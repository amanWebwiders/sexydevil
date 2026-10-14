@extends('admin.layout.layout')
@section('content')

<style>
    .category-name-text {
        font-weight: 600;
        color: #111827;
        font-size: 14px;
    }
    .category-desc-preview {
        font-size: 13px;
        color: #4b5563;
        max-width: 320px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        word-break: break-word;
        line-height: 1.5;
    }
    .badge-slug {
        background: #f3f4f6;
        color: #374151;
        border: 1px solid #e5e7eb;
        border-radius: 4px;
        padding: 3px 8px;
        font-size: 12px;
        font-family: monospace;
    }
    .badge-robots {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
        border-radius: 4px;
        padding: 3px 8px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }
    .table td {
        color: #1f2937;
        vertical-align: middle;
    }
    .form-switch .form-check-input {
        cursor: pointer;
        width: 2.5em;
        height: 1.3em;
    }
    /* Keep header/footer fixed and scroll only the form fields */
    #categoryModal .modal-body {
        max-height: calc(100vh - 210px);
        overflow-y: auto;
    }
    .form-section-title {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
        color: #bc1212;
        border-bottom: 1px solid #f3f4f6;
        padding-bottom: 6px;
        margin-bottom: 14px;
    }
</style>

<div id="content" class="app-content">
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <div>
            <a href="{{ route('admin.blogs.index') }}" class="small text-decoration-none"><i class="fa fa-arrow-left me-1"></i> Blogs</a>
            <h3 class="page-header mb-0">Blog Category Management</h3>
            <small class="text-muted">Manage blog categories and their SEO settings</small>
        </div>
        <div>
            <button type="button" class="btn btn-primary d-flex align-items-center gap-2" id="addCategoryBtn">
                <i class="fa fa-plus"></i> Add New Category
            </button>
        </div>
    </div>

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card p-4 mb-4">
        <!-- Search & Filter Bar -->
        <form method="GET" action="{{ route('admin.blog-categories.index') }}" class="row g-3 mb-3">
            <div class="col-md-7">
                <div class="input-group">
                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search name, slug or description..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-secondary w-100">Filter</button>
                @if(request()->hasAny(['search', 'status']))
                    <a href="{{ route('admin.blog-categories.index') }}" class="btn btn-outline-secondary">Reset</a>
                @endif
            </div>
        </form>

        <!-- Categories Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 60px;">#</th>
                        <th>Category Name</th>
                        <th>Slug</th>
                        <th>Description</th>
                        <th style="width: 150px;">Robots</th>
                        <th style="width: 110px;" class="text-center">Status</th>
                        <th style="width: 140px;" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($blogCategories as $key => $category)
                    <tr id="category-row-{{ $category->id }}">
                        <td>{{ $blogCategories->firstItem() + $key }}</td>
                        <td>
                            <div class="category-name-text">{{ $category->name }}</div>
                        </td>
                        <td>
                            <span class="badge-slug">{{ $category->slug }}</span>
                        </td>
                        <td>
                            <div class="category-desc-preview" title="{{ $category->description }}">{{ $category->description ?: '—' }}</div>
                        </td>
                        <td>
                            <span class="badge-robots">{{ $category->robots }}</span>
                        </td>
                        <td class="text-center">
                            <div class="form-check form-switch d-inline-block">
                                <input class="form-check-input status-toggle" type="checkbox"
                                       data-id="{{ $category->id }}"
                                       {{ $category->status == 1 ? 'checked' : '' }}>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" class="btn btn-sm btn-primary edit-category-btn"
                                        data-id="{{ $category->id }}"
                                        title="Edit Category">
                                    <i class="fa fa-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger delete-category-btn"
                                        data-id="{{ $category->id }}"
                                        title="Delete Category">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="fa fa-folder-open fa-2x mb-2 d-block opacity-50"></i>
                            No blog categories found. Click "Add New Category" to create one.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
            <div class="text-muted small">
                Showing <strong>{{ $blogCategories->firstItem() ?? 0 }}</strong> to <strong>{{ $blogCategories->lastItem() ?? 0 }}</strong> of <strong>{{ $blogCategories->total() }}</strong> categories
            </div>
            @if($blogCategories->hasPages())
            <div>
                {{ $blogCategories->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- ADD / EDIT CATEGORY MODAL -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-dark" id="categoryModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="categoryForm">
                @csrf
                <input type="hidden" id="category_id">
                <div class="modal-body text-dark">
                    <div class="form-section-title">Basic Details</div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-dark">Category Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" id="cat_name" placeholder="e.g. Lifestyle" maxlength="255" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-dark">Slug <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="slug" id="cat_slug" placeholder="e.g. lifestyle" maxlength="255" required>
                            <small class="text-muted">Auto-filled from name. Lowercase letters, numbers and hyphens only.</small>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Description</label>
                        <textarea class="form-control" name="description" id="cat_description" rows="3" placeholder="Short description of this category..."></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold text-dark">Status <span class="text-danger">*</span></label>
                            <select class="form-select" name="status" id="cat_status" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-section-title mt-2">SEO Settings</div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Meta Title</label>
                        <input type="text" class="form-control" name="meta_title" id="cat_meta_title" maxlength="255" placeholder="SEO title for the category page">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Meta Description</label>
                        <textarea class="form-control" name="meta_description" id="cat_meta_description" rows="3" placeholder="SEO description for the category page"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Meta Keywords</label>
                        <textarea class="form-control" name="meta_keywords" id="cat_meta_keywords" rows="2" placeholder="keyword one, keyword two, keyword three"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Canonical URL</label>
                        <input type="url" class="form-control" name="canonical_url" id="cat_canonical_url" maxlength="500" placeholder="https://example.com/blog/category/lifestyle">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-dark">Index / Noindex <span class="text-danger">*</span></label>
                            <select class="form-select" name="robots_index" id="cat_robots_index" required>
                                <option value="index">Index</option>
                                <option value="noindex">Noindex</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-dark">Follow / Nofollow <span class="text-danger">*</span></label>
                            <select class="form-select" name="robots_follow" id="cat_robots_follow" required>
                                <option value="follow">Follow</option>
                                <option value="nofollow">Nofollow</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveCategoryBtn"></button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // CSRF Token setup for AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var $form = $('#categoryForm');
    var $saveBtn = $('#saveCategoryBtn');
    var slugEdited = false;

    function slugify(text) {
        return text.toString().toLowerCase().trim()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/[\s_-]+/g, '-')
            .replace(/^-+|-+$/g, '');
    }

    function errorMessage(err, fallback) {
        var res = err.responseJSON;
        if (res && res.errors) {
            return Object.values(res.errors).map(function(m) { return m[0]; }).join('<br>');
        }
        return res && res.message ? res.message : fallback;
    }

    function openModal(mode) {
        var isEdit = mode === 'edit';
        $('#categoryModalLabel').html(isEdit
            ? '<i class="fa fa-pencil me-2 text-danger"></i>Edit Blog Category'
            : '<i class="fa fa-plus-circle me-2 text-danger"></i>Add New Blog Category');
        $saveBtn.prop('disabled', false).text(isEdit ? 'Update Category' : 'Save Category');
        $('#categoryModal').modal('show');
    }

    // Auto-generate slug from name until the slug is edited by hand
    $('#cat_name').on('input', function() {
        if (!slugEdited) {
            $('#cat_slug').val(slugify($(this).val()));
        }
    });
    $('#cat_slug').on('input', function() {
        slugEdited = $(this).val() !== '';
    }).on('blur', function() {
        $(this).val(slugify($(this).val()));
    });

    // 1. OPEN ADD MODAL
    $('#addCategoryBtn').on('click', function() {
        $form[0].reset();
        $('#category_id').val('');
        slugEdited = false;
        openModal('add');
    });

    // 2. OPEN EDIT MODAL
    $(document).on('click', '.edit-category-btn', function() {
        var id = $(this).data('id');
        var editUrl = "{{ route('admin.blog-categories.edit', ':id') }}".replace(':id', id);

        $.get(editUrl, function(res) {
            if (res.status == 1) {
                var c = res.data;
                $form[0].reset();
                $('#category_id').val(c.id);
                $('#cat_name').val(c.name);
                $('#cat_slug').val(c.slug);
                $('#cat_description').val(c.description);
                $('#cat_status').val(c.status);
                $('#cat_meta_title').val(c.meta_title);
                $('#cat_meta_description').val(c.meta_description);
                $('#cat_meta_keywords').val(c.meta_keywords);
                $('#cat_canonical_url').val(c.canonical_url);
                $('#cat_robots_index').val(c.robots_index);
                $('#cat_robots_follow').val(c.robots_follow);
                slugEdited = true;
                openModal('edit');
            }
        }).fail(function() {
            Swal.fire({ icon: 'error', title: 'Error', text: 'Unable to load category details.' });
        });
    });

    // 3. SUBMIT ADD / EDIT
    $form.on('submit', function(e) {
        e.preventDefault();
        var id = $('#category_id').val();
        var url = id
            ? "{{ route('admin.blog-categories.update', ':id') }}".replace(':id', id)
            : "{{ route('admin.blog-categories.store') }}";
        var data = $(this).serialize() + (id ? '&_method=PUT' : '');
        var btnText = $saveBtn.text();
        $saveBtn.prop('disabled', true).text(id ? 'Updating...' : 'Saving...');

        $.ajax({
            url: url,
            type: "POST",
            data: data,
            success: function(res) {
                $('#categoryModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: id ? 'Updated!' : 'Success!',
                    text: res.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(function() {
                    location.reload();
                });
            },
            error: function(err) {
                $saveBtn.prop('disabled', false).text(btnText);
                Swal.fire({ icon: 'error', title: 'Error', html: errorMessage(err, 'Failed to save category.') });
            }
        });
    });

    // 4. DELETE CATEGORY
    $(document).on('click', '.delete-category-btn', function() {
        var id = $(this).data('id');
        var deleteUrl = "{{ route('admin.blog-categories.destroy', ':id') }}".replace(':id', id);

        Swal.fire({
            title: 'Delete this category?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e41e3f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: deleteUrl,
                    type: 'POST',
                    data: { _method: 'DELETE' },
                    success: function(res) {
                        $('#category-row-' + id).fadeOut(300, function() { $(this).remove(); });
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: res.message,
                            timer: 1200,
                            showConfirmButton: false
                        });
                    },
                    error: function() {
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to delete category.' });
                    }
                });
            }
        });
    });

    // 5. STATUS TOGGLE
    $(document).on('change', '.status-toggle', function() {
        var id = $(this).data('id');
        var toggleUrl = "{{ route('admin.blog-categories.toggle-status', ':id') }}".replace(':id', id);
        var $checkbox = $(this);

        $.post(toggleUrl, function(res) {
            if (res.status == 1) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000
                });
                Toast.fire({ icon: 'success', title: res.message });
            }
        }).fail(function() {
            $checkbox.prop('checked', !$checkbox.prop('checked'));
            Swal.fire({ icon: 'error', title: 'Error', text: 'Could not change status.' });
        });
    });
});
</script>
@endpush
