<?php

declare(strict_types=1);

namespace HyderKamran\CustomFields\Enums;

enum FieldType: string
{
    case Text     = 'text';
    case Textarea = 'textarea';
    case Number   = 'number';
    case Email    = 'email';
    case Password = 'password';
    case Select   = 'select';
    case Checkbox = 'checkbox';
    case Radio    = 'radio';
    case Boolean  = 'boolean';
    case Date     = 'date';
    case Datetime = 'datetime';
    case File     = 'file';
    case Image    = 'image';
    case Repeater = 'repeater';
    case Json     = 'json';
    case Color    = 'color';
    case Wysiwyg  = 'wysiwyg';
    case Url      = 'url';
    case Time     = 'time';
    case Range    = 'range';

    /**
     * Returns a human-readable label for the field type.
     */
    public function label(): string
    {
        return match ($this) {
            self::Text     => 'Text',
            self::Textarea => 'Textarea',
            self::Number   => 'Number',
            self::Email    => 'Email',
            self::Password => 'Password',
            self::Select   => 'Select',
            self::Checkbox => 'Checkbox',
            self::Radio    => 'Radio',
            self::Boolean  => 'Toggle / Boolean',
            self::Date     => 'Date',
            self::Datetime => 'Date & Time',
            self::File     => 'File Upload',
            self::Image    => 'Image Upload',
            self::Repeater => 'Repeater',
            self::Json     => 'JSON',
            self::Color    => 'Color Picker',
            self::Wysiwyg  => 'WYSIWYG Editor',
            self::Url      => 'URL',
            self::Time     => 'Time Picker',
            self::Range    => 'Range Slider',
        };
    }

    /**
     * Returns whether this field type stores complex (array/object) values.
     */
    public function isComplex(): bool
    {
        return in_array($this, [self::Repeater, self::Json, self::Select, self::Checkbox]);
    }

    /**
     * Returns whether this field type handles file uploads.
     */
    public function isUpload(): bool
    {
        return in_array($this, [self::File, self::Image]);
    }

    /**
     * All available values as an array (useful for validation rules).
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
