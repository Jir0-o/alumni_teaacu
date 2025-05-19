@extends('layouts.app')

@section('title', 'All Notice || ' . env('APP_NAME'))

@section('content')
    <section class="all-notice">
        <div class="container">
            <center>
                <h3>Alumni Notices</h3>
            </center>
            <div class="notice-list">
                <div class="notices-all">
                    @foreach ($notices as $item)
                        <div class="mb-3 mb-md-4 card {{ \Carbon\Carbon::parse($item->valid_till)->isFuture() ? 'active-section' : '' }}">
                            <div class="card-body">
                                <h2 class="card-title">{{ $item->title }}</h2>
                                @if (!Auth::check())
                                    <p class="text-warning">Only logged user can view details</p>
                                @endif
                                <div class="row">
                                    <div class="col-6">
                                        <h6 class="card-subtitle ">
                                            <a href="{{ route('frontend.viewProfile', $item->person_id) }}" target="_blank"
                                                rel="noopener noreferrer" style="color: #666666;">Posted by: {{ $item->name }}</a>
                                        </h6>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-end">
                                            <p class="m-0">
                                                Posted {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @if ($item->noticeBody && Auth::user())
                                    <div class="card rounded bg-gradient my-3">
                                        <div class="card-body">
                                            <div class="card-text slide">
                                                {!! $item->noticeBody !!}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col-6 text-start">
                                        @if ($item->uril && Auth::user())
                                            <p>
                                                <a href="{{ $item->uril }}" target="_blank" class="btn btn-primary  font-weight-bold text-white py-2 px-2 prominent-link" role="button">
                                                    Follow External Link
                                                </a>
                                            </p>
                                        @endif
                                    </div>
                                    <div class="col-6 text-end">
                                        @if ($item->filepath && Auth::user())
                                            <p>
                                                <a href="{{ asset('public/' . $item->filepath) }}" class="btn btn-success font-weight-bold text-white py-2 px-2 download-link" role="button" download>
                                                    Download Attachment
                                                </a>
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                @if ($item->imgPath)
                                    <img src="{{ $item->imgPath }}" class="w-md-25 w-100" alt="Notice Img" srcset="" loading="lazy">
                                @endif
                            </div>
                        </div>
                    @endforeach
                    <div style="margin-top: 30px;text-align:center;margin-bottom:30px">
                        {{ $notices->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection