@extends('layouts.front-master')
@section('body')
    @push('css')
    <style>

        .container{
            min-height: 1vh !important;
        }
        
        .main_box_coupon {
        background-image: url('{{ url('/giftcards/images/coupon.png') }}');
        width: 570px;
        height: 107px;
        align-items: center;
        justify-content: center;
        }
        .main_box_coupon .box_coupon {
        float: right;
        display: flex;
        width: 100%;
        justify-content: end !important;
        }
        .main_box_coupon .single-coupon-content {
        margin-top: 0px;
        }
        #gift_card_code {
        height: 45px; 
        border-radius: 5px;
        }
        .btn-warning {
        background-color: #ffc107;
        border: none;
        font-weight: bold;
        }

    </style>      

    <style>
        
.card {
  width: 100%;
  max-width: 500px;
  margin: 0 auto 16px auto;
  padding: 24px 12px;
  box-sizing: border-box;
  background: #fff;
}

@media (max-width: 576px) {

.row{
    padding-top: 30px !important;
  }
.container{
    min-height: 1vh !important;
  }
  .card {
    max-width: 98vw;
    min-width: 90vw;
    padding: 16px 4px;
    border-radius: 12px;
    box-shadow: 0 3px 12px rgba(0,0,0,0.08);
  }

  .main_box_coupon {
    display: block;
    width: 100%;
    min-width: 90vw;
    max-width: 100vw;
    min-height: 90px;
    height: auto;
    padding: 12px 6px;
    margin: 0 auto 12px auto;
    box-sizing: border-box;
    background-size: cover;
    flex-direction: column !important;
  }

  .main_box_coupon .box_coupon, .main_box_coupon .single-coupon-content {
    flex-direction: column !important;
    width: 100%;
    text-align: center;
    align-items: center;
    justify-content: center !important;
    margin: 0 auto;
  }
  .main_box_coupon .col-md-3,
  .main_box_coupon .col-md-5,
  .main_box_coupon .col-md-4 {
    width: 100% !important;
    margin: 0 auto 8px auto;
    text-align: center !important;
    float: none !important;
  }
  
  .list-group-item {
    /* flex-direction: column !important; */
    /* align-items: flex-start !important; */
  }
  
  input, button, select, textarea {
    width: 100% !important;
    font-size: 1rem;
    margin-bottom: 8px;
  }
  
  #progressbar {
    flex-direction: column;
    align-items: center;
    padding-left: 0;
  }
  
  .modal-dialog {
    max-width: 98vw;
    margin: 2vw auto;
  }
  .table th{
    max-width: 100px !important;
}
}
@media (max-width: 350px) {
  .card, .main_box_coupon {
    min-width: 95vw;
    padding: 2px;
    }
  .table th{
    max-width: 100px !important;
    }
  
}

    </style>


    <style>
        /* Radio options responsiveness */
@media (max-width: 768px) {
    .row .col-md-8,
    .row .col-md-6 {
        flex: 1 1 100%;
        max-width: 100%;
        margin-bottom: 10px;
    }

    .form-check-input {
        transform: scale(1.3) !important; /* slightly smaller for mobile */
        /* margin-right: 8px !important; */
        margin-left: 0.65rem !important;
    }

    .form-check-label {
        font-size: 16px !important;
        line-height: 1.4;
    }
}

