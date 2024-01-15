<?php

namespace App\Http\Middleware;
use Auth;
use Closure;

class CrrdDivHead
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
        if(Auth::user()->jabatan_user->nama_jabatan !== 'Credit Risk Reviewer Division Head'):
            abort(403);
        endif;

        return $next($request);
    }
}
