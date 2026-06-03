<div class="mb-3 form-group">
    <label class="form-label">
        {{ $field->label }} 
        @if($field->required) <span class="text-danger">*</span> @endif
    </label>
    
    @php
        $choices = $field->options['choices'] ?? [];
        $checkedValues = is_array($value) ? $value : [];
    @endphp

    <div>
        @foreach($choices as $val => $label)
            <div class="form-check form-check-inline">
                <input class="form-check-input @error('custom_fields.'.$field->name) is-invalid @enderror" 
                       type="checkbox" 
                       name="custom_fields[{{ $field->name }}][]" 
                       id="cf_{{ $field->name }}_{{ $loop->index }}" 
                       value="{{ $val }}"
                       @if(in_array($val, $checkedValues)) checked @endif>
                <label class="form-check-label" for="cf_{{ $field->name }}_{{ $loop->index }}">
                    {{ $label }}
                </label>
            </div>
        @endforeach
    </div>

    @error('custom_fields.'.$field->name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
