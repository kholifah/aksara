<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
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
        //@TODO redirectnya kondisional , ada action / filter supaya bisa dihook sama plugin 
        if (Auth::guard($guard)->check()) {
            return redirect('/admin');
        }

        return $next($request);
    }
}
