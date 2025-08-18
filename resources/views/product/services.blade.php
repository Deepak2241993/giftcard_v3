@extends('layouts.front-master')
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
  box-shadow: 0 2px 8px rgba(0,0,0,0.2);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome (for icons if needed) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@endpush
    

<div class="container">
    <div id="successToast" class="toast-success"></div>
        <!-- Left Side - Business Info -->
        <div class="business-card">
            <div class="card-glow"></div>
            <div class="business-header">
                <div class="logo-section">
                    <div class="logo-icon">
                        <i class="fas fa-spa"></i>
                    </div>
                    <h1>Forever MedSpa</h1>
                </div>
            </div>

            <div class="business-description">
                <p>At <strong>Forever Medspa & Wellness Center</strong>, we offer Botox, Fillers, RF, RFMN, Laser Hair
                    Reduction, Facials, Microneedling, and Advanced Skin and Body treatments—customized to your unique
                    needs. We believe aesthetic care should be as personal as you are.</p>
            </div>

            <div class="categories">
    <div class="categories-header">
        <h3><i class="fas fa-th-large"></i> Treatment Categories</h3>
    </div>

    <!-- Category Search -->
    <div class="category-search-container">
        <input type="text" id="categorySearch" class="category-search-input"
               placeholder="Search categories..." autocomplete="off">
        <i class="fas fa-search category-search-icon"></i>
        <button class="clear-category-search-btn" id="clearCategorySearch" style="display: none;">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <div class="categories-list" id="categoriesList">
            <div class="accordion" id="categoryAccordion">
                @foreach ($category as $key => $value)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ $key }}">
                            <button class="accordion-button {{ $key != 0 ? 'collapsed' : '' }}" 
                                    type="button" 
                                    data-bs-toggle="collapse" 
                                    data-bs-target="#collapse{{ $key }}" 
                                    aria-expanded="{{ $key == 0 ? 'true' : 'false' }}" 
                                    aria-controls="collapse{{ $key }}">
                                {{ $value->cat_name ?? '' }}
                            </button>
                        </h2>

                        <div id="collapse{{ $key }}" 
                            class="accordion-collapse collapse {{ $key == 0 ? 'show' : '' }}" 
                            aria-labelledby="heading{{ $key }}" 
                            data-bs-parent="#categoryAccordion">
                            <div class="accordion-body">
                                <ul class="list-group">
                                    @foreach ($services as $sKey => $service)
                                        @if ($value->id == $service->cat_id)
                                            <li class="list-group-item">
                                                <a href="{{ route('category-list',$service->product_slug) }}">{{ $service->product_name }}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
    </div>
