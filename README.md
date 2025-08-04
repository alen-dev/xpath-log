# XpathLog 📓
[![Latest Version on Packagist](https://img.shields.io/packagist/v/alen-dev/xpath-log.svg?style=flat-square)](https://packagist.org/packages/alen-dev/xpath-log)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/alen-dev/xpath-log/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/alen-dev/xpath-log/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/alen-dev/xpath-log/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/alen-dev/xpath-log/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/alen-dev/xpath-log.svg?style=flat-square)](https://packagist.org/packages/alen-dev/xpath-log)

A simple and extensible Laravel logging package for structured logging, transactions, and multiple output drivers — all with zero code changes when switching drivers.

---

## 🚀 Features

- 🔧 Multiple log levels (`debug`, `info`, `warning`, `error`)
- 🏷 Tagged log entries with custom attributes
- 📁 Supports multiple drivers:
    - CLI (console output)
    - JSON file logging (rotated daily)
    - Simple text log file
- 🔄 Transaction-based logging with start/end timestamps
- 📆 Log viewer Artisan command with filters
- ➕ Easily add custom drivers without modifying the core
- 📦 Laravel-ready with automatic service provider & facade

---

## 📦 Installation

```bash
composer require alen-dev/xpath-log
```

## 🛠 Setup
Step 1: Publish the config
```bash
php artisan vendor:publish --tag=xpath-log-config
```
This is the contents of the published config file:

```php
return [
    'driver_map' => [
        'cli' => \AlenDev\XpathLog\Drivers\CliDriver::class,
        'json' => \AlenDev\XpathLog\Drivers\JsonFileDriver::class,
        'log'  => \AlenDev\XpathLog\Drivers\LogFileDriver::class,
    ],
    'external_driver_map' => [],
    'default_drivers' => explode(',', env('XPATH_LOG_DEFAULT_DRIVERS', 'cli,log')),
    'file_name' => env('XPATH_LOG_FILENAME', 'xpath'),
];
```

Step 2: Optional ENV config
```bash
XPATH_LOG_DEFAULT_DRIVERS="cli,log"
XPATH_LOG_FILENAME=xpathlog
```
---

## 🧪 Usage
Basic Logging
```bash
$xPathLog = new XpathLog();
$xPathLog
    ->use('cli')
    ->log('warning', 'message', ['test' => '34234']);
```

Transaction Logging
```bash
$xPathLog
    ->use('json')
    ->startTransaction('TX-789', ['customerId' => 123]);
$xPathLog
    ->use('json')
    ->endTransaction('TX-789', ['status' => 'success']);
```
Or log custom transaction messages:
```bash
$xPathLog
    ->use('json')
    ->transaction('abc-123', 'Applied discount', ['code' => 'SUMMER']);
```
---
## 🖥 Artisan Log Viewer
Optional: you can use some sample data for Artisan Log Viewer
```bash
xpathlog:create-sample
```
View the most recent XpathLog entries from your JSON log file
```bash
php artisan xpathlog:view
```
Filter logs
```bash
php artisan xpathlog:view --level=error
php artisan xpathlog:view --search=payment
php artisan xpathlog:view --date=2025-08-01
php artisan xpathlog:view --from="2025-08-01" --to="2025-08-02"
php artisan xpathlog:view --search=payment --from="yesterday"
```
## 🧩 Custom Drivers
You can register custom drivers externally via config:
```bash
// config/xpath-log.php
'driver_map' => [
    'slack' => App\Logging\Drivers\SlackDriver::class,
],
```
Each driver must implement:
```bash
interface DriverInterface {
    public function handle(LogEntry $entry): void;
}
```

## 🧩 Request Logger
This feature is disabled by default. To enable just add the following variable to your .env file:
```bash
XPATH_LOG_ENABLE_REQUEST_LOGGER=true
```
If enabled, by default, this will log every request on your web middleware but you can change this by adding the following line to your .env file:
```bash
XPATH_LOG_MIDDLEWARE_GROUP=api
```

## 🧪 Testing
```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Alain Traxler](https://github.com/alen-dev)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
