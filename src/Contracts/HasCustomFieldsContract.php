<?php

declare(strict_types=1);

namespace HyderKamran\CustomFields\Contracts;

use Illuminate\Database\Eloquent\Model;

/**
 * Contract exposing the custom-field capabilities on a host model.
 */
interface HasCustomFieldsContract
{
    /**
     * Retrieve a single field value by its slug name.
     */
    public function getCustomField(string $name): mixed;

    /**
     * Persist a single field value by its slug name.
     */
    public function setCustomField(string $name, mixed $value): void;

    /**
     * Retrieve all field values keyed by field slug.
     *
     * @return array<string, mixed>
     */
    public function getAllCustomFields(): array;

    /**
     * Relationship to the raw custom-field value records.
     */
    public function customFieldValues(): \Illuminate\Database\Eloquent\Relations\MorphMany;
}
