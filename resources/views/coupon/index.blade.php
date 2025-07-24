@extends('layouts.admin_layout')
@section('body')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h3 class="mb-0">All-Coupon</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ url('admin-dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            All-Coupon
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
            <a href="{{ route('coupon.create') }}"  class="btn btn-block btn-outline-primary">Add More</a>
            <div class="card-header">
                @if(session()->has('error'))
                    {{ session()->get('error') }}
                @endif
                @if(session()->has('success'))
                    {{ session()->get('success') }}
                @endif
            </div>
            @if(count($data) > 0)
            <table id="datatable-buttons" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#">#</th>
                            <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name">Name</th>
                            <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Discount">Discount</th>
                            <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Code">Code</th>
                            <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Created At">Created At</th>
                            <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Status">Status</th>
                            @if(Auth::user()->user_type == 1)
                                <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Action">Action</th>
                            @endif
                        </tr>
                    </thead>


                    <tbody>
                        @foreach($data as $key => $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $value->title }}</td>
                                {{-- <td>{{$value->category_name }}</td> --}}
                                <td>{{ $value->discount_type == 'amount' ? '$ ' . $value->discount_rate : $value->discount_rate . ' %' }}
                                </td>
                                <td>{{ $value->coupon_code }}</td>
                                <td>{{ $value->created_at }}</td>
                                <td> {{ $value->status == 1 ? 'Active' : 'Inactive' }}
                                </td>
                                <th>
                                    <a href="{{ route('coupon.edit', $value->id) }}"
                                         class="btn btn-block btn-outline-primary">Edit</a>

                                    <form action="{{ route('coupon.destroy', $value->id) }}"
                                        method="POST">
                                        @method('DELETE')
                                        @csrf<!-- Include CSRF token for security -->
                                        <button  class="btn btn-block btn-outline-danger" type="submit">Delete</button>
                                    </form>



                                </th>


                            </tr>
                        @endforeach

                    </tbody>
                </table>
            @else
                <p> No data found</p>
            @endif
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