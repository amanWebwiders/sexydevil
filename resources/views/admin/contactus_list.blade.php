@extends('admin.layout.layout')
@section('content')
<style>
    input.pe-2 {
        margin-right: 5px;
        position: relative;
        top: 2px;
    }
</style>

<div id="content" class="app-content">

    <div class="d-lg-flex align-items-end mb-4">
        <h3 class="page-header mb-lg-0">
            Contact Us Listing
        </h3>
    </div>

    <div class="card p-4">

        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
                tabindex="0">

                <div class="table-responsive">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">S.no</th>
                                <th scope="col">Full Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">City</th>
                                <th scope="col">Message</th>
                                <th scope="col">Created At</th>
                                <!-- <th scope="col">Action</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @php use Illuminate\Support\Str; @endphp
                            @foreach($contactus as $index => $list)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{$list['full_name']}}</td>
                                <td>{{$list['email']}}</td>
                                <td>{{$list['phone']}}</td>
                                <td>{{$list['city']}}</td>
                                <td> @php
                                    $plainMessage = strip_tags($list['message']);
                                    $words = str_word_count($plainMessage, 1);

                                    // Short message = pehle 15 words
                                    $shortMessage = implode(' ', array_slice($words, 0, 15));
                                    $fullMessage = implode(' ', $words);
                                    @endphp

                                    @if(count($words) > 15)
                                    <span class="short-msg">{{ e($shortMessage) }}...</span>
                                    <span class="full-msg d-none">{{ e($fullMessage) }}</span>
                                    <button class="btn btn-primary read-more-toggle">Read more</button>
                                    @else
                                    {{ e($fullMessage) }}
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($list['created_at'])->format('d M Y, h:i A') }}</td>
                                <!-- <td>
                                <input type="checkbox"
                                    class="actioned-checkbox"
                                    data-id="{{ $list['id'] }}"
                                    {{ $list['status'] == 1 ? 'checked' : '' }}>
                            </td> -->

                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>

        </div>


    </div>
    @endsection
    @push('js')
    <script>
        $(document).on('click', '.read-more-toggle', function() {
    let $btn = $(this);
    let $td = $btn.closest('td');

    $td.find('.short-msg, .full-msg').toggleClass('d-none');

    if ($btn.text() === 'Read more') {
        $btn.text('Read less');
    } else {
        $btn.text('Read more');
    }
});

        $('.actioned-checkbox').on('change', function() {
            var contactId = $(this).data('id');
            var status = $(this).is(':checked') ? 1 : 0;
            var url = '{{ route("admin.contact-status", ":id") }}'.replace(':id', contactId);

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    status: status,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Status updated successfully!',
                            timer: 1000,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'Failed to update status.'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while updating status.'
                    });
                }
            });
        });
    </script>

    @endpush('js')