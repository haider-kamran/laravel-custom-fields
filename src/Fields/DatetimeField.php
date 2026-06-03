<?php

declare(strict_types=1);

namespace HyderKamran\CustomFields\Fields;

class DatetimeField extends BaseField
{
    protected function getViewName(): string
    {
        return 'custom-fields::fields.datetime';
    }
}
