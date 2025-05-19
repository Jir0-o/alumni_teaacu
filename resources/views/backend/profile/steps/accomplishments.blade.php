<div class="card p-3">
    <h5>Accomplishments</h5>
    <form id="form-step-5" method="POST" action="{{ route('profile.update.accomplishments') }}" enctype="multipart/form-data">
        @csrf
        
        <div id="accomplishments-wrapper">
        </div>

        <button type="button" class="btn btn-sm btn-success mb-3" id="add-accomplishment">Add More</button>

        <div class="deleted-files-container"></div>

        <button type="button" class="btn btn-primary save-step">Save</button>
    </form>
</div>

<script>
    const savedAccomplishments = @json($accomplishments ?? []);
</script>

<script>

    function formatDate(dateStr) {
        const date = new Date(dateStr);
        if (isNaN(date)) return ''; // if invalid
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }
let count = 0;

function getAccomplishmentBlock(index = count, data = {}) {
    const escape = str => (str || '').replace(/"/g, '&quot;').replace(/'/g, '&#39;');

        const fileList = (data.files || []).map((file, i) => {
            const ext = file.split('.').pop().toLowerCase();
            const isImage = ['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext);

            const preview = isImage
                ? `<img src="/${file}" alt="preview" class="preview-img">`
                : `<div class="file-box">${file.split('/').pop()}</div>`;

            return `
                <div class="preview-container me-2 mb-2 existing-file position-relative" data-file="${file}">
                    ${preview}
                    <button type="button" class="btn btn-sm btn-danger remove-file position-absolute top-0 end-0 p-1" style="line-height: 1; font-size: 14px;">&times;</button>
                    <input type="hidden" name="accomplishments[${index}][existing_files][${i}]" value="${file}">
                </div> 
            `;
        }).join('');

    return `
    <div class="border p-3 mb-3 accomplishment-block">
        <div class="mb-2 d-flex justify-content-between">
            <label><strong>Accomplishment Type</strong></label>
            <button type="button" class="btn btn-danger btn-sm remove-accomplishment">Remove</button>
        </div>

        ${data.id ? `<input type="hidden" name="accomplishments[${index}][id]" value="${data.id}">` : ''}

        <select name="accomplishments[${index}][type]" class="form-control mb-2">
            <option value="">-- Select --</option>
            <option value="Portfolio" ${data.type === 'Portfolio' ? 'selected' : ''}>Portfolio</option>
            <option value="Publications" ${data.type === 'Publications' ? 'selected' : ''}>Publications</option>
            <option value="Awards/Honor" ${data.type === 'Awards/Honor' ? 'selected' : ''}>Awards/Honor</option>
            <option value="Projects" ${data.type === 'Projects' ? 'selected' : ''}>Projects</option>
            <option value="Others" ${data.type === 'Others' ? 'selected' : ''}>Others</option>
        </select>

        <input type="text" name="accomplishments[${index}][title]" class="form-control mb-2" placeholder="Title" value="${escape(data.title)}">
        <input type="date" name="accomplishments[${index}][issued_on]" class="form-control mb-2" value="${formatDate(data.issued_on)}">
        <input type="url" name="accomplishments[${index}][url]" class="form-control mb-2" placeholder="URL" value="${escape(data.url)}">
        <textarea name="accomplishments[${index}][description]" rows="3" class="form-control mb-2" placeholder="Description">${escape(data.description)}</textarea>

        <div class="mb-2">
            <label>Previously Uploaded:</label>
            ${fileList || '<em>No files uploaded</em>'}
        </div>

        <input type="file" name="accomplishments[${index}][files][]" class="form-control" multiple>
    </div>`;
}


$(document).ready(function () {
    // Add saved data if available
    if (savedAccomplishments.length > 0) {
        savedAccomplishments.forEach((acc, idx) => {
            $('#accomplishments-wrapper').append(getAccomplishmentBlock(count, acc));
            count++;
        });
    } else {
        // Add one empty if no data
        $('#accomplishments-wrapper').append(getAccomplishmentBlock());
        count++;
    }

    // Add new entry
    $('#add-accomplishment').on('click', function () {
        $('#accomplishments-wrapper').append(getAccomplishmentBlock());
        count++;
        $('#smartwizard').smartWizard("fixHeight");
    });

    // Remove entry
    $(document).on('click', '.remove-accomplishment', function () {
        $(this).closest('.accomplishment-block').remove();
        $('#smartwizard').smartWizard("fixHeight");
    });
});

$(document).on('click', '.remove-file', function () {
    const $fileDiv = $(this).closest('.existing-file');
    const filePath = $fileDiv.data('file');
    const index = $(this).closest('.accomplishment-block').index('.accomplishment-block');

    const input = `<input type="hidden" name="accomplishments[${index}][deleted_files][]" value="${filePath}">`;
    $(this).closest('.accomplishment-block').append(input);

    $fileDiv.remove(); 
});

</script>

