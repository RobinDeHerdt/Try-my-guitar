<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        // If the user is not authenticated or doesn't have sufficient permissions, redirect to login.
        if (!$request->user() || !$request->user()->hasRole($role)) {
            return redirect(route('login'));
        } else {
            if (!$request->user()->active) {
                Auth::logout();
                return redirect(route('login'));
            }
        }

        return $next($request);
    }
}
