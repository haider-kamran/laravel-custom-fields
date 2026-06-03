<?php

declare(strict_types=1);

namespace HyderKamran\CustomFields\Fields;

use HyderKamran\CustomFields\Models\CustomField;

class UrlField extends BaseField
{
    protected function getViewName(): string
    {
        return 'custom-fields::fields.url';
    }

    public function validationRules(CustomField $field): array
    {
        $rules = parent::validationRules($field);
        $rules[] = 'url';
        return $rules;
    }
}
