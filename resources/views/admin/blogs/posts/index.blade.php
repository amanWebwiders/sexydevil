@extends('admin.layout.layout')
@section('content')

<style>
    .btn.be-ghost { background: #fff !important; border: 1px solid #d1d5db !important; color: #374151 !important; }
    .btn.be-ghost:hover, .btn.be-ghost:focus-visible { background: #fef2f2 !important; border-color: #bc1212 !important; color: #bc1212 !important; }
    .btn.be-ghost.be-danger { color: #dc2626 !important; }
    .btn.be-ghost.be-success { color: #16a34a !important; }
    .bp-status-tabs { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 18px; }
    .bp-status-tab {
        border: 1px solid #e5e7eb; background: #fff; color: #374151; border-radius: 999px;
        padding: 6px 14px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all .15s ease;
    }
    .bp-status-tab:hover { border-color: #bc1212; color: #bc1212; }
    .bp-status-tab.active { background: #bc1212; border-color: #bc1212; color: #fff; }
    .bp-status-tab .bp-count { opacity: .75; font-weight: 500; margin-left: 4px; }
    .bp-filters .form-label { font-size: 12px; font-weight: 600; color: #6b7280; margin-bottom: 4px; }
    /* Card grid */
    .bp-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(270px, 1fr)); gap: 20px; }
    .bp-card {
        background: #fff; border: 1px solid #e5e7eb; border-radius: 14px; overflow: hidden;
        display: flex; flex-direction: column; transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
    }
    .bp-card:hover { transform: translateY(-3px); box-shadow: 0 12px 28px rgba(17, 24, 39, .10); border-color: #fecaca; }
    .bp-card-media { position: relative; display: block; aspect-ratio: 16 / 9; background: #f3f4f6; overflow: hidden; }
    .bp-card-media img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .35s ease; }
    .bp-card:hover .bp-card-media img { transform: scale(1.04); }
    .bp-card-placeholder {
        width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;
        font-size: 56px; font-weight: 800; color: rgba(255, 255, 255, .92);
        background: linear-gradient(135deg, hsl(var(--hue), 70%, 42%), hsl(calc(var(--hue) + 40), 75%, 28%));
    }
    .bp-card-status { position: absolute; top: 12px; left: 12px; box-shadow: 0 2px 8px rgba(0, 0, 0, .15); }
    .bp-card-video { position: absolute; right: 12px; bottom: 12px; width: 34px; height: 34px; border-radius: 50%; background: rgba(0, 0, 0, .65); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 12px; }
    .bp-card-body { padding: 14px 16px 10px; flex: 1; display: flex; flex-direction: column; }
    .bp-card-cats { display: flex; flex-wrap: wrap; gap: 4px; margin-bottom: 8px; min-height: 22px; }
    .bp-card-title { font-size: 16px; font-weight: 700; line-height: 1.35; margin: 0 0 6px; }
    .bp-card-title a { color: #111827; text-decoration: none; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .bp-card-title a:hover { color: #bc1212; }
    .bp-card-excerpt { font-size: 13px; color: #6b7280; line-height: 1.55; margin: 0 0 12px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .bp-card-meta { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; font-size: 12px; color: #4b5563; margin-top: auto; }
    .bp-card-meta-sub { margin-top: 6px; color: #9ca3af; gap: 12px; }
    .bp-card-meta-sub i { margin-right: 3px; }
    .bp-avatar { width: 22px; height: 22px; border-radius: 50%; background: #bc1212; color: #fff; font-size: 11px; font-weight: 700; display: inline-flex; align-items: center; justify-content: center; }
    .bp-card-author { font-weight: 600; color: #1f2937; }
    .bp-dot { color: #d1d5db; }
    .bp-card-footer { border-top: 1px solid #f3f4f6; padding: 10px 16px; display: flex; align-items: center; justify-content: space-between; gap: 10px; background: #fcfcfd; }
    .bp-card-footer .bp-seo { flex: 1; max-width: 130px; }
    .bp-card-footer .bp-seo small { font-size: 11px; font-weight: 700; color: #6b7280; }
    .bp-card-actions { display: flex; gap: 4px; }
    .bp-card-actions .btn { width: 30px; height: 30px; padding: 0; display: inline-flex; align-items: center; justify-content: center; }
    .bp-chip-muted { background: #f3f4f6 !important; color: #6b7280 !important; border-color: #e5e7eb !important; }
    .bp-chip { display: inline-block; background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; border-radius: 999px; padding: 1px 9px; font-size: 11px; font-weight: 600; white-space: nowrap; }
    .bp-badge { display: inline-flex; align-items: center; gap: 5px; border-radius: 999px; padding: 3px 10px; font-size: 12px; font-weight: 600; }
    .bp-badge-draft { background: #f3f4f6; color: #374151; }
    .bp-badge-published { background: #dcfce7; color: #166534; }
    .bp-badge-scheduled { background: #e0f2fe; color: #075985; }
    .bp-badge-archived { background: #fef3c7; color: #92400e; }
    .bp-seo { display: flex; align-items: center; gap: 6px; cursor: help; }
    .bp-seo-bar { flex: 1; height: 6px; background: #e5e7eb; border-radius: 999px; overflow: hidden; min-width: 50px; }
    .bp-seo-bar span { display: block; height: 100%; border-radius: 999px; }
    .bp-seo-good span { background: #16a34a; }
    .bp-seo-ok span { background: #f59e0b; }
    .bp-seo-poor span { background: #dc2626; }
    .bp-empty { text-align: center; padding: 56px 16px; }
    .bp-empty-icon { width: 72px; height: 72px; margin: 0 auto 16px; border-radius: 50%; background: #fef2f2; color: #bc1212; display: flex; align-items: center; justify-content: center; font-size: 28px; }
    .bp-empty h5 { color: #111827; font-weight: 700; }
    .bp-empty p { color: #6b7280; max-width: 420px; margin: 0 auto 18px; }
    .bp-more-filters { display: none; }
    @media (max-width: 767.98px) {
        .bp-filters:not(.show-extra) .bp-filter-extra { display: none; }
        .bp-more-filters { display: inline-flex; align-items: center; margin: -4px 0 8px; }
        .bp-grid { grid-template-columns: 1fr; }
    }
    #bpResults { position: relative; min-height: 120px; transition: opacity .15s ease; }
    #bpResults.is-loading { opacity: .45; pointer-events: none; }
</style>

<div id="content" class="app-content">
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <div>
            <a href="{{ route('admin.blogs.index') }}" class="small text-decoration-none"><i class="fa fa-arrow-left me-1"></i> Blogs</a>
            <h3 class="page-header mb-0">Blog Management</h3>
            <small class="text-muted">Write, schedule and publish blog articles</small>
        </div>
        <a href="{{ route('admin.blog-posts.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
            <i class="fa fa-plus"></i> Add New Blog
        </a>
    </div>

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card p-4 mb-4">
        <div class="bp-status-tabs" role="tablist" aria-label="Filter by status">
            @foreach (['' => 'All'] + \App\Models\Blog::STATUSES as $value => $label)
                <button type="button" class="bp-status-tab {{ (string) request('status') === (string) $value ? 'active' : '' }}"
                        data-status="{{ $value }}" role="tab" aria-selected="{{ (string) request('status') === (string) $value ? 'true' : 'false' }}">
                    {{ $label }} <span class="bp-count" data-count-for="{{ $value ?: 'all' }}">({{ $statusCounts[$value ?: 'all'] }})</span>
                </button>
            @endforeach
        </div>

        <form id="bpFilterForm" class="row g-3 mb-3 bp-filters" autocomplete="off">
            <input type="hidden" name="status" value="{{ request('status') }}">
            <div class="col-lg-4 col-md-6">
                <label class="form-label" for="bpSearch">Search</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                    <input type="search" id="bpSearch" name="search" class="form-control" placeholder="Search by article title..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-lg-2 col-md-6">
                <label class="form-label" for="bpCategory">Category</label>
                <button type="button" class="btn btn-sm be-ghost bp-more-filters float-end" aria-expanded="false" aria-controls="bpFilterForm">
                    <i class="fa fa-sliders me-1"></i> More filters
                </button>
                <select id="bpCategory" name="category" class="form-select">
                    <option value="">All categories</option>
                    @foreach ($blogCategories as $blogCategory)
                        <option value="{{ $blogCategory->id }}" {{ (string) request('category') === (string) $blogCategory->id ? 'selected' : '' }}>{{ $blogCategory->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-3 col-md-6 bp-filter-extra">
                <label class="form-label" for="bpDateFrom">Published between</label>
                <div class="input-group">
                    <input type="date" id="bpDateFrom" name="date_from" class="form-control" value="{{ request('date_from') }}" aria-label="From date">
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}" aria-label="To date">
                </div>
            </div>
            <div class="col-lg-3 col-md-6 d-flex align-items-end bp-filter-extra">
                <button type="button" class="btn be-ghost w-100 bp-reset-filters"><i class="fa fa-rotate-left me-1"></i> Reset filters</button>
            </div>
            <div class="col-lg-4 col-md-4 bp-filter-extra">
                <label class="form-label" for="bpCountry">Country</label>
                <select id="bpCountry" name="country_id" class="form-select">
                    <option value="">All countries</option>
                    @foreach ($countries as $countryOption)
                        <option value="{{ $countryOption->id }}" {{ (string) request('country_id') === (string) $countryOption->id ? 'selected' : '' }}>{{ $countryOption->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-4 col-md-4 bp-filter-extra">
                <label class="form-label" for="bpState">State</label>
                <select id="bpState" name="state_id" class="form-select" disabled>
                    <option value="">All states</option>
                </select>
            </div>
            <div class="col-lg-4 col-md-4 bp-filter-extra">
                <label class="form-label" for="bpCity">City</label>
                <select id="bpCity" name="city_id" class="form-select" disabled>
                    <option value="">All cities</option>
                </select>
            </div>
        </form>

        <div id="bpResults" aria-live="polite">
            @include('admin.blogs.posts._table')
        </div>
    </div>
</div>

@endsection

@push('js')
<script>
$(function () {
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    var indexUrl = "{{ route('admin.blog-posts.index') }}";
    var statesUrl = "{{ route('admin.get-states') }}";
    var citiesUrl = "{{ route('admin.get-cities') }}";
    var $form = $('#bpFilterForm');
    var $results = $('#bpResults');
    var currentRequest = null;
    var searchTimer = null;

    function load(url) {
        url = url || indexUrl + '?' + $form.serialize();
        if (currentRequest) currentRequest.abort();
        $results.addClass('is-loading');

        currentRequest = $.ajax({ url: url, dataType: 'json', cache: false })
            .done(function (res) {
                $results.html(res.html);
                $.each(res.counts, function (key, count) {
                    $('[data-count-for="' + key + '"]').text('(' + count + ')');
                });
                // Keep the URL shareable / reload-safe without a full page reload.
                history.replaceState(null, '', url);
            })
            .fail(function (xhr) {
                if (xhr.statusText !== 'abort') {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Unable to load articles. Please try again.' });
                }
            })
            .always(function () { $results.removeClass('is-loading'); });
    }

    function fillSelect($select, url, params, placeholder, selected) {
        $select.html('<option value="">' + placeholder + '</option>').prop('disabled', true);
        if (!params[Object.keys(params)[0]]) return $.Deferred().resolve();

        return $.get(url, params, function (items) {
            $.each(items, function (_, item) {
                $select.append($('<option>', { value: item.id, text: item.name, selected: String(item.id) === String(selected) }));
            });
            $select.prop('disabled', false);
        });
    }

    // Filters
    $form.on('change', 'select:not(#bpCountry):not(#bpState), input[type="date"]', function () { load(); });
    $('#bpSearch').on('input', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function () { load(); }, 350);
    });
    $form.on('submit', function (e) { e.preventDefault(); load(); });

    $('#bpCountry').on('change', function () {
        fillSelect($('#bpState'), statesUrl, { country_id: this.value }, 'All states');
        fillSelect($('#bpCity'), citiesUrl, { state_id: '' }, 'All cities');
        load();
    });
    $('#bpState').on('change', function () {
        fillSelect($('#bpCity'), citiesUrl, { state_id: this.value }, 'All cities');
        load();
    });

    $('.bp-status-tab').on('click', function () {
        $('.bp-status-tab').removeClass('active').attr('aria-selected', 'false');
        $(this).addClass('active').attr('aria-selected', 'true');
        $form.find('[name="status"]').val($(this).data('status'));
        load();
    });

    $(document).on('click', '.bp-reset-filters', function () {
        $form[0].reset();
        $form.find('input').val('');
        $form.find('select').val('');
        fillSelect($('#bpState'), statesUrl, { country_id: '' }, 'All states');
        fillSelect($('#bpCity'), citiesUrl, { state_id: '' }, 'All cities');
        $('.bp-status-tab').removeClass('active').attr('aria-selected', 'false').first().addClass('active').attr('aria-selected', 'true');
        load();
    });

    // Mobile: location / date filters are tucked away until asked for
    $('.bp-more-filters').on('click', function () {
        var open = $form.toggleClass('show-extra').hasClass('show-extra');
        $(this).attr('aria-expanded', open ? 'true' : 'false')
            .html('<i class="fa fa-sliders me-1"></i> ' + (open ? 'Fewer filters' : 'More filters'));
    });
    if ($form.find('.bp-filter-extra').find('input, select').filter(function () { return this.value; }).length) {
        $('.bp-more-filters').trigger('click');
    }

    // Pagination without full page reloads
    $results.on('click', '.pagination a', function (e) {
        e.preventDefault();
        load(this.href);
        $('html, body').animate({ scrollTop: $results.offset().top - 120 }, 200);
    });

    // Restore dependent location filters from the query string
    @if (request('country_id'))
        fillSelect($('#bpState'), statesUrl, { country_id: '{{ (int) request('country_id') }}' }, 'All states', '{{ (int) request('state_id') }}').then(function () {
            @if (request('state_id'))
                fillSelect($('#bpCity'), citiesUrl, { state_id: '{{ (int) request('state_id') }}' }, 'All cities', '{{ (int) request('city_id') }}');
            @endif
        });
    @endif

    // Duplicate
    $results.on('click', '.bp-duplicate', function () {
        var $btn = $(this).prop('disabled', true);
        $.post("{{ route('admin.blog-posts.duplicate', ':id') }}".replace(':id', $btn.data('id')))
            .done(function (res) {
                Swal.fire({
                    icon: 'success', title: 'Duplicated', text: res.message,
                    showCancelButton: true, confirmButtonText: 'Edit the copy', cancelButtonText: 'Stay here',
                    confirmButtonColor: '#bc1212'
                }).then(function (result) {
                    if (result.isConfirmed) window.location = res.edit_url;
                    else load(location.href);
                });
            })
            .fail(function (xhr) {
                Swal.fire({ icon: 'error', title: 'Error', text: (xhr.responseJSON && xhr.responseJSON.message) || 'Failed to duplicate the article.' });
            })
            .always(function () { $btn.prop('disabled', false); });
    });

    // Delete
    $results.on('click', '.bp-delete', function () {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Delete this article?',
            text: '"' + $(this).data('title') + '" will be permanently deleted. This cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e41e3f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it'
        }).then(function (result) {
            if (!result.isConfirmed) return;
            $.ajax({ url: "{{ route('admin.blog-posts.destroy', ':id') }}".replace(':id', id), type: 'POST', data: { _method: 'DELETE' } })
                .done(function (res) {
                    Swal.fire({ icon: 'success', title: 'Deleted', text: res.message, timer: 1200, showConfirmButton: false });
                    load(location.href);
                })
                .fail(function (xhr) {
                    Swal.fire({ icon: 'error', title: 'Error', text: (xhr.responseJSON && xhr.responseJSON.message) || 'Failed to delete the article.' });
                });
        });
    });
});
</script>
@endpush
