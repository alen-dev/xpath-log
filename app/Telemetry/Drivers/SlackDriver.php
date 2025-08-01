<?php

namespace App\Telemetry\Drivers;

use AlenDev\XpathLog\Contracts\DriverInterface;
use AlenDev\XpathLog\LogEntry;

class SlackDriver implements DriverInterface
{
    public function handle(LogEntry $entry): void
    {
        // Send log to Slack via webhook
        $message = "[{$entry->timestamp}] {$entry->level}: {$entry->message}";
        // Slack sending code here...
    }
}
