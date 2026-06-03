<?php

declare(strict_types=1);

namespace HyderKamran\CustomFields\Enums;

/**
 * Determines where custom-field values are persisted.
 */
enum StorageDriver: string
{
    case Database = 'database';
    case Json     = 'json';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
