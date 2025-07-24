@extends('layouts.admin_layout')
@section('body')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>All Patient</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/root') }}">Home</a></li>
                    <li class="breadcrumb-item active">All Patient</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<div class="card-body">
    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#createPatient">
        Create Patient
    </button>
</div>
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
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Action">Action</th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Patient Name">Patient Name</th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Email">Email</th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Phone">Phone</th>
                                    {{-- <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Address">Address</th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Zip Code">Zip Code</th> --}}
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Status">Status</th>
                                </tr>
                            </thead>
                            <tbody id="data-table-body">
                                
                                @if(count($data)>0)
                                @foreach($data as $value)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>
                                        
                                        <div class="btn-group mb-2" role="group" aria-label="Quick Actions">
                                            <a href="{{ route('patient.edit', $value->id) }}" class="btn btn-outline-primary btn-sm" title="View Profile">
                                                <i class="fa fa-user"></i>
                                            </a>

                                            <a href="{{ route('giftcards-sale') }}" class="btn btn-outline-success btn-sm" title="Buy Giftcard">
                                                <i class="fa fa-gift"></i>
                                            </a>

                                            <a href="{{ route('product.index') }}" class="btn btn-outline-info btn-sm" title="Buy Services & Deals">
                                                <i class="fa fa-dna"></i>
                                            </a>

                                            <a href="{{ route('program.index') }}" class="btn btn-outline-warning btn-sm" title="Buy Program">
                                                <i class="fa fa-stethoscope"></i>
                                            </a>
                                        </div>

                                        {{-- <form
                                            action="{{route('patient.destroy',$value->id)}}"
                                            method="POST">
                                            @method('DELETE')
                                            
                                              @csrf
                                            <button  class="btn btn-block btn-outline-danger" type="submit">Delete</button>
                                        </form> --}}
                                    </td>
                                    <td>{{$value->fname ." ".$value->lname }}</td>
                                    <td>{{$value->email }}</td>
                                    <td>{{$value->phone }}</td>
                                    {{-- <td>{{$value->address }}</td>
                                    <td>{{$value->zip_code }}</td> --}}
                                    <td>
                                        @if($value->status==1)
                                        <span class="badge bg-success">Active</span>
                                        @else
                                        <span class="badge bg-danger">Inactive</span>
                                        @endif
                                      </td>
                                 
                                
                                    <!-- Button trigger modal -->
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="8"><h3>No Program Available</h3></td>
                                </tr>
                                
                                @endif
                                
                                <br>
                                {{-- {{ $data->links() }} --}}
                            </tbody>
                        </table>

                        {{-- {{ $data->links() }} --}}
                       

                    </div>
                </div>
            </div>
            <!-- /.row (main row) -->
    </div>
</section>

{{-- For Create Patient  --}}
<div class="modal fade" id="createPatient">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create Patient Quickly</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="patientForm" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-lg-12 self">
                            <label for="patient_login_id" class="form-label">User Name <span class="text-danger">*</span></label>
                            <input class="form-control" id="patient_login_id" onkeyup="CheckUser()" required type="text" name="patient_login_id" placeholder="User Name">
                            <div class="showbalance" style="color: red; margin-top: 10px;"></div>
                            <div id="error-patient_login_id" class="text-danger mt-1"></div>
                        </div>
                
                        <div class="mb-3 col-lg-6 self">
                            <label for="fitst_name" class="form-label">First Name <span class="text-danger">*</span></label>
                            <input class="form-control" id="fitst_name" required type="text" name="fname" placeholder="First Name">
                            <div id="error-fname" class="text-danger mt-1"></div>
                        </div>
                
                        <div class="mb-3 col-lg-6 self">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input class="form-control" type="text" name="lname" placeholder="Last Name" id="last_name">
                        </div>
                
                        <div class="mb-3 col-lg-6 self mt-2">
                            <label for="email_id" class="form-label">Email <span class="text-danger">*</span></label>
                            <input class="form-control" type="email" name="email" id="email_id" placeholder="Email" required>
                            <div id="error-email" class="text-danger mt-1"></div>
                        </div>
                
                        <div class="mb-3 col-lg-6 self mt-2">
                            <label for="phone_number" class="form-label">Mobile</label>
                            <input class="form-control" type="number" name="phone" id="phone_number" placeholder="Mobile">
                        </div>
                
                        <div class="mb-3 col-lg-6">
                            <button class="btn btn-block btn-outline-primary form_submit" type="button" id="submitBtn" onclick="createFrom()">
                                <span id="btnText">Submit</span>
                                <span id="spinner" class="spinner-border spinner-border-sm d-none"></span>
                            </button>
                        </div>
                    </div>
                </form>
                
                <!-- Success & Error Messages -->
                <div id="success-message" class="alert alert-success d-none"></div>
                <div id="error-message" class="alert alert-danger d-none"></div>
                
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
{{-- Create Patient Code End --}}

@endsection

@push('script')
<script>
    function createFrom() {
    let formData = new FormData(document.getElementById("patientForm"));

    // Disable button, show spinner, and update text
    $("#submitBtn").prop("disabled", true);
    $("#btnText").text("Submitting...");
    $("#spinner").removeClass("d-none");

    $.ajax({
        url: "{{ route('patient-quick-create') }}",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ensure correct CSRF token is used
        },
        success: function (response) {
            $("#submitBtn").prop("disabled", false);
            $("#btnText").text("Submit");
            $("#spinner").addClass("d-none");

            if (response.success) {
                $("#success-message").removeClass("d-none").text(response.message);
                $("#error-message").addClass("d-none");
                
                setTimeout(function () {
                    location.reload();
                }, 2000);
            } else {
                $("#error-message").removeClass("d-none").text(response.message);
                $("#success-message").addClass("d-none");
            }
        },
        error: function (xhr) {
            $("#submitBtn").prop("disabled", false);
            $("#btnText").text("Submit");
            $("#spinner").addClass("d-none");

            let errors = xhr.responseJSON?.errors;
            $(".text-danger").text(""); // Clear previous errors

            if (errors) {
                $.each(errors, function (key, value) {
                    $("#error-" + key).text(value[0]);
                });
            } else {
                $("#error-message").removeClass("d-none").text("Something went wrong!");
            }
        }
    });
} 


</script>
<script>

function deletePatient(id) {
    if (confirm('Are you sure you want to delete this patient?')) {
        $.ajax({
            url: `{{url('/')}}/admin/patient/${id}`,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                alert(response.message);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('Failed to delete the patient.');
            }
        });
    }
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
