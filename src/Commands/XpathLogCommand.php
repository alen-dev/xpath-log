<?php

namespace AlenDev\XpathLog\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use AlenDev\XpathLog\XpathLog;
use Illuminate\Support\Facades\Auth;

class XpathLogCommand extends Command
{
    public $signature = 'xpath-log';

    public $description = 'My command';

    public function handle(Request $request): void
    {
        $this->comment('Hello xpath!');


        $xPathLog = new XpathLog();

        // Log to CLI only
//        $telemetry->use('cli')->log('info', 'Logged to CLI');
//
//        // Log to JSON file only
//        $telemetry->use('json')->log('error', 'Logged to JSON');
//
//        // Log to both
//        $telemetry->use(['cli', 'json'])->log('debug', 'Logged to both drivers');


        $log = [
            'User' => ($user = Auth::user()) ? $user->name : 'Not logged in',
            'URI' => $request->getUri(),
            'Method' => $request->getMethod(),
            'Request_body' => $request->getContent(),
            'IP' => $request->getClientIp(),
        ];

        $xPathLog
            ->use('log')
            ->log('warning', 'message', $log);

        $xPathLog
            ->use('cli')
            ->log('warning', 'message', $log);


        $xPathLog
            ->use('json')
            ->transaction('abc-123', 'Transaction started', ['action' => 'checkout']);





//        $this->call('pail'); // php artisan pail


//        $this->comment(config('xpath-log.channel.custom'));

    }
}
