<?php

namespace App\Http\Middleware\Auth;

use App\Models\Notice;
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

            $user = Auth::user();
            $notice = Notice::where('user_id', $user->uuid)->where('seen', false)->select(['title','url','user_id','created_at'])->get();
            View::share('person', $user);
            View::share('notices', $notice);
            return $next($request);
        }
        return redirect()->route('login');
    }
}
