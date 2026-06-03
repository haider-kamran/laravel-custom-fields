<div class="mb-3 form-group form-check form-switch">
    <!-- Hidden input ensures a value is sent even if unchecked -->
    <input type="hidden" name="custom_fields[{{ $field->name }}]" value="0">
    <input class="form-check-input @error('custom_fields.'.$field->name) is-invalid @enderror" 
           type="checkbox" 
           role="switch" 
           name="custom_fields[{{ $field->name }}]" 
           id="cf_{{ $field->name }}" 
           value="1"
           @if($value) checked @endif>
    <label class="form-check-label" for="cf_{{ $field->name }}">
        {{ $field->label }}
        @if($field->required) <span class="text-danger">*</span> @endif
    </label>

    @error('custom_fields.'.$field->name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
