@extends('layouts.front_product')
@section('body')
    @php
        use Carbon\Carbon;
    @endphp
    @push('css')
        <!-- CSS here -->

        <style>
            main {
                margin-top: 100px;
            }

            .theme-bg-3 {
                background: #fca52a;
            }

            .fill-btn-hover {
                color: #ffffff;
            }

            .fill-btn {
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
                background-color: rgba(252, 165, 42, 0.75);
                /* Set background opacity to 75% */
                color: white;
                /* Ensuring text color is white */
            }

            .breadcrumb__wrapper .nav_class:hover {
                border-color: #FCA52A;
                /* Keep the same border color or change it if needed */
                background-color: rgba(252, 165, 42, 1);
                /* Optionally, make the background fully opaque on hover */

            }

            .breadcrumb__wrapper .nav_class h6 {
                opacity: 1;
                /* Full opacity for the text */
            }


            input[type=text] {
                background-color: #ffffff;
                width: 100%;
            }

            @media (max-width: 767px) {
                main {
                    margin-top: 20px;
                }

                .navbar-toggler span+span {
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

            .hl05eU .UkUFwK,
            .hl05eU .yRaY8j {
                display: inline-block;
                margin-left: 8px;
            }

            .nav {
                border-color: orange;
                --bs-nav-tabs-link-active-color: #fca52a;
                --bs-nav-tabs-link-active-border-color: #fca52a #fca52a #f6f6f6;
            }
            .custom-btn {
    display: inline-block;
    background-color: #ff5722; /* Attractive orange */
    color: #fff; /* White text */
    font-size: 16px; /* Larger text */
    font-weight: bold; /* Bold text */
    padding: 8px 12px; /* Spacing around the text */
    border-radius: 25px; /* Rounded corners */
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); /* Subtle shadow for depth */
    text-decoration: none; /* Remove underline */
    transition: all 0.3s ease-in-out; /* Smooth hover effect */
}

.custom-btn:hover {
    background-color: #e64a19; /* Slightly darker orange */
    color: #fff; /* Ensure text remains visible */
    transform: scale(1.1); /* Slight zoom effect */
    box-shadow: 0px 6px 14px rgba(0, 0, 0, 0.3); /* Enhance shadow on hover */
}
.carousel-caption {
    position: absolute;
    right: 15%;
    bottom: -0.75rem;
    left: 15%;
    padding-top: 1.25rem;
    padding-bottom: 1.25rem;
    color: #fff;
    text-align: center;
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

            @if (!empty($sliders))
                <div id="carouselExampleAutoplaying" class="carousel slide" style="margin-top: 80px" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($sliders as $key => $value)
                            @if ($key <= 5)
                                <div class="carousel-item @if ($key == 0) active @endif">
                                    <img src="{{ url($value->image) }}" class="d-block w-100" alt="..."
                                        onerror="this.onerror=null; this.src='{{ url('/No_Image_Available.jpg') }}';">
                                    <div class="carousel-caption d-block">
                                        <a href="{{ $value->url }}" target="_blank" class="custom-btn">Buy Now</a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            @else
                <h1>No Slider Data Found</h1>
            @endif

            <!-- Breadcrumb area start  -->

            <!-- Postbox details area start -->
            <section class="postbox__area grey-bg-4 section-space">
                <div class="container">
                    <div class="row gy-50">
                        <div class="col-xxl-12 col-lg-12">
                            <h2>Black Friday Deals 2024</h2>
                            {{-- <img src="{{url('/images/balac_friday.jpg')}}" alt="" class="image" width="730"> --}}
                            <div class="postbox__wrapper">
                                @if (isset($data))
                                <article class="postbox__item mb-30 transition-3">
                                    @foreach ($data as $value)
                                    <div class="rc__post">
                                            {{-- <div class="postbox__thumb w-img mb-30">
                                                <a href="@if(!empty($value['unit_id'])){{route('serviceunit',$value->product_slug)}}@else{{route('productdetails',['slug' => $value['product_slug']])}} @endif">
                                                    <img src="{{ $value['product_image'] }}"
                                                        alt="{{ $value['product_name'] }}"
                                                        onerror="this.onerror=null; this.src='{{ url('/No_Image_Available.jpg') }}';"
                                                        style="height:250px">
                                                </a>
                                            </div> --}}
                                            <div class="postbox__content">

                                                <h3 class="postbox__title">
                                                    <a
                                                        href="@if(!empty($value['unit_id'])){{route('serviceunit',$value->product_slug)}}@else{{route('productdetails',['slug' => $value['product_slug']])}} @endif">{{ $value['product_name'] }}</a>
                                                </h3>

                                                <div class="postbox__text">

                                                    <p>{!! $value['short_description'] !!}</p>
                                                </div>

                                                <div class="hl05eU">
                                                    <div class="UkUFwK">
                                                        {{-- <span><i><b>Up to {{ $max_amount }}% off</b></i></span> --}}
                                                        {{-- For Countdown Code --}}

                                                    </div>

                                                    {{-- <script>
                                                        function updateCountdown() {
                                                            var now = new Date().getTime();
                                                            var endOfDay = new Date();
                                                            endOfDay.setHours(23, 59, 59, 999); // Set to end of day
                                                            var distance = endOfDay - now;

                                                            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                                            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                                            document.getElementById("countdown").innerHTML = hours + "h " +
                                                                minutes + "m " + seconds + "s ";

                                                            if (distance < 0) {
                                                                clearInterval(x);
                                                                document.getElementById("countdown").innerHTML = "EXPIRED";
                                                            }
                                                        }

                                                        var x = setInterval(updateCountdown, 1000);
                                                        updateCountdown();
                                                    </script> --}}

                                                    <div class="product__add-cart col-md-3">
                                                        @if(!empty($value['unit_id']))
                                                        <a href="{{route('serviceunit',$value->product_slug)}}"
                                                            class="fill-btn cart-btn">
                                                            <span class="fill-btn-inner">
                                                                <span class="fill-btn-normal">Explore</span>
                                                                <span class="fill-btn-hover">Explore</span>
                                                            </span>
                                                        </a>
                                                        @else
                                                        <a href="{{route('productdetails',['slug' => $value['product_slug']])}}"
                                                            class="fill-btn cart-btn">
                                                            <span class="fill-btn-inner">
                                                                <span class="fill-btn-normal">Buy Now</span>
                                                                <span class="fill-btn-hover">Buy Now</span>
                                                            </span>
                                                        </a>
                                                        @endif

                                                    </div>

                                                </div>
                                              
                                            </div>
                                        </div>
                                        </article>
                                    @endforeach
                                @else
                                    <p>{{ $data['error'] }}</p>
                                @endif



                                <div class="pagination__wrapper">
                                    <div class="bd-basic__pagination d-flex align-items-center justify-content-center">
                                        <nav>

                                            {{ $data->links('vendor.pagination.custom') }}
                                        </nav>
                                    </div>
                                </div>

                            </div>
                        </div>
                        {{-- <div class="col-xxl-4 col-lg-4">
                            <div class="sidebar__wrapper bd-sticky pl-30">
                                <div class="sidebar__widget mb-20">
                                    <div class="sidebar__widget-content">
                                        <div class="sidebar__search">
                                            <form autocomplete="off" action="{{ route('ServicesSearch') }}" method="post">
                                                @csrf
                                                <div class="sidebar__search-input">
                                                    <input type="text" id="myInput"
                                                        placeholder="Enter your keywords..." name="search">
                                                    <button type="submit">
                                                        <svg width="20" height="20" viewBox="0 0 20 20"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M9.55 18.1C14.272 18.1 18.1 14.272 18.1 9.55C18.1 4.82797 14.272 1 9.55 1C4.82797 1 1 4.82797 1 9.55C1 14.272 4.82797 18.1 9.55 18.1Z"
                                                                stroke="currentColor" stroke-width="1.5"
                                                                stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M19.0002 19.0002L17.2002 17.2002" stroke="currentColor"
                                                                stroke-width="1.5" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                @if (count($popular_service) > 0)
                                    <div class="sidebar__widget mb-45">
                                        <h3 class="sidebar__widget-title">Popular Services</h3>
                                        <div class="sidebar__widget-content">
                                            <div class="sidebar__post">

                                                @foreach ($popular_service as $key => $value)
                                                    @if ($key <= 9)
                                                        <div class="rc__post d-flex align-items-center">
                                                            <div class="rc__post-thumb">
                                                                <a
                                                                    href="@if(!empty($value['unit_id'])){{route('serviceunit',$value->product_slug)}}@else{{route('productdetails',['slug' => $value['product_slug']])}}@endif"><img
                                                                        src="{{ $value->product_image }}"
                                                                        alt="{{ $value->product_name }}"
                                                                        onerror="this.onerror=null; this.src='{{ url('/No_Image_Available.jpg') }}';"></a>
                                                            </div>
                                                            <div class="rc__post-content">
                                                                <h4 class="rc__post-title">
                                                                    <a
                                                                        href="@if(!empty($value['unit_id'])){{route('serviceunit',$value->product_slug)}}@else{{route('productdetails',['slug' => $value['product_slug']])}}@endif">{{ Str::limit($value->product_name, 10, '...') }}</a>
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
                        </div> --}}
                    </div>
                </div>
            </section>
            <!-- Postbox details area end -->

            <!-- Newsletter area start -->
            <section class="newsletter-area p-relative">
                <div class="newsletter-overlay theme-bg-3"></div>
                
                <div class="container"
                    style="background-image: url('{{ url('/uploads/FOREVER-MEDSPA/giftcards.jpg') }}'); 
                           background-size: cover; 
                           background-position: center; 
                           background-repeat: no-repeat; 
                           width: 100%; 
                           max-width: 1110px; 
                           height: auto; 
                           aspect-ratio: 1110 / 260.41;" onclick="location.href='{{ url('/') }}';">

                    <div class="newsletter-grid p-relative">
                        <div class="row gy-4 align-items-center">
                            <div class="col-xxl-12 col-xl-12 col-lg-12">
                                <div class="newsletter-content">
                                    <!-- Removed the <h3> tag -->
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
    <script src="{{ url('/') }}/giftcards/js/custom.js"></script>
    <script src="{{ url('/') }}/giftcards/js/giftcard.js"></script>
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
                if (!val) {
                    return false;
                }
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
            document.addEventListener("click", function(e) {
                closeAllLists(e.target);
            });
        }

        /*An array containing all the country names in the world:*/
        var countries = {!! $search !!};

        /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
        autocomplete(document.getElementById("myInput"), countries);
    </script>
@endpush
