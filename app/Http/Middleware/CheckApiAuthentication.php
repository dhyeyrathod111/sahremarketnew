<?php

namespace App\Http\Middleware;

use Closure;

class CheckApiAuthentication
{
    protected $response = array();
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->header('X-API-SECRET') != hash('sha256','9967313968')) {
            $this->response['status'] = FALSE;
            $this->response['message'] = "Application secret key is not valid.";
            return \Response::json($this->response, 200);
        } else {
            return $next($request);
        } 
        // return $next($request);
    }
}
