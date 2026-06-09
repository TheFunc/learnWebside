<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LearnAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('learn_user_id')) {
            return redirect()->route('learn.login');
        }

        return $next($request);
    }
}
