<div class="mb-3">
    <label>Start Date</label>
    <input type="date" name="start_date" class="form-control"
           value="{{ old('start_date', optional($popupNotice)->start_date) }}" required>
</div>

<div class="mb-3">
    <label>End Date</label>
    <input type="date" name="end_date" class="form-control"
           value="{{ old('end_date', optional($popupNotice)->end_date) }}" required>
</div>

<div class="mb-3">
    <label>Upload Image</label>
    <input type="file" name="image" class="form-control" accept="image/*" {{ isset($popupNotice) ? '' : 'required' }}>
    
    @if(isset($popupNotice) && $popupNotice->image)
        <p class="mt-2">Current Image:</p>
        <img src="{{ asset($popupNotice->image) }}" width="120" alt="Current Image">
    @endif
</div>

<!-- <div class="mb-3">
    <label>Status</label>
    <select name="is_active" class="form-control" required>
        <option value="1" {{ old('is_active', optional($popupNotice)->is_active) == 1 ? 'selected' : '' }}>Active</option>
        <option value="0" {{ old('is_active', optional($popupNotice)->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
    </select>
</div> -->
