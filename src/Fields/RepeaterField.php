<?php

declare(strict_types=1);

namespace HyderKamran\CustomFields\Fields;

use HyderKamran\CustomFields\Models\CustomField;

class RepeaterField extends BaseField
{
    protected function getViewName(): string
    {
        return 'custom-fields::fields.repeater';
    }

    public function validationRules(CustomField $field): array
    {
        $rules = parent::validationRules($field);
        $rules[] = 'array';
        return $rules;
    }

    public function castValue(CustomField $field, mixed $raw): mixed
    {
        // Ensure it's stored as an array/json
        if (is_string($raw)) {
            $decoded = json_decode($raw, true);
            return json_last_error() === JSON_ERROR_NONE ? $decoded : [];
        }
        return (array) $raw;
    }
}
