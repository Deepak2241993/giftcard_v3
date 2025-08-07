@extends('layouts.admin_layout')
@section('body')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>All Program</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/root') }}">Home</a></li>
                    <li class="breadcrumb-item active">All Program</li>
                </ol>
            </div>
        </div>
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
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Buy">Buy</th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Program Name">Program Name</th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Unit Name">Unit Name</th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Status">Status</th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Action">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @if(count($data)>0)addcart
                                @foreach($data as $value)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>  @if(isset($id))
                                            <a class="btn btn-sm btn-outline-primary" onclick="({{ $value['id'] }}, {{ $id }})">Buy</a>
                                        @else
                                        <a class="btn btn-sm btn-outline-primary" onclick="addcart({{ $value['id'] }})">Buy</a>
                                        @endif</td>
                                    
                                    <td>{{$value->program_name}}</td>
                                    <td>
                                        <ul>
                                            @php
                                                $unit_id = explode('|', $value->unit_id);
                                                foreach ($unit_id as $unit) {
                                                    $unit_data = \App\Models\ServiceUnit::find($unit);
                                                    if ($unit_data) {
                                                        echo "<li>" . ($unit_data->product_name) . "</li>";
                                                    }
                                                }
                                            @endphp
                                        </ul>
                                    </td>
                                    <td>
                                        @if($value->status==1)
                                        <span class="badge bg-success">Active</span>
                                        @else
                                        <span class="badge bg-danger">Inactive</span>
                                        @endif
                                      </td>
                                      <td class="text-nowrap">
                                    @if(!@isset($id))
                                        <div class="d-flex">
                                            <a href="{{ route('program.edit', $value->id) }}"
                                            class="btn btn-sm btn-outline-primary me-2"><i class="fa fa-edit"></i></a>

                                            <form action="{{ route('program.destroy', $value->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm  btn-outline-danger"
                                                        onclick="return confirm('Are you sure you want to delete this program?')">
                                                   <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endisset
                                </td>

                                
                                    <!-- Button trigger modal -->
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="6"><h3>No Program Available</h3></td>
                                </tr>
                                
                                @endif
                                
                                <br>
                               
                            </tbody>
                        </table>
                        {{-- {{ $data->links() }} --}}


                    </div>
                </div>
            </div>
            <!-- /.row (main row) -->
    </div>
</section>


@endsection

@push('script')
<script>
    function addcart(id,patient_id) {
        $.ajax({
            url: '{{ route('cart') }}',
            method: "post",
            dataType: "json",
            data: {
                _token: '{{ csrf_token() }}',
                program_id: id,
                patient_id: patient_id,
                quantity: 1,
                type: "program"
            },
            success: function(response) {
                if (response.success) {
                    location.href = "{{ route('service-cart') }}";
                } else {
                    $('.showbalance').html(response.error).show();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Handle the error here
                $('.showbalance').html('An error occurred. Please try again.').show();
            }
        });
    }
</script>
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
