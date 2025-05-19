@extends('layouts.app')

@section('title', 'All Member List || ' . env('APP_NAME'))

@section('extra_css')
    <style>
        .fixed-btn {
            right: 50px;
            bottom: 50px;
            position: fixed;
        }

        .jumper {
            animation: jumper 600ms infinite;
        }

        @keyframes jumper {
            0%, 100% {
                padding-bottom: 5px;
            }
            10%, 70% {
                padding-bottom: 0px;
            }
        }
    </style>
@endsection

@section('content')
    <div id="cv-container" class="bg-white">
        <section id="cv-section" class="full-info container">
            <div class="fixed-btn jumper">
            <button id="downloadBtn" class="btn btn-primary">
                <span><i class="bi bi-arrow-down"></i></span>
                Download CV
            </button>
            </div>
            <div class="row justify-content-between align-items-center ">
                <div class="col-md-8 col-lg-9 p-3 bg-primary text-white">
                    <h2 class="text-white">{{ $persons->name }}</h2>
                    <p>
                        Email: 
                        <a class="text-white" href="mailto:{{ $persons->email }}" target="_blank">
                            {{ $persons->email }}
                        </a>
                    </p>
                    <p class="m-0">
                        Contact: 
                        <a class="text-white" href="tel:{{ $persons->mobile_no }}">
                            {{ $persons->mobile_no?? "N/A" }}
                        </a>
                    </p>
                </div>
                <div class="col-md-4 col-lg-3">
                    @if ($persons->profileImage)
                        <img class="img-fluid ml-3" src="{{ asset($persons->profileImage) }}" alt="{{ $persons->name }}"
                            loading="lazy">
                    @else
                        <img class="img-fluid ml-3" src="{{ asset('default.png') }}"
                            alt="{{ $persons->name }}" loading="lazy">
                    @endif
                </div>
            </div>    
            <h4 class="bottom-line">Short Biography:</h4>
            <div class="pt-3" style="border-bottom: 1px solid #DEE2E6; margin-bottom:1rem;">
                <p>
                    {{ $persons->short_biography }}
                </p>
            </div>
            <h4 class="bottom-line">Profession:</h4>
            <div class="pt-3">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Achievement Title</th>
                                <th scope="col">Type</th>
                                <th scope="col">Date</th>
                                <th scope="col">Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($getAccomplishments as $achievement)
                                <tr>
                                    <th scope="row">{{ $loop->index + 1 }}</th>
                                    <td>{{ $achievement->title }}</td>
                                    <td>{{ $achievement->type }}</td>
                                    <td>{{ \Carbon\Carbon::parse($achievement->issued_on)->format('d F Y') }}</td>
                                    <td>{{ $achievement->description }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <h4 class="bottom-line">Working Experience:</h4>
            <div class="pt-3">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Organization</th>
                                <th scope="col">Designation</th>
                                <th scope="col">Department</th>
                                <th scope="col">Duration (Years)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($getEmployment as $experience)
                                <tr>
                                    <th scope="row">{{ $loop->index + 1 }}</th>
                                    <td>{{ $experience->organization }}</td>
                                    <td>{{ $experience->designation }}</td>
                                    <td>{{ $experience->department }}</td>
                                    <td>{{ $experience->duration }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <h4 class="bottom-line">Education:</h4>
            <div class="pt-3">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Degree Title</th>
                                <th scope="col">Institution</th>
                                <th scope="col">Result</th>
                                <th scope="col">Passing Year</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($getEducation as $education)
                                <tr>
                                    <th scope="row">{{ $loop->index + 1 }}</th>
                                    <td>{{ $education->degree_title }}</td>
                                    <td>{{ $education->education_institute }}</td>
                                    <td>{{ $education->result }}</td>
                                    <td>{{ $education->passing_year }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <h4 class="bottom-line">Personal Info:</h4>
            <div class="pt-3">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th>Full Name</th>
                            <td>: {{ $persons->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>: {{ $persons->email }}</td>
                        </tr>
                        <tr>
                            <th>Membership Status</th>
                            <td>: {{ $persons->cips_membership_status }}</td>
                        </tr>
                        <tr> 
                            <th>Father Name</th>
                            <td>: {{ $persons->f_name }}</td>
                        </tr>
                        <tr>
                            <th>Mother Name</th>
                            <td>: {{ $persons->m_name }}</td>
                        </tr>
                        <tr>
                            <th>Date Of Birth</th>
                            <td>: {{ $persons->dob }}</td>
                        </tr>
                        <tr>
                            <th>Gender</th>
                            <td>: {{ $persons->gender }}</td>
                        </tr>
                        <tr>
                            <th>Religion</th>
                            <td>: {{ $persons->religion }}</td>
                        </tr>
                        <tr>
                            <th>Marital Status</th>
                            <td>: {{ $persons->marital_status }}</td>
                        </tr>
                        <tr>
                            <th>Nationality</th>
                            <td>: {{ $persons->nationality }}</td>
                        </tr>
                        <tr>
                            <th>Present Address</th>
                            <td>: {{ $persons->present_address }}</td>
                        </tr>
                        <tr>
                            <th>Permanent Address</th>
                            <td>: {{ $persons->permanent_address }}</td>
                        </tr>
                        <tr>
                            <th>Mobile</th>
                            <td>: {{ $persons->mobile_no }}</td>
                        </tr>
                        <tr>
                            <th>Career Type</th>
                            <td>: {{ $persons->career_type }}</td>
                        </tr>
                    </table>
                </div>
            </div>    
        </section>
    </div>

<script>
    document.getElementById('downloadBtn').addEventListener('click', function () {
        const element = document.getElementById('cv-section');
        const opt = {
            margin:       0.5,
            filename:     'cv-section.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2 },
            jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
        };
        html2pdf().set(opt).from(element).save();
    });
</script>
@endsection
