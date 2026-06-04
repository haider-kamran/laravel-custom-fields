<?php

namespace HyderKamran\CustomFields\Database\Seeders;

use Illuminate\Database\Seeder;
use HyderKamran\CustomFields\Models\FieldGroup;
use HyderKamran\CustomFields\Models\CustomField;
use HyderKamran\CustomFields\Enums\FieldType;

class CustomFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ----------------------------------------------------
        // Example 1: User Profile Custom Fields
        // ----------------------------------------------------
        $userGroup = FieldGroup::updateOrCreate(
            ['name' => 'Profile Information'],
            [
                'model_type' => 'App\Models\User',
                'description' => 'Additional profile information for the user.',
                'is_active' => true,
            ]
        );

        CustomField::updateOrCreate(
            ['group_id' => $userGroup->id, 'name' => 'bio'],
            [
                'label' => 'Biography',
                'type' => FieldType::Textarea,
                'required' => false,
                'order' => 1,
            ]
        );

        CustomField::updateOrCreate(
            ['group_id' => $userGroup->id, 'name' => 'twitter_handle'],
            [
                'label' => 'Twitter / X Handle',
                'type' => FieldType::Text,
                'required' => false,
                'order' => 2,
            ]
        );

        CustomField::updateOrCreate(
            ['group_id' => $userGroup->id, 'name' => 'receive_newsletter'],
            [
                'label' => 'Receive Newsletter',
                'type' => FieldType::Boolean,
                'required' => false,
                'order' => 3,
            ]
        );

        // ----------------------------------------------------
        // Example 2: SEO Settings for a Post or Page Model
        // ----------------------------------------------------
        $seoGroup = FieldGroup::updateOrCreate(
            ['name' => 'SEO Settings'],
            [
                'model_type' => 'App\Models\Post', // Change to your actual model
                'description' => 'Search Engine Optimization fields.',
                'is_active' => true,
            ]
        );

        CustomField::updateOrCreate(
            ['group_id' => $seoGroup->id, 'name' => 'seo_title'],
            [
                'label' => 'Meta Title',
                'type' => FieldType::Text,
                'required' => false,
                'order' => 1,
            ]
        );

        CustomField::updateOrCreate(
            ['group_id' => $seoGroup->id, 'name' => 'seo_description'],
            [
                'label' => 'Meta Description',
                'type' => FieldType::Textarea,
                'required' => false,
                'order' => 2,
            ]
        );

        CustomField::updateOrCreate(
            ['group_id' => $seoGroup->id, 'name' => 'index_page'],
            [
                'label' => 'Allow Search Engines to Index',
                'type' => FieldType::Boolean,
                'required' => false,
                'order' => 3,
            ]
        );

        // ----------------------------------------------------
        // Example 3: Homepage Layout (Repeater Example)
        // ----------------------------------------------------
        $layoutGroup = FieldGroup::updateOrCreate(
            ['name' => 'Homepage Layout Settings'],
            [
                'model_type' => 'App\Models\Page',
                'description' => 'Dynamic sections for the homepage.',
                'is_active' => true,
            ]
        );

        CustomField::updateOrCreate(
            ['group_id' => $layoutGroup->id, 'name' => 'hero_image'],
            [
                'label' => 'Hero Background Image',
                'type' => FieldType::Image,
                'required' => true,
                'order' => 1,
            ]
        );

        CustomField::updateOrCreate(
            ['group_id' => $layoutGroup->id, 'name' => 'features_list'],
            [
                'label' => 'Features List',
                'type' => FieldType::Repeater,
                'required' => false,
                'order' => 2,
                'options' => [
                    'sub_fields' => [
                        ['name' => 'title', 'label' => 'Feature Title', 'type' => 'text'],
                        ['name' => 'description', 'label' => 'Description', 'type' => 'textarea'],
                        ['name' => 'icon', 'label' => 'Icon Class', 'type' => 'text'],
                    ]
                ]
            ]
        );
    }
}
