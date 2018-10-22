<?php

namespace App\Http\Middleware;

use Closure;

class IsMobile
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
        if (! isset($_SERVER['HTTP_USER_AGENT'])) {
            return redirect('/mobile');
        }

        if (stristr($_SERVER['HTTP_USER_AGENT'], 'mobi') !== false) {
            return redirect('/mobile');
        }

        return $next($request);
    }
}
