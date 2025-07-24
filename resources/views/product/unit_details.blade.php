@extends('layouts.front_product')
@section('body')
@push('css')
.product__details-action {
   display: flex;
   flex-wrap: wrap;
   gap: 20px 15px;
}

.product__quantity .product-quantity-wrapper .cart-input {
   height: 60px;
   width: 170px;
   text-align: center;
   font-size: 16px;
   border: none;
   display: inline-block;
   vertical-align: middle;
   margin: 0 -3px;
   padding-bottom: 4px;
   background: transparent;
   color: #fca52a;;
   font-weight: var(--bd-fw-medium);
}
.product__quantity .product-quantity-wrapper {
   position: relative;
   width: 160px;
   height: 60px;
   line-height: 60px;
   border: 1px solid var(--clr-border-2);
   -webkit-border-radius: 30px;
   -moz-border-radius: 30px;
   -o-border-radius: 30px;
   -ms-border-radius: 30px;
   border-radius: 30px;
}
.product__quantity .product-quantity-wrapper .cart-minus {
   position: absolute;
   top: 50%;
   left: 10px;
   transform: translateY(-50%);
   width: 30px;
   height: 30px;
   line-height: 30px;
   display: inline-block;
   vertical-align: middle;
   text-align: center;
   font-size: 16px;
   background: transparent;
   color: #9e9e9e;
   border: 0;
}
.product__quantity .product-quantity-wrapper .cart-qty {
   position: absolute;
   top: 50%;
   left: 10px;
   transform: translateY(-50%);
   width: 30px;
   height: 30px;
   line-height: 30px;
   display: inline-block;
   vertical-align: middle;
   text-align: center;
   font-size: 16px;
   background: transparent;
   color: #9e9e9e;
   border: 0;
}

.product__quantity .product-quantity-wrapper .cart-plus {
   position: absolute;
   top: 50%;
   right: 10px;
   transform: translateY(-50%);
   width: 30px;
   height: 30px;
   line-height: 30px;
   display: inline-block;
   vertical-align: middle;
   text-align: center;
   font-size: 16px;
   background: transparent;
   color: #9e9e9e;
   border: 0;
}


