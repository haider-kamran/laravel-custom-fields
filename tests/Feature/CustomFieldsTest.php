<?php

declare(strict_types=1);

namespace HyderKamran\CustomFields\Tests\Feature;

use HyderKamran\CustomFields\Tests\TestCase;
use HyderKamran\CustomFields\Models\FieldGroup;
use HyderKamran\CustomFields\Models\CustomField;
use HyderKamran\CustomFields\Traits\HasCustomFields;
use Illuminate\Database\Eloquent\Model;

class TestModel extends Model
{
    use HasCustomFields;
    protected $guarded = [];
}

class CustomFieldsTest extends TestCase
{
    public function test_can_create_field_groups_and_fields()
    {
        $group = FieldGroup::create([
            'name'       => 'Test Group',
            'model_type' => TestModel::class,
        ]);

        $this->assertDatabaseHas(config('custom-fields.tables.field_groups'), [
            'name' => 'Test Group'
        ]);

        $field = CustomField::create([
            'group_id' => $group->id,
            'name'     => 'meta_title',
            'label'    => 'Meta Title',
            'type'     => 'text',
        ]);

        $this->assertDatabaseHas(config('custom-fields.tables.custom_fields'), [
            'name'  => 'meta_title',
            'label' => 'Meta Title'
        ]);
    }

    public function test_can_set_and_get_custom_fields_on_model()
    {
        $group = FieldGroup::create([
            'name'       => 'Test Group',
            'model_type' => TestModel::class,
        ]);

        CustomField::create([
            'group_id' => $group->id,
            'name'     => 'meta_title',
            'label'    => 'Meta Title',
            'type'     => 'text',
        ]);

        $model = TestModel::create(['name' => 'My Record']);

        // Set value
        $model->setCustomField('meta_title', 'My Meta Title Content');

        // Check value
        $this->assertEquals('My Meta Title Content', $model->getCustomField('meta_title'));

        // Check database
        $this->assertDatabaseHas(config('custom-fields.tables.field_values'), [
            'model_type' => TestModel::class,
            'model_id'   => $model->id,
            'value'      => json_encode('My Meta Title Content')
        ]);
    }
}
