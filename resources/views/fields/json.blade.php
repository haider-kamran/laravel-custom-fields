<div class="mb-3 form-group">
    <label for="cf_{{ $field->name }}" class="form-label">
        {{ $field->label }} <small class="text-muted">(JSON format)</small>
        @if($field->required) <span class="text-danger">*</span> @endif
    </label>
    
    @php
        $displayValue = is_array($value) ? json_encode($value, JSON_PRETTY_PRINT) : $value;
    @endphp

    <textarea 
        name="custom_fields[{{ $field->name }}]" 
        id="cf_{{ $field->name }}" 
        class="form-control font-monospace @error('custom_fields.'.$field->name) is-invalid @enderror"
        rows="{{ $field->options['rows'] ?? 5 }}"
        @if($field->required) required @endif
    >{{ $displayValue }}</textarea>

    @error('custom_fields.'.$field->name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