/* For very small screens */
@media (max-width: 480px) {
    .form-check-label {
        font-size: 15px !important;
    }

    .form-check-input {
        transform: scale(1.2) !important;
    }
}
    </style>

    @endpush

    @push('csslink')
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        {{-- <link rel="stylesheet" href="{{ url('/') }}/giftcards/css/bootstrap.min.css"> --}}
        <!-- Pogo Slider CSS -->
        <link rel="stylesheet" href="{{ url('/') }}/giftcards/css/pogo-slider.min.css">
        <!-- Site CSS -->
        <link rel="stylesheet" href="{{ url('/') }}/giftcards/css/style.css">
        <!-- Responsive CSS -->
        <link rel="stylesheet" href="{{ url('/') }}/giftcards/css/responsive.css">
        <!-- Custom CSS -->
        <link rel="stylesheet" href="{{ url('/') }}/giftcards/css/custom.css">
    @endpush
    <!-- wish -->
    <div class="about-box" style="padding-bottom: 0;">
        <div class="about-a1">
            <div class="container">
                <input type="hidden" id="user_token"value="FOREVER-MEDSPA" placeholder="" />
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="row align-items-center about-main-info">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <h2><b>Giftcards made simple </b>
                                    {{-- {{dd(Session::get('patient_details'))}} --}}
                                </h2>
                                <p style="text-align: justify;">We're thrilled to express our gratitude to the loyal
                                    customers of MedSpa Wellness centre, with our ! Whether it's a token of appreciation, a
                                    celebration, or a simple gesture of kindness, our gift cards provide the perfect
                                    opportunity to share the joy of our products and services. Delight your loved ones with
                                    the freedom to explore and indulge in what they love most. With each gift card, we're
                                    extending our heartfelt thanks for your continued support and patronage. Spread the joy
                                    and make someone's day a little brighter with our gift cards
                                </p>
                                @if (isset($coupon_code) && count($coupon_code) > 0)
                                    <hr>
                                    <h4 class="mt-2 mb-2">Get your Coupon and Save more!</h4>
                                    <hr>
                                    @foreach ($coupon_code as $key => $value)
                                        @if ($key < 5)
                                            <div class="row main_box_coupon mt-2">
                                                <div class="col-md-3"></div>
                                                <div class="col-md-5">
                                                    <strong
                                                        style="margin-left: 2px;margin-right: 2px;font-size:20px;text-align: center;"><u>{{ $value->title ? $value->title : '' }}</u></strong>
                                                    <p
                                                        style="font-weight: 700;margin-left: 5px;margin-right: 18px;text-align: center;">
                                                        {{ $value->title ? $value->redeem_description : '' }}
                                                    </p>
                                                </div>
                                                <div class="col-md-4" style="text-align:center">
                                                    <span class="mt-2">
                                                        Coupon Code
                                                        <h3>
                                                            <b>{{ $value->title ? $value->coupon_code : '' }}</b>
                                                        </h3>
                                                    </span>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 text_align_center">
                                <div>
                                    @if (session()->has('message'))
                                        {{ session()->get('message') }}
                                    @endif
                                    <!-- MultiStep Form -->
                                    <div class="row justify-content-center mt-0">
                                        <div class="col-11 col-sm-9 col-md-7 col-lg-11 text-center p-0 mt-3 mb-2">
                                            <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                                                <h2><strong>Send Gift Cards</strong></h2>
                                                <p>Fill all form field to go to next step</p>
                                                <div class="row">
                                                    <div class="col-md-12 mx-0">
                                                        <div id="msform">
                                                            <!-- progressbar -->
                                                            <ul id="progressbar">
                                                                <li class="active" id="gift"><strong>Gift</strong></li>
                                                                <li id="personal"><strong>Personal</strong></li>
                                                                <li id="payment"><strong>Payment</strong></li>
                                                                {{-- 
                                             <li id="confirm"><strong>Finish</strong></li>
                                             --}}
                                                            </ul>
                                                            <!-- fieldsets -->
                                                            <fieldset id="firstbox">
                                                                <ul class="list-group">
                                                                    <!-- Gift card items -->
                                                                    <li
                                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                                        <span class="giftlist">$25 gift card</span>
                                                                        <span class="d-flex align-items-center">
                                                                            <span class="giftamount me-3">$25</span>
                                                                            <button class="btn btn-outline-warning"
                                                                                type="button"
                                                                                onclick="fixamount(25)">Buy</button>
                                                                        </span>
                                                                    </li>
                                                                    <li
                                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                                        <span class="giftlist">$50 gift card</span>
                                                                        <span class="d-flex align-items-center">
                                                                            <span class="giftamount me-3">$50</span>
                                                                            <button class="btn btn-outline-warning"
                                                                                type="button"
                                                                                onclick="fixamount(50)">Buy</button>
                                                                        </span>
                                                                    </li>
                                                                    <li
                                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                                        <span class="giftlist">$75 gift card</span>
                                                                        <span class="d-flex align-items-center">
                                                                            <span class="giftamount me-3">$75</span>
                                                                            <button class="btn btn-outline-warning"
                                                                                type="button"
                                                                                onclick="fixamount(75)">Buy</button>
                                                                        </span>
                                                                    </li>
                                                                    <li
                                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                                        <span class="giftlist">$100 gift card</span>
                                                                        <span class="d-flex align-items-center">
                                                                            <span class="giftamount me-3">$100</span>
                                                                            <button class="btn btn-outline-warning"
                                                                                type="button"
                                                                                onclick="fixamount(100)">Buy</button>
                                                                        </span>
                                                                    </li>
                                                                    <!-- Custom amount input -->
                                                                    <li class="list-group-item">
                                                                        <!-- Label Section (Responsive) -->
                                                                        <div class="mb-3">
                                                                            <h6 class="mb-0">Choose a Custom Amount:</h6>
                                                                            <small class="text-muted d-block mb-2">Enter an
                                                                                amount between $25 and $2000.</small>
                                                                        </div>
                                                                        <!-- Input Field Section -->
                                                                        <div class="input-group w-100">
                                                                            <input type="number" step="1"
                                                                                min="25" max="2000"
                                                                                id="customeamount" class="form-control"
                                                                                
                                                                                onkeypress="return (event.charCode >= 48 && event.charCode <= 57)"
                                                                                aria-label="Custom amount"
                                                                                style="margin-top: 25px;">
                                                                        </div>
                                                                        <!-- Buy Button Section -->
                                                                        <div class="mt-3">
                                                                            <button
                                                                                class="btn btn-outline-warning w-100 w-md-auto"
                                                                                type="button"
                                                                                onclick="customeamount()">Buy</button>
                                                                        </div>
                                                                    </li>
                                                                    <!-- Additional content -->
                                                                    <p class="p-4">Give the gift of rejuvenation and
                                                                        relaxation with a Medspa gift card - perfect for you
                                                                        and your friends!
                                                                    </p>
                                                                    <p class="text-warning p-4" onclick="checkbalance()"
                                                                        href="javascript:void(0)">Check your gift card
                                                                        balance
                                                                    </p>
                                                                </ul>
                                                                {{-- <input type="button" name="next" class="next" value="Next Step"/> --}}
                                                            </fieldset>

                                                            <fieldset id="secondbox">
                                                                <h2 id="amountdisplay" amount="0" finalAmount="0"
                                                                    coupondiscount="0"></h2>
                                                                <p>For use at Forever Medspa Clinic</p>
                                                                <div
                                                                    class="button-group ml-4 d-flex justify-content-between">
                                                                    <button type="button"
                                                                        class="btn btn-light flex-fill active"
                                                                        id="someone" onclick="someOneElse('someone')">
                                                                        <i class="fa fa-gift" aria-hidden="true"></i>
                                                                        Someone else
                                                                    </button>
                                                                    <button type="button" class="btn btn-light flex-fill"
                                                                        id="self" onclick="someOneElse('self')">
                                                                        <i class="fa fa-user" aria-hidden="true"></i>
                                                                        Yourself
                                                                    </button>
                                                                </div>


                                                                <form id="someoneform" method="post"
                                                                    enctype="multipart/form-data" class="p-4 text-left">
                                                                    @csrf
                                                                    <div class="row">
                                                                        <!-- Quantity Field -->
                                                                        <div class="mb-3 col-lg-12 col-md-12">
                                                                            <label for="to_1"
                                                                                class="form-label">Quantity</label>
                                                                            <select class="form-control" name="qty"
                                                                                id="qty" onchange="qtychange()">
                                                                                @for ($i = 1; $i <= 10; $i++)
                                                                                    <option
                                                                                        value="{{ $i }}"{{ $i == 1 ? 'selected' : '' }}>
                                                                                        {{ $i }}</option>
                                                                                @endfor
                                                                            </select>
                                                                        </div>
                                                                           {{-- {{ dd(session()->all()) }} --}}
                                                                        <!-- Your Name Field -->
                                                                        <div class="mb-3 col-lg-12 col-md-12 self">
                                                                            <label for="your_name" class="form-label">Your
                                                                                name <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input class="form-control" type="text"
                                                                                name="your_name"
                                                                            value="{{ Session::has('patient_details') ? Session::get('patient_details')->fname . ' ' . Session::get('patient_details')->lname : '' }}"

