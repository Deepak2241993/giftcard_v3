<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use App\Models\Clinic;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    $employees = Employee::where('is_deleted', 0)
        ->orderBy('id', 'DESC')
        ->get();

    $clinics = Clinic::where('is_deleted', 0)->where('status', 1)->get();
    $departments = Department::where('is_deleted', 0)->where('status', 1)->get();
    $designations = Designation::orderBy('designation_name')->get();

    return view(
        'admin.employees.index',
        compact('employees', 'clinics', 'departments', 'designations')
    );
}


    /**
     * Show the form for creating a new resource.
     */
       public function create()
    {
        return view('admin.employees.create', [
            'clinics'      => Clinic::where('is_deleted', 0)->get(),
            'departments'  => Department::where('is_deleted', 0)->get(),
            'designations' => Designation::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'first_name' => 'required|string|max:100',
        'last_name'  => 'required|string|max:100',
        'email'      => 'required|email|unique:users,email', // ✅ users table
        'phone'      => 'required|string|max:15',
    ]);

    // 1️⃣ Create User
    $user = User::create([
        'name'       => $request->first_name . ' ' . $request->last_name,
        'email'      => $request->email,
        'password'   => Hash::make($request->phone), // default password
        'user_type'  => 2,
        'user_token' => 'FOREVER-MEDSPA',
    ]);

    // 2️⃣ Create Employee (SAFE WAY)
    Employee::create([
        'user_id'        => $user->id,
        'emp_id'         => $request->emp_id,
        'employee_code'  => $request->employee_code,
        'first_name'     => $request->first_name,
        'last_name'      => $request->last_name,
        'email'          => $request->email,
        'phone'          => $request->phone,
        'gender'         => $request->gender,
        'dob'            => $request->dob,
        'address'        => $request->address,
        'city'           => $request->city,
        'state'          => $request->state,
        'zip'            => $request->zip,
        'country'        => $request->country,
        'salary'         => $request->salary,
        'hire_date'      => $request->hire_date,
        'clinic_id'      => $request->clinic_id,
        'department_id'  => $request->department_id,
        'designation_id' => $request->designation_id,
        'employment_type'=> $request->employment_type,
        'status'         => $request->status ?? 1,
        'is_deleted'     => 0,
        'created_by'     => auth()->id(),   // ✅ fixed
        'updated_by'     => auth()->id(),
    ]);

    return redirect()
        ->route('employees.index')
        ->with('success', 'Employee created successfully. Default password is phone number.');
}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $employee = Employee::where('id', $id)
            ->where('is_deleted', 0)
            ->firstOrFail();

        return view('admin.employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit($id)
    {
        return view('admin.employees.create', [
            'employee'     => Employee::where('is_deleted',0)->findOrFail($id),
            'clinics'      => Clinic::where('is_deleted', 0)->get(),
            'departments'  => Department::where('is_deleted', 0)->get(),
            'designations' => Designation::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::where('id', $id)
            ->where('is_deleted', 0)
            ->firstOrFail();

        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => 'nullable|email|unique:employees,email,' . $employee->id,
            'phone'      => 'required|string|max:15',
        ]);

        $employee->update($request->all());
        // $employee->update([
        //     'clinic_id'      => $request->clinic_id,
        //     'first_name'     => $request->first_name,
        //     'last_name'      => $request->last_name,
        //     'email'          => $request->email,
        //     'phone'          => $request->phone,
        //     'designation_id' => $request->designation_id,
        //     'department_id'  => $request->department_id,
        //     'status'         => $request->status,
        // ]);

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified resource from storage (Soft Delete).
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);

        $employee->update([
            'is_deleted' => 1
        ]);

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee deleted successfully.');
    }

    public function trashed()
    {
        $employees = Employee::onlyTrashed()
            ->orderBy('id', 'DESC')
            ->get();

        return view('admin.employees.trashed', compact('employees'));
    }

    public function exportPdf($id)
    {
        $employee = Employee::with([
            'attendance','leaves','salaryHistory','shifts','documents'
        ])->findOrFail($id);

        $pdf = PDF::loadView('admin.employees.pdf', compact('employee'));
        return $pdf->download('employee-profile.pdf');
    }

    
    public function updateRoles(Request $request, Employee $employee)
    {
        $request->validate([
            'roles'   => 'nullable|array',
            'roles.*' => 'exists:employee_roles,id',
        ]);

        // Sync roles (add/remove automatically)
        $employee->roles()->sync($request->roles ?? []);

        return redirect()
            ->route('employees.edit', $employee->id)
            ->with('success', 'Employee roles updated successfully.');
    }

     public function tableData()
        {
            $employees = Employee::where('is_deleted', 0)->latest();
        
            return DataTables::of($employees)
                ->addIndexColumn()
                ->addColumn('employee_name', function ($row) {
                    return $row->first_name . ' ' . $row->last_name;
                })
                ->addColumn('status_badge', function ($row) {
                    return $row->status
                        ? '<span class="badge badge-success">Active</span>'
                        : '<span class="badge badge-danger">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    return '
                <a class="btn btn-sm btn-info mr-1"  href="'.route('employees.edit',$row->id).'" > <i class="fa fa-edit"></i></a>
                    
                        <button class="btn btn-sm btn-danger"
                            onclick="deleteEmployee(' . $row->id . ')">
                            <i class="fa fa-trash"></i>
                        </button>';
                })
                ->rawColumns(['action', 'status_badge'])
                ->make(true);
        }
}
