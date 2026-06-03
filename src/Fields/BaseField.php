<?php

declare(strict_types=1);

namespace HyderKamran\CustomFields\Fields;

use HyderKamran\CustomFields\Contracts\FieldRendererContract;
use HyderKamran\CustomFields\Models\CustomField;
use Illuminate\Support\Facades\View;

abstract class BaseField implements FieldRendererContract
{
    /**
     * Define the blade view name for this field (e.g. 'custom-fields::fields.text')
     */
    abstract protected function getViewName(): string;

    public function render(CustomField $field, mixed $value = null, array $options = []): string
    {
        $data = array_merge([
            'field' => $field,
            'value' => old('custom_fields.' . $field->name, $value),
        ], $options);

        return View::make($this->getViewName(), $data)->render();
    }

    public function validationRules(CustomField $field): array
    {
        $rules = [];
        
        if ($field->required) {
            $rules[] = 'required';
        } else {
            $rules[] = 'nullable';
        }

        $options = $field->options ?? [];
        if (isset($options['min'])) {
            $rules[] = 'min:' . $options['min'];
        }
        if (isset($options['max'])) {
            $rules[] = 'max:' . $options['max'];
        }
        if (isset($options['regex'])) {
            $rules[] = 'regex:' . $options['regex'];
        }

        return $rules;
    }

    public function castValue(CustomField $field, mixed $raw): mixed
    {
        return $raw; // default passthrough
    }
}
