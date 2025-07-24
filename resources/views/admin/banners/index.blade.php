@extends('layouts.admin_layout')
@section('body')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>All Sliders</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/root') }}">Home</a></li>
                    <li class="breadcrumb-item active">All Sliders</li>
                </ol>
            </div>
        </div>
        <a href="{{ route('banner.create') }}"  class="btn btn-block btn-outline-primary">Add More</a>
    </div><!-- /.container-fluid -->
</section>
<section class="content-header">
    <!--begin::App Content-->
    <div class="app-content">
        <!--begin::Container-->
        <section class="content">
            <div class="container-fluid">
                <!--begin::Row-->
                {{-- <a href="{{route('medspa-gift.create') }}"  class="btn btn-block
                btn-outline-primary">Add More</a> --}}
                <div class="card-header">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(session('error'))
                    <div class="alert alert-danger">
                        <ul>
                            @foreach(explode(' ', session('error')) as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                

                </div>
                <span class="text-success" id="response_msg"></span>
                <div class="scroll-container">
                    <div style="overflow: scroll">
                        {{-- <div class="scroll-content"> --}}

                            <table id="datatable-buttons" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#">#</th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title">Title</th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Image">Image</th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="URL">URL</th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Status">Status</th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Action">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($result as $key=>$value)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $value->title ? $value->title : '' }}
                                        </td>
                                        <td><img src="{{ $value->image ? $value->image : '' }}"
                                                height="100" width="200" onerror="this.onerror=null; this.src='{{url('/No_Image_Available.jpg')}}';"></td>
                                        <td>{{ $value->url ? $value->url : '' }}
                                        </td>
                                        <td>{{ $value->status ==1 ? 'Active' : 'Inactive' }}
                                        </td>
                                        <td>
                                            <a href="{{ route('banner.edit', $value->id) }}"
                                                 class="btn btn-block btn-outline-primary">Edit</a>
                                            <form
                                                action="{{ route('banner.destroy', $value->id) }}"
                                                method="POST">
                                                @method('DELETE')
                                                
                                                  @csrf
                                                <button  class="btn btn-block btn-outline-danger" type="submit">Delete</button>
                                            </form>
                                        </td>


                                        <!-- Button trigger modal -->
                                    </tr>
                                @endforeach
                                <br>

                            </tbody>
                        </table>


                        <hr>

                    </div>
                </div>
            </div>
            <!-- /.row (main row) -->
    </div>
</section>


@endsection

@push('script')
<script>
    $(function () {
      $("#datatable-buttons").DataTable({
        "responsive": true, "lengthChange": true, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>
@endpush
