<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Options;

class LMiddleware
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

        if( url()->current() == 'validate-license' )
            return $next($request);
         
        if( Options::get_option('license_key') )
            return $next($request);
        else
            return redirect('validate-license');

    }
}
