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
            if($request->route('user')) {
                $user = $request->route('user');
                $user = isset($user->id)? $user->id : $user;
                $found = User::find($user);
                if($found->isPartOfCompany($company)) {
                    CompanyManager::getInstance()->remember('company', $company);
                    return $next($request);
                }
            } else {
                CompanyManager::getInstance()->remember('company', $company);
                return $next($request);
            }
        }

        return response(["message" => "Not authorized"], 403);
    }
}
