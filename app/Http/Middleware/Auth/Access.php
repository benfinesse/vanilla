<?php

namespace App\Http\Middleware\Auth;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class Access
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
        if(Auth::check()){

            View::share('person', Auth::user());
            View::share('notices', []);
            return $next($request);
        }
        return redirect()->route('login');
    }
}
