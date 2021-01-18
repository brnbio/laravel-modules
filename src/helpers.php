<?php

declare(strict_types=1);

use Brnbio\Modules\Models\Module;
use Illuminate\Support\Collection;

if (!function_exists('modules')) {
    /**
     * @return Collection
     */
    function modules(): Collection
    {
        $modules = new Collection();
        foreach (config('modules') as $module => $config) {
            if ($config['enabled'] ?? false) {
                $modules->add(new Module($module, $config));
            }
        }

        return $modules;
    }
}