<?php

namespace AlenDev\XpathLog\Drivers;

use AlenDev\XpathLog\LogEntry;

class JsonFileDriver extends BaseFileDriver
{
    public function handle(LogEntry $entry): void
    {
        $filePath = $this->getDatedFilePath('json');

        file_put_contents($filePath, json_encode([
                'timestamp'  => $entry->timestamp,
                'level'      => $entry->level,
                'message'    => $entry->message,
                'attributes' => $entry->attributes,
            ]) . PHP_EOL, FILE_APPEND);
    }
}
