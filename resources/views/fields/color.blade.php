<div class="mb-3 form-group">
    <label for="cf_{{ $field->name }}" class="form-label d-block">
        {{ $field->label }} 
        @if($field->required) <span class="text-danger">*</span> @endif
    </label>
    
    <div class="d-flex align-items-center gap-2">
        <input type="color" 
               name="custom_fields[{{ $field->name }}]" 
               id="cf_{{ $field->name }}" 
               class="form-control form-control-color @error('custom_fields.'.$field->name) is-invalid @enderror"
               value="{{ $value ?? '#000000' }}"
               title="Choose your color"
               @if($field->required) required @endif
        >
        <!-- Optional visual hex display -->
        <span class="text-muted small font-monospace hex-display">{{ $value ?? '#000000' }}</span>
    </div>

    @error('custom_fields.'.$field->name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

{{-- Basic inline script to update the hex text label when the color picker changes --}}
<script>
    document.getElementById('cf_{{ $field->name }}').addEventListener('input', function(e) {
        let display = this.parentElement.querySelector('.hex-display');
        if (display) display.textContent = e.target.value.toUpperCase();
    });
</script>
