<?php

declare(strict_types=1);

namespace HyderKamran\CustomFields\Events;

use HyderKamran\CustomFields\Models\FieldGroup;

class FieldGroupCreated
{
    public function __construct(
        public FieldGroup $group
    ) {}
}
