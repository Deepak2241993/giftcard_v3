@extends('layouts.admin_layout')
@section('body')
<style>
    .modern-table thead th {
        font-weight: 600;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        background: #f5f7fa !important;
    }

    .modern-table tbody tr {
        border-bottom: 1px dashed #e0e0e0 !important;
        transition: all .2s ease-in-out;
    }

    .modern-table tbody tr:hover {
        background: #eef4ff !important;
        box-shadow: inset 0 0 5px rgba(0,0,0,0.05);
    }

    .modern-table td {
        padding: 12px 16px !important;
        font-size: 15px;
    }

    /* Action buttons */
    .action-btn {
        border: none;
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        font-size: 15px;
        margin-right: 6px;
        transition: 0.2s;
    }

    .action-btn:hover {
        transform: scale(1.13);
    }

    .avatar-circle {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #4c6ef5;
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        font-weight: bold;
        margin-right: 10px;
    }
</style>


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
           <div class="card-body">
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#createPatient">
            Create Patient
        </button>
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#importPatient">
            Import Patient
        </button>

        <button id="mergePatientsBtn" class="btn btn-danger d-none ml-2">
            <i class="fa fa-compress"></i> Merge Selected Patients
        </button>
    </div>
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
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach (explode(' ', session('error')) as $error)
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

                            <div class="card shadow-sm border-0 rounded-4 mt-3">
    <div class="card-header bg-white border-0 pb-1 pt-3">
        <h4 class="card-title fw-bold text-primary">
            <i class="fa fa-users"></i> Patient Records
        </h4>
    </div>

    <div class="card-body p-0">
        <table id="datatable-buttons" class="table table-hover align-middle mb-0 modern-table">
            <thead class="table-light">
                <tr>
                    <th>
                        <input type="checkbox" id="selectAllPatients">
                    </th>
                    <th>#</th>
                    <th><i class="fa fa-cogs"></i> Action</th>
                    <th><i class="fa fa-user"></i> Patient</th>
                    <th><i class="fa fa-envelope"></i> Email</th>
                    <th><i class="fa fa-phone"></i> Phone</th>
                    <th><i class="fa fa-toggle-on"></i> Status</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>


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
                                <label for="patient_login_id" class="form-label">User Name <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" id="patient_login_id" onkeyup="CheckUser()" required
                                    type="text" name="patient_login_id" placeholder="User Name">
                                <div class="showbalance" style="color: red; margin-top: 10px;"></div>
                                <div id="error-patient_login_id" class="text-danger mt-1"></div>
                            </div>

                            <div class="mb-3 col-lg-6 self">
                                <label for="fitst_name" class="form-label">First Name <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" id="fitst_name" required type="text" name="fname"
                                    placeholder="First Name">
                                <div id="error-fname" class="text-danger mt-1"></div>
                            </div>

                            <div class="mb-3 col-lg-6 self">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input class="form-control" type="text" name="lname" placeholder="Last Name"
                                    id="last_name">
                            </div>

                            <div class="mb-3 col-lg-6 self mt-2">
                                <label for="email_id" class="form-label">Email <span class="text-danger">*</span></label>
                                <input class="form-control" type="email" name="email" id="email_id"
                                    placeholder="Email" required>
                                <div id="error-email" class="text-danger mt-1"></div>
                            </div>

                            <div class="mb-3 col-lg-6 self mt-2">
                                <label for="phone_number" class="form-label">Mobile</label>
                                <input class="form-control" type="text" name="phone" id="phone_number"
                                    placeholder="Mobile">
                            </div>

                            <div class="mb-3 col-lg-6">
                                <button class="btn btn-block btn-outline-primary form_submit" type="button"
                                    id="submitBtn" onclick="createFrom()">
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



    {{-- Import Patient  --}}
    <div class="modal fade" id="importPatient">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Upload Patient From CSV</h4>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <span class="p-4"><a href="{{ url('/PatientDummy.csv') }}" download>Download Sample Data</a></span>
                <div class="modal-body">
                    <form action="{{ route('patients.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Select CSV File</label>
                            <input type="file" name="file" class="form-control" required>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">Upload</button>
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
    {{-- Import Patient --}}


    {{-- ================= MERGE PREVIEW MODAL ================= --}}
<div class="modal fade" id="mergePreviewModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            {{-- Header --}}
            <div class="modal-header bg-warning d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    ⚠ Review Patient Merge
                </h5>

                <div>
                    <small class="text-muted mr-3">
                        Left = KEEP • Right = MERGE
                    </small>

                    <button id="swapPatientsBtn"
                            type="button"
                            class="btn btn-outline-dark btn-sm">
                        🔄 Swap KEEP / MERGE
                    </button>

                    <button type="button" class="close ml-2" data-dismiss="modal">
                        &times;
                    </button>
                </div>
            </div>

            {{-- Body --}}
            <div class="modal-body">
                <div class="row">

                    {{-- KEEP --}}
                    <div class="col-md-6">
                        <h6 class="text-success font-weight-bold mb-2">
                            KEEP PATIENT
                        </h6>
                        <div id="patientA"></div>
                    </div>

                    {{-- MERGE --}}
                    <div class="col-md-6">
                        <h6 class="text-danger font-weight-bold mb-2">
                            MERGE PATIENT
                        </h6>
                        <div id="patientB"></div>
                    </div>

                </div>
            </div>

            {{-- Footer --}}
            <div class="modal-footer">
                <button id="confirmMergeBtn"
                        type="button"
                        class="btn btn-danger">
                    Proceed
                </button>

                <button type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal">
                    Cancel
                </button>
            </div>

        </div>
    </div>
