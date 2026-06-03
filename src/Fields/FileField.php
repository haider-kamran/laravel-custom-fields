<?php

declare(strict_types=1);

namespace HyderKamran\CustomFields\Fields;

use HyderKamran\CustomFields\Models\CustomField;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileField extends BaseField
{
    protected function getViewName(): string
    {
        return 'custom-fields::fields.file';
    }

    public function validationRules(CustomField $field): array
    {
        $rules = parent::validationRules($field);
        $rules[] = 'file';
        
        $maxSize = config('custom-fields.max_file_size', 10240);
        $rules[] = 'max:' . $maxSize;
        
        return $rules;
    }

    public function castValue(CustomField $field, mixed $raw): mixed
    {
        // If a new file was uploaded, store it
        if ($raw instanceof UploadedFile) {
            $disk = config('custom-fields.file_disk', 'public');
            $path = config('custom-fields.file_path', 'custom-fields/uploads');
            
            $storedPath = $raw->store($path, $disk);
            
            return [
                'path' => $storedPath,
                'disk' => $disk,
                'name' => $raw->getClientOriginalName(),
                'size' => $raw->getSize(),
                'mime' => $raw->getMimeType(),
                'url'  => Storage::disk($disk)->url($storedPath),
            ];
        }

        // If it's a string, it might be JSON from a previous save. Decode it.
        if (is_string($raw)) {
            $decoded = json_decode($raw, true);
            return json_last_error() === JSON_ERROR_NONE ? $decoded : $raw;
        }

        return $raw;
    }
}
