<?php

namespace App\Http\Middleware;

use Closure;
use App\Libs\Ping;

class PingEtmApi
{
    public function handle($request, Closure $next, $guard = null)
    {
        /*$ping = new Ping();
        
        $response = $ping->call();
        
        if (isset($response['error']) && $response['error'] == true) {
            return response(
                view('main.ping_error', [
                    'title'   => 'E-tickets'
                ])
            );
        }*/

        return $next($request);
    }
}