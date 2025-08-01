<?php

namespace AlenDev\XpathLog;

use AlenDev\XpathLog\Commands\XpathLogCommand;
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

}

