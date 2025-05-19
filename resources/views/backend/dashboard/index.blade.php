@extends('layouts.app')

@section('title', 'Dashboard || ' . env('APP_NAME'))

@section('content')
    <section class="dashboard-container">
        <div class="container">
            <center>
                <h5>Admin Dashboard</h5>
            </center>
            @if (session('success'))
                <div class="alert alert-success mt-2">
                    {{ session('success') }}
                </div>
            @endif
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="overview" data-bs-toggle="tab" data-bs-target="#overview-pane"
                        type="button" role="tab" aria-controls="overview-pane" aria-selected="true">
                        Overview
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="notice-tab" data-bs-toggle="tab" data-bs-target="#notice-tab-pane"
                        type="button" role="tab" aria-controls="notice-tab-pane" aria-selected="false">
                        Notice
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="event-tab" data-bs-toggle="tab" data-bs-target="#event-tab-pane"
                        type="button" role="tab" aria-controls="event-tab-pane" aria-selected="false">
                        Event
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="committee-tab" data-bs-toggle="tab" data-bs-target="#committee-tab-pane"
                        type="button" role="tab" aria-controls="committee-tab-pane" aria-selected="false">
                        Committee
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="committee-member-tab" data-bs-toggle="tab"
                        data-bs-target="#committee-member-tab-pane" type="button" role="tab"
                        aria-controls="committee-member-tab-pane" aria-selected="false">
                        Committee Member
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="links-tab" data-bs-toggle="tab" data-bs-target="#links-tab-pane"
                        type="button" role="tab" aria-controls="links-tab-pane" aria-selected="false">
                        Important Links
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="user-tab" data-bs-toggle="tab" data-bs-target="#user-tab-pane"
                        type="button" role="tab" aria-controls="user-tab-pane" aria-selected="false">
                        User
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="user-request-tab" data-bs-toggle="tab"
                        data-bs-target="#user-request-tab-pane" type="button" role="tab"
                        aria-controls="user-request-tab-pane" aria-selected="false">
                        User Request
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="settings-tab" data-bs-toggle="tab"
                        data-bs-target="#settings-tab-pane" type="button" role="tab"
                        aria-controls="settings-tab-pane" aria-selected="false">
                        Role & Permission
                    </button>
                </li>
            </ul>
            <div class="tab-content pt-4" id="myTabContent">
                <div class="tab-pane fade show active" id="overview-pane" role="tabpanel" aria-labelledby="overview"
                    tabindex="0">
                    <div class="row">
                        <div class="col-sm-6 col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Total Members</h5>
                                    <h3>{{ $user }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Total Notice</h5>
                                    <h3>{{ $notice }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Total Events</h5>
                                    <h3>{{ $event }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Current Committee Member</h5>
                                    <h3>{{ $totalCommitteeMember }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="notice-tab-pane" role="tabpanel" aria-labelledby="notice-tab"
                    tabindex="0">
                    <h5>Notice For Verification</h5>
                    <div class="table-responsive">
                        <table class="table table-hovered">
                            <thead>
                                <tr>
                                    <th>#SL</th>
                                    <th class="text-center">Notice Title</th>
                                    <th class="text-center">Posted By</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($newNotice as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->title }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('frontend.viewProfile', $item->person_id) }}">
                                                {{ $item->name }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('deleteNotice', $item->id) }}" class="btn btn-danger me-2"
                                                title="Delete Notice">
                                                <i class="bi bi-x-octagon-fill"></i>
                                            </a>
                                            <a href="{{ route('approveNotice', $item->id) }}" class="btn btn-success"
                                                title="Approve Notice">
                                                <i class="bi bi-check-circle-fill"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <h5 class="pt-4 pt-md-5">Verified Notices</h5>
                    <div class="table-responsive">
                        <table class="table table-hovered">
                            <thead>
                                <tr>
                                    <th>#SL</th>
                                    <th class="text-center">Notice Title</th>
                                    <th class="text-center">Posted By</th>
                                    <th class="text-center">Is Active</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allNotice as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->title }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('frontend.viewProfile', $item->person_id) }}">
                                                {{ $item->name }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            @if ($item->isActive == 1)
                                                Active
                                            @else
                                                Deactivated
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('deleteNotice', $item->id) }}" class="btn btn-danger me-2"
                                                title="Delete Notice">
                                                <i class="bi bi-trash3"></i>
                                            </a>
                                            @if ($item->isActive == 1)
                                                <a href="{{ route('deactivateNotice', $item->id) }}"
                                                    class="btn btn-warning" title="Deactivate Notice">
                                                    <i class="bi bi-stop-circle-fill"></i>
                                                </a>
                                            @else
                                                <a href="{{ route('approveNotice', $item->id) }}" class="btn btn-success"
                                                    title="Activate Notice">
                                                    <i class="bi bi-check-circle-fill"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="event-tab-pane" role="tabpanel" aria-labelledby="event-tab"
                    tabindex="0">
                    <h5>Uploaded Events For Verification</h5>
                    <div class="table-responsive">
                        <table class="table table-hovered">
                            <thead>
                                <tr>
                                    <th>#SL</th>
                                    <th class="text-center">Event Title</th>
                                    <th class="text-center">Posted By</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($newEvent as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->title }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('frontend.viewProfile', $item->created_by) }}">
                                                {{ $item->name }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('deleteEvent', $item->id) }}" class="btn btn-danger me-2"
                                                title="Delete Notice">
                                                <i class="bi bi-x-octagon-fill"></i>
                                            </a>
                                            <a href="{{ route('approveEvent', $item->id) }}" class="btn btn-success"
                                                title="Approve Notice">
                                                <i class="bi bi-check-circle-fill"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <h5 class="pt-4 pt-md-5">Verified Events</h5>
                    <div class="table-responsive">
                        <table class="table table-hovered">
                            <thead>
                                <tr>
                                    <th>#SL</th>
                                    <th class="text-center">Notice Title</th>
                                    <th class="text-center">Posted By</th>
                                    <th class="text-center">Is Active</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allEvent as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->title }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('frontend.viewProfile', $item->created_by) }}">
                                                {{ $item->name }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            @if ($item->isActive == 1)
                                                Active
                                            @else
                                                Deactivated
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('deleteEvent', $item->id) }}" class="btn btn-danger me-2"
                                                title="Delete Notice">
                                                <i class="bi bi-trash3"></i>
                                            </a>
                                            @if ($item->isActive == 1)
                                                <a href="{{ route('deactivateEvent', $item->id) }}"
                                                    class="btn btn-warning" title="Deactivate Notice">
                                                    <i class="bi bi-stop-circle-fill"></i>
                                                </a>
                                            @else
                                                <a href="{{ route('approveEvent', $item->id) }}" class="btn btn-success"
                                                    title="Activate Notice">
                                                    <i class="bi bi-check-circle-fill"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="committee-tab-pane" role="tabpanel" aria-labelledby="committee-tab"
                    tabindex="0">
                    <h5>Add New Committee</h5>
                    <form id="new_committee" class="row">
                        <div class="col-sm-12">
                            <div class="form-group mb-3">
                                <label for="committe_name">Committee Name</label>
                                <input type="text" class="form-control" id="committe_name" name="committe_name"
                                    placeholder="Committee Name">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="committe_from">Starting Date</label>
                                <input type="date" class="form-control" id="committe_from" name="committe_from"
                                    placeholder="From">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="committe_to">Expiring Date</label>
                                <input type="date" class="form-control" id="committe_to" name="committe_to"
                                    placeholder="From">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="committe_isActive">Activation Status</label>
                                <select class="form-select" name="committe_isActive" id="committe_isActive">
                                    <option value="1" selected>Active</option>
                                    <option value="0">Disabled</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex flex-column h-100 justify-content-end">
                                <input id="add_committee" class="btn btn-success mb-3" type="submit"
                                    value="Create Committee">
                            </div>
                        </div>
                    </form>
                    <h5 class="pt-4 pt-md-5">All Committee List</h5>
                    <div class="table-responsive">
                        <table id="get_committee_data" class="table table-striped">
                            <thead>
                                <th>#</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">From</th>
                                <th class="text-center">To</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </thead>
                            <tbody>
                                @foreach ($getCommittee as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td class="text-center">{{ $item->from }}</td>
                                        <td class="text-center">{{ $item->to }}</td>
                                        <td class="text-center">
                                            @if ($item->isActive)
                                                Activated
                                            @else
                                                Deactivated
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('EditCommittee', $item->id) }}"
                                                class="btn btn-success me-2">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <a href="{{ route('DeleteCommittee', $item->id) }}"
                                                class="btn btn-danger me-2">
                                                <i class="bi bi-trash3-fill"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- <button id="next_going_to_Committe_member" value="2" class="btn btn-outline-success">
                        <i class="bi bi-arrow-right-square"></i>
                        View Members
                    </button> --}}
                </div>

                {{-- shihab  --}}
                <div class="tab-pane fade" id="committee-member-tab-pane" role="tabpanel"
                    aria-labelledby="committee-tab" tabindex="0">
                    <form class="row" id="committee_member_form" method="post" enctype="multipart/form-data">
                        <div class="col-sm-12">
                            <div class="form-group mb-3">
                                <label for="committee_member_name">Select that member</label>
                                <select class="form-control" id="committee_member_name" name="committee_member_name">
                                    <option selected disabled>Please Select a Member</option>
                                    @foreach ($peopleName as $peopleNames)
                                        <option value="{{ $peopleNames->name }}">{{ $peopleNames->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="cipsMemberId">Write Position</label>
                                <input type="text" class="form-control" id="cipsMemberId" name="cipsMemberId"
                                    placeholder="Member ID">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="position_held">Write Priority Number</label>
                                <input type="number" class="form-control" id="position_held" name="position_held"
                                    placeholder="Member position">
                            </div>
                        </div>
                        {{-- <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="committee_member_image">Image</label>
                                <input type="file" class="form-control" id="committee_member_image"
                                    name="committee_member_image" placeholder="Member profile">
                            </div>
                        </div> --}}
                        {{-- <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="priority">Priority</label>
                                <input type="number" class="form-control" id="priority" name="priority"
                                    placeholder="Serial Priority">
                            </div>
                        </div> --}}

                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="committe_ID">Select Committee Type</label>
                                <select class="form-control" name="committee_type" id="">
                                    <option selected disabled>Please Select a Committee Type</option>
                                    <option value="Executive">Executive Committee</option>
                                    <option value="Advisor">Advisor Committee</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="committe_ID">Select Committee</label>
                                <select class="form-control" name="committe_ID" id="">
                                    <option selected disabled>Please Select a Committee </option>
                                    @foreach ($getCommittee as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="d-flex flex-column h-100 justify-content-end">
                                <input class="btn btn-success mb-3 add_committee_member" type="submit"
                                    value="Add Member">
                            </div>
                        </div>
                    </form>
                    <h5 class="pt-4 pt-md-5">Committee Member List</h5>
                    <div class="table-responsive">
                        <table id="CommitteeMemberData" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th class="text-center">Member Name</th>
                                    <th class="text-center">CIPS Member Id</th>
                                    <th class="text-center">Position Held</th>
                                    <th class="text-center">Committee Name</th>
                                    <th class="text-center">Priority</th>
                                    <th class="text-center">Committee Type</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($getCommitteeMember as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <img height="50px" src="{{ asset($item->imgPath) }}" alt="Profile"
                                                loading="lazy">
                                        </td>
                                        <td class="text-center">{{ $item->committee_member_name }}</td>
                                        <td class="text-center">{{ $item->cipsMemberId }}</td>
                                        <td class="text-center">{{ $item->designation }}</td>
                                        <td class="text-center">{{ $item->name }}</td> 
                                        <td class="text-center">{{ $item->priority }}</td>
                                        <td class="text-center">{{ $item->committee_type }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('EditCommitteeMember', $item->id) }}"
                                                class="btn btn-success me-2">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <a href="{{ route('DeleteCommitteeMember', $item->id) }}"
                                                class="btn btn-danger me-2">
                                                <i class="bi bi-trash3-fill"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="links-tab-pane" role="tabpanel" aria-labelledby="links-tab"
                    tabindex="0">
                    <form id="imp_link_submit" action="{{ route('cips_upload') }}" method="post"
                        enctype="multipart/form-data">
                        <h1>Add Important Links</h1>
                        @csrf
                        <div class="form-group">
                            <label for="link">Link</label>
                            <input type="text" class="form-control" id="link" name="link" required>
                        </div>
                        <div class="form-group">
                            <label for="img_path">Image</label>
                            <input type="file" class="form-control" id="img_path" name="img_path" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Submit</button>
                    </form>

                    <form id="imp_link_update" style="display: none;" action="{{ route('cips_update') }}"
                        method="post" enctype="multipart/form-data">
                        <h1>Update Important Links</h1>
                        @csrf
                        <input id="imp_link_id" type="hidden" name="id" value="">
                        <div class="form-group">
                            <label for="link">Link</label>
                            <input type="text" class="form-control" id="link_upt" name="link" required>
                        </div>
                        <div class="form-group">
                            <label for="img_path">Image</label>
                            <input type="file" class="form-control" id="img_path_upt" name="img_path">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button class="btn btn-danger">Cancel</button>
                    </form>
                    <table class="table mt-3">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Link</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($links as $link)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $link->link }}</td>
                                    <td>
                                        <img class="table-img" src="{{ asset('imp_link_img/' . $link->img_path) }}"
                                            alt="{{ $link->img_path }}" loading="lazy" width="80">
                                    </td>
                                    <td>
                                        <form action="{{ route('delete_cips', $link->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this item?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Edit user Model --}}
                <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <form id="editUserForm" method="POST">
                                @csrf
                                @method('PUT')

                                <input type="hidden" id="editUserId" name="editUserId">
                                
                                <div class="mb-3">
                                    <label for="edit_name" class="form-label">User Name</label>
                                    <input type="text" id="edit_name" name="name" class="form-control" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="edit_email" class="form-label">Email</label>
                                    <input type="email" id="edit_email" name="email" class="form-control" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="edit_cips" class="form-label">Alumni Number</label>
                                    <input type="text" id="edit_cips" name="cips_number" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_role" class="form-label">Role</label>
                                    <select id="edit_role" name="role[]" class="form-control" multiple required>
                                        @foreach ($roles as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button id="saveUserBtn" class="btn btn-primary">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="user-tab-pane" role="tabpanel" aria-labelledby="user-tab"
                    tabindex="0">
                    @if ($persons)
                        <div>
                            <h5 style="text-align: center;">New Person Information </h5>
                        </div>
                        <div>
                            <table class="table table-hover" id="examples5">
                                <thead>
                                    <tr>
                                        <th scope="col"><b>#SL</b></th>
                                        <th scope="col"><b>Name</b></th>
                                        <th scope="col"><b>Alumni Number</b></th>
                                        <th scope="col"><b>Email</b></th>
                                        <th scope="col"><b>Action</b></th>

                                    </tr>
                                </thead>
                                    <tbody>
                                        @foreach ($persons as $person)
                                            @php
                                                $personID = App\Models\Person::where('user_id', $person->id)->first();
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $person->name ?? 'N/A' }}</td>
                                                <td>{{ $personID->alumni_id ?? 'Pending'  }}</td>
                                                <td>{{ $person->email ?? 'N/A' }}</td>
                                            <td>
                                                <a href="{{ route('delete', $person->id) }}" class="btn btn-danger"
                                                    style="margin-left: 10px"><i class="bi bi-trash3"></i></a>
                                                @if ($person->status == 2)
                                                <a href="{{ route('approve', $person->id) }}" class="btn btn-success"
                                                    style="margin-left: 10px"><i class="bi bi-person-plus-fill"></i></a>
                                                @endif
                                                @if ($person->status == 2)
                                                <a href="{{ route('return', $person->id) }}" class="btn btn-warning"
                                                style="margin-left: 10px"><i class="bi bi-arrow-return-left"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    {{-- @endif --}}

                                </tbody>
                            </table>
                        </div>
                    @endif
                    @if ($registered)
                        <div>
                            <h5 style="text-align: center; margin-top:30px">Registered Person Information </h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover" id="examples2">
                                <thead>
                                    <tr>
                                        <th scope="col"><b>SL</b></th>
                                        <th scope="col"><b>Name</b></th>
                                        <th scope="col"><b>Alumni Number</b></th>
                                        <th scope="col"><b>Email</b></th>
                                        <th scope="col"><b>Role</b></th>
                                        <th scope="col"><b>Action</b></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($registered as $person)
                                        @php
                                            $personID = App\Models\Person::where('user_id', $person->id)->first();
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $person->name }}</td>
                                            <td>{{ $personID->alumni_id }}</td>
                                            <td>{{ $person->email }}</td>
                                            {{-- @if ($person->role == 1 && $person->cips == Auth::User()->cips)
                                                <td>Super Admin</td>
                                            @elseif ($person->role == 1)
                                            <td>
                                                    <a href="{{ route('approve', $person->id) }}" class="btn btn-info">
                                                        Make Member
                                                    </a>
                                                </td>
                                            @else
                                                <td>
                                                    <a href="{{ route('promote', $person->id) }}"
                                                        class="btn btn-success">
                                                        Make Admin
                                                    </a>
                                                    <a href="{{ route('demote', $person->id) }}" class="btn btn-danger">
                                                        Make User
                                                    </a>
                                                </td>
                                            @endif --}}
                                            <td>
                                                {{ $person->roles->pluck('name')->implode(', ') }}
                                            </td>
                                            <td>
                                            <button class="btn btn-warning edit-user-btn" 
                                                data-id="{{ $person->id }}"
                                                data-name="{{ $person->name }}"
                                                data-cips="{{ $personID->alumni_id }}"
                                                data-email="{{ $person->email }}"
                                                data-roles='@json($person->roles->pluck("id"))'
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editUserModal">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                            </td>                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
                <div class="tab-pane fade" id="user-request-tab-pane" role="tabpanel" aria-labelledby="user-request-tab"
                    tabindex="0">
                    <h5>User Request</h5>
                    <div class="table-responsive">
                        <table class="table table-hover" id="examples3">
                            <thead>
                                <tr>
                                    <th scope="col"><b>SL</b></th>
                                    <th scope="col"><b>Name</b></th>
                                    <th scope="col"><b>Alumni Number</b></th>
                                    <th scope="col"><b>Email</b></th>
                                    <th scope="col"><b>Action</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($userRequest as $person)
                                    @php
                                        $personID = App\Models\Person::where('user_id', $person->id)->first();
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $person->name }}</td>
                                        <td>{{ $personID->alumni_id }}</td>
                                        <td>{{ $person->email }}</td>
                                        <td>
                                            <a href="{{ route('user.approve', $person->id) }}" class="btn btn-success"
                                                style="margin-left: 10px"><i class="bi bi-check-circle"></i></a>

                                            <a href="{{ route('user.reject', $person->id) }}" class="btn btn-danger"
                                                style="margin-left: 10px"><i class="bi bi-trash3"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="settings-tab-pane" role="tabpanel" aria-labelledby="settings-tab"
                    tabindex="0">
                    <h5>Role & Permission</h5>
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6">
                            <!-- Roles -->
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <h5>Roles</h5>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="float-end">
                    
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal">
                                                    <i class="bx bx-edit-alt me-1"></i> Create Role
                                                </button>
                    
                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form id="Role-Submit">
                                                                @csrf
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Create Role</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <label for="name">Role Name <span class="text-danger">*</span>
                                                                            </label>
                                                                            <input id="name" name="name" value="{{ old('name') }}"
                                                                                type="text" required class="form-control"
                                                                                placeholder="Role Name">
                                                                            <span class="text-danger" id="roleNameError"></span>
                                                                        </div>
                                                                        <div class="col-12 mt-3">
                                                                            <table class="table">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>SL</th>
                                                                                        <th>Permission Name</th>
                                                                                        <th>Action</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody id="Permission-Table-Model">
                    
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" id="Role-Submit" class="btn btn-primary">Save
                                                                        changes</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--Role Edit Modal -->
                                                <div class="modal fade" id="RoleEditModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form id="Role-Edit">
                                                                @csrf
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Eit Role</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <label for="Rolename">Role Name</label>
                                                                            <input id="Rolename" name="Rolename"
                                                                                value="{{ old('Rolename') }}" type="text" required
                                                                                class="form-control" placeholder="Role Name">
                                                                        </div>
                                                                        <div class="col-12 mt-3">
                                                                            <table class="table">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>SL</th>
                                                                                        <th>Permission Name</th>
                                                                                        <th>Action</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody id="Permission-Edit-Data">
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" id="Role-Edit" class="btn btn-primary">Update
                                                                        changes</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive text-nowrap p-3">
                    
                                    <table id="datatable2" class="table">
                                        <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>Role Name</th>
                                                <th>Permissions</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0" id="Role-Table">
                    
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!--/ Roles -->
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <h5>Permissions</h5>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="float-end">
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#Permission">
                                                    <i class="bx bx-edit-alt me-1"></i> Create Permission
                                                </button>
                    
                                                <!-- Parmission Modal -->
                                                <div class="modal fade" id="Permission" tabindex="-1" aria-labelledby="PermissionLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form id="Permission-Submit">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="PermissionLabel">Create Permission</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <label for="name">Permission Name <span
                                                                                    class="text-danger">*</span> </label>
                                                                            <input id="Permissionname" name="Permissionname" type="text"
                                                                                required class="form-control" placeholder="Permission Name">
                                                                            <span class="text-danger" id="permissionNameError"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" id="Permission-Submit"
                                                                        class="btn btn-primary">Save changes</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Edit Parmission Modal -->
                                                <div class="modal fade" id="Edit-Permission" tabindex="-1" aria-labelledby="PermissionLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form id="Edit-Permission-Submit">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="Edit-PermissionLabel">Edit Permission
                                                                    </h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <label for="name">Permission Name</label>
                                                                            <input id="EditPermissionname" name="EditPermissionname"
                                                                                type="text" required class="form-control"
                                                                                placeholder="Permission Name">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" id="Edit-Permission-Submit"
                                                                        class="btn btn-primary">Update changes</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive text-nowrap p-3">
                                    <table id="datatable" class="table">
                                        <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>Permission Name</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0" id="Permission-Table">
                    
                    
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- modal for update committee start -->
    <!-- Button trigger modal -->
    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateCommittee">
        Launch static backdrop modal
    </button> -->
    <div class="modal fade" id="updateCommittee" tabindex="-1" aria-labelledby="updateCommitteeLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="updateCommitteeLabel">Update Committee Information</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row">
                        <input type="hidden" name="committee_id" id="committee_id">
                        <div class="col-sm-12">
                            <div class="form-group mb-3">
                                <label for="update_committe_name">Committee Name</label>
                                <input type="text" class="form-control" id="update_committe_name"
                                    name="update_committe_name" placeholder="Committee Name">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="update_committe_from">Starting Date</label>
                                <input type="date" class="form-control" id="update_committe_from"
                                    name="update_committe_from" placeholder="From">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="update_committe_to">Expiring Date</label>
                                <input type="date" class="form-control" id="update_committe_to"
                                    name="update_committe_to" placeholder="To">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="update_committe_isActive">Is Active</label>
                                <select class="form-select" name="update_committe_isActive"
                                    id="update_committe_isActive">
                                    <option value="1" selected>Active</option>
                                    <option value="0">Disabled</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex flex-column h-100 justify-content-end">
                                <input class="btn btn-success mb-3 committee_update" type="submit" value="Update Data">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('extra_js')
    <script src="{{ asset('frontend_assets/js/committee.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script>
    const userUpdateUrlTemplate = @json(route('user.update', ['id' => '__ID__']));
