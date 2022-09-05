<?php

namespace Modules\Generator\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Generator\Console\ActionGeneratorCommand;
use Modules\Generator\Console\GeneratorCommand;
use Modules\Generator\Console\ModalGeneratorCommand;
use Modules\Generator\Console\ModelGeneratorCommand;
use Modules\Generator\Console\PageGeneratorCommand;
use Modules\Generator\Console\PermissionGeneratorCommand;
use Modules\Generator\Console\ResourceGeneratorCommand;
use Modules\Generator\Console\RouteGeneratorCommand;
use Modules\Generator\Console\WidgetGeneratorCommand;

class GeneratorServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Generator';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'generator';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {

        // assign commands
        $this->commands([
            GeneratorCommand::class,
            ModelGeneratorCommand::class,
            ResourceGeneratorCommand::class,
            PermissionGeneratorCommand::class,
            ActionGeneratorCommand::class,
            ModalGeneratorCommand::class,
            PageGeneratorCommand::class,
            WidgetGeneratorCommand::class,
            RouteGeneratorCommand::class,
        ]);
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
            $this->loadJsonTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
            $this->loadJsonTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }

}
