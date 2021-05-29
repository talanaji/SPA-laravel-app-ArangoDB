<?php

namespace App\Http\Middleware;

use Closure;
use Config;
use Illuminate\Http\Request;

class ApiAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('app_token');
        if ($token != Config::get('app.app_token')) {
            return response()->json(['message' => 'App Key not found'], 401);
        }
        return $next($request);
    }
}
