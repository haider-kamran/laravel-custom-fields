<?php

declare(strict_types=1);

namespace HyderKamran\CustomFields\Database\Seeders;

use Illuminate\Database\Seeder;
use HyderKamran\CustomFields\Models\FieldGroup;
use HyderKamran\CustomFields\Models\CustomField;
use App\Models\User; // Assuming a standard Laravel User model for demo

class CustomFieldsSeeder extends Seeder
{
    public function run(): void
    {
        if (!class_exists(User::class)) {
            $this->command->warn('User model not found. Skipping CustomFields seeder demo data.');
            return;
        }

        $group = FieldGroup::create([
            'name'        => 'User Profile Settings',
            'model_type'  => User::class,
            'description' => 'Extended profile fields for users.',
            'is_active'   => true,
        ]);

        CustomField::create([
            'group_id' => $group->id,
            'name'     => 'bio',
            'label'    => 'Biography',
            'type'     => 'textarea',
            'required' => false,
            'order'    => 1,
            'options'  => ['rows' => 4]
        ]);

        CustomField::create([
            'group_id' => $group->id,
            'name'     => 'social_links',
            'label'    => 'Social Media Links',
            'type'     => 'repeater',
            'required' => false,
            'order'    => 2,
            'options'  => [
                'sub_fields' => [
                    ['name' => 'platform', 'label' => 'Platform (e.g. Twitter)', 'type' => 'text'],
                    ['name' => 'url', 'label' => 'URL', 'type' => 'text'],
                ]
            ]
        ]);
        
        $this->command->info('Custom Fields demo data seeded successfully!');
    }
}