"
                                                                                placeholder="From Name" id="your_name"
                                                                                autocomplete="off" required>
                                                                            <input type="hidden" value="0"
                                                                                name="template_id">
                                                                        </div>

                                                                        <!-- Recipient Name Field -->
                                                                        <div class="mb-3 col-lg-12 col-md-12">
                                                                            <label for="recipient_name"
                                                                                class="form-label">Recipient name <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input class="form-control" type="text"
                                                                                name="to_name" value=""
                                                                                placeholder="To Name" id="recipient_name"
                                                                                autocomplete="off" required>
                                                                        </div>

                                                                        <!-- Message Field -->
                                                                        <div class="mb-3 col-lg-12 col-md-12">
                                                                            <label for="message"
                                                                                class="form-label">Message <span
                                                                                    class="text-danger">*</span></label>
                                                                            <textarea name="msg" id="message" autocomplete="off" rows="4" class="form-control"></textarea>
                                                                        </div>

                                                                        <!-- Email Fields -->
                                                                        <div id="emailfields">
                                                                            <!-- Recipient Email -->
                                                                            <div class="mb-3 col-lg-12 col-md-12 mt-2"
                                                                                id="giftSendByEmail">
                                                                                <label for="recipient_email"
                                                                                    class="form-label"><b>What email
                                                                                        address should we send the gift card
                                                                                        to? <span
                                                                                            class="text-danger">*</span></b></label>
                                                                                <input class="form-control" type="email"
                                                                                    name="to_email" value=""
                                                                                    placeholder="Recipient Email Address"
                                                                                    id="gift_send_to" autocomplete="off"
                                                                                    required>
                                                                            </div>

                                                                            <!-- Sender Email -->
                                                                            <div class="mb-3 col-lg-12 col-md-12 mt-2"
                                                                                id="giftSendByEmail">
                                                                                <label for="recipient_email"
                                                                                    class="form-label"><b>Your email
                                                                                        address (for the receipt) <span
                                                                                            class="text-danger">*</span></b></label>
                                                                                <input class="form-control" type="email"
                                                                                    name="from_email"
                                                                                    value="{{ optional(Session::get('patient_details'))->email }}"

                                                                                    placeholder="Sender's Email address (for the receipt)"
                                                                                    id="recipient_email"
                                                                                    autocomplete="off" required>
                                                                            </div>

                                                                            <!-- Select Event -->
                                                                            @if (count($occassion) > 0)
                                                                                <div class="mb-3 col-lg-12 col-md-12 mt-2"
                                                                                    id="giftSendByEmail">
                                                                                    <label for="recipient_email"
                                                                                        class="form-label"><b>Select Event
                                                                                            <span
                                                                                                class="text-danger">*</span></b></label>
                                                                                    <select class="form-control"
                                                                                        id="Event_id" name="">
                                                                                        <option value="">Select Event
                                                                                        </option>
                                                                                        @foreach ($occassion as $value)
                                                                                            <option
                                                                                                value="{{ $value->id }}">
                                                                                                {{ $value->title }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                            @endif
                                                                        </div>

                                                                        <!-- Future Send Section -->
                                                                        <div class="mb-3 col-md-12">
                                                                            <label class="form-label"><b>Send In Future:
                                                                                    <span
                                                                                        class="text-danger">*</span></b></label>
                                                                        </div>

                                                                        <div class="row" style="margin-left: 20px;">
                                                                            <div
                                                                                class="col-md-8 d-flex align-items-center">
                                                                                <input class="form-check-input"
                                                                                    style="transform: scale(1.5); margin-right: 10px;"
                                                                                    type="radio" id="future_yes"
                                                                                    value="yes" name="future_status"
                                                                                    onclick="futureDate()"
                                                                                    autocomplete="off">
                                                                                <label class="form-check-label"
                                                                                    for="future_yes"
                                                                                    style="font-size: 20px;">Send on a
                                                                                    future date</label>
                                                                            </div>

                                                                            <div
                                                                                class="col-md-6 d-flex align-items-center">
                                                                                <input class="form-check-input"
                                                                                    style="transform: scale(1.5); margin-right: 10px;"
                                                                                    type="radio" id="future_no"
                                                                                    value="no" name="future_status"
                                                                                    onclick="futureDate()"
                                                                                    autocomplete="off" checked>
                                                                                <label class="form-check-label"
                                                                                    for="future_no"
                                                                                    style="font-size: 20px;">Send
                                                                                    instantly</label>
                                                                            </div>
                                                                        </div>



                                                                        <!-- Future Date Input (Visible only if "Send on a future date" is selected) -->
                                                                        <div class="mb-3 col-12 mt-2"
                                                                            id="future_date_section"
                                                                            style="display: none;">
                                                                            <label for="in_future"
                                                                                class="form-label"><b>Select
                                                                                    Date</b></label>
                                                                            <input class="form-control" id="in_future"
                                                                                type="date" name="future_date"
                                                                                autocomplete="off" required>
                                                                            <span id="error_msg"
                                                                                class="text-danger"></span>
                                                                        </div>

                                                                    </div>

                                                                    <hr />

                                                                    <!-- Promo Code Section -->
                                                                    <div class="row">
                                                                        <div
                                                                            class="mb-3 col-lg-8 col-md-12 col-sm-6 col-12">
                                                                            <input class="text-uppercase form-control"
                                                                                type="text"
                                                                                placeholder="Have a promo code?"
                                                                                id="coupon_code">
                                                                        </div>
                                                                        <div
                                                                            class="mt-4 col-lg-4 col-md-12 col-sm-6 col-12">
                                                                            <button
                                                                                class="btn btn-block btn-outline-warning"
                                                                                type="button"
                                                                                onclick="CheckCoupon()">Apply Code</button>
                                                                        </div>
                                                                        <div class="text-success"
                                                                            style="margin-left: 20px;"
                                                                            id="Coupon_success"></div>
                                                                        <div class="text-danger"
                                                                            style="margin-left: 20px;" id="Coupon_error">
                                                                        </div>
                                                                    </div>
                                                                    <input type="hidden" name="gift_card_send_type" id="gift_other"value="other">
                                                                    <!-- Submit and Back Buttons -->
                                                                    <div class="mb-3 col-lg-12 col-md-12 mt-2">
                                                                        <button class="btn btn-block btn-outline-primary"
                                                                            id="couponaply" onclick="sendsomeOneElse()"
                                                                            type="button" name="submit">Submit</button>
                                                                        <button class="btn btn-block btn-outline-warning"
                                                                            id="submitFormButton" type="button"
                                                                            onclick="firstboxshow()">Back</button>
                                                                    </div>

                                                                    <!-- Additional Info Section -->
                                                                    <div class="mb-3 col-lg-12 col-md-12">
                                                                        <p>Give the gift of rejuvenation and relaxation with
                                                                            a Medspa gift card - perfect for you and your
                                                                            friends!</p>
                                                                        <p class="text-warning p-2"
                                                                            onclick="checkbalance()"
                                                                            href="javascript:void(0)">Check your gift card
                                                                            balance</p>
                                                                    </div>
                                                                </form>

                                                                <form id="selfform" method="post"
                                                                    enctype="multipart/form-data" class="p-4 text-left">
                                                                    @csrf
                                                                    <div class="row">
                                                                        <div class="mb-3 col-12">
                                                                            <label for="to_1"
                                                                                class="form-label">Quantity</label>
                                                                            <select class="form-control" id="sqty"
                                                                                onchange="sqtychange()">
                                                                                @for ($i = 1; $i <= 10; $i++)
                                                                                    <option value="{{ $i }}"
                                                                                        {{ $i == 1 ? 'selected' : '' }}>
                                                                                        {{ $i }}
                                                                                    </option>
                                                                                @endfor
                                                                            </select>
                                                                        </div>

                                                                        <div class="mb-3 col-12">
                                                                            <label for="syour_name"
                                                                                class="form-label">Your Name <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input class="form-control" type="text"
                                                                                name="from_name"
                                                                                value="{{ Session::has('patient_details') ? Session::get('patient_details')->fname . ' ' . Session::get('patient_details')->lname : '' }}"

                                                                                placeholder="From Name" id="syour_name"
                                                                                required autocomplete="off">
                                                                            <input type="hidden" value="0"
                                                                                name="template_id">
                                                                        </div>

                                                                        

                                                                        <div class="mb-3 col-12 mt-2"
                                                                            id="giftSendByEmail">
                                                                            <label for="to_email_1"
                                                                                class="form-label"><b>What email address
                                                                                    should we send the gift card to? <span
                                                                                        class="text-danger">*</span></b></label>
                                                                            <input class="form-control" type="email"
                                                                                name="to_email"
                                                                                placeholder="Enter Your Email"
                                                                                id="sto_email" autocomplete="off"
                                                                                value="{{ Auth::guard('patient')->check() ? Auth::guard('patient')->user()->email : '' }}"

                                                                                required>
                                                                        </div>

                                                                        <div class="row mb-3 col-12 mt-2">
                                                                            <div
                                                                                class="mb-3 col-lg-8 col-md-12 col-sm-6 col-12">
                                                                                <input class="form-control text-uppercase"
                                                                                    type="text"
                                                                                    placeholder="Have a promo code?"
                                                                                    id="scoupon_code">
                                                                            </div>
                                                                            <div
                                                                                class="mb-3 col-lg-4 col-md-12 col-sm-6 col-12">
                                                                                <button
                                                                                    class="mt-4 btn btn-block btn-outline-warning"
                                                                                    type="button"
                                                                                    onclick="SelfCoupon()">Apply
                                                                                    Code</button>
                                                                            </div>
                                                                            <div class="text-success"
                                                                                style="margin-left: 20px;"
                                                                                id="SCoupon_success"></div>
                                                                            <div class="text-danger"
                                                                                style="margin-left: 20px;"
                                                                                id="SCoupon_error"></div>
                                                                        </div>
                                                                        <input type="hidden" name="gift_card_send_type" id="gift_self"value="self">
                                                                        <div class="mb-3 col-12 mt-2">
                                                                            <button
                                                                                class="btn btn-block btn-outline-primary"
                                                                                onclick="selfValidation()" type="button"
                                                                                name="submit">Submit</button>
                                                                            <button
                                                                                class="btn btn-block btn-outline-warning"
                                                                                id="back" type="button"
                                                                                onclick="firstboxshow()">Back</button>
                                                                        </div>

                                                                        <hr />

                                                                        <div class="mb-3 col-12">
                                                                            <p>Give the gift of rejuvenation and relaxation
                                                                                with a Medspa gift card - perfect for you
                                                                                and your friends!</p>
                                                                            <p class="text-warning"
                                                                                onclick="checkbalance()"
                                                                                href="javascript:void(0)">Check your gift
                                                                                card balance</p>
                                                                        </div>
                                                                    </div>
                                                                </form>

                                                            </fieldset>

                                                            <fieldset id="paymentdbox" class="p-4">
                                                                <h2 class="fs-title">Order summary</h2>
                                                                <div id="paymentresult"></div>
                                                                {{-- Go To Main Payment  --}}
                                                                <form action="{{ url('/giftcardpayment') }}"
                                                                    method="POST" class="mb-4">
                                                                    @csrf
                                                                    <div id="paymentscript"></div>
                                                                </form>
                                                            </fieldset>
                                                            <div class="giftcardField">
                                                                <div class="row align-items-center p-4 g-3">
                                                                    <!-- Input Field -->
                                                                    <div class="col-md-8">
                                                                        <div class="input-group">
                                                                            <input type="text"
                                                                                placeholder="Enter gift card code..."
                                                                                id="gift_card_code" class="form-control"
                                                                                aria-label="Gift Card Code">
                                                                        </div>
                                                                    </div>
                                                                    <!-- Button -->
                                                                    <div class="col-md-4 text-md-end">
                                                                        <button
                                                                            class="btn btn-warning w-100 w-md-auto px-9"
                                                                            type="button" onclick="check_balance()">
                                                                            Check Balance
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <span class="showbalance"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    {{-- Modal Code --}}
    <!-- Modal for prompting login or guest buy -->
    <div id="loginPromptModal" class="modal" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Login Required</h5>
                    <button type="button" class="close" onclick="closeLoginPromptModal()">&times;</button>
                </div>
                <div class="modal-body">
                    <p>You need to log in to continue. Or proceed as a guest.</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" onclick="redirectToLogin()">Login</button>
                    <button class="btn btn-dark" onclick="SignUp()">Guest Buy</button>
                    <button class="btn btn-secondary" onclick="closeLoginPromptModal()">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Code End --}}
    <!-- wish us -->
    {{-- best deals  --}}
    <div id="redeem" class="main-timeline-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-box">
                        <h2><b>Redeem Process</b></h2>
                    </div>
                </div>
            </div>
            <div class="row p-4">
                <ol>
                    <li>The customer needs to purchase the giftcard from<strong> https://myforevermedspa.com</strong></li>
                    <li>After Purchasing the giftcard, the customer needs to visit the <strong>MedSpa Wellness
                            Center</strong> to redeem the dedicated purchased Giftcard
                    </li>
                    <li>Admins at the Welness centre will check the details of the giftcard and process the transaction as
                        per need of the customer
                    </li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Check if Session has 'amount' if patient sign in then goto next page -->
    @if (Session::has('amount'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Call the function with the stored session value when page loads
                fixamount({{ Session::get('amount') }});
            });
        </script>
    @endif
    <!-- Check if Session has 'amount' -->

    <!-- best deals -->
