@push('css')

<style>
    .logo-img {
        max-height: 50px;
        width: auto;
    }

    .mobile-only-icon {
        width: 44px;
        height: 44px;
        background: var(--bg-white);
        color: var(--accent-dark);
        border-radius: var(--radius-lg);
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all var(--transition-base);
        box-shadow: var(--shadow-sm);
    }

    .mobile-only-icon:hover {
        background: var(--bg-gray-100);
    }

    /* Hide mobile-only icons on desktop */
    @media (min-width: 769px) {
        .mobile-only-icon {
            display: none;
        }

        /* Always hide mobile menu on desktop */
        #mobileMenu {
            display: none !important;
        }
    }

    /* Responsive Styles for mobile */
    @media (max-width: 768px) {
        .mobile-only-icon {
            display: flex;
        }

        .header-nav .nav-link {
            display: none;
        }

        #mobileMenu {
            display: none;
            flex-direction: column;
            background-color: white;
            position: absolute;
            top: 70px;
            left: 0;
            right: 0;
            padding: 15px;
            z-index: 999;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        #mobileMenu a {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
            color: #000;
            text-decoration: none;
            font-weight: 500;
        }

        #mobileMenu.show {
            display: flex;
        }
    }
</style>
<style>
    /* Mobile search container */
#mobileSearchContainer {
    display: none;
    position: absolute;
    top: 70px;
    left: 0;
    right: 0;
    background-color: white;
    padding: 10px 15px;
    z-index: 999;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

/* Show search box only on mobile */
@media (min-width: 769px) {
    #mobileSearchContainer {
        display: none !important;
    }
}

@media (max-width: 768px) {
    #mobileSearchContainer input[type="text"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    #mobileSearchContainer.show {
        display: block;
    }
}

</style>


<header class="page-header">
    <div class="header-container">
        
        <div class="header-logo">
            <img src="{{url('/forever-color.fw_.png')}}" alt="Forever MedSpa Logo" class="logo-img">
        </div>

        <nav class="header-nav">
            <a href="https://forevermedspanj.com/" class="nav-link">Website</a>
            <a href="{{ url('/') }}" class="nav-link">Giftcards</a>
            <a href="{{ route('services') }}" class="nav-link">Services</a>
            @if (Session::get('patient_details'))
                <a class="nav-link"
                    href="{{ route('patient-dashboard') }}">{{ Auth::guard('patient')->user()->fname }}</a>
            @else
                <a class="nav-link" href="{{ url('/patient-login') }}">Login</a>
            @endif
            @php
                $cart = session()->get('cart', []);
                $cartCount = count($cart);
            @endphp

            <div class="cart-icon" id="cartIcon">
                <i class="fas fa-shopping-cart"></i>
                <span class="cart-count {{ $cartCount === 0 ? 'hiddencount' : '' }}" id="cartCount">
                    {{ $cartCount }}
                </span>
            </div>
            <!-- Search Icon (mobile only) -->
            @if(url()->current() == route('services'))
            <div class="mobile-only-icon" id="searchIcon">
                <i class="fas fa-search"></i>
            </div>
            @endif

            <!-- Hamburger Icon (mobile only) -->
            <div class="mobile-only-icon" id="hamburgerMenu">
                <i class="fas fa-bars"></i>
        </div>
        </nav>
    </div>
    <!-- Mobile Menu Links -->
    <div id="mobileMenu">
        <a href="https://forevermedspanj.com/">Home</a>
        <a href="{{ url('/') }}">Giftcards</a>
        <a href="{{ route('services') }}">Services</a>
        @if (Session::get('patient_details'))
            <a href="{{ route('patient-dashboard') }}">{{ Auth::guard('patient')->user()->fname }}</a>
        @else
            <a href="{{ url('/patient-login') }}">Login</a>
        @endif
    </div>
     @if(url()->current() == route('services'))
        <div id="mobileSearchContainer" class="d-block d-md-none">
            <input type="text" placeholder="Search..." id="mobileSearchInput" />
            <div class="search-dropdown" id="mobileSearchDropdown"></div>
        </div>
    @endif
</header>

@php
$cart = session()->get('cart', []);
 $redeem = 0;
$amount = 0;
    @endphp
