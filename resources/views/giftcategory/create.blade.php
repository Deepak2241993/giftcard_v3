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
                <div class="card-body p-4">
                    @if (isset($giftCategory))
                        <form method="post"
                            action="{{ route('gift-category.update', ['gift_category' => $giftCategory->id]) }}"
                            enctype="multipart/form-data">
                            @method('PUT')
                        @else
                            <form method="post" action="{{ route('gift-category.store') }}" enctype="multipart/form-data">
                    @endif

                    @csrf
                    <div class="row">


                        <div class="mb-3 col-lg-6 self">
                            <label for="to" class="form-label">Category Name</label>
                            <input class="form-control" type="name" name="name"
                                value="{{ isset($giftCategory) ? $giftCategory->name : '' }}" placeholder="Gift Card Name"
                                id="to">
                        </div>
                        <div class="mb-3 col-lg-6">
                            <label for="status" class="form-label">From</label>
                            <select class="form-control" name="status" id='status'>
                                <option
                                    value="1"{{ isset($giftCategory->status) && $giftCategory->status == 1 ? 'selected' : '' }}>
                                    Active</option>
                                <option
                                    value="0"{{ isset($giftCategory->status) && $giftCategory->status == 0 ? 'selected' : '' }}>
                                    Inactive</option>
                            </select>
                        </div>


                        <div class="mb-3 col-lg-6">

                            <button  class="btn btn-block btn-outline-primary" type="submit" name="submit">Submit</button>
                        </div>
                    </div>
                    </form>
                </div>
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
