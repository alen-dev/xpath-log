<?php

namespace AlenDev\XpathLog\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RequestLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
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

        Log::channel(xpath_channel_name())->debug('HTTP Request Log', $log);

        return $response;
    }
}
