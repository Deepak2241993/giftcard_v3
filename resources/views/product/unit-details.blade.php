@extends('layouts.front-master')

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

        @media (max-width: 767px) {

            .business-card,
            .service-selection {
                width: 100% !important;
                margin-bottom: 20px;
            }
        }
    </style>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
@endpush


@section('body')
    <div class="container">
        <div id="successToast" class="toast-success"></div>

        <!-- Service Selection -->
        <div class="service-selection">
            <div class="card-glow"></div>

            <div class="service-options">
                <div class="service-card">

                    <!-- Header -->
                    <div class="service-card-header">
                        <h3>{{ $ServiceUnit->product_name }}</h3>

                        @if ($ServiceUnit->fetures_original_price == 1)
                            <div class="service-price">
                                From $<del>{{ $ServiceUnit->amount }}</del>
                            </div>
                        @endif

                        @if ($ServiceUnit->popular_service == 1)
                            <div class="service-badge">Popular</div>
                        @endif
                    </div>

                    <!-- Description -->
                    <div class="service-description">
                        <p>{!! $ServiceUnit->short_description !!}</p>

                        <div class="hidden-content">
                            <p>{!! $ServiceUnit->product_description !!}</p>
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

                    <!-- Footer -->
                    <div class="service-footer">

    <div class="price">
        <i class="fas fa-tag"></i>
        <span class="price-display">
            From ${{ $ServiceUnit->discounted_amount }}
        </span>
    </div>

    <div class="quantity-controls" style="display:none;">
        <button class="quantity-btn minus-btn"
            onclick="updateQuantity(this,-1,{{ $ServiceUnit->min_qty }})">
            -
        </button>

        <span class="quantity-display">{{ $ServiceUnit->min_qty }}</span>

        <button class="quantity-btn plus-btn"
            onclick="updateQuantity(this,1,{{ $ServiceUnit->max_qty }})">
            +
        </button>
    </div>

    {{-- <button class="book-now-btn"
        onclick="toggleQuantityControls(this)"
        data-base-price="{{ $ServiceUnit->discounted_amount }}"
        data-id="{{ $ServiceUnit->id }}"
        data-type="unit">
        <span>Buy Now</span>
        <i class="fas fa-arrow-right"></i>
    </button> --}}


    <button class="book-now-btn" onclick="toggleQuantityControls(this)"
                                    data-base-price="{{ $ServiceUnit->discounted_amount }}" data-id="{{ $ServiceUnit->id }}"
                                    data-type="unit" data-unit_id="{{ $ServiceUnit->id }}">
                                    <span>Buy Now</span>
                                    <i class="fas fa-arrow-right"></i>
                                </button>

</div>

                </div>
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