@endpush
@section('body')
!-- Body main wrapper start -->
   <main>

      <!-- Breadcrumb area start  -->
      <div class="breadcrumb__area theme-bg-1 p-relative z-index-11 pt-95 pb-95">
         <div class="breadcrumb__thumb" data-background="{{url('/uploads/FOREVER-MEDSPA')}}/med-spa-banner.jpg"></div>
         <div class="container">
            <div class="row justify-content-center">
               <div class="col-xxl-12">
                  <div class="breadcrumb__wrapper text-center">
                     <h2 class="breadcrumb__title">{{$unit->product_name}}</h2>
                     <div class="breadcrumb__menu">
                        <nav>
                           <ul>
                              <li><span><a href="{{url('/')}}">Home</a></span></li>
                              <li><span>{{$unit->product_name}}</span></li>
                           </ul>
                        </nav>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Breadcrumb area start  -->

      <!-- Product details area start -->
      <div class="product__details-area section-space-medium">
         <div class="container">
            <div class="row align-items-center">
               <div class="col-xxl-6 col-lg-6">
                  <div class="product__details-thumb-wrapper d-sm-flex align-items-start mr-50">
                     <div class="product__details-thumb-tab mr-20">
                        <nav>
                           <div class="nav nav-tabs flex-nowrap flex-sm-column" id="nav-tab" role="tablist">
                               @foreach($image as $key=>$image_name)
                               @if($key<=2)
                              <button class="nav-link {{$key==0?'active':''}}" id="img-{{$key}}-tab" data-bs-toggle="tab"
                                 data-bs-target="#img-{{$key}}" type="button" role="tab" aria-controls="img-{{$key}}"
                                 aria-selected="true">
                                 <img src="{{$image_name}}" alt="product-sm-thumb" onerror="this.onerror=null; this.src='{{url('/No_Image_Available.jpg')}}';">
                              </button>
                              @endif
                              @endforeach
                           </div>
                        </nav>
                     </div>
                     <div class="product__details-thumb-tab-content">
                        <div class="tab-content" id="productthumbcontent">
                          
                           @foreach($image as $key=>$image_name)
                           @if($key<=2)
                           <div class="tab-pane fade {{$key==0?'show active':''}}" id="img-{{$key}}" role="tabpanel"
                              aria-labelledby="img-{{$key}}-tab">
                              <div class="product__details-thumb-big w-img">
                                 <img src="{{$image_name}}" alt="" onerror="this.onerror=null; this.src='{{url('/No_Image_Available.jpg')}}';">
                              </div>
                           </div>
                           @endif
                           @endforeach
                          
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xxl-6 col-lg-6">
                  <div class="product__details-content pr-80">
                     
                     <h3 class="product__details-title">{{$unit->product_name}}</h3>
                     <div class="product__details-price">
                        @if($unit->discounted_amount!=null)
                        <span class="old-price">${{$unit->amount}}</span>
                        <span class="new-price">${{$unit->discounted_amount}}</span>
                        @else
                        <span class="new-price">${{$unit->amount}}</span>
                        @endif

                     </div>
                     <p>{!! $unit->short_description !!}</p>

                     <div class="product__details-action mb-35">
                        <div class="product__quantity">
                           <div class="product-quantity-wrapper">
                             
                                 {{-- <button class="cart-minus"><i class="fa-light fa-minus"></i></button> --}}
                                 <layout class="cart-qty">Qty:</layout>
                                <input 
                                 class="cart-input" 
                                 id="qty_{{$unit->id}}"
                                 type="number" 
                                 value="{{$unit->min_qty}}" 
                                 min="{{$unit->min_qty}}" 
                                 max="{{$unit->max_qty}}" 
                              >
                                 {{-- <button class="cart-plus"><i class="fa-light fa-plus"></i></button> --}}
                           </div>
                        </div>
                        <div class="product__add-cart">
                           <a href="javascript:void(0)" class="fill-btn cart-btn" onclick="addcart({{$unit->id}})">
                              <span class="fill-btn-inner">
                                 <span class="fill-btn-normal">Add To Cart<i
                                       class="fa-solid fa-basket-shopping"></i></span>
                                 <span class="fill-btn-hover">Add To Cart<i
                                       class="fa-solid fa-basket-shopping"></i></span>
                              </span>
                           </a>
                        </div>
                       
                     </div>
                     {{--  For Shar on Social media --}}
                     {{-- <div class="product__details-share">
                        <span>Share:</span>
                        <a href="http://www.facebook.com/sharer.php?u={{url()->current()}}"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="https://twitter.com/share?url={{url()->current()}}"><i class="fa-brands fa-twitter"></i></a>
                        <a href="https://instagram.com/api/v1/media/upload/{{url()->current()}}"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                     </div> --}}
                     {{--  For Shar on Social media --}}
                  </div>
               </div>
            </div>
            <div class="product__details-additional-info section-space-medium-top">
               <div class="row">
                  <div class="col-xxl-3 col-xl-4 col-lg-4">
                     <div class="product__details-more-tab mr-15">
                        <nav>
                           <div class="nav nav-tabs flex-column " id="productmoretab" role="tablist">
                              <button class="nav-link active" id="nav-description-tab" data-bs-toggle="tab"
                                 data-bs-target="#nav-description" type="button" role="tab"
                                 aria-controls="nav-description" aria-selected="true">Description</button>
                              
                              <button class="nav-link" id="nav-review-tab" data-bs-toggle="tab"
                                 data-bs-target="#nav-review" type="button" role="tab" aria-controls="nav-review"
                                 aria-selected="false">Terms & Conditions</button>
                           </div>
                        </nav>
                     </div>
                  </div>
                  <div class="col-xxl-9 col-xl-8 col-lg-8">
                     <div class="product__details-more-tab-content">
                        <div class="tab-content" id="productmorecontent">

                           <div class="tab-pane fade show active" id="nav-description" role="tabpanel"
                              aria-labelledby="nav-description-tab">
                              <div class="product__details-des">
                                 {!! $unit->product_description !!}
                              </div>
                           </div>

                           <div class="tab-pane fade show" id="nav-review" role="tabpanel"
                           aria-labelledby="nav-review-tab">
                           <a href="{{url('/generate-pdf',$unit->terms_id)}}" class="fill-btn cart-btn">
                              <span class="fill-btn-inner">
                                 <span class="fill-btn-normal">Download Terms & Conditions<i class="fa-regular fa-file"></i></i></span>
                                 <span class="fill-btn-hover">Download Terms & Conditions<i class="fa-regular fa-file"></i></i></span>
                              </span>
                           </a>
                           <div class="product__details-des">
                              {!! $unit->terms_and_conditions !!}
                           </div>
                        </div>
                            
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Product details area end -->

   </main>
   <!-- Body main wrapper end -->
@endsection

@push('footerscript')
<script>
  function addcart(id) {
    var qty = parseInt($('#qty_' + id).val()); // Get the entered quantity
    var min = parseInt($('#qty_' + id).attr('min')); // Get the min value
    var max = parseInt($('#qty_' + id).attr('max')); // Get the max value

    // Check if qty is outside the range
    if (qty < min || qty > max) {
        alert('Quantity must be between ' + min + ' and ' + max + '.');
        $('#qty_' + id).val(min);
        return false; // Stop the execution if invalid
    }

    // Proceed with the AJAX request if valid
    $.ajax({
        url: '{{ route('cart') }}',
        method: "post",
        dataType: "json",
        data: {
            _token: '{{ csrf_token() }}',
            unit_id: id,
            quantity: qty,
            type: "unit",
        },
        success: function (response) {
            if (response.success) {
                window.location.href = '{{ route('cartview') }}'; 
            } else {
                $('.showbalance').html(response.error).show();
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            // Handle the error here
            $('.showbalance').html('An error occurred. Please try again.').show();
        }
    });
}


</script>

{{-- <script>
   function validateQuantity(input) {
       const min = parseInt(input.min, 10);
       const max = parseInt(input.max, 10);
       const value = parseInt(input.value, 10);

       if (value > max) {
           alert(`The value cannot be greater than ${max}.`);
           input.value = max; // Reset to max value
       } else if (value < min) {
           alert(`The value cannot be less than ${min}.`);
           input.value = min; // Reset to min value
       }
   }
</script> --}}
@endpush
