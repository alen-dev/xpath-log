<?php

//return [
//    'channel' =>  env('XPATH_LOG_CHANNEL', 'custom'),
//    'level' =>  env('XPATH_LOG_LEVEL', 'debug'),
//    'filename' => env('XPATH_LOG_FILENAME', 'xpath'),
//    'filetype' => env('XPATH_LOG_FILETYPE', 'log'), // log, txt, json
//];

return [
    'driver_map' => [
        'cli' => \AlenDev\XpathLog\Drivers\CliDriver::class,
        'json' => \AlenDev\XpathLog\Drivers\JsonFileDriver::class,
        'log'  => \AlenDev\XpathLog\Drivers\LogFileDriver::class,
//        'slack' => \App\Telemetry\Drivers\SlackDriver::class, // added externally
    ],

    'default_drivers' => ['cli', 'log'],

    'file_name' => env('XPATH_LOG_FILENAME', 'xpath'),
];
