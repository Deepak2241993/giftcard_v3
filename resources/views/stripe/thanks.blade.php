@extends('layouts.front-master')

@section('body')


    <style>

.tran{

padding-top: 200px;
}
        /* Define styles for the print version */
        @media print {
            body * {
                visibility: hidden;
            }

            #printableContent,
            #printableContent * {
                visibility: visible;
            }

            #printableContent {
                position: absolute;
                left: 0;
                top: 0;
            }
        }

        .fit-image {
            max-width: 50%;
            height: auto;
        }

        .payment-image {
            max-width: 20%;
            height: auto;
            align-items: center;
        }

        .form-card {
    text-align: center;
    margin: 20px auto;
    width: 80%;
    max-width: 400px; /* Adjust max-width as needed */
    padding: 80px 20px; /* Adjust padding to fit content within the image */
    background-color: #ffffff; /* Background color for the container */
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); /* Box shadow for a subtle effect */
    background-image: url({{ asset('giftcards/images/payment.png') }});
    background-size: 400px; /* Cover the entire container */
    background-repeat: no-repeat; /* Set the background to appear only once */
}


.tran{

padding-top: 200px;
}

.col-7{
padding-left: 0px;
padding-right: 0px;

}

.row{

margin-left: -60px;
margin-right: -60px;
}

/* Adjust other styles as needed */

@media screen and (max-width: 768px){

    .form-card {
    text-align: center;
    margin-bottom: 50px;
    width: 80%;
    max-width: 400px; /* Adjust max-width as needed */
    padding: 60px 20px; /* Adjust padding to fit content within the image */
    background-color: #ffffff; /* Background color for the container */
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); /* Box shadow for a subtle effect */
    background-image: url({{asset('giftcards/images/payment.png')}});
    background-size: 350px; /* Cover the entire container */
    background-repeat: no-repeat; /* Set the background to appear only once */
}

}

    </style>

    <div id="myDiv" class="about-box" style="padding-bottom: 0;">
        <fieldset id="finishbox">
            <div class="form-card">
                <img id="logosuccess" src="{{url('/images/gifts/logo.png')}}" style="width:200px; height:100px; display:none">
                <div class="row justify-content-center">
                    <div class="col-7 ">
                    <h4 class="tran">Payment Successful. Thank you for the payment</h4>
                        <p>Transaction Id :  {{$data->source->id}}</br>
                        Order Amount :  ${{$data->amount/100}}</p>
                        <h5>Giftcard Sent Successfully</h5>
                       
                    </div>
                </div>
                
            </div>
        </fieldset>
    </div>
    {{--  for Redeem Process  --}}
    <div class="container">
        <h3>Redeem Process</h3>
        <ol>
           <li>The customer needs to purchase the giftcard from<strong> https://myforevermedspa.com</strong></li>
           <li>After Purchasing the giftcard, the customer needs to visit the <strong>MedSpa Wellness Center</strong> to redeem the dedicated purchased Giftcard</li>
           <li>Admins at the Welness centre will check the details of the giftcard and process the transaction as per need of the customer</li>
        </ol>
     </div>


    <center class="mb-2">
        <a href="{{ url('/') }}"  class="btn btn-primary mr-2">Home</a>
        <button  class="btn btn-success" id="printButton" onclick="printDiv()">Print</button>
    </center>
    

@endsection

@push('footerscript')

<script>
    function printDiv() {
        $('#logosuccess').css('display', 'block');
        var divToPrint = document.getElementById('myDiv');
        var newWin = window.open('', 'Print-Window');
        newWin.document.open();
        newWin.document.write('<html><head><title>Print</title></head><body>' + divToPrint.innerHTML + '</body></html>');
        newWin.document.close();
        $('#logosuccess').css('display', 'none');
        newWin.print();
    }
</script>

@endpush
