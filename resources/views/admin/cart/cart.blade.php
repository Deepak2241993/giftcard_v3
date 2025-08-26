@extends('layouts.admin_layout')
@section('body')
<!-- Body main wrapper start -->
@php
$cart = session()->get('cart', []);
$amount = 0;
// $cart = session()->pull('cart');
@endphp
@push('css')




<style>
   .cart-page-total {
   background-color: #f8f9fa;
   /* Light background to highlight the cart totals */
   border: 1px solid #ddd;
   /* Border around the totals section */
   padding: 20px;
   border-radius: 5px;
   /* Rounded corners */
   }
   .cart-page-total h2 {
   margin-bottom: 20px;
   font-size: 24px;
   font-weight: bold;
   border-bottom: 1px solid #ddd;
   /* Line under heading */
   padding-bottom: 10px;
   }
   .cart-totals-list {
   list-style: none;
   /* Remove bullet points */
   padding: 0;
   margin: 0;
   }
   .cart-totals-item {
   display: flex;
   /* Flexbox to align items */
   justify-content: space-between;
   /* Space between label and value */
   padding: 10px 0;
   /* Spacing for each item */
   border-bottom: 1px solid #ddd;
   /* Line between items */
   }
   .cart-totals-item:last-child {
   border-bottom: none;
   /* Remove bottom line from last item */
   }
   .cart-totals-value {
   font-weight: bold;
   /* Bold values for emphasis */
   color: #333;
   /* Dark text color */
   }
   .fill-btn {
   display: block;
   width: 100%;
   text-align: center;
   margin-top: 20px;
   padding: 15px 0;
   background-color: #007bff;
   /* Primary button color */
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
   /* Darker blue on hover */
   }
   .fill-btn-inner {
   display: inline-block;
   position: relative;
   }
   .fill-btn-hover {
   position: absolute;
   top: 0;
   left: 0;
   width: 100%;
   height: 100%;
   display: none;
   /* Hide hover text */
   }
   .fill-btn:hover .fill-btn-hover {
   display: inline-block;
   /* Show hover text */
   }
   .fill-btn:hover .fill-btn-normal {
   display: none;
   /* Hide normal text on hover */
   }
</style>
@endpush
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>
               Program Sale
            </h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="#">Home</a></li>
               <li class="breadcrumb-item active">Program Sale</li>
            </ol>
         </div>
      </div>
   </div>
   <!-- /.container-fluid -->
