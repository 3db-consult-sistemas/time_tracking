<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Gate;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        foreach ($roles as $role) {
            if (Gate::allows('checkrole', $role)) {
                return $next($request);
            }
        }
        abort(403, 'You do not have permission to do this.');
    }

}
