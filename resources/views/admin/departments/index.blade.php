@extends('layouts.admin_layout')

@section('body')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3 class="mb-0">Departments</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Departments</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
<div class="container-fluid">
<div class="card">
<div class="card-body">

{{-- ACTION BUTTONS --}}
<div class="mb-3">
    <button id="bulk_active" class="btn btn-success btn-sm">Mark Active</button>
    <button id="bulk_inactive" class="btn btn-warning btn-sm">Mark Inactive</button>
    <button id="bulk_delete" class="btn btn-danger btn-sm">Delete Selected</button>
    <a href="{{ route('departments.create') }}" class="btn btn-dark btn-sm">Add Department</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table id="datatable-buttons" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th><input type="checkbox" id="select_all"></th>
            <th>#</th>
            <th>Department Name</th>
            <th>Description</th>
            <th>Status</th>
            <th width="120">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($departments as $department)
        <tr>
            <td>
                <input type="checkbox" class="dept_checkbox" value="{{ $department->id }}">
            </td>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $department->department_name }}</td>
            <td>{{ $department->description ?? '—' }}</td>
            <td>
                {!! $department->status
                    ? "<span class='badge bg-success'>Active</span>"
                    : "<span class='badge bg-danger'>Inactive</span>" !!}
            </td>
            <td class="text-nowrap">
                <a href="{{ route('departments.edit', $department->id) }}"
                   class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-edit"></i>
                </a>

                <form action="{{ route('departments.destroy', $department->id) }}"
                      method="POST"
                      style="display:inline;"
                      onsubmit="return confirm('Are you sure?')">
                    @csrf
                    @method('DELETE')
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

{{-- DATATABLE --}}
<script>
$(function () {
    $("#datatable-buttons").DataTable({
        responsive: true,
        lengthChange: true,
        autoWidth: false,
        buttons: ["copy", "csv", "excel", "pdf", "print"]
    }).buttons().container()
      .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
});
</script>

{{-- BULK ACTION SCRIPT --}}
<script>
// SELECT ALL
$('#select_all').on('click', function () {
    $('.dept_checkbox').prop('checked', this.checked);
});

// GET SELECTED IDS
function getSelectedIDs() {
    let ids = [];
    $('.dept_checkbox:checked').each(function () {
        ids.push($(this).val());
    });
    return ids;
}

// BULK DELETE
$('#bulk_delete').on('click', function () {
    let ids = getSelectedIDs();
    if (ids.length === 0) return alert('Select at least one department');

    if (!confirm('Delete selected departments?')) return;

    bulkAction('delete', ids);
});

// BULK ACTIVE
$('#bulk_active').on('click', function () {
    let ids = getSelectedIDs();
    if (ids.length === 0) return alert('Select at least one department');
    bulkAction('active', ids);
});

// BULK INACTIVE
$('#bulk_inactive').on('click', function () {
    let ids = getSelectedIDs();
    if (ids.length === 0) return alert('Select at least one department');
    bulkAction('inactive', ids);
});

// AJAX BULK ACTION
function bulkAction(type, ids) {
    $.ajax({
        url: "{{ route('departments.bulk.action') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            action_type: type,
            ids: ids
        },
        success: function (response) {
            alert(response.message);
            location.reload();
        }
    });
}
</script>

@endpush
