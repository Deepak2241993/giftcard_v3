
@extends('layouts.front-master')
@php
    function getStaticContent($id)
    {
        $content = App\Models\StaticContent::find($id);
        return $content ? $content : 'No Data Found';
    }

@endphp
@section('body')
    @push('csslink')
        <style>
            .hiddencount {
                display: none !important;

            }

            .toast-success {
                position: fixed;
                top: 20px;
                right: 20px;
                background-color: #28a745;
                color: white;
                padding: 12px 20px;
                border-radius: 5px;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
                opacity: 0;
                z-index: 9999;
                transition: opacity 0.4s ease, transform 0.3s ease;
                transform: translateY(-20px);
                pointer-events: none;
            }

            .toast-success.show {
                opacity: 1;
                transform: translateY(0);
            }

            /* For Pagination  */
            .pagination-wrapper nav ul.pagination {
                display: flex;
                justify-content: center;
                padding: 1rem;
                gap: 0.4rem;
            }

            .pagination-wrapper .page-link {
                color: #dd7344;
                border: 1px solid #dd7344;
                padding: 8px 12px;
                border-radius: 6px;
                transition: all 0.2s ease-in-out;
                background-color: white;
            }

            .pagination-wrapper .page-link:hover {
                background-color: #dd7344;
                color: white;
            }

            .pagination-wrapper .page-item.active .page-link {
                background-color: #dd7344;
                color: white;
                border-color: #dd7344;
            }

            .pagination-wrapper .page-item.disabled .page-link {
                color: #ccc;
                border-color: #eee;
                background-color: #f9f9f9;
            }

            /* Remove default list styles */
            .pagination-wrapper ul.pagination {
                list-style: none;
                padding-left: 0;
                margin: 0;
                display: flex;
                justify-content: center;
                gap: 0.4rem;
                flex-wrap: wrap;
            }

            /* Style the pagination links */
            .pagination-wrapper .page-link {
                color: #dd7344;
                border: 1px solid #dd7344;
                padding: 8px 14px;
                border-radius: 6px;
                transition: all 0.2s ease-in-out;
                background-color: white;
                text-decoration: none;
            }

            .pagination-wrapper .page-link:hover {
                background-color: #dd7344;
                color: white;
            }

            /* Active page style */
            .pagination-wrapper .page-item.active .page-link {
                background-color: #dd7344;
                color: white;
                border-color: #dd7344;
            }

            /* Disabled buttons */
            .pagination-wrapper .page-item.disabled .page-link {
                color: #ccc;
                border-color: #eee;
                background-color: #f9f9f9;
            }

            .search-dropdown {
                position: absolute;
                background: #fff;
                border: 1px solid #ccc;
                width: 100%;
                z-index: 1000;
                display: none;
                max-height: 200px;
                overflow-y: auto;
            }

            .suggestion-item {
                padding: 8px 12px;
                cursor: pointer;
            }

            .suggestion-item:hover {
                background-color: #f0f0f0;
            }
        </style>

        <style>
            @media (max-width: 767px) {
                /* .container {
                    display: flex;
                    flex-direction: column;
                } */
                .business-card, .service-selection {
                        width: 100% !important;
                        margin-bottom: 20px;
                }
            }
        </style>
        
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> --}}

        <!-- FontAwesome (for icons if needed) -->
        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"> --}}
    @endpush


    <div class="container">
        <div id="successToast" class="toast-success"></div>
        

        <!-- Left Side - Business Info -->
        <div class="business-card">
        @php
            $result = getStaticContent(3);
        @endphp
            <div class="card-glow"></div>
            <div class="business-header">
                <div class="logo-section">
                    <div class="logo-icon">
                        <i class="fas fa-spa"></i>
                    </div>
                    <h1>{{$result->title}}</h1>
                </div>
            </div>

            <div class="business-description">
                {!! $result->content !!}
            </div>

            <div class="categories">
                <div class="categories-header mb-2">
                    <h3><i class="fas fa-th-large"></i> Treatment Categories</h3>
                </div>
                <!-- Category Search -->
                <div class="category-search-container mb-3 position-relative">
                    <input type="text" id="categorySearch" class="form-control" placeholder="Search categories..." autocomplete="off">
                        <i class="fas fa-search category-search-icon position-absolute" style="right:40px; top:12px;"></i>
                    <button class="btn btn-sm btn-light position-absolute" id="clearCategorySearch" style="right:5px; top:6px; display:none;" >
                            <i class="fas fa-times"></i>
                    </button>
                </div>

                    <!-- Categories Accordion -->
                <div class="accordion" id="accordionExample">
                    @foreach ($category as $key => $value)
                    <div class="card accordion-item">
                        <div class="card-header p-2" id="heading{{ $key }}">
                            <h2 class="mb-0">
                                <button class="btn text-left w-100 {{ $key != 0 ? 'collapsed' : '' }}" 
                                type="button" 
                                data-toggle="collapse" 
                                data-target="#collapse{{ $key }}" 
                                aria-expanded="{{ $key == 0 ? 'true' : 'false' }}" 
                                aria-controls="collapse{{ $key }}" style="color: #f39548;">
                                <i class="fas fa-folder mr-2"></i> {{ $value->cat_name ?? '' }}
                                </button>
                            </h2>
                        </div>

                        <div id="collapse{{ $key }}" 
                             class="collapse {{ $key == 0 ? 'show' : '' }}" 
                             aria-labelledby="heading{{ $key }}" 
                             data-parent="#accordionExample">
                            <ul class="list-group list-group-flush">
                                @foreach ($services as $sKey => $service)
                                    @php $cat_array = explode('|',$service->cat_id)   @endphp
                                    @if (in_array($value->id, $cat_array))
                                        <li class="list-group-item p-2">
                                            <a href="{{ route('treatment-categories', $service->product_slug) }}" style="color:var(--text-primary) text-decoration: underline;">
                                                {{ $service->product_name }}
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        
        <!-- Right Side - Service Selection -->
        <div class="service-selection">
            <div class="card-glow"></div>
            <div class="service-header">
                {{-- <div class="header-content">
                    <h2><i class="fas fa-list-ul"></i> Choose a Service Category</h2>
                    <p>Select from our premium treatment options</p>
                </div> --}}
                <div class="search-container d-none d-md-block">
                    <input type="text" id="serviceSearch" class="search-input"
                        placeholder="Search treatments (e.g., Botox, Laser, Facials...)" autocomplete="off">
                    <i class="fas fa-search search-icon"></i>
                    <button class="clear-search-btn" id="clearSearch" style="display: none;">
                        <i class="fas fa-times"></i>
                    </button>
                    <div class="search-dropdown" id="searchDropdown"></div>
                </div>


            </div>

            <div class="service-options">
                <!-- Service Option 1 -->
                @if (isset($units) && $units->count() > 0)
                    @foreach ($units as $value)
                        <div class="service-card">
                            <div class="service-card-header">
                                <h3>{{ $value['product_name'] }}</h3>
                                @if($value['fetures_original_price'] == 1)
                                <div class="service-price">From $<del>{{ $value['amount'] }}</del></div>
                                @endif

                                @if ($value['popular_service'] != null && $value['popular_service'] == 1)
                                    <div class="service-badge">Popular</div>
                                @endif
                            </div>

                            {{-- <div class="service-description">
                                <p>{!! $value['short_description'] !!}</p>

                                <button class="read-more-btn" onclick="toggleReadMore(this)">
                                    <span>Read More</span>
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                                

                                <div class="hidden-content">
                                    <p>{!! $value['product_description'] !!}</p>
                                </div>
                            </div> --}}
                            <div class="service-description">
    <p>{!! $value['short_description'] !!}</p>

    <div class="hidden-content">
        <p>{!! $value['product_description'] !!}</p>

        <!-- Move the button here -->
        <button class="read-more-btn" onclick="toggleReadMore(this)">
            <span>Read Less</span>
            <i class="fas fa-chevron-up"></i>
        </button>
    </div>

    <button class="read-more-btn top-btn" onclick="toggleReadMore(this)">
        <span>Read More</span>
        <i class="fas fa-chevron-down"></i>
    </button>
