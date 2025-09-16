@extends('layouts.front-master')

@section('body')

<style>
.btn-primary, .btn-secondary {
    flex: 0 !important;
}
/* ✅ Reset fieldset default border */
fieldset {
    border: none !important;
    margin: 0;
    padding: 0;
}

/* ✅ Base Styles */
.tran {
    padding-top: 200px;
}

/* Print Version */
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
    display: block;
    margin: 0 auto;
}

/* ✅ Card Styling */
.form-card {
    text-align: center;
    margin: 40px auto;
    width: 90%;
    max-width: 420px;
    padding: 100px 20px 60px; /* more top space for bg image */
    background-color: #ffffff;
    border-radius: 12px;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.15);
    background-image: url({{ asset('giftcards/images/payment.png') }});
    background-size: contain; /* fluid scaling */
    background-position: top center;
    background-repeat: no-repeat;
}

/* ✅ Desktop Spacing Fix */
.col-7 {
    padding-left: 0;
    padding-right: 0;
}

.container {
        min-height:10vh !important ;
    }

.row {
    margin-left: 0;
    margin-right: 0;
}

/* ✅ Mobile Responsive */
@media screen and (max-width: 768px) {
    .tran {
        padding-top: 140px;
        font-size: 18px;
        line-height: 1.4;
    }

    .form-card {
        width: 95%;
        max-width: 380px;
        padding: 90px 15px 50px;
        background-size: 90%; /* fluid scaling */
    }

    #logosuccess {
        width: 140px !important;
        height: auto !important;
    }

    .container h3 {
        font-size: 20px;
        margin-top: 25px;
    }

    .container ol {
        padding-left: 20px;
    }
}

@media screen and (max-width: 480px) {
    .tran {
        padding-top: 120px;
        font-size: 16px;
    }

    .form-card {
        padding: 80px 12px 40px;
        background-size: 95%;
    }

    .container h3 {
        font-size: 18px;
    }

    .container ol li {
        font-size: 14px;
        margin-bottom: 6px;
    }
}
@media (max-width: 576px) {
    .container {
        min-height:10vh !important ;
    }
}
</style>

<style>
/* ✅ Equal button styling */
.btn-action {
    width: 130px;        /* same fixed width */
    height: 40px;        /* same height */
    font-size: 14px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

/* ✅ Desktop: side by side, centered */
.button-container {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 15px;
}

/* ✅ Mobile: stacked vertically */
@media (max-width: 768px) {
    .button-container {
        flex-direction: column;
        gap: 10px;
    }
    .btn-action {
        width: 80%; /* make them wider on small screens */
    }
}
</style>

<div id="myDiv" class="about-box" style="padding-bottom: 0;">
    <fieldset id="finishbox">
        <div class="form-card">
            <img id="logosuccess" src="{{url('/images/gifts/logo.png')}}" style="width:200px; height:100px; display:none">
            <div class="row justify-content-center">
                <div class="col-7">
                    <h4 class="tran">Payment Successful. Thank you for the payment</h4>
                  <p>
    Transaction Id : {{ isset($data->source->id) ? $data->source->id : '' }}<br>
    Order Amount : ${{ isset($data->amount) ? $data->amount/100 : '' }}
</p>

                    {{-- <p>
                        Transaction Id : TXN123456789<br>
                        Order Amount : $100
                    </p> --}}
                    <h5>Giftcard Sent Successfully</h5>
                </div>
            </div>
        </div>
    </fieldset>
</div>


{{-- Redeem Process --}}
<div class="container">
    <h3>Redeem Process</h3>
    <ol>
        <li>The customer needs to purchase the giftcard from <strong>https://myforevermedspa.com</strong></li>
        <li>After Purchasing the giftcard, the customer needs to visit the <strong>MedSpa Wellness Center</strong> to redeem the dedicated purchased Giftcard</li>
        <li>Admins at the Wellness Centre will check the details of the giftcard and process the transaction as per need of the customer</li>
    </ol>
</div>

<!-- <center class="mb-2">
    <a href="{{ url('/') }}" class="btn btn-primary mr-2">Home</a>
    <button class="btn btn-success" id="printButton" onclick="printDiv()">Print</button>
</center> -->

<center class="mb-3 button-container">
    <a href="{{ url('/') }}" class="btn btn-primary btn-action">Home</a>
    <button class="btn btn-primary btn-action" id="printButton" onclick="printDiv()">Print</button>
</center>

@endsection

@push('footerscript')
<script>
function printDiv() {
    // Show logo in original div
    var logo = document.getElementById('logosuccess');
    logo.style.display = 'block';

    // Copy content
    var divToPrint = document.getElementById('myDiv').innerHTML;
    var newWin = window.open('', 'Print-Window');

    newWin.document.open();
    newWin.document.write(`
        <html>
        <head>
            <title>Print</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                img { display: block; margin: 0 auto 20px; }
                .tran { color: green; }
            </style>
        </head>
        <body onload="window.print(); window.close();">
            ${divToPrint}
        </body>
        </html>
    `);
    newWin.document.close();

    // Hide logo again in the original page
    logo.style.display = 'none';
}
</script>
@endpush
