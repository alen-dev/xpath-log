<?php

namespace AlenDev\XpathLog;

use AlenDev\XpathLog\Commands\XpathLogCommand;
use AlenDev\XpathLog\Http\Middleware\RequestLogger;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class XpathLogServiceProvider extends PackageServiceProvider
{
//    public function bootingPackage()
//    {
//        app('router')->pushMiddlewareToGroup('RequestLogger', RequestLogger::class);
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
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_xpath_log_table')
//            ->hasMiddleware(RequestLogger::class)
            ->hasCommand(XpathLogCommand::class);

        $kernel = app(\Illuminate\Contracts\Http\Kernel::class);
        $kernel->prependMiddlewareToGroup('web', RequestLogger::class);
    }
}

//class XpathLogServiceProvider extends ServiceProvider
//{
//
//}
