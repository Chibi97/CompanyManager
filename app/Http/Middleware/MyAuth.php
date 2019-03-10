<?php

namespace App\Http\Middleware;

use Closure;

class MyAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $arg = null)
    {
        if(!$request->session()->has("user")) {
            \Log::alert("User with IP address: " . $request->ip() . " tried to access management panel");
        }

        $user = $request->session()->get("user");

        if(!$user) {
           return redirect()->route('login-form');
        }
        if($arg === 'boss' && !$user->isBoss()) {
            return redirect()->back();
        }

        if($arg === 'employee' && !$user->isEmployee()) {
            return redirect()->back();
        }

        return $next($request);
    }
}
