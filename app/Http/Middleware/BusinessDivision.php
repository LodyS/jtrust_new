<?php

namespace App\Http\Middleware;
use Auth;
use Closure;

class BusinessDivision
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
        if(Auth::user()->divisi == 'Business Division'):
            return $next($request);
        endif;

        return abort(403);
    }
}
