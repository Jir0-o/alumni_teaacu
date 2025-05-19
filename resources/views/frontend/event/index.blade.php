@extends('layouts.app')

@section('title', 'All Event || ' . env('APP_NAME'))

@section('content')
    <section class="all-event">
        <div class="container">
            <center>
                <h5>All Events List</h5>
            </center>
            <div class="events-card-list">
                <div class="all-event-card row">
                    @foreach ($events as $item)
                        <div class="card col-12 {{ \Carbon\Carbon::parse($item->reg_valid_date)->isFuture() ? 'active-section' : '' }}" style="margin-bottom: 10px">
                            <div class="card-body">
                                <h2 class="card-title">{{ $item->title }}</h2>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h6 class="card-subtitle ">
                                            <a href="{{ route('frontend.viewProfile', $item->created_by) }}" target="_blank"
                                                rel="noopener noreferrer" style="color: #666666;">Posted by: {{ $item->name }}</a>
                                        </h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="text-end">
                                            <p class="m-0">
                                                Posted {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @if ($item->reg_valid_date)
                                    @php
                                        $validDate = \Carbon\Carbon::parse($item->reg_valid_date)->endOfDay();
                                        $currentDateTime = \Carbon\Carbon::now();
                                    @endphp                                
                                    @if ($currentDateTime->lte($validDate))
                                        <div class="row">
                                            <div class="col-6 my-4">
                                                <h6 class="card-subtitle">
                                                    Registration Open Till: {{ $item->reg_valid_date }}
                                                </h6>
                                            </div>
                                            <div class="col-4 my-4">
                                                <div class="text-end">
                                                    Registration Fee: {{ $item->reg_amount }}
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="text-end">
                                                    @auth
                                                        @if (Auth::user())
                                                            @if($item->status == 0)
                                                            <a type="button" id="regBtn" class="btn btn-success font-weight-bold text-white my-2" 
                                                            data-bs-toggle="modal" role="button" data-bs-target="#registrationForm"
                                                            data-value="{{$item->id}}">
                                                                Sign up
                                                            </a>
                                                            @else
                                                                <a class="btn btn-warning font-weight-bold text-white my-2" disabled>
                                                                    Registered
                                                                </a>
                                                            @endif
                                                        @endif
                                                    @endauth
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif 
                                <br>
                                <div class="row"> 
                                    @foreach ($pics as $items)
                                        @if ($items->event_id == $item->id)
                                            <div class="col-sm-6 col-md-4 col-lg-3">
                                                <img class="w-100" src="{{ asset($items->imgPath) }}" alt="Slider Img" loading="lazy">
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
            </div>
        </div>
    </section>

    <!-- modal for events registration -->
    <div class="modal fade" id="registrationForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Sign up for event</h1>
                </div>
                <div class="modal-body">
                    <form class="row g-3" action="{{ route('eventRegister') }}" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="paymentmethod" class="form-label">Paid by <sup class="text-danger">*</sup></label>
                                <input type="hidden" id="eventID" name="eventID" value="">
                                <input required id="paymentmethod" class="form-control" placeholder="Payment Method" name="paymentmethod"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="trxNumber" class="form-label">Transaction Reference <sup class="text-danger">*</sup></label>
                                <input required id="trxNumber" class="form-control" placeholder="Transaction Reference #" name="trxNumber">
                            </div>
                        </div>
                        <div class="text-right">
                            @csrf
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button style="float: right;" type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra_js')
    <script>
        $(document).ready(function() {
            $('#regBtn').click(function() {
                var value = $(this).data('value');
                $('#eventID').val(value);
            });
        });
    </script>
@endsection