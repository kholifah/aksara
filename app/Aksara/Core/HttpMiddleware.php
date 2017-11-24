<?php
namespace App\Aksara\Core;
use Closure;

class HttpMiddleware
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
        \Eventy::action('aksara.http-middleware', $request, $next, $guard);
        return $next($request);
    }
}
