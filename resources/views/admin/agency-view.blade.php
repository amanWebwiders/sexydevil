@extends('admin.layout.layout')
@section('content')

<div id="content" class="app-content">

    <div class="d-lg-flex align-items-end mb-4">
        <h3 class="page-header mb-lg-0">
            Agency Details
        </h3>
        <a href="{{ route('admin.agencies.index') }}" class="btn btn-secondary ms-auto">Back to List</a>
    </div>

    <div class="card p-4">

        {{-- Basic Info --}}
        <h4 class="mb-3">{{ $agency->name }}</h4>
        <p><strong>Headline:</strong> {{ $agency->headline ?? '-' }}</p>
        <p><strong>Short Description:</strong> {{ $agency->short_desc ?? '-' }}</p>
        <p><strong>Long Description:</strong> {{ $agency->long_desc ?? '-' }}</p>

        {{-- Contact Info --}}
        <h5 class="mt-4">Contact</h5>
        <p><strong>Email:</strong> {{ $agency->email ?? '-' }}</p>
        <p><strong>Phone:</strong> {{ $agency->phone ?? '-' }}</p>
        <p><strong>Address:</strong> {{ $agency->address ?? '-' }}</p>
        <p><strong>Website:</strong>
            @if($agency->website)
                <a href="{{ $agency->website }}" target="_blank">{{ $agency->website }}</a>
            @else
                -
            @endif
        </p>

        {{-- Social Media --}}
        <h5 class="mt-4">Social Media</h5>
        <ul>
            <li><strong>Telegram:</strong> 
                @if($agency->telegram) <a href="{{ $agency->telegram }}" target="_blank">{{ $agency->telegram }}</a> @else - @endif
            </li>
            <li><strong>Facebook:</strong> 
                @if($agency->facebook) <a href="{{ $agency->facebook }}" target="_blank">{{ $agency->facebook }}</a> @else - @endif
            </li>
            <li><strong>Instagram:</strong> 
                @if($agency->instagram) <a href="{{ $agency->instagram }}" target="_blank">{{ $agency->instagram }}</a> @else - @endif
            </li>
            <li><strong>LinkedIn:</strong> 
                @if($agency->linkedin) <a href="{{ $agency->linkedin }}" target="_blank">{{ $agency->linkedin }}</a> @else - @endif
            </li>
        </ul>

        {{-- Agency Photo --}}
        @if($agency->photo)
            <h5 class="mt-4">Agency Photo</h5>
            <img src="{{ asset('storage/'.$agency->photo) }}" class="rounded mb-3" style="max-width:200px;">
        @endif

        {{-- Agency Photos --}}
        @if($agency->media->where('type','image')->count())
            <h5 class="mt-4">Photos</h5>
            <div class="d-flex flex-wrap">
               @foreach($agency->media->where('type','image') as $media)
                    <div class="m-2">
                        <img src="{{ asset('storage/'.$media->file_path) }}" style="max-width:150px; max-height:150px;" class="rounded">
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Agency Videos --}}
         @if($agency->media->where('type','video')->count())
            <h5 class="mt-4">Videos</h5>
            <div class="d-flex flex-wrap">
                @foreach($agency->media->where('type','video') as $media)
                    <div class="m-2">
                        <video src="{{ asset('storage/'.$media->file_path) }}" style="max-width:200px; max-height:150px;" controls></video>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Team Members --}}
        @if($agency->teams->count())
            <h5 class="mt-4">Team Members</h5>
            <div class="row">
                @foreach($agency->teams as $team)
                    <div class="col-md-4 mb-3">
                        <div class="card p-3">
                            @if($team->photo)
                                <img src="{{ asset('storage/'.$team->photo) }}" class="rounded mb-2" style="max-width:100px;">
                            @endif
                            <h6>{{ $team->name }}</h6>
                            <p><strong>Age:</strong> {{ $team->age ?? '-' }}</p>
                            <p><strong>Gender:</strong> {{ $team->gender ? ucfirst($team->gender) : '-' }}</p>
                            <p>{{ $team->description ?? '-' }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</div>
@endsection
