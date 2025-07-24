@extends('layouts.admin_layout')
@section('body')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Dashboard</h3>

                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Dashboard
                            </li>
                        </ol>
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <a href="{{ route('gift-category.create') }}"  class="btn btn-block btn-outline-primary">Add More</a>
                <div class="card-header">
                    @if (session()->has('error'))
                        {{ session()->get('error') }}
                    @endif
                    @if (session()->has('success'))
                        {{ session()->get('success') }}
                    @endif
                </div>
                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Created At</th>
                            <th>Status</th>
                            @if (Auth::user()->user_type == 1)
                                <th>Action</th>
                            @endif
                        </tr>
                    </thead>


                    <tbody>
                        @foreach ($data as $key => $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $value->name }}</td>
                                <td>{{ $value->created_at }}</td>
                                <td> {{ $value->status == 1 ? 'Active' : 'Inactive' }}</td>
                                <th>
                                    <a href="{{ route('gift-category.edit', ['gift_category' => $value->id]) }}"
                                         class="btn btn-block btn-outline-primary">Edit</a>
                                    <form action="{{ route('gift-category.destroy', ['gift_category' => $value->id]) }}"
                                        method="POST">
                                        @method('DELETE')
                                        @csrf <!-- You should include CSRF token for security -->
                                        <button  class="btn btn-block btn-outline-danger" type="submit">Delete</button>
                                    </form>


                                </th>


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
        </div>
        <!--end::App Content-->
    </main>
@endsection
