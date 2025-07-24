
@extends('layouts.front_product')
@section('body')
@push('css')
<!-- CSS here -->

<style>
   main {
      margin-top: 100px;
   }
.theme-bg-3{
   background: #fca52a;
}
.fill-btn-hover{
   color:#ffffff;
}
.fill-btn{
background-color: black;
}
.fill-btn::before {
   background-color: #fca52a;
}
.breadcrumb__wrapper .nav_class {
    height: 40px;
    width: 350px;
    border: 1px solid;
    border-radius: 8px;
    text-align: center;
    padding: 10px;
    border-color: #FCA52A;
    background-color: rgba(252, 165, 42, 0.75); /* Set background opacity to 75% */
    color: white; /* Ensuring text color is white */
}

.breadcrumb__wrapper .nav_class:hover {
    border-color: #FCA52A; /* Keep the same border color or change it if needed */
    background-color: rgba(252, 165, 42, 1); /* Optionally, make the background fully opaque on hover */
   
}
.breadcrumb__wrapper .nav_class h6 {
    opacity: 1; /* Full opacity for the text */
}


input[type=text] {
    background-color: #ffffff;
    width: 100%;
}

   @media (max-width: 767px) {
      main {
      margin-top: 20px;
   }
   .navbar-toggler span + span {
    margin-top: 10px;
}
   
}
</style>
{{-- Search box Style --}}
<style>
   * {
     box-sizing: border-box;
   }
   
   body {
     font: 16px Arial;  
   }
   
   /*the container must be positioned relative:*/
   .autocomplete {
     position: relative;
     display: inline-block;
   }
   
   input {
     border: 1px solid transparent;
     background-color: #f1f1f1;
     padding: 10px;
     font-size: 16px;
   }
   
   input[type=text] {
     background-color: #ffffff;
     width: 100%;
   }
   
   input[type=submit] {
     background-color: DodgerBlue;
     color: #fff;
     cursor: pointer;
   }
   
   .autocomplete-items {
     position: absolute;
     border: 1px solid #d4d4d4;
     border-bottom: none;
     border-top: none;
     z-index: 99;
     /*position the autocomplete items to be the same width as the container:*/
     top: 100%;
     left: 0;
     right: 0;
   }
   
   .autocomplete-items div {
     padding: 10px;
     cursor: pointer;
     background-color: #fff; 
     border-bottom: 1px solid #d4d4d4; 
   }
   
   /*when hovering an item:*/
   .autocomplete-items div:hover {
     background-color: #e9e9e9; 
   }
   
   /*when navigating through the items using the arrow keys:*/
   .autocomplete-active {
     background-color: DodgerBlue !important; 
     color: #ffffff; 
   }
   /* For Discount  */
   .hl05eU .Nx9bqj {
    display: inline-block;
    font-size: 16px;
    font-weight: 500;
    color: #212121;
}
.hl05eU .UkUFwK {
    color: #FCA52A;
    font-size: 16px;
    letter-spacing: -.2px;
    font-weight: 500;
}
.hl05eU .UkUFwK, .hl05eU .yRaY8j {
    display: inline-block;
    margin-left: 8px;
}

.nav {
    border-color: orange;
    --bs-nav-tabs-link-active-color: #fca52a;
    --bs-nav-tabs-link-active-border-color: #fca52a #fca52a #f6f6f6;
}

   </style>
@endpush

