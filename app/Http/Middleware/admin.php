<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class admin  // Changed from 'admin' to 'Admin'
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }
        
        return redirect()->route('home')->with('error', 'Unauthorized access');
    }
}