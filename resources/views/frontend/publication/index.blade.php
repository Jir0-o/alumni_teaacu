@extends('layouts.app')

@section('title', 'Research & Publication || ' . env('APP_NAME'))

@section('extra_css')
    <style>
        .publication-box iframe {
            width: 100%;
            aspect-ratio: 5/3;
        }
    </style>
@endsection

@section('content')
<section class="publication-box">
    <div class="container">
        <h4 class="text-center text-uppercase fw-bold">Our Members Research & Publication</h4>
        <div class="row">
        @foreach($getPublication as $publication)
            @php
                $files = is_array($publication->files) ? $publication->files : json_decode($publication->files, true);
            @endphp

            @if(!empty($files) && is_array($files))
                @foreach($files as $file)
                    @if(!empty($file))
                        <div class="col-sm-6 col-md-4 p-3">
                            <div class="card h-100">
                                <iframe src="{{ asset($file) }}" frameborder="0" style="height: 300px;"></iframe>
                                <div class="card-body">
                                    <a href="{{ asset($file) }}" target="_blank">
                                        <h6 class="fw-bold">{{ $publication->title }}</h6>
                                    </a>
                                    <small>
                                        Upload By: 
                                        @php
                                            $user = \App\Models\User::find($publication->user_id);
                                        @endphp
                                        <a href="{{ route('frontend.viewProfile', ['id' => $publication->user_id]) }}" target="_blank">
                                            {{ $user->name ?? 'Unknown User' }}
                                        </a>
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        @endforeach
        </div>
    </div>
</section>

@endsection
