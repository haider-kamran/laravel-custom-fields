<?php

declare(strict_types=1);

namespace HyderKamran\CustomFields\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use HyderKamran\CustomFields\Enums\FieldType;

class CustomField extends Model
{
    protected $guarded = [];

    protected $casts = [
        'options'  => 'json',
        'required' => 'boolean',
        'type'     => FieldType::class,
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable(config('custom-fields.tables.custom_fields', 'cf_custom_fields'));
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(FieldGroup::class, 'group_id');
    }
}
