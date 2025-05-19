@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Popup Notices</h2>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Create Button -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createPopupModal">
        Add New Notice
    </button>

    <!-- Notices Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Image</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($notices as $notice)
            <tr>
                <td>{{ $notice->start_date }}</td>
                <td>{{ $notice->end_date }}</td>
                <td><img src="{{ asset('storage/' . $notice->image) }}" width="80" alt="Notice Image"></td>
                <td>{{ $notice->is_active ? 'Active' : 'Inactive' }}</td>
                <td>
                    <!-- Edit Button -->
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $notice->id }}">Edit</button>

                    <!-- Delete Form -->
                    <form action="{{ route('popup_notices.destroy', $notice->id) }}" method="POST" style="display:inline-block;">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal{{ $notice->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form action="{{ route('popup_notices.update', $notice->id) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Popup Notice</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                @include('popup_notices._form', ['popupNotice' => $notice])
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createPopupModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('popup_notices.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Popup Notice</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @include('popup_notices._form', ['popupNotice' => null])
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
