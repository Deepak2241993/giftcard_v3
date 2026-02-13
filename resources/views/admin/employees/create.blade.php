@extends('layouts.admin_layout')

@section('body')

{{-- ================= HEADER ================= --}}
<section class="content-header">
    <div class="container-fluid">
        <a href="{{ route('employees.export.pdf', $employee->id) }}" class="btn btn-danger btn-sm float-right">
            <i class="fa fa-file-pdf"></i> Export PDF
        </a>
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Employee Profile</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">Employees</a></li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

    </div>

</section>

{{-- ================= MAIN CONTENT ================= --}}
<section class="content">
<div class="container-fluid">
<div class="row">


{{-- ================= LEFT PROFILE CARD ================= --}}
<div class="col-md-3">
    <div class="card card-primary card-outline">
        <div class="card-body box-profile text-center">
            <h3>{{ $employee->first_name }} {{ $employee->last_name }}</h3>
            <p class="text-muted">
                {{ $employee->designation->name ?? 'Employee' }}
            </p>

            <hr>

            <strong><i class="fas fa-envelope"></i> Email</strong>
            <p class="text-muted">{{ $employee->email }}</p>

            <strong><i class="fas fa-phone"></i> Phone</strong>
            <p class="text-muted">{{ $employee->phone }}</p>

            <strong><i class="fas fa-map-marker-alt"></i> Address</strong>
            <p class="text-muted">
                {{ $employee->address }}<br>
                {{ $employee->city }}, {{ $employee->state }} - {{ $employee->zip }}<br>
                {{ $employee->country }}
            </p>
        </div>
    </div>
</div>

{{-- ================= RIGHT CONTENT ================= --}}
<div class="col-md-9">
<div class="card">
<div class="card-header p-2">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#profile">Profile</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#attendance">Attendance</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#shifts">Shifts</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#leaves">Leaves</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#salary">Salary History</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#documents">Documents</a></li>
        
    </ul>
</div>

<div class="card-body">
<div class="tab-content">

{{-- ================= PROFILE UPDATE ================= --}}
<div class="active tab-pane" id="profile">
<form method="POST" action="{{ route('employees.update', $employee->id) }}">
@csrf
@method('PUT')

<div class="row">

{{-- Employee ID --}}
<div class="col-md-6">
    <label>Employee ID</label>
    <input class="form-control" name="emp_id"
           value="{{ old('emp_id', $employee->emp_id) }}">
</div>

{{-- Employee Code --}}
<div class="col-md-6">
    <label>Employee Code</label>
    <input class="form-control" name="employee_code"
           value="{{ old('employee_code', $employee->employee_code) }}">
</div>

{{-- First Name --}}
<div class="col-md-6 mt-2">
    <label>First Name <span class="text-danger">*</span></label>
    <input class="form-control" name="first_name"
           value="{{ old('first_name', $employee->first_name) }}" required>
</div>

{{-- Last Name --}}
<div class="col-md-6 mt-2">
    <label>Last Name <span class="text-danger">*</span></label>
    <input class="form-control" name="last_name"
           value="{{ old('last_name', $employee->last_name) }}" required>
</div>

{{-- Email --}}
<div class="col-md-6 mt-2">
    <label>Email</label>
    <input class="form-control" type="email" name="email"
           value="{{ old('email', $employee->email) }}">
</div>

{{-- Phone --}}
<div class="col-md-6 mt-2">
    <label>Phone <span class="text-danger">*</span></label>
    <input class="form-control" name="phone"
           value="{{ old('phone', $employee->phone) }}" required>
</div>

{{-- Gender --}}
<div class="col-md-6 mt-2">
    <label>Gender</label>
    <select class="form-control" name="gender">
        <option value="">Select</option>
        <option value="male"   {{ old('gender',$employee->gender)=='male'?'selected':'' }}>Male</option>
        <option value="female" {{ old('gender',$employee->gender)=='female'?'selected':'' }}>Female</option>
        <option value="other"  {{ old('gender',$employee->gender)=='other'?'selected':'' }}>Other</option>
    </select>
</div>

