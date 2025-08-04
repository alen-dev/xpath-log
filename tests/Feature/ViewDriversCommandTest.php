<?php

use Illuminate\Support\Facades\Artisan;

it('lists available drivers', function () {
    Artisan::call('xpathlog:drivers');

    $output = Artisan::output();

    expect($output)->toContain('cli')
        ->toContain('json')
        ->toContain('log');
});
