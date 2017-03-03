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
    public function handle($request, Closure $next)
    {
        if ($request->user() && $request->is('admin/*') && !$request->is('admin/logout') && $request->user()->account_type != 'ADMIN') {
            return redirect()->route('homepage');
        }
        return $next($request);
    }
}
