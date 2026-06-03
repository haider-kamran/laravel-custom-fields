<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Storage Driver
    |--------------------------------------------------------------------------
    | Determines how custom field values are stored.
    | Supported: "database", "json"
    */
    'storage' => env('CUSTOM_FIELDS_STORAGE', 'database'),

    /*
    |--------------------------------------------------------------------------
    | File Storage Disk
    |--------------------------------------------------------------------------
    | The disk used when storing uploaded files via file/image field types.
    | Supported: "local", "public", "s3"
    */
    'file_disk' => env('CUSTOM_FIELDS_FILE_DISK', 'public'),

    /*
    |--------------------------------------------------------------------------
    | File Storage Path
    |--------------------------------------------------------------------------
    | The directory (relative to the disk root) where uploads are stored.
    */
    'file_path' => 'custom-fields/uploads',

    /*
    |--------------------------------------------------------------------------
    | Cache
    |--------------------------------------------------------------------------
    | Enable or disable caching of field groups and their fields.
    | Setting a TTL of null means cache forever until manually invalidated.
    */
    'cache_enabled' => env('CUSTOM_FIELDS_CACHE', true),
    'cache_ttl'     => 3600, // seconds

    /*
    |--------------------------------------------------------------------------
    | Cache Store
    |--------------------------------------------------------------------------
    | Which cache store to use. null = default application cache.
    */
    'cache_store' => null,

    /*
    |--------------------------------------------------------------------------
    | Database Tables
    |--------------------------------------------------------------------------
    | Override table names if your application already uses these names.
    */
    'tables' => [
        'field_groups'       => 'cf_field_groups',
        'custom_fields'      => 'cf_custom_fields',
        'field_values'       => 'cf_field_values',
    ],

    /*
    |--------------------------------------------------------------------------
    | API
    |--------------------------------------------------------------------------
    | Enable or disable the built-in REST API endpoints.
    */
    'api_enabled'  => env('CUSTOM_FIELDS_API', true),
    'api_prefix'   => 'api/custom-fields',
    'api_middleware' => ['api'],

    /*
    |--------------------------------------------------------------------------
    | Route Web Prefix
    |--------------------------------------------------------------------------
    */
    'web_prefix'    => 'custom-fields',
    'web_middleware' => ['web'],

    /*
    |--------------------------------------------------------------------------
    | Supported Field Types
    |--------------------------------------------------------------------------
    | Mapping of type slug -> renderer class. Extend this to add custom types.
    */
    'field_types' => [
        'text'     => \HyderKamran\CustomFields\Fields\TextField::class,
        'textarea' => \HyderKamran\CustomFields\Fields\TextareaField::class,
        'number'   => \HyderKamran\CustomFields\Fields\NumberField::class,
        'email'    => \HyderKamran\CustomFields\Fields\EmailField::class,
        'password' => \HyderKamran\CustomFields\Fields\PasswordField::class,
        'select'   => \HyderKamran\CustomFields\Fields\SelectField::class,
        'checkbox' => \HyderKamran\CustomFields\Fields\CheckboxField::class,
        'radio'    => \HyderKamran\CustomFields\Fields\RadioField::class,
        'boolean'  => \HyderKamran\CustomFields\Fields\BooleanField::class,
        'date'     => \HyderKamran\CustomFields\Fields\DateField::class,
        'datetime' => \HyderKamran\CustomFields\Fields\DatetimeField::class,
        'file'     => \HyderKamran\CustomFields\Fields\FileField::class,
        'image'    => \HyderKamran\CustomFields\Fields\ImageField::class,
        'repeater' => \HyderKamran\CustomFields\Fields\RepeaterField::class,
        'json'     => \HyderKamran\CustomFields\Fields\JsonField::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Allowed Image MIME Types
    |--------------------------------------------------------------------------
    */
    'allowed_image_mimes' => ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],

    /*
    |--------------------------------------------------------------------------
    | Max Upload Size (KB)
    |--------------------------------------------------------------------------
    */
    'max_file_size' => 10240,

];