{{-- DOB --}}
<div class="col-md-6 mt-2">
    <label>Date of Birth</label>
    <input type="date" class="form-control" name="dob"
           value="{{ old('dob', $employee->dob) }}">
</div>

{{-- Address --}}
<div class="col-md-12 mt-2">
    <label>Address</label>
    <textarea class="form-control" name="address">{{ old('address',$employee->address) }}</textarea>
</div>

{{-- City --}}
<div class="col-md-4 mt-2">
    <label>City</label>
    <input class="form-control" name="city"
           value="{{ old('city',$employee->city) }}">
</div>

{{-- State --}}
<div class="col-md-4 mt-2">
    <label>State</label>
    <input class="form-control" name="state"
           value="{{ old('state',$employee->state) }}">
</div>

{{-- Zip --}}
<div class="col-md-4 mt-2">
    <label>Zip</label>
    <input class="form-control" name="zip"
           value="{{ old('zip',$employee->zip) }}">
</div>

{{-- Country --}}
<div class="col-md-6 mt-2">
    <label>Country</label>
    <input class="form-control" name="country"
           value="{{ old('country',$employee->country) }}">
</div>

{{-- Salary --}}
<div class="col-md-6 mt-2">
    <label>Salary</label>
    <input type="number" class="form-control" name="salary"
           value="{{ old('salary',$employee->salary) }}">
</div>

{{-- Hire Date --}}
<div class="col-md-6 mt-2">
    <label>Hire Date</label>
    <input type="date" class="form-control" name="hire_date"
           value="{{ old('hire_date',$employee->hire_date) }}">
</div>

{{-- Employment Type --}}
<div class="col-md-6 mt-2">
    <label>Employment Type</label>
    <select class="form-control" name="employment_type">
        <option value="full_time" {{ old('employment_type',$employee->employment_type)=='full_time'?'selected':'' }}>Full Time</option>
        <option value="part_time" {{ old('employment_type',$employee->employment_type)=='part_time'?'selected':'' }}>Part Time</option>
        <option value="contract"  {{ old('employment_type',$employee->employment_type)=='contract'?'selected':'' }}>Contract</option>
    </select>
</div>

{{-- Clinic --}}
<div class="col-md-6 mt-2">
    <label>Clinic <span class="text-danger">*</span></label>
    <select class="form-control" name="clinic_id" required>
        <option value="">Select Clinic</option>
        @foreach($clinics as $clinic)
            <option value="{{ $clinic->id }}"
                {{ old('clinic_id',$employee->clinic_id)==$clinic->id?'selected':'' }}>
                {{ $clinic->clinic_name }}
            </option>
        @endforeach
    </select>
</div>

{{-- Department --}}
<div class="col-md-6 mt-2">
    <label>Department <span class="text-danger">*</span></label>
    <select class="form-control" name="department_id" required>
        <option value="">Select Department</option>
        @foreach($departments as $department)
            <option value="{{ $department->id }}"
                {{ old('department_id',$employee->department_id)==$department->id?'selected':'' }}>
                {{ $department->department_name }}
            </option>
        @endforeach
    </select>
</div>

{{-- Designation --}}
<div class="col-md-6 mt-2">
    <label>Designation <span class="text-danger">*</span></label>
    <select class="form-control" name="designation_id" required>
        <option value="">Select Designation</option>
        @foreach($designations as $designation)
            <option value="{{ $designation->id }}"
                {{ old('designation_id',$employee->designation_id)==$designation->id?'selected':'' }}>
                {{ $designation->designation_name }}
            </option>
        @endforeach
    </select>
</div>

{{-- Status --}}
<div class="col-md-6 mt-2">
    <label>Status</label>
    <select class="form-control" name="status">
        <option value="1" {{ old('status',$employee->status)==1?'selected':'' }}>Active</option>
        <option value="0" {{ old('status',$employee->status)==0?'selected':'' }}>Inactive</option>
    </select>
</div>

{{-- Submit --}}
<div class="col-md-12 mt-3">
    <button class="btn btn-info">
        <i class="fa fa-save"></i> Update Employee
    </button>
    <a href="{{ route('employees.index') }}" class="btn btn-secondary">
        Back
    </a>
