<?php

namespace AlenDev\XpathLog\Drivers;

use AlenDev\XpathLog\Contracts\DriverInterface;
use AlenDev\XpathLog\LogEntry;

class LogFileDriver implements DriverInterface
{
    protected string $file;

    public function __construct()
    {
        $this->file = config('xpath-log.log_file_path', storage_path('logs/telemetry.log'));
    }

    public function handle(LogEntry $entry): void
    {
        $line = "[{$entry->timestamp}] {$entry->level}: {$entry->message}";

        if (!empty($entry->attributes)) {
            $line .= ' | ' . json_encode($entry->attributes);
        }

        file_put_contents($this->file, $line . PHP_EOL, FILE_APPEND);
    }
}
