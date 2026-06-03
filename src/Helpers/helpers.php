<?php

use Illuminate\Database\Eloquent\Model;

if (!function_exists('get_custom_field')) {
    /**
     * Retrieve a custom field value from a model, similar to ACF's get_field().
     *
     * @param Model $model The Eloquent model instance.
     * @param string $name The field name/slug.
     * @param mixed $default Optional default value.
     * @return mixed
     */
    function get_custom_field(Model $model, string $name, mixed $default = null): mixed
    {
        if (method_exists($model, 'getCustomField')) {
            $value = $model->getCustomField($name);
            return $value !== null ? $value : $default;
        }

        return $default;
    }
}

if (!function_exists('has_custom_field')) {
    /**
     * Check if a model has a specific custom field populated.
     */
    function has_custom_field(Model $model, string $name): bool
    {
        return get_custom_field($model, $name) !== null;
    }
}
