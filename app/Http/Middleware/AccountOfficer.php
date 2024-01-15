<?php

namespace App\Http\Middleware;
use Auth;
use Closure;

class AccountOfficer
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
        if(Auth::user()->jabatan_user->nama_jabatan == 'Account Officer'):
            return $next($request);
        endif;

        abort(403);
    }
}
