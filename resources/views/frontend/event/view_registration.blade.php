@extends('layouts.app')

@section('title', 'All Event || ' . env('APP_NAME'))

@section('content')
    <section class="all-event">
        <div class="container">
            <center>
                <h5>All Events List</h5>
            </center>
            <div class="container mt-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Event Registrations</h4>
                    </div>
                    <div class="card-body">
                        <table id="eventTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Registration Date</th>
                                    <th>Registration Amount</th>
                                    <th>Payment Method</th>
                                    <th>Transaction Number</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($events as $event)
                                    @foreach ($event->registrations as $registration)
                                        <tr>
                                            <td>{{ $event->title }}</td>
                                            <td>{{ \Carbon\Carbon::parse($registration->reg_date)->format('d F Y') }}</td>
                                            <td class="text-end">৳{{ number_format($event->reg_amount, 2) }}</td>
                                            <td>{{ ucfirst($registration->payment_method) }}</td>
                                            <td>{{ $registration->trx_number }}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('extra_js')
@endsection