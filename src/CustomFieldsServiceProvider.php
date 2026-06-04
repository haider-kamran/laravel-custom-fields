<?php

declare(strict_types=1);

namespace HyderKamran\CustomFields;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use HyderKamran\CustomFields\Services\FieldRendererService;

class CustomFieldsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/custom-fields.php',
            'custom-fields'
        );

        $this->app->singleton(FieldRendererService::class, function ($app) {
            return new FieldRendererService();
        });
    }

    public function boot(Filesystem $filesystem): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/custom-fields.php' => config_path('custom-fields.php'),
            ], 'custom-fields-config');

            $this->publishes([
                __DIR__ . '/../database/migrations/create_custom_fields_tables.php.stub' => $this->getMigrationFileName($filesystem),
            ], 'custom-fields-migrations');

            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/custom-fields'),
            ], 'custom-fields-views');

            $this->publishes([
                __DIR__ . '/../database/seeders/CustomFieldSeeder.php' => database_path('seeders/CustomFieldSeeder.php'),
            ], 'custom-fields-seeders');
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'custom-fields');
        
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        
        // Blade Directives
        Blade::directive('customFields', function ($expression) {
            return "<?php echo app(\\HyderKamran\\CustomFields\\Services\\FieldRendererService::class)->renderForm($expression); ?>";
        });
    }

    /**
     * Returns existing migration file if found, else uses the current timestamp.
     */
    protected function getMigrationFileName(Filesystem $filesystem): string
    {
        $timestamp = date('Y_m_d_His');

        return Collection::make($this->app->databasePath() . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR)
            ->flatMap(function ($path) use ($filesystem) {
                return $filesystem->glob($path . '*_create_custom_fields_tables.php');
            })->push($this->app->databasePath() . "/migrations/{$timestamp}_create_custom_fields_tables.php")
            ->first();
    }
}
