<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Route;
use Illuminate\Validation\UnauthorizedException;

class BeforeAction
{
    public function handle($request, Closure $next)
    {
        $route = app()->make(Route::class);
        $controller = $route->getController();

        if(!$controller->before($request)) {
            throw new UnauthorizedException("Not autohrized for this action");
        }

        return $next($request);
    }
}
