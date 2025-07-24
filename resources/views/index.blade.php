@extends('layouts.master')
@section('title') @lang('translation.Dashboards') @endsection
@section('css')

<link href="{{ URL::asset('/assets/libs/admin-resources/admin-resources.min.css') }}" rel="stylesheet">

@endsection
@section('content')

@component('components.breadcrumb')
@slot('li_1') Dashboard @endslot
@slot('title') Welcome ! @endslot
@endcomponent

@if(Auth::user()->user_type==1)
    @include('admindashboard');
@else
@include('userdashboard');
@endif



@endsection
@section('script')
<!-- apexcharts -->
<script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/admin-resources/admin-resources.min.js') }}"></script>

<!-- dashboard init -->
<script src="{{ URL::asset('/assets/js/pages/dashboard.init.js') }}"></script>

@endsection
