<div class="card p-3">
    <h5>Personal Details</h5>
    <div class="d-flex align-items-start mb-3">
        <div style="position: relative; width: 120px; height: 120px; overflow: hidden;">
                <img id="profileImage" src="{{ $person->profileImage ? asset($person->profileImage) : asset('default.png') }}" 
                alt="Profile Photo" 
                style="width: 100%; height: 100%; object-fit: cover; border-radius: 5px; cursor: pointer; border: 1px solid #ddd;">

            <a id="changePhoto" style="position: absolute; z-index: 1; bottom: 0; left: 0; right: 0; background: rgba(0,0,0,0.6); color: white; 
                        text-align: center; font-size: 12px; padding: 4px; cursor: pointer;">
                Change Photo
            </a>
        </div>
    </div>
    <input type="file" id="profileInput" name="photo" style="display: none;">

    <form id="form-step-1" method="POST" action="{{ route('profile.update.personal') }}" enctype="multipart/form-data">
        @csrf
        <div class="row mb-3">
            <div class="col-md-6">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $person->name) }}">
            </div>
            <div class="col-md-6">
                <label>Father's Name</label>
                <input type="text" name="f_name" class="form-control" value="{{ old('f_name', $person->f_name) }}">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label>Mother's Name</label>
                <input type="text" name="m_name" class="form-control" value="{{ old('m_name', $person->m_name) }}">
            </div>
            <div class="col-md-6">
                <label>Date of Birth</label>
                <input type="date" name="dob" class="form-control" value="{{ old('dob', $person->dob) }}">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label>Gender</label>
                <select name="gender" class="form-control">
                    <option value="Male" {{ $person->gender == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ $person->gender == 'Female' ? 'selected' : '' }}>Female</option>
                    <option value="Other" {{ $person->gender == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
            <div class="col-md-6">
                <label>Religion</label>
                <input type="text" name="religion" class="form-control" value="{{ old('religion', $person->religion) }}">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label>Marital Status</label>
                <select name="marital_status" class="form-control">
                    <option value="Single" {{ $person->marital_status == 'Single' ? 'selected' : '' }}>Single</option>
                    <option value="Married" {{ $person->marital_status == 'Married' ? 'selected' : '' }}>Married</option>
                    <option value="Divorced" {{ $person->marital_status == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                </select>
            </div>
            <div class="col-md-6">
                <label>Nationality</label>
                <input type="text" name="nationality" class="form-control" value="{{ old('nationality', $person->nationality) }}">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label>National ID</label>
                <input type="text" name="nid" class="form-control" value="{{ old('nid', $person->nid) }}">
            </div>
            <div class="col-md-6">
                <label>CIPS Membership Status</label>
                <input type="text" name="cips_membership_status" class="form-control" value="{{ old('cips_membership_status', $person->cips_membership_status) }}">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label>Present Address</label>
                <input type="text" name="present_address" class="form-control" value="{{ old('present_address', $person->present_address) }}">
            </div>
            <div class="col-md-6">
                <label>Permanent Address</label>
                <input type="text" name="permanent_address" class="form-control" value="{{ old('permanent_address', $person->permanent_address) }}">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label>Career Type</label>
                <select name="career_type" class="form-control" id="career_type">
                    <option value="">Select Career Type</option>
                    <option value="Entrepreneur" {{ $person->career_type == 'Entrepreneur' ? 'selected' : '' }}>Entrepreneur</option>
                    <option value="Service" {{ $person->career_type == 'Service' ? 'selected' : '' }}>Service</option>
                </select>
            </div>
            <div class="col-md-6">
                <label>Mobile No</label>
                <input type="text" name="mobile_no" class="form-control" value="{{ old('mobile_no', $person->mobile_no) }}">
            </div>
        </div>

        <div id="service_fields" style="display: none;">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Service Category</label>
                    <select name="service_category_id" class="form-control" id="service_category">
                        <option value="">Select Category</option>
                        @foreach($serviceCategories as $category)
                        <option value="{{ $category->id }}" 
                            {{ old('service_category_id', $person->service_type) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Service Sub Category</label>
                    <select name="service_sub_category_id" class="form-control" id="service_sub_category">
                        <option value="">Select Sub Category</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label>Alternative Mobile No</label>
                <input type="text" name="alt_mobile_no" class="form-control" value="{{ old('alt_mobile_no', $person->alt_mobile_no) }}">
            </div>
            {{-- <div class="col-md-6">
                <label>Profile Image</label>
                <input type="file" name="profileImage" class="form-control">
                @if($person->profileImage)
                    <img src="{{ asset('storage/' . $person->profileImage) }}" class="mt-2" width="80">
                @endif
            </div> --}}

        </div>
        {{-- career objective --}}
        <div class="row mb-3">
            <div class="col-md-12">
                <label>Career Objective</label>
                <textarea name="career_objective" class="form-control" rows="4">{{ old('career_objective', $person->career_objective) }}</textarea>
            </div>
        </div>
        {{-- Short Biography --}}
        <div class="row mb-3">
            <div class="col-md-12">
                <label>Short Biography</label>
                <textarea name="short_biography" class="form-control" rows="4">{{ old('short_biography', $person->short_biography) }}</textarea>
            </div>
        </div>

        <button type="button" class="btn btn-primary save-step">Save</button>
    </form>
</div>
