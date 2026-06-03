<?php

declare(strict_types=1);

namespace HyderKamran\CustomFields\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class FieldValue extends Model
{
    protected $guarded = [];

    protected $casts = [
        'value' => 'json',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable(config('custom-fields.tables.field_values', 'cf_field_values'));
    }

    public function field(): BelongsTo
    {
        return $this->belongsTo(CustomField::class, 'field_id');
    }

    public function model(): MorphTo
    {
        return $this->morphTo();
    }
}
