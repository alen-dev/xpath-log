<?php

namespace AlenDev\XpathLog\Http\Middleware;

use Illuminate\Support\Facades\App;
use AlenDev\XpathLog\XpathLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RequestLogger
{
    /**
     * @param Request $request
     * @param Closure $next
     *
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $log = [
            'User' => ($user = Auth::user()) ? $user->name : 'Not logged in',
            'URI' => $request->getUri(),
            'Method' => $request->getMethod(),
            'Request_body' => $request->getContent(),
            'StatusCode' => $response->getStatusCode(),
            'IP' => $request->getClientIp(),
            'Timestamp' => $response->getDate(),
        ];

        $drivers = config('xpath-log.default_drivers');

//        $xPathLog = new XpathLog();

        $xPathLog = App::make(XpathLog::class); // resolve from container instead of new

        $xPathLog
            ->use($drivers)
            ->log('info', 'message', $log);

        return $response;
    }
}
