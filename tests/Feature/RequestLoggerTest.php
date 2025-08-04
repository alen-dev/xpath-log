<?php

use AlenDev\XpathLog\Http\Middleware\RequestLogger;
use AlenDev\XpathLog\XpathLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;

// Boot test environment
beforeEach(function () {
    // Configure drivers
    Config::set('xpath-log.default_drivers', ['log']);

    // Create dummy user
    $user = new class {
        public $name = 'Jane Doe';
    };

    // Simulate authenticated user
    Auth::shouldReceive('user')->andReturn($user);

    // Register a test route with middleware applied
    Route::middleware(RequestLogger::class)->post('/test-logger', function () {
        return response('OK', 200);
    });
});

it('logs request using configured drivers', function () {
    // Create XpathLog mock
    $mockLog = Mockery::mock(XpathLog::class);
    $mockLog->shouldReceive('use')->once()->with(['log'])->andReturnSelf();
    $mockLog->shouldReceive('log')->once()->with(
        'info',
        'message',
        Mockery::on(function ($log) {
            return isset($log['User']) && $log['User'] === 'Jane Doe'
                && isset($log['Method']) && $log['Method'] === 'POST'
                && isset($log['URI']) && str_contains($log['URI'], '/test-logger');
        })
    );

    // Bind the mock
    app()->instance(XpathLog::class, $mockLog);

    // Trigger route
    $this->post('/test-logger')->assertOk();
});
