@extends('layouts.patient_layout')
@section('body')
    <!-- Body main wrapper start -->
    <!-- Your existing content in invoice.blade.php -->
   
    <main class="app-main">
        <!--begin::App Content Header-->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Invoice</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Orders</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Invoice
                            </li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
    <!-- Include the service_invoice.blade.php file here -->
    @include('invoice.service_invoice', ['transaction_data' => $transaction_data])
    </main>
    <!-- Rest of your content in invoice.blade.php -->
@endsection