</div>

                            <div class="service-footer">
                                <div class="service-info">
                                    <div class="price">
                                        <i class="fas fa-tag"></i>
                                        <span class="price-display">From ${{ $value['discounted_amount'] }}</span>
                                    </div>
                                </div>
                                <div class="quantity-controls" style="display: none;">
                                    <button class="quantity-btn minus-btn" onclick="updateQuantity(this, -1,{{$value['min_qty']}})">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <span class="quantity-display">{{$value['min_qty']}}</span>
                                    <button class="quantity-btn plus-btn" onclick="updateQuantity(this, 1,{{$value['max_qty']}})">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <button class="book-now-btn" onclick="toggleQuantityControls(this)"
                                    data-base-price="{{ $value['discounted_amount'] }}" data-id="{{ $value['id'] }}"
                                    data-type="unit" data-unit_id="{{ $value['id'] }}">
                                    <span>Buy Now</span>
                                    <i class="fas fa-arrow-right"></i>
                                </button>

                            </div>
                        </div>
                    @endforeach
                    <!-- Pagination links -->
                    <div class="pagination-wrapper">
                        {{ $units->links() }}
                    </div>
                @else
                    <p>{{ 'No Data Found' }}</p>
                @endif
            </div>
        </div>

    </div>
@endsection
@push('footerscript')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}
    <script>
        function addcart(unit_id, quantity, type) {

            $.ajax({
                url: '{{ route('cart') }}',
                method: "POST",
                dataType: "json",
                data: {
                    _token: '{{ csrf_token() }}',
                    unit_id: unit_id,
                    quantity: quantity,
                    type: type,
                    cart_name: "front_cart"

                },
                success: function(response) {
                    if (response.success) {
                        const quantityDisplay = document.querySelector('#cartCount');

                        if (quantityDisplay) {
                            quantityDisplay.style.transform = "scale(1.2)";
                            setTimeout(() => {
                                quantityDisplay.style.transform = "scale(1)";
                            }, 150);
                        }

                        // Show success toast
                        const toast = document.getElementById('successToast');
                        if (toast) {
                            toast.classList.add('show');
                            setTimeout(() => {
                                toast.classList.remove('show');
                            }, 3000);
                        }
                        location.reload();
                        // Optional: Refresh cart sidebar if needed
                        // updateCartSidebar(response.cartItems); // Uncomment if you handle cart updates dynamically
                    } else {
                        $('.showbalance').html(response.error ?? 'Something went wrong.').show();
                    }
                },
                error: function() {
                    $('.showbalance').html('An error occurred. Please try again.').show();
                }
            });
        }

        // For Update Cart Item Quantity
        function updateCartItemQuantity(key, newQuantity) {
            if (newQuantity < 1) return;

            // 1. Update the quantity display immediately in the DOM
            const qtySpan = document.getElementById(`qty_${key}`);
            if (qtySpan) {
                qtySpan.textContent = newQuantity;
            }

            // 2. Send AJAX to update the session/cart on server
            $.ajax({
                url: '{{ route('update-cart') }}',
                type: 'POST',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}',
                    key: key,
                    quantity: newQuantity,
                    cart_name: "front_cart"
                },
                success: function(response) {
                    if (response.success) {
                        // Optionally update sidebar totals or UI
                        updateCartSidebar(response.cartHtml, response.cartSubtotal, response.cartTotal, response
                            .cartCount);

                        const toast = document.getElementById('successToast');
                        if (toast) {
                            toast.textContent = "Cart updated successfully ✅";
                            toast.classList.add('show');
                            setTimeout(() => toast.classList.remove('show'), 3000);
                        }
                        location.reload();
                    }
                },
                error: function() {
                    alert('Something went wrong while updating the cart.');
                }
            });
        }
    </script>
    <script>
    // Function to filter categories/services
    function performSearch(searchTerm) {
        searchTerm = searchTerm.toLowerCase();
        let hasResults = false;

        document.querySelectorAll(".accordion-item").forEach((item) => {
            let matchFound = false;

            // Check service names inside the category
            item.querySelectorAll(".list-group-item").forEach((listItem) => {
                const text = listItem.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    listItem.style.display = "block";
                    matchFound = true;
                } else {
                    listItem.style.display = "none";
                }
            });

            // Show/hide whole category
            if (matchFound || item.querySelector(".btn-link").textContent.toLowerCase().includes(searchTerm)) {
                item.style.display = "block";
                hasResults = true;

                // Expand matched categories
                const collapse = item.querySelector(".collapse");
                if (collapse && !collapse.classList.contains("show")) {
                    $(collapse).collapse("show");
                }
            } else {
                item.style.display = "none";
            }
        });

        // Show/hide clear button
        document.getElementById("clearCategorySearch").style.display = searchTerm ? "inline-block" : "none";

        // Optional notification (if you have showNotification())
        if (!hasResults && searchTerm) {
            console.log("No matching services found");
        }
    }

    document.addEventListener("DOMContentLoaded", () => {
        const searchInput = document.getElementById("categorySearch");
        const clearBtn = document.getElementById("clearCategorySearch");

        searchInput.addEventListener("input", () => {
            performSearch(searchInput.value);
        });

        clearBtn.addEventListener("click", () => {
            searchInput.value = "";
            performSearch("");
        });
    });


    function renderAllServices() {
    const container = document.querySelector('.service-options');
    container.innerHTML = '';

    allServices.forEach(service => {
        let popularBadge = service.popular_service == 1 ? `<div class="service-badge">Popular</div>` : '';

        const cardHTML = `
        <div class="service-card">
            <div class="service-card-header">
                <h3>${service.product_name}</h3>
                ${
                service.fetures_original_price == 1
                    ? `<div class="service-price">From $<del>${service.amount}</del></div>`
                    : ``
            }
              
                ${popularBadge}
            </div>

            <div class="service-description">
                <p>${service.short_description || ''}</p>
                <button class="read-more-btn" onclick="toggleReadMore(this)">
                    <span>Read More</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="hidden-content">
                    <p>${service.product_description || ''}</p>
                </div>
            </div>

            <div class="service-footer">
                <div class="service-info">
                    <div class="price">
                        <i class="fas fa-tag"></i>
                        <span class="price-display">From $${service.discounted_amount}</span>
                    </div>
                </div>
                <div class="quantity-controls" style="display: none;">
                    <button class="quantity-btn minus-btn" onclick="updateQuantity(this, -1,${service.min_qty})">
                        <i class="fas fa-minus"></i>
                    </button>
                    <span class="quantity-display">1</span>
                    <button class="quantity-btn plus-btn" onclick="updateQuantity(this, 1,${service.max_qty})">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                <button class="book-now-btn" onclick="toggleQuantityControls(this)"
                    data-base-price="${service.discounted_amount}" data-id="${service.id}">
                    <span>Buy Now</span>
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>
        `;

        container.innerHTML += cardHTML;
    });
}

