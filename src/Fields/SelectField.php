<?php

declare(strict_types=1);

namespace HyderKamran\CustomFields\Fields;

use HyderKamran\CustomFields\Models\CustomField;

class SelectField extends BaseField
{
    protected function getViewName(): string
    {
        return 'custom-fields::fields.select';
    }

    public function validationRules(CustomField $field): array
    {
        $rules = parent::validationRules($field);
        
        $isMultiple = $field->options['multiple'] ?? false;
        if ($isMultiple) {
            $rules[] = 'array';
        }

        return $rules;
    }
}
