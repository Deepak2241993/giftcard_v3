<?php

use Illuminate\Support\Facades\Auth;
use App\Models\StaticContent;

if (!function_exists('hasPermission')) {
    function hasPermission($permission)
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        // Super Admin full access
        if ($user->role_id == 1) {
            return true;
        }

        return $user->role && $user->role->permissions
            ->contains('name', $permission);
    }
}

if (!function_exists('getStaticContent')) {
    function getStaticContent($id)
    {
        return StaticContent::find($id);
    }
}