<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ValidateUsers
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
        if (Auth::guard('bdm')->check()) {
            return $next($request);
        }
        
        // session()->flush();
        return redirect('/login?paramssss=099')->with('error', 'please login first');
    }
}