</section>
{{--  Action Button Section --}}
<section class="content">
   <div class="container-fluid">
      <div class="row">
         @if ($errors->any())
         <div class="alert alert-danger">
            <ul>
               @foreach ($errors->all() as $error)
               <li>{{ $error }}</li>
               @endforeach
            </ul>
         </div>
         @endif
         <div class="col-md-12">
            <div class="card card-primary card-outline">
               <div class="card-header">
                  <h3 class="card-title">
                     <i class="fas fa-edit"></i>
                     Add Unit/Add Program/Services
                  </h3>
               </div>
               <div class="card-body">
                  <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#createPatient">
                  Create Patient
                  </button>
                  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default">
                  Create Unit
                  </button>
                  <button type="button" class="btn btn-primary"
                     onclick="location.href='{{ route('program.index') }}';">
                  Buy Programs
                  </button>
                  <button type="button" class="btn btn-warning"
                     onclick="location.href='{{ route('unit.index') }}';">
                  Buy Unit
                  </button>
                  {{-- <button type="button" class="btn btn-dark"
                     onclick="location.href='{{ route('product.index') }}';">
                  Buy Services
                  </button> --}}
               </div>
            </div>
         </div>
      </div>
   </div>
   {{--  For Unit Create Modal --}}
   <div class="modal fade" id="modal-default">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">Create Unit Quickly</h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <form method="post" action="{{ route('create-unit-quickly') }}" enctype="multipart/form-data">
                  @csrf
                  <div class="row">
                     <div class="mb-3 col-lg-6 self">
                        <label for="product_name" class="form-label">Unit Name<span
                           class="text-danger">*</span></label>
                        <input class="form-control" id="product_name" required type="text"
                           name="product_name" value="{{ isset($data) ? $data['product_name'] : '' }}"
                           placeholder="Product Name" onkeyup="slugCreate()">
                     </div>
                     <div class="mb-3 col-lg-6 self">
                        <label for="product_slug" class="form-label">Unit Slug<span
                           class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="product_slug"
                           value="{{ isset($data) ? $data['product_slug'] : '' }}" placeholder="Slug"
                           id="product_slug">
                     </div>
                     <div class="mb-3 col-lg-6 self mt-2">
                        <label for="amount" class="form-label">Unit Original Price<span
                           class="text-danger">*</span>
                        </label>
                        <input class="form-control" type="number" min="0" name="amount"
                           value="{{ isset($data) ? $data['amount'] : '' }}" placeholder="Original Price"
                           required step="0.01">
                        <input class="form-control" type="hidden" min="0" name="id"
                           value="{{ isset($data) ? $data['id'] : '' }}">
                     </div>
                     <div class="mb-3 col-lg-6 self mt-2">
                        <label for="discounted_amount" class="form-label">Unit Discounted Price</label>
                        <input class="form-control" type="number" min="0" name="discounted_amount"
                           value="{{ isset($data) ? $data['discounted_amount'] : '' }}"
                           placeholder="Discounted Price" step="0.01">
                     </div>
                     <div class="mb-3 col-lg-6 self">
                        <label for="min_qty" class="form-label">Min Qty<span
                           class="text-danger">*</span></label>
                        <input class="form-control" type="number" min="1" name="min_qty"
                           value="{{ isset($data) ? $data['min_qty'] : '1' }}"
                           placeholder="Number Of Session" required>
                     </div>
                     <div class="mb-3 col-lg-6 self">
                        <label for="max_qty" class="form-label">Max Qty<span
                           class="text-danger">*</span></label>
                        <input class="form-control" type="number" min="1" name="max_qty"
                           value="{{ isset($data) ? $data['max_qty'] : '1' }}"
                           placeholder="Number Of Session" required>
                     </div>
                     <div class="mb-3 col-lg-6">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" name="status" id='status'>
                        <option
                        value="1"{{ isset($data['status']) && $data['status'] == 1 ? 'selected' : '' }}>
                        Active</option>
                        <option
                        value="0"{{ isset($data['status']) && $data['status'] == 0 ? 'selected' : '' }}>
                        Inactive</option>
                        </select>
                     </div>
                     <div class="mb-3 col-lg-6">
                        <label for="giftcard_redemption" class="form-label">Giftcard Redeem</label>
                        <select class="form-control" name="giftcard_redemption" id="from">
                        <option value="1"
                        {{ isset($data['giftcard_redemption']) && $data['giftcard_redemption'] == 1 ? 'selected' : '' }}>
                        Yes</option>
                        <option value="0"
                        {{ isset($data['giftcard_redemption']) && $data['giftcard_redemption'] == 0 ? 'selected' : '' }}>
                        No</option>
                        </select>
                     </div>
                     <div class="mb-3 col-lg-6">
                        <button class="btn btn-block btn-outline-primary form_submit" type="submit"
                           id="submitBtn">Submit</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
         <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
   </div>
   {{--  For Unit Create Modal End --}}
   {{--  For Patient Create Modal --}}
   <div class="modal fade" id="createPatient">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">Create Patient Quickly</h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <form id="patientForm" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="row">
                     <div class="mb-3 col-lg-12 self">
                        <label for="patient_login_id" class="form-label">User Name <span class="text-danger">*</span></label>
                        <input class="form-control" id="patient_login_id" onkeyup="CheckUser()" required type="text" name="patient_login_id" placeholder="User Name">
                        <div class="showbalance" style="color: red; margin-top: 10px;"></div>
                        <div id="error-patient_login_id" class="text-danger mt-1"></div>
                     </div>
                     <div class="mb-3 col-lg-6 self">
                        <label for="fitst_name" class="form-label">First Name <span class="text-danger">*</span></label>
                        <input class="form-control" id="fitst_name" required type="text" name="fname" placeholder="First Name">
                        <div id="error-fname" class="text-danger mt-1"></div>
                     </div>
                     <div class="mb-3 col-lg-6 self">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input class="form-control" type="text" name="lname" placeholder="Last Name" id="last_name">
                     </div>
                     <div class="mb-3 col-lg-6 self mt-2">
                        <label for="email_id" class="form-label">Email <span class="text-danger">*</span></label>
                        <input class="form-control" type="email" name="email" id="email_id" placeholder="Email" required>
                        <div id="error-email" class="text-danger mt-1"></div>
                     </div>
                     <div class="mb-3 col-lg-6 self mt-2">
                        <label for="phone_number" class="form-label">Mobile</label>
                        <input class="form-control" type="number" name="phone" id="phone_number" placeholder="Mobile">
                     </div>
                     <div class="mb-3 col-lg-6">
                        <button class="btn btn-block btn-outline-primary form_submit" type="button" id="submitBtn" onclick="createFrom()">
                        <span id="btnText">Submit</span>
                        <span id="spinner" class="spinner-border spinner-border-sm d-none"></span>
                        </button>
                     </div>
                  </div>
               </form>
               <!-- Success & Error Messages -->
               <div id="success-message" class="alert alert-success d-none"></div>
               <div id="error-message" class="alert alert-danger d-none"></div>
            </div>
         </div>
         <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
   </div>
   {{--  For PAtient Create Modal End --}}