</div>
{{-- ================= MERGE PREVIEW MODAL END ================= --}}


{{-- ================= FINAL CONFIRMATION MODAL ================= --}}
<div class="modal fade" id="mergeConfirmModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    Final Confirmation
                </h5>
            </div>

            <div class="modal-body">
                <p class="text-danger">
                    This action <strong>cannot be undone</strong>.
                </p>

                <label class="font-weight-bold">
                    Type <span class="text-danger">MERGE</span> to confirm:
                </label>

                <input type="text"
                       id="mergeConfirmText"
                       class="form-control"
                       placeholder="Type MERGE">
            </div>

            <div class="modal-footer">
                <button id="finalMergeBtn"
                        type="button"
                        class="btn btn-danger"
                        disabled>
                    🔥 MERGE
                </button>

                <button type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal">
                    Cancel
                </button>
            </div>

        </div>
    </div>
</div>
{{-- ================= FINAL CONFIRMATION MODAL END ================= --}}

{{-- End FINAL CONFIRMATION MODAL --}}
@endsection

@push('script')

{{-- For Mearge Function Script  --}}
<script>
let selectedPatients = [];
let keepId = null;
let mergeId = null;

/* ---------------- SELECT CHECKBOXES ---------------- */

$('#selectAllPatients').on('change', function () {
    $('.patient-checkbox').prop('checked', this.checked).trigger('change');
});

$(document).on('change', '.patient-checkbox', function () {
    selectedPatients = $('.patient-checkbox:checked')
        .map(function () { return $(this).val(); })
        .get();

    $('#mergePatientsBtn')
        .toggleClass('d-none', selectedPatients.length !== 2);
});

/* ---------------- LOAD MERGE PREVIEW ---------------- */

$('#mergePatientsBtn').click(function () {
    $.ajax({
        url: "{{ route('patients.merge.preview') }}",
        type: "GET",
        data: {
            'ids[]': selectedPatients
        },
        success: function (res) {
            $('#patientA').html(res.patientA);
            $('#patientB').html(res.patientB);

            // Default assignment
            keepId = selectedPatients[0];
            mergeId  = selectedPatients[1];
            console.log(keepId,mergeId);

            $('#mergePreviewModal').modal('show');
        }
    });
});

/* ---------------- 🔄 SWAP KEEP / MERGE ---------------- */

$('#swapPatientsBtn').on('click', function () {

    // Swap UI
    let left  = $('#patientA').html();
    let right = $('#patientB').html();

    $('#patientA').html(right);
    $('#patientB').html(left);

    // Swap IDs
    let temp = keepId;
    keepId = mergeId;
    mergeId = temp;
});

/* ---------------- PROCEED ---------------- */

$('#confirmMergeBtn').click(function () {
    $('#mergePreviewModal').modal('hide');
    $('#mergeConfirmModal').modal('show');
});

/* ---------------- FINAL CONFIRM ---------------- */

$('#mergeConfirmText').keyup(function () {
    $('#finalMergeBtn').prop('disabled', $(this).val() !== 'MERGE');
});

/* ---------------- EXECUTE MERGE ---------------- */

$('#finalMergeBtn').click(function () {
    $.post("{{ route('patients.merge.execute') }}", {
        _token: "{{ csrf_token() }}",
        keep_id: keepId,
        merge_id: mergeId
    }, function () {
        location.reload();
    });
});
</script>

{{-- Mearge Code End  --}}


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
                success: function(response) {
                    $("#submitBtn").prop("disabled", false);
                    $("#btnText").text("Submit");
                    $("#spinner").addClass("d-none");

                    if (response.success) {
                        $("#success-message").removeClass("d-none").text(response.message);
                        $("#error-message").addClass("d-none");

                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        $("#error-message").removeClass("d-none").text(response.message);
                        $("#success-message").addClass("d-none");
                    }
                },
                error: function(xhr) {
                    $("#submitBtn").prop("disabled", false);
                    $("#btnText").text("Submit");
                    $("#spinner").addClass("d-none");

                    let errors = xhr.responseJSON?.errors;
                    $(".text-danger").text(""); // Clear previous errors

                    if (errors) {
                        $.each(errors, function(key, value) {
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
                    url: `{{ url('/') }}/admin/patient/${id}`,
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

{{-- For Index Table Data --}}
    <script>
        $(document).ready(function () {

    var table = $("#datatable-buttons").DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('patient.table.data') }}",
    columns: [
        {
            data: 'id',
            orderable: false,
            searchable: false,
            render: function (id) {
                return `<input type="checkbox" class="patient-checkbox" value="${id}">`;
            }
        },
        { data: 'DT_RowIndex', orderable: false, searchable: false },
        { data: 'action', orderable: false, searchable: false },
        { data: 'patient_name' },
        { data: 'email' },
        { data: 'phone' },
        { data: 'status_badge', orderable: false }
    ],
    order: [[3, "asc"]],
    responsive: true,
    autoWidth: false,
    dom: 'Bfrtip',
    buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
});


    // Append Buttons Correctly
    table.buttons().container()
        .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
});

    </script>
@endpush
