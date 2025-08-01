<?php

namespace AlenDev\XpathLog\Contracts;

use AlenDev\XpathLog\LogEntry;

interface DriverInterface
{
    /**
     * @param LogEntry $entry
     *
     * @return void
     */
    public function handle(LogEntry $entry): void;
}

