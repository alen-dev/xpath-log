<?php

namespace AlenDev\XpathLog;

use AlenDev\XpathLog\Contracts\DriverInterface;
use AlenDev\XpathLog\LogEntry;

class XpathLog
{
    protected array $driverMap;
    protected array $defaultDriverNames;
    protected array $activeDrivers = [];

    public function __construct()
    {
        $this->driverMap = config('xpath-log.driver_map', []);
        $this->defaultDriverNames = config('xpath-log.default_drivers', []);
        $this->use($this->defaultDriverNames);
    }

    public function use(array|string $driverNames): self
    {
        $driverNames = (array) $driverNames;
        $this->activeDrivers = [];

        foreach ($driverNames as $name) {
            if (!isset($this->driverMap[$name])) {
                throw new \InvalidArgumentException("Driver [$name] not found.");
            }

            $driver = app($this->driverMap[$name]);

            if (!$driver instanceof DriverInterface) {
                throw new \RuntimeException("Driver [$name] must implement DriverInterface.");
            }

            $this->activeDrivers[] = $driver;
        }

        return $this;
    }

    public function log(string $level, string $message, array $attributes = []): void
    {
        $entry = new LogEntry($level, $message, $attributes);

        foreach ($this->activeDrivers as $driver) {
            $driver->handle($entry);
        }
    }

    public function transaction(string $transactionId, string $message, array $attributes = []): void
    {
        $this->log('info', $message, array_merge(['transactionId' => $transactionId], $attributes));
    }
}
