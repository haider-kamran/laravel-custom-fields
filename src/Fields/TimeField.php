<?php

declare(strict_types=1);

namespace HyderKamran\CustomFields\Fields;

use HyderKamran\CustomFields\Models\CustomField;

class TimeField extends BaseField
{
    protected function getViewName(): string
    {
        return 'custom-fields::fields.time';
    }

    public function validationRules(CustomField $field): array
    {
        $rules = parent::validationRules($field);
        $rules[] = 'date_format:H:i';
        return $rules;
    }
}
