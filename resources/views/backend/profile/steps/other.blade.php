<div class="card p-3">
    <h5>Other Information</h5>
    <form id="form-step-4" method="POST" action="{{ route('profile.update.other') }}">
        @csrf

        {{-- <div class="mb-3">
            <label>Available for Job</label>
            <select name="availability" class="form-control">
                <option value="yes" {{ $user->availability == 'yes' ? 'selected' : '' }}>Yes</option>
                <option value="no" {{ $user->availability == 'no' ? 'selected' : '' }}>No</option>
            </select>
        </div> --}}

        <!-- Skills Section -->
        <div class="mb-3">
            <label>Skill Description</label>
            <textarea name="skill_description" class="form-control">{{ old('skill_description', $person->skill_description) }}</textarea>
        </div>

        <div id="skills-container">
            @php $skillIndex = 0; @endphp
            @foreach($skills as $skill)
                <div class="skill-entry mb-3">
                    <h6>Skill {{ $loop->iteration }}</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" name="skills[{{ $skillIndex }}][name]" class="form-control" placeholder="Skill Name" value="{{ $skill->name }}">
                        </div>
                        <div class="col-md-6">
                            <label>Skill Learned By:</label><br>
                            @php
                                $methods = is_array($skill->learned_by) ? $skill->learned_by : json_decode($skill->learned_by, true) ?? [];
                            @endphp
                            <div class="form-check form-check-inline">
                                <input type="checkbox" name="skills[{{ $skillIndex }}][learned_by][]" value="Training" class="form-check-input" {{ in_array('Training', $methods) ? 'checked' : '' }}> Training
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="checkbox" name="skills[{{ $skillIndex }}][learned_by][]" value="Self-taught" class="form-check-input" {{ in_array('Self-taught', $methods) ? 'checked' : '' }}> Self-taught
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="checkbox" name="skills[{{ $skillIndex }}][learned_by][]" value="Experience" class="form-check-input" {{ in_array('Experience', $methods) ? 'checked' : '' }}> Experience
                            </div>
                        </div>
                        <div class="col-md-12 mt-2">
                            <button type="button" class="btn btn-danger remove-skill">Remove</button>
                        </div>
                    </div>
                </div>
                @php $skillIndex++; @endphp
            @endforeach
        </div>



        <button type="button" class="btn btn-secondary" id="add-skill-btn">Add More Skill</button>
        <br><br>


        <!-- Language Proficiency Section -->
        <div class="mb-3">
            <label>Language Proficiency</label>
            <div id="language-container">
                @php $languageIndex = 0; @endphp
                @foreach($languages as $language)
                    <div class="row mb-2 language-row">
                        <div class="col-md-5">
                            <input type="text" name="languages[{{ $languageIndex }}][name]" class="form-control" placeholder="Language" value="{{ $language->language }}">
                        </div>
                        <div class="col-md-5">
                            <select name="languages[{{ $languageIndex }}][level]" class="form-control">
                                <option value="">Select Proficiency</option>
                                <option value="Beginner" {{ $language->speaking == 'Beginner' ? 'selected' : '' }}>Beginner</option>
                                <option value="Intermediate" {{ $language->speaking == 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                                <option value="Fluent" {{ $language->speaking == 'Fluent' ? 'selected' : '' }}>Fluent</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger remove-language">Remove</button>
                        </div>
                    </div>
                    @php $languageIndex++; @endphp
                @endforeach
            </div>
            <button type="button" class="btn btn-secondary" id="add-language">Add Language</button>
        </div>

        <button type="button" class="btn btn-primary save-step">Save</button>
    </form>
</div>

<script>
$(document).ready(function () {
    let skillCount = {{ count($skills) }};  // Initialize skillCount using the existing number of skills
    let languageIndex = {{ count($languages) }};  // Initialize languageIndex using the existing number of languages

    // Add Skill
    $('#add-skill-btn').on('click', function () {
        skillCount++;
        const skillHtml = `
            <div class="skill-entry mb-3">
                <h6>Skill ${skillCount}</h6>
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="skills[${skillCount - 1}][name]" class="form-control" placeholder="Skill Name">
                    </div>
                    <div class="col-md-6">
                        <label>Skill Learned By:</label><br>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" name="skills[${skillCount - 1}][learned_by][]" value="Training" class="form-check-input"> Training
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" name="skills[${skillCount - 1}][learned_by][]" value="Self-taught" class="form-check-input"> Self-taught
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" name="skills[${skillCount - 1}][learned_by][]" value="Experience" class="form-check-input"> Experience
                        </div>
                    </div>
                    <div class="col-md-12 mt-2">
                        <button type="button" class="btn btn-danger remove-skill">Remove</button>
                    </div>
                </div>
            </div>
        `;

        $('#skills-container').append(skillHtml);

        // Fix wizard container height after DOM change
        setTimeout(function () {
            $('#smartwizard').smartWizard("fixHeight");
        }, 250);
    });

    // Remove Skill
    $('#skills-container').on('click', '.remove-skill', function () {
        $(this).closest('.skill-entry').remove();
        skillCount--;
        // Renumber the skills
        $('#skills-container .skill-entry').each(function (index) {
            $(this).find('h6').text(`Skill ${index + 1}`);
            $(this).find('input[name^="skills"]').attr('name', `skills[${index}][name]`);
            $(this).find('input[name^="skills"][type="checkbox"]').each(function () {
                const name = $(this).attr('name').replace(/\[\d+\]/, `[${index}]`);
                $(this).attr('name', name);
            });
        });
    });

    // Add Language
    $('#add-language').on('click', function () {
        $('#language-container').append(`
            <div class="row mb-2 language-row">
                <div class="col-md-5">
                    <input type="text" name="languages[${languageIndex}][name]" class="form-control" placeholder="Language">
                </div>
                <div class="col-md-5">
                    <select name="languages[${languageIndex}][level]" class="form-control">
                        <option value="">Select Proficiency</option>
                        <option value="Beginner">Beginner</option>
                        <option value="Intermediate">Intermediate</option>
                        <option value="Fluent">Fluent</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-language">Remove</button>
                </div>
            </div>
        `);
        languageIndex++;
        // Fix wizard container height after DOM change
        setTimeout(function () {
            $('#smartwizard').smartWizard("fixHeight");
        }, 250);
    });

    // Remove Language
    $('#language-container').on('click', '.remove-language', function () {
        $(this).closest('.language-row').remove();
        languageIndex--;
    });
});
</script>
