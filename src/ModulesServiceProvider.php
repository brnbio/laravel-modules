<?php

declare(strict_types=1);

namespace Brnbio\Modules;

use Brnbio\Modules\Console\Commands\MakeModule;
use Brnbio\Modules\Models\Module;
use Illuminate\Support\ServiceProvider;

/**
 * Class ModulesServiceProvider
 *
 * @package Brnbio\Modules
 */
class ModulesServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/config/modules.php' => config_path('modules.php'),
        ]);

        /** @var Module $module */
        foreach (modules() as $module) {
            $module->loadRoutes();
            $this->loadConfig($module);
            $this->loadMigrationsFrom($module->getMigrationPath());
            $this->commands($module->getCommands());
            $this->loadViewsFrom($module->getModulePath('resources/views'), $module->identifier);
        }
    }

    /**
     * @return void
     */
    public function register(): void
    {
        require_once(__DIR__ . '/helpers.php');
        $this->loadCommands();
        $this->mergeConfigFrom(__DIR__ . '/config/modules.php', 'modules');
    }

    /**
     * @return void
     */
    private function loadCommands(): void
    {
        $this->commands([
            MakeModule::class,
        ]);
    }

    /**
     * @param Module $module
     * @return void
     */
    private function loadConfig(Module $module): void
    {
        $configFile = $module->getModulePath('config/' . $module->identifier . '.php');
        if (is_file($configFile)) {
            $this->mergeConfigFrom($configFile, $module->identifier);
        }
    }
}
