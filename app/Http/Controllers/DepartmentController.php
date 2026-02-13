<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Clinic;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the departments.
     */
    public function index()
    {
        $departments = Department::where('is_deleted', 0)
            ->orderBy('id', 'DESC')
            ->get();

        return view('admin.departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new department.
     */
   public function create()
{
    $clinics = Clinic::where('is_deleted', 0)
        ->where('status', 1)
        ->orderBy('clinic_name')
        ->get();

    return view('admin.departments.create', compact('clinics'));
}


    /**
     * Store a newly created department.
     */
    public function store(Request $request)
    {
        $request->validate([
            'department_name' => 'required|string|max:255',
            'clinic_id'       => 'required|integer',
            'status'          => 'required|boolean',
        ]);

        Department::create([
            'clinic_id'       => $request->clinic_id,
            'department_name' => $request->department_name,
            'description'     => $request->description,
            'status'          => $request->status,
            'created_by'      => auth()->id(),
            'updated_by'      => auth()->id(),
            'is_deleted'      => 0,
        ]);

        return redirect()
            ->route('departments.index')
            ->with('success', 'Department created successfully.');
    }

    /**
     * Display the specified department.
     */
    public function show(Department $department)
    {
        if ($department->is_deleted) {
            abort(404);
        }

        return view('admin.departments.show', compact('department'));
    }

    /**
     * Show the form for editing the department.
     */
   public function edit(Department $department)
{
    if ($department->is_deleted) {
        abort(404);
    }

    $clinics = Clinic::where('is_deleted', 0)
        ->where('status', 1)
        ->orderBy('clinic_name')
        ->get();

    return view('admin.departments.create', compact('department', 'clinics'));
}


    /**
     * Update the specified department.
     */
    public function update(Request $request, Department $department)
    {
        if ($department->is_deleted) {
            abort(404);
        }

        $request->validate([
            'department_name' => 'required|string|max:255',
            'clinic_id'       => 'required|integer',
            'status'          => 'required|boolean',
        ]);

        $department->update([
            'clinic_id'       => $request->clinic_id,
            'department_name' => $request->department_name,
            'description'     => $request->description,
            'status'          => $request->status,
            'updated_by'      => auth()->id(),
        ]);

        return redirect()
            ->route('departments.index')
            ->with('success', 'Department updated successfully.');
    }

    /**
     * Soft delete the department.
     */
    public function destroy(Department $department)
    {
        $department->update([
            'is_deleted' => 1,
            'updated_by' => auth()->id(),
        ]);

        return redirect()
            ->route('departments.index')
            ->with('success', 'Department deleted successfully.');
    }

    public function bulkAction(Request $request)
    {
        $ids = $request->ids;

        if ($request->action_type === 'delete') {
            Department::whereIn('id', $ids)->update(['is_deleted' => 1]);
        }

        if ($request->action_type === 'active') {
            Department::whereIn('id', $ids)->update(['status' => 1]);
        }

        if ($request->action_type === 'inactive') {
            Department::whereIn('id', $ids)->update(['status' => 0]);
        }

        return response()->json(['message' => 'Action completed successfully']);
    }

}
