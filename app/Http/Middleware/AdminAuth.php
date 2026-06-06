<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('admin_id') || !Session::get('is_admin')) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
