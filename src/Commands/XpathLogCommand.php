<?php

namespace AlenDev\XpathLog\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use AlenDev\XpathLog\XpathLog;
use Illuminate\Support\Facades\Auth;

class XpathLogCommand extends Command
{
    public $signature = 'xpath-log';

    public $description = 'My command';

    public function handle(Request $request): void
    {
        $this->comment('Hello xpath!');

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
            ->log('warning', 'message', $log);

        $xPathLog
            ->use('json')
            ->transaction('abc-123', 'Transaction started', ['action' => 'checkout']);
    }
}
