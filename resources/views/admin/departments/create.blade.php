@extends('layouts.admin_layout')

@section('body')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3 class="mb-0">
                    {{ isset($department) ? 'Edit Department' : 'Create Department' }}
                </h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Department</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
<div class="container-fluid">
<div class="card">
<div class="card-body">

{{-- ERROR / SUCCESS --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- FORM START --}}
@if(isset($department))
<form method="POST" action="{{ route('departments.update', $department->id) }}">
@method('PUT')
@else
<form method="POST" action="{{ route('departments.store') }}">
@endif
@csrf

<div class="row">

{{-- CLINIC --}}
<div class="col-md-6 mb-3">
    <label>Clinic <span class="text-danger">*</span></label>
    <select name="clinic_id" class="form-control" required>
        <option value="">Select Clinic</option>
        @foreach($clinics as $clinic)
            <option value="{{ $clinic->id }}"
                {{ (isset($department) && $department->clinic_id == $clinic->id) ? 'selected' : '' }}>
                {{ $clinic->clinic_name }}
            </option>
        @endforeach
    </select>
</div>

{{-- DEPARTMENT NAME --}}
<div class="col-md-6 mb-3">
    <label>Department Name <span class="text-danger">*</span></label>
    <input type="text"
           name="department_name"
           class="form-control"
           required
           value="{{ $department->department_name ?? old('department_name') }}"
           placeholder="Enter department name">
</div>

{{-- DESCRIPTION --}}
<div class="col-md-12 mb-3">
    <label>Description</label>
    <textarea name="description"
              class="form-control"
              rows="4"
              placeholder="Department description">{{ $department->description ?? old('description') }}</textarea>
</div>

{{-- STATUS --}}
<div class="col-md-6 mb-3">
    <label>Status</label>
    <select name="status" class="form-control">
        <option value="1" {{ (isset($department) && $department->status == 1) ? 'selected' : '' }}>Active</option>
        <option value="0" {{ (isset($department) && $department->status == 0) ? 'selected' : '' }}>Inactive</option>
    </select>
</div>

{{-- HIDDEN FIELDS --}}
<input type="hidden" name="is_deleted" value="0">
<input type="hidden" name="created_by" value="{{ auth()->id() }}">
<input type="hidden" name="updated_by" value="{{ auth()->id() }}">

{{-- SUBMIT --}}
<div class="col-md-12 mt-3">
    <button class="btn btn-outline-primary">
        {{ isset($department) ? 'Update Department' : 'Create Department' }}
    </button>

    <a href="{{ route('departments.index') }}" class="btn btn-secondary ml-2">
        Back
    </a>
</div>

</div>
</form>
{{-- FORM END --}}

</div>
</div>
</div>
</section>
@endsection
