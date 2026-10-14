<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\City;
use App\Models\State;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

/**
 * Runs against the configured database inside a transaction that is rolled back after each test.
 */
class BlogPostManagementTest extends TestCase
{
    use DatabaseTransactions;

    private Admin $admin;
    private array $uploadedFiles = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Admin::create([
            'name' => 'Blog Test Admin',
            'email' => 'blog-test-' . uniqid() . '@example.com',
            'password' => bcrypt('secret'),
        ]);
    }

    protected function tearDown(): void
    {
        foreach ($this->uploadedFiles as $path) {
            File::delete(public_path($path));
        }

        parent::tearDown();
    }

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'title' => 'Ultimate Nightlife Guide ' . uniqid(),
            'slug' => '',
            'slug_auto' => 1,
            'excerpt' => 'A short summary.',
            'content' => '<h2>Intro</h2><p>Hello <strong>world</strong>.</p>',
            'status' => 'draft',
            'published_at' => '',
            'featured_media_type' => 'image',
            'robots_index' => 'index',
            'robots_follow' => 'follow',
        ], $overrides);
    }

    private function asAdmin()
    {
        return $this->actingAs($this->admin, 'admin');
    }

    private function storeBlog(array $overrides = []): Blog
    {
        $response = $this->asAdmin()->postJson(route('admin.blog-posts.store'), $this->payload($overrides));
        $response->assertOk()->assertJsonPath('status', 1);

        return Blog::findOrFail($response->json('data.id'));
    }

    public function test_guests_cannot_reach_blog_management(): void
    {
        $this->get(route('admin.blog-posts.index'))->assertRedirect(route('admin.login'));
        $this->post(route('admin.blog-posts.store'), $this->payload())->assertRedirect(route('admin.login'));
        $this->post(route('admin.blog-posts.media.upload'))->assertRedirect(route('admin.login'));
    }

    public function test_listing_editor_and_ajax_table_render(): void
    {
        $blog = $this->storeBlog(['title' => 'Listing Visible Article']);

        $this->asAdmin()->get(route('admin.blog-posts.index'))->assertOk()->assertSee('Blog Management')->assertSee('Listing Visible Article');
        $this->asAdmin()->get(route('admin.blog-posts.create'))->assertOk()->assertSee('Enter your blog title...');
        $this->asAdmin()->get(route('admin.blog-posts.edit', $blog->id))->assertOk()->assertSee('Listing Visible Article');

        $this->asAdmin()
            ->getJson(route('admin.blog-posts.index', ['search' => 'Listing Visible', 'status' => 'draft']), ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk()
            ->assertJsonPath('status', 1)
            ->assertJsonStructure(['html', 'counts' => ['all', 'draft', 'published', 'scheduled', 'archived']]);

        $html = $this->asAdmin()
            ->getJson(route('admin.blog-posts.index', ['search' => 'Listing Visible', 'status' => 'published']), ['X-Requested-With' => 'XMLHttpRequest'])
            ->json('html');
        $this->assertStringNotContainsString('Listing Visible Article', $html);
    }

    public function test_draft_is_saved_with_categories_and_unique_auto_slug(): void
    {
        $categories = collect(['Travel', 'Nightlife'])->map(fn ($name) => BlogCategory::create([
            'name' => $name . uniqid(), 'slug' => 'test-cat-' . uniqid(), 'status' => 1, 'robots_index' => 'index', 'robots_follow' => 'follow',
        ]));

        $first = $this->storeBlog(['title' => 'Same Title Story', 'categories' => $categories->pluck('id')->all()]);
        $second = $this->storeBlog(['title' => 'Same Title Story']);

        $this->assertSame('same-title-story', $first->slug);
        $this->assertSame('same-title-story-2', $second->slug);
        $this->assertSame(Blog::STATUS_DRAFT, $first->status);
        $this->assertSame($this->admin->id, $first->author_id);
        $this->assertEqualsCanonicalizing($categories->pluck('id')->all(), $first->categories()->pluck('blog_categories.id')->all());
    }

    public function test_manual_slug_must_be_unique(): void
    {
        $this->storeBlog(['slug' => 'taken-slug', 'slug_auto' => 0]);

        $this->asAdmin()->postJson(route('admin.blog-posts.store'), $this->payload(['slug' => 'taken-slug', 'slug_auto' => 0]))
            ->assertStatus(422)
            ->assertJsonValidationErrors('slug');
    }

    public function test_content_is_sanitized_but_formatting_and_links_are_kept(): void
    {
        $blog = $this->storeBlog(['content' =>
            '<p onclick="steal()">Text<script>alert(1)</script></p>'
            . '<a href="javascript:alert(1)">bad</a>'
            . '<a href="https://example.com/page" target="_blank">good</a>'
            . '<iframe src="https://evil.example/x"></iframe>'
            . '<iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ"></iframe>'
            . '<figure class="image"><img src="/uploads/blogs/images/a.jpg" alt="Alt" onerror="x()"><figcaption>Caption</figcaption></figure>'
            . '<table><tr><td>cell</td></tr></table><h3 style="text-align: center">Sub</h3>'
        ]);

        $html = $blog->content;
        $this->assertStringNotContainsString('<script', $html);
        $this->assertStringNotContainsString('onclick', $html);
        $this->assertStringNotContainsString('onerror', $html);
        $this->assertStringNotContainsString('javascript:', $html);
        $this->assertStringNotContainsString('evil.example', $html);
        $this->assertStringContainsString('<a href="https://example.com/page" target="_blank" rel="noopener noreferrer">good</a>', $html);
        $this->assertStringContainsString('https://www.youtube.com/embed/dQw4w9WgXcQ', $html);
        $this->assertStringContainsString('<figcaption>Caption</figcaption>', $html);
        $this->assertStringContainsString('<td>cell</td>', $html);
        $this->assertStringContainsString('style="text-align: center"', $html);
    }

    public function test_publishing_rules_and_public_visibility(): void
    {
        $draft = $this->storeBlog();
        $this->get(route('blog.show', $draft->slug))->assertNotFound();

        $published = $this->storeBlog(['status' => 'published', 'meta_title' => 'Custom SEO Title', 'meta_description' => 'Custom SEO description.', 'robots_follow' => 'nofollow']);
        $this->assertSame(Blog::STATUS_PUBLISHED, $published->status);
        $this->assertNotNull($published->published_at);

        $this->get(route('blog.show', $published->slug))
            ->assertOk()
            ->assertSee('<title>Custom SEO Title</title>', false)
            ->assertSee('<meta name="description" content="Custom SEO description.">', false)
            ->assertSee('<meta name="robots" content="index, nofollow">', false)
            ->assertSee('<link rel="canonical" href="' . route('blog.show', $published->slug) . '">', false)
            ->assertSee('<h2>Intro</h2>', false);

        // "Publish" with a future date becomes scheduled and stays hidden.
        $scheduled = $this->storeBlog(['status' => 'published', 'published_at' => now()->addDay()->format('Y-m-d\TH:i')]);
        $this->assertSame(Blog::STATUS_SCHEDULED, $scheduled->status);
        $this->get(route('blog.show', $scheduled->slug))->assertNotFound();

        // Once the scheduled time has passed the article is live without any cron job.
        $scheduled->forceFill(['published_at' => now()->subMinute()])->save();
        $this->get(route('blog.show', $scheduled->slug))->assertOk();
        $this->assertSame(Blog::STATUS_PUBLISHED, $scheduled->fresh()->effective_status);

        $archived = $this->storeBlog(['status' => 'archived', 'published_at' => now()->subDay()->format('Y-m-d\TH:i')]);
        $this->get(route('blog.show', $archived->slug))->assertNotFound();
    }

    public function test_publish_and_schedule_validation(): void
    {
        $this->asAdmin()->postJson(route('admin.blog-posts.store'), $this->payload(['status' => 'published', 'content' => '']))
            ->assertStatus(422)->assertJsonValidationErrors('content');

        $this->asAdmin()->postJson(route('admin.blog-posts.store'), $this->payload(['status' => 'scheduled', 'published_at' => now()->subHour()->format('Y-m-d\TH:i')]))
            ->assertStatus(422)->assertJsonValidationErrors('published_at');

        $this->asAdmin()->postJson(route('admin.blog-posts.store'), $this->payload([
            'canonical_url' => 'javascript:alert(1)',
            'featured_video_url' => 'https://evil.example/video',
            'featured_image' => 'uploads/blogs/images/../../../.env',
            'title' => '',
        ]))->assertStatus(422)->assertJsonValidationErrors(['canonical_url', 'featured_video_url', 'featured_image', 'title']);
    }

    public function test_location_must_be_consistent(): void
    {
        $city = City::query()->whereNotNull('state_id')->first();
        $this->assertNotNull($city, 'Location master data is required for this test.');

        $blog = $this->storeBlog(['country_id' => $city->country_id, 'state_id' => $city->state_id, 'city_id' => $city->id]);
        $this->assertSame($city->id, (int) $blog->city_id);

        $otherCity = City::query()->where('state_id', '!=', $city->state_id)->first();
        $this->asAdmin()->postJson(route('admin.blog-posts.store'), $this->payload(['country_id' => $city->country_id, 'state_id' => $city->state_id, 'city_id' => $otherCity->id]))
            ->assertStatus(422)->assertJsonValidationErrors('city_id');
    }

    public function test_update_duplicate_and_delete(): void
    {
        $blog = $this->storeBlog(['status' => 'published']);

        $this->asAdmin()->putJson(route('admin.blog-posts.update', $blog->id), $this->payload([
            'title' => 'Updated Title', 'slug' => $blog->slug, 'slug_auto' => 0, 'status' => 'published',
            'published_at' => $blog->published_at->format('Y-m-d\TH:i'),
        ]))->assertOk()->assertJsonPath('data.slug', $blog->slug);
        $this->assertSame('Updated Title', $blog->fresh()->title);

        $duplicate = $this->asAdmin()->postJson(route('admin.blog-posts.duplicate', $blog->id))->assertOk();
        $copy = Blog::latest('id')->first();
        $this->assertSame(Blog::STATUS_DRAFT, $copy->status);
        $this->assertSame($blog->slug . '-copy', $copy->slug);
        $this->assertNull($copy->published_at);
        $this->assertSame(route('admin.blog-posts.edit', $copy->id), $duplicate->json('edit_url'));

        $this->asAdmin()->deleteJson(route('admin.blog-posts.destroy', $blog->id))->assertOk();
        $this->assertNull(Blog::find($blog->id));
    }

    public function test_published_article_outputs_structured_data(): void
    {
        $category = BlogCategory::create(['name' => 'Guides ' . uniqid(), 'slug' => 'guides-' . uniqid(), 'status' => 1, 'robots_index' => 'index', 'robots_follow' => 'follow']);
        $published = $this->storeBlog(['status' => 'published', 'title' => 'Schema </script> Test', 'categories' => [$category->id]]);

        $html = $this->get(route('blog.show', $published->slug))
            ->assertOk()
            ->assertSee('<meta property="article:published_time" content="' . $published->published_at->toAtomString() . '" />', false)
            ->assertDontSee('Schema </script> Test","', false)
            ->getContent();

        preg_match_all('#<script type="application/ld\+json">(.*?)</script>#s', $html, $matches);
        $schemas = collect($matches[1])->map(fn ($json) => json_decode($json, true))->keyBy('@type');

        $this->assertSame('Schema </script> Test', $schemas['BlogPosting']['headline']);
        $this->assertSame(route('blog.show', $published->slug), $schemas['BlogPosting']['mainEntityOfPage']['@id']);
        $this->assertSame($category->name, $schemas['BlogPosting']['articleSection']);
        $this->assertSame(route('blog.show', $published->slug), $schemas['BreadcrumbList']['itemListElement'][2]['item']);

        // Previews never carry structured data.
        $this->asAdmin()->get(route('admin.blog-posts.preview', $published->id))->assertDontSee('application/ld+json', false);
    }

    public function test_public_listing_shows_live_articles_with_filters_and_pagination(): void
    {
        Blog::query()->update(['status' => Blog::STATUS_ARCHIVED]);
        $category = BlogCategory::create(['name' => 'Listing Guides', 'slug' => 'listing-guides-' . uniqid(), 'status' => 1, 'robots_index' => 'index', 'robots_follow' => 'follow']);
        $city = City::whereNotNull('state_id')->firstOrFail();
        $countryId = State::findOrFail($city->state_id)->country_id;

        $guide = $this->storeBlog(['status' => 'published', 'title' => 'Verified Profile Guide', 'categories' => [$category->id]]);
        $local = $this->storeBlog(['status' => 'published', 'title' => 'Local Nightlife Guide', 'country_id' => $countryId, 'state_id' => $city->state_id, 'city_id' => $city->id]);
        $draft = $this->storeBlog(['title' => 'Hidden Draft Guide']);

        $this->get(route('blogs'))
            ->assertOk()
            ->assertSee('<meta name="robots" content="index, follow">', false)
            ->assertSee(route('blog.show', $guide->slug), false)
            ->assertSee(route('blog.show', $local->slug), false)
            ->assertDontSee($draft->title)
            ->assertSee('2 Articles')
            ->assertSee(route('blogs', ['category' => $category->slug]), false);

        // Every filter narrows the result grid (the sidebar still lists recent posts) and keeps filtered views out of the index.
        $readMore = fn (Blog $blog) => 'aria-label="Read more: ' . $blog->title . '"';
        $this->get(route('blogs', ['category' => $category->slug]))
            ->assertOk()
            ->assertSee('<meta name="robots" content="noindex, follow">', false)
            ->assertSee('1 Article Found')
            ->assertSee($readMore($guide), false)
            ->assertDontSee($readMore($local), false);
        $this->get(route('blogs', ['country' => $countryId, 'state' => $city->state_id, 'city' => $city->id]))
            ->assertSee($readMore($local), false)
            ->assertDontSee($readMore($guide), false);
        $this->get(route('blogs', ['q' => 'verified']))->assertSee($readMore($guide), false)->assertDontSee($readMore($local), false);
        $this->get(route('blogs', ['q' => '%']))->assertSee('No Matching Blog Articles Found');
        $this->get(route('blogs', ['category' => 'no-such-category']))->assertSee('No Matching Blog Articles Found');

        // A state without its country is ignored instead of producing an impossible filter.
        $this->get(route('blogs', ['state' => $city->state_id]))->assertSee($readMore($guide), false)->assertSee($readMore($local), false);

        foreach (range(1, 12) as $i) {
            $this->storeBlog(['status' => 'published', 'published_at' => now()->subDays($i)->format('Y-m-d\TH:i')]);
        }
        $this->get(route('blogs'))->assertSee('Page 1 of 2')->assertSee(route('blogs', ['page' => 2]), false);
        $this->get(route('blogs', ['page' => 2]))
            ->assertOk()
            ->assertSee('<meta name="robots" content="noindex, follow">', false)
            ->assertSee('Page 2 of 2');
    }

    public function test_sitemap_lists_indexable_live_articles(): void
    {
        $live = $this->storeBlog(['status' => 'published']);
        $noindex = $this->storeBlog(['status' => 'published', 'robots_index' => 'noindex']);
        $elsewhere = $this->storeBlog(['status' => 'published', 'canonical_url' => 'https://example.com/original-article']);
        $draft = $this->storeBlog();

        $this->get(route('sitemap'))
            ->assertOk()
            ->assertSee('<loc>' . route('blogs') . '</loc>', false)
            ->assertSee('<loc>' . route('blog.show', $live->slug) . '</loc>', false)
            ->assertDontSee(route('blog.show', $noindex->slug), false)
            ->assertDontSee(route('blog.show', $elsewhere->slug), false)
            ->assertDontSee(route('blog.show', $draft->slug), false);
    }

    public function test_previews_are_admin_only_and_noindex(): void
    {
        // Created directly so the guest request below is really unauthenticated.
        $draft = Blog::create([
            'title' => 'Secret Draft Article', 'slug' => 'secret-draft-' . uniqid(), 'content' => '<p>Draft</p>',
            'status' => 'draft', 'featured_media_type' => 'image', 'robots_index' => 'index', 'robots_follow' => 'follow',
        ]);

        $this->get(route('admin.blog-posts.preview', $draft->id))->assertRedirect(route('admin.login'));
        $this->get(route('blog.show', $draft->slug))->assertNotFound();

        $this->asAdmin()->get(route('admin.blog-posts.preview', $draft->id))
            ->assertOk()
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow')
            ->assertSee('<meta name="robots" content="noindex, nofollow">', false)
            ->assertSee('Secret Draft Article');

        // Unsaved preview renders the submitted (sanitized) content without saving it.
        $this->asAdmin()->post(route('admin.blog-posts.preview-draft'), $this->payload([
            'id' => $draft->id, 'slug' => $draft->slug, 'slug_auto' => 0, 'title' => 'Unsaved Title Change',
            'content' => '<p>Unsaved body</p><script>alert(1)</script>',
        ]), ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk()
            ->assertSee('Unsaved Title Change')
            ->assertSee('Unsaved body')
            ->assertDontSee('<script>alert(1)</script>', false);

        $this->assertSame('Secret Draft Article', $draft->fresh()->title);
    }

    public function test_media_upload_validation_and_library(): void
    {
        $response = $this->asAdmin()->post(route('admin.blog-posts.media.upload'), [
            'type' => 'image',
            'file' => UploadedFile::fake()->image('cover.png', 800, 450),
        ], ['Accept' => 'application/json'])->assertOk();

        $path = $response->json('path');
        $this->uploadedFiles[] = $path;
        $this->assertMatchesRegularExpression('#^uploads/blogs/images/\d{8}_[A-Za-z0-9]{24}\.png$#', $path);
        $this->assertFileExists(public_path($path));
        $this->assertSame(asset($path), $response->json('location'));

        $blog = $this->storeBlog(['featured_image' => $path, 'featured_image_alt' => 'Cover']);
        $this->assertSame($path, $blog->featured_image);

        $library = $this->asAdmin()->getJson(route('admin.blog-posts.media'))->assertOk()->json('items');
        $this->assertContains($path, array_column($library, 'path'));

        $this->asAdmin()->post(route('admin.blog-posts.media.upload'), [
            'type' => 'image',
            'file' => UploadedFile::fake()->create('shell.php', 10, 'application/x-php'),
        ], ['Accept' => 'application/json'])->assertStatus(422)->assertJsonValidationErrors('file');

        $this->asAdmin()->post(route('admin.blog-posts.media.upload'), [
            'type' => 'video',
            'file' => UploadedFile::fake()->image('not-a-video.png'),
        ], ['Accept' => 'application/json'])->assertStatus(422)->assertJsonValidationErrors('file');
    }

    public function test_video_embed_urls(): void
    {
        $this->assertSame('https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ', Blog::videoEmbedUrl('https://www.youtube.com/watch?v=dQw4w9WgXcQ&t=10'));
        $this->assertSame('https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ', Blog::videoEmbedUrl('https://youtu.be/dQw4w9WgXcQ'));
        $this->assertSame('https://player.vimeo.com/video/76979871', Blog::videoEmbedUrl('https://vimeo.com/76979871'));
        $this->assertSame('https://www.dailymotion.com/embed/video/x8abcd1', Blog::videoEmbedUrl('https://www.dailymotion.com/video/x8abcd1'));
        $this->assertNull(Blog::videoEmbedUrl('https://evil.example/watch?v=dQw4w9WgXcQ'));
        $this->assertNull(Blog::videoEmbedUrl('javascript:alert(1)'));
    }
}
