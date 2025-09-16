
@extends('layouts.front-master')
@section('body')
@push('csslink')
<style>
     .required{
        color:red !important;
    }

</style>

<style>
    .section-space {
        padding-top: 10px !important;
        padding-bottom: 5px !important;
    }

    @media only screen and (min-width: 576px) and (max-width: 767px), (max-width: 575px) {
        .section-space {
            padding-top: 40px !important;
            padding-bottom: 10px !important;
        }       

        .your-order{
            padding-right:0px !important;
        }

        
    }
</style>

<!-- CSS here -->
<link rel="stylesheet" href="{{url('/product_page')}}/css/bootstrap.min.css">
<link rel="stylesheet" href="{{url('/product_page')}}/css/main.css">
{{-- <link rel="stylesheet" href="{{url('/')}}/giftcards/css/style.css">  --}}
@endpush
    @php
        $cart = session()->get('front_cart', []);
        $amount = 0;
    @endphp
  
    {{-- {{dd(session()->get('totalValue'))}} --}}
    {{-- {{dd(session()->get('cart'))}} --}}

    <!-- Body main wrapper start -->
<div class="container">

        <!-- checkout-area start -->
        <section class="checkout-area section-space">
            <div class="container">
                <form action="{{ route('checkout_process') }}" method="POST" id="bill_form">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="checkbox-form">
                                <h3 class="mb-15">Billing Details</h3>
                                <div class="row g-5">
                                    <div class="col-md-6">
                                        <div class="checkout-form-list">
                                            <label>First Name <span class="required">*</span></label>
                                            <input type="text" placeholder="" name="fname" value="{{Session::get('result') ? Auth::guard('patient')->user()->fname : old('fname') }}">
                                            @error('fname')
                                            <span class="text-danger">{{ 'First name is required.' }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="checkout-form-list">
                                            <label>Last Name </label>
                                            <input type="text" placeholder="" name="lname" value="{{Session::get('result') ? Auth::guard('patient')->user()->lname : old('lname') }}">
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="checkout-form-list">
                                            <label>Email Address <span class="required">*</span></label>
                                            <input type="email" placeholder="" name="email" value="{{Session::get('result') ? Auth::guard('patient')->user()->email : old('email') }}">
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="checkout-form-list">
                                            <label>Phone <span class="required">*</span></label>
                                            <input type="number" placeholder="Phone" name="phone" value="{{Session::get('result') ? Auth::guard('patient')->user()->phone : old('phone') }}">
                                            @error('phone')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="checkout-form-list">
                                            <input type="text" placeholder="Apartment, suite, unit etc. (optional)" name="address" value="{{Session::get('result') ? Auth::guard('patient')->user()->address : old('address') }}">
                                           
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="checkout-form-list">
                                            <label>Town / City <span class="required">*</span></label>
                                            <input type="text" placeholder="Town / City" name="city" value="{{Session::get('result') ? Auth::guard('patient')->user()->city : old('city') }}">
                                            @error('city')
                                                <span class="text-danger">{{ 'Please Enter Town / City.' }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="checkout-form-list">
                                            <label>State / Country <span class="required">*</span></label>
                                            <input type="text" placeholder="" name="country" value="{{Session::get('result') ? Auth::guard('patient')->user()->country : old('country') }}">
                                            @error('country')
                                                <span class="text-danger">{{ 'Please Enter State / County' }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="checkout-form-list">
                                            <label>Postcode / Zip <span class="required">*</span></label>
                                            <input type="text" placeholder="Postcode / Zip" name="zip_code" value="{{Session::get('result') ? Auth::guard('patient')->user()->zip_code : old('zip_code') }}">
                                            @error('zip_code')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="your-order">
                                <h3>Your order</h3>
                                <div class="your-order-table table-responsive">
                                    <table>
                                        <thead>
                                            <tr>
                                                {{-- <th class="product-name">Image</th> --}}
                                                <th class="product-name">Product</th>
                                                <th class="product-name">Qty</th>
                                                <th class="product-name">Price</th>
                                                <th class="product-total">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cart as $key => $item)
                                            <tr>
                                                {{-- <td>{{ $loop->iteration }}</td> --}}
                                                @if ($item['type'] === 'product')
                                                        @php
                                                            $units = App\Models\ServiceUnit::find($item['unit_id']);
                                                            $image = explode('|', $units->product_image);
                                                            $price = $units->discounted_amount ?? $units->amount;
                                                            $subtotal = $price*$item['quantity'];
                                                            $amount += $subtotal;
                                                           
                                                        @endphp
                                                    {{--  <td>
                                                    
                                                       <img src="{{ $image[0] }}" style="height:100px; width:100px;" 
                                                            onerror="this.onerror=null; this.src='{{ url('/No_Image_Available.jpg') }}';"> 
                                                    </td>--}}
                                                    @elseif ($item['type'] === 'unit')
                                                        @php
                                                            $unit = App\Models\ServiceUnit::find($item['unit_id']);
                                                            $image = explode('|', $unit->product_image);
                                                            $price = $unit->discounted_amount ?? $unit->amount;
                                                            $subtotal = $price*$item['quantity'];
                                                            $amount += $subtotal;
                                                        @endphp
                                                       {{-- <td>
                                                         <img src="{{ $image[0] }}" style="height:100px; width:100px;" 
                                                            onerror="this.onerror=null; this.src='{{ url('/No_Image_Available.jpg') }}';">
                                                        </td> --}}
                                                    @endif
                                                
                                                <td>
                                                    @if ($item['type'] === 'product')
                                                        {{ $units->product_name }}
                                                    @elseif ($item['type'] === 'unit')
                                                        {{ $unit->product_name }}
                                                    @endif
                                                </td>
                                                <td>{{ $item['quantity'] }}</td>
                                                
                                                <td>
                                                    @if ($item['type'] === 'product')
                                                        {{ "$".$units->discounted_amount ?? "$".$units->amount }}
                                                    @elseif ($item['type'] === 'unit')
                                                        {{ "$".$unit->discounted_amount ?? "$".$unit->amount }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item['type'] === 'product')
                                                        {{ "$".$item['quantity']*$units->discounted_amount ?? "$".$item['quantity']*$units->amount }}
                                                    @elseif ($item['type'] === 'unit')
                                                        {{ "$".$item['quantity']*$unit->discounted_amount ?? "$".$item['quantity']*$unit->amount }}
                                                    @endif
                                                </td>
                                   
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="cart-subtotal">
                                                <th>Cart Subtotal</th>
                                                <td><span class="amount">${{ number_format($amount, 2) }}</span></td>
                                            </tr>
                                            @if (session()->has('total_gift_applyed'))
                                                <tr class="cart-subtotal">
                                                    <td>Total Gift Applied:</td>
                                                    <td> -${{ session('total_gift_applyed') }}</td>
                                                </tr>
                                            @endif
                                                {{-- <tr class="cart-subtotal">
                                                    <td>Tax 0%:</td>
                                                    @php
                                                    $taxamount = ($amount * 0) / 100;
                                                    // echo "+$" . $taxamount;
                                                    @endphp
                                                    <td> +${{ session('tax_amount') ? session('tax_amount'):$taxamount }}</td>
                                                </tr> --}}
                                            <tr class="order-total">
                                                <th>Order Total</th>
                                                <td>
                                                    <strong>
                                                        <span class="amount">
                                                            ${{ session('total_gift_applyed') 
                                                                ? number_format(
                                                                    session('totalValue'), 
                                                                    2
                                                                  ) 
                                                                : number_format(
                                                                    $amount, 
                                                                    2
                                                                  ) 
                                                            }}
                                                        </span>
                                                    </strong>
                                                </td>
                                                
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="payment-method">
                                    <div class="order-button-payment mt-20">
                                        <button class="fill-btn" type="submit">
                                            <span class="fill-btn-inner">
                                                <span class="fill-btn-normal">Place order</span>
                                                <span class="fill-btn-hover">Place order</span>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                
            </div>
        </section>
        <!-- checkout-area end -->

    </div>
    <!-- Body main wrapper end -->
@endsection

@push('footerscript')
 <script src="{{url('/product_page')}}/js/jquery-3.6.0.min.js"></script>
    <script src="{{url('/product_page')}}/js/bootstrap.bundle.min.js"></script>
    <script src="{{url('/')}}/giftcards/js/custom.js"></script>
{{-- <script>
// Disable right-click context menu
document.addEventListener('contextmenu', function(event) {
    event.preventDefault();
});

// Disable F12, Ctrl+Shift+I, Ctrl+Shift+J, and Ctrl+U (view source)
document.addEventListener('keydown', function(event) {
    // F12 key
    if (event.keyCode === 123) {
        event.preventDefault();
    }
    // Ctrl+Shift+I (Inspect)
    if (event.ctrlKey && event.shiftKey && event.keyCode === 73) {
        event.preventDefault();
    }
    // Ctrl+Shift+J (Console)
    if (event.ctrlKey && event.shiftKey && event.keyCode === 74) {
        event.preventDefault();
    }
    // Ctrl+U (View Source)
    if (event.ctrlKey && event.keyCode === 85) {
        event.preventDefault();
    }
});
</script> --}}
@endpush
