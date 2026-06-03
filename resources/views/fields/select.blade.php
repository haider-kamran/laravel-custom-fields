<div class="mb-3 form-group">
    <label for="cf_{{ $field->name }}" class="form-label">
        {{ $field->label }} 
        @if($field->required) <span class="text-danger">*</span> @endif
    </label>
    
    @php
        $isMultiple = $field->options['multiple'] ?? false;
        $choices = $field->options['choices'] ?? [];
        $selectedValues = $isMultiple ? (is_array($value) ? $value : []) : [$value];
    @endphp

    <select 
        name="custom_fields[{{ $field->name }}]{{ $isMultiple ? '[]' : '' }}" 
        id="cf_{{ $field->name }}" 
        class="form-select @error('custom_fields.'.$field->name) is-invalid @enderror"
        @if($field->required) required @endif
        @if($isMultiple) multiple @endif
    >
        @if(!$isMultiple && !$field->required)
            <option value="">-- Select --</option>
        @endif

        @foreach($choices as $val => $label)
            <option value="{{ $val }}" @if(in_array($val, $selectedValues)) selected @endif>
                {{ $label }}
            </option>
        @endforeach
    </select>

    @error('custom_fields.'.$field->name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
