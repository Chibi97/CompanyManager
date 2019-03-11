<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(session()->has('user')) {
            return redirect()->back();
        }

        return $next($request);
    }
}
