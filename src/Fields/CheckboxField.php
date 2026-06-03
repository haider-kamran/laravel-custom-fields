<?php

declare(strict_types=1);

namespace HyderKamran\CustomFields\Fields;

use HyderKamran\CustomFields\Models\CustomField;

class CheckboxField extends BaseField
{
    protected function getViewName(): string
    {
        return 'custom-fields::fields.checkbox';
    }

    public function validationRules(CustomField $field): array
    {
        $rules = parent::validationRules($field);
        $rules[] = 'array';
        return $rules;
    }

    public function castValue(CustomField $field, mixed $raw): mixed
    {
        return is_array($raw) ? $raw : [];
    }
}
