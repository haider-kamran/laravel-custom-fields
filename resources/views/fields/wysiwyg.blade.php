<div class="mb-3 form-group">
    <label for="cf_{{ $field->name }}" class="form-label">
        {{ $field->label }} 
        @if($field->required) <span class="text-danger">*</span> @endif
    </label>
    
    <!-- We add the 'wysiwyg-editor' class so your frontend JS (like Quill/TinyMCE) can target it -->
    <textarea 
        name="custom_fields[{{ $field->name }}]" 
        id="cf_{{ $field->name }}" 
        class="form-control wysiwyg-editor @error('custom_fields.'.$field->name) is-invalid @enderror"
        rows="{{ $field->options['rows'] ?? 5 }}"
        @if($field->required) required @endif
    >{{ $value }}</textarea>

    @error('custom_fields.'.$field->name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
