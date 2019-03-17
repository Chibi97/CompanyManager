<?php

namespace App\Http\Middleware;

use App\Http\Helpers\CompanyManager;
use App\Models\Company;
use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckApiToken
{
    /**
     * Handle an incoming request.a
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $requestToken = $request->header('Authorization');
        $company = Company::where('api_token', $requestToken)->first();

        if($company) {
            CompanyManager::getInstance()->remember('company', $company);
            return $next($request);
        }

        return response(["message" => "Bad API token"], 403);
    }
}