</div>

</div>
</form>

</div>

{{-- ================= ATTENDANCE ================= --}}
<div class="tab-pane" id="attendance">
<table class="table table-bordered">
<tr><th>Date</th><th>Check In</th><th>Check Out</th><th>Status</th></tr>
@foreach($employee->attendance as $a)
<tr>
<td>{{ $a->attendance_date }}</td>
<td>{{ $a->check_in }}</td>
<td>{{ $a->check_out }}</td>
<td>{{ ucfirst($a->status) }}</td>
</tr>
@endforeach
</table>
</div>

{{-- ================= SHIFTS ================= --}}
<div class="tab-pane" id="shifts">
<table class="table table-bordered">
<tr><th>Date</th><th>Start</th><th>End</th></tr>
@foreach($employee->shifts as $s)
<tr>
<td>{{ $s->shift_date }}</td>
<td>{{ $s->shift_start }}</td>
<td>{{ $s->shift_end }}</td>
</tr>
@endforeach
</table>
</div>

{{-- ================= LEAVES ================= --}}
<div class="tab-pane" id="leaves">

    <button class="btn btn-sm btn-primary mb-2" data-toggle="modal" data-target="#addLeaveModal">+ Add Leav</button>

<table class="table table-bordered">
<tr><th>Type</th><th>From</th><th>To</th><th>Status</th></tr>
@foreach($employee->leaves as $l)
<tr>
<td>{{ $l->leave_type }}</td>
<td>{{ $l->from_date }}</td>
<td>{{ $l->to_date }}</td>
<td>{{ ucfirst($l->approval_status) }}</td>
</tr>
@endforeach
</table>

{{-- Add Leave --}}
<div class="modal fade" id="addLeaveModal">
    <div class="modal-dialog">
        {{-- <form method="POST" action="{{ route('employee.leaves.store') }}"> --}}
            @csrf
            <input type="hidden" name="employee_id" value="{{ $employee->id }}">

            <div class="modal-content">
                <div class="modal-header">
                    <h5>Add Leave</h5>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <label>Leave Type</label>
                    <select class="form-control mb-2" name="leave_type">
                        <option>Sick</option>
                        <option>Casual</option>
                        <option>Paid</option>
                    </select>

                    <label>From Date</label>
                    <input type="date" class="form-control mb-2" name="from_date">

                    <label>To Date</label>
                    <input type="date" class="form-control mb-2" name="to_date">

                    <label>Reason</label>
                    <textarea class="form-control" name="reason"></textarea>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

</div>

{{-- ================= SALARY HISTORY ================= --}}
<div class="tab-pane" id="salary">
    
    <button class="btn btn-sm btn-success mb-2" data-toggle="modal" data-target="#addSalaryModal">+ Add Salary</button>
<table class="table table-bordered">
<tr><th>Salary</th><th>Effective From</th></tr>
@foreach($employee->salaryHistory as $s)
<tr>
<td>{{ $s->salary }}</td>
<td>{{ $s->effective_from }}</td>
</tr>
@endforeach
</table>
{{-- Add Salary Model --}}
<div class="modal fade" id="addSalaryModal">
    <div class="modal-dialog">
        {{-- <form method="POST" action="{{ route('employee.salary.store') }}"> --}}
            @csrf
            <input type="hidden" name="employee_id" value="{{ $employee->id }}">

            <div class="modal-content">
                <div class="modal-header">
                    <h5>Add Salary</h5>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <label>Salary</label>
                    <input type="number" class="form-control mb-2" name="salary">

                    <label>Effective From</label>
                    <input type="date" class="form-control" name="effective_from">
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

</div>

{{-- ================= DOCUMENTS ================= --}}
<div class="tab-pane" id="documents">
<table class="table table-bordered">
<tr><th>Type</th><th>File</th></tr>
@foreach($employee->documents as $d)
<tr>
<td>{{ $d->document_type }}</td>
<td><a href="{{ asset($d->file_path) }}" target="_blank">View</a></td>
</tr>
@endforeach
</table>
</div>

</div>
</div>
</div>
</div>

</div>
</section>

@endsection
