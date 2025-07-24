@extends('layouts.admin_layout')
@section('body')
<style>
    .btn-outline-warning {
        --bs-btn-color: #000;
        --bs-btn-bg: #d3d3d3;
        --bs-btn-border-color: #d3d3d3;
        --bs-btn-hover-color: #000;
        --bs-btn-hover-bg: #ffca2c;
        --bs-btn-hover-border-color: #d3d3d3;
        --bs-btn-focus-shadow-rgb: 217, 164, 6;
        --bs-btn-active-color: #000;
        --bs-btn-active-bg: #ffc720;
        --bs-btn-active-border-color: #ffc720;
        --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
        --bs-btn-disabled-color: #000;
        --bs-btn-disabled-bg: #ffc107;
        --bs-btn-disabled-border-color: #ffc107;
    }

    .btn-light.active {
        background-color: #ffc107;
        border-color: #ffc107;
    }

    section {
        position: relative;
        padding: 5px;
        text-align: left;
    }

    .giftlist {
        margin-left: 10px;
        max-width: 10px;
    }

    .giftamount {
        max-width: 50px;
        margin-left: 300px;
    }

    html {
        height: 100%;
    }

    /*form styles*/
    #msform {
        /* text-align: center; */
        position: relative;
        margin-top: 20px;
    }

    #msform section .form-card {
        background: white;
        border: 0 none;
        border-radius: 0px;
        box-shadow: 0 2px 2px 2px rgba(0, 0, 0, 0.2);
        padding: 20px 40px 30px 40px;
        box-sizing: border-box;
        width: 94%;
        margin: 0 3% 20px 3%;
        /*stacking sections above each other*/
        position: relative;
    }

    #msform section {
        background: white;
        border: 0 none;
        border-radius: 0.5rem;
        box-sizing: border-box;
        width: 100%;
        margin: 0;
        padding-bottom: 20px;
        /*stacking sections above each other*/
        position: relative;
    }

    /*Hide all except first section*/
    #msform section:not(:first-of-type) {
        display: none;
    }

    #msform section .form-card {
        text-align: left;
        color: #9E9E9E;
    }

    #msform input,
    #msform textarea {
        /* padding: 0px 8px 4px 8px; */
        /* border: none; */
        /* border-bottom: 1px solid #f0a61e; */
        border-radius: 5px;
        margin-bottom: 25px;
        margin-top: 2px;
        width: 100%;
        box-sizing: border-box;
        font-family: montserrat;
        color: #2C3E50;
        font-size: 16px;
        letter-spacing: 1px;
    }

    #msform input:focus,
    #msform textarea:focus {
        -moz-box-shadow: none !important;
        -webkit-box-shadow: none !important;
        /* box-shadow: none !important;
   border: none; */
        font-weight: bold;
        border: 2px solid #fca52a;
        outline-width: 0;
    }

    /*Blue Buttons*/
    #msform .action-button {
        width: 100px;
        background: #fca52a;
        font-weight: bold;
        color: white;
        border: 0 none;
        border-radius: 0px;
        cursor: pointer;
        padding: 10px 5px;
        margin: 10px 5px;
    }

    #msform .action-button:hover,
    #msform .action-button:focus {
        box-shadow: 0 0 0 2px white, 0 0 0 3px #fca52a;
    }

    /*Previous Buttons*/
    #msform .action-button-previous {
        width: 100px;
        background: #616161;
        font-weight: bold;
        color: white;
        border: 0 none;
        border-radius: 0px;
        cursor: pointer;
        padding: 10px 5px;
        margin: 10px 5px;
    }

    #msform .action-button-previous:hover,
    #msform .action-button-previous:focus {
        box-shadow: 0 0 0 2px white, 0 0 0 3px #616161;
    }

    /*Dropdown List Exp Date*/
    select.list-dt {
        border: none;
        outline: 0;
        border-bottom: 1px solid #ccc;
        padding: 2px 5px 3px 5px;
        margin: 2px;
    }

    select.list-dt:focus {
        border-bottom: 2px solid #fca52a;
    }

    /*The background card*/
    .card {
        z-index: 0;
        border: none;
        border-radius: 0.5rem;
        position: relative;
    }

    /*section headings*/
    .fs-title {
        font-size: 25px;
        color: #2C3E50;
        margin-bottom: 10px;
        font-weight: bold;
        text-align: left;
    }

    /*progressbar*/
    #progressbar {
        margin-bottom: 30px;
        overflow: hidden;
        color: lightgrey;
    }

    #progressbar .active {
        color: #000000;
    }

    #progressbar li {
        list-style-type: none;
        font-size: 12px;
        width: 25%;
        float: left;
        position: relative;
    }

    /*Icons in the ProgressBar*/
    #progressbar #account:before {
        font-family: FontAwesome;
        content: "\f06b";
    }

    #progressbar #personal:before {
        font-family: FontAwesome;
        content: "\f007";
    }

    #progressbar #payment:before {
        font-family: FontAwesome;
        content: "\f09d";
    }

    #progressbar #spayment:before {
        font-family: FontAwesome;
        content: "\f09d";
    }

    #progressbar #confirm:before {
        font-family: FontAwesome;
        content: "\f00c";
    }

    /*ProgressBar before any progress*/
    #progressbar li:before {
        width: 50px;
        height: 50px;
        line-height: 45px;
        display: block;
        font-size: 18px;
        color: #ffffff;
        background: lightgray;
        border-radius: 50%;
        margin: 0 auto 10px auto;
        padding: 2px;
    }

    /*ProgressBar connectors*/
    #progressbar li:after {
        content: '';
        width: 100%;
        height: 2px;
        background: lightgray;
        position: absolute;
        left: 0;
        top: 25px;
        z-index: -1;
    }

    /*Color number of the step and the connector before it*/
    #progressbar li.active:before,
    #progressbar li.active:after {
        background: #fca52a;
    }

    /*Imaged Radio Buttons*/
    .radio-group {
        position: relative;
        margin-bottom: 25px;
    }

    .radio {
        display: inline-block;
        width: 204;
        height: 104;
        border-radius: 0;
        background: lightblue;
        box-shadow: 0 2px 2px 2px rgba(0, 0, 0, 0.2);
        box-sizing: border-box;
        cursor: pointer;
        margin: 8px 2px;
    }

    .radio:hover {
        box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, 0.3);
    }

    .radio.selected {
        box-shadow: 1px 1px 2px 2px rgba(0, 0, 0, 0.1);
    }

    /*Fit image in bootstrap div*/
    .fit-image {
        width: 100%;
        object-fit: cover;
    }

    button:disabled {
        background-color: #ccc;
        /* Light gray background */
        color: #666;
        /* Darker gray text */
        border: 1px solid #999;
        /* Gray border */
        cursor: not-allowed;
        /* Change cursor to indicate it's disabled */
    }

    /* Deepak Css */
    .right-content {
        float: right;

        .btn-outline-warning {
            width: 80px;
        }
    }

    .button_width {
        width: 80px;
    }

