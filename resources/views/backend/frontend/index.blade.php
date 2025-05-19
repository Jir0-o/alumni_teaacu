@extends('layouts.app')

@section('title', 'frontend || ' . env('APP_NAME'))

<style>
    /* Hide any CKEditor notification banners */
    .cke_notification, 
    .cke_bottom {
        display: none !important;
    }
</style>

@section('content')
    <section class="dashboard-container">
        <div class="container">
            <center>
                <h5>Admin Frontend</h5>
            </center>
            @if (session('success'))
                <div class="alert alert-success mt-2">
                    {{ session('success') }}
                </div>
            @endif
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <!-- <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="overview" data-bs-toggle="tab" data-bs-target="#overview-pane"
                        type="button" role="tab" aria-controls="overview-pane" aria-selected="true">
                        Overview
                    </button>
                </li> -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="messages-tab" data-bs-toggle="tab" data-bs-target="#messages-tab-pane"
                        type="button" role="tab" aria-controls="messages-tab-pane" aria-selected="false">
                        Messages
                    </button>
                </li>
                <!-- <li class="nav-item" role="presentation">
                    <button class="nav-link" id="about-tab" data-bs-toggle="tab" data-bs-target="#about-tab-pane"
                        type="button" role="tab" aria-controls="about-tab-pane" aria-selected="false">
                        About
                    </button>
                </li> -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="gallery-tab" data-bs-toggle="tab" data-bs-target="#gallery-tab-pane"
                        type="button" role="tab" aria-controls="gallery-tab-pane" aria-selected="false">
                        Our Gallery
                    </button>
                </li>
                {{-- home Gallery --}}
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="home-gallery-tab" data-bs-toggle="tab"
                        data-bs-target="#home-gallery-tab-pane" type="button" role="tab"
                        aria-controls="home-gallery-tab-pane" aria-selected="false">
                        Hero Gallery
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="links-tab" data-bs-toggle="tab" data-bs-target="#links-tab-pane"
                        type="button" role="tab" aria-controls="links-tab-pane" aria-selected="false">
                        Important Links
                    </button>
                </li>
                <!-- popup notice -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="popup-notices-tab" data-bs-toggle="tab" data-bs-target="#popup-notices-tab-pane"
                        type="button" role="tab" aria-controls="popup-notices-tab-pane" aria-selected="false">
                        Popup Notices
                    </button>
                </li>
                <!-- about tab -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="about-tab" data-bs-toggle="tab" data-bs-target="#about-tab-pane"
                        type="button" role="tab" aria-controls="about-tab-pane" aria-selected="false">
                        About
                    </button>
                </li>
            </ul>
            <div class="tab-content pt-4" id="myTabContent">
                <div class="tab-pane fade" id="overview-pane" role="tabpanel" aria-labelledby="overview"
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

                <div class="tab-pane fade show active" id="messages-tab-pane" role="tabpanel" aria-labelledby="messages-tab" tabindex="0">
                    <form action="{{ route('profile.updateMessages') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- VC’s Message --}}
                        <div class="mb-4">
                            <h5>VC’s Message</h5>
                            <div class="mb-2">
                                <label for="vc_image" class="form-label">Upload Image (Max 2MB)</label>
                                <input type="file" class="form-control" name="vc_image" id="vc_image" accept="image/*">
                                @if(!empty($message->vc_image))
                                    <img src="{{ asset($message->vc_image ?? 'frontend_assets/img/profile.png') }}" alt="VC Image" class="img-thumbnail mt-2" width="150">
                                @endif
                            </div>
                            <div class="mb-2">
                                <label for="vc_message" class="form-label">Message</label>
                                <textarea name="vc_message" id="vc_message" class="form-control ckeditor" rows="4">{{ old('vc_message', $message->vc_message ?? '') }}</textarea>
                            </div>
                        </div>

                        {{-- Alumni President’s Message --}}
                        <div class="mb-4">
                            <h5>Alumni President’s Message</h5>
                            <div class="mb-2">
                                <label for="president_image" class="form-label">Upload Image (Max 2MB)</label>
                                <input type="file" class="form-control" name="president_image" id="president_image" accept="image/*">
                                @if(!empty($message->president_image))
                                    <img src="{{ asset( $message->president_image) }}" alt="President Image" class="img-thumbnail mt-2" width="150">
                                @endif
                            </div>
                            <div class="mb-2">
                                <label for="president_message" class="form-label">Message</label>
                                <textarea name="president_message" id="president_message" class="form-control ckeditor" rows="4">{{ old('president_message', $message->president_message ?? '') }}</textarea>
                            </div>
                        </div>

                        {{-- Advisor’s Message --}}
                        <div class="mb-4">
                            <h5>Advisor’s Message</h5>
                            <div class="mb-2">
                                <label for="advisor_image" class="form-label">Upload Image (Max 2MB)</label>
                                <input type="file" class="form-control" name="advisor_image" id="advisor_image" accept="image/*">
                                @if(!empty($message->advisor_image))
                                    <img src="{{ asset( $message->advisor_image) }}" alt="Advisor Image" class="img-thumbnail mt-2" width="150">
                                @endif
                            </div>
                            <div class="mb-2">
                                <label for="advisor_message" class="form-label">Message</label>
                                <textarea name="advisor_message" id="advisor_message" class="form-control ckeditor" rows="4">{{ old('advisor_message', $message->advisor_message ?? '') }}</textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Messages</button>
                    </form>
                </div>

                {{-- shihab --}}
                <div class="tab-pane fade" id="gallery-tab-pane" role="tabpanel" aria-labelledby="gallery-tab"
                    tabindex="0">
                    <div class="modal fade" id="addGallery" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog"> 
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add Slide</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('ourGalleryCreate') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Title</label>
                                            <input required type="text" name="title" class="form-control"
                                                id="title" aria-describedby="emailHelp">
                                        </div>
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Slide Image</label>
                                            <input required type="file" name="gallery_image" class="form-control"
                                                id="image">
                                        </div>
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Status</label>
                                            <select required name="is_active" class="form-select"
                                                aria-label="Default select example">
                                                <option value="" disabled>---Select---</option>
                                                <option value="1" selected>Active</option>
                                                <option value="0">Disabled</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="type" class="form-label">Type</label>
                                            <select required name="type" class="form-select"
                                                aria-label="Default select example">
                                                <option value="" disabled>---Select---</option>
                                                <option value="1" selected>Events</option>
                                                <option value="2">Labs</option>
                                                <option value="3">Classroom</option>
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Add</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- edit our gallery --}}
                    <div class="modal fade" id="editOurGallery" tabindex="-1" aria-labelledby="editOurGallery" 
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Slide</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editOurGalleryForm" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="id" id="our_gallery_id">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Title</label>
                                            <input required type="text" name="our_gallery_title" class="form-control"
                                                id="our_gallery_title" aria-describedby="emailHelp">
                                        </div>
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Slide Image</label>
                                            <input required type="file" name="our_gallery_image" class="form-control"
                                                id="our_gallery_image">
                                        </div>
                                        <div class="mb-3">
                                            <img id="our_gallery_image_preview" src="" alt="Image Preview" style="width: 100px; height: 100px;">
                                        </div>
                                        <div class="mb-3">
                                            <label for="type" class="form-label">Type</label>
                                            <select required name="our_gallery_type" id="our_gallery_type" class="form-select">
                                                <option value="" disabled>---Select---</option>
                                                <option value="1">Events</option>
                                                <option value="2">Labs</option>
                                                <option value="3">Classroom</option>
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" id="updateOurGalleryBtn" class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- end edit our gallery --}}
                    <div class="row" style="margin-bottom: 5%">
                        <div class="col-lg-12">
                            <div class="container">
                                <div style="display: flex;justify-content: end;"><button data-bs-toggle="modal"
                                        data-bs-target="#addGallery" class="btn btn-outline-primary btn-sm">Add
                                        Gallery</button></div>
                                @if (session()->has('success'))
                                    <div style="width:30%" class="alert alert-info" role="alert">
                                        <strong>{{ session()->get('success') }}</strong>
                                    </div>
                                @endif
                                @if (session()->has('update'))
                                    <div style="width:30%" class="alert alert-info" role="alert">
                                        <strong>{{ session()->get('update') }}</strong>
                                    </div>
                                @endif
                                @if (session()->has('delete'))
                                    <div style="width:30%" class="alert alert-info" role="alert">
                                        <strong>{{ session()->get('delete') }}</strong>
                                    </div>
                                @endif
                                <div>
                                    <h2 style="text-align: center;">Our Gallery</h2>
                                </div>
                                <div>
                                    <table class="table table-hover" id="examples3">
                                        <thead>
                                            <tr>
                                                <th scope="col"><b>SL</b></th>
                                                <th scope="col"><b>Title</b></th>
                                                <th scope="col"><b>Image</b></th>
                                                <th scope="col"><b>Type</b></th>
                                                <th scope="col"><b>Status</b></th>
                                                <th scope="col"><b>Action</b></th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($getGalleryData as $getGalleryData)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>{{ $getGalleryData->title }}</td>
                                                    <td><img style="width: 50px; height:50px;border-radius: 30px;"
                                                            src="{{ $getGalleryData->gallery_image }}"
                                                        alt="{{ $getGalleryData->gallery_image }}">
                                                    </td>
                                                    <td>
                                                        @if ($getGalleryData->type == 1)
                                                            Events
                                                        @elseif ($getGalleryData->type == 2)
                                                            Labs
                                                        @elseif ($getGalleryData->type == 3)
                                                            Classroom
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($getGalleryData->is_active == 1)
                                                            Active
                                                        @else
                                                            Disabled
                                                        @endif
                                                    <td><a href="{{ route('ourGalleryDelete', encrypt($getGalleryData->id)) }}"
                                                            class="btn btn-outline-danger btn-sm"
                                                            style="margin-left: 10px"><i class="bi bi-trash3"></i></a>
                                                        <a href="javascript:void(0);"
                                                            class="btn btn-outline-success btn-sm editOurGalleryBtn"
                                                            data-id="{{ $getGalleryData->id }}"
                                                            data-edit-url="{{ route('ourEditView', ['id' => ($getGalleryData->id)]) }}"
                                                            data-update-url="{{ route('ourGalleryUpdate', ['id' => $getGalleryData->id]) }}"
                                                            style="margin-left: 10px">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </a>
                                                        @if ($getGalleryData->is_active == 1)
                                                            <a href="{{ route('ourDisabled', encrypt($getGalleryData->id)) }}"
                                                                class="btn btn-outline-warning btn-sm"
                                                                style="margin-left: 10px"><i
                                                                    class="bi bi-toggle-off"></i></a>
                                                        @else
                                                            <a href="{{ route('ourEnable', encrypt($getGalleryData->id)) }}"
                                                                class="btn btn-outline-success btn-sm"
                                                                style="margin-left: 10px"><i
                                                                    class="bi bi-toggle-on"></i></a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="home-gallery-tab-pane" role="tabpanel" aria-labelledby="home-gallery-tab"
                    tabindex="0">
                    <div class="modal fade" id="homeAddGallery" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add Slide</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('homeGalleryCreate') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Title</label>
                                            <input required type="text" name="title" class="form-control"
                                                id="title" aria-describedby="emailHelp">
                                        </div>
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Slide Image</label>
                                            <input required type="file" name="gallery_image" class="form-control"
                                                id="image">
                                        </div>
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Status</label>
                                            <select required name="is_active" class="form-select"
                                                aria-label="Default select example">
                                                <option value="" disabled>---Select---</option>
                                                <option value="1" selected>Active</option>
                                                <option value="0">Disabled</option>
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Add</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- edit home gallery --}}
                    <div class="modal fade" id="editGallery" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Slide</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editGalleryForm" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="id" id="home_gallery_id">
                                        
                                        <!-- Title -->
                                        <div class="mb-3">
                                            <label class="form-label">Title</label>
                                            <input type="text" name="edit_gallery_title" class="form-control" id="home_gallery_title">
                                        </div>

                                        <!-- Image -->
                                        <div class="mb-3">
                                            <label class="form-label">Slide Image</label>
                                            <input type="file" name="edit_gallery_image" class="form-control" id="home_gallery_image">
                                        </div>

                                        <!-- Image Preview -->
                                        <div class="mb-3">
                                            <img id="home_gallery_image_preview" src="" alt="Image Preview" style="width: 100px; height: 100px;">
                                        </div>

                                        <!-- Status -->
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select name="edit_is_active" class="form-select" id="home_gallery_status">
                                                <option value="" disabled>---Select---</option>
                                                <option value="1">Active</option>
                                                <option value="0">Disabled</option>
                                            </select>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" id="updateGalleryBtn">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- end edit home gallery --}}
                    <div class="row" style="margin-bottom: 5%">
                        <div class="col-lg-12">
                            <div class="container">
                                <div style="display: flex;justify-content: end;"><button data-bs-toggle="modal"
                                        data-bs-target="#homeAddGallery" class="btn btn-outline-primary btn-sm">Add
                                        Gallery</button></div>
                                @if (session()->has('success'))
                                    <div style="width:30%" class="alert alert-info" role="alert">
                                        <strong>{{ session()->get('success') }}</strong>
                                    </div>
                                @endif
                                @if (session()->has('update'))
                                    <div style="width:30%" class="alert alert-info" role="alert">
                                        <strong>{{ session()->get('update') }}</strong>
                                    </div>
                                @endif
                                @if (session()->has('delete'))
                                    <div style="width:30%" class="alert alert-info" role="alert">
                                        <strong>{{ session()->get('delete') }}</strong>
                                    </div>
                                @endif
                                <div>
                                    <h2 style="text-align: center;">Hero Gallery</h2>
                                </div>
                                <div>
                                    <table class="table table-hover" id="examples3">
                                        <thead>
                                            <tr>
                                                <th scope="col"><b>SL</b></th>
                                                <th scope="col"><b>Title</b></th>
                                                <th scope="col"><b>Image</b></th>
                                                <th scope="col"><b>Status</b></th>
                                                <th scope="col"><b>Action</b></th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($getHomeGalleryData as $getHomeGalleryData)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>{{ $getHomeGalleryData->title }}</td>
                                                    <td><img style="width: 50px; height:50px;border-radius: 30px;"
                                                            src="{{ $getHomeGalleryData->gallery_image }}"
                                                        alt="{{ $getHomeGalleryData->gallery_image }}">
                                                    </td>

                                                    <td>
                                                        @if ($getHomeGalleryData->is_active == 1)
                                                            Active
                                                        @else
                                                            Disabled
                                                        @endif
                                                    </td>

                                                    <td><a href
                                                            ="{{ route('homeGalleryDelete', encrypt($getHomeGalleryData->id)) }}"
                                                            class="btn btn-outline-danger btn-sm"
                                                            style="margin-left: 10px"><i class="bi bi-trash3"></i></a>
                                                        <a href="javascript:void(0);"
                                                            class="btn btn-outline-success btn-sm editGalleryBtn"
                                                            data-id="{{ $getHomeGalleryData->id }}"
                                                            data-edit-url="{{ route('homeEditView', ['id' => ($getHomeGalleryData->id)]) }}"
                                                            data-update-url="{{ route('homeGalleryUpdate', ['id' => $getHomeGalleryData->id]) }}"
                                                            style="margin-left: 10px">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </a>
                                                        @if ($getHomeGalleryData->is_active == 1)
                                                            <a href="{{ route('homeDisabled', encrypt($getHomeGalleryData->id)) }}"
                                                                class="btn btn-outline-warning btn-sm"
                                                                style="margin-left: 10px"><i
                                                                    class="bi bi-toggle-off"></i></a>
                                                        @else
                                                            <a href="{{ route('homeEnable', encrypt($getHomeGalleryData->id)) }}"
                                                                class="btn btn-outline-success btn-sm"
                                                                style="margin-left: 10px"><i
                                                                    class="bi bi-toggle-on"></i></a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- end home gallery --}}
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

                <div class="tab-pane fade" id="popup-notices-tab-pane" role="tabpanel"
                    aria-labelledby="popup-notices-tab" tabindex="0">
                    <div class="container">
                        <h2 class="mb-4">Popup Notices</h2>

                        <!-- Success Message -->
                        <!-- @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif -->

                        <!-- Create Button -->
                        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createPopupModal">
                            Add New Notice
                        </button>

                        <!-- Notices Table -->
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($popupNotices as $notice)
                                <tr>
                                    <td><img src="{{ asset($notice->image) }}" width="80" alt="Notice Image" class="img-fluid"></td>
                                    <td>{{ $notice->start_date }}</td>
                                    <td>{{ $notice->end_date }}</td>
                                    <td>{{ $notice->is_active ? 'Active' : 'Inactive' }}</td>
                                    <td>
                                        <!-- Edit Button -->
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $notice->id }}">Edit</button>

                                        <!-- Delete Form -->
                                        <form action="{{ route('popup_notices.destroy', $notice->id) }}" method="POST" style="display:inline-block;">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                        <!-- active button -->
                                        <button type="button"
                                            class="btn btn-sm toggle-status-btn {{ $notice->is_active ? 'btn-secondary' : 'btn-success' }}"
                                            data-id="{{ $notice->id }}">
                                            {{ $notice->is_active ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal{{ $notice->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <form action="{{ route('popup_notices.update', $notice->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf @method('PUT')
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Popup Notice</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    @include('frontend.popup_notices._form', ['popupNotice' => $notice])
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
                            <form action="{{ route('popup_notices.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add Popup Notice</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        @include('frontend.popup_notices._form', ['popupNotice' => null])
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="about-tab-pane" role="tabpanel" aria-labelledby="about-tab">
                    <div class="container">
                        <h2 class="mb-4">About Us</h2>

                        <form action="{{ isset($about) ? route('frontend.about.update', $about->id) : route('frontend.about.store') }}" 
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if(isset($about))
                                @method('PUT')
                            @endif

                            <div class="mb-3">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                                @if(isset($about) && $about->image)
                                    <div class="mt-2">
                                        <img src="{{ asset($about->image) }}" width="120" alt="Current Image">
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="about_details" class="form-label">Details</label>
                                <textarea name="about_details" id="about_details" class="form-control" rows="5" required>{!! optional($about)->details !!}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                {{ isset($about) ? 'Update' : 'Submit' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
        CKEDITOR.replace('about_details', {
            height: 300,
            removeButtons: 'PasteFromWord' // optional
        });
    </script>

    <script>
document.querySelectorAll('.toggle-status-btn').forEach(button => {
    button.addEventListener('click', function () {
        const id = this.dataset.id;
        fetch(`/popup-notices/${id}/toggle`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                location.reload(); // or update button text/status dynamically
            } else {
                alert(data.message || 'Failed to toggle status.');
            }
        })
        .catch(err => alert('Something went wrong.'));
    });
});
</script>


    <script>
    $(document).ready(function() {
            $('#examples3').DataTable();
            $('.ckeditor').each(function () {
            CKEDITOR.replace($(this).attr('id'));
        });

        $('.editGalleryBtn').on('click', function () {
            const id = $(this).data('id');
            const editUrl = $(this).data('edit-url');
            const updateUrl = $(this).data('update-url');

            // AJAX GET for editing
            $.ajax({
                url: editUrl,
                method: 'GET',
                success: function (response) {
                    console.log(updateUrl);
                    $('#home_gallery_id').val(response.id);
                    $('#home_gallery_title').val(response.title);
                    $('#home_gallery_image').val('');
                    $('#home_gallery_image_preview').attr('src', response.gallery_image);
                    $('#home_gallery_image_preview').attr('alt', response.gallery_image);
                    $('select[name="edit_is_active"]').val(response.is_active); 

                    $('form#editGalleryForm').attr('action', updateUrl);
                    $('#editGallery').modal('show');
                },
                error: function () {
                    alert('Failed to load gallery data.');
                }
            });
        });


        // Submit form via AJAX
        $('#updateGalleryBtn').on('click', function (e) {
            e.preventDefault();

            const form = $('#editGalleryForm');
            const updateUrl = form.attr('action');
            const formData = new FormData();

            formData.append('_method', 'PUT');
            formData.append('id', $('#home_gallery_id').val());
            formData.append('edit_title', $('#home_gallery_title').val());
            formData.append('edit_is_active', $('#home_gallery_status').val());

            const imageFile = $('#home_gallery_image')[0].files[0];
            if (imageFile) {
                formData.append('edit_gallery_image', imageFile);
            }

            $.ajax({
                url: updateUrl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function () {
                    $('#editGallery').modal('hide');
                    Swal.fire({
                        title: 'Success!',
                        text: 'Gallery updated successfully.',
                        icon: 'success',
                        confirmButtonText: 'OK',
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function (xhr) {
                    $('#editGallery').modal('hide');
                    Swal.fire({
                        title: 'Error!',
                        text: xhr.responseJSON?.message || 'Failed to update gallery.',
                        icon: 'error',
                        confirmButtonText: 'OK',
                    });
                    console.error(xhr.responseText);
                }
            });
        });

        //edit our gallery
        $('.editOurGalleryBtn').on('click', function () {
            const id = $(this).data('id');
            const editUrl = $(this).data('edit-url');
            const updateUrl = $(this).data('update-url');

            // AJAX GET for editing
            $.ajax({
                url: editUrl,
                method: 'GET',
                success: function (response) {
                    console.log(response);
                    $('#our_gallery_id').val(response.id);
                    $('#our_gallery_title').val(response.title);
                    $('#our_gallery_image').val('');
                    $('#our_gallery_image_preview').attr('src', response.gallery_image);
                    $('#our_gallery_image_preview').attr('alt', response.gallery_image);
                    $('#our_gallery_type').val(String(response.type));


                    $('form#editOurGalleryForm').attr('action', updateUrl);
                    $('#editOurGallery').modal('show');
                },
                error: function () {
                    alert('Failed to load gallery data.');
                }
            });
        });
        // Submit form via AJAX
        $('#updateOurGalleryBtn').on('click', function (e) {
            e.preventDefault();

            const form = $('#editOurGalleryForm');
            const updateUrl = form.attr('action');
            const formData = new FormData();

            // Append necessary data
            formData.append('_method', 'PUT');
            formData.append('id', $('#our_gallery_id').val());
            formData.append('title', $('#our_gallery_title').val()); // Ensure correct name
            formData.append('type', $('#our_gallery_type').val());   // Ensure correct name

            // Handle image file if provided
            const imageFile = $('#our_gallery_image')[0].files[0];
            if (imageFile) {
                formData.append('edit_gallery_image', imageFile);
            }

            // Submit the form data via AJAX
            $.ajax({
                url: updateUrl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function () {
                    console.log(formData);
                    $('#editGallery').modal('hide');
                    Swal.fire({
                        title: 'Success!',
                        text: 'Gallery updated successfully.',
                        icon: 'success',
                        confirmButtonText: 'OK',
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function (xhr) {
                    $('#editGallery').modal('hide');
                    Swal.fire({
                        title: 'Error!',
                        text: xhr.responseJSON?.message || 'Failed to update gallery.',
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
