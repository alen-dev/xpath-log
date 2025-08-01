<?php

namespace AlenDev\XpathLog\Drivers;

use AlenDev\XpathLog\Contracts\DriverInterface;
use AlenDev\XpathLog\LogEntry;

class CliDriver implements DriverInterface
{
    /**
     * @param LogEntry $entry
     *
     * @return void
     */
    public function handle(LogEntry $entry): void
    {
        echo "[{$entry->timestamp}] {$entry->level}: {$entry->message} "
            . (!empty($entry->attributes) ? ' ' . json_encode($entry->attributes) : '')
            . PHP_EOL;
    }
}
