<?php

namespace App\Http\Middleware;

use Closure;

class Checkmemberauth
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
        if ($request->session()->has('member_id') == FALSE) return redirect()->route('login'); 
        return $next($request);
    }
}
