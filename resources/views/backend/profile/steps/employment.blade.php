<div class="card p-3">
    <h5>Employment History</h5>
    <form id="form-step-3" method="POST" action="{{ route('profile.update.employment') }}">
        @csrf
        <div id="employment-container" class="container">
            @php
                $employment = collect(old('organization') ? collect(old('organization'))->map(function ($organization, $i) {
                    return [
                        'organization' => $organization,
                        'designation' => old("designation.$i"),
                        'department' => old("department.$i"),
                        'duration' => old("duration.$i"),
                    ];
                }) : ($employment ?? []))->filter()->values();

                if ($employment->isEmpty()) {
                    $employment = collect([['organization' => '', 'designation' => '', 'department' => '', 'duration' => '']]);
                }
            @endphp

            @foreach ($employment as $index => $emp)
                <div class="employment-entry row mb-3 position-relative">
                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <h6 class="mt-3 mb-0 employment-title">Employment #{{ $index + 1 }}</h6>
                        @if ($index > 0) 
                            <button type="button" class="btn btn-sm btn-danger remove-employment-btn">
                                <i class="fas fa-trash-alt"></i> Remove
                            </button>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label>Organization Name</label>
                        <input type="text" name="organization[]" class="form-control" value="{{ $emp['organization'] ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <label>Designation</label>
                        <input type="text" name="designation[]" class="form-control" value="{{ $emp['designation'] ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <label>Department</label>
                        <input type="text" name="department[]" class="form-control" value="{{ $emp['department'] ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <label>Duration</label>
                        <input type="text" name="duration[]" class="form-control" value="{{ $emp['duration'] ?? '' }}">
                    </div>
                </div>
            @endforeach
        </div>
        <button type="button" class="btn btn-sm btn-secondary mb-3" onclick="addEmploymentEntry()">Add More</button>
        <button type="button" class="btn btn-primary save-step">Save</button>
    </form>
</div>



<script>
    function addEmploymentEntry() {
        const $container = $('#employment-container');

        const $entryContainer = $('<div>', {
            class: 'employment-entry row mb-3 position-relative'
        });

        // Title + Remove Button Container
        const $titleCol = $('<div>', { class: 'col-12 d-flex justify-content-between align-items-center' });
        const $title = $('<h6>', { class: 'mt-3 mb-0 employment-title' });

        const $removeBtn = $('<button>', {
            type: 'button',
            class: 'btn btn-sm btn-danger',
            html: '<i class="fas fa-trash-alt"></i> Remove'
        }).on('click', function () {
            $entryContainer.remove();
            updateEmploymentTitles(); // Renumber after removal
            $('#smartwizard').smartWizard("fixHeight");
        });

        $titleCol.append($title, $removeBtn);
        $entryContainer.append($titleCol);

        // Clone the first entry and reset inputs
        const $baseEntry = $('.employment-entry').first().clone();
        $baseEntry.find('input').val('');
        $baseEntry.find('h6').remove();  // Remove title for cloned entry
        $baseEntry.find('button').remove(); // Remove the remove button for cloned entry

        $entryContainer.append($baseEntry.children());
        $container.append($entryContainer);

        updateEmploymentTitles(); // Renumber the titles
        $('#smartwizard').smartWizard("fixHeight");
    }

    function updateEmploymentTitles() {
        $('#employment-container .employment-entry').each(function (index) {
            const $title = $(this).find('.employment-title');
            $title.text(`Employment #${index + 1}`);
        });
    }

    // Remove button logic
    $(document).on('click', '.remove-employment-btn', function () {
        $(this).closest('.employment-entry').remove();
        updateEmploymentTitles();
        $('#smartwizard').smartWizard("fixHeight");
    });

</script>

