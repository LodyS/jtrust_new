<?php

namespace App\Http\Middleware;
use Auth;
use Closure;
use DB;

class UserWorkflow
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
        $status = DB::table('setting_flows')->where('jabatan_id', Auth::user()->jabatan)->value('jabatan_id');

        if($status):
            return $next($request);
        endif;

        abort(403);
    }
}
