<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if ($user && ($user->role == 'user' || $user->role == 'admin')) {
            return $next($request);
        }

        return redirect()->route('home');
    }
}
