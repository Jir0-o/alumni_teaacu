@extends('layouts.app')

@section('title', 'Committee Information || ' . env('APP_NAME'))

@section('content')
    <section class="committee-list py-4">
        <div class="container">
            <div class="section-title">
                @foreach($getMemberList as $member_index => $member)
                    @if($member->committee_type == 'Executive')
                        <h2>Executive Committee</h2>
                    @else
                        <h2>Advisor Committee</h2>
                    @endif
                @endforeach
                <h4>{{ $committee->name?? ''; }}</h4>
            </div>
            <div class="top-designation-member">
                <div class="row">
                    @foreach($getMemberList as $member_index => $member)
                        @if($member->showcase == 1)
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="card d-flex flex-direction-column justify-content-center text-center p-4">
                                    <div class="card-member-img">
                                        <img src="{{ $member->imgPath ? $member->imgPath : asset('backend/avatar.jpg') }}" alt="Member Image" loading="lazy">
                                    </div>
                                    <h4 class="member-name">
                                        {{ $member->committee_member_name }}
                                    </h4>
                                    <p class="designation">
                                        {{ $member->designation }}
                                    </p>
                                    <a href="{{route('frontend.committeeDetails',encrypt($member->id))}}" class="btn btn-danger btn-sm">
                                        Details
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="designation-member py-md-5 py-4">
                <!-- <div class="section-title">
                    <h3>All Valuable Committee Members</h3>
                </div> -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <td>Sr</td>
                                <td>Image</td>
                                <td>Name</td>
                                <td>CIPS ID</td>
                                <td>Position</td>
                                <td>Committee Name</td>
                                @if(Route::currentRouteName() == 'previous-committee') 
                                    <td>Start</td>
                                    <td>End</td>
                                @endif
                                <td>Status</td>
                                <td class="text-center">View</td>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            @foreach($getMemberList as $member_index => $member)
                                <tr class="align-middle">
                                    <td>{{$member_index + 1}}</td>
                                    <td>
                                        <img height="50" width="50" class="rounded-circle object-fit-cover" src="{{ $member->imgPath ? $member->imgPath : asset('backend/avatar.jpg') }}" alt="Member Image" loading="lazy">
                                    </td>
                                    <td>
                                        {{ $member->committee_member_name }}
                                    </td>
                                    <td>
                                        {{ $member->cipsMemberId }}
                                    </td>
                                    <td>
                                        {{ $member->designation }}
                                    </td>
                                    <td>
                                        {{ $member->committee_name }}
                                    </td>
                                    @if(Route::currentRouteName() == 'previous-committee') 
                                        <td class="text-nowrap">
                                            {{ $member->committee_start }}
                                        </td>
                                        <td class="text-nowrap">
                                            {{ $member->committee_end }}
                                        </td>
                                    @endif
                                    <td class="text-center">
                                        @if ($member->committee_is_active == 1)
                                            <span class="badge rounded-pill text-bg-success">Active</span>
                                        @else 
                                            <span class="badge rounded-pill text-bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{route('frontend.committeeDetails',encrypt($member->id))}}" class="btn btn-primary btn-sm">
                                            Details
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
