<?php

namespace AlenDev\XpathLog;

use AlenDev\XpathLog\Commands\XpathLogCommand;
use AlenDev\XpathLog\Http\Middleware\RequestLogger;
use AlenDev\XpathLog\XpathLog;
use Carbon\Carbon;
use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\StreamHandler;
use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Illuminate\Support\ServiceProvider;


class XpathLogServiceProvider extends PackageServiceProvider
{


//    public function bootingPackage()
//    {
//        // Get dynamic channel name from config
//        $channelName = xpath_channel_name();
//        $fileName = config('xpath-log.filename');
//        $fileType = config('xpath-log.filetype');
//
//        // Define the new logging channel
//        $date = Carbon::today()->toDateString();
//        $newChannel = [
//            'driver' => 'daily',
//            'path' => storage_path("logs/{$fileName}.{$fileType}"),
//            'level' => 'debug',
//            'days' => 14,
//        ];
//
////        $newChannel = [
////            'driver' => 'daily',
////            'handler' => StreamHandler::class,
////            'handler_with' => [
////                'stream' => 'php://stderr',
////            ],
////            'formatter' => JsonFormatter::class,
////            'path' => storage_path("logs/{$fileName}.{$fileType}"),
////            'level' => 'debug',
////            'days' => 14,
////        ];
//
//        // Get existing logging channels
//        $channels = config('logging.channels');
//
//        // Add/override the dynamic channel
//        $channels[$channelName] = $newChannel;
//
//        // Apply the updated channels to the logging config
//        config(['logging.channels' => $channels]);
//    }



    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('xpath-log')
            ->hasConfigFile('xpath-log')
            ->hasViews()
            ->hasMigration('create_xpath_log_table')
            ->hasCommand(XpathLogCommand::class)
        ;



        /**
         * Spatie package tools doesn't support Middlewares, so we add it to Kernel
         * https://github.com/spatie/laravel-package-tools/discussions/6
         */

//        $kernel = app(\Illuminate\Contracts\Http\Kernel::class);
//        $kernel->prependMiddlewareToGroup('web', RequestLogger::class);
    }


//    public function packageRegistered(): void
//    {
//        $this->app->singleton('xpathlog', function ($app) {
//            return new XpathLog();
//        });
//    }



}

