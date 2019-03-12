<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Route;

class BeforeAction
{
    public function handle($request, Closure $next)
    {
        $route = app()->make(Route::class);
        $controller = get_class($route->getController());
        if(!call_user_func("$controller::before", $request)) {
            return response(["message" => "Not authorized"], 403);
        }

        return $next($request);
    }
}
