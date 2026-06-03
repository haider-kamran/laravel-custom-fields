<div class="mb-3 form-group">
    <label for="cf_{{ $field->name }}" class="form-label">
        {{ $field->label }} 
        @if($field->required) <span class="text-danger">*</span> @endif
    </label>
    
    @php
        // $value could be an array of file metadata if previously uploaded
        $fileData = is_array($value) ? $value : json_decode((string)$value, true);
    @endphp

    @if(!empty($fileData) && isset($fileData['url']))
        <div class="mb-2">
            <span class="badge bg-info text-dark">Current File:</span>
            <a href="{{ $fileData['url'] }}" target="_blank" class="text-decoration-none">
                {{ $fileData['name'] ?? 'View File' }}
            </a>
            <small class="text-muted ms-2">({{ round(($fileData['size'] ?? 0) / 1024, 2) }} KB)</small>
        </div>
    @endif

    <input type="file" 
           name="custom_fields[{{ $field->name }}]" 
           id="cf_{{ $field->name }}" 
           class="form-control @error('custom_fields.'.$field->name) is-invalid @enderror"
           @if($field->required && empty($fileData)) required @endif
    >
    
    @error('custom_fields.'.$field->name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
