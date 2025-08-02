<?php

return [
    'driver_map' => [
        'cli' => \AlenDev\XpathLog\Drivers\CliDriver::class,
        'json' => \AlenDev\XpathLog\Drivers\JsonFileDriver::class,
        'log'  => \AlenDev\XpathLog\Drivers\LogFileDriver::class,
    ],

    'external_driver_map' => [
        // 'slack' => \App\Logging\Drivers\SlackDriver::class, // added externally
    ],

    'default_drivers' => explode(',', env('XPATH_LOG_DEFAULT_DRIVERS', 'cli,log')),

    'file_name' => env('XPATH_LOG_FILENAME', 'xpath'),
];
