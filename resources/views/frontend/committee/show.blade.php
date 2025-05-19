@extends('layouts.app')

@section('title', 'All Member List || ' . env('APP_NAME'))

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
    </style>
@endsection

@section('content')
    <section class="com-member-details">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-sm-4 col-md-3">
                    <div class="profile-img">
                        <img src="{{ $getCommitteeMember->imgPath?? asset('frontend_assets/img/profile.png') }}" alt="Image" class="rounded-circle" width="150" height="150" />
                    </div>
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tr>
                                <th class="text-center" colspan="2">CIPS Member</th>
                            </tr>
                            <tr>
                                <th>ID</th>
                                <td>: {{ $getCommitteeMember->cipsMemberId }}</td>
                            </tr>
                            <tr>
                                <th>Position</th>
                                <td>: {{ $getCommitteeMember->designation }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-sm-8 col-md-9">
                    <h2>{{ $getCommitteeMember->committee_member_name }}</h2>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia amet repellendus sit, dolore tenetur
                        numquam eaque animi iure quis consectetur dolorem commodi ea eius ipsam quaerat illo quod ducimus
                        dolores.
                        <br>
                        <br>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia amet repellendus sit, dolore tenetur
                        numquam eaque animi iure quis consectetur dolorem commodi ea eius ipsam quaerat illo quod ducimus
                        dolores.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
