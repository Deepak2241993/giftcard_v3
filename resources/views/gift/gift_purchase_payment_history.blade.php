@extends('layouts.admin_layout')
@section('body')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3 class="mb-0">Service Order History</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Giftcard Payment Review</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Payment Review
                    </li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="app-main">
    
    <!--end::App Content Header-->
    @if(isset($result))
    <!--begin::App Content-->
    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
        <center>
            <div id="myDiv">
                <div class="box" style="height:70%;
                width: 50%;
                border: solid 1px;
                text-align: left;
                padding: 4px;">
                <img class="mb-4" id="logosuccess" src="{{url('/images/gifts/logo.png')}}" height="60px">
                <table class="table mt-4" style="margin-top: 20px;">
                    <thead>
                        <tr><td colspan="2"><h2>Transaction Details</h2></td></tr>
                      <tr>
                        <th>Gift Receiver's Name</th><td>
                            @if(isset($result->recipient_name))
                            {{$result->recipient_name}}
                            @else
                            {{$result->your_name}}
                            @endif

                        </td></tr>
                      <tr><th>Giftcard Sent To </th><td> {{$result->gift_send_to}}</td></tr>
                      <tr><th>Payment Method </th><td>{{$result->payment_mode}}</td></tr>
                      <tr><th>Giftcard Amount</th><td>${{$result->amount}}</td></tr>
                      <tr><th>Giftcard Quantity</th><td>{{$result->qty}}</td></tr>
                      <tr><th>Total Amount</th><td>${{$result->amount * $result->qty}}</td></tr>
                      <tr style="background-color: #00800047;"><th>Discount</th><td>{{$result->discount}}</td></tr>
                      <tr style="background-color: orange;"><th>Payable Amount</th><td>${{$result->transaction_amount}}</td></tr>
                      <tr><th>Transaction ID</th><td>{{$result->transaction_id}}</td></tr>
                      <tr><th>Transaction Date&Time</th><td>{{ date('m-d-Y h:i:s', strtotime($result->payment_time)) }}</td></tr>
                      <tr style="background-color: {{$result->payment_status=='succeeded'?'#00800047':'orange'}};"><th>Payment Status</th><td>{{$result->payment_status}}</td></tr>
                      <tr><td colspan="2"></td></tr>
                        <tr><td colspan="2"><h2>Gift Card Number</h2></td></tr>
                        <tr><th>Card Number</th><td>Amount</td></tr>
                        {{--  Card Number Loop --}}
                        @if(isset($result->card_number))

                        @foreach($result->card_number as $value)
                        <tr><th>{{$value['giftnumber']}}</th><td>${{$value['amount']}}</td></tr>
                        @endforeach
                        @else
                        <h5>No Card Number Has Been Generated Because the Payment Is Under Process</h5>

                        @endif
                        {{--  Card Number Loop End --}}
                        
                    </thead>
                </table>
            </div>
        </div>
            <button  class="btn btn-block btn-outline-warning mt-4"onclick="printDiv()"> Print</button>
        </center>
                
                <!-- /.Start col -->
            </div>
            <!-- /.row (main row) -->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content-->
    @else
    <h1>No Data Found</h1>
    @endif
</section>

  @endsection

  @push('script')
  <script>
    function printDiv() {
        var divToPrint = document.getElementById('myDiv');
        var newWin = window.open('', 'Print-Window');
        newWin.document.open();
        newWin.document.write('<html><head><title>Print</title></head><body><center>' + divToPrint.innerHTML + '</center></body></html>');
        newWin.document.close();
        $('.box').css('border', '1px solid');
        newWin.print();
    }
</script>
  @endpush

