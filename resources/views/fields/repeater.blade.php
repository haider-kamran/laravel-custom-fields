@php
    // Basic repeater implementation
    $items = is_array($value) ? $value : [];
    $subFields = $field->options['sub_fields'] ?? [];
@endphp
<div class="mb-3 form-group custom-field-repeater" data-field-name="custom_fields[{{ $field->name }}]">
    <label class="form-label">
        {{ $field->label }} 
        @if($field->required) <span class="text-danger">*</span> @endif
    </label>

    <div class="repeater-items border p-3 mb-2 rounded bg-light">
        @forelse($items as $index => $item)
            <div class="repeater-item border bg-white p-2 mb-2 d-flex flex-wrap align-items-center gap-2">
                @foreach($subFields as $subField)
                    <div class="flex-grow-1">
                        <label class="form-label small text-muted">{{ $subField['label'] }}</label>
                        <input type="text" 
                               name="custom_fields[{{ $field->name }}][{{ $index }}][{{ $subField['name'] }}]" 
                               class="form-control form-control-sm"
                               value="{{ $item[$subField['name']] ?? '' }}">
                    </div>
                @endforeach
                <button type="button" class="btn btn-sm btn-outline-danger mt-4 remove-repeater-item">&times;</button>
            </div>
        @empty
            <div class="text-muted small no-items-msg">No items added yet.</div>
        @endforelse
    </div>
    
    <button type="button" class="btn btn-sm btn-secondary add-repeater-item">+ Add Row</button>
</div>

{{-- Note: A real implementation would require some JS to handle the DOM manipulation for adding/removing rows based on a template. This is structural. --}}