</script>



    {{-- For Service Search --}}
    <script>
        const allServices = @json($ServiceUnit);
        

        document.addEventListener('DOMContentLoaded', function() {
            const serviceContainer = document.querySelector('.service-options');

            // --- Desktop Search ---
            const searchInput = document.getElementById('serviceSearch');
            const searchDropdown = document.getElementById('searchDropdown');
            const clearBtn = document.getElementById('clearSearch');

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    handleSearch(this, searchDropdown, clearBtn, false);
                });

                clearBtn.addEventListener('click', function() {
                    searchInput.value = '';
                    searchDropdown.style.display = 'none';
                    this.style.display = 'none';

                });

                document.addEventListener('click', function(e) {
                    if (!e.target.closest('.search-container')) {
                        searchDropdown.style.display = 'none';
                    }
                });
            }

            // --- Mobile Search ---
            const mobileInput = document.getElementById('mobileSearchInput');
            const mobileDropdown = document.getElementById('mobileSearchDropdown');

            if (mobileInput) {
                mobileInput.addEventListener('input', function() {
                    handleSearch(this, mobileDropdown, null, true);
                });

                document.addEventListener('click', function(e) {
                    if (!e.target.closest('#mobileSearchContainer')) {
                        mobileDropdown.style.display = 'none';
                    }
                });
            }


        });

        function handleSearch(inputElem, dropdownElem, clearBtn = null, isMobile = false) {
    const query = inputElem.value.trim().toLowerCase();
    dropdownElem.innerHTML = '';

    if (query.length > 0) {
        if (clearBtn) clearBtn.style.display = 'block';
        dropdownElem.style.display = 'block';

        const filtered = allServices.filter(item =>
            item.product_name.toLowerCase().includes(query)
        );

        if (filtered.length) {
            filtered.forEach(item => {
                const div = document.createElement('div');
                div.textContent = item.product_name;
                div.classList.add('suggestion-item');
                div.onclick = () => {
                    inputElem.value = item.product_name;
                    dropdownElem.style.display = 'none';
                    if (clearBtn) clearBtn.style.display = 'block';
                    renderServiceCard(item);
                    if (isMobile) {
                        document.getElementById('mobileSearchContainer').style.display = 'none';
                    }
                };
                dropdownElem.appendChild(div);
            });
        } else {
            dropdownElem.innerHTML = '<div class="suggestion-item">No matches</div>';
        }
    } else {
        // when search box is empty → reset
        if (clearBtn) clearBtn.style.display = 'none';
        dropdownElem.style.display = 'none';

        // show all services again
        renderAllServices();
    }
    
}


