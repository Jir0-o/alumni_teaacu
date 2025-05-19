@extends('layouts.app')

@section('title', 'Edit Profile || ' . env('APP_NAME'))

@section('extra_css')
<style>
    #education-container  {
    overflow: hidden;
    width: 100%;
    }

    #employment-container {
    overflow: hidden;
    width: 100%;
    }

    .education-entry {
        margin-bottom: 20px; 
    }

    .education-entry h6 {
        margin-top: 10px;
        font-size: 16px;
        color: #555; 
    }

     .employment-entry h6 {
        margin-top: 10px;
        font-size: 16px;
        color: #555; 
    }

    .preview-container {
    display: inline-block;
    max-width: 120px;
    max-height: 100px;
    overflow: hidden;
    position: relative;
    }

    .preview-img {
        width: 100%;
        height: auto;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .file-box {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 80px;
        width: 100%;
        background: #f8f9fa;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 12px;
        text-align: center;
        padding: 4px;
    }

</style>
<link href="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/css/smart_wizard_all.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/js/jquery.smartWizard.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container mt-4">
    <h4>Edit Profile</h4>

    <!-- Progress bar -->
    <div class="progress mb-3" style="height: 20px;">
        <div id="profileProgress" class="progress-bar bg-success" role="progressbar" style="width: 20%;">
            20% Complete
        </div>
    </div>

    <!-- SmartWizard -->
    <div id="smartwizard">
        <ul class="nav">
            <li><a class="nav-link" href="#step-1"><i class="fa fa-user"></i> Personal</a></li>
            <li><a class="nav-link" href="#step-2"><i class="fa fa-graduation-cap"></i> Education</a></li>
            <li><a class="nav-link" href="#step-3"><i class="fa fa-briefcase"></i> Employment</a></li>
            <li><a class="nav-link" href="#step-4"><i class="fa fa-info-circle"></i> Other Info</a></li>
            <li><a class="nav-link" href="#step-5"><i class="fa fa-award"></i> Accomplishments</a></li>
        </ul>

        <div class="tab-content">
            <div id="step-1" class="tab-pane" role="tabpanel">
                @include('backend.profile.steps.personal')
            </div>
            <div id="step-2" class="tab-pane" role="tabpanel">
                @include('backend.profile.steps.education')
            </div>
            <div id="step-3" class="tab-pane" role="tabpanel">
                @include('backend.profile.steps.employment')
            </div>
            <div id="step-4" class="tab-pane" role="tabpanel">
                @include('backend.profile.steps.other')
            </div>
            <div id="step-5" class="tab-pane" role="tabpanel">
                @include('backend.profile.steps.accomplishments')
            </div>
        </div>
    </div>
        @if (Auth::user()->hasRole('Guest'))
            <div class="d-flex justify-content-end mt-3">
                <button id="submit-button" class="btn btn-primary d-none">Submit</button>
            </div>
        @endif

        @if (Auth::user()->hasRole('Member'))
            <div class="d-flex justify-content-end mt-3">
                <button id="submit-auth" class="btn btn-primary d-none">Submit</button>
            </div>
        @endif
</div>

<script>
    const subCategoryUrlTemplate = @json(route('get.subcategories', ['id' => '__ID__']));
</script>

<script>
    $(function () {
        $('#smartwizard').smartWizard({
            theme: 'arrows',
            toolbarSettings: {
                toolbarPosition: 'bottom',
                showNextButton: true,
                showPreviousButton: true,
                toolbarExtraButtons: []
            },
            anchorSettings: {
                enableAnchorOnDoneStep: true,
                enableAllAnchors: true,
                markDoneStep: true,
                removeDoneStepOnNavigateBack: true,
                enableDoneStep: true
            },
            onStepChanged: function (event, anchorObject, currentStepIndex, previousStepIndex) {
                var totalSteps = $('#smartwizard').find('ul.nav li').length;
                var currentProgress = ((currentStepIndex + 1) / totalSteps) * 100;

                updateProfileProgress(currentProgress);
            }
        });

    $(function () {
        let formChanged = false; 

        $("#smartwizard").on("change", "input, select, textarea", function () {
            formChanged = true; 
        });

        function updateStepProgress(currentStepIndex) {
            const totalSteps = 5; // You have 5 steps
            const progress = ((currentStepIndex + 1) / totalSteps) * 100;

            $('#profileProgress')
                .css('width', progress + '%')
                .text(Math.round(progress) + '% Complete');
        }

        $("#smartwizard").on("leaveStep", function (e, anchorObject, currentStepIndex, nextStepIndex, stepDirection) {
            if (stepDirection === 'forward') {
                let form = $('#form-step-' + (currentStepIndex + 1));
                
                if (!formChanged) {
                    updateStepProgress(nextStepIndex);
                    return true; 
                }

                if (form.length) {
                    let formData = form.serialize();

                    $.ajax({
                        url: form.attr('action'),
                        method: 'POST',
                        data: formData,
                        success: function (response) {
                            Toastify({
                                text: response.message || "Saved successfully!",
                                duration: 3000,
                                close: true,
                                gravity: "top",
                                position: "right",
                                backgroundColor: "#28a745",
                            }).showToast();

                            updateStepProgress(nextStepIndex);

                            formChanged = false;
                        },
                        error: function (xhr) {
                            let errors = xhr.responseJSON?.errors;
                            if (errors) {
                                Object.values(errors).forEach(err => {
                                    Toastify({
                                        text: err[0],
                                        duration: 3000,
                                        close: true,
                                        gravity: "top",
                                        position: "right",
                                        backgroundColor: "#dc3545",
                                    }).showToast();
                                });
                            } else {
                                Toastify({
                                    text: "Failed to save. Please check your inputs.",
                                    duration: 3000,
                                    close: true,
                                    gravity: "top",
                                    position: "right",
                                    backgroundColor: "#dc3545",
                                }).showToast();
                            }
                        }
                    });
                }
            }
        });
    });


        // Profile image upload
        $(document).on('click', '#profileImage', function () {
            $('#profileInput').click();
        });

        $(document).on('click', '#changePhoto', function () {
            $('#profileInput').click();
        });

        // Handle profile image change

        $(document).on('change', '#profileInput', function () {
            let formData = new FormData();
            formData.append('photo', this.files[0]);

            $.ajax({
                url: "{{ route('profile.update.photo') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    $('#profileImage').attr('src', response.new_photo_url);
                    Toastify({
                        text: "Profile photo updated successfully!",
                        duration: 3000,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "#28a745",
                    }).showToast();
                },
                error: function () {
                    Toastify({
                        text: "Error uploading image.",
                        duration: 3000,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "#dc3545",
                    }).showToast();
                }
            });
        });


        // Save buttons for each step
        $(document).on('click', '.save-step', function (e) {
        e.preventDefault();
            const form = $(this).closest('form');
            const url = form.attr('action');
            const data = new FormData(form[0]);

            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    Toastify({
                        text: response.message || "Saved successfully!",
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "#28a745",
                    }).showToast();

                    updateProfileProgress(response.percent || 20);
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON?.errors;
                    if (errors) {
                        Object.values(errors).forEach(err => {
                            Toastify({
                                text: err[0],
                                duration: 3000,
                                close: true,
                                gravity: "top",
                                position: "right",
                                backgroundColor: "#dc3545",
                            }).showToast();
                        });
                    } else {
                        Toastify({
                            text: "Failed to save. Please check your inputs.",
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#dc3545",
                        }).showToast();
                    }
                }
            });
        });

    });

    function updateProfileProgress(percent) {
        $('#profileProgress').css('width', percent + '%').text(Math.round(percent) + '% Complete');
    }

    $(document).ready(function () {
        // Toggle service fields visibility
        function toggleServiceFields() {
            const isService = $('#career_type').val() === 'Service';

            if (isService) {
                $('#service_fields').slideDown(200); 
            } else {
                $('#service_fields').slideUp(200);
            }

            setTimeout(function () {
                $('#smartwizard').smartWizard("fixHeight");
            }, 250); 
        }

        toggleServiceFields(); // Initial check on page load

        $('#career_type').change(function () {
            toggleServiceFields();
        });

        // Fetch subcategories based on category selection
        $('#service_category').on('change', function () {
            let categoryId = $(this).val();
            let subCategoryDropdown = $('#service_sub_category');
            let selectedSubCategoryId = '{{ old('member_sub_subcategory_id', $person->member_sub_subcategory_id) }}';

            subCategoryDropdown.html('<option value="">Loading...</option>');

            let url = subCategoryUrlTemplate.replace('__ID__', categoryId);

            if (categoryId) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        subCategoryDropdown.html('<option value="">Select Sub Category</option>');
                        $.each(data, function (key, subCategory) {
                            subCategoryDropdown.append(
                                $('<option></option>')
                                    .val(subCategory.id)
                                    .text(subCategory.name)
                                    .prop('selected', subCategory.id == selectedSubCategoryId)
                            );
                        });
                    },
                    error: function () {
                        subCategoryDropdown.html('<option value="">Failed to load</option>');
                    }
                });
            } else {
                subCategoryDropdown.html('<option value="">Select Sub Category</option>');
            }
        });

            if ($('#service_category').val()) {
                $('#service_category').trigger('change');
                }

        $('#smartwizard').on("showStep", function(e, anchorObject, stepIndex, stepDirection, stepPosition) {
            var totalSteps = $('#smartwizard ul.nav li').length;

            if (stepIndex === totalSteps - 1) {
                // Last step - hide Next and show Submit
                $('.sw-btn-next').addClass('d-none');
                $('#submit-button').removeClass('d-none');
                $('#submit-auth').removeClass('d-none');
            } else {
                // Any other step - show Next and hide Submit
                $('.sw-btn-next').removeClass('d-none');
                $('#submit-button').addClass('d-none');
                $('#submit-auth').addClass('d-none');
            }
        });
        // Final submit button
        $('#submit-button').on('click', function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to submit your profile?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, submit it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const $btn = $('#submit-button');
                    const form = $('#form-step-5');
                    const url = form.attr('action');
                    const formData = new FormData(form[0]);

                    $btn.prop('disabled', true).text('Saving...');

                    // Step 1: Submit the accomplishments form
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            Toastify({
                                text: response.message || "Accomplishments saved successfully!",
                                duration: 3000,
                                close: true,
                                gravity: "top",
                                position: "right",
                                backgroundColor: "#28a745",
                            }).showToast();

                            updateProfileProgress(response.percent || 20); 

                            $.ajax({
                                url: '{{ route("profile.submit.status") }}',
                                type: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    user_id: '{{ auth()->user()->id }}'
                                },
                                success: function () {
                                    Swal.fire(
                                        'Submitted!',
                                        'Your profile has been successfully submitted.',
                                        'success'
                                    ).then(() => {
                                        window.location.href = "{{ route('Profile.Show') }}";
                                    });
                                },
                                error: function () {
                                    Swal.fire('Error!', 'Status update failed.', 'error');
                                    $btn.prop('disabled', false).text('Final Submit');
                                }
                            });
                        },
                        error: function (xhr) {
                            let errors = xhr.responseJSON?.errors;
                            if (errors) {
                                Object.values(errors).forEach(err => {
                                    Toastify({
                                        text: err[0],
                                        duration: 3000,
                                        close: true,
                                        gravity: "top",
                                        position: "right",
                                        backgroundColor: "#dc3545",
                                    }).showToast();
                                });
                            } else {
                                Toastify({
                                    text: "Failed to save accomplishments. Please check required fields.",
                                    duration: 3000,
                                    close: true,
                                    gravity: "top",
                                    position: "right",
                                    backgroundColor: "#dc3545",
                                }).showToast();
                            }

                            $btn.prop('disabled', false).text('Final Submit');
                        }
                    });
                }
            });
        });


        $('#submit-auth').on('click', function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to submit your profile?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, submit it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const $btn = $('#submit-auth');
                    const form = $('#form-step-5');
                    const url = form.attr('action');
                    const formData = new FormData(form[0]);

                    $btn.prop('disabled', true).text('Saving...');

                    // First: Save the last step data
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            Toastify({
                                text: response.message || "Saved successfully!",
                                duration: 3000,
                                close: true,
                                gravity: "top",
                                position: "right",
                                backgroundColor: "#28a745",
                            }).showToast();

                            updateProfileProgress(response.percent || 20);

                            // Second: Now update the status
                            $.ajax({
                                url: '{{ route("profile.submit.auth") }}',
                                type: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    user_id: '{{ auth()->user()->id }}'
                                },
                                success: function () {
                                    Swal.fire(
                                        'Submitted!',
                                        'Your profile has been successfully submitted.',
                                        'success'
                                    ).then(() => {
                                        window.location.href = "{{ route('Profile.Show') }}";
                                    });
                                },
                                error: function () {
                                    Swal.fire('Error!', 'Status update failed. Please try again.', 'error');
                                    $btn.prop('disabled', false).text('Final Submit');
                                }
                            });
                        },
                        error: function (xhr) {
                            let errors = xhr.responseJSON?.errors;
                            if (errors) {
                                Object.values(errors).forEach(err => {
                                    Toastify({
                                        text: err[0],
                                        duration: 3000,
                                        close: true,
                                        gravity: "top",
                                        position: "right",
                                        backgroundColor: "#dc3545",
                                    }).showToast();
                                });
                            } else {
                                Toastify({
                                    text: "Failed to save. Please check your inputs.",
                                    duration: 3000,
                                    close: true,
                                    gravity: "top",
                                    position: "right",
                                    backgroundColor: "#dc3545",
                                }).showToast();
                            }

                            $btn.prop('disabled', false).text('Final Submit');
                        }
                    });
                }
            });
        });


    });
</script>
@endsection
