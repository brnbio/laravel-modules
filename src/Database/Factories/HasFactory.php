<?php

declare(strict_types=1);

namespace Brnbio\Modules\Database\Factories;

use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory as BaseHasFactoryTrait;
use Illuminate\Support\Arr;

/**
 * Trait HasFactory for Modules
 *
 * @package Brnbio\Modules\Database\Factories
 */
trait HasFactory
{
    use BaseHasFactoryTrait;

    /**
     * @return Factory
     * @throws Exception
     */
    public static function newFactory(): Factory
    {
        $className = explode('\\', get_called_class());
        $factory = Arr::first($className) . '\\Database\\Factories\\' . Arr::last($className) . 'Factory';

        if ( !class_exists($factory)) {
            throw new Exception("Factory [$factory] not found.");
        }

        return new $factory;
    }
}