<body>

   <!-- Back to top start -->
   <div class="backtotop-wrap cursor-pointer">
      <svg class="backtotop-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
         <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
      </svg>
   </div>
   <!-- Back to top end -->

   <!-- Body main wrapper start -->
   <main>

      <!-- Breadcrumb area start  -->
      <div class="breadcrumb__area theme-bg-1 p-relative z-index-11 pt-95 pb-95">
         <div class="breadcrumb__thumb" data-background="{{url('/uploads/FOREVER-MEDSPA')}}/med-spa-banner.jpg"></div>
         <div class="container">
            <div class="row justify-content-center">
               <div class="col-xxl-12">
                  <div class="breadcrumb__wrapper text-center">
                     <h4 class="breadcrumb__title">Welcome to the world of Forever Medspa.</h4>
                     <center><div class="nav_class">
                        <h6 style="color: white;opacity: 100%;">Avail these amazing Services Now!</h6>
                     </div>
                  </center>
                     <div class="breadcrumb__menu">
                        <nav>
                           <ul>
                              <li><span><a href="index.html">Home</a></span></li>
                              <li><span>Services</span></li>
                           </ul>
                        </nav>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Breadcrumb area start  -->

      <!-- Postbox details area start -->
      <section class="postbox__area grey-bg-4 section-space">
         <div class="container">
            <div class="row gy-50">
               <div class="col-xxl-8 col-lg-8">
                  <div class="postbox__wrapper">
                     @if(isset($data))
                     @foreach($data as $value) 
                     <article class="postbox__item mb-50 transition-3">
                        <div class="postbox__thumb w-img mb-30">
                           <a href="{{route('productdetails',['slug' => $value['product_slug']])}}">
                              @php 
                              $image= explode('|',$value['product_image'])
                              @endphp
                              <img src="{{$image[0]}}" alt="" onerror="this.onerror=null; this.src='{{url('/No_Image_Available.jpg')}}';">
                           </a>
                        </div>
                        <div class="postbox__content">
                         
                           <h3 class="postbox__title">
                              <a href="{{route('productdetails',['slug' => $value['product_slug']])}}">{{$value['product_name']}}</a>
                          </h3>
                           <div class="hl05eU">
                              @if($value['discounted_amount']!=null)
                              {{-- <del class="yRaY8j"><b>${{$value['amount']}}</b></del>&nbsp;&nbsp; --}}
                              <div class="Nx9bqj"><b>{{ "$".$value['discounted_amount']}}</b></div>
                              {{-- <div class="UkUFwK"><span><b>{{$value['discount_rate'] >0 ? $value['discount_rate']:0}}% off</b></span> </div>  &nbsp;<b>for {{ $value->session_number }} Sessions</b> --}}
                              @endif
                              @if($value['amount']!=null)
                              <div class="Nx9bqj"><b>{{ "$".$value['amount']}}</b></div>
                              @endif
                           </div>
                           <div class="postbox__text mt-4">
                              <p>{!!$value['product_description']!!}</p>
                           </div>
                           
                           <div id="prerequisites__desc_{{$value->id}}"  style="display:none">
                              @if(!empty($value->prerequisites))
                               <p>{!! $value->prerequisites !!}</p>
                               @else
                              <p class="mt-4">No Data Found</p>
                              @endif
                              </div>

                           <div class="row">
                             
                              <div class="product__add-cart col-md-6">
                                 @if(!empty($value->unit_id))
                                 <a href="{{route('unit-page',$value->id)}}" class="fill-btn cart-btn">
                                    <span class="fill-btn-inner">
                                       <span class="fill-btn-normal">Explore<i class="fa-solid fa-basket-shopping"></i></span>
                                       <span class="fill-btn-hover">Explore<i class="fa-solid fa-basket-shopping"></i></span>
                                    </span>
                                 </a>
                                 @else
                                 <a href="javascript:void(0)" class="fill-btn cart-btn" onclick="addcart({{$value->id}})">
                                    <span class="fill-btn-inner">
                                       <span class="fill-btn-normal">Add To Cart<i class="fa-solid fa-basket-shopping"></i></span>
                                       <span class="fill-btn-hover">Add To Cart<i class="fa-solid fa-basket-shopping"></i></span>
                                    </span>
                                 </a>
                                 @endif
                              </div>
                           </div>
                           
                        </div>
                     </article>
                     @endforeach
                     @else
                        <p>{{$data['error']}}</p>
                     @endif
                     
                 
                     
                     <div class="pagination__wrapper">
                        <div class="bd-basic__pagination d-flex align-items-center justify-content-center">
                           <nav>
                             
                              {{$data->links('vendor.pagination.custom')}}
                           </nav>
                        </div>
                     </div>
                     
                  </div>
               </div>
               <div class="col-xxl-4 col-lg-4">
                  <div class="sidebar__wrapper bd-sticky pl-30">
                     <div class="sidebar__widget mb-20">
                        <div class="sidebar__widget-content">
                           <div class="sidebar__search">
                              <form autocomplete="off" action="{{route('ServicesSearch')}}" method="post">
                                 @csrf
                                 <div class="sidebar__search-input">
                                    <input type="text" id="myInput"  placeholder="Enter your keywords..." name="search">
                                    <button type="submit">
                                       <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                          xmlns="http://www.w3.org/2000/svg">
                                          <path
                                             d="M9.55 18.1C14.272 18.1 18.1 14.272 18.1 9.55C18.1 4.82797 14.272 1 9.55 1C4.82797 1 1 4.82797 1 9.55C1 14.272 4.82797 18.1 9.55 18.1Z"
                                             stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                             stroke-linejoin="round" />
                                          <path d="M19.0002 19.0002L17.2002 17.2002" stroke="currentColor"
                                             stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                       </svg>
                                    </button>
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                     <div class="sidebar__widget mb-45">
                        <h3 class="sidebar__widget-title">Category</h3>
                        <div class="sidebar__widget-content">
                           <ul>
                              @foreach($category as $value)
                              @php
                              $id=$value->id;
                              $product = App\Models\Product::where('cat_id', 'LIKE', '%|' . $id . '|%')
                              ->where('cat_id', 'LIKE', '%|' . $id . '|%')
                              ->orWhere('cat_id', 'LIKE', $id . '|%')
                              ->orWhere('cat_id', 'LIKE', '%|' . $id)
                              ->orWhere('cat_id', $id)
                              ->where('status', 1)
                              ->where('product_is_deleted', 0)
                              ->first();
                              @endphp
                               @if($product)
                              <li><a href="{{ route('product', ['slug' => $value['slug']]) }}">{{substr(ucFirst($value->cat_name),0,20)}}</a></li>
                              @endif
                              @endforeach
                              
                           </ul>
                        </div>
                     </div>
                     
                     @if(count($popular_service)>0)
                     <div class="sidebar__widget mb-45">
                        <h3 class="sidebar__widget-title">Popular Services</h3>
                        <div class="sidebar__widget-content">
                           <div class="sidebar__post">
                             
                              @foreach($popular_service as $key=>$value)
                              @php 
                              $image= explode('|',$value->product_image)
                              @endphp
                              @if($key<=9)
                              <div class="rc__post d-flex align-items-center">
                                 <div class="rc__post-thumb">
                                   
                                    <a href="{{ route('PopularService', ['id' => $value->id]) }}"><img src="{{$image[0]}}" alt="{{$value->product_name}}" onerror="this.onerror=null; this.src='{{url('/No_Image_Available.jpg')}}';"></a>
                                 </div>
                                 <div class="rc__post-content">
                                    <h4 class="rc__post-title">
                                       <a href="{{ route('PopularService', ['id' => $value->id]) }}">{{ Str::limit($value->product_name, 10, '...') }}</a>
                                    </h4>
                                    
                                 </div>
                              </div>
                              @endif
                              @endforeach
                              
                              
                           </div>
                        </div>
                     </div>
                    @endif
                     
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- Postbox details area end -->

      <!-- Newsletter area start -->
      <section class="newsletter-area p-relative">
         <div class="newsletter-overlay theme-bg-3"></div>
         <div class="container" 
             style="background-image: url('{{ url('/uploads/FOREVER-MEDSPA/giftcard.jpeg') }}'); 
                    background-size: cover; 
                    background-position: center; 
                    background-repeat: no-repeat; 
                    width: 100%; 
                    max-width: 1110px; 
                    height: auto; 
                    aspect-ratio: 1110 / 260.41;">
             
             <div class="newsletter-grid p-relative">
                 <div class="row gy-4 align-items-center">
                     <div class="col-xxl-6 col-xl-6 col-lg-6">
                         <div class="newsletter-content">
                             <!-- Removed the <h3> tag -->
                         </div>
                     </div>
                     <div class="col-xxl-6 col-xl-6 col-lg-6">
                         <div class="newsletter-form">
                             <div class="newsletter-input p-relative text-center">
                                 <button class="fill-btn" type="submit" 
                                     style="padding: 12px 24px; font-size: 16px; max-width: 200px; width: 100%;"
                                     onclick="location.href='{{ url('/') }}';">
                                     <span class="fill-btn-inner">
                                         Buy Now
                                         <span class="fill-btn-hover">Buy Now</span>
                                     </span>
                                 </button>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </section>
     <!-- Newsletter area end -->

   </main>
   <!-- Body main wrapper end -->

