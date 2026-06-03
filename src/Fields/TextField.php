<?php

declare(strict_types=1);

namespace HyderKamran\CustomFields\Fields;

use HyderKamran\CustomFields\Models\CustomField;

class TextField extends BaseField
{
    protected function getViewName(): string
    {
        return 'custom-fields::fields.text';
    }

    public function validationRules(CustomField $field): array
    {
        $rules = parent::validationRules($field);
        $rules[] = 'string';
        return $rules;
    }
}
