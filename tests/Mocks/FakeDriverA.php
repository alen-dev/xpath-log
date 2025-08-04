<?php

namespace AlenDev\XpathLog\Tests\Mocks;

use AlenDev\XpathLog\Contracts\DriverInterface;
use AlenDev\XpathLog\LogEntry;

class FakeDriverA implements DriverInterface
{
    public static array $calls = [];

    public function handle(LogEntry $entry): void
    {
        self::$calls[] = ['driver' => 'A', 'entry' => $entry];
    }
}
