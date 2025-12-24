@extends('layouts.admin_layout')

@section('body')

<!-- ================= HEADER ================= -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3 class="mb-0">Email Templates</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Email Template</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<main class="app-main">

    <div class="app-content">
        <div class="container-fluid">

            <!-- ================= ACTION BAR ================= -->
            <div class="d-flex justify-content-between mb-3">
                <a href="{{ route('email-template.create') }}"
                   class="btn btn-outline-primary">
                    ➕ Add New Template
                </a>
            </div>

            <!-- ================= FLASH MESSAGE ================= -->
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <!-- ================= TABLE ================= -->
            <table id="datatable-buttons" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="20%">Template Name</th>
                    <th width="20%">Template Type</th>
                    <th width="20%">Template Title</th>
                    <th width="15%">Header Image</th>
                    <th width="30%">Message Preview</th>
                    <th width="10%">Status</th>
                    <th width="20%">Action</th>
                </tr>
                </thead>

                <tbody>
                @foreach($data as $value)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <!-- TITLE -->
                        <td>
                            <strong>{{ $value->template_name }}</strong><br>
                           
                        </td>
                         <td>
                            <strong>{{ $value->template_type }}</strong><br>
                           
                        </td>
                        <td>
                            <strong>{{ $value->title }}</strong><br>
                            <small class="text-muted">{{ $value->secondtitle }}</small>
                        </td>

                        <!-- IMAGE -->
                        <td>
                            @if(!empty($value->header_image))
                                <img src="{{ $value->header_image }}"
                                     alt="Header"
                                     style="width:80px;height:auto;border-radius:6px;">
                            @else
                                <span class="text-muted">No Image</span>
                            @endif
                        </td>

                        <!-- MESSAGE -->
                        <td>
                            {{ \Illuminate\Support\Str::limit(strip_tags($value->message_email), 120) }}
                        </td>

                        <!-- STATUS -->
                        <td>
                            <span class="badge {{ ($value->status ?? 1) ? 'bg-success' : 'bg-danger' }}">
                                {{ ($value->status ?? 1) ? 'Active' : 'Inactive' }}
                            </span>
                        </td>

                        <!-- ACTION -->
                        <td>
                            <div class="btn-group">

                                <a href="{{ route('email-template.edit', $value->id) }}"
                                   class="btn btn-outline-primary btn-sm">
                                    ✏ Edit
                                </a>

                                <a href="{{ route('email-template.preview', $value->id) }}?mode=dummy"
                                   target="_blank"
                                   class="btn btn-outline-secondary btn-sm">
                                    👁 Preview
                                </a>

                                {{-- DELETE (Optional) --}}
                                {{--
                                <form method="POST"
                                      action="{{ route('email-template.destroy', $value->id) }}"
                                      onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm">
                                        🗑 Delete
                                    </button>
                                </form>
                                --}}
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
</main>

@endsection
