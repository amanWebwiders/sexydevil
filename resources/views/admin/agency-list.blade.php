@extends('admin.layout.layout')

@section('content')
<style>
  input.pe-2 {
    margin-right: 5px;
    position: relative;
    top: 2px;
  }

  .btn {
    text-wrap-mode: nowrap;
  }
</style>

<div id="content" class="app-content">
  <section class="content">
    <div class="container-fluid">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="">Agencies</h3>
        <a href="{{ route('admin.agencies.create') }}" class="btn btn-success">
          <i class="fa fa-plus"></i> Add Agency
        </a>
      </div>
      <div class="row">
        <div class="col-12 mt-3">
          <div class="card card-primary p-4">

            {{-- Success Message --}}
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
              <table class="table display" id="AgencyTable">
                <thead class="table-dark">
                  <tr>
                    <th>S.No</th>
                    <th>Name</th>
                    <th>Headline</th>
                    <th>Teams</th>
                    <th>Created At</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($agencies as $index => $agency)
                  <tr>
                    <td>{{ $index + 1 }}</td>

                    <td>{{ $agency->name }}</td>
                    <td>{{ $agency->headline ?? '-' }}</td>
                    <td><span class="badge bg-info">{{ $agency->teams->count() }}</span></td>

                    <td>{{ $agency->created_at->format('d M Y') }}</td>
                    <td class="d-lg-flex gap-2">
                      <a href="{{ route('admin.agencies.edit', $agency->id) }}"
                        class="btn btn-warning btn-sm">Edit</a>

                      <form action="{{ route('admin.agencies.destroy', $agency->id) }}"
                        method="POST"
                        class="d-inline delete-form"
                        data-name="{{ $agency->name }}" data-id="{{ $agency->id }}">
                        <input type="hidden" name="id" value="{{ $agency->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger btn-sm delete-btn">Delete</button>
                      </form>

                      <a href="{{ route('admin.agencies.show', $agency->id) }}"
                        class="btn btn-primary btn-sm">View</a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection

@push('js')
<script>
  $(document).ready(function() {
    // DataTable
    new DataTable('#AgencyTable', {
      order: [
        [0, 'asc']
      ]
    });

    // Delete confirmation with SweetAlert
    $('.delete-btn').click(function(e) {
        e.preventDefault();

        var btn = $(this);
        var form = btn.closest('form');
        var url = form.attr('action');
        var name = form.data('name');

        Swal.fire({
            title: 'Are you sure?',
            text: `Do you want to delete "${name}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            preConfirm: () => {
                // Disable button and show processing
                btn.prop('disabled', true).text('Processing...');

                return $.ajax({
                    url: url,
                    type: 'POST',
                    data: form.serialize(),
                }).then(response => {
                    return response;
                }).catch(xhr => {
                    Swal.showValidationMessage(`Request failed: ${xhr.responseText}`);
                }).always(() => {
                    // Re-enable button if needed
                    btn.prop('disabled', false).text('Delete');
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Deleted!',
                    `"${name}" has been deleted.`,
                    'success'
                );
                form.closest('tr').remove(); // remove the row
            }
        });
    });
  });
</script>
@endpush