</div>





            {{-- <div class="contact-info">
                <div class="contact-item website">
                    <div class="contact-icon">
                        <i class="fas fa-globe"></i>
                    </div>
                    <div class="contact-details">
                        <span class="contact-label">Website</span>
                        <a href="https://www.forevermedspanj.com" target="_blank">forevermedspanj.com</a>
                    </div>
                </div>
                <div class="contact-item phone">
                    <div class="contact-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div class="contact-details">
                        <span class="contact-label">Phone</span>
                        <a href="tel:+12013404809">(201) 340-4809</a>
                    </div>
                </div>
            </div> --}}
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
                {{-- {{ dd($services) }} --}}
                 @if (isset($units) && $units->count() > 0)
                @foreach ($units as $value)
                
                <div class="service-card">
                    <div class="service-card-header">
                        <h3>{{ $value['product_name'] }}</h3>
                        <div class="service-price">From $<del>{{$value['amount']}}</del></div>
                        @if($value['popular_service']!=null && $value['popular_service'] == 1)
                        <div class="service-badge">Popular</div>
                        @endif
                    </div>

                    <div class="service-description">
                        <p>{!! $value['short_description'] !!}</p>

                            <button class="read-more-btn" onclick="toggleReadMore(this)">
                                <span>Read More</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </p>

                        <div class="hidden-content">
                            <p>{!! $value['product_description'] !!}</p>
                        </div>
                    </div>

                    <div class="service-footer">
                        <div class="service-info">
                            <div class="price">
                                <i class="fas fa-tag"></i>
                                <span class="price-display">From ${{$value['discounted_amount']}}</span>
                            </div>
                        </div>
                        <div class="quantity-controls" style="display: none;">
                            <button class="quantity-btn minus-btn" onclick="updateQuantity(this, -1)">
                                <i class="fas fa-minus"></i>
                            </button>
                            <span class="quantity-display">1</span>
                            <button class="quantity-btn plus-btn" onclick="updateQuantity(this, 1)">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                       <button
                                class="book-now-btn"
                                onclick="toggleQuantityControls(this)"
                                data-base-price="{{$value['discounted_amount']}}"
                                data-id="{{$value['id']}}"
                                data-type="unit"
                                data-unit_id="{{$value['id']}}"
                                >
                                <span>Book Now</span>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @push('footerscript')
       <script>
        function addcart(unit_id, quantity,type) {
        
    $.ajax({
        url: '{{ route('cart') }}',
        method: "POST",
        dataType: "json",
        data: {
            _token: '{{ csrf_token() }}',
            unit_id: unit_id,
            quantity: quantity,
            type: type
        },
        success: function (response) {
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
        error: function () {
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
        url: '{{ route("update-cart") }}',
        type: 'POST',
        dataType: 'json',
        data: {
            _token: '{{ csrf_token() }}',
            key: key,
            quantity: newQuantity
        },
        success: function (response) {
            if (response.success) {
                // Optionally update sidebar totals or UI
                updateCartSidebar(response.cartHtml, response.cartSubtotal, response.cartTotal, response.cartCount);

                const toast = document.getElementById('successToast');
                if (toast) {
                    toast.textContent = "Cart updated successfully ✅";
                    toast.classList.add('show');
                    setTimeout(() => toast.classList.remove('show'), 3000);
                }
                location.reload();
            }
        },
        error: function () {
            alert('Something went wrong while updating the cart.');
        }
    });
}
    </script> 
<script>
    const categoryMap = @json($categoryMap);

    // Function to filter categories/services
    function performSearch(searchTerm) {
        searchTerm = searchTerm.toLowerCase();
        let hasResults = false;

        document.querySelectorAll(".accordion-item").forEach((item) => {
            let matchFound = false;

            // Check service names inside the category
            item.querySelectorAll(".list-group-item a").forEach((link) => {
                const text = link.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    link.parentElement.style.display = "block";
                    matchFound = true;
                } else {
                    link.parentElement.style.display = "none";
                }
            });

            // Show or hide the whole category
            if (matchFound) {
                item.style.display = "block";
                hasResults = true;

                // Expand matched categories
                const collapse = item.querySelector(".accordion-collapse");
                const button = item.querySelector(".accordion-button");
                if (collapse && !collapse.classList.contains("show")) {
                    new bootstrap.Collapse(collapse, { show: true });
                    button.classList.remove("collapsed");
                }
            } else {
                item.style.display = "none";
            }
        });

        document.getElementById("clearCategorySearch").style.display = searchTerm ? "inline-block" : "none";

        if (!hasResults && searchTerm) {
            showNotification("No matching services found", "error");
        }
    }

    // For Category Search (when selecting from list)
    function selectCategory(category, selectedItem) {
        document.querySelectorAll(".category-item").forEach((item) => {
            item.classList.remove("active");
        });

        selectedItem.classList.add("active");

        const searchInput = document.getElementById("categorySearch");
        const categoryName = categoryMap[category] || "";
        searchInput.value = categoryName;

        if (categoryName) {
            performSearch(categoryName);
        }

        showNotification(`Selected category: ${categoryName}`, "success");
        createRipple(selectedItem);
    }

    // Input event for live searching
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
</script>


{{-- For Service Search --}}
<script>
    const allServices = @json($ServiceUnit);

    document.addEventListener('DOMContentLoaded', function () {
        const serviceContainer = document.querySelector('.service-options');

        // --- Desktop Search ---
        const searchInput = document.getElementById('serviceSearch');
        const searchDropdown = document.getElementById('searchDropdown');
        const clearBtn = document.getElementById('clearSearch');

        if (searchInput) {
            searchInput.addEventListener('input', function () {
                handleSearch(this, searchDropdown, clearBtn, false);
            });

            clearBtn.addEventListener('click', function () {
                searchInput.value = '';
                searchDropdown.style.display = 'none';
                this.style.display = 'none';
                
            });

            document.addEventListener('click', function (e) {
                if (!e.target.closest('.search-container')) {
                    searchDropdown.style.display = 'none';
                }
            });
        }

        // --- Mobile Search ---
        const mobileInput = document.getElementById('mobileSearchInput');
        const mobileDropdown = document.getElementById('mobileSearchDropdown');

        if (mobileInput) {
            mobileInput.addEventListener('input', function () {
                handleSearch(this, mobileDropdown, null, true);
            });

            document.addEventListener('click', function (e) {
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
            if (clearBtn) clearBtn.style.display = 'none';
            dropdownElem.style.display = 'none';
           
        }
    }

    function renderServiceCard(service) {
        const container = document.querySelector('.service-options');
        container.innerHTML = '';

        let popularBadge = service.popular_service == 1
            ? `<div class="service-badge">Popular</div>` : '';

        const cardHTML = `
            <div class="service-card">
                <div class="service-card-header">
                    <h3>${service.product_name}</h3>
                    <div class="service-price">From $${service.amount}</div>
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
                        <button class="quantity-btn minus-btn" onclick="updateQuantity(this, -1)">
                            <i class="fas fa-minus"></i>
                        </button>
                        <span class="quantity-display">1</span>
                        <button class="quantity-btn plus-btn" onclick="updateQuantity(this, 1)">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <button class="book-now-btn" onclick="toggleQuantityControls(this)"
                        data-base-price="${service.discounted_amount}" data-id="${service.id}">
                        <span>Book Now</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        `;

        container.innerHTML = cardHTML;
    }

</script>





    @endpush

