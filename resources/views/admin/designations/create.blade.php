@extends('layouts.admin_layout')

@section('body')
<section class="content-header">
    <div class="container-fluid">
        <h3>{{ isset($designation) ? 'Edit Designation' : 'Create Designation' }}</h3>
    </div>
</section>

<section class="content">
<div class="container-fluid">
<div class="card">
<div class="card-body">

{{-- Validation Errors --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST"
      action="{{ isset($designation)
                ? route('designations.update', $designation->id)
                : route('designations.store') }}">

    @csrf
    @isset($designation)
        @method('PUT')
    @endisset

    <div class="row">

        {{-- Designation Name --}}
        <div class="col-md-6 mb-3">
            <label>Designation Name <span class="text-danger">*</span></label>
            <input type="text"
                   name="designation_name"
                   class="form-control @error('designation_name') is-invalid @enderror"
                   value="{{ old('designation_name', $designation->designation_name ?? '') }}"
                   required>

            @error('designation_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Level --}}
        <div class="col-md-6 mb-3">
            <label>Level <span class="text-danger">*</span></label>
            <input type="number"
                   name="level"
                   min="1"
                   class="form-control @error('level') is-invalid @enderror"
                   value="{{ old('level', $designation->level ?? '') }}"
                   required>

            @error('level')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Buttons --}}
        <div class="col-md-12 mt-2">
            <button type="submit" class="btn btn-outline-primary">
                {{ isset($designation) ? 'Update' : 'Create' }}
            </button>

            <a href="{{ route('designations.index') }}" class="btn btn-secondary">
                Back
            </a>
        </div>

    </div>
</form>

</div>
</div>
</div>
</section>
@endsection
