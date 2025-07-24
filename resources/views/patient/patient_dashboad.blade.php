@extends('layouts.patient_layout')
@section('body')
       <!-- Content Header (Page header) -->
       <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('root')}}">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
                </div><!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <section class="content">
            <div class="container-fluid">
            <!-- Info boxes -->
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-solid fa-gift" aria-hidden="true"></i></span>
                        <a href="{{ route('my-giftcards') }}">
                            <div class="info-box-content">
                                <span class="info-box-text">My Giftcards</span>
                                <span class="info-box-number">
                                {{ $giftcards }}
                                
                                </span>
                            </div>
                        </a>
                        <!-- /.info-box-content -->
                    </div>
                        <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <a href="{{ route('my-services') }}">
                    <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fa fa-user-md"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">My Services</span>
                        <span class="info-box-number">{{ $order }}</span>
                    </div>
                    <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </a>
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                
                
                <!-- /.col -->
                </div>
                
                <!-- /.col -->
                </div>
            </div>
        </section>

    
@endsection

