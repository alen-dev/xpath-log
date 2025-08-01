<?php

//namespace AlenDev\XpathLog\Tests;

//use Illuminate\Database\Eloquent\Factories\Factory;
//use Orchestra\Testbench\TestCase as Orchestra;
//use AlenDev\XpathLog\XpathLogServiceProvider;

//class TestCase extends Orchestra
//{
//    protected function setUp(): void
//    {
//        parent::setUp();
//
//        Factory::guessFactoryNamesUsing(
//            fn (string $modelName) => 'AlenDev\\XpathLog\\Database\\Factories\\'.class_basename($modelName).'Factory'
//        );
//    }
//
//    protected function getPackageProviders($app)
//    {
//        return [
//            XpathLogServiceProvider::class,
//        ];
//    }
//
//    public function getEnvironmentSetUp($app)
//    {
//        config()->set('database.default', 'testing');
//
//        /*
//         foreach (\Illuminate\Support\Facades\File::allFiles(__DIR__ . '/database/migrations') as $migration) {
//            (include $migration->getRealPath())->up();
//         }
//         */
//    }
//}


namespace AlenDev\XpathLog\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use AlenDev\XpathLog\XpathLogServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            XpathLogServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app)
    {
        $app['config']->set('xpath-log.driver_map', [
            'cli'  => \AlenDev\XpathLog\Drivers\CliDriver::class,
            'json' => \AlenDev\XpathLog\Drivers\JsonFileDriver::class,
            'log'  => \AlenDev\XpathLog\Drivers\LogFileDriver::class,
        ]);

        $app['config']->set('xpath-log.default_drivers', ['cli']);
    }

    protected function getPackageAliases($app)
    {
        return [
            'Telemetry' => \AlenDev\XpathLog\Facades\XpathLog::class,
        ];
    }
}