</section>
{{--  Action Button Section End --}}
<section class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="card card-default">
            <div class="card-header">
               <h3 class="card-title">Program Purchase</h3>
            </div>
            <div class="card-body p-0">
               <div class="bs-stepper linear">
                  <div class="bs-stepper-header" role="tablist">
                     <!-- your steps here -->
                     <div class="step active" data-target="#logins-part">
                        <button type="button" class="step-trigger" role="tab"
                           aria-controls="logins-part" id="logins-part-trigger" aria-selected="true">
                        <span class="bs-stepper-circle"><i class="fa fa-shopping-cart"></i></span>
                        <span class="bs-stepper-label">Carts</span>
                        </button>
                     </div>
                     <div class="line"></div>
                     <div class="step" data-target="#patient-information">
                        <button type="button" class="step-trigger" role="tab"
                           aria-controls="patient-information" id="patient-information-trigger"
                           aria-selected="false" disabled="disabled">
                        <span class="bs-stepper-circle"><i class="nav-icon fas fa-heartbeat"></i></span>
                        <span class="bs-stepper-label">Patient Information</span>
                        </button>
                     </div>
                     <div class="line"></div>
                     <div class="step" data-target="#payment_part">
                        <button type="button" class="step-trigger" role="tab"
                           aria-controls="payment_part" id="payment_part-trigger"
                           aria-selected="false" disabled="disabled">
                        <span class="bs-stepper-circle"><i class="fa fa-credit-card"></i></span>
                        <span class="bs-stepper-label">Payment</span>
                        </button>
                     </div>
                  </div>
                  <div class="bs-stepper-content">
                     <!-- Cart Page -->
                     <div id="logins-part" class="content active dstepper-block" role="tabpanel"
                        aria-labelledby="logins-part-trigger">
                        <div class="col-12">
                           <div class="table-responsive">
                              <table class="table table-bordered table-striped">
                                 <thead>
                                    <tr>
                                       <th class="cart-product-name">Product / Unit Name</th>
                                       <th class="product-subtotal">Price</th>
                                       <th class="product-subtotal">Discounted Price</th>
                                       <th class="product-quantity">No.of Session</th>
                                       <th class="product-quantity">Total</th>
                                       <th class="product-remove">Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    @php
                                    $redeem = 0;
                                    $total = 0; // Initialize total amount
                                    @endphp
                                    {{-- {{ dd($cart) }}; --}}
                                    @foreach ($cart as $key => $item)
                                    @php
                                    if($item['type']=='product')
                                    {
                                       // dd('prasad');
                                       $cart_data = App\Models\Product::find($item['unit_id']);

                                    }
                                    else {
                                       // dd('deepak');
                                        $cart_data = App\Models\ServiceUnit::find($item['unit_id']);
                                    }
                                    $subtotal = ($item['quantity'] * $cart_data->discounted_amount) ?? ($item['quantity'] * $cart_data->amount);

                                    $total += $subtotal; // Add subtotal to total
                                    @endphp
                                    <tr id="cart-item-{{ $cart_data->id }}">
                                       <td class="product-name">{{ $cart_data->product_name }}</td>
                                       <td class="product-price"><span
                                          class="amount">{{ "$" . number_format($cart_data->amount, 2) }}</span>
                                       </td>
                                       <td class="product-price"><span
                                          class="amount">{{ "$" . number_format($cart_data->discounted_amount ?? 0, 2) }}</span>
                                       </td>
                                       <td class="product-price">
                                          <form action="#" class="update-cart-form"
                                             data-id="{{ $item['unit_id'] }}">
                                             <input class="cart-input form-control"
                                             id="cart_qty_{{ $key }}"
                                             type="number"
                                             value="{{ $item['quantity'] }}"
                                             data-id="{{ $item['unit_id'] }}"
                                             min="{{ $cart_data->min_qty ?? 1 }}"
                                             max="{{ $cart_data->max_qty ?? 1 }}"
                                             onchange="updateCart('{{ $key }}')"
                                             onkeyup="updateCart('{{ $key }}')">

                                          </form>
                                       </td>
                                       <td>{{ "$" . number_format($subtotal, 2) }}</td>
                                       <!-- Subtotal -->
                                       <td>
                                          <a href="javascript:void(0)"
                                             onclick="removeFromCart('{{ $key }}')"
                                             class="btn btn-block btn-outline-danger">Remove</a>
                                       </td>
                                    </tr>
                                    @endforeach
                                    <tr style="background-color:#333;color:aliceblue" id="cart-final-total-row">
                                       <td colspan="4" class="text-end fw-bold">Final Total:</td>
                                       <td colspan="2" class="fw-bold" id="cart-final-total">${{ number_format($total, 2) }}</td>
                                    </tr>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                        <button class="btn btn-primary" onclick="stepper.next()">Next</button>
                     </div>
                     {{-- Patient Inforamtion --}}
                     <div id="patient-information" class="content" role="tabpanel"
                        aria-labelledby="patient-information-trigger">
                        <div class="form-group">
                           @if(!isset($patient))
                           <h5>Patient List</h5>
                           <table id="datatable-buttons" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#">#</th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Action">Action</th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Patient Name">Patient Name</th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Email">Email</th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Phone">Phone</th>
                                    {{-- <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Address">Address</th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Zip Code">Zip Code</th> --}}
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Status">Status</th>
                                </tr>
                            </thead>
                            <tbody id="data-table-body">
                                
                                @if(count($patients)>0)
                                @foreach($patients as $value)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>
                                        
                                        <div class="btn-group mb-2" role="group" aria-label="Quick Actions">
                                            <button class="btn btn-outline-dark btn-sm" onclick="findPatientData({{$value->id}})" title=" Select Patient">
                                                Select Patient
                                            </button>
                                        </div>

                                    </td>
                                    <td>{{$value->fname ." ".$value->lname }}</td>
                                    <td>{{$value->email }}</td>
                                    <td>{{$value->phone }}</td>
                                    {{-- <td>{{$value->address }}</td>
                                    <td>{{$value->zip_code }}</td> --}}
                                    <td>
                                        @if($value->status==1)
                                        <span class="badge bg-success">Active</span>
                                        @else
                                        <span class="badge bg-danger">Inactive</span>
                                        @endif
                                      </td>
                                 
                                
                                    <!-- Button trigger modal -->
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="8"><h3>No Program Available</h3></td>
                                </tr>
                                
                                @endif
                                
                                <br>
                                {{-- {{ $data->links() }} --}}
                            </tbody>
                        </table>
                           @endif

                           <h5>Patient Details</h5>
                           <div class="row mb-4">
                              <div class="mt-4 col-md-3">
                                 <input type="text" class="form-control" value="{{$patient->fname??''}}" readonly id="fname" name="fname"
                                    Placeholder="First Name">
                                 <input type="hidden" class="form-control" value="{{$patient->id??''}}" id="patient_id" name="patient_id"
                                    Placeholder="id">
                              </div>
                              <div class="mt-4 col-md-3">
                                 <input type="text" class="form-control" value="{{$patient->lname??''}}" readonly id="lname" name="lname"
                                    Placeholder="Last Name">
                              </div>
                              <div class="mt-4 col-md-3">
                                 <input type="email" class="form-control" value="{{$patient->email??''}}" readonly id="email" name="email"
                                    Placeholder="Email">
                              </div>
                              <div class="mt-4 col-md-3">
                                 <input type="text" class="form-control" value="{{$patient->phone??''}}" readonly id="phone" name="phone"
                                    Placeholder="Phone">
                              </div>
                           </div>
                           {{--  Table Data --}}
                           <h5 class="mb-4 mt-4">Patient Giftcards </h5>
                           <table class="table table-bordered dt-responsive nowrap w-100"border="1">
                              <thead>
                                 <tr>
                                    <th>Sl No.</th>
                                    <th>Card Number</th>
                                    <th>Balance Value Amount</th>
                                    <th>Balance Actual Amount</th>
                                    <th>Use Giftcard</th>
                                 </tr>
                              </thead>
                              <tbody id="giftcards-container">
                                 @if(isset($giftcards))
                                 @forelse($giftcards as $index => $card)
                                 <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $card['card_number'] }}</td>
                                    <td>${{ number_format($card['value_amount'], 2) }}</td>
                                    <td>${{ number_format($card['actual_paid_amount'], 2) }}</td>
                                    <td>
                                       @if($card['value_amount'] != 0)
                                       <button class="btn btn-warning" onclick="addGiftCardRow('{{ $card['card_number'] }}', '{{ $card['value_amount'] }}')">Use</button>
                                       @endif
                                    </td>
                                 </tr>
                                 @empty
                                 <tr>
                                    <td colspan="5" class="text-center text-muted">No gift cards found.</td>
                                 </tr>
                                 @endforelse
                                 @endif
                              </tbody>
                           </table>
                           {{-- Giftcard Add Section --}}
                           <div class="row justify-content-center">
                              <div class="col-md-8 mt-4 p-4 border rounded shadow-lg bg-white">
                                 <h4 class="text-center mb-4 text-primary fw-bold">Apply Gift Card</h4>
                                 <!-- Gift Card Section -->
                                 <div class="row p-3 bg-light border rounded" id="giftCardContainer">
                                    <p class="text-muted text-center w-100">No Gift Card Applied</p>
                                 </div>
                                 <!-- Payment Information -->
                                 <h4 class="mt-4 text-dark fw-bold border-bottom pb-2">Payment Information</h4>
                                 <ul class="list-unstyled mt-3">
                                    <li class="d-flex justify-content-between py-2">
                                       <span class="fw-semibold">Cart Total:</span>
                                       <span class="fw-bold text-dark" id="cart_total">${{ number_format($total, 2) }}</span>
                                    </li>
                                    <li class="d-flex justify-content-between py-2">
                                       <span class="fw-semibold">Gift Cards Applied:</span>
                                       <span class="fw-bold text-success" id="giftcard_amount">-$0.00</span>
                                    </li>
                                    <li class="d-flex justify-content-between py-2">
                                       <span class="fw-semibold">Discount:</span>
                                       <input type="number" class="form-control w-50" id="discount" value="0">
                                    </li>
                                    <li class="d-flex justify-content-between py-2">
                                       <span class="fw-semibold">Tax%:</span>
                                       <select id="tax" class="form-control w-50">
                                          <option value="0">0%</option>
                                          <option value="5">5%</option>
                                          <option value="10">10%</option>
                                          <option value="12">12%</option>
                                          <option value="18">18%</option>
                                       </select>
                                    </li>
                                    <li class="d-flex justify-content-between py-3 border-top">
                                       <strong class="fs-5">Pay Amount:</strong>
                                       <strong id="totalValue" class="text-primary fs-5"></strong>
                                    </li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                        <button class="btn btn-primary" onclick="stepper.previous()">Previous</button>
                        <button class="btn btn-primary" onclick="stepper.next()">Next</button>
                     </div>
                     {{-- Payment Section  --}}
                     <div id="payment_part" class="content" role="tabpanel" aria-labelledby="payment_part-trigger">
                        <div class="form-group">
                           <h2>Payment Details</h2>
                           <div class="row justify-content-center">
                              <div class="col-lg-6">
                                 <div class="cart-page-total shadow-lg p-4 rounded-3 bg-white">
                                    <h3 class="text-center mb-4 text-uppercase fw-bold" style="color: #333;">Billing Information</h3>
                                    <div class="row mb-4">
                                       <div class="col-md-12">
                                          <table class="table table-bordered table-striped">
                                       <tr>
                                          <th class="cart-product-name">Product / Unit Name</th>
                                          <th class="product-subtotal">Price</th>
                                          <th class="product-subtotal">Discounted Price</th>
                                          <th class="product-quantity">No.of Session</th>
                                          <th class="product-quantity">Total</th>
                                          {{-- <th class="product-remove">Action</th> --}}
                                       </tr>
                                    @foreach ($cart as $key => $item)
                                    @php
                                    if($item['type']=='product')
                                    {
                                       // dd('prasad');
                                       $cart_data = App\Models\Product::find($item['unit_id']);

                                    }
                                    else {
                                       // dd('deepak');
                                        $cart_data = App\Models\ServiceUnit::find($item['unit_id']);
                                    }
                                    $subtotal = ($item['quantity'] * $cart_data->discounted_amount) ?? ($item['quantity'] * $cart_data->amount);

                                    $total += $subtotal; // Add subtotal to total
                                    @endphp
                                    <tr id="cart-item-{{ $cart_data->id }}">
                                       <td class="product-name">{{ $cart_data->product_name }}</td>
                                       <td class="product-price"><span
                                          class="amount">{{ "$" . number_format($cart_data->amount, 2) }}</span>
                                       </td>
                                       <td class="product-price"><span
                                          class="amount">{{ "$" . number_format($cart_data->discounted_amount ?? 0, 2) }}</span>
                                       </td>
                                       <td class="product-price">{{ $item['quantity'] }}
                                          {{-- <form action="#" class="update-cart-form"
                                             data-id="{{ $item['unit_id'] }}">
                                             <input class="cart-input form-control"
                                             id="cart_qty_{{ $key }}"
                                             type="number"
                                             value="{{ $item['quantity'] }}"
                                             data-id="{{ $item['unit_id'] }}"
                                             min="{{ $cart_data->min_qty ?? 1 }}"
                                             max="{{ $cart_data->max_qty ?? 1 }}"
                                             onchange="updateCart('{{ $key }}')"
                                             onkeyup="updateCart('{{ $key }}')">

                                          </form> --}}
                                       </td>
                                       <td>{{ "$" . number_format($subtotal, 2) }}</td>
                                       <!-- Subtotal -->
                                       {{-- <td>
                                          <a href="javascript:void(0)"
                                             onclick="removeFromCart('{{ $key }}')"
                                             class="btn btn-block btn-outline-danger">Remove</a>
                                       </td> --}}
                                    </tr>
                                    @endforeach
                                    </table>
                                       </div>
                                    </div>


                                    <ul class="list-unstyled border-top pt-3">
                                       <li class="d-flex justify-content-between py-2">
                                          <span>Cart Total:</span>
                                          <span class="fw-bold text-dark" id="finalcart_total">$</span>
                                       </li>
                                       <li class="d-flex justify-content-between py-2">
                                          <span>Gift Cards Applied:</span>
                                          <span class="fw-bold text-success" id="giftcard_amount_payment">-$0.00</span>
                                       </li>
                                       <li class="d-flex justify-content-between py-2">
                                          <span>Discount:</span>
                                          <span class="fw-bold text-success" id="discount_amount_payment">-$0.00</span>
                                       </li>
                                       <li class="d-flex justify-content-between py-2">
                                          <span>Tax:</span>
                                          <span class="fw-bold text-warning" id="tax_amount_payment">$0.00</span>
                                       </li>
                                       <li class="d-flex justify-content-between py-3 border-top">
                                          <strong>Pay Amount:</strong>
                                          <strong id="totalValuePayment" class="text-primary fs-5">${{ number_format($amount, 2) }}</strong>
                                       </li>
                                       <li class="d-flex justify-content-between py-3 border-top">
                                          <strong>Payment Status</strong>
                                          <select name="payment_status" class="form-control" id="payment_status">
                                             <option value="paid" selected>Success</option>
                                             <option value="under_process">Process</option>
                                             <option value="fail">Fail</option>
                                          </select>
                                       </li>
                                       <li class="d-flex justify-content-between py-3 border-top">
                                          <button type="submit" class="btn btn-primary" id="submitPayment">Submit</button>
                                       </li>
                                       <li class="d-flex justify-content-between text-danger py-3 border-top">
                                          <div id="errorMessages" class="alert alert-danger" style="display: none;"></div>
                                       </li>
                                    </ul>
                                 </div>
                              </div>
                           </div>
                           <!-- Form Section -->
                           <button type="button" class="btn btn-primary" onclick="stepper.previous()">Previous</button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- /.card-body -->
         </div>
         <!-- /.card -->
      </div>
   </div>
