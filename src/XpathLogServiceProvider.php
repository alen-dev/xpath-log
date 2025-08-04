<?php

namespace AlenDev\XpathLog;

use AlenDev\XpathLog\Commands\XpathLogCommand;
use AlenDev\XpathLog\Commands\ViewLogCommand;
use AlenDev\XpathLog\Commands\ViewDriversCommand;
use AlenDev\XpathLog\Http\Middleware\RequestLogger;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;


class XpathLogServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('xpath-log')
            ->hasConfigFile('xpath-log')
            ->hasCommands(
                XpathLogCommand::class,
                ViewLogCommand::class,
                ViewDriversCommand::class
            );



    }

    public function bootingPackage(): void
    {
        // Merge external_driver_map into driver_map
        $driverMap = config('xpath-log.driver_map', []);
        $externalMap = config('xpath-log.external_driver_map', []);
        config()->set('xpath-log.driver_map', array_merge($driverMap, $externalMap));

        /**
         * Conditionally add middleware
         *
         * Spatie package tools doesn't support Middlewares, so we add it to Kernel
         * https://github.com/spatie/laravel-package-tools/discussions/6
         */
        if (config('xpath-log.enable_request_logger', false)) {
            $kernel = app(\Illuminate\Contracts\Http\Kernel::class);
            $group = config('xpath-log.middleware_group', 'web');
            $kernel->prependMiddlewareToGroup($group, RequestLogger::class);
        }
    }

}

