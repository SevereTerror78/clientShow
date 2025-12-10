<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->has('api_token')) {
            return redirect('/login');
        }

        return $next($request);
    }
}
