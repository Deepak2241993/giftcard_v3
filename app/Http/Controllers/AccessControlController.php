<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class AccessControlController extends Controller
{
    /**
     * View Page
     */
    public function index()
    {
        $roles = Role::all();
        return view('admin.access_control.index', compact('roles'));
    }

    /**
     * OPTIONAL: DataTable (if you want to list roles)
     */
    public function tableData(Request $request)
    {
        $data = Role::latest();

        return DataTables::of($data)
            ->addIndexColumn()

            ->addColumn('permissions_count', function ($row) {
                return RolePermission::where('role_id', $row->id)->count();
            })

            ->addColumn('action', function ($row) {
                return '
                    <button class="btn btn-sm btn-primary" onclick="editRole('.$row->id.')">Manage</button>
                ';
            })

            ->make(true);
    }

    /**
     * GET PERMISSIONS BY ROLE
     */
public function getPermissions($roleId)
{
    $permissions = RolePermission::where('role_id', $roleId)
        ->join('permissions', 'permissions.id', '=', 'role_permissions.permission_id')
        ->pluck('permissions.name');

    return response()->json($permissions);
}

    /**
     * STORE / UPDATE PERMISSIONS
     */

public function storePermissions(Request $request)
{
    $request->validate([
        'role_id' => 'required|exists:roles,id',
    ]);

    $roleId = $request->role_id;

    // delete old
    RolePermission::where('role_id', $roleId)->delete();

    if ($request->permissions) {

        // 🔥 get permission IDs from DB
        $permissionIds = Permission::whereIn('name', $request->permissions)
            ->pluck('id')
            ->toArray();

        $data = [];

        foreach ($permissionIds as $pid) {
            $data[] = [
                'role_id' => $roleId,
                'permission_id' => $pid,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        RolePermission::insert($data);
    }

    return response()->json([
        'status' => true,
        'message' => 'Permissions updated successfully!'
    ]);
}

    /**
     * OPTIONAL: DELETE ALL PERMISSIONS OF ROLE
     */
    public function destroy($roleId)
    {
        RolePermission::where('role_id', $roleId)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Permissions removed successfully!'
        ]);
    }
}