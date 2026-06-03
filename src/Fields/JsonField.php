<?php

declare(strict_types=1);

namespace HyderKamran\CustomFields\Fields;

class JsonField extends BaseField
{
    protected function getViewName(): string
    {
        return 'custom-fields::fields.json';
    }

    public function validationRules(\HyderKamran\CustomFields\Models\CustomField $field): array
    {
        $rules = parent::validationRules($field);
        $rules[] = 'json';
        return $rules;
    }

    public function castValue(\HyderKamran\CustomFields\Models\CustomField $field, mixed $raw): mixed
    {
        if (is_array($raw)) {
            return $raw;
        }
        $decoded = json_decode((string)$raw, true);
        return json_last_error() === JSON_ERROR_NONE ? $decoded : [];
    }
}