</script>

    <script>
        //// Fetch ALl Data////
        $(document).ready(function() {
            // Initialize DataTables
            $('#datatable').DataTable();
            $('#datatable2').DataTable();
            // Fetch data using AJAX
            $.ajax({
                url: "{{ route('roles.index') }}",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
        
                    // Populate the table with fetched data
                    populateTable(data);
                },
                error: function(error) {
        
                    console.error('Error fetching data:', error);
                }
            });
        });
        
        function populateTable(data) {
            // Get relevant table bodies
            var roleTableBody = $('#Role-Table');
            var permissionTableBody = $('#Permission-Table');
            var permissionTableModelBody = $('#Permission-Table-Model');
            var roleDropDown = $('#Role-DropDown');
            var editRoleDropDown = $('#EditRole-DropDown');

            // Clear existing table rows
            roleTableBody.empty();
            permissionTableBody.empty();
            permissionTableModelBody.empty();
            roleDropDown.empty();
            editRoleDropDown.empty();

            // Add default options to dropdowns
            roleDropDown.append('<option value="" disabled selected>Select a Role</option>');
            editRoleDropDown.append('<option value="" disabled selected>Select a Role</option>');

            // Populate roles
            $.each(data.data, function(index, role) {
                var permissionsHTML = '';
                $.each(role.permissions, function(i, permission) {
                    permissionsHTML += '<div class="bg-green-500 p-1 rounded font-bold">' + permission.name + '</div>';
                });

                var row = $('<tr>')
                    .append('<td>' + (index + 1) + '</td>')
                    .append('<td>' + role.name + '</td>')
                    .append('<td class="flex flex-wrap gap-2">' + permissionsHTML + '</td>')
                    .append('<td><span class="badge bg-primary">Active</span></td>')
                    .append('<td>' +
                        '<div class="dropdown">' +
                        '<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">' +
                        '<i class="bx bx-dots-vertical-rounded"></i>' +
                        '</button>' +
                        '<div class="dropdown-menu">' +
                        '<button type="button" class="dropdown-item editRoleBtn" data-editrole-id="' + role.id + '">' +
                        '<i class="bx bx-edit-alt me-1"></i> Edit</button>' +
                        '<button type="button" class="dropdown-item deleteRoleBtn" data-role-id="' + role.id + '">' +
                        '<i class="bx bx-trash me-1"></i> Delete</button>' +
                        '</div></div></td>');

                roleTableBody.append(row);

                roleDropDown.append('<option value="' + role.name + '">' + role.name + '</option>');
                editRoleDropDown.append('<option value="' + role.name + '">' + role.name + '</option>');
            });

            // Populate permissions
            $.each(data.permissions, function(index, permission) {
                var rowHtml = '<tr>' +
                    '<td>' + (index + 1) + '</td>' +
                    '<td>' + permission.name + '</td>' +
                    '<td><span class="badge bg-primary">Active</span></td>' +
                    '<td>' +
                    '<div class="dropdown">' +
                    '<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">' +
                    '<i class="bx bx-dots-vertical-rounded"></i>' +
                    '</button>' +
                    '<div class="dropdown-menu">' +
                    '<button type="button" class="dropdown-item editpermissionBtn" data-editpermission-id="' + permission.id + '">' +
                    '<i class="bx bx-edit-alt me-1"></i> Edit</button>' +
                    '<button type="button" class="dropdown-item deletepermissionBtn" data-permission-id="' + permission.id + '">' +
                    '<i class="bx bx-trash me-1"></i> Delete</button>' +
                    '</div></div></td>' +
                    '</tr>';

                permissionTableBody.append(rowHtml);

                var permissionModelRowHtml = '<tr>' +
                    '<td>' + (index + 1) + '</td>' +
                    '<td>' + permission.name + '</td>' +
                    '<td><input value="' + permission.id + '" type="checkbox" name="permission[]" class="permission-checkbox"></td>' +
                    '</tr>';

                permissionTableModelBody.append(permissionModelRowHtml);
            });
        }

        
        //// Role Create////
        $(document).ready(function() {
            $('#Role-Submit').on('submit', function(e) {
                e.preventDefault();
                var name = $('#name').val();
                var permissions = $('.permission-checkbox:checked').map(function() {
                    return parseInt(this.value); 
                }).get();
                        
                // Use the Fetch API for AJAX request
                fetch("{{ route('settings.permissionStore') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        },
                        body: JSON.stringify({
                            name: name,
                            permission: permissions,
                        }),
                    })
                    .then(response => {
                        if (!response.ok) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('data', data);
                        // Data saved successfully
                        $('#exampleModal').modal('hide');
                        // Use SweetAlert for success
                        Toastify({
                            text: "Role Created Successfully!",
                            duration: 3000,
                            close: true,
                            gravity: "top", // Add this to change position
                            position: "right", // Add this to change position
                            backgroundColor: "green", // Set a different background color
                            stopOnFocus: true, // Stop timeout when the window gets focus
                        }).showToast();
        
                        // Fetch data again to refresh the table
                        $.ajax({
                            url: "{{ route('roles.index') }}", // Replace with your actual route
                            type: 'GET',
                            dataType: 'json',
                            success: function(data) {
        
                                // Populate the table with fetched data
                                populateTable(data);
                            },
                            error: function(error) {
        
                                console.error('Error fetching data:', error);
                            }
                        });
        
                        // Reset the form
                        $('#Role-Submit').trigger('reset');
                    })
                    .catch(error => {
                        //clear the error message
                        $('#roleNameError').text('');
                        $('#roleNameError').removeClass('text-danger');
        
                        //set the error message
                        $('#roleNameError').text(error.responseJSON.errors.name[0]);
                    });
            });
        });
        
        //// Role Delete////
        $(document).on('click', '.deleteRoleBtn', function(e) {
            e.preventDefault();
            var roleId = $(this).data('role-id');
        
            // Use SweetAlert for confirmation
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If user confirms, send Ajax request
                    $.ajax({
                        type: "DELETE",
                        url: "{{ url('roles') }}" + '/' + roleId,
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(data) {
                            // Handle success, e.g., remove the row from the table
                            Toastify({
                                text: "Role Delete Successfully!",
                                duration: 3000,
                                close: true,
                                gravity: "top", // Add this to change position
                                position: "right", // Add this to change position
                                backgroundColor: "red", // Set a different background color
                                stopOnFocus: true, // Stop timeout when the window gets focus
                            }).showToast();
        
                            // Fetch data again to refresh the table
                            $.ajax({
                                url: "{{ route('roles.index') }}",
                                type: 'GET',
                                dataType: 'json',
                                success: function(data) {
        
                                    // Populate the table with fetched data
                                    populateTable(data);
                                },
                                error: function(error) {
        
                                    console.error('Error fetching data:', error);
                                }
                            });
                        },
                        error: function(data) {
                            Swal.fire(
                                'Error!',
                                'There was an error deleting the role.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
        
        // Role Edit
        // Set up a global variable to store the current edit role ID
        var currentEditRoleId = null;
        
        // Handle the click event for the "Edit" button on the table
        $(document).on('click', '.editRoleBtn', function() {
            var roleId = $(this).data('editrole-id');
        
            // Fetch edit data using Ajax
            $.ajax({
                url: "{{ url('roles') }}/" + roleId + "/edit",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Populate the modal form with fetched data
                    populateEditForm(data);
                },
                error: function(error) {
                    console.error('Error fetching edit data:', error);
                }
            });
        });
        
        // Function to populate the modal form with edit data
        function populateEditForm(data) {
            // Set role name in the input field
            $('#Rolename').val(data.role.name);
        
            // Clear existing rows in the permission table
            $('#Permission-Edit-Data').empty();
        
            $.each(data.permissions, function(index, permission) {
                var serialno = index + 1;
        
                // Check if the permission ID is in the data array
                var isChecked = data.data.includes(permission.id);
        
                // Build the HTML for the checkbox and append it to the table row
                var checkboxHTML = '<td><input value="' + permission.id +
                    '" type="checkbox" name="permission[]" class="Checkedpermission" ' + (isChecked ? 'checked' :
                        '') +
                    '></td>';
        
                // Create the table row and append it to the table body
                var row = $('<tr>')
                    .append('<td>' + serialno + '</td>')
                    .append('<td>' + permission.name + '</td>')
                    .append(checkboxHTML);
        
                $('#Permission-Edit-Data').append(row);
            });
        
            // Set role ID in a global variable
            currentEditRoleId = data.role.id;
        
            // Open the modal
            $('#RoleEditModal').modal('show');
        }
        
        // Handle the form submit event for the "Edit" form
        $('#Role-Edit').on('submit', function(e) {
            e.preventDefault();
        
            // Get the values from the form
            var roleId = currentEditRoleId;
            var name = $('#Rolename').val();
            var permissions = $('.Checkedpermission:checked').map(function() {
                return this.value;
            }).get();
            console.log(permissions);
        
            // Use the Fetch API for AJAX request
            fetch("{{ url('roles') }}" + '/' + roleId, {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    body: JSON.stringify({
                        name: name,
                        permissions: permissions,
                    }),
                })
                .then(response => {
                    if (!response.ok) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    // Data saved successfully
                    $('#RoleEditModal').modal('hide');
                    // Use SweetAlert for success
                    Toastify({
                        text: "Role Updated Successfully!",
                        duration: 3000,
                        close: true,
                        gravity: "top", // Add this to change position
                        position: "right", // Add this to change position
                        backgroundColor: "green", // Set a different background color
                        stopOnFocus: true, // Stop timeout when the window gets focus
                    }).showToast();
        
                    // Fetch data again to refresh the table
                    $.ajax({
                        url: "{{ route('roles.index') }}",
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            // Populate the table with fetched data
                            populateTable(data);
                        },
                        error: function(error) {
                            console.error('Error fetching data:', error);
                        }
                    });
        
                    // Reset the form
                    $('#Role-Edit').trigger('reset');
                })
                .catch(error => {
                    // Handle errors
                    $('#RoleEditModal').modal('hide');
                    // Use SweetAlert for error
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        showConfirmButton: false,
                        timer: 1500
                    });
                });
        });
        
        
        // Permission Create
        $(document).ready(function() {
            $('#Permission-Submit').on('submit', function(e) {
                e.preventDefault();
                var name = $('#Permissionname').val();
                console.log('data', name);
        
                // Use the Fetch API for AJAX request
                fetch("{{ route('permissions.store') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        },
                        body: JSON.stringify({
                            name: name,
                        }),
                    })
                    .then(response => {
                        if (!response.ok) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                            });
                        }
                    })
                    .then(data => {
                        // Data saved successfully
                        $('#Permission').modal('hide');
                        // Use SweetAlert for success
                        Toastify({
                            text: "Permission Created Successfully!",
                            duration: 3000,
                            close: true,
                            gravity: "top", // Add this to change position
                            position: "right", // Add this to change position
                            backgroundColor: "green", // Set a different background color
                            stopOnFocus: true, // Stop timeout when the window gets focus
                        }).showToast();
        
                        $('#Permission-Submit').trigger('reset');
        
                        // Fetch data using AJAX
                        $.ajax({
                            url: "{{ route('roles.index') }}", // Replace with your actual route
                            type: 'GET',
                            dataType: 'json',
                            success: function(data) {
        
                                // Populate the table with fetched data
                                populateTable(data);
                            },
                            error: function(error) {
        
                                console.error('Error fetching data:', error);
                            }
                        });
                    })
                    .catch(error => {
                        //clear the error message
                        $('#permissionNameError').text('');
                        $('#permissionNameError').removeClass('text-danger');
        
                        //set the error message
                        $('#permissionNameError').text(error.responseJSON.errors.name[0]);
                    });
            });
        });
        
        // Permission Delete
        $(document).on('click', '.deletepermissionBtn', function(e) {
            e.preventDefault();
            var permissionId = $(this).data('permission-id');
        
            // Use SweetAlert for confirmation
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If user confirms, send Ajax request
                    $.ajax({
                        type: "DELETE",
                        url: "{{ url('permissions') }}" + '/' + permissionId,
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(data) {
                            // Handle success, e.g., remove the row from the table
                            Toastify({
                                text: "Permission Delete Successfully!",
                                duration: 3000,
                                close: true,
                                gravity: "top", // Add this to change position
                                position: "right", // Add this to change position
                                backgroundColor: "red", // Set a different background color
                                stopOnFocus: true, // Stop timeout when the window gets focus
                            }).showToast();
        
                            // Fetch data again to refresh the table
                            $.ajax({
                                url: "{{ route('roles.index') }}",
                                type: 'GET',
                                dataType: 'json',
                                success: function(data) {
        
                                    // Populate the table with fetched data
                                    populateTable(data);
                                },
                                error: function(error) {
        
                                    console.error('Error fetching data:', error);
                                }
                            });
                        },
                        error: function(data) {
                            Swal.fire(
                                'Error!',
                                'There was an error deleting the permission.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
        
        //// Permission Edit
        // Set up a global variable to store the current edit permission ID
        var currentEditPermissionId = null;
        
        // Handle the click event for the "Edit" button
        $(document).on('click', '.editpermissionBtn', function() {
            var permissionId = $(this).data('editpermission-id');
        
            // Fetch edit data using Ajax
            $.ajax({
                url: "{{ url('permissions') }}/" + permissionId + "/edit",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Populate the modal form with fetched data
                    populateEditPermissionForm(data);
                },
                error: function(error) {
                    console.error('Error fetching edit data:', error);
                }
            });
        });
        
        // Function to populate the modal form with edit data
        function populateEditPermissionForm(data) {
            // Set permission name in the input field
            $('#EditPermissionname').val(data.permissions.name);
        
            // Set permission ID in a global variable
            currentEditPermissionId = data.permissions.id;
        
            // Open the modal
            $('#Edit-Permission').modal('show');
        }
        
        // Handle the form submit event for the "Edit" form
        $('#Edit-Permission-Submit').on('submit', function(e) {
            e.preventDefault();
        
            // Get the values from the form
            var EditPermissionId = currentEditPermissionId;
            var name = $('#EditPermissionname').val();
        
            // Use the Fetch API for AJAX request
            fetch("{{ url('permissions') }}" + '/' + EditPermissionId, {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    body: JSON.stringify({
                        name: name,
                    }),
                })
                .then(response => {
                    if (!response.ok) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                        });
                    }
                })
                .then(data => {
                    // Data saved successfully
                    $('#Edit-Permission').modal('hide');
                    // Use SweetAlert for success
                    Toastify({
                        text: "Permission Updated Successfully!",
                        duration: 3000,
                        close: true,
                        gravity: "top", // Add this to change position
                        position: "right", // Add this to change position
                        backgroundColor: "green", // Set a different background color
                        stopOnFocus: true, // Stop timeout when the window gets focus
                    }).showToast();
        
                    // Fetch data again to refresh the table
                    $.ajax({
                        url: "{{ route('roles.index') }}",
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            // Populate the table with fetched data
                            populateTable(data);
                        },
                        error: function(error) {
                            console.error('Error fetching data:', error);
                        }
                    });
        
                    // Reset the form
                    $('#Edit-Permission-Submit').trigger('reset');
                })
                .catch(error => {
                    // Handle errors
                    $('#Edit-Permission').modal('hide');
                    // Use SweetAlert for error
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        show: false,
                        timer: 1500,
                        text: 'Something went wrong!',
                    });
                });
        });

        $(document).ready(function () {
            $('.edit-user-btn').on('click', function () {
                const button = $(this);
                const id = button.data('id');
                const name = button.data('name');
                const email = button.data('email');
                const cips = button.data('cips');
                const roles = $(this).data('roles');

                $('#editUserId').val(id);
                $('#edit_name').val(name);
                $('#edit_email').val(email);
                $('#edit_cips').val(cips);
                $('#edit_role').val(roles).trigger('change');

                $('#editUserForm').data('user-id', id);
            });

            $('#edit_role').select2({
                placeholder: 'Select Role',
                allowClear: true,
                width: '100%',
                dropdownParent: $('#editUserModal')
            });

            $('#saveUserBtn').on('click', function () {
                const userId = $('#editUserId').val(); 
                const formData = new FormData();

                formData.append('_method', 'PATCH'); 
                formData.append('name', $('#edit_name').val());
                formData.append('email', $('#edit_email').val());
                formData.append('cips_number', $('#edit_cips').val());
                $('#edit_role').find(':selected').each(function () {
                    formData.append('roles[]', $(this).val());
                });

                const url = userUpdateUrlTemplate.replace('__ID__', userId);

                $.ajax({
                    url: url,
                    type: 'POST', 
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        $('#editUserModal').modal('hide');
                        Swal.fire({
                            title: 'Success!',
                            text: 'User updated successfully.',
                            icon: 'success',
                            confirmButtonText: 'OK',
                        }).then(() => {
                            location.reload(); 
                        });
                    },
                    error: function (xhr) {
                        $('#editUserModal').modal('hide');
                        Swal.fire({
                            title: 'Error!',
                            text: xhr.responseJSON?.message || 'Failed to update user. Please try again.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                        });
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    
    </script>

@endsection
