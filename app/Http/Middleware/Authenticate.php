<?php

namespace App\Http\Middleware;

use Closure,Request,Route;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            $query = [];
            if( !Route::is('login', 'logout')){
                $query['redirect'] = $request->fullUrl();
            }
            if($request->ajax()){
                prompt('未登录，或登录超时', 'logon_failure', route('login', $query));
            }else{
                return redirect()->route('login', $query);
            }
        }

        return $next($request);
    }
}
