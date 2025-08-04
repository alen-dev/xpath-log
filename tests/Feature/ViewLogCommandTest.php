<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

beforeEach(function () {
    $this->logFile = storage_path('logs/xpath-' . now()->format('Y-m-d') . '.json');

    File::ensureDirectoryExists(storage_path('logs'));

    // Seed the log file
    File::put($this->logFile, json_encode([
            'timestamp' => now()->toISOString(),
            'level' => 'info',
            'message' => 'Test log entry',
            'attributes' => ['user' => 42],
        ]) . PHP_EOL);
});

afterEach(function () {
    File::delete($this->logFile);
});

it('shows logs using the xpathlog:view command', function () {
    Artisan::call('xpathlog:view', [
        '--date' => now()->format('Y-m-d'),
        '--lines' => 1,
    ]);

    $output = Artisan::output();

    expect($output)->toContain('Test log entry');
    expect($output)->toContain('INFO');
    expect($output)->toContain('user: 42');
});

it('filters logs by level using xpathlog:view', function () {
    Artisan::call('xpathlog:view', [
        '--level' => 'info',
        '--date' => now()->format('Y-m-d'),
    ]);

    $output = Artisan::output();

    expect($output)->toContain('Test log entry');
});
