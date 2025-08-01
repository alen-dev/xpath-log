<?php

namespace AlenDev\XpathLog\Tests\Mocks;

use AlenDev\XpathLog\Contracts\DriverInterface;
use AlenDev\XpathLog\LogEntry;

class MockDriver implements DriverInterface
{
    public array $entries = [];

    public function handle(LogEntry $entry): void
    {
        $this->entries[] = $entry;
    }
}
