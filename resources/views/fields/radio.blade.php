<div class="mb-3 form-group">
    <label class="form-label">
        {{ $field->label }} 
        @if($field->required) <span class="text-danger">*</span> @endif
    </label>
    
    @php
        $choices = $field->options['choices'] ?? [];
    @endphp

    <div>
        @foreach($choices as $val => $label)
            <div class="form-check">
                <input class="form-check-input @error('custom_fields.'.$field->name) is-invalid @enderror" 
                       type="radio" 
                       name="custom_fields[{{ $field->name }}]" 
                       id="cf_{{ $field->name }}_{{ $loop->index }}" 
                       value="{{ $val }}"
                       @if($value == $val) checked @endif
                       @if($field->required) required @endif>
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
