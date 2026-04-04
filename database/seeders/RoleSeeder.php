<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\RolePermission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // ✅ Create Super Admin role (if not exists)
        $role = Role::updateOrCreate(
            ['name' => 'Super Admin'],
            ['created_at' => now(), 'updated_at' => now()]
        );

        // ✅ Get all permissions
        $permissions = Permission::pluck('id')->toArray();

        // ❌ Remove old permissions (safe reset)
        RolePermission::where('role_id', $role->id)->delete();

        // ✅ Assign all permissions
        $data = [];

        foreach ($permissions as $pid) {
            $data[] = [
                'role_id' => $role->id,
                'permission_id' => $pid,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        RolePermission::insert($data);
    }
}