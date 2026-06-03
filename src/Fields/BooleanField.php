<?php

declare(strict_types=1);

namespace HyderKamran\CustomFields\Fields;

class BooleanField extends BaseField
{
    protected function getViewName(): string
    {
        return 'custom-fields::fields.boolean';
    }

    public function validationRules(\HyderKamran\CustomFields\Models\CustomField $field): array
    {
        $rules = parent::validationRules($field);
        $rules[] = 'boolean';
        return $rules;
    }

    public function castValue(\HyderKamran\CustomFields\Models\CustomField $field, mixed $raw): mixed
    {
        return filter_var($raw, FILTER_VALIDATE_BOOLEAN);
    }
}
