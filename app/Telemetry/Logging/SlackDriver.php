<?php

namespace App\Logging\Drivers;

use AlenDev\XpathLog\Contracts\DriverInterface;
use AlenDev\XpathLog\LogEntry;
use Illuminate\Support\Facades\Http;

class SlackDriver implements DriverInterface
{
    protected string $webhookUrl;

    public function __construct()
    {
        // add your slack webhook here (https://hooks.slack.com/services/...)
        $this->webhookUrl = '';
    }

    public function handle(LogEntry $entry): void
    {
        $message = "*[{$entry->level}]* {$entry->message}";
        if (!empty($entry->attributes)) {
            $message .= "\n```" . json_encode($entry->attributes, JSON_PRETTY_PRINT) . "```";
        }

        Http::post($this->webhookUrl, [
            'text' => $message,
        ]);
    }
}
