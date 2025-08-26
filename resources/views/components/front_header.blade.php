@push('css')

<style>
    .logo-img {
        max-height: 75px;
        width: auto;
    }

    .page-header {
       width: 100%;
       background: #000; /* full-width black background */
        margin: 0;
        padding: 15px 0; /* padding top & bottom */
    }

    .header-container {
        width: 100%;
        max-width: 1300px; /* keeps content centered */
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 20px; /* left/right padding inside */
    }

    .header-logo img {
        display: block;
    }

    .header-nav {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .header-nav .nav-link {
        color: #fff;
        font-weight: 500;
        text-decoration: none;
    }

    .header-nav .nav-link:hover {
        color: #F39548;
    }

    .cart-icon {
        position: relative;
        color: #fff;
        cursor: pointer;
    }

    .cart-count {
        position: absolute;
        top: -8px;
        right: -10px;
        background: #F39548;
        color: #fff;
        font-size: 12px;
        padding: 2px 6px;
        border-radius: 50%;
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
            position: fixed;   /* FIX: stays below header */
            top: 70px;
            left: 0;
            right: 0;
            padding: 15px;
            z-index: 1000;  /* ensure it sits above search */
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            max-height: calc(100vh - 70px); /* scroll if too tall */
            overflow-y: auto;
        }



        #mobileMenu .close-btn {
            text-align: right;
            font-size: 20px;
            cursor: pointer;
                margin-bottom: 10px;
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

    /* Mobile search container always visible */
    #mobileSearchContainer {
        display: none;
    }

    @media (max-width: 768px) {
        #mobileSearchContainer {
            display: block !important;
            position: relative;
            width: 100%;
            background-color: white;
            padding: 10px 15px;
            z-index: 999;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        #mobileSearchContainer input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    }

    /* For Phone Button */
    .btn_phone {
        display: inline-block;
        font-weight: 400;
        line-height: 1.5;
        color: #212529;
        text-align: center;
        text-decoration: none;
        vertical-align: middle;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
        padding: .375rem .75rem;
        font-size: 1rem;
        border-radius: .25rem;
        transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }

    .btnc-primary {
        border: 1px solid #F39548;
        color: #FFFFFF;
        --button-bg-color: #F39548;
        background: var(--button-bg-color);
        border-color: #F39548;
        padding: 11px 35px 11px 35px;
    }

    @media (max-width: 768px) {
    .header-nav .btn-phone {
        display: none !important;
    }
}

@media (max-width: 991px) {
    body {
        margin-top: 100px; /* matches your header height */
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
            {{-- <a href="{{ route('services') }}" class="nav-link">Services</a> --}}
            {{-- @if (Session::get('patient_details'))
                <a class="nav-link"
                    href="{{ route('patient-dashboard') }}">{{ Auth::guard('patient')->user()->fname }}</a>
            @else
                <a class="nav-link" href="{{ url('/patient-login') }}">Login</a>
            @endif
            @php
                $cart = session()->get('front_cart', []);
                $cartCount = count($cart);
            @endphp

            <div class="cart-icon" id="cartIcon">
                <i class="fas fa-shopping-cart"></i>
                <span class="cart-count {{ $cartCount === 0 ? 'hiddencount' : '' }}" id="cartCount">
                    {{ $cartCount }}
                </span>
            </div> --}}

            <!-- Hamburger Icon (mobile only) -->
            <div class="mobile-only-icon" id="hamburgerMenu">
                <i class="fas fa-bars"></i>
            </div>
            <a href="https://forevermedspanj.com/services/book-appointments/" class="btn btn_phone btnc-primary btn-phone"><span style="color:#fff"><i class="fa fa-phone" aria-hidden="true"></i> Book appointment</span></a>
        </nav>
    </div>
    <!-- Mobile Menu Links -->
    <div id="mobileMenu">
        <div class="close-btn">&times;</div>
        <a href="https://forevermedspanj.com/">Website</a>
        <a href="{{ url('/') }}">Giftcards</a>
        {{-- <a href="{{ route('services') }}">Services</a> --}}
        @if (Session::get('patient_details'))
        <a href="{{ route('patient-dashboard') }}">{{ Auth::guard('patient')->user()->fname }}</a>
        @else
        <a href="{{ url('/patient-login') }}">Login</a>
        @endif

        <a href="https://forevermedspanj.com/services/book-appointments/" class="btn btn_phone btnc-primary btn-phone" style="margin-top:10px; text-align:center;">
            <span style="color:#fff">
                <i class="fa fa-phone" aria-hidden="true"></i> Book appointment
            </span>
        </a>
    </div>

     @if(url()->current() == route('services'))
        <div id="mobileSearchContainer" class="d-block d-md-none">
            <input type="text" placeholder="Search..." id="mobileSearchInput" />
            <div class="search-dropdown" id="mobileSearchDropdown"></div>
        </div>
    @endif
    
</header>

@php
$cart = session()->get('front_cart', []);
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
                    $units = App\Models\ServiceUnit::find($item['unit_id']);
                    $image = explode('|', $units->product_image);
                    $price = $units->discounted_amount ?? $units->amount;
                    $subtotal = $price * $item['quantity'];
                    $amount += $subtotal;
                    if ($units->giftcard_redemption == 0) {
                        $redeem++;
                    }
                @endphp

                <div class="cart-item" id="cartItem_{{ $key }}">
                    <div class="cart-item-header">
                        <div class="cart-item-title">{{ $units->product_name }}</div>
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
            $.ajax({
                url: '{{ route('cartremove') }}',
                method: "POST",
                dataType: "json",
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: id,
                    cart_name: "front_cart"
                },
                success: function(response) {
                    if (response.success) {
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

     {{-- For Clear All Cart Value --}}
     <script>
    document.getElementById('clearCartBtn').addEventListener('click', function () {
        if (!confirm("Are you sure you want to clear your cart?")) return;

        $.ajax({
            url: '{{ route("cart.clear") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                cart_name: "front_cart"
            },
            success: function (response) {
                if (response.success) {
                    location.reload();
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

<!-- Hamburger toggle -->
<script>
    // document.getElementById('hamburgerMenu').addEventListener('click', function () {
    //     document.getElementById('mobileMenu').classList.toggle('show');
    // });

    // Toggle mobile menu
document.getElementById('hamburgerMenu').addEventListener('click', function () {
    const menu = document.getElementById('mobileMenu');
    menu.classList.toggle('show');
    document.getElementById('mobileSearchContainer').classList.remove('show'); // hide search
});

// Add close button functionality
document.addEventListener('click', function (e) {
    if (e.target.classList.contains('close-btn')) {
        document.getElementById('mobileMenu').classList.remove('show');
    }
});

</script>

@endpush
