@extends('layouts.admin_layout')

@section('body')
<section class="content-header">
<div class="container-fluid">
    <h3>Designations</h3>
</div>
</section>

<section class="content">
<div class="container-fluid">
<div class="card">
<div class="card-body">

<a href="{{ route('designations.create') }}" class="btn btn-dark btn-sm mb-3">
    Add Designation
</a>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table id="datatable" class="table table-bordered">
<thead>
<tr>
    <th>#</th>
    <th>Designation Name</th>
    <th>Level</th>
    <th width="120">Action</th>
</tr>
</thead>
<tbody>
@foreach($designations as $designation)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $designation->designation_name }}</td>
    <td>
        <span class="badge bg-info">Level {{ $designation->level }}</span>
    </td>
    <td>
        <a href="{{ route('designations.edit', $designation->id) }}"
           class="btn btn-sm btn-outline-primary">
            <i class="fas fa-edit"></i>
        </a>

        <form action="{{ route('designations.destroy', $designation->id) }}"
              method="POST"
              style="display:inline"
              onsubmit="return confirm('Delete this designation?')">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-outline-danger">
                <i class="fas fa-trash"></i>
            </button>
        </form>
    </td>
</tr>
@endforeach
</tbody>
</table>

</div>
</div>
</div>
</section>
@endsection

@push('script')
<script>
$('#datatable').DataTable();
</script>
@endpush
