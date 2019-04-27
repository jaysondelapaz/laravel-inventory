<?php

namespace App\Http\Middleware\CustomMiddleware;

use Closure;
use Auth; #or use Illuminate\Support\Facades\Auth;
class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(!Auth::check())
        {
            return redirect()->route('Backend.login');
        }
        return $next($request);
    }
}
