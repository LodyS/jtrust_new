<?php

namespace App\Http\Middleware;
use Auth;
use Closure;

class AmlDepartemenHead
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
        if(Auth::user()->jabatan_user->nama_jabatan == 'AML & CFT Departemen Head'):
            return $next($request);
        endif;

        abort(403);
    }
}