</style>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h3 class="mb-0">Giftcards Sale</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ url('admin-dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Giftcards Sale</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<main class="app-main">

    <!--end::App Content Header-->
    <!--begin::App Content-->
    <div class="app-content">
        <!-- MultiStep Form -->
        <div class="container-fluid" id="grad1">
            <div class="row justify-content-center mt-0">
                <div class="col-11 col-sm-9 col-md-7 col-lg-6 text-center p-0 mt-3 mb-2">
                    <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                        <h2><strong>Send Gift Cards</strong></h2>
                        <p>Fill all form field to go to next step</p>

                        <div class="button-group ml-6 mb-4">
                            <button type="button"  class="btn btn-block btn-light active" id="someone"
                                onclick="giftCardSentType('someone')"><i class="fa fa-gift" aria-hidden="true"></i>
                                Someone else</button>
                            <button type="button"  class="btn btn-block btn-light" id="self" onclick="giftCardSentType('self')"><i
                                    class="fa fa-user" aria-hidden="true"></i> Yourself</button>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mx-0">
                                <input type="hidden" value="" id="fix_amount" class="fix_amount"
                                    placeholder="fix Amount">
                                <input type="hidden" value="" id="giftcard_amount" class="giftcard_amount"
                                    placeholder="pay Amount Without Discount">
                                <input type="hidden" value="" name="discount" id="discount" class="discount"
                                    placeholder="discount">
                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form id="msform" class="some_one_else_div" Method="post"
                                    action="{{ route('giftcard-purchase') }}">
                                    @csrf
                                    <!-- progressbar -->
                                    <ul id="progressbar">
                                        <li class="active" id="account"><strong>Account</strong></li>
                                        <li id="personal"><strong>Personal</strong></li>
                                        <li id="payment"><strong>Payment</strong></li>
                                        <li id="confirm"><strong>Finish</strong></li>
                                    </ul>
                                    <!-- sections -->
                                    <section id="o_one">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <span class="giftlist">$25 gift card</span>
                                                <div class="right-content">
                                                    <span class="giftamount">$25</span>
                                                    <button  class="btn btn-warning" type="button"
                                                        onclick="fixamount(25, this)">Buy</button>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <span class="giftlist">$50 gift card</span>
                                                <div class="right-content">
                                                    <span class="giftamount">$50</span>
                                                    <button  class="btn btn-warning" type="button"
                                                        onclick="fixamount(50, this)">Buy</button>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <span class="giftlist">$75 gift card</span>
                                                <div class="right-content">
                                                    <span class="giftamount">$75</span>
                                                    <button  class="btn btn-warning" type="button"
                                                        onclick="fixamount(75, this)">Buy</button>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <span class="giftlist">$100 gift card</span>
                                                <div class="right-content">
                                                    <span class="giftamount">$100</span>
                                                    <button  class="btn btn-warning" type="button"
                                                        onclick="fixamount(100, this)">Buy</button>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <span class="giftlist">Choose an amount…</span>
                                                <div class="row">
                                                    <div class="col-md-10" style="max-width: 90%;">
                                                        <input class="form-control" type="number" name="amount"
                                                            onkeyup="CustomeamountOther()" onkeydown="hidebutton()"
                                                            step="1" min="25" max="2000" id="customeamount_other"
                                                            size="8" placeholder="$25"
                                                            onkeypress="return (event.charCode != 8 && event.charCode == 0 || (event.charCode >= 48 && event.charCode <= 57))">
                                                    </div>
                                                    {{-- <div class="col-md-2">
                                                       <button  class="btn btn-warning right-content button_width" type="button" onclick="CustomeamountOther()">Buy</button>
                                                   </div> --}}
                                                </div>
                                                <span class="text-danger amounterror"></span>
                                            </li>
                                            <p class="p-2">Give the gift of rejuvenation and relaxation with a Medspa
                                                gift card - perfect for you and your friends!</p>
                                        </ul>
                                        <input type="button" id="check_amount_other_button" name="next" class="next action-button" 
    onclick="$('#personal').addClass('active'); $('#payment').removeClass('active');" value="Next Step" />


                                    </section>

                                    <section id="o_two">
                                        <div class="form-card">
                                            <h2 class="qtyshow" class="text-warning"></h2>
                                            <div class="row">
                                                <!-- /ko -->
                                                <div class="mb-3 col-lg-12 self">
                                                    <label for="to_1" class="form-label">Quantity</label>
                                                    <select class="form-control giftcard_qty" name="qty" id="qty"
                                                        onchange="qtychange()">
                                                        @for($i=1; $i<=10;$i++)
                                                            <option value="{{ $i }}"
                                                                {{ $i==1?'selected':'' }}>
                                                                {{ $i }}</option>
                                                        @endfor
                                                    </select>

                                                    <input type="hidden" name="user_token" value="FOREVER-MEDSPA"
                                                        class="user_token">
                                                </div>
                                                <div class="mb-3 col-lg-6 self">
                                                    <label for="your_name" class="form-label">Sender Name<span
                                                            class="text-danger">*</span></label>
                                                <input class="form-control" type="text" name="your_name" value="{{ $patient->fname ?? '' }} {{ $patient->lname ?? '' }}"
                                                        placeholder="From Name" id="your_name" autocomplete="off">
                                                    <span id="your_name_error" class="text-danger"></span>
                                                </div>
                                                <div class="mb-3 col-lg-6" id="giftSendByEmail">
                                                    <label for="receipt_email" class="form-label"><b>Sender Email<span
                                                                class="text-danger">*</span></b></label>
                                                    <input class="form-control" type="email" name="receipt_email"
                                                        value="{{$patient->email ?? ''}}"
                                                        placeholder="Sender's Email address (for the receipt)"
                                                        id="receipt_email" autocomplete="off">
                                                    <span id="receipt_email_error" class="text-danger"></span>
                                                </div>
                                                <div class="mb-3 col-lg-6">
                                                    <label for="recipient_name" class="form-label">Receiver Name<span
                                                            class="text-danger">*</span></label>
                                                    <input class="form-control" type="text" name="recipient_name"
                                                        value="" placeholder="To Name" id="recipient_name"
                                                        autocomplete="off">
                                                    <span id="recipient_name_error" class="text-danger"></span>
                                                </div>
                                                <div class="mb-3 col-lg-6" id="giftSendByEmail">
                                                    <label for="gift_send_to" class="form-label"><b>Receiver Email<span
                                                                class="text-danger">*</span></b></label>
                                                    <input class="form-control" type="email" name="gift_send_to"
                                                        value="" placeholder="Recipient Email Address"
                                                        id="gift_send_to" autocomplete="off">
                                                    <span id="gift_send_to_error" class="text-danger"></span>
                                                </div>
                                                <div class="mb-3 col-lg-12">
                                                    <label for="message" class="form-label">Message</label>
                                                    <textarea name="message" id="message" autocomplete="off" rows="4"
                                                        class="form-control"></textarea>
                                                </div>
                                                <div id="emailfields">
                                                    
                                                    
                                                    <div class="mb-3 col-lg-12">
                                                        <label for="future_yes">
                                                            <input type="radio" id="future_yes" value="yes"
                                                                name="future_status" onclick="futureDate()"
                                                                autocomplete="off"> Send on a future date
                                                        </label>
                                                        <label for="future_no">
                                                            <input type="radio" id="future_no" value="no" checked
                                                                name="future_status" onclick="futureDate()"
                                                                autocomplete="off"> Send instantly
                                                        </label>
                                                    </div>

                                                    <div class="mb-3 col-lg-12" id="future_date_section">
                                                        <label for="in_future" class="form-label">Select Date</label>
                                                        <input class="form-control" id="in_future" type="date"
                                                            name="in_future" autocomplete="off">
                                                        <span id="error_msg" class="text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="mb-3 col-lg-8">
                                                    <input class="text-uppercase form-control" type="text"
                                                        placeholder="Have a promo code?"
                                                        onkeyup="calculateWithoutGiftcard()" name="coupon_code"
                                                        id="coupon_code">
                                                </div>
                                                <div class="col-lg-4">
                                                    <button  class="btn btn-warning couponValidate" type="button"
                                                        onclick="CheckCoupon()">Apply Code</button>
                                                </div>
                                            </div>



                                            <div class="text-success Coupon_success" style="margin-left: 20px;"></div>
                                            <div class="text-danger Coupon_error" style="margin-left: 20px;"></div>



                                        </div>
                                        <input type="button" name="previous" onclick="hidebutton()"
                                            class="previous action-button-previous hide_button" value="Go Back" />
                                        <input type="button" name="next" class="action-button"
                                            onclick="finalcalculation()" value="Next Step" />
                                    </section>
                                    <section id="o_three">
                                        <div class="form-card">
                                            <h2 class="fs-title">Transaction Amount</h2>

                                            <label class="pay">Take Transaction Amount</label>
                                            <input type="text" name="transaction_amount"
                                                class="form-control transaction_amount" value="" readonly>
                                            <input type="hidden" value="" name="discount" class="fdiscount"
                                                placeholder="discount">
                                            <input type="hidden" id="amount_input" name="amount">
                                        </div>

                                        <input type="button" name="previous" class="previous action-button-previous"
                                            value="Go Back" />
                                        <input type="button" name="next" class="next action-button" value="Next Step" />
                                    </section>
                                    <section id="o_four">
                                        <div class="form-card">
                                            <h2 class="fs-title">Payment Status</h2>

                                            <label class="pay">Select Payment Status</label>
                                            <select class="form-control" name="payment_status" id="payment_status">
                                                <option value="succeeded">Succeeded</option>
                                                <option value="processing">Under Process</option>
                                            </select>
                                        </div>
                                        <button type="button" class="previous btn btn-dark action-button-previous">Go
                                            Back</button>
                                        <input type="submit" name="cok" value="Submit"  class="btn btn-success" style="width: 50%;
                                       font-weight: bold;
                                       color: white;
                                       border: 0 none;
                                       border-radius: 0px;
                                       cursor: pointer;
                                       padding: 10px 5px;
                                       margin: 10px 5px;" Name="Submit"
                                            style="margin-top: 15px; border-radius: 6px; width: 130px;"
                                            onclick="this.value='Please Wait ...';alert('Please press Ok to print the invoice');" />
                                        <span class="error_message"></span>
                                    </section>
                                </form>
                                {{-- For Self Purchase Form --}}
                                <form id="msform" class="self_div" Method="post"
                                    action="{{ route('giftcard-purchase') }}">
                                    @csrf
                                    <!-- progressbar -->
                                    <ul id="progressbar">
                                        <li class="active" id="account"><strong>Account</strong></li>
                                        <li id="personal"><strong>Personal</strong></li>
                                        <li id="spayment"><strong>Payment</strong></li>
                                        <li id="confirm"><strong>Finish</strong></li>
                                    </ul>
                                    <!-- sections -->
                                    <section id="o_five">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <span class="giftlist">$25 gift card</span>
                                                <div class="right-content">
                                                    <span class="giftamount">$25</span>
                                                    <button  class="btn btn-warning" type="button"
                                                        onclick="fixamount(25, this)">Buy</button>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <span class="giftlist">$50 gift card</span>
                                                <div class="right-content">
                                                    <span class="giftamount">$50</span>
                                                    <button  class="btn btn-warning" type="button"
                                                        onclick="fixamount(50, this)">Buy</button>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <span class="giftlist">$75 gift card</span>
                                                <div class="right-content">
                                                    <span class="giftamount">$75</span>
                                                    <button  class="btn btn-warning" type="button"
                                                        onclick="fixamount(75, this)">Buy</button>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <span class="giftlist">$100 gift card</span>
                                                <div class="right-content">
                                                    <span class="giftamount">$100</span>
                                                    <button  class="btn btn-warning" type="button"
                                                        onclick="fixamount(100, this)">Buy</button>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <span class="giftlist">Choose an amount…</span>
                                                <div class="row">
                                                    <div class="col-md-10" style="max-width: 90%;">
                                                        <input class="form-control" type="number" step="1" name="amount"
                                                            min="25" max="2000" id="customeamount_self"
                                                            onkeyup="CustomeamountSelf()" onkeydown="hidebutton()"
                                                            size="8" placeholder="$25"
                                                            onkeypress="return (event.charCode != 8 && event.charCode == 0 || (event.charCode >= 48 && event.charCode <= 57))">
                                                    </div>
                                                    {{-- <div class="col-md-2">
                                                       <button  class="btn btn-warning right-content button_width" type="button" onclick="CustomeamountSelf()">Buy</button>
                                                   </div> --}}
                                                </div>
                                                <span class="text-danger amounterror"></span>
                                            </li>
                                            <p class="p-2">Give the gift of rejuvenation and relaxation with a Medspa
                                                gift card - perfect for you and your friends!</p>
                                        </ul>

                                        <input type="button" id="check_amount_self_button" name="next"
                                            class="next action-button" value="Next Step" />
                                    </section>
                                    <section id="o_six">
                                        <div class="form-card">
                                            <h2 class="qtyshow" class="text-warning"></h2>


                                            <div>
                                                <div class="row">
                                                    <div class="mb-3 col-lg-12 self">
                                                        <label for="to_1" class="form-label">Quantity</label>
                                                        <select class="form-control giftcard_qty" id="sqty"
                                                            onchange="oqtychange()" name="qty">
                                                            @for($i=1; $i<=10;$i++)
                                                                <option value="{{ $i }}"
                                                                    {{ $i==1?'selected':'' }}>
                                                                    {{ $i }}</option>
                                                            @endfor
                                                        </select>

                                                        <input type="hidden" name="user_token" value="FOREVER-MEDSPA"
                                                            class="user_token" readonly>
                                                    </div>
                                                    <div class="mb-3 col-lg-12 self">
                                                        <label for="syour_name" class="form-label">Your Name<span
                                                                class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" name="your_name"
                                                            value="{{ $patient->fname ?? '' }} {{ $patient->lname ?? '' }}" placeholder="From Name" id="syour_name"
                                                            autocomplete="off">
                                                        <span id="syour_name_error" class="text-danger"></span>
                                                    </div>
                                                    <div class="mb-3 col-lg-12 mt-2" id="giftSendByEmail">
                                                        <label for="to_email_1" class="form-label"><b>What email address
                                                                should we send the gift card to?<span
                                                                    class="text-danger">*</span></b></label>
                                                        <input class="form-control" type="email" name="gift_send_to"
                                                            value="{{$patient->email ?? ''}}" placeholder="Enter Your Email" id="sto_email"
                                                            autocomplete="off">
                                                        <span id="sgift_send_to_error" class="text-danger"></span>
                                                    </div>

                                                    <div class="col-lg-8">
                                                        <input class="text-uppercase form-control" type="text"
                                                            placeholder="Have a promo code?"
                                                            onkeyup="scalculateWithoutGiftcard()" name="coupon_code"
                                                            id="scoupon_code" message="">
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <button  class="btn btn-warning right-content" type="button"
                                                            onclick="SCheckCoupon()">Apply Code</button>
                                                    </div>
                                                    <div class="text-success Coupon_success" style="margin-left: 20px;">
                                                    </div>
                                                    <div class="text-danger Coupon_error" style="margin-left: 20px;">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <input type="button" name="previous" class="previous action-button-previous"
                                            onclick="hidebutton()" value="Go Back" />
                                        <input type="button" name="next" class="action-button"
                                            onclick="sfinalcalculation()" value="Next Step" />
                                    </section>
                                    <section id="o_seven">
                                        <div class="form-card">
                                            <h2 class="fs-title">Transaction Amount</h2>

                                            <label class="pay">Take Transaction Amount</label>
                                            <input type="text" name="transaction_amount"
                                                class="form-control transaction_amount" value="" readonly>
                                            <input type="hidden" value="" name="discount" class="fdiscount"
                                                placeholder="discount">
                                            <input type="hidden" id="samount_input" name="amount">

                                        </div>

                                        <input type="button" name="previous" class="previous action-button-previous"
                                            value="Go Back" />
                                        <input type="button" name="next" class="next action-button" value="Next Step" />
                                    </section>
                                    <section id="o_eight">
                                        <div class="form-card">
                                            <h2 class="fs-title">Payment Status</h2>

                                            <label class="pay">Select Payment Status</label>
                                            <select class="form-control" name="payment_status" id="payment_status">
                                                <option value="succeeded">Succeeded</option>
                                                <option value="processing">Under Process</option>
                                            </select>


                                        </div>

                                        <button type="button" class="previous btn btn-dark action-button-previous">Go
                                            Back</button>
                                        <input type="submit" name="cok" value="Submit"  class="btn btn-success" style="width: 50%;
                                    font-weight: bold;
                                    color: white;
                                    border: 0 none;
                                    border-radius: 0px;
                                    cursor: pointer;
                                    padding: 10px 5px;
                                    margin: 10px 5px;" Name="Submit"
                                            style="margin-top: 15px; border-radius: 6px; width: 130px;"
                                            onclick="this.value='Please Wait ...';alert('Please press Ok to print the invoice');" />

                                        <span class="error_message"></span>
                                    </section>

                                </form>
                                {{-- For Self Purchase Form --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::App Content-->
</main>


@endsection
@push('script')
    <script>
        //  All function for Giftcard For Other
        //  for fix amountset 
        function fixamount(amount, button) {
            $('#customeamount_other').val("");
            $('#customeamount_self').val("");

            // Remove 'active' class from all buttons
            var buttons = document.querySelectorAll('.btn-outline-warning');
            buttons.forEach(function (btn) {
                btn.classList.remove('active');
            });

            // Add 'active' class to the clicked button
            button.classList.add('active');
            $('#fix_amount').val(amount);
            $('.transaction_amount').val(amount);

            $(".qtyshow").html(1 + ' X ' + '$' + amount + ' Gift card');
            $('.giftcard_amount').val(amount);
            $('.discount').val(0);
            // Your existing logic here
            $('#check_amount_self_button').show();
            $('#check_amount_other_button').show();
            var selectElements = document.getElementsByClassName('giftcard_qty');
            for (var i = 0; i < selectElements.length; i++) {
                selectElements[i].value = '1';
            }
            console.log('Amount selected:', amount);
        }

        function CustomeamountOther() {
            var activeElements = document.querySelectorAll('.btn-outline-warning.active');

            // Remove the 'active' class from each element
            activeElements.forEach(function (element) {
                element.classList.remove('active');
            });

            var custome_amount = $('#customeamount_other').val();
            if (custome_amount < 25) {
                $('.amounterror').html('The Amount should be more than or equal to $25');

                return false;
            } else if (custome_amount > 2000) {
                $('.amounterror').html(
                    'Your amount is more than $2000. Please enter an amount less than or equal to $2000');
                return false;
            } else {
                $('.amounterror').html('');
            }
            $('.transaction_amount').val(custome_amount);
            $('#fix_amount').val(custome_amount);
            $('#giftcard_amount').val(custome_amount);
            $(".qtyshow").html(1 + ' X ' + '$' + custome_amount + ' Gift card');
            $('#check_amount_other_button').show();
            var selectElements = document.getElementsByClassName('giftcard_qty');
            for (var i = 0; i < selectElements.length; i++) {
                selectElements[i].value = '1';
            }

        }

        function hidebutton() {

            $('#check_amount_other_button').hide();
            $('#check_amount_self_button').hide();
        }

        function calculateWithoutGiftcard() {
            var paybelamount = $('#giftcard_amount').val();
            console.log(paybelamount);
            $('.transaction_amount').val(paybelamount);
        }

        function qtychange() {
            var qty = $('#qty').val();
            var amount = $("#fix_amount").val();
            var finalamout = qty * amount;
            $(".qtyshow").html(qty + ' X ' + '$' + amount + ' Gift card');
            $("#giftcard_amount").val(finalamout)
            $(".transaction_amount").val(finalamout)

        }
        //  for coupon validate
        function CheckCoupon() {
            var coupon_code = $('#coupon_code').val();
            var giftcard_amount = $('#giftcard_amount').val();
            if (giftcard_amount < 25) {
                alert('The Amount should be more than or equal to $25');
                return false;
            }
            if (giftcard_amount > 2000) {
                alert('Your amount is more than $2000. Please enter an amount less than or equal to $2000');
                return false;
            }

            //  For validation code 
            $.ajax({
                url: '{{ route('coupon-validate') }}',
                method: "post",
                dataType: "json",
                data: {
                    _token: '{{ csrf_token() }}',
                    coupon_code: coupon_code,
                    user_token: 'FOREVER-MEDSPA',
                    amount: giftcard_amount,
                },
                success: function (response) {
                    if (response.success) {
                        $('.Coupon_error').hide();
                        $('.Coupon_success').html(response.success).show();

                        if (response.data[0]['discount_type'] == 'amount') {
                            var discountAmount = response.data[0]['discount_rate'];
                            var afterDiscount = giftcard_amount - discountAmount;
                            $("#discount").val(parseInt(discountAmount));
                            $(".transaction_amount").val(parseInt(afterDiscount));
                            $(".fdiscount").val(parseInt(discountAmount));

                        }
                        if (response.data[0]['discount_type'] == 'percentage') {
                            var discountRate = response.data[0][
                            'discount_rate']; // Assuming discount_rate is a percentage (e.g., 10 for 10%)
                            var discountAmount = (giftcard_amount * discountRate) / 100;
                            var afterDiscount = giftcard_amount - discountAmount;
                            $("#discount").val(parseInt(discountAmount));
                            $(".transaction_amount").val(parseInt(afterDiscount));
                            $(".fdiscount").val(parseInt(discountAmount));
                        }
                    }
                    if (response.error) {
                        $('.Coupon_success').hide();
                        $('.Coupon_error').html(response.error).show();
                        $(".discount").val(0);
                        $(".transaction_amount").val(giftcard_amount);
                    }
                }
            });
        }
        //  All Function For Giftcard for other End


        //  For Self Code 
        function CustomeamountSelf() {
            var activeElements = document.querySelectorAll('.btn-outline-warning.active');
            // Remove the 'active' class from each element
            activeElements.forEach(function (element) {
                element.classList.remove('active');
            });



            var custome_amount = $('#customeamount_self').val();
            if (custome_amount < 25) {
                $('.amounterror').html('The Amount should be more than or equal to $25');
                return false;
            } else if (custome_amount > 2000) {
                $('.amounterror').html(
                    'Your amount is more than $2000. Please enter an amount less than or equal to $2000');
                return false;
            } else {
                $('.amounterror').html('');
            }
            $('#fix_amount').val(custome_amount);
            $('#giftcard_amount').val(custome_amount);

            $('.transaction_amount').val(custome_amount);
            $('#check_amount_self_button').show();
            $(".qtyshow").html(1 + ' X ' + '$' + custome_amount + ' Gift card');
            var selectElements = document.getElementsByClassName('giftcard_qty');
            for (var i = 0; i < selectElements.length; i++) {
                selectElements[i].value = '1';
            }
        }

        function oqtychange() {

            var qty = $('#sqty').val();
            var amount = $("#fix_amount").val();
            var finalamout = qty * amount;
            $(".qtyshow").html(qty + ' X ' + '$' + amount + ' Gift card');
            // $("#giftcard_amount").attr('amount', price);
            $("#giftcard_amount").val(finalamout)
            $(".transaction_amount").val(finalamout)

        }

        function scalculateWithoutGiftcard() {
            var paybelamount = $('#giftcard_amount').val();
            console.log(paybelamount);
            $('.transaction_amount').val(paybelamount);
        }

        function SCheckCoupon() {
            var coupon_code = $('#scoupon_code').val();
            var giftcard_amount = $('#giftcard_amount').val();
            if (giftcard_amount < 25) {
                alert('The Amount should be more than or equal to $25');
                return false;
            }
            if (giftcard_amount > 2000) {
                alert('Your amount is more than $2000. Please enter an amount less than or equal to $2000');
                return false;
            }

            //  For validation code 
            $.ajax({
                url: '{{ route('coupon-validate') }}',
                method: "post",
                dataType: "json",
                data: {
                    _token: '{{ csrf_token() }}',
                    coupon_code: coupon_code,
                    user_token: 'FOREVER-MEDSPA',
                    amount: giftcard_amount,
                },
                success: function (response) {
                    if (response.success) {
                        $('.Coupon_error').hide();
                        $('.Coupon_success').html(response.success).show();

                        if (response.data[0]['discount_type'] == 'amount') {
                            var discountAmount = response.data[0]['discount_rate'];
                            var afterDiscount = giftcard_amount - discountAmount;
                            $("#discount").val(parseInt(discountAmount));
                            $(".transaction_amount").val(parseInt(afterDiscount));
                            $(".fdiscount").val(parseInt(discountAmount));

                        }
                        if (response.data[0]['discount_type'] == 'percentage') {
                            var discountRate = response.data[0][
                            'discount_rate']; // Assuming discount_rate is a percentage (e.g., 10 for 10%)
                            var discountAmount = (giftcard_amount * discountRate) / 100;
                            var afterDiscount = giftcard_amount - discountAmount;
                            $("#discount").val(parseInt(discountAmount));
                            $(".transaction_amount").val(parseInt(afterDiscount));
                            $(".fdiscount").val(parseInt(discountAmount));
                        }
                    }
                    if (response.error) {
                        $('.Coupon_success').hide();
                        $('.Coupon_error').html(response.error).show();
                        $(".discount").val(0);
                        $(".transaction_amount").val(giftcard_amount);
                    }
                }
            });
        }
        //  Self Section Code End



        function hidebutton() {
            $('#check_amount_other_button').hide();
            $('#check_amount_self_button').hide();
        }
        //  for gift

        //     For submit end forgift send for other


        $('.self_div').hide();
        $('#future_date_section').hide();
        $(document).ready(function () {
            var fix_Amount = $('#fix_amount').val();
            if (fix_Amount === '' || fix_Amount == 0) { // Corrected logical condition
                $('#check_amount_self_button').hide();
                $('#check_amount_other_button').hide();
            }

        });

        function giftCardSentType(action) {
            if (action == 'someone') {
                $("#fix_amount").val(0);
                $('#someone').addClass('active');
                $('#self').removeClass('active');
                //   $('#self_div').hide();
                $('.self_div').css('display', 'none');
                $('.some_one_else_div').css('display', 'block');
                $('#check_amount_other_button').hide();

            }
            if (action == 'self') {
                $("#fix_amount").val(0);
                $('#someone').removeClass('active');
                $('#self').addClass('active');
                //   $('#self_div').show();
                //   $('#some_one_else_div').hide();
                $('.self_div').css('display', 'block');
                $('.some_one_else_div').css('display', 'none');
                $('#check_amount_self_button').hide();
            }
        }



        function futureDate() {
            // Get the selected radio button
            var selectedValue = document.querySelector('input[name="future_status"]:checked').value;
            if ($('#future_yes').is(':checked')) {
                $('#future_date_section').show();
            }
            if ($('#future_no').is(':checked')) {
                $('#future_date_section').hide();

            }

        }

    </script>
    <script>
        $(document).ready(function () {

            var current_fs, next_fs, previous_fs; //sections
            var opacity;

            $(".next").click(function () {

                current_fs = $(this).parent();
                next_fs = $(this).parent().next();

                //Add Class Active
                $("#progressbar li").eq($("section").index(next_fs)).addClass("active");

                //show the next section
                next_fs.show();
                //hide the current section with style
                current_fs.animate({
                    opacity: 0
                }, {
                    step: function (now) {
                        // for making fielset appear animation
                        opacity = 1 - now;

                        current_fs.css({
                            'display': 'none',
                            'position': 'relative'
                        });
                        next_fs.css({
                            'opacity': opacity
                        });
                    },
                    duration: 600
                });
            });

            $(".previous").click(function () {

                current_fs = $(this).parent();
                previous_fs = $(this).parent().prev();

                //Remove class active
                $("#progressbar li").eq($("section").index(current_fs)).removeClass("active");

                //show the previous section
                previous_fs.show();

                //hide the current section with style
                current_fs.animate({
                    opacity: 0
                }, {
                    step: function (now) {
                        // for making fielset appear animation
                        opacity = 1 - now;

                        current_fs.css({
                            'display': 'none',
                            'position': 'relative'
                        });
                        previous_fs.css({
                            'opacity': opacity
                        });
                    },
                    duration: 600
                });
            });

            $('.radio-group .radio').click(function () {
                $(this).parent().find('.radio').removeClass('selected');
                $(this).addClass('selected');
            });

            $(".submit").click(function () {
                return false;
            })

        });

        function finalcalculation() {
            if (validateForm()) {
                // If validation passes, hide the current section and show the next section
                document.getElementById('o_two').style.display = 'none';
                // Assuming the next section has an id of 'nextSection'
                document.getElementById('o_three').style.display = 'block';
               
            }
            $('#payment').addClass('active');
            var amount = $('#fix_amount').val();
            $('#amount_input').val(amount);
            $('#samount_input').val(amount);
        };


        function validateForm() {
            var isValid = true;

            var yourName = document.getElementById('your_name').value.trim();
            var recipientName = document.getElementById('recipient_name').value.trim();
            var email = document.getElementById('gift_send_to').value.trim();
            var remail = document.getElementById('receipt_email').value.trim();

            // Reset error messages
            document.getElementById('your_name_error').innerHTML = '';
            document.getElementById('recipient_name_error').innerHTML = '';
            document.getElementById('gift_send_to_error').innerHTML = '';
            document.getElementById('receipt_email_error').innerHTML = '';

            // Validate "Your Name" field
            if (yourName === '') {
                document.getElementById('your_name_error').innerHTML = 'Please enter your name.';
                isValid = false;
            }
            if (recipientName === '') {
                document.getElementById('recipient_name_error').innerHTML = 'Please Enter Recipient name';
                isValid = false;
            }

            // Validate "Recipient Email" field
            if (email === '') {
                document.getElementById('gift_send_to_error').innerHTML = 'Please enter the recipient email address.';
                isValid = false;
            } else if (!validateEmail(email)) {
                document.getElementById('gift_send_to_error').innerHTML = 'Please enter a valid email address.';
                isValid = false;
            }
            // Validate "Sender Email" field
            if (remail === '') {
                document.getElementById('receipt_email_error').innerHTML = 'Please enter the Sender email address.';
                isValid = false;
            } else if (!validateEmail(remail)) {
                document.getElementById('receipt_email_error').innerHTML = 'Please enter a valid email address.';
                isValid = false;
            }

            // Add more validation rules as needed

            return isValid;
        }

        function validateEmail(email) {
            var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }



        //  Self For Validation Code 
        function sfinalcalculation() {
            if (self_section_validateForm()) {
                // If validation passes, hide the current section and show the next section
                document.getElementById('o_six').style.display = 'none';
                // Assuming the next section has an id of 'nextSection'
                document.getElementById('o_seven').style.display = 'block';
                $('#spayment').addClass("active");

            }
            var amount = $('#fix_amount').val();
            $('#amount_input').val(amount);
            $('#samount_input').val(amount);
        };


        function self_section_validateForm() {
            var isValid = true;

            var yourName = document.getElementById('syour_name').value.trim();
            var email = document.getElementById('sto_email').value.trim();

            // Reset error messages
            document.getElementById('syour_name_error').innerHTML = '';
            document.getElementById('sgift_send_to_error').innerHTML = '';


            // Validate "Your Name" field
            if (yourName === '') {
                document.getElementById('syour_name_error').innerHTML = 'Please enter your name.';
                isValid = false;
            }

            // Validate "Recipient Email" field
            if (email === '') {
                document.getElementById('sgift_send_to_error').innerHTML = 'Enter Your email address.';
                isValid = false;
            } else if (!validateEmail(email)) {
                document.getElementById('sgift_send_to_error').innerHTML = 'Please enter a valid email address.';
                isValid = false;
            }
            // Add more validation rules as needed

            return isValid;
        }

        function validateEmail(email) {
            var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

    </script>

<script>
$(document).ready(function () {
    function setupAutocomplete(inputField) {
        $(inputField).autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "{{route('email-suggestions')}}", // Laravel route to fetch emails
                    type: "GET",
                    data: {
                        query: request.term
                    },
                    dataType: "json",
                    success: function (data) {
                        response(data);
                    },
                    error: function () {
                        console.error("Error fetching email suggestions.");
                    }
                });
            },
            minLength: 2, // Start suggesting after 2 characters
            select: function (event, ui) {
                $(inputField).val(ui.item.value);
                return false;
            }
        });
    }

    // Apply autocomplete to both email fields
    setupAutocomplete("#receipt_email"); // Sender Email
    setupAutocomplete("#gift_send_to"); // Receiver Email
});
// For Name Search

$(document).ready(function () {
    function setupAutocomplete(inputField) {
        $(inputField).autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "{{ route('name-suggestions') }}", // Laravel route
                    type: "GET",
                    data: {
                        query: request.term
                    },
                    dataType: "json",
                    success: function (data) {
                        console.log("Autocomplete Data:", data); // Debugging
                        response($.map(data, function (item) {
                            return {
                                label: item.full_name, // Display full name
                                value: item.full_name // Fill input with selected name
                            };
                        }));
                    },
                    error: function (xhr, status, error) {
                        console.error("Error fetching name suggestions:", error);
                    }
                });
            },
            minLength: 2, // Start suggesting after 2 characters
            select: function (event, ui) {
                $(inputField).val(ui.item.value); // Set the input value
                return false;
            }
        });
    }

    setupAutocomplete("#your_name"); // Sender Name
    setupAutocomplete("#recipient_name"); // Receiver Name
});

</script>


@endpush
