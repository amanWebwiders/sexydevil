@extends('admin.layout.layout')
@section('content')

@php
    $isNew = !$blog->exists;
    $selectedCategoryIds = $isNew ? [] : $blog->categories->pluck('id')->all();
    $initial = [
        'id' => $blog->id,
        'status' => $blog->status,
        'effective_status' => $blog->effective_status,
        'updated_at' => optional($blog->updated_at)->toIso8601String(),
        'public_url' => $blog->exists ? route('blog.show', $blog->slug) : null,
        'country_id' => $blog->country_id,
        'state_id' => $blog->state_id,
        'city_id' => $blog->city_id,
        'featured_image_url' => $blog->featured_image_url,
        'featured_video_file_url' => $blog->featured_video_file_url,
    ];
@endphp

<style>
    :root { --be-accent: #bc1212; --be-border: #e5e7eb; --be-muted: #6b7280; --be-ink: #111827; --be-soft: #f9fafb; }
    #content.be-page { padding-top: 0; }
    .btn.be-ghost { background: #fff !important; border: 1px solid #d1d5db !important; color: #374151 !important; }
    .btn.be-ghost:hover, .btn.be-ghost:focus-visible { background: #fef2f2 !important; border-color: #bc1212 !important; color: #bc1212 !important; }
    .btn.be-ghost.be-danger { color: #dc2626 !important; }
    .btn.be-ghost.be-success { color: #16a34a !important; }
    .be-check { width: 16px; height: 16px; accent-color: var(--be-accent); flex-shrink: 0; margin: 0; }

    /* Toolbar */
    .be-toolbar {
        position: sticky; top: 5.5rem; z-index: 1010; background: #fff; border-bottom: 1px solid var(--be-border);
        margin: 0 -1rem 1.5rem; padding: 10px 1rem; display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
        box-shadow: 0 4px 12px rgba(17, 24, 39, .04);
    }
    .be-toolbar .be-back { color: var(--be-ink); text-decoration: none; font-weight: 600; font-size: 14px; display: inline-flex; align-items: center; gap: 6px; }
    .be-toolbar .be-back:hover { color: var(--be-accent); }
    .be-toolbar-sep { width: 1px; height: 24px; background: var(--be-border); }
    .be-toolbar-spacer { flex: 1; }
    .be-save-state { font-size: 13px; color: var(--be-muted); display: inline-flex; align-items: center; gap: 6px; white-space: nowrap; }
    .be-save-state.is-saving { color: #2563eb; }
    .be-save-state.is-saved { color: #16a34a; }
    .be-save-state.is-dirty { color: #b45309; }
    .be-save-state.is-error { color: #dc2626; font-weight: 600; }
    .be-status-pill { font-size: 12px; font-weight: 700; border-radius: 999px; padding: 3px 10px; text-transform: uppercase; letter-spacing: .03em; }
    .be-status-draft { background: #f3f4f6; color: #374151; }
    .be-status-published { background: #dcfce7; color: #166534; }
    .be-status-scheduled { background: #e0f2fe; color: #075985; }
    .be-status-archived { background: #fef3c7; color: #92400e; }
    .be-toolbar .btn { white-space: nowrap; }
    .be-more-menu { min-width: 210px; }
    .be-more-menu .dropdown-item { font-size: 14px; padding: 8px 14px; }
    .be-more-menu .dropdown-item i { width: 18px; color: var(--be-muted); }

    /* Workspace */
    .be-workspace { display: grid; grid-template-columns: minmax(0, 1fr) 340px; gap: 24px; align-items: start; }
    .be-canvas { background: #fff; border: 1px solid var(--be-border); border-radius: 14px; padding: 40px 48px 28px; min-width: 0; }
    .be-canvas-inner { max-width: 820px; margin: 0 auto; }
    .be-title {
        display: block; width: 100%; border: 0; outline: 0; resize: none; overflow: hidden; background: transparent;
        font-size: 34px; line-height: 1.25; font-weight: 800; color: var(--be-ink); padding: 0; margin-bottom: 10px;
    }
    .be-title::placeholder { color: #c4c8cf; }
    .be-permalink { display: flex; align-items: center; flex-wrap: wrap; gap: 4px; font-size: 13px; color: var(--be-muted); margin-bottom: 22px; }
    .be-permalink-base { word-break: break-all; }
    .be-permalink input { border: 1px dashed transparent; background: var(--be-soft); border-radius: 6px; padding: 2px 8px; font-family: monospace; font-size: 13px; color: var(--be-ink); min-width: 120px; flex: 1; max-width: 420px; }
    .be-permalink input:hover, .be-permalink input:focus { border-color: #cbd5e1; outline: none; background: #fff; }
    .be-link-btn { background: none; border: 0; color: var(--be-accent); font-size: 12px; font-weight: 600; padding: 0 4px; cursor: pointer; }
    .be-link-btn:hover { text-decoration: underline; }
    .be-editor-wrap .tox-tinymce { border-radius: 10px; border-color: var(--be-border); }
    .be-editor-placeholder { min-height: 560px; border: 1px solid var(--be-border); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--be-muted); }

    /* Sidebar panels */
    .be-sidebar { position: sticky; top: calc(5.5rem + 76px); max-height: calc(100vh - 5.5rem - 96px); overflow-y: auto; padding-right: 2px; }
    .be-panel { background: #fff; border: 1px solid var(--be-border); border-radius: 12px; margin-bottom: 12px; }
    .be-panel > summary {
        list-style: none; cursor: pointer; padding: 14px 16px; font-weight: 700; font-size: 14px; color: var(--be-ink);
        display: flex; align-items: center; gap: 10px; user-select: none; border-radius: 12px;
    }
    .be-panel > summary::-webkit-details-marker { display: none; }
    .be-panel > summary:focus-visible { outline: 2px solid var(--be-accent); outline-offset: 2px; }
    .be-panel > summary .be-panel-icon { width: 28px; height: 28px; border-radius: 8px; background: #fef2f2; color: var(--be-accent); display: inline-flex; align-items: center; justify-content: center; font-size: 13px; }
    .be-panel > summary .be-panel-hint { margin-left: auto; font-weight: 500; font-size: 12px; color: var(--be-muted); }
    .be-panel > summary::after { content: '\f107'; font-family: 'Font Awesome 6 Free', 'Font Awesome 5 Free', FontAwesome; font-weight: 900; color: var(--be-muted); transition: transform .15s ease; }
    .be-panel[open] > summary::after { transform: rotate(180deg); }
    .be-panel[open] > summary .be-panel-hint + * { margin-left: 0; }
    .be-panel-body { padding: 4px 16px 16px; }
    .be-panel.has-error > summary { color: #dc2626; }
    .be-field { margin-bottom: 14px; }
    .be-field:last-child { margin-bottom: 0; }
    .be-field label, .be-label { display: block; font-size: 12px; font-weight: 700; color: #374151; margin-bottom: 5px; text-transform: uppercase; letter-spacing: .03em; }
    .be-field .form-control, .be-field .form-select { font-size: 14px; }
    .be-help { font-size: 12px; color: var(--be-muted); margin-top: 4px; }
    .be-error { font-size: 12px; color: #dc2626; margin-top: 4px; display: none; }
    .be-field.is-invalid .be-error { display: block; }
    .be-field.is-invalid .form-control, .be-field.is-invalid .form-select { border-color: #dc2626; }
    .be-counter { float: right; font-weight: 600; text-transform: none; letter-spacing: 0; }
    .be-counter.good { color: #16a34a; } .be-counter.warn { color: #d97706; } .be-counter.bad { color: #dc2626; }

    /* Segmented control */
    .be-segment { display: flex; background: #f3f4f6; border-radius: 10px; padding: 3px; gap: 3px; }
    .be-segment label { flex: 1; margin: 0; text-transform: none; letter-spacing: 0; font-size: 13px; }
    .be-segment input { position: absolute; opacity: 0; pointer-events: none; }
    .be-segment span { display: block; text-align: center; padding: 6px 8px; border-radius: 8px; cursor: pointer; color: #4b5563; font-weight: 600; }
    .be-segment input:checked + span { background: #fff; color: var(--be-accent); box-shadow: 0 1px 3px rgba(0,0,0,.1); }
    .be-segment input:focus-visible + span { outline: 2px solid var(--be-accent); }

    /* Categories */
    .be-chips { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 10px; }
    .be-chip { display: inline-flex; align-items: center; gap: 6px; background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; border-radius: 999px; padding: 2px 4px 2px 10px; font-size: 12px; font-weight: 600; }
    .be-chip button { border: 0; background: transparent; color: inherit; width: 18px; height: 18px; border-radius: 50%; line-height: 1; padding: 0; }
    .be-chip button:hover { background: #fecaca; }
    .be-category-list { max-height: 210px; overflow-y: auto; border: 1px solid var(--be-border); border-radius: 8px; padding: 6px 4px; }
    .be-category-list label { display: flex; align-items: center; gap: 8px; padding: 5px 8px; margin: 0; border-radius: 6px; cursor: pointer; font-size: 14px; text-transform: none; letter-spacing: 0; font-weight: 500; color: #1f2937; }
    .be-category-list label:hover { background: var(--be-soft); }
    .be-category-list .be-inactive { font-size: 11px; color: var(--be-muted); }

    /* Media */
    .be-dropzone { border: 2px dashed #d1d5db; border-radius: 10px; padding: 22px 12px; text-align: center; color: var(--be-muted); background: var(--be-soft); transition: all .15s ease; }
    .be-dropzone.is-over { border-color: var(--be-accent); background: #fef2f2; color: var(--be-accent); }
    .be-dropzone i { font-size: 26px; margin-bottom: 8px; display: block; }
    .be-media-preview { position: relative; border-radius: 10px; overflow: hidden; border: 1px solid var(--be-border); background: #000; }
    .be-media-preview img, .be-media-preview video { display: block; width: 100%; max-height: 220px; object-fit: cover; }
    .be-media-preview iframe { display: block; width: 100%; aspect-ratio: 16 / 9; border: 0; }
    .be-media-actions { display: flex; gap: 6px; flex-wrap: wrap; margin-top: 8px; }
    .be-progress { height: 6px; background: #e5e7eb; border-radius: 999px; overflow: hidden; margin-top: 8px; display: none; }
    .be-progress span { display: block; height: 100%; width: 0; background: var(--be-accent); transition: width .1s linear; }

    /* SEO preview */
    .be-serp { border: 1px solid var(--be-border); border-radius: 10px; padding: 12px 14px; background: #fff; font-family: arial, sans-serif; }
    .be-serp-url { font-size: 12px; color: #202124; margin-bottom: 2px; word-break: break-all; }
    .be-serp-title { font-size: 18px; color: #1a0dab; line-height: 1.3; margin-bottom: 3px; word-break: break-word; }
    .be-serp-desc { font-size: 13px; color: #4d5156; line-height: 1.5; word-break: break-word; }

    /* Library modal */
    .be-library-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 10px; }
    .be-library-item { border: 2px solid transparent; border-radius: 8px; overflow: hidden; padding: 0; background: #f3f4f6; aspect-ratio: 4 / 3; }
    .be-library-item img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .be-library-item:hover, .be-library-item:focus { border-color: var(--be-accent); outline: none; }

    /* Cover image (mirrors the featured image) */
    .be-cover { margin: -8px 0 22px; }
    .be-cover-empty { display: flex; gap: 8px; flex-wrap: wrap; opacity: .75; transition: opacity .15s ease; }
    .be-canvas:hover .be-cover-empty, .be-cover-empty:focus-within { opacity: 1; }
    .be-cover-btn { border: 1px dashed #d1d5db; background: #fff; color: var(--be-muted); border-radius: 999px; padding: 5px 14px; font-size: 13px; font-weight: 600; }
    .be-cover-btn:hover, .be-cover-btn:focus-visible { border-color: var(--be-accent); color: var(--be-accent); outline: none; }
    .be-cover-filled { position: relative; border-radius: 14px; overflow: hidden; aspect-ratio: 21 / 9; background: #111; }
    .be-cover-filled img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .be-cover-actions { position: absolute; right: 12px; bottom: 12px; display: flex; gap: 6px; opacity: 0; transition: opacity .15s ease; }
    .be-cover-filled:hover .be-cover-actions, .be-cover-actions:focus-within { opacity: 1; }
    .be-cover-actions button { border: 0; background: rgba(17, 24, 39, .78); color: #fff; border-radius: 8px; padding: 6px 12px; font-size: 12px; font-weight: 600; backdrop-filter: blur(4px); }
    .be-cover-actions button:hover { background: var(--be-accent); }
    .be-cover-video-note { position: absolute; left: 12px; top: 12px; background: rgba(17, 24, 39, .78); color: #fff; font-size: 12px; border-radius: 999px; padding: 4px 10px; }

    .be-title-meta { display: flex; justify-content: flex-end; font-size: 11px; color: #9ca3af; margin-top: -6px; }

    /* Writing stats */
    .be-stats { display: flex; flex-wrap: wrap; gap: 6px 18px; margin-top: 12px; font-size: 12px; color: var(--be-muted); }
    .be-stats strong { color: var(--be-ink); font-weight: 700; }
    .be-stats i { color: #9ca3af; margin-right: 4px; }

    /* Health checklist */
    .be-health-head { display: flex; align-items: center; gap: 14px; margin-bottom: 12px; }
    .be-ring { --p: 0; --c: #dc2626; width: 58px; height: 58px; border-radius: 50%; flex-shrink: 0;
        background: conic-gradient(var(--c) calc(var(--p) * 1%), #f3f4f6 0); display: flex; align-items: center; justify-content: center; }
    .be-ring span { width: 46px; height: 46px; border-radius: 50%; background: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 14px; color: var(--be-ink); }
    .be-health-label { font-weight: 700; color: var(--be-ink); font-size: 14px; }
    .be-health-sub { font-size: 12px; color: var(--be-muted); }
    .be-checks { list-style: none; padding: 0; margin: 0; }
    .be-checks li { display: flex; align-items: flex-start; gap: 8px; padding: 6px 0; font-size: 13px; color: #374151; border-top: 1px dashed #f3f4f6; }
    .be-checks li:first-child { border-top: 0; }
    .be-checks .be-check-icon { width: 18px; flex-shrink: 0; text-align: center; margin-top: 1px; }
    .be-checks .good .be-check-icon { color: #16a34a; }
    .be-checks .warn .be-check-icon { color: #d97706; }
    .be-checks .bad .be-check-icon { color: #dc2626; }
    .be-checks .be-fix { margin-left: auto; flex-shrink: 0; }

    /* Outline */
    .be-outline { list-style: none; padding: 0; margin: 0; }
    .be-outline li button { display: block; width: 100%; text-align: left; border: 0; background: none; padding: 5px 8px; border-radius: 6px; font-size: 13px; color: #374151; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .be-outline li button:hover, .be-outline li button:focus-visible { background: #fef2f2; color: var(--be-accent); outline: none; }
    .be-outline .lvl-2 button { font-weight: 700; }
    .be-outline .lvl-3 button { padding-left: 22px; }
    .be-outline .lvl-4 button { padding-left: 36px; font-size: 12px; color: var(--be-muted); }
    .be-outline .skip button::after { content: ' ⚠'; color: #d97706; }

    /* Social card preview */
    .be-social { border: 1px solid var(--be-border); border-radius: 10px; overflow: hidden; background: #f0f2f5; }
    .be-social-img { aspect-ratio: 1.91 / 1; background: #e5e7eb center / cover no-repeat; display: flex; align-items: center; justify-content: center; color: #9ca3af; font-size: 12px; }
    .be-social-body { padding: 8px 12px 10px; }
    .be-social-domain { font-size: 11px; text-transform: uppercase; color: #65676b; }
    .be-social-title { font-size: 14px; font-weight: 700; color: #050505; line-height: 1.3; margin: 2px 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .be-social-desc { font-size: 12px; color: #65676b; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }

    /* Focus mode: hide admin chrome and settings, keep the writing canvas */
    body.be-focus .app-sidebar, body.be-focus .app-header, body.be-focus .app-sidebar-bg, body.be-focus .be-sidebar { display: none !important; }
    body.be-focus .app-content { margin-left: 0 !important; }
    body.be-focus .app { padding-top: 0 !important; }
    body.be-focus .be-toolbar { top: 0; }
    body.be-focus .be-workspace { grid-template-columns: 1fr; }
    body.be-focus .be-canvas { border-color: transparent; box-shadow: none; }
    body.be-focus #beFocusToggle { background: var(--be-accent) !important; color: #fff !important; border-color: var(--be-accent) !important; }

    .be-mobile-only { display: none; }

    @media (max-width: 1199.98px) {
        .be-workspace { grid-template-columns: minmax(0, 1fr) 300px; }
        .be-canvas { padding: 32px 28px 24px; }
    }
    @media (max-width: 991.98px) {
        .be-workspace { grid-template-columns: 1fr; }
        .be-sidebar { position: static; max-height: none; overflow: visible; }
        .be-mobile-only { display: inline-flex; }
        .be-title { font-size: 28px; }
    }
    @media (max-width: 575.98px) {
        .be-canvas { padding: 22px 14px 16px; border-radius: 10px; }
        .be-toolbar .be-btn-label { display: none; }
        .be-toolbar-sep { display: none; }
        .be-title { font-size: 24px; }
    }
</style>

<div id="content" class="app-content be-page">
    <form id="blogEditorForm" novalidate autocomplete="off">
        <!-- TOP TOOLBAR -->
        <div class="be-toolbar" role="toolbar" aria-label="Article actions">
            <a href="{{ route('admin.blog-posts.index') }}" class="be-back" id="beBack"><i class="fa fa-arrow-left"></i> <span class="be-btn-label">Back to Blogs</span></a>
            <span class="be-toolbar-sep"></span>
            <span class="be-status-pill" id="beStatusPill"></span>
            <span class="be-save-state" id="beSaveState" role="status" aria-live="polite"></span>
            <span class="be-toolbar-spacer"></span>

            <a href="#beSidebar" class="btn be-ghost btn-sm be-mobile-only" title="Settings"><i class="fa fa-sliders"></i></a>
            <button type="button" class="btn be-ghost btn-sm" id="beFocusToggle" title="Focus mode — hide everything except the writing area (Esc to exit)" aria-pressed="false">
                <i class="fa fa-expand"></i> <span class="be-btn-label">Focus</span>
            </button>
            <button type="button" class="btn be-ghost btn-sm" id="beSaveDraft">
                <i class="fa fa-floppy-disk"></i> <span class="be-btn-label">Save Draft</span>
            </button>
            <button type="button" class="btn be-ghost btn-sm" id="bePreview">
                <i class="fa fa-eye"></i> <span class="be-btn-label">Preview</span>
            </button>
            <button type="button" class="btn btn-primary btn-sm" id="bePublish">
                <i class="fa fa-paper-plane"></i> <span class="be-btn-label" id="bePublishLabel">Publish</span>
            </button>
            <div class="dropdown">
                <button type="button" class="btn be-ghost btn-sm" data-bs-toggle="dropdown" aria-expanded="false" title="More actions" aria-label="More actions">
                    <i class="fa fa-ellipsis-vertical"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end be-more-menu">
                    <li><a class="dropdown-item" href="#" id="beViewLive" target="_blank" rel="noopener"><i class="fa fa-arrow-up-right-from-square"></i> View live article</a></li>
                    <li><button type="button" class="dropdown-item" id="beSwitchDraft"><i class="fa fa-file-pen"></i> Switch to draft</button></li>
                    <li><button type="button" class="dropdown-item" id="beArchive"><i class="fa fa-box-archive"></i> Archive</button></li>
                    <li><button type="button" class="dropdown-item" id="beDuplicate"><i class="fa fa-copy"></i> Duplicate</button></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><button type="button" class="dropdown-item text-danger" id="beDelete"><i class="fa fa-trash text-danger"></i> Delete article</button></li>
                </ul>
            </div>
        </div>

        <div class="be-workspace">
            <!-- MAIN WRITING AREA -->
            <main class="be-canvas" aria-label="Article content">
                <div class="be-canvas-inner">
                    <!-- Cover: same value as the Featured Media image -->
                    <div class="be-cover">
                        <div class="be-cover-empty" id="beCoverEmpty">
                            <button type="button" class="be-cover-btn be-upload-trigger" data-type="image"><i class="fa fa-image me-1"></i> Add cover image</button>
                            <button type="button" class="be-cover-btn be-open-library"><i class="fa fa-images me-1"></i> Choose from library</button>
                        </div>
                        <div class="be-cover-filled" id="beCoverFilled" style="display: none;">
                            <img id="beCoverImg" src="" alt="">
                            <span class="be-cover-video-note" id="beCoverVideoNote" style="display: none;"><i class="fa fa-film me-1"></i> Video is shown first; this image is the thumbnail</span>
                            <div class="be-cover-actions">
                                <button type="button" class="be-upload-trigger" data-type="image"><i class="fa fa-arrow-up-from-bracket me-1"></i> Change</button>
                                <button type="button" class="be-open-library"><i class="fa fa-images me-1"></i> Library</button>
                                <button type="button" id="beCoverRemove"><i class="fa fa-xmark me-1"></i> Remove</button>
                            </div>
                        </div>
                        <div class="be-progress" data-progress="image"><span></span></div>
                    </div>

                    <div class="be-field" data-field="title">
                        <label for="beTitle" class="visually-hidden">Title</label>
                        <textarea id="beTitle" name="title" class="be-title" rows="1" maxlength="255" placeholder="Enter your blog title..." required>{{ $blog->title }}</textarea>
                        <div class="be-title-meta"><span id="beTitleCount"></span></div>
                        <div class="be-error"></div>
                    </div>

                    <div class="be-field" data-field="slug">
                        <div class="be-permalink">
                            <i class="fa fa-link"></i>
                            <span class="be-permalink-base">{{ url('/blog') }}/</span>
                            <label for="beSlug" class="visually-hidden">URL slug</label>
                            <input type="text" id="beSlug" name="slug" value="{{ $blog->slug }}" maxlength="255" spellcheck="false" placeholder="your-article-url">
                            <button type="button" class="be-link-btn" id="beSlugReset" title="Generate the slug from the title again">Regenerate</button>
                            <button type="button" class="be-link-btn" id="beCopyLink" title="Copy the article URL"><i class="fa fa-copy"></i> Copy</button>
                        </div>
                        <div class="be-error"></div>
                    </div>

                    <div class="be-field be-editor-wrap" data-field="content">
                        <label for="beContent" class="visually-hidden">Article content</label>
                        <textarea id="beContent" name="content" class="d-none">{{ $blog->content }}</textarea>
                        <div class="be-editor-placeholder" id="beEditorLoading"><i class="fa fa-spinner fa-spin me-2"></i> Loading editor...</div>
                        <div class="be-error"></div>
                        <div class="be-stats" id="beStats" aria-live="off">
                            <span><i class="fa fa-font"></i><strong data-stat="words">0</strong> words</span>
                            <span><i class="fa fa-text-width"></i><strong data-stat="chars">0</strong> characters</span>
                            <span><i class="fa fa-clock"></i><strong data-stat="minutes">0</strong> min read</span>
                            <span><i class="fa fa-heading"></i><strong data-stat="headings">0</strong> headings</span>
                            <span><i class="fa fa-link"></i><strong data-stat="links">0</strong> links</span>
                            <span><i class="fa fa-image"></i><strong data-stat="images">0</strong> images</span>
                        </div>
                    </div>
                </div>
            </main>

            <!-- SETTINGS SIDEBAR -->
            <aside class="be-sidebar" id="beSidebar" aria-label="Article settings">

                <!-- Publishing -->
                <details class="be-panel" open data-panel="publishing">
                    <summary><span class="be-panel-icon"><i class="fa fa-calendar-check"></i></span> Publishing</summary>
                    <div class="be-panel-body">
                        <div class="be-field" data-field="published_at">
                            <label for="bePublishedAt">Publish date &amp; time</label>
                            <div class="input-group input-group-sm">
                                <input type="datetime-local" id="bePublishedAt" name="published_at" class="form-control" value="{{ optional($blog->published_at)->format('Y-m-d\TH:i') }}">
                                <button type="button" class="btn be-ghost" id="bePublishNow" title="Clear to publish immediately">Now</button>
                            </div>
                            <div class="be-help" id="bePublishHint"></div>
                            <div class="be-help">Times are in {{ config('app.timezone') }} time.</div>
                            <div class="be-error"></div>
                        </div>
                        <div class="be-field" data-field="status">
                            <div class="be-help mb-0" id="beStatusHelp"></div>
                            <div class="be-error"></div>
                        </div>
                    </div>
                </details>

                <!-- Article health -->
                <details class="be-panel" open data-panel="health">
                    <summary><span class="be-panel-icon"><i class="fa fa-heart-pulse"></i></span> Article Health <span class="be-panel-hint" id="beHealthHint"></span></summary>
                    <div class="be-panel-body">
                        <div class="be-health-head">
                            <div class="be-ring" id="beHealthRing"><span id="beHealthScore">0</span></div>
                            <div>
                                <div class="be-health-label" id="beHealthLabel">Let's get started</div>
                                <div class="be-health-sub">Live checks for readability and SEO. Click <em>Fix</em> to jump to a field.</div>
                            </div>
                        </div>
                        <ul class="be-checks" id="beChecks"></ul>
                    </div>
                </details>

                <!-- Outline -->
                <details class="be-panel" data-panel="outline">
                    <summary><span class="be-panel-icon"><i class="fa fa-list-ol"></i></span> Outline <span class="be-panel-hint" id="beOutlineHint"></span></summary>
                    <div class="be-panel-body">
                        <ul class="be-outline" id="beOutline"></ul>
                        <div class="be-help" id="beOutlineEmpty">Add H2–H4 headings to structure the article. They appear here and you can click one to jump to it.</div>
                    </div>
                </details>

                <!-- Post settings -->
                <details class="be-panel" open data-panel="settings">
                    <summary><span class="be-panel-icon"><i class="fa fa-gear"></i></span> Post Settings</summary>
                    <div class="be-panel-body">
                        <div class="be-field" data-field="excerpt">
                            <label for="beExcerpt">Excerpt <span class="be-counter" data-counter-for="beExcerpt"></span></label>
                            <textarea id="beExcerpt" name="excerpt" class="form-control" rows="3" maxlength="1000" placeholder="A short summary shown on blog listings...">{{ $blog->excerpt }}</textarea>
                            <div class="be-help d-flex justify-content-between gap-2">
                                <span>Also used as the default meta description.</span>
                                <button type="button" class="be-link-btn text-nowrap" id="beExcerptGenerate" title="Fill the excerpt with the opening sentences of the article"><i class="fa fa-wand-magic-sparkles"></i> From content</button>
                            </div>
                            <div class="be-error"></div>
                        </div>
                        <div class="be-field" data-field="author_id">
                            <label for="beAuthor">Author</label>
                            <select id="beAuthor" name="author_id" class="form-select form-select-sm">
                                @foreach ($authors as $author)
                                    <option value="{{ $author->id }}" {{ (int) $blog->author_id === (int) $author->id ? 'selected' : '' }}>{{ $author->name }}</option>
                                @endforeach
                            </select>
                            <div class="be-error"></div>
                        </div>
                    </div>
                </details>

                <!-- Categories -->
                <details class="be-panel" open data-panel="categories">
                    <summary><span class="be-panel-icon"><i class="fa fa-folder-tree"></i></span> Categories <span class="be-panel-hint" id="beCategoryCount"></span></summary>
                    <div class="be-panel-body">
                        <div class="be-field" data-field="categories">
                            <div class="be-chips" id="beCategoryChips"></div>
                            @if ($blogCategories->isEmpty())
                                <div class="be-help">No categories yet. <a href="{{ route('admin.blog-categories.index') }}" target="_blank" rel="noopener">Create categories</a>, then reload this page.</div>
                            @else
                                @if ($blogCategories->count() > 6)
                                    <input type="search" class="form-control form-control-sm mb-2" id="beCategorySearch" placeholder="Search categories..." aria-label="Search categories">
                                @endif
                                <div class="be-category-list" id="beCategoryList">
                                    @foreach ($blogCategories as $blogCategory)
                                        <label data-name="{{ strtolower($blogCategory->name) }}">
                                            <input type="checkbox" class="be-check" name="categories[]" value="{{ $blogCategory->id }}" data-label="{{ $blogCategory->name }}"
                                                {{ in_array($blogCategory->id, $selectedCategoryIds) ? 'checked' : '' }}>
                                            {{ $blogCategory->name }}
                                            @if (!$blogCategory->status)<span class="be-inactive">(inactive)</span>@endif
                                        </label>
                                    @endforeach
                                </div>
                                <div class="be-help"><a href="{{ route('admin.blog-categories.index') }}" target="_blank" rel="noopener">Manage categories</a></div>
                            @endif
                            <div class="be-error"></div>
                        </div>
                    </div>
                </details>

                <!-- Featured media -->
                <details class="be-panel" open data-panel="media">
                    <summary><span class="be-panel-icon"><i class="fa fa-photo-film"></i></span> Featured Media</summary>
                    <div class="be-panel-body">
                        <div class="be-field" data-field="featured_media_type">
                            <span class="be-label">Show at the top of the article</span>
                            <div class="be-segment" role="radiogroup" aria-label="Primary featured media">
                                <label><input type="radio" name="featured_media_type" value="image" {{ $blog->featured_media_type !== 'video' ? 'checked' : '' }}><span><i class="fa fa-image me-1"></i> Image</span></label>
                                <label><input type="radio" name="featured_media_type" value="video" {{ $blog->featured_media_type === 'video' ? 'checked' : '' }}><span><i class="fa fa-film me-1"></i> Video</span></label>
                            </div>
                            <div class="be-error"></div>
                        </div>

                        <!-- Featured image -->
                        <div class="be-field" data-field="featured_image">
                            <span class="be-label">Featured image</span>
                            <input type="hidden" name="featured_image" id="beFeaturedImage" value="{{ $blog->featured_image }}">
                            <div id="beImageEmpty" class="be-dropzone" data-drop="image">
                                <i class="fa fa-cloud-arrow-up"></i>
                                <div class="small mb-2">Drag an image here or</div>
                                <div class="d-flex gap-2 justify-content-center flex-wrap">
                                    <button type="button" class="btn btn-sm btn-primary be-upload-trigger" data-type="image">Upload</button>
                                    <button type="button" class="btn btn-sm be-ghost be-open-library">Media library</button>
                                </div>
                                <div class="be-help mt-2">JPG, PNG, GIF or WebP, up to 5 MB.</div>
                            </div>
                            <div id="beImageFilled" style="display: none;">
                                <div class="be-media-preview"><img id="beImagePreview" src="" alt=""></div>
                                <div class="be-media-actions">
                                    <button type="button" class="btn btn-sm be-ghost be-upload-trigger" data-type="image"><i class="fa fa-arrow-up-from-bracket"></i> Replace</button>
                                    <button type="button" class="btn btn-sm be-ghost be-open-library"><i class="fa fa-images"></i> Library</button>
                                    <button type="button" class="btn btn-sm be-ghost be-danger" id="beImageRemove"><i class="fa fa-xmark"></i> Remove</button>
                                </div>
                            </div>
                            <div class="be-progress" data-progress="image"><span></span></div>
                            <div class="be-help">Also used as the listing thumbnail and social sharing image.</div>
                            <div class="be-error"></div>
                        </div>
                        <div class="be-field" data-field="featured_image_alt">
                            <label for="beImageAlt">Image alt text</label>
                            <input type="text" id="beImageAlt" name="featured_image_alt" class="form-control form-control-sm" maxlength="255" value="{{ $blog->featured_image_alt }}" placeholder="Describe the image for screen readers & SEO">
                            <div class="be-error"></div>
                        </div>

                        <!-- Featured video -->
                        <div id="beVideoSection">
                            <div class="be-field">
                                <span class="be-label">Featured video</span>
                                <div class="be-segment" role="radiogroup" aria-label="Video source">
                                    <label><input type="radio" name="video_source" value="url" {{ !$blog->featured_video ? 'checked' : '' }}><span>Embed link</span></label>
                                    <label><input type="radio" name="video_source" value="file" {{ $blog->featured_video ? 'checked' : '' }}><span>Upload file</span></label>
                                </div>
                            </div>
                            <div class="be-field" data-field="featured_video_url" id="beVideoUrlBox">
                                <label for="beVideoUrl">Video URL</label>
                                <input type="url" id="beVideoUrl" name="featured_video_url" class="form-control form-control-sm" maxlength="500" value="{{ $blog->featured_video_url }}" placeholder="https://www.youtube.com/watch?v=...">
                                <div class="be-help">YouTube, Vimeo or Dailymotion link.</div>
                                <div class="be-media-preview mt-2" id="beVideoEmbedPreview" style="display: none;"><iframe title="Video preview" allowfullscreen loading="lazy"></iframe></div>
                                <div class="be-error"></div>
                            </div>
                            <div class="be-field" data-field="featured_video" id="beVideoFileBox">
                                <input type="hidden" name="featured_video" id="beFeaturedVideo" value="{{ $blog->featured_video }}">
                                <div id="beVideoEmpty" class="be-dropzone" data-drop="video">
                                    <i class="fa fa-film"></i>
                                    <div class="small mb-2">Drag a video here or</div>
                                    <button type="button" class="btn btn-sm btn-primary be-upload-trigger" data-type="video">Upload video</button>
                                    <div class="be-help mt-2">MP4, WebM, Ogg or MOV, up to 50 MB.</div>
                                </div>
                                <div id="beVideoFilled" style="display: none;">
                                    <div class="be-media-preview"><video id="beVideoPreview" controls preload="metadata"></video></div>
                                    <div class="be-media-actions">
                                        <button type="button" class="btn btn-sm be-ghost be-upload-trigger" data-type="video"><i class="fa fa-arrow-up-from-bracket"></i> Replace</button>
                                        <button type="button" class="btn btn-sm be-ghost be-danger" id="beVideoRemove"><i class="fa fa-xmark"></i> Remove</button>
                                    </div>
                                </div>
                                <div class="be-progress" data-progress="video"><span></span></div>
                                <div class="be-error"></div>
                            </div>
                        </div>
                        <input type="file" id="beFileInput" class="d-none" aria-hidden="true" tabindex="-1">
                    </div>
                </details>

                <!-- Location -->
                <details class="be-panel" data-panel="location">
                    <summary><span class="be-panel-icon"><i class="fa fa-location-dot"></i></span> Location <span class="be-panel-hint">Optional</span></summary>
                    <div class="be-panel-body">
                        <div class="be-field" data-field="country_id">
                            <label for="beCountry">Country</label>
                            <select id="beCountry" name="country_id" class="form-select form-select-sm">
                                <option value="">No location</option>
                                @foreach ($countries as $countryOption)
                                    <option value="{{ $countryOption->id }}" {{ (int) $blog->country_id === (int) $countryOption->id ? 'selected' : '' }}>{{ $countryOption->name }}</option>
                                @endforeach
                            </select>
                            <div class="be-error"></div>
                        </div>
                        <div class="be-field" data-field="state_id">
                            <label for="beState">State</label>
                            <select id="beState" name="state_id" class="form-select form-select-sm" disabled><option value="">Select a country first</option></select>
                            <div class="be-error"></div>
                        </div>
                        <div class="be-field" data-field="city_id">
                            <label for="beCity">City</label>
                            <select id="beCity" name="city_id" class="form-select form-select-sm" disabled><option value="">Select a state first</option></select>
                            <div class="be-error"></div>
                        </div>
                    </div>
                </details>

                <!-- SEO -->
                <details class="be-panel" data-panel="seo">
                    <summary><span class="be-panel-icon"><i class="fa fa-magnifying-glass-chart"></i></span> SEO Settings</summary>
                    <div class="be-panel-body">
                        <div class="be-field">
                            <span class="be-label">Search preview</span>
                            <div class="be-serp" aria-label="Google search result preview">
                                <div class="be-serp-url" id="beSerpUrl"></div>
                                <div class="be-serp-title" id="beSerpTitle"></div>
                                <div class="be-serp-desc" id="beSerpDesc"></div>
                            </div>
                        </div>
                        <div class="be-field">
                            <span class="be-label">Social share preview</span>
                            <div class="be-social" aria-label="Social media share preview">
                                <div class="be-social-img" id="beSocialImg">No featured image</div>
                                <div class="be-social-body">
                                    <div class="be-social-domain">{{ request()->getHost() }}</div>
                                    <div class="be-social-title" id="beSocialTitle"></div>
                                    <div class="be-social-desc" id="beSocialDesc"></div>
                                </div>
                            </div>
                        </div>
                        <div class="be-field" data-field="meta_title">
                            <label for="beMetaTitle">Meta title <span class="be-counter" data-counter-for="beMetaTitle"></span></label>
                            <input type="text" id="beMetaTitle" name="meta_title" class="form-control form-control-sm" maxlength="255" value="{{ $blog->meta_title }}">
                            <div class="be-help">Leave empty to use the article title. Aim for 50–60 characters.</div>
                            <div class="be-error"></div>
                        </div>
                        <div class="be-field" data-field="meta_description">
                            <label for="beMetaDescription">Meta description <span class="be-counter" data-counter-for="beMetaDescription"></span></label>
                            <textarea id="beMetaDescription" name="meta_description" class="form-control form-control-sm" rows="3" maxlength="500">{{ $blog->meta_description }}</textarea>
                            <div class="be-help">Leave empty to use the excerpt or the start of the article. Aim for 120–160 characters.</div>
                            <div class="be-error"></div>
                        </div>
                        <div class="be-field" data-field="meta_keywords">
                            <label for="beMetaKeywords">Meta keywords</label>
                            <input type="text" id="beMetaKeywords" name="meta_keywords" class="form-control form-control-sm" maxlength="1000" value="{{ $blog->meta_keywords }}" placeholder="keyword one, keyword two">
                            <div class="be-error"></div>
                        </div>
                        <div class="be-field" data-field="canonical_url">
                            <label for="beCanonical">Canonical URL</label>
                            <input type="url" id="beCanonical" name="canonical_url" class="form-control form-control-sm" maxlength="500" value="{{ $blog->canonical_url }}" placeholder="Defaults to the article URL">
                            <div class="be-error"></div>
                        </div>
                        <div class="row g-2">
                            <div class="col-6 be-field" data-field="robots_index">
                                <label for="beRobotsIndex">Indexing</label>
                                <select id="beRobotsIndex" name="robots_index" class="form-select form-select-sm">
                                    <option value="index" {{ $blog->robots_index !== 'noindex' ? 'selected' : '' }}>Index</option>
                                    <option value="noindex" {{ $blog->robots_index === 'noindex' ? 'selected' : '' }}>Noindex</option>
                                </select>
                            </div>
                            <div class="col-6 be-field" data-field="robots_follow">
                                <label for="beRobotsFollow">Links</label>
                                <select id="beRobotsFollow" name="robots_follow" class="form-select form-select-sm">
                                    <option value="follow" {{ $blog->robots_follow !== 'nofollow' ? 'selected' : '' }}>Follow</option>
                                    <option value="nofollow" {{ $blog->robots_follow === 'nofollow' ? 'selected' : '' }}>Nofollow</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </details>
            </aside>
        </div>
    </form>
</div>

<!-- MEDIA LIBRARY MODAL -->
<div class="modal fade" id="beLibraryModal" tabindex="-1" aria-labelledby="beLibraryTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-dark" id="beLibraryTitle"><i class="fa fa-images me-2 text-danger"></i>Media library</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="be-library-grid" id="beLibraryGrid"></div>
                <div class="text-center text-muted py-4" id="beLibraryEmpty" style="display: none;">No images uploaded yet.</div>
                <div class="text-center mt-3"><button type="button" class="btn be-ghost btn-sm" id="beLibraryMore" style="display: none;">Load more</button></div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.10.9/tinymce.min.js"></script>
<script>
$(function () {
    'use strict';

    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), 'Accept': 'application/json' } });

    var STATUS_LABELS = @json(\App\Models\Blog::STATUSES);
    var URLS = {
        index: "{{ route('admin.blog-posts.index') }}",
        store: "{{ route('admin.blog-posts.store') }}",
        update: "{{ route('admin.blog-posts.update', ':id') }}",
        destroy: "{{ route('admin.blog-posts.destroy', ':id') }}",
        duplicate: "{{ route('admin.blog-posts.duplicate', ':id') }}",
        previewDraft: "{{ route('admin.blog-posts.preview-draft') }}",
        upload: "{{ route('admin.blog-posts.media.upload') }}",
        library: "{{ route('admin.blog-posts.media') }}",
        states: "{{ route('admin.get-states') }}",
        cities: "{{ route('admin.get-cities') }}",
        blogBase: "{{ url('/blog') }}/"
    };
    var initial = @json($initial);

    var state = {
        id: initial.id,
        status: initial.status,                 // status as stored on the server
        effectiveStatus: initial.effective_status,
        publicUrl: initial.public_url,
        updatedAt: initial.updated_at,
        slugAuto: !initial.id,                  // keep generating the slug from the title until edited by hand
        lastSnapshot: null,                     // payload the server last confirmed
        dirty: false,
        saving: false,
        chain: $.Deferred().resolve().promise(), // serialises saves so they never overlap
        autosaveTimer: null,
        backupTimer: null,
        checkTimer: null,
        editor: null
    };
    var locationReady = $.Deferred();

    var $form = $('#blogEditorForm');
    var $title = $('#beTitle');
    var $slug = $('#beSlug');
    var $publishedAt = $('#bePublishedAt');

    /* ------------------------------------------------------------------ helpers */

    function slugify(text) {
        return (text || '').toString().normalize('NFKD').replace(/[̀-ͯ]/g, '')
            .toLowerCase().trim()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/[\s_-]+/g, '-')
            .replace(/^-+|-+$/g, '');
    }

    function stripHtml(html) {
        var div = document.createElement('div');
        div.innerHTML = html || '';
        return (div.textContent || '').replace(/\s+/g, ' ').trim();
    }

    function truncate(text, max) {
        return text.length > max ? text.slice(0, max - 1).replace(/\s+\S*$/, '') + '…' : text;
    }

    function escapeHtml(text) {
        return $('<div>').text(text || '').html();
    }

    function editorContent() {
        return state.editor ? state.editor.getContent() : $('#beContent').val();
    }

    function isFuture(value) {
        return value && new Date(value).getTime() > Date.now();
    }

    function stringId(value) {
        return value ? String(value) : '';
    }

    function backupKey() {
        return 'blog-editor-backup:' + (state.id || 'new');
    }

    function storage(fn) {
        try { return fn(window.localStorage); } catch (e) { return null; }
    }

    /* ------------------------------------------------------------------ payload */

    function collect() {
        var videoSource = $('input[name="video_source"]:checked').val();

        return {
            id: state.id || '',
            title: $title.val().trim(),
            slug: $slug.val().trim(),
            slug_auto: state.slugAuto ? 1 : 0,
            excerpt: $('#beExcerpt').val(),
            content: editorContent(),
            published_at: $publishedAt.val(),
            author_id: $('#beAuthor').val() || '',
            categories: $('input[name="categories[]"]:checked').map(function () { return this.value; }).get(),
            featured_media_type: $('input[name="featured_media_type"]:checked').val(),
            featured_image: $('#beFeaturedImage').val(),
            featured_image_alt: $('#beImageAlt').val(),
            featured_video: videoSource === 'file' ? $('#beFeaturedVideo').val() : '',
            featured_video_url: videoSource === 'url' ? $('#beVideoUrl').val().trim() : '',
            country_id: $('#beCountry').val() || '',
            // Until the dependent dropdowns have loaded, keep the stored values instead of blanks.
            state_id: locationReady.state() === 'pending' ? stringId(initial.state_id) : ($('#beState').val() || ''),
            city_id: locationReady.state() === 'pending' ? stringId(initial.city_id) : ($('#beCity').val() || ''),
            meta_title: $('#beMetaTitle').val(),
            meta_description: $('#beMetaDescription').val(),
            meta_keywords: $('#beMetaKeywords').val(),
            canonical_url: $('#beCanonical').val().trim(),
            robots_index: $('#beRobotsIndex').val(),
            robots_follow: $('#beRobotsFollow').val()
        };
    }

    function snapshot(payload) {
        var copy = $.extend({}, payload);
        delete copy.slug_auto;
        delete copy.id;
        delete copy.status;
        return JSON.stringify(copy);
    }

    /* ------------------------------------------------------------------ UI state */

    function setSaveState(kind, text) {
        var icons = { saving: 'fa-spinner fa-spin', saved: 'fa-circle-check', dirty: 'fa-circle', error: 'fa-triangle-exclamation', idle: 'fa-circle-info' };
        $('#beSaveState')
            .attr('class', 'be-save-state is-' + kind)
            .html('<i class="fa ' + icons[kind] + '"></i> ' + escapeHtml(text));
    }

    function refreshToolbar() {
        var status = state.effectiveStatus || 'draft';
        var future = isFuture($publishedAt.val());
        var live = status === 'published' || status === 'scheduled';

        $('#beStatusPill').attr('class', 'be-status-pill be-status-' + status).text(state.id ? STATUS_LABELS[status] : 'New draft');
        $('#bePublishLabel').text(live ? (future && status !== 'published' ? 'Update schedule' : 'Update') : (future ? 'Schedule' : 'Publish'));
        $('#bePublish i').attr('class', 'fa ' + (live ? 'fa-rotate' : (future ? 'fa-clock' : 'fa-paper-plane')));
        $('#beSaveDraft').toggle(!live);

        $('#beViewLive').closest('li').toggle(status === 'published' && !!state.publicUrl);
        $('#beViewLive').attr('href', state.publicUrl || '#');
        $('#beSwitchDraft').closest('li').toggle(!!state.id && status !== 'draft');
        $('#beArchive').closest('li').toggle(!!state.id && status !== 'archived');
        $('#beDuplicate, #beDelete').closest('li').toggle(!!state.id);
        $('.be-more-menu .dropdown-divider').closest('li').toggle(!!state.id);

        var hint;
        if (!$publishedAt.val()) {
            hint = live ? 'Keeps the original publish date.' : 'Empty = publish immediately when you click Publish.';
        } else if (future) {
            hint = '<i class="fa fa-clock"></i> Will go live on ' + escapeHtml(new Date($publishedAt.val()).toLocaleString()) + '.';
        } else {
            hint = 'Date in the past: the article is shown with this date.';
        }
        $('#bePublishHint').html(hint);

        var help = {
            draft: 'Drafts are private. Autosave is on.',
            published: 'This article is live. Changes go live when you click Update.',
            scheduled: 'Scheduled articles stay hidden until their publish time.',
            archived: 'Archived articles are hidden from the website.'
        };
        $('#beStatusHelp').text(state.id ? help[status] : 'New article — it is saved as a private draft as soon as you add a title.');
    }

    /**
     * Something may have changed: compare against the last server-confirmed version
     * (debounced, so long articles are not serialised on every keystroke).
     */
    function markChanged() {
        state.dirty = true; // pessimistic until checked, so leaving the page still warns
        clearTimeout(state.checkTimer);
        state.checkTimer = setTimeout(checkDirty, 300);
    }

    function checkDirty() {
        var payload = collect();
        refreshInsights(payload);
        state.dirty = state.lastSnapshot === null
            ? !!(payload.title || stripHtml(payload.content))
            : snapshot(payload) !== state.lastSnapshot;

        if (state.dirty) {
            setSaveState('dirty', 'Unsaved changes');
            scheduleAutosave();
            scheduleBackup();
        } else if (!state.saving) {
            clearTimeout(state.autosaveTimer);
            clearTimeout(state.backupTimer);
            storage(function (s) { s.removeItem(backupKey()); });
            setSaveState(state.id ? 'saved' : 'idle', state.id ? 'All changes saved' : 'Not saved yet');
        }
    }

    /* ------------------------------------------------------------------ errors */

    function clearErrors() {
        $form.find('.be-field.is-invalid').removeClass('is-invalid').find('.be-error').text('');
        $('.be-panel.has-error').removeClass('has-error');
    }

    function showErrors(errors) {
        clearErrors();
        var messages = [];
        $.each(errors || {}, function (key, list) {
            var field = key.split('.')[0];
            var $field = $form.find('[data-field="' + field + '"]');
            messages.push(list[0]);
            if ($field.length) {
                $field.addClass('is-invalid').find('.be-error').text(list[0]);
                $field.closest('details').attr('open', true).addClass('has-error');
            }
        });
        return messages;
    }

    function errorText(xhr, fallback) {
        if (xhr.status === 419) return 'Your session expired. Reload the page (your text is kept in this browser).';
        if (xhr.status === 0) return 'No connection to the server.';
        return (xhr.responseJSON && xhr.responseJSON.message) || fallback;
    }

    /* ------------------------------------------------------------------ saving */

    /**
     * Queue a save. mode: 'autosave' | 'manual'. status: target status sent to the server.
     */
    function save(status, mode) {
        var deferred = $.Deferred();

        state.chain = state.chain.then(function () {
            return doSave(status, mode).then(deferred.resolve, deferred.reject);
        }, function () {
            return doSave(status, mode).then(deferred.resolve, deferred.reject);
        });

        return deferred.promise();
    }

    function doSave(status, mode) {
        var deferred = $.Deferred();
        clearTimeout(state.autosaveTimer);

        // Make sure pasted / dropped images are uploaded before the HTML is sent.
        var uploads = state.editor ? state.editor.uploadImages() : Promise.resolve();

        Promise.resolve(uploads).then(function () {
            var payload = collect();
            payload.status = status;
            var sentSnapshot = snapshot(payload);

            if (!payload.title) {
                if (mode === 'manual') {
                    showErrors({ title: ['Add a title before saving.'] });
                    $title.trigger('focus');
                }
                return deferred.reject();
            }

            state.saving = true;
            setSaveState('saving', mode === 'autosave' ? 'Autosaving…' : 'Saving…');

            var data = $.extend({}, payload);
            if (state.id) data._method = 'PUT';

            $.ajax({
                url: state.id ? URLS.update.replace(':id', state.id) : URLS.store,
                type: 'POST',
                data: data,
                dataType: 'json'
            }).done(function (res) {
                var wasNew = !state.id;
                var saved = res.data;

                if (wasNew) {
                    storage(function (s) { s.removeItem(backupKey()); });
                    history.replaceState(null, '', saved.edit_url);
                }

                state.id = saved.id;
                state.status = saved.status;
                state.effectiveStatus = saved.effective_status;
                state.publicUrl = saved.public_url;
                state.updatedAt = saved.updated_at;

                // The server may have made the slug unique or resolved the publish date.
                if ($slug.val() !== saved.slug) $slug.val(saved.slug);
                if (saved.status !== 'draft' && saved.status !== 'archived') state.slugAuto = false;
                if (saved.published_at && $publishedAt.val() !== saved.published_at) $publishedAt.val(saved.published_at);

                payload.slug = saved.slug;
                payload.published_at = saved.published_at || payload.published_at;
                state.lastSnapshot = snapshot(payload);

                // Edits typed while the request was running stay "unsaved".
                state.dirty = snapshot(collect()) !== state.lastSnapshot;
                clearErrors();
                refreshToolbar();
                updateSeoPreview();

                if (state.dirty) {
                    setSaveState('dirty', 'Unsaved changes');
                    scheduleAutosave();
                } else {
                    setSaveState('saved', (mode === 'autosave' ? 'Autosaved' : 'Saved') + ' at ' + new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }));
                    storage(function (s) { s.removeItem(backupKey()); });
                }
                deferred.resolve(res);
            }).fail(function (xhr) {
                writeBackup();
                if (xhr.status === 422) {
                    var messages = showErrors(xhr.responseJSON.errors);
                    setSaveState('error', mode === 'autosave' ? 'Autosave paused: fix the highlighted fields' : 'Not saved: fix the highlighted fields');
                    if (mode === 'manual') {
                        Swal.fire({ icon: 'error', title: 'Please check the article', html: messages.map(escapeHtml).join('<br>') });
                    }
                } else {
                    setSaveState('error', 'Not saved — ' + errorText(xhr, 'server error') + ' Retry with Save.');
                    if (mode === 'manual') {
                        Swal.fire({ icon: 'error', title: 'Save failed', text: errorText(xhr, 'The article could not be saved. Your changes are still here; please try again.') });
                    }
                }
                deferred.reject(xhr);
            }).always(function () {
                state.saving = false;
            });
        }, function () {
            setSaveState('error', 'An image in the article failed to upload.');
            deferred.reject();
        });

        return deferred.promise();
    }

    function canAutosave() {
        return (!state.id || state.status === 'draft') && $title.val().trim() !== '';
    }

    function scheduleAutosave() {
        clearTimeout(state.autosaveTimer);
        if (!canAutosave()) return;
        state.autosaveTimer = setTimeout(function () {
            // Skip while another save is running; the change is picked up by the next timer.
            if (state.saving) return scheduleAutosave();
            if (state.dirty && canAutosave()) save('draft', 'autosave');
        }, 4000);
    }

    /* ------------------------------------------------------------------ local backup */

    function writeBackup() {
        var payload = collect();
        storage(function (s) { s.setItem(backupKey(), JSON.stringify({ ts: Date.now(), payload: payload })); });
    }

    function scheduleBackup() {
        clearTimeout(state.backupTimer);
        state.backupTimer = setTimeout(writeBackup, 1500);
    }

    function offerBackupRestore() {
        var raw = storage(function (s) { return s.getItem(backupKey()); });
        if (!raw) return;

        var backup;
        try { backup = JSON.parse(raw); } catch (e) { return; }

        var serverTime = state.updatedAt ? new Date(state.updatedAt).getTime() : 0;
        if (!backup || !backup.payload || backup.ts <= serverTime || snapshot(backup.payload) === state.lastSnapshot) {
            storage(function (s) { s.removeItem(backupKey()); });
            return;
        }

        Swal.fire({
            icon: 'info',
            title: 'Restore unsaved changes?',
            text: 'This browser has a newer, unsaved version of this article from ' + new Date(backup.ts).toLocaleString() + '.',
            showCancelButton: true,
            confirmButtonText: 'Restore it',
            cancelButtonText: 'Discard',
            confirmButtonColor: '#bc1212'
        }).then(function (result) {
            if (result.isConfirmed) {
                applyPayload(backup.payload);
                markChanged();
            } else {
                storage(function (s) { s.removeItem(backupKey()); });
            }
        });
    }

    function applyPayload(p) {
        $title.val(p.title).trigger('autosize');
        $slug.val(p.slug);
        state.slugAuto = !!p.slug_auto;
        $('#beExcerpt').val(p.excerpt);
        if (state.editor) state.editor.setContent(p.content || '');
        $publishedAt.val(p.published_at);
        $('#beAuthor').val(p.author_id);
        $('input[name="categories[]"]').each(function () { this.checked = (p.categories || []).indexOf(this.value) !== -1; });
        $('input[name="featured_media_type"][value="' + p.featured_media_type + '"]').prop('checked', true);
        setImage(p.featured_image, null);
        $('#beImageAlt').val(p.featured_image_alt);
        $('input[name="video_source"][value="' + (p.featured_video ? 'file' : 'url') + '"]').prop('checked', true);
        setVideoFile(p.featured_video, null);
        $('#beVideoUrl').val(p.featured_video_url);
        $('#beMetaTitle').val(p.meta_title);
        $('#beMetaDescription').val(p.meta_description);
        $('#beMetaKeywords').val(p.meta_keywords);
        $('#beCanonical').val(p.canonical_url);
        $('#beRobotsIndex').val(p.robots_index);
        $('#beRobotsFollow').val(p.robots_follow);
        $('#beCountry').val(p.country_id);
        loadStates(p.country_id, p.state_id).then(function () { return loadCities(p.state_id, p.city_id); });
        renderChips(); updateMediaUi(); updateCounters(); updateSeoPreview(); refreshToolbar();
    }

    /* ------------------------------------------------------------------ title & slug */

    function autosizeTitle() {
        $title[0].style.height = 'auto';
        $title[0].style.height = $title[0].scrollHeight + 'px';
    }

    function updateTitleCount() {
        var len = $title.val().trim().length;
        $('#beTitleCount').text(len ? len + ' / 70' : '').css('color', len > 70 ? '#dc2626' : '');
    }

    $title.on('input autosize', function () {
        autosizeTitle();
        updateTitleCount();
        if (state.slugAuto) $slug.val(slugify($title.val()));
        $form.find('[data-field="title"]').removeClass('is-invalid');
        updateSeoPreview();
    }).on('keydown', function (e) {
        // Enter in the title jumps into the article body instead of adding a line break.
        if (e.key === 'Enter') {
            e.preventDefault();
            if (state.editor) state.editor.focus();
        }
    });

    $slug.on('input', function () {
        state.slugAuto = false;
        updateSeoPreview();
    }).on('blur', function () {
        $slug.val(slugify($slug.val()) || slugify($title.val()));
        updateSeoPreview();
    });

    $('#beSlugReset').on('click', function () {
        state.slugAuto = true;
        $slug.val(slugify($title.val()));
        markChanged();
        updateSeoPreview();
    });

    /* ------------------------------------------------------------------ publishing */

    $publishedAt.on('change input', refreshToolbar);
    $('#bePublishNow').on('click', function () {
        $publishedAt.val('');
        refreshToolbar();
        markChanged();
    });

    function publish() {
        var future = isFuture($publishedAt.val());
        var target = future ? 'scheduled' : 'published';
        var wasLive = state.effectiveStatus === 'published';

        if (!stripHtml(editorContent()) && !/<(img|iframe|video)/i.test(editorContent())) {
            showErrors({ content: ['Write some content before publishing the article.'] });
            Swal.fire({ icon: 'warning', title: 'The article is empty', text: 'Write some content before publishing.' });
            return;
        }

        // First publish: point out failing health checks, but let the admin decide.
        refreshInsights();
        if (!wasLive && state.effectiveStatus !== 'scheduled' && (state.healthIssues || []).length && !publish.confirmed) {
            Swal.fire({
                icon: 'question',
                title: 'Publish with ' + state.healthIssues.length + ' open issue' + (state.healthIssues.length > 1 ? 's' : '') + '?',
                html: '<ul style="text-align:left;margin:0 auto;max-width:360px">' + state.healthIssues.map(function (i) { return '<li>' + escapeHtml(i) + '</li>'; }).join('') + '</ul>',
                showCancelButton: true,
                confirmButtonText: future ? 'Schedule anyway' : 'Publish anyway',
                cancelButtonText: 'Review first',
                confirmButtonColor: '#bc1212'
            }).then(function (r) {
                if (r.isConfirmed) {
                    publish.confirmed = true;
                    publish();
                    publish.confirmed = false;
                } else {
                    $('[data-panel="health"]').attr('open', true)[0].scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
            return;
        }

        save(target, 'manual').done(function () {
            if (state.effectiveStatus === 'scheduled') {
                Swal.fire({ icon: 'success', title: 'Scheduled', text: 'The article will go live on ' + new Date($publishedAt.val()).toLocaleString() + '.', confirmButtonColor: '#bc1212' });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: wasLive ? 'Article updated' : 'Article published',
                    html: 'It is live at <a href="' + escapeHtml(state.publicUrl) + '" target="_blank" rel="noopener">' + escapeHtml(state.publicUrl) + '</a>',
                    confirmButtonColor: '#bc1212'
                });
            }
        });
    }

    $('#bePublish').on('click', publish);
    $('#beSaveDraft').on('click', function () { save('draft', 'manual'); });

    $('#beSwitchDraft').on('click', function () {
        Swal.fire({
            icon: 'question', title: 'Switch to draft?', text: 'The article will be removed from the website until you publish it again.',
            showCancelButton: true, confirmButtonText: 'Switch to draft', confirmButtonColor: '#bc1212'
        }).then(function (r) { if (r.isConfirmed) save('draft', 'manual'); });
    });

    $('#beArchive').on('click', function () {
        Swal.fire({
            icon: 'question', title: 'Archive this article?', text: 'Archived articles are hidden from the website but kept here.',
            showCancelButton: true, confirmButtonText: 'Archive', confirmButtonColor: '#bc1212'
        }).then(function (r) { if (r.isConfirmed) save('archived', 'manual'); });
    });

    $('#beDuplicate').on('click', function () {
        var go = function () {
            $.post(URLS.duplicate.replace(':id', state.id)).done(function (res) {
                state.dirty = false;
                window.location = res.edit_url;
            }).fail(function (xhr) {
                Swal.fire({ icon: 'error', title: 'Error', text: errorText(xhr, 'Failed to duplicate the article.') });
            });
        };
        if (!state.dirty) return go();
        Swal.fire({
            icon: 'question', title: 'Duplicate the saved version?', text: 'Your unsaved changes are not included in the copy and will be lost if you continue.',
            showCancelButton: true, confirmButtonText: 'Duplicate anyway', confirmButtonColor: '#bc1212'
        }).then(function (r) { if (r.isConfirmed) go(); });
    });

    $('#beDelete').on('click', function () {
        Swal.fire({
            icon: 'warning', title: 'Delete this article?', text: 'This action cannot be undone.',
            showCancelButton: true, confirmButtonText: 'Yes, delete it', confirmButtonColor: '#e41e3f', cancelButtonColor: '#6c757d'
        }).then(function (r) {
            if (!r.isConfirmed) return;
            $.ajax({ url: URLS.destroy.replace(':id', state.id), type: 'POST', data: { _method: 'DELETE' } })
                .done(function () {
                    state.dirty = false;
                    storage(function (s) { s.removeItem(backupKey()); });
                    window.location = URLS.index;
                })
                .fail(function (xhr) { Swal.fire({ icon: 'error', title: 'Error', text: errorText(xhr, 'Failed to delete the article.') }); });
        });
    });

    /* ------------------------------------------------------------------ preview */

    $('#bePreview').on('click', function () {
        // Open the tab synchronously (popup blockers), then fill it with the rendered preview.
        var win = window.open('', '_blank');
        if (!win) {
            Swal.fire({ icon: 'info', title: 'Pop-up blocked', text: 'Allow pop-ups for this site to open the preview.' });
            return;
        }
        win.document.write('<p style="font-family:sans-serif;padding:24px;color:#555">Rendering preview…</p>');

        var uploads = state.editor ? state.editor.uploadImages() : Promise.resolve();
        Promise.resolve(uploads).then(function () {
            var payload = collect();
            payload.status = state.id ? state.status : 'draft';
            if (payload.status === 'scheduled' && !isFuture(payload.published_at)) payload.status = 'published';

            $.ajax({ url: URLS.previewDraft, type: 'POST', data: payload, dataType: 'html' })
                .done(function (html) {
                    win.document.open();
                    win.document.write(html);
                    win.document.close();
                })
                .fail(function (xhr) {
                    win.close();
                    var json = null;
                    try { json = JSON.parse(xhr.responseText); } catch (e) {}
                    if (xhr.status === 422 && json) {
                        Swal.fire({ icon: 'error', title: 'Cannot preview yet', html: showErrors(json.errors).map(escapeHtml).join('<br>') });
                    } else {
                        Swal.fire({ icon: 'error', title: 'Preview failed', text: errorText(xhr, 'Could not render the preview.') });
                    }
                });
        });
    });

    /* ------------------------------------------------------------------ categories */

    function renderChips() {
        var $chips = $('#beCategoryChips').empty();
        var $checked = $('input[name="categories[]"]:checked');

        $checked.each(function () {
            var id = this.value;
            $('<span class="be-chip">').text($(this).data('label')).append(
                $('<button type="button" aria-label="Remove category">').html('&times;').on('click', function () {
                    $('input[name="categories[]"][value="' + id + '"]').prop('checked', false).trigger('change');
                })
            ).appendTo($chips);
        });

        $chips.toggle($checked.length > 0);
        $('#beCategoryCount').text($checked.length ? $checked.length + ' selected' : '');
    }

    $form.on('change', 'input[name="categories[]"]', renderChips);
    $('#beCategorySearch').on('input', function () {
        var q = this.value.toLowerCase().trim();
        $('#beCategoryList label').each(function () {
            $(this).toggle(!q || $(this).data('name').indexOf(q) !== -1);
        });
    });

    /* ------------------------------------------------------------------ featured media */

    var uploadType = null;

    function setImage(path, url) {
        var src = path ? (url || '{{ asset('') }}' + path) : '';
        $('#beFeaturedImage').val(path || '');
        $('#beImagePreview').attr('src', src).attr('alt', $('#beImageAlt').val());
        $('#beImageEmpty').toggle(!path);
        $('#beImageFilled').toggle(!!path);
        // Cover in the writing canvas and the social card show the same image.
        $('#beCoverImg').attr('src', src);
        $('#beCoverEmpty').toggle(!path);
        $('#beCoverFilled').toggle(!!path);
        $('#beSocialImg').css('background-image', src ? 'url("' + src.replace(/"/g, '%22') + '")' : 'none').text(src ? '' : 'No featured image');
    }

    $('#beCoverRemove').on('click', function () { setImage(null); markChanged(); });

    function setVideoFile(path, url) {
        $('#beFeaturedVideo').val(path || '');
        var video = $('#beVideoPreview')[0];
        if (path) { video.src = url || '{{ asset('') }}' + path; } else { video.removeAttribute('src'); video.load(); }
        $('#beVideoEmpty').toggle(!path);
        $('#beVideoFilled').toggle(!!path);
    }

    function embedUrl(url) {
        var m;
        if (!/^https?:\/\//i.test(url || '')) return null;
        if ((m = url.match(/(?:youtube(?:-nocookie)?\.com\/(?:watch\?(?:.*&)?v=|embed\/|shorts\/|live\/)|youtu\.be\/)([A-Za-z0-9_-]{6,20})/))) return 'https://www.youtube-nocookie.com/embed/' + m[1];
        if ((m = url.match(/vimeo\.com\/(?:video\/)?(\d{5,12})/))) return 'https://player.vimeo.com/video/' + m[1];
        if ((m = url.match(/(?:dailymotion\.com\/(?:embed\/)?video\/|dai\.ly\/)([A-Za-z0-9]{5,12})/))) return 'https://www.dailymotion.com/embed/video/' + m[1];
        return null;
    }

    function updateMediaUi() {
        var isVideo = $('input[name="featured_media_type"]:checked').val() === 'video';
        var source = $('input[name="video_source"]:checked').val();
        $('#beVideoSection').toggle(isVideo);
        $('#beCoverVideoNote').toggle(isVideo);
        $('#beVideoUrlBox').toggle(source === 'url');
        $('#beVideoFileBox').toggle(source === 'file');

        var embed = embedUrl($('#beVideoUrl').val().trim());
        var $frame = $('#beVideoEmbedPreview iframe');
        if (embed && $frame.attr('src') !== embed) $frame.attr('src', embed);
        $('#beVideoEmbedPreview').toggle(!!embed);
    }

    function uploadFile(file, type) {
        var $progress = $('[data-progress="' + type + '"]').show();
        var $bar = $progress.find('span').css('width', '0');
        var $field = $form.find('[data-field="' + (type === 'image' ? 'featured_image' : 'featured_video') + '"]');
        var fd = new FormData();
        fd.append('file', file);
        fd.append('type', type);
        $field.removeClass('is-invalid');

        return $.ajax({
            url: URLS.upload, type: 'POST', data: fd, processData: false, contentType: false, dataType: 'json',
            xhr: function () {
                var xhr = $.ajaxSettings.xhr();
                if (xhr.upload) xhr.upload.addEventListener('progress', function (e) {
                    if (e.lengthComputable) $bar.css('width', Math.round(e.loaded / e.total * 100) + '%');
                });
                return xhr;
            }
        }).always(function () {
            $progress.hide();
        }).fail(function (xhr) {
            var msg = xhr.status === 422 && xhr.responseJSON.errors
                ? Object.values(xhr.responseJSON.errors)[0][0]
                : (xhr.status === 413 ? 'The file is too large for the server.' : errorText(xhr, 'Upload failed.'));
            $field.addClass('is-invalid').find('.be-error').text(msg);
        });
    }

    $form.on('click', '.be-upload-trigger', function () {
        uploadType = $(this).data('type');
        $('#beFileInput').attr('accept', uploadType === 'image' ? 'image/jpeg,image/png,image/gif,image/webp' : 'video/mp4,video/webm,video/ogg,video/quicktime').val('').trigger('click');
    });

    $('#beFileInput').on('change', function () {
        if (!this.files.length) return;
        handleFile(this.files[0], uploadType);
    });

    function handleFile(file, type) {
        uploadFile(file, type).done(function (res) {
            if (type === 'image') {
                setImage(res.path, res.url);
                if (!$('#beImageAlt').val()) $('#beImageAlt').val($title.val().trim());
            } else {
                setVideoFile(res.path, res.url);
            }
            markChanged();
        });
    }

    $form.on('dragover dragenter', '.be-dropzone', function (e) { e.preventDefault(); $(this).addClass('is-over'); })
        .on('dragleave drop', '.be-dropzone', function () { $(this).removeClass('is-over'); })
        .on('drop', '.be-dropzone', function (e) {
            e.preventDefault();
            var files = e.originalEvent.dataTransfer.files;
            if (files.length) handleFile(files[0], $(this).data('drop'));
        });

    $('#beImageRemove').on('click', function () { setImage(null); markChanged(); });
    $('#beVideoRemove').on('click', function () { setVideoFile(null); markChanged(); });
    $form.on('change', 'input[name="featured_media_type"], input[name="video_source"]', updateMediaUi);
    $('#beVideoUrl').on('input', updateMediaUi);
    $('#beImageAlt').on('input', function () { $('#beImagePreview').attr('alt', this.value); });

    // Media library
    var libraryPage = 1;

    function loadLibrary(reset) {
        if (reset) { libraryPage = 1; $('#beLibraryGrid').empty(); }
        $.get(URLS.library, { page: libraryPage }).done(function (res) {
            $.each(res.items, function (_, item) {
                $('<button type="button" class="be-library-item">')
                    .attr({ 'data-path': item.path, 'data-url': item.url, title: item.name })
                    .append($('<img loading="lazy">').attr({ src: item.url, alt: item.name }))
                    .appendTo('#beLibraryGrid');
            });
            $('#beLibraryEmpty').toggle(libraryPage === 1 && !res.items.length);
            $('#beLibraryMore').toggle(res.has_more);
        });
    }

    $form.on('click', '.be-open-library', function () {
        loadLibrary(true);
        $('#beLibraryModal').modal('show');
    });
    $('#beLibraryMore').on('click', function () { libraryPage++; loadLibrary(false); });
    $('#beLibraryGrid').on('click', '.be-library-item', function () {
        setImage($(this).data('path'), $(this).data('url'));
        $('#beLibraryModal').modal('hide');
        markChanged();
    });

    /* ------------------------------------------------------------------ location */

    function fillSelect($select, url, params, emptyLabel, disabledLabel, selected) {
        var key = Object.keys(params)[0];
        if (!params[key]) {
            $select.html($('<option value="">').text(disabledLabel)).prop('disabled', true);
            return $.Deferred().resolve().promise();
        }
        $select.html($('<option value="">').text('Loading…')).prop('disabled', true);
        return $.get(url, params).done(function (items) {
            $select.html($('<option value="">').text(emptyLabel));
            $.each(items, function (_, item) {
                $select.append($('<option>', { value: item.id, text: item.name, selected: String(item.id) === String(selected) }));
            });
            $select.prop('disabled', false);
        });
    }

    function loadStates(countryId, selected) {
        return fillSelect($('#beState'), URLS.states, { country_id: countryId }, 'Whole country', 'Select a country first', selected);
    }

    function loadCities(stateId, selected) {
        return fillSelect($('#beCity'), URLS.cities, { state_id: stateId }, 'Whole state', 'Select a state first', selected);
    }

    $('#beCountry').on('change', function () {
        locationReady.resolve(); // a manual choice replaces the stored location
        loadStates(this.value);
        loadCities('');
    });
    $('#beState').on('change', function () {
        locationReady.resolve();
        loadCities(this.value);
    });

    /* ------------------------------------------------------------------ SEO */

    function counter(id, value, good, warnMax) {
        var len = value.length;
        var cls = len === 0 ? '' : (len >= good[0] && len <= good[1] ? 'good' : (len <= warnMax ? 'warn' : 'bad'));
        $('[data-counter-for="' + id + '"]').attr('class', 'be-counter ' + cls).text(len + ' / ' + good[1]);
    }

    function updateCounters() {
        counter('beMetaTitle', $('#beMetaTitle').val(), [50, 60], 70);
        counter('beMetaDescription', $('#beMetaDescription').val(), [120, 160], 180);
        $('[data-counter-for="beExcerpt"]').text($('#beExcerpt').val().length ? $('#beExcerpt').val().length + ' chars' : '');
    }

    function updateSeoPreview() {
        var title = $('#beMetaTitle').val().trim() || $title.val().trim() || 'Your article title';
        var description = $('#beMetaDescription').val().trim() || $('#beExcerpt').val().trim() || stripHtml(editorContent()) || 'Add a meta description or an excerpt to control this text.';
        var slug = $slug.val().trim() || 'your-article-url';
        var base = URLS.blogBase.replace(/^https?:\/\//, '').replace(/\/$/, '');

        $('#beMetaTitle').attr('placeholder', $title.val().trim() || 'Defaults to the article title');
        $('#beMetaDescription').attr('placeholder', truncate($('#beExcerpt').val().trim() || stripHtml(editorContent()), 160) || 'Defaults to the excerpt');
        $('#beSerpUrl').text(base.replace(/\//g, ' › ') + ' › ' + slug);
        $('#beSerpTitle').text(truncate(title, 60));
        $('#beSerpDesc').text(truncate(description, 160));
        $('#beSocialTitle').text(title);
        $('#beSocialDesc').text(description);
    }

    /* ------------------------------------------------------------------ insights: stats, outline, health */

    var HEALTH_COLORS = { good: '#16a34a', ok: '#d97706', poor: '#dc2626' };

    function refreshInsights(payload) {
        payload = payload || collect();
        var body = state.editor ? state.editor.getBody() : null;
        var text = stripHtml(payload.content);
        var words = text ? text.split(/\s+/).length : 0;
        var headings = body ? Array.prototype.slice.call(body.querySelectorAll('h2, h3, h4')) : [];
        var images = body ? Array.prototype.slice.call(body.querySelectorAll('img')) : [];
        var links = body ? body.querySelectorAll('a[href]').length : 0;
        var missingAlt = images.filter(function (img) { return !(img.getAttribute('alt') || '').trim(); }).length;

        // Stats bar
        $('[data-stat="words"]').text(words.toLocaleString());
        $('[data-stat="chars"]').text(text.length.toLocaleString());
        $('[data-stat="minutes"]').text(Math.max(1, Math.ceil(words / 200)));
        $('[data-stat="headings"]').text(headings.length);
        $('[data-stat="links"]').text(links);
        $('[data-stat="images"]').text(images.length);

        // Outline
        state.headings = headings;
        var $outline = $('#beOutline').empty();
        var previous = 1;
        var skipped = false;
        headings.forEach(function (h, i) {
            var level = parseInt(h.tagName.substring(1), 10);
            var skip = level > previous + 1 && i > 0 || (i === 0 && level > 2);
            skipped = skipped || skip;
            previous = level;
            $('<li>').addClass('lvl-' + level + (skip ? ' skip' : '')).append(
                $('<button type="button">').attr({ 'data-heading': i, title: skip ? 'Heading level skipped' : '' }).text(h.textContent.trim() || '(empty heading)')
            ).appendTo($outline);
        });
        $('#beOutlineEmpty').toggle(!headings.length);
        $('#beOutlineHint').text(headings.length ? headings.length + ' heading' + (headings.length > 1 ? 's' : '') : '');

        // Health checks: good = 1 point, warn = half a point
        var titleLen = payload.title.length;
        var metaLen = (payload.meta_description || '').trim().length;
        var h2Count = headings.filter(function (h) { return h.tagName === 'H2'; }).length;
        var checks = [
            { status: titleLen >= 20 && titleLen <= 70 ? 'good' : (titleLen ? 'warn' : 'bad'), label: 'Title length: ' + titleLen + ' characters (aim for 20–70)', fix: '#beTitle' },
            { status: words >= 300 ? 'good' : (words >= 100 ? 'warn' : 'bad'), label: words.toLocaleString() + ' words' + (words < 300 ? ' — aim for at least 300' : ''), fix: 'editor' },
            { status: h2Count ? 'good' : (words >= 300 ? 'bad' : 'warn'), label: h2Count ? 'Uses subheadings to structure the text' : 'Add H2 subheadings to break up the text', fix: 'editor' },
            { status: payload.featured_image ? 'good' : 'bad', label: payload.featured_image ? 'Featured image added' : 'Add a featured image', fix: 'panel:media' }
        ];
        if (payload.featured_image) {
            checks.push({ status: payload.featured_image_alt.trim() ? 'good' : 'bad', label: 'Featured image alt text', fix: '#beImageAlt' });
        }
        if (images.length) {
            checks.push({ status: missingAlt ? 'warn' : 'good', label: missingAlt ? missingAlt + ' image(s) in the article without alt text' : 'All article images have alt text', fix: 'editor' });
        }
        checks.push(
            { status: payload.categories.length ? 'good' : 'bad', label: payload.categories.length ? 'Category assigned' : 'Assign at least one category', fix: 'panel:categories' },
            { status: payload.excerpt.trim() ? 'good' : 'warn', label: payload.excerpt.trim() ? 'Excerpt written' : 'Write an excerpt for listings', fix: '#beExcerpt' },
            { status: metaLen >= 120 && metaLen <= 160 ? 'good' : 'warn', label: metaLen ? 'Meta description: ' + metaLen + ' characters (aim for 120–160)' : 'No meta description — the excerpt is used', fix: '#beMetaDescription' },
            { status: links ? 'good' : 'warn', label: links ? links + ' link(s) in the article' : 'Add at least one helpful link', fix: 'editor' },
            { status: skipped ? 'warn' : 'good', label: skipped ? 'Heading levels skip a step (see Outline)' : 'Heading levels are in order', fix: 'panel:outline' }
        );

        var points = checks.reduce(function (sum, c) { return sum + (c.status === 'good' ? 1 : (c.status === 'warn' ? 0.5 : 0)); }, 0);
        var score = Math.round(points / checks.length * 100);
        var level = score >= 80 ? 'good' : (score >= 50 ? 'ok' : 'poor');
        var icons = { good: 'fa-circle-check', warn: 'fa-circle-exclamation', bad: 'fa-circle-xmark' };

        var $checks = $('#beChecks').empty();
        checks.forEach(function (c) {
            var $li = $('<li>').addClass(c.status).append(
                $('<span class="be-check-icon">').html('<i class="fa ' + icons[c.status] + '"></i>'),
                $('<span>').text(c.label)
            );
            if (c.status !== 'good') {
                $li.append($('<button type="button" class="be-link-btn be-fix">').attr('data-fix', c.fix).text('Fix'));
            }
            $checks.append($li);
        });

        $('#beHealthRing').css({ '--p': score, '--c': HEALTH_COLORS[level] });
        $('#beHealthScore').text(score);
        $('#beHealthLabel').text({ good: 'Looking great', ok: 'Almost there', poor: 'Needs some work' }[level]);
        $('#beHealthHint').text(score + '%');

        state.healthIssues = checks.filter(function (c) { return c.status === 'bad'; }).map(function (c) { return c.label; });
    }

    $('#beChecks').on('click', '.be-fix', function () {
        var fix = $(this).data('fix');
        if (fix === 'editor') {
            if (state.editor) state.editor.focus();
            $('html, body').animate({ scrollTop: $('.be-editor-wrap').offset().top - 160 }, 250);
        } else if (fix.indexOf('panel:') === 0) {
            var $panel = $('[data-panel="' + fix.slice(6) + '"]').attr('open', true);
            $panel[0].scrollIntoView({ behavior: 'smooth', block: 'start' });
            $panel.find('summary').trigger('focus');
        } else {
            var $el = $(fix);
            $el.closest('details').attr('open', true);
            $el.trigger('focus');
            $el[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });

    $('#beOutline').on('click', 'button', function () {
        var node = (state.headings || [])[$(this).data('heading')];
        if (!node || !state.editor) return;
        state.editor.selection.select(node, true);
        state.editor.selection.collapse(false);
        state.editor.focus();
        var frameTop = state.editor.iframeElement.getBoundingClientRect().top + window.pageYOffset;
        window.scrollTo({ top: frameTop + node.offsetTop - 170, behavior: 'smooth' });
    });

    /* ------------------------------------------------------------------ writing helpers */

    $('#beExcerptGenerate').on('click', function () {
        // Paragraph text only, so headings and list labels don't leak into the summary.
        var body = state.editor ? state.editor.getBody() : null;
        var text = body
            ? Array.prototype.map.call(body.querySelectorAll('p'), function (p) { return p.textContent.trim(); }).filter(Boolean).join(' ')
            : stripHtml(editorContent());
        if (!text) {
            Swal.fire({ toast: true, position: 'top-end', icon: 'info', title: 'Write some content first', showConfirmButton: false, timer: 2000 });
            return;
        }
        var excerpt = '';
        (text.match(/[^.!?]+[.!?]+(\s|$)|[^.!?]+$/g) || [text]).some(function (sentence) {
            var next = (excerpt + ' ' + sentence.trim()).trim();
            if (excerpt && next.length > 200) return true;
            excerpt = next;
            return excerpt.length >= 120;
        });
        $('#beExcerpt').val(truncate(excerpt, 300)).trigger('input');
    });

    $('#beCopyLink').on('click', function () {
        var url = URLS.blogBase + ($slug.val().trim() || slugify($title.val()));
        var done = function () { Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Link copied', showConfirmButton: false, timer: 1500 }); };
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(url).then(done);
        } else {
            var input = $('<input>').val(url).appendTo('body').select();
            document.execCommand('copy');
            input.remove();
            done();
        }
    });

    function setFocusMode(on) {
        $('body').toggleClass('be-focus', on);
        $('#beFocusToggle').attr('aria-pressed', on ? 'true' : 'false')
            .find('i').attr('class', 'fa ' + (on ? 'fa-compress' : 'fa-expand'));
        storage(function (s) { s.setItem('blog-editor-focus', on ? '1' : '0'); });
    }

    $('#beFocusToggle').on('click', function () { setFocusMode(!$('body').hasClass('be-focus')); });
    $(document).on('keydown', function (e) {
        if (e.key === 'Escape' && $('body').hasClass('be-focus') && !$('.swal2-container').length) setFocusMode(false);
    });
    if (storage(function (s) { return s.getItem('blog-editor-focus'); }) === '1') setFocusMode(true);

    $('#beMetaTitle, #beMetaDescription, #beExcerpt').on('input', function () { updateCounters(); updateSeoPreview(); });

    /* ------------------------------------------------------------------ change tracking */

    $form.on('input change', 'input, textarea, select', function (e) {
        if (e.target.id === 'beFileInput' || e.target.id === 'beCategorySearch') return;
        markChanged();
    });

    window.addEventListener('beforeunload', function (e) {
        if (!state.dirty && !state.saving) return;
        writeBackup();
        e.preventDefault();
        e.returnValue = '';
    });

    $(document).on('keydown', function (e) {
        if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 's') {
            e.preventDefault();
            saveShortcut();
        }
    });

    function saveShortcut() {
        var live = state.effectiveStatus === 'published' || state.effectiveStatus === 'scheduled';
        live ? publish() : save('draft', 'manual');
    }

    /* ------------------------------------------------------------------ editor */

    function uploadForEditor(file, type) {
        var fd = new FormData();
        fd.append('file', file);
        fd.append('type', type);
        return $.ajax({ url: URLS.upload, type: 'POST', data: fd, processData: false, contentType: false, dataType: 'json' });
    }

    tinymce.init({
        selector: '#beContent',
        min_height: 560,
        max_height: 2000,
        menubar: false,
        branding: false,
        toolbar_sticky: true,
        toolbar_sticky_offset: 150,
        toolbar_mode: 'sliding',
        plugins: 'advlist autolink autoresize lists link image media table hr charmap codesample searchreplace visualblocks wordcount fullscreen code paste quickbars textpattern help template emoticons',
        toolbar: 'undo redo | formatselect styleselect | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | blockquote link image media table hr codesample | template emoticons charmap | removeformat | searchreplace fullscreen code help',
        block_formats: 'Paragraph=p; Heading 2=h2; Heading 3=h3; Heading 4=h4; Preformatted=pre',
        // "Styles" menu: designed blocks that the public article page styles too.
        style_formats: [
            { title: 'Callout – Info', block: 'div', classes: 'blog-callout', wrapper: true },
            { title: 'Callout – Tip', block: 'div', classes: 'blog-callout blog-callout-tip', wrapper: true },
            { title: 'Callout – Warning', block: 'div', classes: 'blog-callout blog-callout-warning', wrapper: true },
            { title: 'Lead paragraph', selector: 'p', classes: 'blog-lead' },
            { title: 'Highlight', inline: 'mark' },
            { title: 'Button link', selector: 'a', classes: 'blog-btn' }
        ],
        templates: [
            {
                title: 'How-to guide',
                description: 'Intro, what you need, numbered steps, a tip and a conclusion.',
                content: '<h2>Introduction</h2><p>Explain what the reader will achieve.</p><h2>What you need</h2><ul><li>Item one</li><li>Item two</li></ul><h2>Step-by-step</h2><ol><li><strong>Step one:</strong> describe it.</li><li><strong>Step two:</strong> describe it.</li><li><strong>Step three:</strong> describe it.</li></ol><div class="blog-callout blog-callout-tip"><p><strong>Tip:</strong> share a useful shortcut.</p></div><h2>Conclusion</h2><p>Wrap up and invite the reader to act.</p>'
            },
            {
                title: 'Top list',
                description: 'A numbered "Top 5" article with a short intro and final thoughts.',
                content: '<p class="blog-lead">Hook the reader with one strong opening sentence.</p><h2>1. First pick</h2><p>Why it made the list.</p><h2>2. Second pick</h2><p>Why it made the list.</p><h2>3. Third pick</h2><p>Why it made the list.</p><h2>4. Fourth pick</h2><p>Why it made the list.</p><h2>5. Fifth pick</h2><p>Why it made the list.</p><h2>Final thoughts</h2><p>Summarise the list.</p>'
            },
            {
                title: 'Pros & cons table',
                description: 'A two-column comparison table.',
                content: '<h2>Pros and cons</h2><table style="border-collapse: collapse; width: 100%;" border="1"><thead><tr><th>Pros</th><th>Cons</th></tr></thead><tbody><tr><td>Advantage</td><td>Drawback</td></tr><tr><td>Advantage</td><td>Drawback</td></tr></tbody></table><p></p>'
            },
            {
                title: 'FAQ section',
                description: 'Frequently asked questions with answers.',
                content: '<h2>Frequently asked questions</h2><h3>First question?</h3><p>Answer.</p><h3>Second question?</h3><p>Answer.</p><h3>Third question?</h3><p>Answer.</p>'
            }
        ],
        quickbars_selection_toolbar: 'bold italic underline | quicklink h2 h3 blockquote | forecolor',
        quickbars_insert_toolbar: 'quickimage quicktable hr template',
        contextmenu: 'link image table',
        placeholder: 'Start writing your story…',
        // Links
        link_assume_external_targets: 'https',
        link_context_toolbar: true,
        link_title: false,
        link_target_list: [{ title: 'Same tab', value: '' }, { title: 'New tab', value: '_blank' }],
        rel_list: [{ title: 'Default', value: '' }, { title: 'No follow', value: 'nofollow' }, { title: 'Sponsored', value: 'nofollow sponsored' }],
        default_link_target: '',
        // Images & media
        image_caption: true,
        image_title: false,
        image_dimensions: true,
        image_description: true,
        image_advtab: false,
        object_resizing: 'img,video,iframe',
        automatic_uploads: true,
        paste_data_images: true,
        images_reuse_filename: false,
        file_picker_types: 'image media',
        images_upload_handler: function (blobInfo, success, failure) {
            uploadForEditor(blobInfo.blob(), 'image')
                .done(function (res) { success(res.location); })
                .fail(function (xhr) {
                    var msg = xhr.status === 422 && xhr.responseJSON.errors ? Object.values(xhr.responseJSON.errors)[0][0] : 'Image upload failed.';
                    failure(msg, { remove: true });
                });
        },
        file_picker_callback: function (callback, value, meta) {
            var input = document.createElement('input');
            input.type = 'file';
            input.accept = meta.filetype === 'image' ? 'image/jpeg,image/png,image/gif,image/webp' : 'video/mp4,video/webm,video/ogg,video/quicktime';
            input.onchange = function () {
                var file = input.files[0];
                if (!file) return;
                var editor = tinymce.activeEditor;
                editor.setProgressState(true);
                uploadForEditor(file, meta.filetype === 'image' ? 'image' : 'video')
                    .done(function (res) { callback(res.location, meta.filetype === 'image' ? { alt: '' } : {}); })
                    .fail(function (xhr) {
                        var msg = xhr.status === 422 && xhr.responseJSON.errors ? Object.values(xhr.responseJSON.errors)[0][0] : 'Upload failed.';
                        editor.notificationManager.open({ text: msg, type: 'error', timeout: 4000 });
                    })
                    .always(function () { editor.setProgressState(false); });
            };
            input.click();
        },
        media_live_embeds: true,
        media_alt_source: false,
        media_poster: false,
        // Root-relative URLs keep content portable between environments.
        relative_urls: false,
        remove_script_host: true,
        convert_urls: true,
        invalid_elements: 'script,style,object,embed,form,input,button,textarea,select',
        table_default_attributes: { border: '1' },
        table_default_styles: { 'border-collapse': 'collapse', width: '100%' },
        codesample_languages: [
            { text: 'HTML/XML', value: 'markup' }, { text: 'JavaScript', value: 'javascript' }, { text: 'CSS', value: 'css' },
            { text: 'PHP', value: 'php' }, { text: 'Python', value: 'python' }, { text: 'Bash', value: 'bash' }
        ],
        content_style:
            'body{font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif;font-size:17px;line-height:1.75;color:#1f2937;max-width:760px;margin:24px auto;padding:0 20px}' +
            'h2{font-size:1.6em;margin:1.4em 0 .5em;line-height:1.3}h3{font-size:1.3em;margin:1.3em 0 .5em}h4{font-size:1.1em;margin:1.2em 0 .4em}' +
            'p{margin:0 0 1.1em}a{color:#bc1212}img,video{max-width:100%;height:auto}iframe{max-width:100%}' +
            'blockquote{border-left:4px solid #bc1212;margin:1.5em 0;padding:.4em 1.2em;color:#4b5563;background:#fafafa}' +
            'figure.image{display:inline-block;margin:1em 0}figure.image figcaption{font-size:.85em;color:#6b7280;text-align:center;padding-top:6px}' +
            'table{border-collapse:collapse}td,th{border:1px solid #d1d5db;padding:6px 10px}' +
            'pre{background:#111827;color:#f9fafb;padding:14px;border-radius:8px;overflow:auto;font-size:14px}' +
            'hr{border:0;border-top:2px solid #e5e7eb;margin:2em 0}' +
            '.blog-callout{border-left:4px solid #2563eb;background:#eff6ff;border-radius:8px;padding:12px 16px;margin:1.4em 0}' +
            '.blog-callout-tip{border-color:#16a34a;background:#f0fdf4}.blog-callout-warning{border-color:#d97706;background:#fffbeb}' +
            '.blog-callout p:last-child{margin-bottom:0}.blog-lead{font-size:1.2em;color:#374151}' +
            'mark{background:#fde68a;padding:0 3px}a.blog-btn{display:inline-block;background:#bc1212;color:#fff;padding:8px 18px;border-radius:999px;text-decoration:none;font-weight:600}',
        setup: function (editor) {
            editor.on('init', function () {
                state.editor = editor;
                $('#beEditorLoading').remove();
                // Baseline = what the server has, read back through the editor so it compares
                // cleanly with later collect() calls (location comes from the stored ids).
                state.lastSnapshot = initial.id ? snapshot(collect()) : null;
                state.dirty = false;
                setSaveState('idle', initial.id ? 'All changes saved' : 'Not saved yet');
                updateSeoPreview();
                refreshInsights();
                offerBackupRestore();
            });
            editor.on('input Undo Redo ExecCommand change', function (e) {
                if (e.type === 'execcommand' && /^(mceFocus|mceAutoResize|mceToggleFormat_?)$/i.test(e.command || '')) return;
                markChanged();
                if (e.type !== 'input') updateSeoPreview();
            });
            editor.on('blur', updateSeoPreview);
            editor.addShortcut('meta+s', 'Save', saveShortcut);
        }
    });

    /* ------------------------------------------------------------------ init */

    autosizeTitle();
    updateTitleCount();
    setImage($('#beFeaturedImage').val(), initial.featured_image_url);
    setVideoFile($('#beFeaturedVideo').val(), initial.featured_video_file_url);
    renderChips();
    updateMediaUi();
    updateCounters();
    refreshToolbar();
    setSaveState('idle', 'Loading…');

    if (initial.country_id) {
        loadStates(initial.country_id, initial.state_id).then(function () {
            return initial.state_id ? loadCities(initial.state_id, initial.city_id) : null;
        }).always(locationReady.resolve);
    } else {
        locationReady.resolve();
    }

    if (!initial.id) $title.trigger('focus');
});
</script>
@endpush
