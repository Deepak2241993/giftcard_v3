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
            <a href="{{route('medspa-gift.create')}}"  class="btn btn-block btn-outline-primary">Add More</a>
            <div class="card-header">
                @if(session()->has('error'))
                    {{ session()->get('error') }}
                @endif
                @if(session()->has('success'))
                    {{ session()->get('success') }}
                @endif
            </div>
            <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Amount</th>
                    <th>coupen_code</th>
                    <th>Email Template Name</th>
                    <th>Category Name</th>
                    <th>Created At</th>
                    <th>Status</th>
                    @if(Auth::user()->user_type==1)
                    <th>Action</th>
                    @endif
                </tr>
                </thead>
                 <tbody>
                    @foreach($data as $key => $value)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $value->title }}</td>
                        <td>{{ $value->amount }}</td>
                        <td>{{ $value->coupon_code == 1 ? 'Active' : 'Inactive' }}</td>
                        <td>{{ $value->template_title }}</td>
                        <td>{{ $value->category_name }}</td>
                        <td>{{ $value->created_at }}</td>
                        <td>{{ $value->status == 1 ? 'Active' : 'Inactive' }}</td>
                        <td>
                            <a href="{{route('medspa-gift.edit',$value->id)}}"  class="btn btn-block btn-outline-primary">Edit</a>
                            <form action="{{route('medspa-gift.destroy',$value->id) }}" method="POST">
                                @method('DELETE')
                                @csrf <!-- Include CSRF token for security -->
                                <button  class="btn btn-block btn-outline-danger" type="submit">Delete</button>
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
    </div>
    <!--end::App Content-->
</main>
@endsection
