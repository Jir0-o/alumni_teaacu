@extends('layouts.app')

@section('title', 'My Profile || ' . env('APP_NAME'))

@section('extra_css')
    <style>
        .emp-profile {
            padding: 3%;
            margin-top: 3%;
            margin-bottom: 3%;
            border-radius: 0.5rem;
            background: #fff;
        }

        .profile-img {
            text-align: center;
        }

        .profile-img .file {
            position: relative;
            overflow: hidden;
            margin-top: 2%;
            width: 70%;
            border: none;
            border-radius: 0;
            font-size: 15px;
            background: #212529b8;
        }

        .profile-img .file input {
            position: absolute;
            opacity: 0;
            right: 0;
            top: 0;
        }

        .profile-head h5 {
            color: #333;
        }

        .profile-head h6 {
            color: #0062cc;
        }

        .profile-edit-btn {
            border: none;
            border-radius: 1.5rem;
            width: 70%;
            padding: 2%;
            font-weight: 600;
            color: #6c757d;
            cursor: pointer;
        }

        .proile-rating {
            font-size: 12px;
            color: #818182;
            margin-top: 5%;
        }

        .proile-rating span {
            color: #495057;
            font-size: 15px;
            font-weight: 600;
        }

        .profile-head .nav-tabs {
            margin-bottom: 5%;
        }

        .profile-head .nav-tabs .nav-link {
            font-weight: 600;
            border: none;
        }

        .profile-head .nav-tabs .nav-link.active {
            border: none;
            border-bottom: 2px solid #0062cc;
        }

        .profile-work {
            padding: 14%;
            margin-top: -15%;
        }

        .profile-work p {
            font-size: 12px;
            color: #818182;
            font-weight: 600;
            margin-top: 10%;
        }

        .profile-work a {
            text-decoration: none;
            color: #495057;
            font-weight: 600;
            font-size: 14px;
        }

        .profile-work ul {
            list-style: none;
        }

        .profile-tab label {
            font-weight: 600;
        }

        .profile-tab p {
            font-weight: 600;
            color: #0062cc;
        }

        @media (max-width:576px) {
            .gap-sm {
                gap: 50px;
            }
        }
    </style>
@endsection

