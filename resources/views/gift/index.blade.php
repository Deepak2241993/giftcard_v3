@extends('layouts.master')
@section('title') @lang('translation.Data_Tables')  @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/datatables.net-bs4/datatables.net-bs4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/libs/datatables.net-buttons-bs4/datatables.net-buttons-bs4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/libs/datatables.net-responsive-bs4/datatables.net-responsive-bs4.min.css') }}" rel="stylesheet" type="text/css" />

@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Tables @endslot
@slot('title') All Giftcards @endslot
@endcomponent

 <!-- end row -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">All Giftcards</h4>
               
            </div>
            <div class="card-body">
                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                    <tr>
                        <th>To Name</th>
                        <th>From Name</th>
                        <th>To</th>
                        <th>From</th>
                        <th>Amount $</th>
                        <th>Gift Card Code</th>
                        <th>Redeem Status</th>
                        @if(Auth::user()->user_type==1)
                        <th>Action</th>
                        @endif
                    </tr>
                    </thead>


                    <tbody>
                        @foreach($data as $key=>$value)
                        
                    <tr>
                        <td>{{$value->to_name}}</td>
                        <td>{{$value->from_name}}</td>
                        <td>{{$value->to}}</td>
                        <td>{{$value->from}}</td>
                        <td>{{$value->amount}}</td>
                        <td>{{$value->code}}</td>
                        <td> {{ $value->is_redeemed == 0 ? 'Not Redeem' : 'Redeem' }}</td>
                        @if(Auth::user()->user_type==1)
                        <th>Action</th>
                        @endif
                       
                    </tr>
                    @endforeach
                    
                    </tbody>
                </table>
            </div>
        </div>
        <!-- end cardaa -->
    </div> <!-- end col -->
</div> <!-- end row -->

@endsection
@section('script')
<script src="{{ URL::asset('assets/libs/datatables.net/datatables.net.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/datatables.net-bs4/datatables.net-bs4.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/datatables.net-buttons/datatables.net-buttons.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/datatables.net-buttons-bs4/datatables.net-buttons-bs4.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/jszip/jszip.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/datatables.net-responsive/datatables.net-responsive.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/datatables.net-responsive-bs4/datatables.net-responsive-bs4.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
<script src="{{ URL::asset('assets/js/app.min.js') }}"></script>
@endsection