<!-- Cart Sidebar -->
<div class="cart-sidebar" id="cartSidebar">
    <div class="cart-sidebar-overlay" id="cartSidebarOverlay"></div>
    <div class="cart-sidebar-content">
        <div class="cart-sidebar-header">
            <h3><i class="fas fa-shopping-cart"></i> Your Cart</h3>
            <button class="cart-close-btn" id="cartCloseBtn">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="cart-sidebar-body" id="cartSidebarBody">
    <div class="empty-cart" id="emptyCart" @if(!isset($cart) || empty($cart)) style="display: block;" @else style="display: none;" @endif>
        <i class="fas fa-shopping-cart"></i>
        <h4>Your cart is empty</h4>
        <p>Add some treatments to get started!</p>
    </div>

    @php $amount = 0; $redeem = 0; @endphp
    @if (!empty($cart))
    <div class="cart-items" id="cartItems" @if(empty($cart)) style="display: none;" @else style="display: block;" @endif>
            @foreach ($cart as $key => $item)
                @php
                    $product = App\Models\Product::find($item['id']);
                    $image = explode('|', $product->product_image);
                    $price = $product->discounted_amount ?? $product->amount;
                    $subtotal = $price * $item['quantity'];
                    $amount += $subtotal;
                    if ($product->giftcard_redemption == 0) {
                        $redeem++;
                    }
                @endphp

                <div class="cart-item" id="cartItem_{{ $key }}">
                    <div class="cart-item-header">
                        <div class="cart-item-title">{{ $product->product_name }}</div>
                        <button class="cart-item-remove" onclick="removeFromCart('{{ $key }}')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    <div class="cart-item-details">
                        <div class="cart-item-quantity">
                            <div class="cart-quantity-controls">
                                <button class="cart-quantity-btn" onclick="updateCartItemQuantity('{{ $key }}', {{ $item['quantity'] - 1 }})" {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                                    <i class="fas fa-minus"></i>
                                </button>
                                <span class="cart-quantity-display" id="qty_{{ $key }}">{{ $item['quantity'] }}</span>

                                <button class="cart-quantity-btn" onclick="updateCartItemQuantity('{{ $key }}', {{ $item['quantity'] + 1 }})">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="cart-item-price">$ {{ number_format($subtotal, 2) }}</div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="cart-sidebar-footer" id="cartSidebarFooter" style="display: block;">
            <div class="cart-total">
                <div class="total-row">
                    <span>Subtotal:</span>
                    <span id="cartSubtotal">${{ number_format($amount, 2) }}</span>
                </div>
                <div class="total-row total-final">
                    <span>Total:</span>
                    <span id="cartTotal">${{ number_format($amount, 2) }}</span>
                </div>
            </div>
            <div class="cart-actions">
                <button class="btn-secondary" id="clearCartBtn">
                    <i class="fas fa-trash"></i>
                    Clear Cart
                </button>
                <button class="btn-primary" id="checkoutBtn" onclick="window.location.href='{{ route('checkout') }}'">
                    <i class="fas fa-credit-card"></i>
                    Proceed to Checkout
                </button>
            </div>
        </div>
        @endif
</div>


        
    </div>
</div>

@push('footerscript')
    <script>
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
                        alert(response.success);
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
        </script>

           </script>
     {{-- For Clear All Cart Value --}}
     <script>
    document.getElementById('clearCartBtn').addEventListener('click', function () {
        if (!confirm("Are you sure you want to clear your cart?")) return;

        $.ajax({
            url: '{{ route("cart.clear") }}', // Make sure this route exists in web.php
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                if (response.success) {
                    location.reload(); // Or update sidebar dynamically
                } else {
                    alert(response.message || "Failed to clear cart.");
                }
            },
            error: function () {
                alert("An error occurred while clearing the cart.");
            }
        });
    });
</script>
<!--mobile view-->
<!-- <script>
    document.getElementById('hamburgerMenu').addEventListener('click', function () {
        document.getElementById('mobileMenu').classList.toggle('show');
    });
</script> -->
<!-- search bar -->
<script>
    // Toggle mobile menu
    document.getElementById('hamburgerMenu').addEventListener('click', function () {
        document.getElementById('mobileMenu').classList.toggle('show');
        document.getElementById('mobileSearchContainer').classList.remove('show'); // hide search if open
    });

    // Toggle mobile search
    document.getElementById('searchIcon').addEventListener('click', function () {
        document.getElementById('mobileSearchContainer').classList.toggle('show');
        document.getElementById('mobileMenu').classList.remove('show'); // hide menu if open
    });
</script>



@endpush