@section('content')
    @if ($getForProfile->status == 1)
    <div class="container emp-profile">
        <div class="alert alert-warning mb-4" role="alert">
            <strong>Note:</strong> Click on <strong>Edit Profile</strong> and fill up all the information in order to get full access.
    </div>
    @elseif ($getForProfile->status == 2)
        <div class="container emp-profile">
            <div class="alert alert-info mb-4" role="alert">
                <strong>Note:</strong> Your profile is under review. You will be notified once it is approved.
            </div>
    @elseif ($getForProfile->status == 3)
        <div class="container emp-profile">
            <div class="alert alert-success mb-4" role="alert">
                <strong>Note:</strong> Your profile is approved. You can now access all features.
            </div>
    @elseif ($getForProfile->status == 5)
        <div class="container emp-profile">
            <div class="alert alert-info mb-4" role="alert">
                <strong>Note:</strong> Your profile edit request is under review. You will be notified once it is approved.
            </div>
    @endif
        <form method="post">
            <div class="row gap-sm">
                <div class="col-lg-3 col-md-3" style="margin-bottom: -40px">
                    <div class="profile-img">
                        <img  src="{{ $getPersonalInformation->profileImage ? asset($getPersonalInformation->profileImage) : asset('default.png') }}" 
                            class="rounded-circle" width="100" height="100" />
                        <div class="file btn btn-lg btn-primary">
                            {{ $getPersonalInformation->name ?? 'Parson' }}
                            <input disabled type="file" name="file" />
                        </div>
                    </div>
                </div> 
                <div class="col-lg-8 col-md-6">
                    <div class="profile-head">
                        <h5>
                            {{ $getPersonalInformation->name ?? 'Parson' }}
                        </h5>
                        <h6>
                            {{ $getPersonalInformation->cips_membership_status ?? ' ' }}
                        </h6>
                        <p class="proile-rating"><span></span></p>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#about"
                                    type="button" role="tab" aria-controls="home" aria-selected="true">About</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                    data-bs-target="#Professional_Degrees" type="button" role="tab"
                                    aria-controls="profile" aria-selected="false"> Professional
                                    Degree/Awards/Certificate</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#experience"
                                    type="button" role="tab" aria-controls="contact" aria-selected="false">Working
                                    Experience</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#education"
                                    type="button" role="tab" aria-controls="contact"
                                    aria-selected="false">Education</button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-1 col-md-3">
                    @if ($getForProfile->status == 1)
                        <a href="{{ route('profile.view') }}" class="btn btn-sm btn-outline-primary mb-2">Edit Profile</a> <br>
                    @endif
                    @if ($getForProfile->status == 3)
                        <a href="{{ route('profile.request') }}" class="btn btn-sm btn-outline-primary mb-2">Edit Request</a> <br>
                    @endif
                    @if ($getForProfile->status == 2 || $getForProfile->status == 3)
                    <a href="{{ route('profile.full_info') }}" class="btn btn-sm btn-outline-primary">View</a>
                    @endif
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-3">
                    {{-- <div class="profile-work">
                        <p>WORK LINK</p>
                        <a href="">Website Link</a><br />
                        <a href="">Bootsnipp Profile</a><br />
                        <a href="">Bootply Profile</a>
                        <p>SKILLS</p>
                        <a href="">Web Designer</a><br />
                        <a href="">Web Developer</a><br />
                        <a href="">WordPress</a><br />
                        <a href="">WooCommerce</a><br />
                        <a href="">PHP, .Net</a><br />
                    </div> --}}
                </div>
                <div class="col-md-9">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="home-tab">
                            <div class="row ">
                                <div class="col-md-6">
                                    <label>Full Name</label>
                                </div>
                                <div class="col-md-6">
                                    <p> {{ $getPersonalInformation->name ?? 'Parson' }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Email</label>
                                </div>
                                <div class="col-md-6">
                                    <p> {{ Auth::user()->email }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>CIPS Membership Status</label>
                                </div>
                                <div class="col-md-6">
                                    <p> {{ $getPersonalInformation->cips_membership_status ?? ' ' }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Father Name</label>
                                </div>
                                <div class="col-md-6">
                                    <p> {{ $getPersonalInformation->f_name ?? ' ' }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Mother Name</label>
                                </div>
                                <div class="col-md-6">
                                    <p> {{ $getPersonalInformation->m_name ?? ' ' }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Date Of Birth</label>
                                </div>
                                <div class="col-md-6">
                                    <p> {{ $getPersonalInformation->dob ?? ' ' }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Gender</label>
                                </div>
                                <div class="col-md-6">
                                    <p> {{ $getPersonalInformation->gender ?? ' ' }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Religion</label>
                                </div>
                                <div class="col-md-6">
                                    <p> {{ $getPersonalInformation->religion ?? ' ' }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Marital Status</label>
                                </div>
                                <div class="col-md-6">
                                    <p> {{ $getPersonalInformation->marital_status ?? ' ' }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Nationality</label>
                                </div>
                                <div class="col-md-6">
                                    <p> {{ $getPersonalInformation->nationality ?? ' ' }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>National ID</label>
                                </div>
                                <div class="col-md-6">
                                    <p> {{ $getPersonalInformation->nid ?? ' ' }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Present Address</label>
                                </div>
                                <div class="col-md-6">
                                    <p> {{ $getPersonalInformation->present_address ?? ' ' }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Permanent Address</label>
                                </div>
                                <div class="col-md-6">
                                    <p> {{ $getPersonalInformation->permanent_address ?? ' ' }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Mobile</label>
                                </div>
                                <div class="col-md-6">
                                    <p> {{ $getPersonalInformation->mobile_no ?? ' ' }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Career Type</label>
                                </div>
                                <div class="col-md-6">
                                    <p> {{ $getPersonalInformation->career_type ?? ' ' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="Professional_Degrees" role="tabpanel"
                            aria-labelledby="profile-tab">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name Of Achievement</th>
                                        <th scope="col">Type Of Achievement</th>
                                        <th scope="col">Achievement Date</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Files</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($getAccomplishments as $getDegrees)
                                    @php
                                        $files = is_array($getDegrees->files)
                                            ? $getDegrees->files
                                            : (is_string($getDegrees->files) ? json_decode($getDegrees->files, true) : []);
                                    @endphp
                                        <tr>
                                            <th scope="row">{{ $loop->index + 1 }}</th>
                                            <td class="example" style="overflow: auto;max-width: 125px;">
                                                {{ $getDegrees->title }}</td>
                                            <td class="example" style="overflow: auto;max-width: 125px;">
                                                {{ $getDegrees->type }}</td>
                                            <td class="example text-center" style="overflow: auto;max-width: 125px;"
                                                scope="col">
                                                {{ $getDegrees->issued_on }}</td>
                                            <td class="example text-center" style="overflow: auto;max-width: 125px;">
                                                {{ $getDegrees->description }}</td>
                                            <td class="example text-center" style="overflow: auto; max-width: 125px;">
                                                @if (!empty($files))
                                                    <div class="d-flex flex-wrap justify-content-center">
                                                        @foreach ($files as $file)
                                                            @php
                                                                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                                                $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                                            @endphp

                                                            <div class="preview-container me-2 mb-2 position-relative" style="max-width: 100px;">
                                                                @if ($isImage)
                                                                    <a href="{{ asset( $file) }}" target="_blank">
                                                                        <img src="{{ asset($file) }}" alt="preview" class="img-fluid rounded shadow-sm" style="max-height: 80px;">
                                                                    </a>
                                                                @else
                                                                    <a href="{{ asset( $file) }}" target="_blank" class="d-block small bg-light border rounded p-1">
                                                                        {{ basename($file) }}
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    No File
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="experience" role="tabpanel" aria-labelledby="contact-tab">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Organization</th>
                                        <th scope="col">Designation</th>
                                        <th scope="col">Department</th>
                                        <th scope="col">Duration</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($getEmployment as $getExperiences)
                                        <tr>
                                            <th scope="row">{{ $loop->index + 1 }}</th>
                                            <td>{{ $getExperiences->organization }}</td>
                                            <td>{{ $getExperiences->designation }}</td>
                                            <td>{{ $getExperiences->department }}</td>
                                            <td>{{ $getExperiences->duration }} Years</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="education" role="tabpanel" aria-labelledby="contact-tab">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Education Level</th>
                                        <th scope="col">Education Institute</th>
                                        <th>University / Board</th>
                                        <th scope="col">Passing Year</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($getEducation as $getEducation)
                                        <tr>
                                            <th scope="row">{{ $loop->index + 1 }}</th>
                                            <td class="example" style="overflow: auto;max-width: 125px;">
                                                {{ $getEducation->degree_title }}</td>
                                            <td class="example" style="overflow: auto;max-width: 125px;">
                                                {{ $getEducation->education_institute }}</td>
                                            <td class="example text-center" style="overflow: auto;max-width: 125px;"
                                                scope="col">
                                                {{ $getEducation->education_board_universities }}</td>
                                            <td class="example text-center" style="overflow: auto;max-width: 125px;">
                                                {{ $getEducation->passing_year }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
