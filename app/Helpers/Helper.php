<?php

use Illuminate\Support\Facades\Auth;
use App\Models\StaticContent;

if (!function_exists('hasPermission')) {
    function hasPermission($permission)
    {
        $user = Auth::user();

        if (!$user || !$user->role) {
            return false;
        }

        if ($user->role_id == 1) {
            return true;
        }

        return $user->role->permissions()
            ->where('name', $permission)
            ->exists();
    }
}

if (!function_exists('getStaticContent')) {
    function getStaticContent($id)
    {
        return StaticContent::find($id);
    }
}


if (!function_exists('roleRoute')) {
    function roleRoute($adminRoute, $employeeRoute = null)
    {
        $user = Auth::user();

        if (!$user) return '#';

        return $user->role_id == 1
            ? route($adminRoute)
            : ($employeeRoute ? route($employeeRoute) : route($adminRoute));
    }
}