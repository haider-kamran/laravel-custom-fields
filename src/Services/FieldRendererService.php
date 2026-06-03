<?php

declare(strict_types=1);

namespace HyderKamran\CustomFields\Services;

use HyderKamran\CustomFields\Models\CustomField;
use Illuminate\Database\Eloquent\Model;
use HyderKamran\CustomFields\Contracts\HasCustomFieldsContract;

class FieldRendererService
{
    /**
     * Render an entire form for a model's custom fields.
     */
    public function renderForm(Model $model): string
    {
        if (!method_exists($model, 'customFieldGroups')) {
            throw new \Exception(sprintf('Model [%s] must use the HasCustomFields trait.', get_class($model)));
        }

        $groups = $model->customFieldGroups();
        $html = '';

        foreach ($groups as $group) {
            $html .= '<div class="custom-field-group mb-4">';
            $html .= '<h4>' . e($group->name) . '</h4>';
            
            if ($group->description) {
                 $html .= '<p class="text-muted">' . e($group->description) . '</p>';
            }

            foreach ($group->customFields as $field) {
                $value = $model->getCustomField($field->name);
                $html .= $this->renderField($field, $value);
            }
            $html .= '</div>';
        }

        return $html;
    }

    /**
     * Render a single custom field.
     */
    public function renderField(CustomField $field, mixed $value = null): string
    {
        $types = config('custom-fields.field_types', []);
        $typeSlug = $field->type->value ?? $field->type;

        if (!isset($types[$typeSlug])) {
             return '<!-- Unsupported Field Type: ' . e($typeSlug) . ' -->';
        }

        $rendererClass = $types[$typeSlug];
        if (!class_exists($rendererClass)) {
            return '<!-- Missing Field Renderer: ' . e($rendererClass) . ' -->';
        }

        $renderer = app($rendererClass);
        return $renderer->render($field, $value);
    }
}
