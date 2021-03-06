<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Routing\Route;
use Illuminate\Validation\UnauthorizedException;

class BeforeAction
{
    public function handle($request, Closure $next, $method = "before")
    {
        $route = app()->make(Route::class);
        $controller = $route->getController();

        if(!$controller->{$method}($request)) {
            throw new AuthorizationException("Not authorized for this action");
        }

        return $next($request);
    }
}
