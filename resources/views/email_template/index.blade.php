@extends('layouts.admin_layout')
@section('body')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h3 class="mb-0">Email Template</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Email Template
                        </li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<main class="app-main">

    <!--begin::App Content-->
    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <a href="{{ route('email-template.create') }}"  class="btn btn-block btn-outline-primary">Add More</a>
            <form class="mt-2" method="get" action="{{ route('ServicesSearch') }}">
                @csrf
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="Email Name">Template Name:</label>
                        <input type="text" class="form-control" id="Email Name" name="Email Name"
                            placeholder="Template Name">
                    </div>

                    <div class="col-md-1">
                        <input type="hidden" name="user_token" value="{{ Auth::user()->user_token }}">
                        <button type="submit"  class="btn btn-block btn-outline-success mt-4">Search</button>
                    </div>
                </div>
            </form>
            <div class="card-header">
                @if(session()->has('error'))
                    {{ session()->get('error') }}
                @endif
                @if(session()->has('success'))
                    {{ session()->get('success') }}
                @endif
            </div>
            <table id="datatable-buttons" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#">#</th>
                        <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title">Title</th>
                        <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Image">Image</th>
                        <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Message">Message</th>
                        <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Status">Status</th>
                        <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Action">Action</th>

                    </tr>
                </thead>


                <tbody>
                    @foreach($data as $key => $value)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $value->title }}</td>
                            <td>
                                @if(!empty($value->image))
                                    <image src="{{ $value->image }}" height="100px" width="100px">
                                @endif
                            </td>
                            <td>{{ substr($value->message_email, 0, 100) }}</td>

                            <td>{{ $value->status == 1 ? 'Active' : 'Deactive' }}
                            </td>
                            <td><a href="{{ route('email-template.edit', $value->id) }}"
                                     class="btn btn-block btn-outline-primary"><i class="bx bx-pencil"></i>Edit </a>
                                <form method="post"
                                    action="{{ route('email-template.destroy', $value->id) }}">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit"  class="btn btn-block btn-outline-danger"
                                        onclick="return confirm('Are You sure')"><i
                                            class="bx bx-trash-alt"></i>Delete</button>

                                </form>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            <!--end::Row-->
            <!-- /.Start col -->
        </div>
        <!-- /.row (main row) -->
    </div>
    <!--end::Container-->
</main>
@endsection
@push('script')
<script>
    $(function () {
      $("#datatable-buttons").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>
@endpush
