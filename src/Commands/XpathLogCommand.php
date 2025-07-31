<?php

namespace AlenDev\XpathLog\Commands;

use Illuminate\Console\Command;

class XpathLogCommand extends Command
{
    public $signature = 'xpath-log';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('Hello xpath!');
        $this->comment(config_path('channel'));

        return self::SUCCESS;
    }
}
