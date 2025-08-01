<?php

use AlenDev\XpathLog\XpathLog;
use AlenDev\XpathLog\Contracts\DriverInterface;
use AlenDev\XpathLog\LogEntry;
use AlenDev\XpathLog\Tests\Mocks\MockDriver;
use Illuminate\Support\Facades\Config;

beforeEach(function () {
    Config::set('xpath-log.driver_map', [
        'mock' => MockDriver::class,
    ]);

    Config::set('xpath-log.default_drivers', ['mock']);

    app()->bind(MockDriver::class, fn () => new MockDriver());
});

it('can use a single driver', function () {
    $logger = new XpathLog();

    expect($logger->use('mock'))->toBeInstanceOf(XpathLog::class);
});

it('throws if driver not found', function () {
    $logger = new XpathLog();

    $logger->use('invalid-driver');
})->throws(InvalidArgumentException::class, 'Driver [invalid-driver] not found.');

it('throws if driver does not implement interface', function () {
    Config::set('xpath-log.driver_map', ['bad' => stdClass::class]);
    Config::set('xpath-log.default_drivers', ['bad']); // ensures constructor doesn't crash early

    $logger = new XpathLog();

    // Now explicitly call use again to trigger interface check
    $logger->use('bad');
})->throws(RuntimeException::class, 'Driver [bad] must implement DriverInterface.');

it('logs a message through active drivers', function () {
    $mockDriver = Mockery::mock(DriverInterface::class);
    $mockDriver->shouldReceive('handle')->once()->with(Mockery::type(LogEntry::class));

    app()->instance(MockDriver::class, $mockDriver);

    $logger = new XpathLog();
    $logger->use('mock')->log('info', 'Test message');
});

it('logs a transaction with transactionId', function () {
    $mockDriver = Mockery::mock(DriverInterface::class);
    $mockDriver->shouldReceive('handle')->once()->with(Mockery::on(function ($entry) {
        return $entry instanceof LogEntry && $entry->attributes['transactionId'] === 'abc123';
    }));

    app()->instance(MockDriver::class, $mockDriver);

    $logger = new XpathLog();
    $logger->use('mock')->transaction('abc123', 'Transaction message');
});
