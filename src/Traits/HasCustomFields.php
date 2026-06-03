<?php

declare(strict_types=1);

namespace HyderKamran\CustomFields\Traits;

use HyderKamran\CustomFields\Models\FieldValue;
use HyderKamran\CustomFields\Models\CustomField;
use HyderKamran\CustomFields\Models\FieldGroup;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use HyderKamran\CustomFields\Events\FieldValueSaving;
use HyderKamran\CustomFields\Events\FieldValueSaved;

trait HasCustomFields
{
    /**
     * Relationship to the stored values.
     */
    public function customFieldValues(): MorphMany
    {
        return $this->morphMany(FieldValue::class, 'model');
    }

    /**
     * Get a specific custom field value by name.
     */
    public function getCustomField(string $name): mixed
    {
        // Option A: Database Storage (fallback to json if configured)
        if (config('custom-fields.storage') === 'json') {
            return $this->custom_fields[$name] ?? null; // Assumes a JSON column named custom_fields exists
        }

        $field = CustomField::where('name', $name)->first();
        if (!$field) {
            return null;
        }

        $valueRecord = $this->customFieldValues()->where('field_id', $field->id)->first();
        return $valueRecord ? $valueRecord->value : null;
    }

    /**
     * Set a custom field value by name.
     */
    public function setCustomField(string $name, mixed $value): void
    {
        $field = CustomField::where('name', $name)->first();
        if (!$field) {
            throw new \InvalidArgumentException("Custom field [{$name}] does not exist.");
        }
        
        $types = config('custom-fields.field_types', []);
        $typeSlug = $field->type->value ?? $field->type;
        $processedValue = $value;

        if (isset($types[$typeSlug]) && class_exists($types[$typeSlug])) {
            $renderer = app($types[$typeSlug]);
            $processedValue = $renderer->castValue($field, $value);
        }

        if (config('custom-fields.storage') === 'json') {
            $fields = $this->custom_fields ?? [];
            event(new FieldValueSaving($this, $field, $processedValue));
            $fields[$name] = $processedValue;
            $this->custom_fields = $fields;
            $this->save();
            event(new FieldValueSaved($this, $field, $processedValue));
            $this->clearCustomFieldsCache();
            return;
        }

        event(new FieldValueSaving($this, $field, $processedValue));

        $this->customFieldValues()->updateOrCreate(
            ['field_id' => $field->id],
            ['value' => $processedValue]
        );

        event(new FieldValueSaved($this, $field, $processedValue));
        $this->clearCustomFieldsCache();
    }

    /**
     * Retrieve all custom fields for this model type and their values.
     */
    public function getAllCustomFields(): Collection
    {
        if (config('custom-fields.storage') === 'json') {
             return collect($this->custom_fields ?? []);
        }

        $cacheKey = $this->getCustomFieldsCacheKey('all_fields');
        
        return $this->rememberCustomFieldsCache($cacheKey, function () {
            $fields = CustomField::whereHas('group', function ($query) {
                $query->where('model_type', get_class($this))->where('is_active', true);
            })->get();

            $values = $this->customFieldValues()->pluck('value', 'field_id');

            return $fields->mapWithKeys(function ($field) use ($values) {
                return [$field->name => $values->get($field->id)];
            });
        });
    }

    /**
     * Get all active Field Groups assigned to this Model type.
     */
    public function customFieldGroups(): Collection
    {
        $cacheKey = "custom_fields:groups:" . md5(get_class($this));
        
        return $this->rememberCustomFieldsCache($cacheKey, function () {
            return FieldGroup::with('customFields')
                ->where('model_type', get_class($this))
                ->where('is_active', true)
                ->get();
        });
    }

    /**
     * Clear the cache for this specific model instance's custom fields.
     */
    public function clearCustomFieldsCache(): void
    {
        Cache::store(config('custom-fields.cache_store'))->forget($this->getCustomFieldsCacheKey('all_fields'));
    }

    /**
     * Helper to generate a cache key for this model instance.
     */
    protected function getCustomFieldsCacheKey(string $suffix): string
    {
        return "custom_fields:" . get_class($this) . ":{$this->id}:{$suffix}";
    }

    /**
     * Helper to handle cache closure logic based on config.
     */
    protected function rememberCustomFieldsCache(string $key, \Closure $callback)
    {
        if (!config('custom-fields.cache_enabled', true)) {
            return $callback();
        }

        $ttl = config('custom-fields.cache_ttl', 3600);
        $store = Cache::store(config('custom-fields.cache_store'));

        return $ttl === null 
            ? $store->rememberForever($key, $callback)
            : $store->remember($key, $ttl, $callback);
    }
}