</section>
@endsection
@push('script')
<!-- jQuery and jQuery UI -->
<script>
   //  Create Slug 
   function slugCreate() {
       $.ajax({
           url: '{{ route('slugCreate') }}',
           method: "post",
           dataType: "json",
           data: {
               _token: '{{ csrf_token() }}',
               product_name: $('#product_name').val(),
           },
           success: function(response) {
               if (response.success) {
                   $('#product_slug').val(response.slug);
               } else {
                   $('.showbalance').html(response.error).show();
               }
           }
       });
   }
   // Create Slug End
   function removeFromCart(id) {
       // alert(id);
       $.ajax({
           url: '{{ route('cartremove') }}',
           method: "POST",
           dataType: "json",
           data: {
               _token: '{{ csrf_token() }}',
               product_id: id
           },
           success: function(response) {
               if (response.success) {
                   // Update the cart view, e.g., remove the item from the DOM
                   $('#cart-item-' + id).remove();
                    toastr.success(response.success);
                   location.reload();
               } else {
                   alert(response.error);
               }
           },
           error: function(jqXHR, textStatus, errorThrown) {
               alert('An error occurred. Please try again.');
           }
       });
   }
   
   //  For Data Featch From Patient Table
   
   function findPatientData(id) {
   $.ajax({
   url: '{{ route('patient-data') }}', // Laravel route
   method: "POST",
   dataType: "json",
   data: {
       _token: '{{ csrf_token() }}',
       search: id // Get email input value
   },
   success: function(response) {
       if (response.status === 'success') {
           let patient_data = response.patient;
           let giftcards = response.giftcards;
   
           // Populate form fields with patient data
           $('#fname').val(patient_data['fname']).trigger('input');
           $('#lname').val(patient_data['lname']).trigger('input');
           $('#email').val(patient_data['email']).trigger('input');
           $('#phone').val(patient_data['phone']);
           $('#patient_id').val(patient_data['patient_id']);
   
           // Update gift card container
           let giftcardsContainer = $('#giftcards-container');
           giftcardsContainer.empty(); // Clear previous entries
           if (giftcards.length > 0) {
               giftcards.forEach(function(card, index) {
                   let giftcardRow = `
                       <tr>
                           <td>${index + 1}</td>
                           <td>${card.card_number}</td>
                           <td>$${card.value_amount}</td>
                           <td>$${card.actual_paid_amount}</td>
                           <td>${card.value_amount != 0 ? `<button class="btn btn-warning" onclick="addGiftCardRow('${card.card_number}', '${card.value_amount}')">Use</button>` : ''}</td>
                       </tr>
                   `;
                   giftcardsContainer.append(giftcardRow);
               });
           } else {
               giftcardsContainer.append('<tr><td colspan="5" class="text-center">No gift cards found.</td></tr>');
           }
   
           // **validate form **
           validateForm();
       } else {
           alert(response.message || 'No patient data found.');
       }
   },
   error: function(jqXHR, textStatus, errorThrown) {
       console.error('AJAX error:', textStatus, errorThrown);
       alert('An error occurred. Please try again.');
   }
   });
   }
   
   

