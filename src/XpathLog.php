<?php

namespace AlenDev\XpathLog;

use AlenDev\XpathLog\Contracts\DriverInterface;
use AlenDev\XpathLog\LogEntry;

class XpathLog
{
    protected array $driverMap;
    protected array $defaultDriverNames;
    protected array $activeDrivers = [];
    protected array $transactions = [];

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

    public function startTransaction(string $transactionId, array $attributes = []): void
    {
        $this->transactions[$transactionId] = [
            'start' => now(),
            'attributes' => $attributes,
        ];

        $this->log('info', 'Transaction started', array_merge(['transactionId' => $transactionId], $attributes));
    }

    public function endTransaction(string $transactionId, array $attributes = []): void
    {
        if (!isset($this->transactions[$transactionId])) {
            throw new \InvalidArgumentException("Transaction [$transactionId] was not started.");
        }

        $start = $this->transactions[$transactionId]['start'];
        $durationMs = now()->diffInMilliseconds($start);

        $this->log('info', 'Transaction ended', array_merge([
            'transactionId' => $transactionId,
            'durationMs' => $durationMs,
        ], $this->transactions[$transactionId]['attributes'], $attributes));

        unset($this->transactions[$transactionId]);
    }

    public function transaction(string $transactionId, string $message, array $attributes = []): void
    {
        $this->log('info', $message, array_merge(['transactionId' => $transactionId], $attributes));
    }
}
