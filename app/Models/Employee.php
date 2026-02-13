<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';

    protected $fillable = [
        'emp_id', 'first_name', 'last_name', 'email', 'phone','gender','dob', 'address', 'city', 'state', 'zip', 'country', 'salary', 'hire_date', 'clinic_id','designation_id', 'department_id','employment_type','employee_code','status','created_at','updated_at','is_deleted','created_by','updated_by'
    ];


     public function clinic() {
        return $this->belongsTo(Clinic::class);
    }

    public function department() {
        return $this->belongsTo(Department::class);
    }

    public function designation() {
        return $this->belongsTo(Designation::class);
    }

    public function leaves() {
        return $this->hasMany(EmployeeLeave::class);
    }

    public function salaryHistory() {
        return $this->hasMany(EmployeeSalaryHistory::class);
    }

    public function shifts() {
        return $this->hasMany(EmployeeShift::class);
    }

    public function attendance() {
        return $this->hasMany(EmployeeAttendance::class);
    }

    public function documents() {
        return $this->hasMany(EmployeeDocument::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}
