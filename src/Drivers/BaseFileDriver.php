<?php

namespace AlenDev\XpathLog\Drivers;

use AlenDev\XpathLog\Contracts\DriverInterface;
use Illuminate\Support\Facades\File;

abstract class BaseFileDriver implements DriverInterface
{
    protected string $baseFileName;

    public function __construct()
    {
        $this->baseFileName = config('xpath-log.file_name', 'xpathlog');
    }

    protected function getDatedFilePath(string $extension): string
    {
        $date = now()->format('Y-m-d');
        $filePath = storage_path("logs/{$this->baseFileName}-{$date}.{$extension}");

        if (!File::exists(dirname($filePath))) {
            File::makeDirectory(dirname($filePath), 0755, true);
        }

        return $filePath;
    }
}
