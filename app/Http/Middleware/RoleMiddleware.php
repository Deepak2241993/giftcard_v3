<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($role === 'admin' && $user->user_type != 1) {
            abort(403);
        }

        if ($role === 'employee' && $user->user_type != 2) {
            abort(403);
        }

        return $next($request);
    }
}
