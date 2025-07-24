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
                @if(isset($medsapGift))
                
                <form method="post" action="{{route('medspa-gift.update',$medsapGift->id)}}" enctype="multipart/form-data">
                    @method('PUT')
                @else
                    <form method="post" action="{{ route('medspa-gift.store') }}" enctype="multipart/form-data">
                @endif
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-lg-6 self">
                            <label for="title" class="form-label">Giftcard Title</label>
                            <input class="form-control" type="text" name="title" value="{{isset($medsapGift)?$medsapGift->title:''}}" placeholder="Card Title">
                        </div>
                        @if(count($gatcategory)>0)
                        <div class="mb-3 col-lg-6 self">
                            <label for="title" class="form-label">Select Category</label>
                           <select  class="form-control" name="category_id" required>
                            <option value="">Select Category</option>
                            @foreach($gatcategory as $key=>$value)
                            <option value="{{$value->id}}" {{(isset($medsapGift)&& $medsapGift->category_id==$value->id)?'selected':''}}>{{$value->name}}</option>
                            @endforeach
                           </select>
                        </div>
                        @endif
                        
                        @if(count($template)>0)
                        <div class="mb-3 col-lg-6 self">
                            <label for="title" class="form-label">Select Email Template</label>
                           <select  class="form-control" name="template_id" required>
                            <option value="">Select Email Template</option>
                            @foreach($template as $key=>$value)
                            <option value="{{$value->id}}"{{(isset($medsapGift)&& $medsapGift->template_id==$value->id)?'selected':''}}>{{$value->title}}</option>
                            @endforeach
                           </select>
                        </div>
                        @endif
                        <div class="mb-3 col-lg-6 self">
                            <label for="amount" class="form-label">Giftcard Amount</label>
                            <input class="form-control" id="amount" type="number" min="1" name="amount" value="{{isset($medsapGift)?$medsapGift->amount:''}}" placeholder="Giftcard Amount">
                        </div>
                        <div class="mb-3 col-lg-6 self">
                            <label for="image" class="form-label">Giftcard Image</label>
                            <input class="form-control" id="image" type="file" name="image" value="{{isset($medsapGift)?$medsapGift->amount:''}}">
                        </div>
                       
                        <div class="mb-3 col-lg-6">
                            <label for="from" class="form-label">Status</label>
                            <select class="form-control" name="status" id="from">
                                <option value="1"{{ isset($medsapGift->status) && $medsapGift->status == 1 ? 'selected' : '' }} >Active</option>
                                <option value="0"{{ isset($medsapGift->status) && $medsapGift->status == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="form-check form-switch form-switch-lg mt-4 col-lg-6" dir="ltr">
                            <input type="checkbox" name="coupon_code" class="form-check-input" id="customSwitchsizelg" {{ isset($medsapGift) && $medsapGift->coupon_code == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="customSwitchsizelg">Coupon Code</label>
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
