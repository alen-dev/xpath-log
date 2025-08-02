<?php

namespace AlenDev\XpathLog\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use AlenDev\XpathLog\XpathLog;
use Illuminate\Support\Facades\Auth;

class XpathLogCommand extends Command
{
    public $signature = 'xpathlog:create-sample';

    public $description = 'Creates some dummy log entries in order to have some data to display';

    public function handle(Request $request): void
    {
        $this->comment('Hello Xpath!');

        $log = [
            'User' => ($user = Auth::user()) ? $user->name : 'Not logged in',
            'URI' => $request->getUri(),
            'Method' => $request->getMethod(),
            'Request_body' => $request->getContent(),
            'IP' => $request->getClientIp(),
        ];

        $xPathLog = new XpathLog();
        $xPathLog
            ->use('log')
            ->log('warning', 'message', $log);

        $xPathLog
            ->use('cli')
            ->log('warning', 'message', ['test' => '34234']);

        $xPathLog
            ->use('json')
            ->transaction('abc-123', 'Transaction started', ['action' => 'checkout']);

        $xPathLog
            ->use('json')
            ->startTransaction('TX-789', ['customerId' => 123]);
        $xPathLog
            ->use('json')
            ->endTransaction('TX-789', ['status' => 'success']);

        $this->comment('Dummy data created! You can check the log entries with "php artisan xpathlog:view"');
    }
}
