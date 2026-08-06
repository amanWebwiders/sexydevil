@extends('admin.layout.layout')
@section('content')


    <div id="content" class="app-content">
    
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="card p-4">
            <h3 class="page-header mb-3">{{ $terms->name }}</h3>
            <form method="post" action="{{ route('admin.terms-conditions-update') }}">
                @csrf
                <input type="hidden" name="id" value="{{ $terms->id }}" >
                <div class="w-100">
                    <textarea class="form-control textarea" name="content" required>{{ old('content') ?? $terms->content }}</textarea>
                </div>
                <div class="w-25">
                    <button class="btn btn-primary mt-2" type="submit">Update</button>
                </div>

            </form>
        </div>
    
@endsection
@push('js')
<script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=jaa9c6t7n255qwruis8bo6x87nxj39aqrhr4w323i4hd2f9k"></script>
<script>
tinymce.init({
  selector: '.textarea',
  height:480,
  plugins: [ 
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
  toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
  setup: function (editor) {
    editor.on('change', function () {
      tinymce.triggerSave();
    });
  }
});
</script> 
@endpush('js')