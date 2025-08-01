<?php

namespace AlenDev\XpathLog\Drivers;

use AlenDev\XpathLog\Contracts\DriverInterface;
use AlenDev\XpathLog\LogEntry;

class JsonFileDriver implements DriverInterface
{
    protected string $file;

    public function __construct()
    {
        $fileName = config('xpath-log.file_name');
        $this->file = storage_path("logs/{$fileName}.json");
    }

    public function handle(LogEntry $entry): void
    {
        file_put_contents($this->file, json_encode([
                'timestamp'  => $entry->timestamp,
                'level'      => $entry->level,
                'message'    => $entry->message,
                'attributes' => $entry->attributes,
            ]) . PHP_EOL, FILE_APPEND);
    }
}
