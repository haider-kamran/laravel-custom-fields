<div class="mb-3 form-group">
    <label for="cf_{{ $field->name }}" class="form-label">
        {{ $field->label }} 
        @if($field->required) <span class="text-danger">*</span> @endif
    </label>
    <input type="time" 
           name="custom_fields[{{ $field->name }}]" 
           id="cf_{{ $field->name }}" 
           class="form-control @error('custom_fields.'.$field->name) is-invalid @enderror"
           value="{{ $value }}"
           @if($field->required) required @endif
    >
    @error('custom_fields.'.$field->name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
