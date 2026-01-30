@extends('layouts.admin_layout')

@section('body')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Merge Patients</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/root') }}">Home</a></li>
                    <li class="breadcrumb-item active">Merge Patients</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">

        <div class="alert alert-warning">
            <strong>Warning:</strong>
            Merge only when you are 100% sure both records belong to the same patient.
            This action cannot be undone.
        </div>

        <button id="mergePatientsBtn" class="btn btn-danger d-none mb-3">
            <i class="fa fa-compress"></i> Merge Selected Patients
        </button>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table id="patientsMergeTable" class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>
                                <input type="checkbox" id="selectAllPatients">
                            </th>
                            <th>#</th>
                            <th>Patient</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- DataTable --}}
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>

{{-- ================= MERGE PREVIEW MODAL ================= --}}
<div class="modal fade" id="mergePreviewModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header bg-warning">
                <h5 class="modal-title">⚠ Review Patient Merge</h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 border-right">
                        <h5 class="text-success">Patient A (KEEP)</h5>
                        <div id="patientA"></div>
                    </div>

                    <div class="col-md-6">
                        <h5 class="text-danger">Patient B (MERGE)</h5>
                        <div id="patientB"></div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button id="confirmMergeBtn" class="btn btn-danger">
                    Proceed to Final Merge
                </button>
                <button class="btn btn-secondary" data-dismiss="modal">
                    Cancel
                </button>
            </div>

        </div>
    </div>
</div>

{{-- ================= FINAL CONFIRMATION MODAL ================= --}}
<div class="modal fade" id="mergeConfirmModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Final Confirmation</h5>
            </div>

            <div class="modal-body">
                <p class="text-danger">
                    This action <strong>cannot be undone</strong>.
                </p>

                <label>Type <strong>MERGE</strong> to confirm:</label>
                <input type="text" id="mergeConfirmText" class="form-control">
            </div>

            <div class="modal-footer">
                <button id="finalMergeBtn" class="btn btn-danger" disabled>
                    🔥 MERGE PATIENTS
                </button>
                <button class="btn btn-secondary" data-dismiss="modal">
                    Cancel
                </button>
            </div>

        </div>
    </div>
</div>

@endsection

@push('script')
<script>
let selectedPatients = [];

$(document).ready(function () {

    let table = $('#patientsMergeTable').DataTable({
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
            { data: 'patient_name' },
            { data: 'email' },
            { data: 'phone' },
            { data: 'status_badge', orderable: false }
        ]
    });

    // Select all
    $('#selectAllPatients').on('change', function () {
        $('.patient-checkbox').prop('checked', this.checked).trigger('change');
    });

    // Track selection
    $(document).on('change', '.patient-checkbox', function () {
        selectedPatients = $('.patient-checkbox:checked')
            .map(function () { return $(this).val(); })
            .get();

        $('#mergePatientsBtn')
            .toggleClass('d-none', selectedPatients.length !== 2);
    });

    // Load preview
    $('#mergePatientsBtn').click(function () {
        $.get("{{ route('patients.merge.preview') }}", {
            ids: selectedPatients
        }, function (res) {
            $('#patientA').html(res.patientA);
            $('#patientB').html(res.patientB);
            $('#mergePreviewModal').modal('show');
        });
    });

    // Proceed to final
    $('#confirmMergeBtn').click(function () {
        $('#mergePreviewModal').modal('hide');
        $('#mergeConfirmModal').modal('show');
    });

    // Enable final button
    $('#mergeConfirmText').on('keyup', function () {
        $('#finalMergeBtn').prop(
            'disabled',
            $(this).val() !== 'MERGE'
        );
    });

    // Execute merge
    $('#finalMergeBtn').click(function () {
        $.post("{{ route('patients.merge.execute') }}", {
            _token: "{{ csrf_token() }}",
            keep_id: selectedPatients[0],
            merge_id: selectedPatients[1]
        }, function () {
            location.reload();
        });
    });

});
</script>
@endpush
