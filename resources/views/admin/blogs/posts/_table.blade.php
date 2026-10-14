@if ($blogs->isEmpty())
    <div class="bp-empty">
        <div class="bp-empty-icon"><i class="fa fa-feather-pointed"></i></div>
        @if (collect(request()->only(['search', 'status', 'category', 'country_id', 'state_id', 'city_id', 'date_from', 'date_to']))->filter()->isNotEmpty())
            <h5>No articles match these filters</h5>
            <p>Try a different search term or clear the filters.</p>
            <button type="button" class="btn be-ghost bp-reset-filters">Clear filters</button>
        @else
            <h5>No blog articles yet</h5>
            <p>Your first article is one click away. Write it, preview it, then publish when it's ready.</p>
            <a href="{{ route('admin.blog-posts.create') }}" class="btn btn-primary"><i class="fa fa-plus me-1"></i> Write your first article</a>
        @endif
    </div>
@else
    <div class="bp-grid">
        @foreach ($blogs as $blog)
            @php
                $status = $blog->effective_status;
                $seo = $blog->seoChecklist();
                $seoLevel = $seo['score'] >= 80 ? 'good' : ($seo['score'] >= 50 ? 'ok' : 'poor');
                $authorName = optional($blog->author)->name ?? 'Unknown';
                $summary = $blog->excerpt ?: \Illuminate\Support\Str::limit($blog->plain_text, 140);
                $location = collect([optional($blog->city)->name, optional($blog->state)->name, optional($blog->country)->name])->filter()->first();
            @endphp
            <article class="bp-card" id="blog-row-{{ $blog->id }}">
                <a href="{{ route('admin.blog-posts.edit', $blog->id) }}" class="bp-card-media" tabindex="-1" aria-hidden="true">
                    @if ($blog->featured_image)
                        <img src="{{ $blog->featured_image_url }}" alt="" loading="lazy">
                    @else
                        <span class="bp-card-placeholder" style="--hue: {{ ($blog->id * 47) % 360 }}">
                            {{ mb_strtoupper(mb_substr($blog->title, 0, 1)) }}
                        </span>
                    @endif
                    <span class="bp-badge bp-badge-{{ $status }} bp-card-status">
                        <i class="fa {{ ['draft' => 'fa-pen', 'published' => 'fa-circle-check', 'scheduled' => 'fa-clock', 'archived' => 'fa-box-archive'][$status] }}"></i>
                        {{ \App\Models\Blog::STATUSES[$status] }}
                    </span>
                    @if ($blog->shows_featured_video)
                        <span class="bp-card-video" title="Featured video"><i class="fa fa-play"></i></span>
                    @endif
                </a>

                <div class="bp-card-body">
                    <div class="bp-card-cats">
                        @forelse ($blog->categories->take(3) as $category)
                            <span class="bp-chip">{{ $category->name }}</span>
                        @empty
                            <span class="bp-chip bp-chip-muted">Uncategorized</span>
                        @endforelse
                        @if ($blog->categories->count() > 3)
                            <span class="bp-chip bp-chip-muted">+{{ $blog->categories->count() - 3 }}</span>
                        @endif
                    </div>

                    <h3 class="bp-card-title">
                        <a href="{{ route('admin.blog-posts.edit', $blog->id) }}">{{ $blog->title }}</a>
                    </h3>
                    <p class="bp-card-excerpt">{{ $summary ?: 'No content yet.' }}</p>

                    <div class="bp-card-meta">
                        <span class="bp-avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr($authorName, 0, 1)) }}</span>
                        <span class="bp-card-author">{{ $authorName }}</span>
                        <span class="bp-dot">•</span>
                        @if ($blog->published_at)
                            <span title="{{ $blog->published_at->format('d M Y, h:i A') }}">
                                {{ $status === 'scheduled' ? 'Goes live ' . $blog->published_at->format('d M, h:i A') : $blog->published_at->format('d M Y') }}
                            </span>
                        @else
                            <span>Edited {{ $blog->updated_at->diffForHumans() }}</span>
                        @endif
                    </div>
                    <div class="bp-card-meta bp-card-meta-sub">
                        <span><i class="fa fa-clock"></i> {{ $blog->reading_minutes }} min read</span>
                        @if ($location)
                            <span><i class="fa fa-location-dot"></i> {{ $location }}</span>
                        @endif
                    </div>
                </div>

                <div class="bp-card-footer">
                    <div class="bp-seo bp-seo-{{ $seoLevel }}"
                         title="{{ $seo['missing'] ? 'To improve: ' . implode(', ', $seo['missing']) : 'All SEO checks passed' }}">
                        <small>SEO</small>
                        <div class="bp-seo-bar"><span style="width: {{ $seo['score'] }}%"></span></div>
                        <small>{{ $seo['score'] }}%</small>
                    </div>
                    <div class="bp-card-actions">
                        <a href="{{ route('admin.blog-posts.edit', $blog->id) }}" class="btn btn-sm btn-primary" title="Edit" aria-label="Edit {{ $blog->title }}">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <a href="{{ route('admin.blog-posts.preview', $blog->id) }}" target="_blank" rel="noopener" class="btn btn-sm be-ghost" title="Preview" aria-label="Preview {{ $blog->title }}">
                            <i class="fa fa-eye"></i>
                        </a>
                        @if ($status === 'published')
                            <a href="{{ route('blog.show', $blog->slug) }}" target="_blank" rel="noopener" class="btn btn-sm be-ghost be-success" title="View live article" aria-label="View live {{ $blog->title }}">
                                <i class="fa fa-arrow-up-right-from-square"></i>
                            </a>
                        @endif
                        <button type="button" class="btn btn-sm be-ghost bp-duplicate" data-id="{{ $blog->id }}" title="Duplicate" aria-label="Duplicate {{ $blog->title }}">
                            <i class="fa fa-copy"></i>
                        </button>
                        <button type="button" class="btn btn-sm be-ghost be-danger bp-delete" data-id="{{ $blog->id }}" data-title="{{ $blog->title }}" title="Delete" aria-label="Delete {{ $blog->title }}">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>
            </article>
        @endforeach
    </div>
@endif

<div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-2 bp-pagination">
    <div class="text-muted small">
        Showing <strong>{{ $blogs->firstItem() ?? 0 }}</strong> to <strong>{{ $blogs->lastItem() ?? 0 }}</strong> of <strong>{{ $blogs->total() }}</strong> articles
    </div>
    @if ($blogs->hasPages())
        <div>{{ $blogs->withQueryString()->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
