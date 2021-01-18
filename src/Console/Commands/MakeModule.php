<?php

declare(strict_types=1);

namespace Brnbio\Modules\Console\Commands;

use Illuminate\Console\Command;

/**
 * Class MakeModule
 *
 * @package Brnbio\Modules\Console\Commands
 */
class MakeModule extends Command
{
    /**
     * @var string
     */
    protected $signature = 'module:make {name}';

    /**
     * @var string
     */
    protected $description = 'Make a module';

    /**
     * @return int
     */
    public function handle(): int
    {
        // TODO: dir structure
        // TODO: composer.json anpassen

        return 0;
    }
}
