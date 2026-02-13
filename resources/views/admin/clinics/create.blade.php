@extends('layouts.admin_layout')

@section('body')
<section class="content-header">
<div class="container-fluid">
<h3>{{ isset($clinic) ? 'Edit Clinic' : 'Create Clinic' }}</h3>
</div>
</section>

<section class="content">
<div class="container-fluid">
<div class="card">
<div class="card-body">

<form method="POST"
      action="{{ isset($clinic) ? route('clinics.update',$clinic->id) : route('clinics.store') }}">
@csrf
@if(isset($clinic)) @method('PUT') @endif

<div class="row">

<div class="col-md-6 mb-3">
    <label>Clinic Name *</label>
    <input class="form-control" name="clinic_name"
           value="{{ $clinic->clinic_name ?? old('clinic_name') }}" required>
</div>

<div class="col-md-6 mb-3">
    <label>Phone *</label>
    <input class="form-control" name="phone"
           value="{{ $clinic->phone ?? old('phone') }}" required>
</div>

<div class="col-md-6 mb-3">
    <label>Email</label>
    <input class="form-control" name="email"
           value="{{ $clinic->email ?? old('email') }}">
</div>

<div class="col-md-6 mb-3">
    <label>Status</label>
    <select class="form-control" name="status">
        <option value="1" {{ isset($clinic)&&$clinic->status==1?'selected':'' }}>Active</option>
        <option value="0" {{ isset($clinic)&&$clinic->status==0?'selected':'' }}>Inactive</option>
    </select>
</div>

<div class="col-md-12 mb-3">
    <label>Address</label>
    <textarea class="form-control" name="address">{{ $clinic->address ?? '' }}</textarea>
</div>

<div class="col-md-4 mb-3">
    <label>City</label>
    <input class="form-control" name="city" value="{{ $clinic->city ?? '' }}">
</div>

<div class="col-md-4 mb-3">
    <label>State</label>
    <input class="form-control" name="state" value="{{ $clinic->state ?? '' }}">
</div>

<div class="col-md-4 mb-3">
    <label>Pincode</label>
    <input class="form-control" name="pincode" value="{{ $clinic->pincode ?? '' }}">
</div>

<input type="hidden" name="is_deleted" value="0">
<input type="hidden" name="created_by" value="{{ auth()->id() }}">
<input type="hidden" name="updated_by" value="{{ auth()->id() }}">

<div class="col-md-12">
    <button class="btn btn-outline-primary">
        {{ isset($clinic) ? 'Update' : 'Create' }}
    </button>
    <a href="{{ route('clinics.index') }}" class="btn btn-secondary">Back</a>
</div>

</div>
</form>

</div>
</div>
</div>
</section>
@endsection