@endsection
@push('footerscript')
<script src="{{url('/')}}/giftcards/js/custom.js"></script>
<script src="{{url('/')}}/giftcards/js/giftcard.js"></script>
<script>
   function autocomplete(inp, arr) {
     /*the autocomplete function takes two arguments,
     the text field element and an array of possible autocompleted values:*/
     var currentFocus;
     /*execute a function when someone writes in the text field:*/
     inp.addEventListener("input", function(e) {
         var a, b, i, val = this.value;
         /*close any already open lists of autocompleted values*/
         closeAllLists();
         if (!val) { return false;}
         currentFocus = -1;
         /*create a DIV element that will contain the items (values):*/
         a = document.createElement("DIV");
         a.setAttribute("id", this.id + "autocomplete-list");
         a.setAttribute("class", "autocomplete-items");
         /*append the DIV element as a child of the autocomplete container:*/
         this.parentNode.appendChild(a);
         /*for each item in the array...*/
         for (i = 0; i < arr.length; i++) {
           /*check if the item starts with the same letters as the text field value:*/
           if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
             /*create a DIV element for each matching element:*/
             b = document.createElement("DIV");
             /*make the matching letters bold:*/
             b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
             b.innerHTML += arr[i].substr(val.length);
             /*insert a input field that will hold the current array item's value:*/
             b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
             /*execute a function when someone clicks on the item value (DIV element):*/
             b.addEventListener("click", function(e) {
                 /*insert the value for the autocomplete text field:*/
                 inp.value = this.getElementsByTagName("input")[0].value;
                 /*close the list of autocompleted values,
                 (or any other open lists of autocompleted values:*/
                 closeAllLists();
             });
             a.appendChild(b);
           }
         }
     });
     /*execute a function presses a key on the keyboard:*/
     inp.addEventListener("keydown", function(e) {
         var x = document.getElementById(this.id + "autocomplete-list");
         if (x) x = x.getElementsByTagName("div");
         if (e.keyCode == 40) {
           /*If the arrow DOWN key is pressed,
           increase the currentFocus variable:*/
           currentFocus++;
           /*and and make the current item more visible:*/
           addActive(x);
         } else if (e.keyCode == 38) { //up
           /*If the arrow UP key is pressed,
           decrease the currentFocus variable:*/
           currentFocus--;
           /*and and make the current item more visible:*/
           addActive(x);
         } else if (e.keyCode == 13) {
           /*If the ENTER key is pressed, prevent the form from being submitted,*/
           e.preventDefault();
           if (currentFocus > -1) {
             /*and simulate a click on the "active" item:*/
             if (x) x[currentFocus].click();
           }
         }
     });
     function addActive(x) {
       /*a function to classify an item as "active":*/
       if (!x) return false;
       /*start by removing the "active" class on all items:*/
       removeActive(x);
       if (currentFocus >= x.length) currentFocus = 0;
       if (currentFocus < 0) currentFocus = (x.length - 1);
       /*add class "autocomplete-active":*/
       x[currentFocus].classList.add("autocomplete-active");
     }
     function removeActive(x) {
       /*a function to remove the "active" class from all autocomplete items:*/
       for (var i = 0; i < x.length; i++) {
         x[i].classList.remove("autocomplete-active");
       }
     }
     function closeAllLists(elmnt) {
       /*close all autocomplete lists in the document,
       except the one passed as an argument:*/
       var x = document.getElementsByClassName("autocomplete-items");
       for (var i = 0; i < x.length; i++) {
         if (elmnt != x[i] && elmnt != inp) {
           x[i].parentNode.removeChild(x[i]);
         }
       }
     }
     /*execute a function when someone clicks in the document:*/
     document.addEventListener("click", function (e) {
         closeAllLists(e.target);
     });
   }
   
   /*An array containing all the country names in the world:*/
   var countries = {!! $search !!};
   
   /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
   autocomplete(document.getElementById("myInput"), countries);
   </script>
   <script>
      function navtab(id,type){
         if(type==='service_desc')
         {
            $('#prerequisites_'+id).removeClass('active');
            $('#service_desc_'+id).addClass('active');
            $('#desc_'+id).show();
            $('#prerequisites__desc_'+id).hide();
         }
         if(type==='prerequisites')
         {
            $('#prerequisites_'+id).addClass('active');
            $('#service_desc_'+id).removeClass('active');
            $('#desc_'+id).hide();
            $('#prerequisites__desc_'+id).show();
         }
      }
   </script>
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