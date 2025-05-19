@extends('layouts.app')

@section('title', 'All Notice || ' . env('APP_NAME'))

@section('content')
    <section class="my-event-list">
        <div class="container">
            <center>
                <h5 class="mb-3">My Uploaded Events</h5>
            </center>
            @foreach ($events as $item)
                <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="card-title">
                            {{ $item->title }}
                            <a href="{{ route('MyEventAction', $item->id) }}" style="text-align: right" class="btn btn-info">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="{{ route('event.delete', $item->id) }}" style="text-align: right" class="btn btn-danger">
                                <i class="bi bi-trash3"></i>
                            </a>
                        </h2>
                        <h6 class="card-subtitle mb-2 text-muted">
                            <a href="{{ route('frontend.viewProfile', $item->id) }}" target="_blank"
                                rel="noopener noreferrer">{{ $item->name }}</a>
                        </h6>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                        @if ($item->isActive == 1)
                            <h5>Active</h5>
                        @else
                            <h5>Deactivated</h5>
                        @endif
                        <br>
                        <div class="slider">
                            @foreach ($pics as $items)
                                @if ($items->event_id == $item->id)
                                    <div><img src="{{ $items->imgPath }}" alt="" height="300" width="320">
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
            <div style="margin-top: 30px;text-align:center;margin-bottom:30px">
                {{ $events->links() }}
            </div>
        </div>
    </section>
@endsection