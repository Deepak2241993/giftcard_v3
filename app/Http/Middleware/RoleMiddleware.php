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

        if ($role === 'admin' && $user->role_id != 1) {
            abort(403);
        }

        if ($role === 'employee' && $user->role_id != 2) {
            abort(403);
        }

        return $next($request);
    }
}