@endsection
@push('footerscript')
{{-- Bootstrap 4.1 Script --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
{{-- Bootstrap 4.1 Script END --}}
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ url('/') }}/giftcards/js/giftcard.js"></script>
<script src="{{ url('/') }}/giftcards/js/custom.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{--  form validation --}}
    <script>
        //  for self validation
        function selfValidation() {
            $("#selfform").validate({
                rules: {
                    sqty: {
                        required: true,
                    },
                    syour_name: {
                        required: true,
                        minlength: 3,
                    },
                    sto_email: {
                        required: true,
                        email: true,
                        maxlength: 60,
                    },
                },
                messages: {
                    sqty: {
                        required: "Please select quantity",
                    },
                    syour_name: {
                        required: "Please enter your name",
                        minlength: "Please enter at least 3 characters",
                    },
                    sto_email: {
                        required: "This field is required",
                        email: "Please enter a valid email address",
                        maxlength: "Email length should not exceed 60 characters",
                    },
                },
                submitHandler: function(form) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    var couponapplystatus = $('#scoupon_code').attr('message');
                    var getcouponValue = $('#scoupon_code').val();
                    if (getcouponValue != '' && couponapplystatus != 1) {
                        alert('Please Press Apply Code Button');
                        return false;
                    }

                    var amount = $('#amountdisplay').attr('finalamount');
                    var discount = $('#amountdisplay').attr('coupondiscount');
                    var qty = $('#sqty').val();
                    var your_name = $('#syour_name').val();
                    var receipt_email = $('#sto_email').val();
                    var gift_card_send_type = $('#gift_self').val();
                    var coupon_code = $('#scoupon_code').val() || null;

                    $.ajax({
                        url: '{{ route('selfgift') }}',
                        method: "post",
                        dataType: "json",
                        data: {
                            _token: '{{ csrf_token() }}',
                            amount: amount,
                            discount: discount,
                            qty: qty,
                            your_name: your_name,
                            gift_card_send_type: gift_card_send_type,
                            gift_send_to: receipt_email,
                            user_token: $('#user_token').val(),
                            coupon_code: coupon_code,
                            patient_login_id: "{{ session('patient_details')['patient_login_id'] ?? '' }}",
                        },
                        success: function(response) {
                            console.log(response.success);
                            if (response.success) {
                                $('#payment').addClass('active');
                                $('#Coupon_error').hide();
                                $('#Coupon_success').html(response.success).show();
                                $('#firstbox').hide();
                                $('#secondbox').hide();
                                $('#paymentdbox').show();
                                $('#paymentresult').html(response.result).show();
                                $('#paymentscript').html(response.paymentscript).show();
                                $("#giftqty").html(qty + ' x $' + (amount / qty) + ' gift card');
                            }
                            if (response.error) {
                                $('#Coupon_success').hide();
                                $('#Coupon_error').html(response.error).show();
                            }
                        }
                    });
                }
            });

            // Trigger form validation
            if ($("#selfform").valid()) {
                $("#selfform").submit();
            }
        }
    </script>
    <script>
        // Get the current date
        var today = new Date().toISOString().split('T')[0];
        // Set the min attribute of the date input field to today
        document.getElementById('in_future').setAttribute('min', today);
    </script>
    <script>
        //  Send for Someone Else
        function sendsomeOneElse() {
    let toEmail = document.getElementById('gift_send_to').value.trim();
    let fromEmail = document.getElementById('recipient_email').value.trim();

    // Clear any old error
    document.getElementById('email-error')?.remove();

    // 🚫 Check if emails are the same
    if (toEmail !== "" && fromEmail !== "" && toEmail === fromEmail) {
        let errorDiv = document.createElement("div");
        errorDiv.id = "email-error";
        errorDiv.className = "text-danger mt-2";
        errorDiv.innerText = "Sender and recipient email cannot be the same!";
        document.getElementById('couponaply').insertAdjacentElement("afterend", errorDiv);
        return false; // ❌ stop execution here
    }

    // ✅ Run validation only if emails are different
    $("#someoneform").validate({
        rules: {
            qty: { required: true },
            your_name: { required: true, minlength: 3, maxlength: 60 },
            recipient_name: { required: true, minlength: 3, maxlength: 60 },
            message: { required: true, minlength: 10, maxlength: 255 },
            gift_send_to: { required: true, email: true, maxlength: 60 },
            recipient_email: { required: true, email: true, maxlength: 60 }
        },
        messages: {
            qty: { required: "Please select quantity" },
            your_name: {
                required: "Please enter your name",
                maxlength: "Your name must not exceed 60 characters.",
                minlength: "Please enter at least 3 characters"
            },
            recipient_name: {
                required: "Recipient name is required",
                minlength: "Please enter at least 3 characters",
                maxlength: "Recipient name must not exceed 60 characters."
            },
            message: {
                required: "Message is required",
                minlength: "Please enter at least 10 characters",
                maxlength: "Message must not exceed 255 characters."
            },
            gift_send_to: {
                required: "Recipient email is required",
                maxlength: "Email must not exceed 60 characters."
            },
            recipient_email: {
                required: "Sender email is required",
                maxlength: "Email must not exceed 60 characters."
            }
        },
        submitHandler: function(form) {
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            var couponapplystatus = $('#coupon_code').attr('message');
            var getcouponValue = $('#coupon_code').val();
            if (getcouponValue != '' && couponapplystatus != 1) {
                alert('Please Press Apply Code Button');
                return false;
            }

            var amount = $('#amountdisplay').attr('finalamount');
            var discount = $('#amountdisplay').attr('coupondiscount');
            var qty = $('#qty').val();
            var gift_send_to = $('#gift_send_to').val();
            var your_name = $('#your_name').val();
            var recipient_name = $('#recipient_name').val();
            var message = $('#message').val();
            var event = $('#Event_id').val();
            var gift_card_send_type = $('#gift_other').val();
            var receipt_email = $('#recipient_email').val();

            var in_future = $('#in_future').val() || null;
            var coupon_code = $('#coupon_code').val() || null;

            $.ajax({
                url: '{{ route('sendgift') }}',
                method: "post",
                dataType: "json",
                data: {
                    _token: '{{ csrf_token() }}',
                    amount: amount,
                    qty: qty,
                    your_name: your_name,
                    recipient_name: recipient_name,
                    receipt_email: receipt_email,
                    message: message,
                    gift_card_send_type: gift_card_send_type,
                    in_future: in_future,
                    user_token: $('#user_token').val(),
                    coupon_code: coupon_code,
                    discount: discount,
                    gift_send_to: gift_send_to,
                    event_id: event,
                    patient_login_id: "{{ session('patient_details')['patient_login_id'] ?? '' }}",
                },
                success: function(response) {
                    if (response.success) {
                        $('#payment').addClass('active');
                        $('#Coupon_error').hide();
                        $('#Coupon_success').html(response.success).show();
                        $('#firstbox').hide();
                        $('#secondbox').hide();
                        $('#paymentdbox').show();
                        $('#paymentresult').html(response.result).show();
                        $('#paymentscript').html(response.paymentscript).show();
                        $("#giftqty").html(qty + ' x $' + (amount / qty) + ' gift card');
                    }
                    if (response.error) {
                        $('#Coupon_success').hide();
                        $('#Coupon_error').html(response.error).show();
                    }
                }
            });
        }
    });

    // 🚀 Trigger form validation
    if ($("#someoneform").valid()) {
        $("#someoneform").submit();
    }
}


        // for Coupon Validate 
        $('#Coupon_success').hide();
        $('#Coupon_error').hide();

        function CheckCoupon() {
            var amount = $('#amountdisplay').attr('finalamount');
            $.ajax({
                url: '{{ route('coupon-validate') }}',
                method: "post",
                dataType: "json",
                data: {
                    _token: '{{ csrf_token() }}',
                    coupon_code: $("#coupon_code").val(),
                    user_token: $('#user_token').val(),
                    amount: amount,
                },
                success: function(response) {
                    if (response.success) {
                        $('#Coupon_error').hide();
                        $('#Coupon_success').html(response.success).show();
                        if (response.data[0]['discount_type'] == 'amount') {
                            var discountAmount = response.data[0]['discount_rate'];
                            var afterDiscount = parseInt(amount - discountAmount);
                            $("#amountdisplay").attr('coupondiscount', discountAmount);
                            $("#amountdisplay").attr('finalamount', amount);
                        }
                        if (response.data[0]['discount_type'] == 'percentage') {
                            var discountRate = response.data[0][
                                'discount_rate'
                            ]; // Assuming discount_rate is a percentage (e.g., 10 for 10%)
                            var discountAmount = (amount * discountRate) / 100;
                            var afterDiscount = amount - discountAmount;
                            $("#amountdisplay").attr('coupondiscount', discountAmount);
                            $("#amountdisplay").attr('finalamount', amount);
                        }

                        $("#coupon_code").attr('message', response.data[0]['status']);
                    }
                    if (response.error) {
                        $('#Coupon_success').hide();
                        $('#Coupon_error').html(response.error).show();
                        $("#coupon_code").val('');

                    }
                }
            });
        }
        //  for Self

        function SelfCoupon() {
            var amount = $('#amountdisplay').attr('finalamount');
            $.ajax({
                url: '{{ route('coupon-validate') }}',
                method: "post",
                dataType: "json",
                data: {
                    _token: '{{ csrf_token() }}',
                    coupon_code: $('#scoupon_code').val(),
                    user_token: $('#user_token').val(),
                    amount: amount,
                },
                success: function(response) {
                    if (response.success) {
                        $('#SCoupon_error').hide();
                        $('#SCoupon_success').html(response.success).show();
                        if (response.data[0]['discount_type'] == 'amount') {
                            var discountAmount = response.data[0]['discount_rate'];
                            var afterDiscount = parseInt(amount - discountAmount);
                            $("#amountdisplay").attr('coupondiscount', discountAmount);
                            $("#amountdisplay").attr('finalamount', amount);
                        }
                        if (response.data[0]['discount_type'] == 'percentage') {
                            var discountRate = response.data[0][
                                'discount_rate'
                            ]; // Assuming discount_rate is a percentage (e.g., 10 for 10%)
                            var discountAmount = (amount * discountRate) / 100;
                            var afterDiscount = amount - discountAmount;
                            $("#amountdisplay").attr('coupondiscount', discountAmount);
                            $("#amountdisplay").attr('finalamount', amount);
                        }
                        $("#scoupon_code").attr('message', response.data[0]['status']);
                    }
                    if (response.error) {
                        $('#SCoupon_success').hide();
                        $('#SCoupon_error').html(response.error).show();
                        $("#coupon_code").val('');

                    }
                }
            });
        }

        function check_balance() {
            $.ajax({
                url: '{{ route('balance-check') }}',
                method: "post",
                dataType: "json",
                data: {
                    _token: '{{ csrf_token() }}',
                    gift_card_number: $('#gift_card_code').val(),
                    user_token: $('#user_token').val(),
                },
                success: function(response) {
                    if (response.success) {
                        $('.showbalance').html(response.success).show();
                    } else {
                        $('.showbalance').html(response.error).show();
                    }
                }
            });
        }
    </script>
    <script>
        $(document).ready(function() {

            var current_fs, next_fs, previous_fs; //fieldsets
            var opacity;

            $(".next").click(function() {

                current_fs = $(this).parent();
                next_fs = $(this).parent().next();

                //Add Class Active
                $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

                //show the next fieldset
                next_fs.show();
                //hide the current fieldset with style
                current_fs.animate({
                    opacity: 0
                }, {
                    step: function(now) {
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

            $(".previous").click(function() {

                current_fs = $(this).parent();
                previous_fs = $(this).parent().prev();

                //Remove class active
                $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

                //show the previous fieldset
                previous_fs.show();

                //hide the current fieldset with style
                current_fs.animate({
                    opacity: 0
                }, {
                    step: function(now) {
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

            $('.radio-group .radio').click(function() {
                $(this).parent().find('.radio').removeClass('selected');
                $(this).addClass('selected');
            });

            $(".submit").click(function() {
                return false;
            })

        });


        //  for amount move to next window
        function fixamount(amount) {
            if (amount != "" && amount != 0) {
                $.ajax({
                    url: "{{ route('store-amount') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        amount: amount
                    },
                    success: function(response) {
                        if (response.logged_in) {
                            $('#secondbox').show();
                            $('#firstbox').hide();
                            $('#personal').addClass('active');
                            $("#amountdisplay").html('1 X $' + amount + ' gift card');
                            $("#amountdisplay").attr('amount', amount);
                            $("#amountdisplay").attr('finalAmount', amount);
                        } else {
                            // Show login modal
                            document.getElementById('loginPromptModal').style.display = 'block';
                            // Store amount in data attribute for use in redirect
                            document.getElementById('loginPromptModal').setAttribute('data-amount', amount);
                        }
                    },
                    error: function(xhr) {
                        alert("An error occurred. Please try again.");
                    }
                });
            } else {
                alert('Amount is Not Selected');
                $('#secondbox').hide();
            }
        }

        function redirectToLogin() {
            const amount = document.getElementById('loginPromptModal').getAttribute('data-amount');
            window.location.href = "{{ route('patient-login') }}" + "?amount=" + amount;
        }

        function closeLoginModal() {
            document.getElementById('loginPromptModal').style.display = 'none';
        }



        function firstboxshow() {
            // Redirect to the remove-amount route
            location.href = '{{ route('remove-amount') }}';
        }

        //  for custome amount giftcard
        function customeamount(amount) {
            var amount = $('#customeamount').val();

            if (amount != "") {
                if (amount < 25) {
                    alert('The Amount should be more than or equal to $25');
                    return false;
                }
                if (amount > 2000) {
                    alert('Your is more the $2000 please enter less then $2000 or equal to $2000');
                    return false;
                }
                $.ajax({
                    url: "{{ route('store-amount') }}", // Create this route
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        amount: amount
                    },
                    success: function(response) {
                        if (response.logged_in) {
                            $('#secondbox').show();
                            $('#firstbox').hide();
                            $('#personal').addClass('active');
                            $("#amountdisplay").html('1 X $' + amount + ' gift card');
                            $("#amountdisplay").attr('amount', amount);
                            $("#amountdisplay").attr('finalAmount', amount);
                        } else {
                            // Show login modal
                            document.getElementById('loginPromptModal').style.display = 'block';
                            // Store amount in data attribute for use in redirect
                            document.getElementById('loginPromptModal').setAttribute('data-amount', amount);
                        }
                    }
                });


            } else {
                alert('Enter Amount');
                $('#secondbox').hide();
            }

        }
        // Modal RElated Functions
        function closeLoginPromptModal() {
            $.ajax({
                    url: "{{ route('unset-amount') }}", // Create this route
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        document.getElementById('loginPromptModal').style.display = 'none';
                    }
                });
            document.getElementById('loginPromptModal').style.display = 'none';
        }

        function redirectToLogin() {
            var modal = document.getElementById('loginPromptModal');
            var amount = modal.getAttribute('data-amount');
            window.location.href = "{{ route('patient-login') }}?amount=" + amount;
        }

        function SignUp() {
            var modal = document.getElementById('loginPromptModal');
            var amount = modal.getAttribute('data-amount');

            // Hide modal
            modal.style.display = 'none';

            // Proceed as guest – show second box and fill amount
            $('#secondbox').show();
            $('#firstbox').hide();
            $('#personal').addClass('active');
            $("#amountdisplay").html('1 X $' + amount + ' gift card');
            $("#amountdisplay").attr('amount', amount);
            $("#amountdisplay").attr('finalAmount', amount);
        }
    </script>
@endpush
