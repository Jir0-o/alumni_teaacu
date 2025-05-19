@extends('layouts.app')

@section('title', 'My Profile || ' . env('APP_NAME'))

@section('extra_css')
    <style>
        .cv-container {
            background: #fff;
            padding: 30px;
            margin-top: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .cv-header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }
        .cv-header img {
            border-radius: 50%;
            width: 120px;
            height: 120px;
            object-fit: cover;
            margin-right: 20px;
        }
        .cv-header h2 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }
        .cv-section {
            margin-bottom: 30px;
        }
        .cv-section h3 {
            border-bottom: 2px solid #0062cc;
            padding-bottom: 5px;
            margin-bottom: 15px;
            color: #0062cc;
        }
        .cv-section table {
            width: 100%;
            border-collapse: collapse;
        }
        .cv-section table th,
        .cv-section table td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
        }
        .cv-section table th {
            background-color: #f8f9fa;
        }
        .cv-section .info-row {
            display: flex;
            margin-bottom: 10px;
        }
        .cv-section .info-row label {
            width: 200px;
            font-weight: bold;
        }
    </style>
@endsection

@section('content')
    <div class="container cv-container">
        <div class="cv-header">
            <img src="{{ $getPersonalInformation->profileImage ? asset( $getPersonalInformation->profileImage) : asset('default.png') }}" alt="Profile Image">
            <div>
                <h2>{{ $getPersonalInformation->name ?? 'Person' }}</h2>
                <p>{{ $getPersonalInformation->cips_membership_status ?? '' }}</p>
            </div>
        </div>

        {{-- Career objective --}}
        @if ($getPersonalInformation->career_objective)
        <div class="cv-section">
            <h3>Career Objective</h3>
            <p>{{ $getPersonalInformation->career_objective ?? '' }}</p>
        </div>
        @endif

        {{-- short_biography --}}
        @if ($getPersonalInformation->short_biography)
        <div class="cv-section">
            <h3>Short Biography</h3>
            <p>{{ $getPersonalInformation->short_biography ?? '' }}</p>
        </div>
        @endif

        <div class="cv-section">
            <h3>Professional Degrees / Awards / Certificates</h3>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Achievement Title</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Files</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($getAccomplishments as $index => $achievement)
                        @php
                            $files = is_array($achievement->files)
                                ? $achievement->files
                                : (is_string($achievement->files) ? json_decode($achievement->files, true) : []);
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $achievement->title }}</td>
                            <td>{{ $achievement->type }}</td>
                            <td>{{ \Carbon\Carbon::parse($achievement->issued_on)->format('d F Y') }}</td>
                            <td>{{ $achievement->description }}</td>
                            <td>
                                @if (!empty($files))
                                    @foreach ($files as $file)
                                        @php
                                            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                            $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                        @endphp
                                        @if ($isImage)
                                            <a href="{{ asset( $file) }}" target="_blank">
                                                <img src="{{ asset($file) }}" alt="File" style="height: 50px; margin-right: 5px;">
                                            </a>
                                        @else
                                            <a href="{{ asset( $file) }}" target="_blank">{{ basename($file) }}</a><br>
                                        @endif
                                    @endforeach
                                @else
                                    No Files
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="cv-section">
            <h3>Working Experience</h3>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Organization</th>
                        <th>Designation</th>
                        <th>Department</th>
                        <th>Duration (Years)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($getEmployment as $index => $experience)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $experience->organization }}</td>
                            <td>{{ $experience->designation }}</td>
                            <td>{{ $experience->department }}</td>
                            <td>{{ $experience->duration }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="cv-section">
            <h3>Education</h3>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Degree Title</th>
                        <th>Institution</th>
                        <th>Result</th>
                        <th>Passing Year</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($getEducation as $index => $education)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $education->degree_title }}</td>
                            <td>{{ $education->education_institute }}</td>
                            <td>{{ $education->result }}</td>
                            <td>{{ $education->passing_year }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @php
            $user = Auth::user();
            $getSkills = App\Models\Skill::where('user_id', $user->id)->get(); // for skills
            $newGetSkills = App\Models\Person::where('user_id', $user->id)->get(); // for description
        @endphp

        <div class="cv-section">
            <h3>Skills</h3>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Skill Name</th>
                        <th>Skill Learned By</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($getSkills as $index => $skill)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $skill->name }}</td>
                            <td>
                                @if (is_array($skill->learned_by))
                                    {{ implode(', ', $skill->learned_by) }}
                                @else
                                    @php
                                        $learnedBy = json_decode($skill->learned_by, true);
                                    @endphp
                                    {{ is_array($learnedBy) ? implode(', ', $learnedBy) : $skill->learned_by }}
                                @endif
                            </td>
                            {{-- Show description only once in the first row --}}
                            @if ($index === 0)
                                <td rowspan="{{ count($getSkills) }}">{{ $newGetSkills[0]->skill_description }}</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>



        <div class="cv-section">
            <h3>Languages</h3>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Language</th>
                        <th>Proficiency Level</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($getLanguages as $index => $language)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $language->language }}</td>
                            <td>{{ $language->speaking }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="cv-section">
            <h3>About</h3>
            <div class="info-row">
                <label>Full Name:</label>
                <div>{{ $getPersonalInformation->name ?? 'Person' }}</div>
            </div>
            <div class="info-row">
                <label>Email:</label>
                <div>{{ Auth::user()->email }}</div>
            </div>
            <div class="info-row">
                <label>Father's Name:</label>
                <div>{{ $getPersonalInformation->f_name ?? '' }}</div>
            </div>
            <div class="info-row">
                <label>Mother's Name:</label>
                <div>{{ $getPersonalInformation->m_name ?? '' }}</div>
            </div>
            <div class="info-row">
                <label>Date of Birth:</label>
                <div>{{ $getPersonalInformation->dob ?? '' }}</div>
            </div>
            <div class="info-row">
                <label>Gender:</label>
                <div>{{ $getPersonalInformation->gender ?? '' }}</div>
            </div>
            <div class="info-row">
                <label>Religion:</label>
                <div>{{ $getPersonalInformation->religion ?? '' }}</div>
            </div>
            <div class="info-row">
                <label>Marital Status:</label>
                <div>{{ $getPersonalInformation->marital_status ?? '' }}</div>
            </div>
            <div class="info-row">
                <label>Nationality:</label>
                <div>{{ $getPersonalInformation->nationality ?? '' }}</div>
            </div>
            <div class="info-row">
                <label>National ID:</label>
                <div>{{ $getPersonalInformation->nid ?? '' }}</div>
            </div>
            <div class="info-row">
                <label>Present Address:</label>
                <div>{{ $getPersonalInformation->present_address ?? '' }}</div>
            </div>
            <div class="info-row">
                <label>Permanent Address:</label>
                <div>{{ $getPersonalInformation->permanent_address ?? '' }}</div>
            </div>
            <div class="info-row">
                <label>Mobile:</label>
                <div>{{ $getPersonalInformation->mobile_no ?? '' }}</div>
            </div>
            <div class="info-row">
                <label>Career Type:</label>
                <div>{{ $getPersonalInformation->career_type ?? '' }}</div>
            </div>
        </div>
    </div>
@endsection
