<?php

namespace AlenDev\XpathLog\Drivers;

use AlenDev\XpathLog\Contracts\DriverInterface;
use AlenDev\XpathLog\LogEntry;

class LogFileDriver implements DriverInterface
{
    protected string $file;

    public function __construct()
    {
        $fileName = config('xpath-log.file_name');
        $this->file = storage_path("logs/{$fileName}.log");
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
