<?php

namespace AlenDev\XpathLog\Drivers;

use AlenDev\XpathLog\LogEntry;

class LogFileDriver extends BaseFileDriver
{
    public function handle(LogEntry $entry): void
    {
        $filePath = $this->getDatedFilePath('log');

        $line = "[{$entry->timestamp}] {$entry->level}: {$entry->message}";

        if (!empty($entry->attributes)) {
            $line .= ' | ' . json_encode($entry->attributes);
        }

        file_put_contents($filePath, $line . PHP_EOL, FILE_APPEND);
    }
}
