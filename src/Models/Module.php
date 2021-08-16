<?php

declare(strict_types=1);

namespace Brnbio\Modules\Models;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/**
 * Class Module
 *
 * @package Brnbio\Modules\Models
 */
class Module
{
    /**
     * @var string
     */
    public string $identifier;

    /**
     * @var array
     */
    protected array $config = [];

    /**
     * @param string $identifier
     * @param array $config
     */
    public function __construct(string $identifier, array $config = [])
    {
        $this->identifier = $identifier;
        $this->config = $config;
    }

    /**
     * @return string|null
     */
    public function getSeeder(): ?string
    {
        $seeder = $this->config['seeder'] ?? $this->getModuleClass('Database\\Seeders\\ModuleSeeder');
        if ( !class_exists($seeder)) {
            return null;
        }

        return $seeder;
    }

    /**
     * @return void
     */
    public function loadRoutes(): void
    {
        foreach ([
                     'web',
                     'api',
                 ] as $middleware) {
            $routes = $this->getModulePath('routes/' . $middleware . '.php');
            if (is_file($routes)) {
                Route::middleware($middleware)->group($routes);
            }
        }
    }

    /**
     * @return array
     */
    public function getCommands(): array
    {
        $commands = [];
        $commandsPath = $this->getModulePath('app/Console/Commands');

        if ( !is_dir($commandsPath)) {
            return $commands;
        }

        foreach (File::allFiles($commandsPath) as $command) {
            $command = $this->getModuleClass(
                (string) Str::of($command)
                    ->after('app/')
                    ->replace(['/', '.php'], ['\\', ''])
            );
            if (class_exists($command)) {
                $commands[] = $command;
            }
        }

        return $commands;
    }

    /**
     * @param string $className
     * @return string
     */
    public function getModuleClass(string $className): string
    {
        return $this->config['namespace'] . $className;
    }

    /**
     * @return string|null
     */
    public function getMigrationPath(): ?string
    {
        $migratePath = $this->getModulePath('database/migrations');

        return is_dir($migratePath) ? $migratePath : null;
    }

    /**
     * @param string $filename
     * @return string
     */
    public function getModulePath(string $filename): string
    {
        $src = $this->config['src'] ?? $this->identifier;

        return base_path('modules/' . $src . '/' . $filename);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->config['name'];
    }
}