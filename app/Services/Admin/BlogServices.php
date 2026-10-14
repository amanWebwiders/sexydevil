<?php

namespace App\Services\Admin;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Repository\BlogRepositoryInterface;
use App\Services\HtmlSanitizer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BlogServices
{
    /** Upload folders below public/, keyed by media type. */
    const MEDIA_FOLDERS = [
        'image' => 'uploads/blogs/images',
        'video' => 'uploads/blogs/videos',
    ];

    protected $blogRepository;
    protected $sanitizer;

    public function __construct(BlogRepositoryInterface $blogRepository, HtmlSanitizer $sanitizer)
    {
        $this->blogRepository = $blogRepository;
        $this->sanitizer = $sanitizer;
    }

    public function list(array $filters): LengthAwarePaginator
    {
        return $this->blogRepository->paginate($filters);
    }

    public function statusCounts(): array
    {
        return $this->blogRepository->statusCounts();
    }

    public function find(int $id): ?Blog
    {
        return $this->blogRepository->findById($id);
    }

    public function create(array $data, int $adminId): Blog
    {
        return DB::transaction(function () use ($data, $adminId) {
            $blog = $this->blogRepository->create($this->payload($data, null, $adminId));
            $blog->categories()->sync($data['categories'] ?? []);

            return $blog->load('categories:id,name');
        });
    }

    public function update(Blog $blog, array $data, int $adminId): Blog
    {
        return DB::transaction(function () use ($blog, $data, $adminId) {
            $this->blogRepository->update($blog, $this->payload($data, $blog, $adminId));
            $blog->categories()->sync($data['categories'] ?? []);

            return $blog->load('categories:id,name');
        });
    }

    /**
     * Copy an article as a new draft (media files are shared, not copied).
     */
    public function duplicate(Blog $blog, int $adminId): Blog
    {
        return DB::transaction(function () use ($blog, $adminId) {
            $copy = $blog->replicate(['slug', 'status', 'published_at', 'author_id']);
            $copy->title = Str::limit($blog->title . ' (Copy)', 255, '');
            $copy->slug = $this->uniqueSlug($blog->slug . '-copy');
            $copy->status = Blog::STATUS_DRAFT;
            $copy->published_at = null;
            $copy->author_id = $adminId;
            $copy->save();

            $copy->categories()->sync($blog->categories()->pluck('blog_categories.id'));

            return $copy;
        });
    }

    /**
     * Uploaded media files are kept, like a media library, because other articles or
     * article bodies may reference them.
     */
    public function delete(Blog $blog): bool
    {
        return $this->blogRepository->delete($blog);
    }

    /**
     * Build an unsaved article from editor input so unsaved changes can be previewed.
     */
    public function previewModel(array $data, ?Blog $blog, int $adminId): Blog
    {
        $preview = new Blog($this->payload($data, $blog, $adminId));
        $preview->setRelation('categories', BlogCategory::whereIn('id', $data['categories'] ?? [])->get());
        $preview->load(['author', 'country', 'state', 'city']);

        return $preview;
    }

    /**
     * Store an uploaded image / video under public/uploads/blogs with a random name.
     *
     * @return array{path:string, url:string}
     */
    public function uploadMedia(UploadedFile $file, string $type): array
    {
        $folder = self::MEDIA_FOLDERS[$type];
        File::ensureDirectoryExists(public_path($folder));

        // Extension comes from the detected MIME type, never from the client file name.
        $filename = now()->format('Ymd') . '_' . Str::random(24) . '.' . $file->guessExtension();
        $file->move(public_path($folder), $filename);

        $path = $folder . '/' . $filename;

        return ['path' => $path, 'url' => asset($path)];
    }

    /**
     * Previously uploaded blog images, newest first.
     */
    public function mediaLibrary(int $page = 1, int $perPage = 24): array
    {
        $folder = self::MEDIA_FOLDERS['image'];
        $files = File::isDirectory(public_path($folder)) ? File::files(public_path($folder)) : [];

        usort($files, fn ($a, $b) => $b->getMTime() <=> $a->getMTime());

        $items = array_map(fn ($file) => [
            'path' => $folder . '/' . $file->getFilename(),
            'url' => asset($folder . '/' . $file->getFilename()),
            'name' => $file->getFilename(),
        ], array_slice($files, ($page - 1) * $perPage, $perPage));

        return [
            'items' => $items,
            'has_more' => count($files) > $page * $perPage,
        ];
    }

    public function uniqueSlug(string $slug, ?int $ignoreId = null): string
    {
        $base = Str::limit(Str::slug($slug) ?: 'article', 240, '');
        $candidate = $base;
        $suffix = 2;

        while ($this->blogRepository->slugExists($candidate, $ignoreId)) {
            $candidate = $base . '-' . $suffix++;
        }

        return $candidate;
    }

    /**
     * Map validated editor input to table columns and resolve the publishing state.
     */
    private function payload(array $data, ?Blog $blog, int $adminId): array
    {
        $status = $data['status'];
        $publishedAt = !empty($data['published_at']) ? Carbon::parse($data['published_at']) : null;

        if ($status === Blog::STATUS_PUBLISHED) {
            $publishedAt = $publishedAt ?: ($blog && $blog->published_at ? $blog->published_at : now());
            // A future date turns "publish" into "schedule".
            if ($publishedAt->isFuture()) {
                $status = Blog::STATUS_SCHEDULED;
            }
        }

        $slug = !empty($data['slug_auto'])
            ? $this->uniqueSlug($data['slug'], $blog ? $blog->id : null)
            : $data['slug'];

        return [
            'title' => $data['title'],
            'slug' => $slug,
            'excerpt' => isset($data['excerpt']) ? trim(strip_tags($data['excerpt'])) ?: null : null,
            'content' => $this->sanitizer->clean($data['content'] ?? ''),
            'featured_media_type' => $data['featured_media_type'],
            'featured_image' => $data['featured_image'] ?? null,
            'featured_image_alt' => $data['featured_image_alt'] ?? null,
            'featured_video' => $data['featured_video'] ?? null,
            'featured_video_url' => $data['featured_video_url'] ?? null,
            'author_id' => $data['author_id'] ?? ($blog ? $blog->author_id : null) ?? $adminId,
            'status' => $status,
            'published_at' => $publishedAt,
            'country_id' => $data['country_id'] ?? null,
            'state_id' => !empty($data['country_id']) ? ($data['state_id'] ?? null) : null,
            'city_id' => !empty($data['state_id']) && !empty($data['country_id']) ? ($data['city_id'] ?? null) : null,
            'meta_title' => $data['meta_title'] ?? null,
            'meta_description' => $data['meta_description'] ?? null,
            'meta_keywords' => $data['meta_keywords'] ?? null,
            'canonical_url' => $data['canonical_url'] ?? null,
            'robots_index' => $data['robots_index'],
            'robots_follow' => $data['robots_follow'],
        ];
    }
}
