<?php

declare(strict_types=1);

namespace HyderKamran\CustomFields\Fields;

use HyderKamran\CustomFields\Models\CustomField;

class ImageField extends FileField
{
    public function validationRules(CustomField $field): array
    {
        $rules = parent::validationRules($field);
        $rules[] = 'image';
        
        $mimes = config('custom-fields.allowed_image_mimes', ['image/jpeg', 'image/png', 'image/gif', 'image/webp']);
        
        // Convert mime array to just extensions for laravel validation if needed, 
        // but typically 'image' covers basic ones.
        return $rules;
    }
}