// For All Giftcard Calculation, Tax, Discount and Total Calculation 

   document.addEventListener("DOMContentLoaded", function () {
       
       // Get required elements
      const cartTotal = parseFloat($('#cart_total').text().replace('$', '')) || 0;
       const discountInput = document.getElementById("discount");
       const taxSelect = document.getElementById("tax");

       const totalValue = document.getElementById("totalValue");
       const totalValuePayment = document.getElementById("totalValuePayment");// For Payment Page Total Value
       const giftCardAmountDisplay = document.getElementById("giftcard_amount");
       const discountDisplay = document.getElementById("discount_amount_payment");
       const taxDisplay = document.getElementById("tax_amount_payment");
       const paymentGiftCardDisplay = document.getElementById("giftcard_amount_payment");
       const giftCardContainer = document.getElementById("giftCardContainer");
   
       let appliedGiftCards = new Set(); // Store applied gift card numbers
   
       // Function to calculate the total applied gift card amount
       window.calculateGiftCardTotal = function() {
       let totalGiftCardAmount = 0;
           document.querySelectorAll("input[name='gift_card_amount[]']").forEach(input => {
               let value = parseFloat(input.value) || 0;
               let maxValue = parseFloat(input.getAttribute("max")) || 0;
   
               if (value > maxValue) {
                   input.value = maxValue; // Prevent exceeding max value
                   value = maxValue;
               }
   
               totalGiftCardAmount += value;
           });
   
           giftCardAmountDisplay.textContent = `-$${totalGiftCardAmount.toFixed(2)}`;
           paymentGiftCardDisplay.textContent = `-$${totalGiftCardAmount.toFixed(2)}`;
   
           return totalGiftCardAmount;
       }
   
       // Function to calculate the total amount
       function calculateTotal() {
           const discount = parseFloat(discountInput?.value) || 0;
           const tax = parseFloat(taxSelect?.value) || 0;
           const giftCardTotal = calculateGiftCardTotal();

           const subtotal = Math.max(cartTotal - giftCardTotal - discount, 0);
           const taxAmount = (subtotal * tax) / 100;
           const total = subtotal + taxAmount;  
         $('#finalcart_total').text(`$${cartTotal.toFixed(2)}`);
           totalValue.textContent = `$${total.toFixed(2)}`;
           totalValuePayment.textContent = `$${total.toFixed(2)}`;
           discountDisplay.textContent = `-$${discount.toFixed(2)}`;
           taxDisplay.textContent = `$${taxAmount.toFixed(2)}`;
       }
   
       // Function to add a gift card row
       window.addGiftCardRow = function (card_number, gift_card_amount) {
           if (appliedGiftCards.has(card_number)) {
               alert("This gift card is already applied.");
               return;
           }
   
           let newRow = document.createElement("div");
           newRow.classList.add("row", "mb-2");
           newRow.innerHTML = `
               <div class="col-md-5">
                   <input type="text" class="form-control" name="card_number[]" value="${card_number}" readonly>
               </div>
               <div class="col-md-5">
                   <input type="number" class="form-control gift_card_input" name="gift_card_amount[]" value="${gift_card_amount}" max="${gift_card_amount}">
               </div>
               <div class="col-md-2">
                   <button type="button" class="btn btn-danger remove-gift-card">Remove</button>
               </div>
           `;
   
           giftCardContainer.appendChild(newRow);
           appliedGiftCards.add(card_number); // Add to set
   
           // Bind event listeners to the new elements
           newRow.querySelector(".gift_card_input").addEventListener("input", calculateTotal);
           newRow.querySelector(".remove-gift-card").addEventListener("click", function () {
               removeGiftCardRow(this, card_number);
           });
   
           calculateTotal();
       };
   
       // Function to remove a gift card row
       window.removeGiftCardRow = function (button, card_number) {
           appliedGiftCards.delete(card_number); // Remove from set
           button.closest(".row").remove();
           calculateTotal();
       };
   
       // Event listeners
       discountInput?.addEventListener("input", calculateTotal);
       taxSelect?.addEventListener("change", calculateTotal);
   
       // Initial calculation on page load
       calculateTotal();
   });

