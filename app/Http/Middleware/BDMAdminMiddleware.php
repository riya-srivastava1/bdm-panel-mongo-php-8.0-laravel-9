<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class BDMAdminMiddleware
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
        if (Auth::guard('bdm')->check() && Auth::guard('bdm')->user()->bdm_type !== "standard_user") {
            return $next($request);
        }
        return redirect('/dashboard');
    }
}
