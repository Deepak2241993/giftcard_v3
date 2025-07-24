@extends('layouts.front_product')
@section('body')
@push('css')

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
                     <h2 class="breadcrumb__title">{{$data->product_name}}</h2>
                     <div class="breadcrumb__menu">
                        <nav>
                           <ul>
                              <li><span><a href="{{url('/')}}">Home</a></span></li>
                              <li><span>{{$data->product_name}}</span></li>
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
                              @php 
                              $image= explode('|',$data->product_image)
                              @endphp
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
                     
                     <h3 class="product__details-title">{{$data->product_name}}</h3>
                     <div class="product__details-price">
                        @if($data->discounted_amount!=null)
                        {{-- <span class="old-price">${{$data->amount}}</span> --}}
                        <span class="new-price">${{$data->discounted_amount}}</span>
                        @else
                        <span class="new-price">${{$data->amount}}</span>
                        @endif

                     </div>
                     <p>{!! $data->short_description !!}</p>

                     <div class="product__details-action mb-35">
                        <div class="product__quantity">
                           <div class="product-quantity-wrapper">
                              <form action="#">
                                 <button class="cart-minus">Session : {{$data->session_number}}</button>
                                
                              </form>
                           </div>
                        </div>
                        <div class="product__add-cart">
                           <a href="javascript:void(0)" class="fill-btn cart-btn" onclick="addcart({{$data->id}})">
                              <span class="fill-btn-inner">
                                 <span class="fill-btn-normal">Add To Cart<i
                                       class="fa-solid fa-basket-shopping"></i></span>
                                 <span class="fill-btn-hover">Add To Cart<i
                                       class="fa-solid fa-basket-shopping"></i></span>
                              </span>
                           </a>
                        </div>
                       
                     </div>
                     
                     <div class="product__details-share">
                        <span>Share:</span>
                        <a href="http://www.facebook.com/sharer.php?u={{url()->current()}}"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="https://twitter.com/share?url={{url()->current()}}"><i class="fa-brands fa-twitter"></i></a>
                        <a href="https://instagram.com/api/v1/media/upload/{{url()->current()}}"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                     </div>
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
                              <button class="nav-link" id="nav-additional-tab" data-bs-toggle="tab"
                                 data-bs-target="#nav-additional" type="button" role="tab"
                                 aria-controls="nav-additional" aria-selected="false">Prerequisites Information </button>
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
                                 {!! $data->product_description !!}
                              </div>
                           </div>
                           <div class="tab-pane fade" id="nav-additional" role="tabpanel"
                              aria-labelledby="nav-additional-tab">
                              <div class="product__details-info">
                                 {!! $data->prerequisites !!}
                              </div>
                           </div>
                           <div class="tab-pane fade" id="nav-review" role="tabpanel"
                           aria-labelledby="nav-review-tab">
                              <div class="product__details-info">
                                 <div style="text-align:end">
                                 <a href="{{url('/generate-pdf',$data->terms_id)}}" class="fill-btn cart-btn">
                                    <span class="fill-btn-inner">
                                       <span class="fill-btn-normal">Download Terms & Conditions<i class="fa-regular fa-file"></i></i></span>
                                       <span class="fill-btn-hover">Download Terms & Conditions<i class="fa-regular fa-file"></i></i></span>
                                    </span>
                                 </a>
                                 </div>
                                 <hr>
                                 <div class="mt-4">
                                 
                                 {!! $data->terms_and_conditions !!}
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
      <!-- Product details area end -->

   </main>
   <!-- Body main wrapper end -->
@endsection

@push('footerscript')
<script>
   function addcart(id) {
    $.ajax({
        url: '{{ route('cart') }}',
        method: "post",
        dataType: "json",
        data: {
            _token: '{{ csrf_token() }}',
            product_id: id,
            quantity: 1,
            type: "product"
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
@endpush
