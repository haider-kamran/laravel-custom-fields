<?php

declare(strict_types=1);

namespace HyderKamran\CustomFields\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use HyderKamran\CustomFields\CustomFieldsServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            CustomFieldsServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app)
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    protected function defineDatabaseMigrations()
    {
        // Load the package's migrations
        $migration = include __DIR__ . '/../database/migrations/create_custom_fields_tables.php.stub';
        $migration->up();

        // Create a dummy table for the testing model
        Schema::create('test_models', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }
}
