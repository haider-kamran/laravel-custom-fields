<?php

declare(strict_types=1);

namespace HyderKamran\CustomFields\Fields;

use HyderKamran\CustomFields\Models\CustomField;

class ColorField extends BaseField
{
    protected function getViewName(): string
    {
        return 'custom-fields::fields.color';
    }

    public function validationRules(CustomField $field): array
    {
        $rules = parent::validationRules($field);
        // Validates hex colors (e.g., #fff, #ffffff)
        $rules[] = 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/';
        return $rules;
    }
}