const clearBtn = document.getElementById('clearSearch');

if (clearBtn) {
    clearBtn.addEventListener('click', function() {
        const searchInput = document.getElementById('serviceSearch');
        const searchDropdown = document.getElementById('searchDropdown');

        searchInput.value = '';
        searchDropdown.style.display = 'none';
        this.style.display = 'none';

        // ✅ Show all services again
        renderAllServices();
    });
}


        function renderServiceCard(service) {
            const container = document.querySelector('.service-options');
            container.innerHTML = '';

            let popularBadge = service.popular_service == 1 ?
                `<div class="service-badge">Popular</div>` : '';

            const cardHTML = `
            <div class="service-card">
                <div class="service-card-header">
                    <h3>${service.product_name}</h3>

                ${
                service.fetures_original_price == 1
                    ? `<div class="service-price">From $<del>${service.amount}</del></div>`
                    : ``
            }


                    ${popularBadge}
                </div>

                <div class="service-description">
                    <p>${service.short_description || ''}</p>
                    <button class="read-more-btn" onclick="toggleReadMore(this)">
                        <span>Read More</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="hidden-content">
                        <p>${service.product_description || ''}</p>
                    </div>
                </div>

                <div class="service-footer">
                    <div class="service-info">
                        <div class="price">
                            <i class="fas fa-tag"></i>
                            <span class="price-display">From $${service.discounted_amount}</span>
                        </div>
                    </div>
                    <div class="quantity-controls" style="display: none;">
                        <button class="quantity-btn minus-btn" onclick="updateQuantity(this, -1, ${service.min_qty})">
                            <i class="fas fa-minus"></i>
                        </button>
                        <span class="quantity-display">1</span>
                        <button class="quantity-btn plus-btn" onclick="updateQuantity(this, 1, ${service.max_qty})">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <button class="book-now-btn" onclick="toggleQuantityControls(this)"
                        data-base-price="${service.discounted_amount}" data-id="${service.id}">
                        <span>Buy Now</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        `;

            container.innerHTML = cardHTML;
        }
    </script>
@endpush
