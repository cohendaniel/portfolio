<?php

namespace Timetable\Http\Middleware;

use Closure;
use Auth;

class AuthUser
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
        if (Auth::guard('timetable')->check()) {
            return $next($request);
        }

        return redirect('/timetable');
    }
}
