<?php

namespace AlenDev\XpathLog\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class ViewLogCommand extends Command
{
    protected $signature = 'xpathlog:view
                                {--date= : Date of the log file to read (e.g. 2025-08-01)}
                                {--level= : Filter by log level (e.g. error, info)}
                                {--lines=10 : Number of recent lines to show}
                                {--search= : Keyword to search in message or attributes}
                                {--from= : Start date (e.g. 2025-07-01 or 2025-07-01T10:00)}
                                {--to= : End date (e.g. 2025-07-31 or 2025-07-31T23:59)}
                                ';
    protected $description = 'View the most recent XpathLog entries from the JSON log file';

    /**
     * Usage examples:
     *      php artisan xpathlog:view --from="2025-07-01" --to="2025-07-31"
     *      php artisan xpathlog:view --level=error --from="2025-08-01T00:00" --to="2025-08-01T10:00"
     *      php artisan xpathlog:view --search=payment --from="yesterday"
     *
     * @return void
     */
    public function handle(): void
    {
        $fileName = config('xpath-log.file_name');
        $date = $this->option('date') ?? now()->format('Y-m-d');
        $file = storage_path("logs/{$fileName}-{$date}.json");

        $filtersUsed = $this->option('level') || $this->option('search') || $this->option('from') || $this->option('to') || $this->option('date');

        if (!file_exists($file)) {
            $pattern = storage_path("logs/{$fileName}-*.json");
            $files = glob($pattern);

            if (empty($files)) {
                $this->warn("No log files found in: " . storage_path('logs'));
                return;
            }

            $this->warn("Log file not found for ({$date}). Please select from available log files:");

            $choices = collect($files)->map(fn($f) => basename($f))->sort()->values()->all();
            $chosen = $this->choice('Select a log file to view', $choices);

            $file = storage_path('logs/' . $chosen);

//            if (!$filtersUsed) {
//                $this->warn("Log file not found for today ({$date}). Please select from available log files:");
//
//                $choices = collect($files)->map(fn($f) => basename($f))->sort()->values()->all();
//                $chosen = $this->choice('Select a log file to view', $choices);
//
//                $file = storage_path('logs/' . $chosen);
//            } else {
//                $this->warn("Log file not found: $file");
//                return;
//            }
        } else {
            if (!$filtersUsed) {
                $this->info('Showing log file: ' . basename($file));
            }
        }

        $rawLines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $rawLines = array_reverse($rawLines);
        $rawLines = array_slice($rawLines, 0, $this->option('lines') ?? 10);

        $filterLevel = strtolower($this->option('level') ?? '');
        $keyword = strtolower($this->option('search') ?? '');
        $from = $this->option('from') ? Carbon::parse($this->option('from')) : null;
        $to = $this->option('to') ? Carbon::parse($this->option('to')) : null;

        $lines = [];

        foreach ($rawLines as $line) {
            $entry = json_decode($line, true);

            if (!is_array($entry)) {
                continue;
            }

            // Timestamp filter
            $timestamp = Carbon::parse($entry['timestamp'] ?? null);
            if (!$timestamp) {
                continue;
            }

            if ($from && $timestamp->lt($from)) {
                continue;
            }

            if ($to && $timestamp->gt($to)) {
                continue;
            }

            // Level filter
            if ($filterLevel && strtolower($entry['level'] ?? '') !== $filterLevel) {
                continue;
            }

            // Keyword filter
            if ($keyword) {
                $message = strtolower($entry['message'] ?? '');
                $attributes = collect($entry['attributes'] ?? [])
                    ->map(fn($v, $k) => "$k: $v")
                    ->implode(', ');
                $haystack = $message . ' ' . strtolower($attributes);

                if (!str_contains($haystack, $keyword)) {
                    continue;
                }
            }

            $lines[] = [
                'Time'       => $entry['timestamp'] ?? '-',
                'Level'      => strtoupper($entry['level'] ?? 'UNKNOWN'),
                'Message'    => $entry['message'] ?? '',
                'Attributes' => collect($entry['attributes'] ?? [])->map(fn($v, $k) => "$k: $v")->implode(', '),
            ];
        }

        if (empty($lines)) {
            $this->info('No logs found for the specified criteria.');
            return;
        }

        $this->table(['Time', 'Level', 'Message', 'Attributes'], $lines);
    }
}
