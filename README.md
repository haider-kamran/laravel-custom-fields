# Laravel Custom Fields

A powerful, production-ready Laravel package that allows you to dynamically attach custom fields to any Eloquent model, inspired by Advanced Custom Fields (ACF) for WordPress.

## Requirements

- PHP ^8.1
- Laravel ^10.0 or ^11.0 or ^12.0

## Installation

You can install the package via composer:

```bash
composer require hyder-kamran/laravel-custom-fields
```

Publish the configuration file and migrations:

```bash
php artisan vendor:publish --tag="custom-fields-config"
php artisan vendor:publish --tag="custom-fields-migrations"
php artisan vendor:publish --tag="custom-fields-seeders"
```

Run the database migrations:

```bash
php artisan migrate
```

(Optional) Seed the database with some default custom field groups:

```bash
php artisan db:seed --class=CustomFieldSeeder
```

## Setup

Add the `HasCustomFields` trait to any Eloquent model you want to attach custom fields to:

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use HyderKamran\CustomFields\Traits\HasCustomFields;

class Post extends Model
{
    use HasCustomFields;
}
```

## Usage

### Supported Field Types
The package ships with 20 production-ready field types out of the box:
`text`, `textarea`, `number`, `email`, `password`, `select`, `checkbox`, `radio`, `boolean` (switch), `date`, `datetime`, `time`, `url`, `color`, `range` (slider), `file`, `image`, `repeater`, `json`, and `wysiwyg`.

### 1. Creating Field Groups and Fields

You can create Field Groups and assign them to specific models.

```php
use HyderKamran\CustomFields\Models\FieldGroup;
use HyderKamran\CustomFields\Models\CustomField;
use App\Models\Post;

// Create a Field Group
$group = FieldGroup::create([
    'name' => 'SEO Settings',
    'model_type' => Post::class,
    'is_active' => true,
]);

// Add fields to the group
CustomField::create([
    'group_id' => $group->id,
    'name' => 'seo_title',
    'label' => 'SEO Title',
    'type' => 'text',
    'required' => true,
]);

CustomField::create([
    'group_id' => $group->id,
    'name' => 'seo_faqs',
    'label' => 'FAQs',
    'type' => 'repeater',
    'options' => [
        'sub_fields' => [
            ['name' => 'question', 'label' => 'Question', 'type' => 'text'],
            ['name' => 'answer', 'label' => 'Answer', 'type' => 'text'],
        ]
    ]
]);
```

### 2. Setting and Getting Field Values

```php
$post = Post::find(1);

// Set a simple text field
$post->setCustomField('seo_title', 'My Awesome Post SEO Title');

// Set a repeater field
$post->setCustomField('seo_faqs', [
    ['question' => 'What is this?', 'answer' => 'It is a package.'],
    ['question' => 'Is it free?', 'answer' => 'Yes, MIT license.']
]);

// Retrieve a specific field value
$seoTitle = $post->getCustomField('seo_title');

// Retrieve all custom fields as a Collection
$allFields = $post->getAllCustomFields(); 
```

### 3. Rendering Forms

The package provides a built-in rendering engine to generate form HTML for the assigned fields using Bootstrap 5 UI conventions.

In your Blade templates:

```blade
<form action="/posts/{{ $post->id }}" method="POST">
    @csrf
    <!-- Render all custom fields associated with the Post model -->
    @customFields($post)
    
    <button type="submit" class="btn btn-primary">Save Settings</button>
</form>
```

### 4. API Endpoints

The package exposes RESTful API endpoints out of the box if enabled in the config.

**GET: Retrieve custom fields for a model**
```
GET /api/custom-fields/App\Models\Post/1
```

**POST: Save custom fields for a model**
```
POST /api/custom-fields/App\Models\Post/1
Content-Type: application/json

{
    "fields": {
        "seo_title": "New Title via API",
        "seo_description": "Updated meta description"
    }
}
```

## Architecture

The package follows standard Laravel best practices with a clean, extensible architecture. 
You can register new custom Field Types in the `config/custom-fields.php` file by mapping a type slug to a class that implements `FieldRendererContract`.

## License

The MIT License (MIT).
