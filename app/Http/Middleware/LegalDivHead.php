<?php

namespace App\Http\Middleware;
use Auth;
use Closure;

class LegalDivHead
{
    public function handle($request, Closure $next)
    {
        if(Auth::user()->jabatan_user->nama_jabatan == 'Legal Division Head'):
            return $next($request);
        endif;

        abort(403);
    }
}