//  For All Giftcard Calculation, Tax, Discount and Total Calculation 
//   For Payment of Cart

document.addEventListener("DOMContentLoaded", function () {
    const fnameField = document.getElementById("fname");
    const lnameField = document.getElementById("lname");
    const emailField = document.getElementById("email");
    const phoneField = document.getElementById("phone");
    const patient_id = document.getElementById("patient_id");
    const submitButton = document.getElementById("submitPayment");
    const errorMessagesDiv = document.getElementById("errorMessages");

    submitButton.addEventListener("click", function (e) {
        e.preventDefault();

        // Collect gift cards
        let giftCards = [];
        const cardNumbers = document.querySelectorAll("input[name='card_number[]']");
        const cardAmounts = document.querySelectorAll("input[name='gift_card_amount[]']");

        cardNumbers.forEach((input, index) => {
            giftCards.push({
                card_number: input.value.trim(),
                amount: cardAmounts[index]?.value.trim() || 0
            });
        });

        // Build form data
        let formData = {
            cart_total: {!! json_encode($total) !!},
            discount: document.getElementById("discount")?.value || 0,
            tax: $("#tax_amount_payment").text().replace("$", "").trim() || 0,
            gift_cards: giftCards.length > 0 ? giftCards : [],
            pay_amount: document.getElementById("totalValuePayment")?.textContent.replace("$", "").trim() || 0,
            payment_status: document.getElementById("payment_status")?.value || "",
            _token: "{{ csrf_token() }}",
            patient_id:patient_id?.value.trim() || "",
            fname: fnameField?.value.trim() || "",
            lname: lnameField?.value.trim() || "",
            email: emailField?.value.trim() || "",
            phone: phoneField?.value.trim() || "",
            giftapply: $("#giftcard_amount_payment").text().replace("$", "").trim() || 0
        };

        // Clear previous errors
        errorMessagesDiv.style.display = "none";
        errorMessagesDiv.innerHTML = "";

        // Send AJAX
        $.ajax({
            url: "{{ route('InternalServicePurchases') }}",
            type: "POST",
            data: formData,
            success: function (response) {
                alert("Payment details submitted successfully!");
                if (response.invoice_id) {
                    window.location.href = "{{ url('/admin/invoice') }}/" + response.invoice_id;
                }
                console.log(response);
            },
            error: function (xhr) {
               // Debug alert
               

               if (xhr.status === 422 && xhr.responseJSON?.errors) {
                  // Laravel validation error
                  let errors = xhr.responseJSON.errors;
                  let errorHtml = "<ul>";

                  Object.keys(errors).forEach(function (key) {
                        errorHtml += `<li>${errors[key][0]}</li>`;
                  });

                  errorHtml += "</ul>";
                  errorMessagesDiv.innerHTML = errorHtml;
                  errorMessagesDiv.style.display = "block";
               } else {
                  // Show generic error
                  errorMessagesDiv.innerHTML = `<p>Something went wrong. Please Fill Required Fields.</p>`;
                  errorMessagesDiv.style.display = "block";

                  console.error("AJAX Error: ", xhr.responseText);
               }
}

        });
    });
});


   // Update Cart
   function updateCart(cart_id) {
   var quantity = $('#cart_qty_' + cart_id).val();
   var min = parseInt($('#cart_qty_' + cart_id).attr('min'));
   var max = parseInt($('#cart_qty_' + cart_id).attr('max'));
   
   if (quantity <= 0) {
   alert("Quantity must be at least 1");
   return;
   }
   if (quantity < min || quantity > max) {
   alert('Quantity must be between ' + min + ' and ' + max + '.');
   location.reload();
   return false;
   }
   
   // Send AJAX request to update the cart
   $.ajax({
   url: '{{ route('update-cart') }}',
   method: 'POST',
   data: {
       quantity: quantity,
       key: cart_id,
       _token: '{{ csrf_token() }}'
   },
   success: function(response) {
       console.log("AJAX response:", response);
       if (response.success) {
           let updatedItems = response.cartItems;
           let cartTotal = 0;
   
           // Loop through updated cart items
           for (const key in updatedItems) {
               if (updatedItems.hasOwnProperty(key)) {
                   const item = updatedItems[key];
                  console.log('item', item);
                  
                   const priceText = $('#cart-item-' + item.unit_id + ' .product-price').eq(0).text().replace('$', '');
                   const discountedPriceText = $('#cart-item-' + item.unit_id + ' .product-price').eq(1).text().replace('$', '');
   
                   const price = parseFloat(discountedPriceText) > 0 ? parseFloat(discountedPriceText) : parseFloat(priceText);
                   const quantity = parseInt(item.quantity);
                   const subtotal = price * quantity;
                   cartTotal += subtotal;
   
                   // Update subtotal column
                   $('#cart-item-' + item.unit_id + ' td:nth-child(5)').text('$' + subtotal.toFixed(2));
               }
           }
   
           // Update displayed cart total
           $('#cart-final-total').text('$' + cartTotal.toFixed(2));
           $('#cart_total').text('$' + cartTotal.toFixed(2));
           $('#finalcart_total').text('$' + cartTotal.toFixed(2));
           
   
           // Calculate gift card, discount, tax, and grand total
           var giftCardTotal = calculateGiftCardTotal();
           var discount = parseFloat($('#discount').val()) || 0;
           var tax = parseFloat($('#tax').val()) || 0;
   
           const subtotalAfterDiscounts = Math.max(cartTotal - giftCardTotal - discount, 0);
           const taxAmount = (subtotalAfterDiscounts * tax) / 100;
           const grandTotal = subtotalAfterDiscounts + taxAmount;
           $('#totalValue').text('$' + grandTotal.toFixed(2));
       }
       location.reload();
   }
   });
   }
    

   function CheckUser() {
   var user_name = $('#patient_login_id').val();
   
   // Clear previous error messages
   $('#error-username').text(''); // Specific to the username error field
   $('.showbalance').hide(); // Hide previous success/error messages
   
   $.ajax({
       url: '{{ route('checkusername') }}',
       method: 'post',
       dataType: 'json',
       data: {
           _token: '{{ csrf_token() }}',
           username: user_name,
       },
       success: function(response) {
           if (response.success) {
               $('.showbalance').html(response.message).css('color', 'green').show();
           } else {
               $('.showbalance').html(response.message).css('color', 'red').show();
           }
       },
       error: function(xhr) {
           console.log(xhr.responseText);
       }
   });
   }

   function createFrom() {
   let formData = new FormData(document.getElementById("patientForm"));
   
   // Disable button, show spinner, and update text
   $("#submitBtn").prop("disabled", true);
   $("#btnText").text("Submitting...");
   $("#spinner").removeClass("d-none");
   
   $.ajax({
       url: "{{ route('patient-quick-create') }}",
       type: "POST",
       data: formData,
       processData: false,
       contentType: false,
       headers: {
           'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ensure correct CSRF token is used
       },
       success: function (response) {
           $("#submitBtn").prop("disabled", false);
           $("#btnText").text("Submit");
           $("#spinner").addClass("d-none");
   
           if (response.success) {
               $("#success-message").removeClass("d-none").text(response.message);
               $("#error-message").addClass("d-none");
               
               setTimeout(function () {
                   location.reload();
               }, 2000);
           } else {
               $("#error-message").removeClass("d-none").text(response.message);
               $("#success-message").addClass("d-none");
           }
       },
       error: function (xhr) {
           $("#submitBtn").prop("disabled", false);
           $("#btnText").text("Submit");
           $("#spinner").addClass("d-none");
   
           let errors = xhr.responseJSON?.errors;
           $(".text-danger").text(""); // Clear previous errors
   
           if (errors) {
               $.each(errors, function (key, value) {
                   $("#error-" + key).text(value[0]);
               });
           } else {
               $("#error-message").removeClass("d-none").text("Something went wrong!");
           }
       }
   });
   } 
   

    $(function () {
      $("#datatable-buttons").DataTable({
        "responsive": true, "lengthChange": true, "autoWidth": false,
      }).buttons().container().appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>
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
</script>  --}}

@endpush