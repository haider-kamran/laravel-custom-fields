<?php

declare(strict_types=1);

namespace HyderKamran\CustomFields\Contracts;

use Illuminate\Database\Eloquent\Model;
use HyderKamran\CustomFields\Models\CustomField;

/**
 * Contract for all field-type renderers.
 */
interface FieldRendererContract
{
    /**
     * Return the rendered HTML for this field.
     *
     * @param  CustomField  $field  The field definition model.
     * @param  mixed        $value  The current stored value (may be null).
     * @param  array        $options  Additional rendering options (e.g. ['errors' => $errors]).
     */
    public function render(CustomField $field, mixed $value = null, array $options = []): string;

    /**
     * Return the validation rules for this field based on its options JSON.
     *
     * @param  CustomField  $field
     * @return array<string, mixed>
     */
    public function validationRules(CustomField $field): array;

    /**
     * Cast / transform the raw incoming request value before persistence.
     *
     * @param  CustomField  $field
     * @param  mixed        $raw
     */
    public function castValue(CustomField $field, mixed $raw): mixed;
}
