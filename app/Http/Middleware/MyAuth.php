<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
            throw new NotFoundHttpException("Page not found");
        }
        if($arg === 'boss' && !$user->isBoss()) {
            throw new NotFoundHttpException("Page not found");
        }

        if($arg === 'employee' && !$user->isEmployee()) {
            throw new NotFoundHttpException("Page not found");
        }

        return $next($request);
    }
}