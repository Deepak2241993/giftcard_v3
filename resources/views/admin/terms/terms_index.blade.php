@extends('layouts.admin_layout')
@section('body')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3 class="mb-0">Terms & Condition</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Terms & Condition</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">

    <div class="container-fluid">

        {{-- Top Bar --}}
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('terms.create') }}" class="btn btn-primary">
                + Add Term
            </a>
        </div>

        {{-- Alerts --}}
        @if (session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- MAIN CARD --}}
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Terms List</h5>
            </div>

            <div class="card-body">

                @php
                    // Preload names (faster)
                    $allProducts = App\Models\Product::pluck('product_name', 'id');
                    $allUnits = App\Models\ServiceUnit::pluck('product_name', 'id');
                @endphp

                <table id="datatable-buttons" class="table table-striped table-bordered w-100">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Service Name</th>
                            <th>Unit Name</th>
                            <th>Created At</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($result as $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                {{-- Services --}}
                                <td>
                                    @php
                                        $serviceNames = [];
                                        foreach (explode('|', $value->service_id) as $sid) {
                                            if (isset($allProducts[$sid])) {
                                                $serviceNames[] = $allProducts[$sid];
                                            }
                                        }
                                    @endphp
                                    {{ $serviceNames ? implode(', ', $serviceNames) : 'N/A' }}
                                </td>

                                {{-- Units --}}
                                <td>
                                    @php
                                        $unitNames = [];
                                        foreach (explode('|', $value->unit_id) as $uid) {
                                            if (isset($allUnits[$uid])) {
                                                $unitNames[] = $allUnits[$uid];
                                            }
                                        }
                                    @endphp
                                    {{ $unitNames ? implode(', ', $unitNames) : 'N/A' }}
                                </td>

                                <td>{{ $value->created_at->format('m-d-Y h:i A') }}</td>

                                {{-- Action Buttons --}}
                                <td class="text-center">

                                    <a href="{{ route('terms.edit', $value->id) }}"
                                       class="btn btn-sm btn-outline-primary me-1">
                                        Edit
                                    </a>

                                    <form action="{{ route('terms.destroy', $value->id) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Delete this term?')">
                                            Delete
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
    $(function() {
        $("#datatable-buttons").DataTable({
            responsive: true,
            lengthChange: true,
            autoWidth: false,
            pageLength: 10,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search terms..."
            },
            buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
    });
</script>
@endpush
