@extends('admin.layout.layout')
@section('content')

<style>
    .faq-question-text {
        font-weight: 600;
        color: #111827;
        max-width: 320px;
        white-space: normal;
        word-break: break-word;
        font-size: 14px;
        line-height: 1.4;
    }
    .faq-answer-preview {
        font-size: 13px;
        color: #4b5563;
        max-width: 380px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        word-break: break-word;
        line-height: 1.5;
    }
    .badge-category {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
        border-radius: 4px;
        padding: 4px 10px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
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
</style>

<div id="content" class="app-content">
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <div>
            <h3 class="page-header mb-0">Frequently Asked Questions (FAQ)</h3>
            <small class="text-muted">Manage collapsible FAQs displayed on the website footer & FAQ page</small>
        </div>
        <div>
            <button type="button" class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#addFaqModal">
                <i class="fa fa-plus"></i> Add New FAQ
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
        <form method="GET" action="{{ route('admin.faqs.index') }}" class="row g-3 mb-3">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search question, answer or category..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    @foreach ($faqCategories ?? [] as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-secondary w-100">Filter</button>
                @if(request()->hasAny(['search', 'category', 'status']))
                    <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-secondary">Reset</a>
                @endif
            </div>
        </form>

        <!-- FAQs Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 60px;">#</th>
                        <th>Question</th>
                        <th>Answer</th>
                        <th style="width: 170px;">Category</th>
                        <th style="width: 80px;" class="text-center">Order</th>
                        <th style="width: 110px;" class="text-center">Status</th>
                        <th style="width: 140px;" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($faqs as $key => $faq)
                    <tr id="faq-row-{{ $faq->id }}">
                        <td>{{ $faqs->firstItem() + $key }}</td>
                        <td>
                            <div class="faq-question-text">{{ $faq->question }}</div>
                        </td>
                        <td>
                            <div class="faq-answer-preview" title="{{ $faq->answer }}">{{ $faq->answer }}</div>
                        </td>
                        <td>
                            <span class="badge-category">{{ $faq->category }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-secondary">{{ $faq->order }}</span>
                        </td>
                        <td class="text-center">
                            <div class="form-check form-switch d-inline-block">
                                <input class="form-check-input status-toggle" type="checkbox" 
                                       data-id="{{ $faq->id }}" 
                                       {{ $faq->status == 1 ? 'checked' : '' }}>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" class="btn btn-sm btn-primary edit-faq-btn" 
                                        data-id="{{ $faq->id }}" 
                                        title="Edit FAQ">
                                    <i class="fa fa-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger delete-faq-btn" 
                                        data-id="{{ $faq->id }}"
                                        title="Delete FAQ">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="fa fa-circle-question fa-2x mb-2 d-block opacity-50"></i>
                            No FAQs found. Click "Add New FAQ" to create one.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
            <div class="text-muted small">
                Showing <strong>{{ $faqs->firstItem() ?? 0 }}</strong> to <strong>{{ $faqs->lastItem() ?? 0 }}</strong> of <strong>{{ $faqs->total() }}</strong> FAQs
            </div>
            @if($faqs->hasPages())
            <div>
                {{ $faqs->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- ADD FAQ MODAL -->
<div class="modal fade" id="addFaqModal" tabindex="-1" aria-labelledby="addFaqModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-dark" id="addFaqModalLabel"><i class="fa fa-plus-circle me-2 text-danger"></i>Add New FAQ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addFaqForm">
                @csrf
                <div class="modal-body text-dark">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Question <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="question" placeholder="e.g. Who can advertise in our directory?" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-dark">Category</label>
                            <input type="text" class="form-control" name="category" list="categoryOptions" placeholder="e.g. For Advertisers" value="For Advertisers">
                            <datalist id="categoryOptions">
                                @foreach($faqCategories ?? [] as $cat)
                                    <option value="{{ $cat }}">
                                @endforeach
                                <option value="For Advertisers">
                                <option value="For Members and Visitors">
                                <option value="General">
                            </datalist>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold text-dark">Display Order</label>
                            <input type="number" class="form-control" name="order" value="0" min="0">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold text-dark">Status</label>
                            <select class="form-select" name="status">
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Answer <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="answer" rows="5" placeholder="Enter full FAQ response here..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveFaqBtn">Save FAQ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- EDIT FAQ MODAL -->
<div class="modal fade" id="editFaqModal" tabindex="-1" aria-labelledby="editFaqModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-dark" id="editFaqModalLabel"><i class="fa fa-pencil me-2 text-danger"></i>Edit FAQ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editFaqForm">
                @csrf
                <input type="hidden" name="faq_id" id="edit_faq_id">
                <div class="modal-body text-dark">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Question <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="question" id="edit_question" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-dark">Category</label>
                            <input type="text" class="form-control" name="category" id="edit_category" list="editCategoryOptions">
                            <datalist id="editCategoryOptions">
                                @foreach($faqCategories ?? [] as $cat)
                                    <option value="{{ $cat }}">
                                @endforeach
                                <option value="For Advertisers">
                                <option value="For Members and Visitors">
                                <option value="General">
                            </datalist>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold text-dark">Display Order</label>
                            <input type="number" class="form-control" name="order" id="edit_order" min="0">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold text-dark">Status</label>
                            <select class="form-select" name="status" id="edit_status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Answer <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="answer" id="edit_answer" rows="5" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="updateFaqBtn">Update FAQ</button>
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

    // 1. ADD FAQ
    $('#addFaqForm').on('submit', function(e) {
        e.preventDefault();
        var $btn = $('#saveFaqBtn');
        $btn.prop('disabled', true).text('Saving...');

        $.ajax({
            url: "{{ route('admin.faqs.store') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function(res) {
                $('#addFaqModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: res.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(function() {
                    location.reload();
                });
            },
            error: function(err) {
                $btn.prop('disabled', false).text('Save FAQ');
                var msg = err.responseJSON && err.responseJSON.message ? err.responseJSON.message : 'Failed to save FAQ.';
                Swal.fire({ icon: 'error', title: 'Error', text: msg });
            }
        });
    });

    // 2. OPEN EDIT MODAL
    $(document).on('click', '.edit-faq-btn', function() {
        var id = $(this).data('id');
        var editUrl = "{{ route('admin.faqs.edit', ':id') }}".replace(':id', id);

        $.get(editUrl, function(res) {
            if(res.status == 1) {
                var faq = res.data;
                $('#edit_faq_id').val(faq.id);
                $('#edit_question').val(faq.question);
                $('#edit_category').val(faq.category);
                $('#edit_order').val(faq.order);
                $('#edit_status').val(faq.status);
                $('#edit_answer').val(faq.answer);
                $('#editFaqModal').modal('show');
            }
        }).fail(function() {
            Swal.fire({ icon: 'error', title: 'Error', text: 'Unable to load FAQ details.' });
        });
    });

    // 3. SUBMIT EDIT FAQ
    $('#editFaqForm').on('submit', function(e) {
        e.preventDefault();
        var id = $('#edit_faq_id').val();
        var updateUrl = "{{ route('admin.faqs.update', ':id') }}".replace(':id', id);
        var $btn = $('#updateFaqBtn');
        $btn.prop('disabled', true).text('Updating...');

        $.ajax({
            url: updateUrl,
            type: "POST",
            data: $(this).serialize() + '&_method=PUT',
            success: function(res) {
                $('#editFaqModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Updated!',
                    text: res.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(function() {
                    location.reload();
                });
            },
            error: function(err) {
                $btn.prop('disabled', false).text('Update FAQ');
                var msg = err.responseJSON && err.responseJSON.message ? err.responseJSON.message : 'Failed to update FAQ.';
                Swal.fire({ icon: 'error', title: 'Error', text: msg });
            }
        });
    });

    // 4. DELETE FAQ
    $(document).on('click', '.delete-faq-btn', function() {
        var id = $(this).data('id');
        var deleteUrl = "{{ route('admin.faqs.destroy', ':id') }}".replace(':id', id);

        Swal.fire({
            title: 'Delete this FAQ?',
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
                        $('#faq-row-' + id).fadeOut(300, function() { $(this).remove(); });
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: res.message,
                            timer: 1200,
                            showConfirmButton: false
                        });
                    },
                    error: function() {
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to delete FAQ.' });
                    }
                });
            }
        });
    });

    // 5. STATUS TOGGLE
    $(document).on('change', '.status-toggle', function() {
        var id = $(this).data('id');
        var toggleUrl = "{{ route('admin.faqs.toggle-status', ':id') }}".replace(':id', id);
        var $checkbox = $(this);

        $.post(toggleUrl, function(res) {
            if(res.status == 1) {
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
