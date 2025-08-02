<?php

namespace AlenDev\XpathLog\Commands;

use Illuminate\Console\Command;

class ViewDriversCommand extends Command
{
    protected $signature = 'xpathlog:drivers';
    protected $description = 'Display a list of available XpathLog drivers and their associated classes';

    /**
     * @return void
     */
    public function handle(): void
    {
        $map = config('xpath-log.driver_map');

        $this->table(['Driver', 'Class'], collect($map)->map(fn($c, $k) => [$k, $c])->toArray());
    }
}






