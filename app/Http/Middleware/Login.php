<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class Login
{
    /**
     * Обрабатывает входящий запрос
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($user = Auth::user()) {
            View::share('currentUser', $user);
            return $next($request);
        } else {
            View::share('currentUser', null);
            return redirect()->route('login');
        }
    }
}
