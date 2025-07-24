@extends('layouts.admin_layout')
@section('body')
    <!-- Body main wrapper start -->
    @php
        $cart = session()->get('cart', []);
        $amount = 0;
    @endphp
    @push('css')
        .required{
        color:red !important;
        }
        /* General Styles */
body {
    font-family: Arial, sans-serif;
}

.app-content-header, .checkout-area {
    margin-bottom: 30px;
}

/* Breadcrumb Styling */
.breadcrumb {
    background: none;
    padding: 0;
    margin: 0;
}

/* Table Styling */
.your-order-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.your-order-table table {
    width: 100%;
}

.your-order-table th, 
.your-order-table td {
    padding: 10px 15px;
    border: 1px solid #ddd;
    text-align: left;
    vertical-align: middle;
}

.your-order-table th {
    background-color: #f7f7f7;
    font-weight: bold;
}

.cart-item td.product-name {
    width: 70%;
}

.cart-item td.product-total {
    width: 30%;
}

.cart-subtotal th,
.order-total th {
    text-align: left;
}

.cart-subtotal td,
.order-total td {
    text-align: right;
    font-weight: bold;
}

/* Form Styling */
.checkbox-form {
    background-color: #f8f9fa;
    border: 1px solid #ddd;
    padding: 20px;
    border-radius: 5px;
}

.checkout-form-list {
    margin-bottom: 15px;
}

.checkout-form-list label {
    font-weight: bold;
}

.checkout-form-list input.form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-sizing: border-box;
}

.checkout-form-list .text-danger {
    color: red;
    font-size: 12px;
}

.payment-method {
    margin-top: 20px;
}

.fill-btn {
    display: block;
    width: 100%;
    text-align: center;
    margin-top: 20px;
    padding: 15px 0;
    background-color: #007bff;
    color: #fff;
    font-size: 16px;
    font-weight: bold;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.fill-btn:hover {
    background-color: #0056b3;
}

/* Responsive Design */
@media (max-width: 768px) {
    .your-order, .checkbox-form {
        margin-bottom: 20px;
    }

    .your-order-table th, 
    .your-order-table td {
        padding: 8px;
    }

    .fill-btn {
        padding: 12px 0;
        font-size: 14px;
    }
}

    @endpush
    {{-- {{dd(session()->get('totalValue'))}} --}}
    {{-- {{dd(session()->get('cart'))}} --}}

    <!-- Body main wrapper start -->
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-2">
                        <h3 class="mb-0">Payment Process</h3>

                    </div>
                    <div class="col-sm-10">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Cart View
                            </li>
                        </ol>
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!-- Breadcrumb area start  -->

        <!-- checkout-area start -->
        <section class="checkout-area section-space">
            <div class="container">
                <form action="{{ route('servic-checkout-process') }}" method="POST" id="bill_form">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="checkbox-form">
                                <h3 class="mb-15">Billing Details</h3>
                                <div class="row g-5">
                                    <div class="col-md-6">
                                        <div class="checkout-form-list">
                                            <label>First Name <span class="required">*</span></label>
                                            <input type="text" class="form-control" placeholder="" name="fname"
                                                value="{{ old('fname') }}">
                                            @error('fname')
                                                <span class="text-danger">{{ 'First name is required.' }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="checkout-form-list">
                                            <label>Last Name <span class="required">*</span></label>
                                            <input type="text" class="form-control" placeholder="" name="lname"
                                                value="{{ old('lname') }}">
                                            @error('lname')
                                                <span class="text-danger">{{ 'Last name is required.' }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="checkout-form-list">
                                            <input type="text" class="form-control"
                                                placeholder="Apartment, suite, unit etc. (optional)" name="address"
                                                value="{{ old('address') }}">

                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="checkout-form-list">
                                            <label>Town / City <span class="required">*</span></label>
                                            <input type="text" class="form-control" placeholder="Town / City"
                                                name="city" value="{{ old('city') }}">
                                            @error('city')
                                                <span class="text-danger">{{ 'Please Enter Town / City.' }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="checkout-form-list">
                                            <label>State / County <span class="required">*</span></label>
                                            <input type="text" class="form-control" placeholder="" name="country"
                                                value="{{ old('country') }}">
                                            @error('country')
                                                <span class="text-danger">{{ 'Please Enter State / County' }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="checkout-form-list">
                                            <label>Postcode / Zip <span class="required">*</span></label>
                                            <input type="text" class="form-control" placeholder="Postcode / Zip"
                                                name="zip_code" value="{{ old('zip_code') }}">
                                            @error('zip_code')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="checkout-form-list">
                                            <label>Email Address <span class="required">*</span></label>
                                            <input type="email"class="form-control" placeholder="" name="email"
                                                value="{{ old('email') }}">
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="checkout-form-list">
                                            <label>Phone <span class="required">*</span></label>
                                            <input type="number" class="form-control" placeholder="Phone" name="phone"
                                                value="{{ old('phone') }}">
                                            @error('phone')
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
                                                <th class="product-name">Product</th>
                                                <th class="product-total">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cart as $item)
                                                @php
                                                    $cart_data = App\Models\Product::find($item['product_id']);
                                                    $amount += $cart_data->discounted_amount;
                                                @endphp
                                                <tr class="cart_item">
                                                    <td class="product-name">
                                                        {{ $cart_data->product_name }}<strong class="product-quantity"> ×
                                                            {{ $cart_data->session_number ? $cart_data->session_number : 1 }}
                                                            Sessions</strong>
                                                    </td>
                                                    <td class="product-total">
                                                        <span class="amount">${{ $cart_data->discounted_amount, 2 }}</span>
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
                                            <tr class="cart-subtotal">
                                                <td>Tax 10%:</td>
                                                @php
                                                    $taxamount = ($amount * 0) / 100;
                                                    // echo "+$" . $taxamount;
                                                @endphp
                                                <td> +${{ session('tax_amount') ? session('tax_amount') : $taxamount }}</td>
                                            </tr>
                                            <tr class="order-total">
                                                <th>Order Total</th>
                                                <td>
                                                    <strong>
                                                        <span class="amount">
                                                            ${{ session('total_gift_applyed')
                                                                ? number_format(session('totalValue'), 2)
                                                                : number_format($amount + $taxamount, 2) }}
                                                        </span>
                                                    </strong>
                                                </td>

                                            </tr>
                                        </tfoot>
                                    </table>
                                    <div class="col-md-6 mt-4">
                                        <div class="checkout-form-list">
                                            <label>Transaction Status <span class="required">*</span></label>
                                          <select class="form-control" name="transaction_status" required>
                                            <option value="" >Select Status</option>
                                            <option value="complete">Complete</option>
                                            <option value="under process">Under Process</option>
                                          </select>
                                            @error('transaction_status')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
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

    </main>
    <!-- Body main wrapper end -->
@endsection

@push('footerscript')
    <script>
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
    </script>
@endpush
