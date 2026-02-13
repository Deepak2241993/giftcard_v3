@extends('layouts.admin_layout')

@section('body')
<section class="content-header">
<div class="container-fluid">
<div class="row mb-2">
    <div class="col-sm-6"><h3>Clinics</h3></div>
</div>
</div>
</section>

<section class="content">
<div class="container-fluid">
<div class="card">
<div class="card-body">

<div class="mb-3">
    <button id="bulk_active" class="btn btn-success btn-sm">Mark Active</button>
    <button id="bulk_inactive" class="btn btn-warning btn-sm">Mark Inactive</button>
    <button id="bulk_delete" class="btn btn-danger btn-sm">Delete</button>
    <a href="{{ route('clinics.create') }}" class="btn btn-dark btn-sm">Add Clinic</a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table id="datatable-buttons" class="table table-bordered">
<thead>
<tr>
    <th><input type="checkbox" id="select_all"></th>
    <th>#</th>
    <th>Clinic Name</th>
    <th>Phone</th>
    <th>Email</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>
<tbody>
@foreach($clinics as $clinic)
<tr>
    <td><input type="checkbox" class="clinic_checkbox" value="{{ $clinic->id }}"></td>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $clinic->clinic_name }}</td>
    <td>{{ $clinic->phone }}</td>
    <td>{{ $clinic->email ?? '—' }}</td>
    <td>
        {!! $clinic->status
            ? "<span class='badge bg-success'>Active</span>"
            : "<span class='badge bg-danger'>Inactive</span>" !!}
    </td>
    <td>
        <a href="{{ route('clinics.edit', $clinic->id) }}" class="btn btn-sm btn-outline-primary">
            <i class="fas fa-edit"></i>
        </a>
        <form method="POST" action="{{ route('clinics.destroy', $clinic->id) }}"
              style="display:inline" onsubmit="return confirm('Are you sure?')">
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
$('#select_all').on('click', function(){
    $('.clinic_checkbox').prop('checked', this.checked);
});

function getIds(){
    let ids=[];
    $('.clinic_checkbox:checked').each(function(){ ids.push($(this).val()); });
    return ids;
}

function bulkAction(type){
    let ids = getIds();
    if(ids.length === 0) return alert('Select at least one clinic');

    $.post("{{ route('clinics.bulk.action') }}", {
        _token:"{{ csrf_token() }}",
        action_type:type,
        ids:ids
    }, function(){
        location.reload();
    });
}

$('#bulk_active').click(()=>bulkAction('active'));
$('#bulk_inactive').click(()=>bulkAction('inactive'));
$('#bulk_delete').click(()=>bulkAction('delete'));
</script>
@endpush
