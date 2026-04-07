<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\RolePermission;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle($request, Closure $next, $permission)
{
    $user = auth()->user();

    if (!$user) {
        abort(403);
    }

    // ✅ Super Admin bypass
    if ($user->role_id == 1) {
        return $next($request);
    }

    // ✅ Use model method (IMPORTANT)
    if (!$user->hasPermission($permission)) {
        abort(403, 'No permission');
    }

    return $next($request);
}
}