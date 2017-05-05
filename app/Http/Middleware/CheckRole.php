<?php

namespace App\Http\Middleware;

use Closure;

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
        // If the user is not authenticated or doesn't have sufficient permissions, redirect home.
        if (!$request->user() || !$request->user()->hasRole($role)) {
            return redirect(route('login'));
        }

        return $next($request);
    }
}
