<?php

declare(strict_types=1);

namespace HyderKamran\CustomFields\Events;

use Illuminate\Database\Eloquent\Model;
use HyderKamran\CustomFields\Models\CustomField;

class FieldValueSaved
{
    public function __construct(
        public Model $model,
        public CustomField $field,
        public mixed $value
    ) {}
}
