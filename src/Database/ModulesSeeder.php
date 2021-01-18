<?php

declare(strict_types=1);

namespace Brnbio\Modules\Database;

use Brnbio\Modules\Models\Module;
use Illuminate\Database\Seeder;

/**
 * Class ModulesSeeder
 *
 * @package Brnbio\Modules\Database
 */
class ModulesSeeder extends Seeder
{
    public function run(): void
    {
        $seeder = $this->getSeederFromModules();
        $this->call($seeder);
    }

    private function getSeederFromModules(): array
    {
        $seeders = [];
        /** @var Module $module */
        foreach (modules() as $module) {
            if ($seeder = $module->getSeeder()) {
                $seeders[] = $seeder;
            }
        }

        return $seeders;
    }
}