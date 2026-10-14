@extends('admin.layout.layout')
@section('content')

<style>
    .blog-section-card {
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        transition: box-shadow .2s ease, transform .2s ease;
    }
    .blog-section-card:hover {
        box-shadow: 0 6px 18px rgba(0, 0, 0, .08);
        transform: translateY(-2px);
    }
    .blog-section-icon {
        width: 52px;
        height: 52px;
        border-radius: 10px;
        background: #fef2f2;
        color: #bc1212;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }
</style>

<div id="content" class="app-content">
    <div class="mb-4">
        <h3 class="page-header mb-0">Blogs</h3>
        <small class="text-muted">Manage blog categories and content</small>
    </div>

    <div class="row g-4">
        <div class="col-md-6 col-xl-4">
            <div class="card blog-section-card p-4 h-100">
                <div class="d-flex align-items-start gap-3 mb-3">
                    <div class="blog-section-icon"><i class="fa fa-pen-nib"></i></div>
                    <div>
                        <h5 class="fw-bold text-dark mb-1">Blog Articles</h5>
                        <small class="text-muted">
                            {{ $blogStats['all'] }} total &middot; {{ $blogStats['published'] }} published &middot; {{ $blogStats['draft'] }} drafts
                        </small>
                    </div>
                </div>
                <p class="text-muted small mb-4">Write, schedule and publish articles with SEO, media and location settings.</p>
                <div class="d-flex gap-2 mt-auto">
                    <a href="{{ route('admin.blog-posts.index') }}" class="btn btn-primary flex-fill">
                        <i class="fa fa-newspaper me-1"></i> Blog Management
                    </a>
                    <a href="{{ route('admin.blog-posts.create') }}" class="btn btn-outline-primary" title="Write a new article">
                        <i class="fa fa-plus"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-4">
            <div class="card blog-section-card p-4 h-100">
                <div class="d-flex align-items-start gap-3 mb-3">
                    <div class="blog-section-icon"><i class="fa fa-folder-tree"></i></div>
                    <div>
                        <h5 class="fw-bold text-dark mb-1">Blog Categories</h5>
                        <small class="text-muted">
                            {{ $categoryStats['total'] }} total &middot; {{ $categoryStats['active'] }} active
                        </small>
                    </div>
                </div>
                <p class="text-muted small mb-4">Add, edit and remove blog categories along with their SEO settings.</p>
                <a href="{{ route('admin.blog-categories.index') }}" class="btn btn-primary mt-auto">
                    <i class="fa fa-list-check me-1"></i> Blog Category Management
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
