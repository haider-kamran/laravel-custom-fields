<div class="mb-3 form-group">
    <label for="cf_{{ $field->name }}" class="form-label d-flex justify-content-between">
        <span>
            {{ $field->label }} 
            @if($field->required) <span class="text-danger">*</span> @endif
        </span>
        <span class="text-primary fw-bold" id="cf_{{ $field->name }}_display">{{ $value ?? $field->options['min'] ?? 0 }}</span>
    </label>
    
    <input type="range" 
           name="custom_fields[{{ $field->name }}]" 
           id="cf_{{ $field->name }}" 
           class="form-range @error('custom_fields.'.$field->name) is-invalid @enderror"
           value="{{ $value ?? $field->options['min'] ?? 0 }}"
           min="{{ $field->options['min'] ?? 0 }}"
           max="{{ $field->options['max'] ?? 100 }}"
           step="{{ $field->options['step'] ?? 1 }}"
           @if($field->required) required @endif
    >
    
    @error('custom_fields.'.$field->name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

<script>
    document.getElementById('cf_{{ $field->name }}').addEventListener('input', function(e) {
        let display = document.getElementById('cf_{{ $field->name }}_display');
        if (display) display.textContent = e.target.value;
    });
</script>
