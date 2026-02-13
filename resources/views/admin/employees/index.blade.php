@extends('layouts.admin_layout')
@section('body')

<div class="container-fluid">
    <h3 class="mb-3">All Employees</h3>

    <button class="btn btn-secondary mb-3" data-toggle="modal" data-target="#createEmployee">
        Create Employee
    </button>

    <table id="datatable-buttons" class="table table-hover modern-table">
        <thead>
        <tr>
            <th>#</th>
            <th>Action</th>
            <th>Employee</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Status</th>
        </tr>
        </thead>
    </table>
</div>

{{-- CREATE EMPLOYEE MODAL --}}
<div class="modal fade" id="createEmployee">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Create Employee</h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form id="employeeForm">
@csrf
<div class="row">

{{-- Employee ID --}}
<div class="col-md-6 mb-2">
    <label>Employee ID</label>
    <input class="form-control" name="emp_id">
</div>

{{-- Employee Code --}}
<div class="col-md-6 mb-2">
    <label>Employee Code</label>
    <input class="form-control" name="employee_code">
</div>

{{-- First Name --}}
<div class="col-md-6 mb-2">
    <label>First Name <span class="text-danger">*</span></label>
    <input class="form-control" name="first_name" required>
    <small class="text-danger" id="error-first_name"></small>
</div>

{{-- Last Name --}}
<div class="col-md-6 mb-2">
    <label>Last Name <span class="text-danger">*</span></label>
    <input class="form-control" name="last_name" required>
    <small class="text-danger" id="error-last_name"></small>
</div>

{{-- Email --}}
<div class="col-md-6 mb-2">
    <label>Email</label>
    <input class="form-control" type="email" name="email">
    <small class="text-danger" id="error-email"></small>
</div>

{{-- Phone --}}
<div class="col-md-6 mb-2">
    <label>Phone <span class="text-danger">*</span></label>
    <input class="form-control" name="phone" required>
    <small class="text-danger" id="error-phone"></small>
</div>

{{-- Gender --}}
<div class="col-md-6 mb-2">
    <label>Gender</label>
    <select class="form-control" name="gender">
        <option value="">Select</option>
        <option value="male">Male</option>
        <option value="female">Female</option>
        <option value="other">Other</option>
    </select>
</div>

{{-- DOB --}}
<div class="col-md-6 mb-2">
    <label>Date of Birth</label>
    <input class="form-control" type="date" name="dob">
</div>

{{-- Address --}}
<div class="col-md-12 mb-2">
    <label>Address</label>
    <textarea class="form-control" name="address"></textarea>
</div>

{{-- City --}}
<div class="col-md-4 mb-2">
    <label>City</label>
    <input class="form-control" name="city">
</div>

{{-- State --}}
<div class="col-md-4 mb-2">
    <label>State</label>
    <input class="form-control" name="state">
</div>

{{-- Zip --}}
<div class="col-md-4 mb-2">
    <label>Zip</label>
    <input class="form-control" name="zip">
</div>

{{-- Country --}}
<div class="col-md-6 mb-2">
    <label>Country</label>
    <input class="form-control" name="country">
</div>

{{-- Salary --}}
<div class="col-md-6 mb-2">
    <label>Salary</label>
    <input class="form-control" type="number" name="salary">
</div>

{{-- Hire Date --}}
<div class="col-md-6 mb-2">
    <label>Hire Date</label>
    <input class="form-control" type="date" name="hire_date">
</div>

{{-- Employment Type --}}
<div class="col-md-6 mb-2">
    <label>Employment Type</label>
    <select class="form-control" name="employment_type">
        <option value="">Select</option>
        <option value="full_time">Full Time</option>
        <option value="part_time">Part Time</option>
        <option value="contract">Contract</option>
    </select>
</div>

{{-- Clinic --}}
<div class="col-md-6 mb-2">
    <label>Clinic <span class="text-danger">*</span></label>
    <select class="form-control" name="clinic_id" required>
        <option value="">Select Clinic</option>
        @foreach($clinics as $clinic)
            <option value="{{ $clinic->id }}">{{ $clinic->clinic_name }}</option>
        @endforeach
    </select>
    <small class="text-danger" id="error-clinic_id"></small>
</div>

{{-- Department --}}
<div class="col-md-6 mb-2">
    <label>Department <span class="text-danger">*</span></label>
    <select class="form-control" name="department_id" required>
        <option value="">Select Department</option>
        @foreach($departments as $department)
            <option value="{{ $department->id }}">{{ $department->department_name }}</option>
        @endforeach
    </select>
    <small class="text-danger" id="error-department_id"></small>
</div>

{{-- Designation --}}
<div class="col-md-6 mb-2">
    <label>Designation <span class="text-danger">*</span></label>
    <select class="form-control" name="designation_id" required>
        <option value="">Select Designation</option>
        @foreach($designations as $designation)
            <option value="{{ $designation->id }}">{{ $designation->designation_name }}</option>
        @endforeach
    </select>
    <small class="text-danger" id="error-designation_id"></small>
</div>

{{-- Status --}}
<div class="col-md-6 mb-2">
    <label>Status</label>
    <select class="form-control" name="status">
        <option value="1">Active</option>
        <option value="0">Inactive</option>
    </select>
</div>

{{-- Submit --}}
<div class="col-md-12 mt-3">
    <button type="button"
            class="btn btn-outline-primary"
            onclick="createEmployee()">
        Submit
    </button>
</div>

</div>
</form>


            </div>

        </div>
    </div>
</div>

@endsection

@push('script')
<script>
function createEmployee() {
    let formData = new FormData(document.getElementById('employeeForm'));
    $('.text-danger').text('');

    $.ajax({
        url: "{{ route('employees.store') }}",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
        success: function () {
            $('#createEmployee').modal('hide');
            $('#datatable-buttons').DataTable().ajax.reload();
        },
        error: function (xhr) {
            $.each(xhr.responseJSON.errors, function (key, val) {
                $('#error-' + key).text(val[0]);
            });
        }
    });
}

function deleteEmployee(id) {

    if (!confirm('Delete this employee?')) return;

    $.ajax({
        url: "{{ url('admin/employees') }}/" + id,
        method: "DELETE",
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
        success: function () {
            $('#datatable-buttons').DataTable().ajax.reload();
        }
    });
}

//  For Update Employee


$(function () {
    $('#datatable-buttons').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('employees.table.data') }}",
        columns: [
            {data: 'DT_RowIndex', orderable: false},
            {data: 'action', orderable: false},
            {data: 'employee_name'},
            {data: 'email'},
            {data: 'phone'},
            {data: 'status_badge', orderable: false}
        ]
    });
});
</script>
@endpush
