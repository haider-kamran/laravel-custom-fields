<?php

declare(strict_types=1);

namespace HyderKamran\CustomFields\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FieldGroup extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $dispatchesEvents = [
        'created' => \HyderKamran\CustomFields\Events\FieldGroupCreated::class,
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable(config('custom-fields.tables.field_groups', 'cf_field_groups'));
    }

    public function customFields(): HasMany
    {
        return $this->hasMany(CustomField::class, 'group_id')->orderBy('order');
    }
}
