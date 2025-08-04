<?php

namespace AlenDev\XpathLog\Tests\Mocks;

use AlenDev\XpathLog\Contracts\DriverInterface;
use AlenDev\XpathLog\LogEntry;

class FakeDriverB implements DriverInterface
{
    public static array $calls = [];

    public function handle(LogEntry $entry): void
    {
        self::$calls[] = ['driver' => 'B', 'entry' => $entry];
    }
}
