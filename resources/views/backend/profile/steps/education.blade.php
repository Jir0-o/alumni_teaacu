<div class="card p-3">
    <h5>Education Information</h5>
    <form id="form-step-2" method="POST" action="{{ route('profile.update.education') }}">
        @csrf
        <div id="education-container" class="container">
            @php
                $educations = collect(old('degree_title') ? collect(old('degree_title'))->map(function ($title, $i) {
                    return [
                        'degree_title' => $title,
                        'major_subject' => old("major_subject.$i"),
                        'education_institute' => old("education_institute.$i"),
                        'result' => old("result.$i"),
                        'passing_year' => old("passing_year.$i"),
                    ];
                }) : ($education ?? []))->filter()->values();

                if ($educations->isEmpty()) {
                    $educations = collect([[
                        'degree_title' => '',
                        'major_subject' => '',
                        'education_institute' => '',
                        'result' => '',
                        'passing_year' => '',
                    ]]);
                }
            @endphp

            @foreach ($educations as $index => $edu)
                <div class="education-entry row mb-3 position-relative">
                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <h6 class="mt-3 mb-0 education-title">Education #{{ $index + 1 }}</h6>
                            @if ($index > 0) 
                            <button type="button" class="btn btn-sm btn-danger remove-employment-btn">
                                <i class="fas fa-trash-alt"></i> Remove
                            </button>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label>Degree Title</label>
                        <input type="text" name="degree_title[]" class="form-control" value="{{ $edu['degree_title'] ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <label>Major Subject</label>
                        <input type="text" name="major_subject[]" class="form-control" value="{{ $edu['major_subject'] ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <label>Institution Name</label>
                        <input type="text" name="education_institute[]" class="form-control" value="{{ $edu['education_institute'] ?? '' }}">
                    </div>
                    <div class="col-md-3">
                        <label>Result</label>
                        <input type="text" name="result[]" class="form-control" value="{{ $edu['result'] ?? '' }}">
                    </div>
                    <div class="col-md-3">
                        <label>Year of Passing</label>
                        <input type="text" name="passing_year[]" class="form-control" value="{{ $edu['passing_year'] ?? '' }}">
                    </div>
                </div>
            @endforeach
        </div>
        <button type="button" class="btn btn-sm btn-secondary mb-3" onclick="addEducationEntry()">Add More</button>
        <button type="button" class="btn btn-primary save-step">Save</button>
    </form>
</div>

<script>
    function addEducationEntry() {
        const $container = $('#education-container');

        const $entryContainer = $('<div>', {
            class: 'education-entry row mb-3 position-relative'
        });

        // Title + Remove Button Container
        const $titleCol = $('<div>', { class: 'col-12 d-flex justify-content-between align-items-center' });
        const $title = $('<h6>', { class: 'mt-3 mb-0 education-title' });

        // Remove button
        const $removeBtn = $('<button>', {
            type: 'button',
            class: 'btn btn-sm btn-danger',
            html: '<i class="fas fa-trash-alt"></i> Remove'
        }).on('click', function () {
            $entryContainer.remove();
            updateEducationTitles(); // Renumber after removal
            $('#smartwizard').smartWizard("fixHeight");
        });

        $titleCol.append($title, $removeBtn);
        $entryContainer.append($titleCol);

        // Clone and reset inputs
        const $baseEntry = $('.education-entry').first().clone();
        $baseEntry.find('input').val('');
        $baseEntry.find('h6').remove(); 
        $baseEntry.find('button').remove(); 
        $entryContainer.append($baseEntry.children());

        $container.append($entryContainer);

        updateEducationTitles(); // Renumber after adding
        $('#smartwizard').smartWizard("fixHeight");
    }

    function updateEducationTitles() {
        $('#education-container .education-entry').each(function (index) {
            const $title = $(this).find('.education-title');
            $title.text(`Education #${index + 1}`);
        });
    }

    $(document).on('click', '.remove-education-btn', function () {
        $(this).closest('.education-entry').remove();
        updateEducationTitles(); 
        $('#smartwizard').smartWizard("fixHeight");
    });
</script>



