<?php

namespace AlenDev\XpathLog;

class LogEntry
{
    public string $timestamp;

    public function __construct(
        public string $level,
        public string $message,
        public array  $attributes = []
    )
    {
        $this->timestamp = now();
    }
}
