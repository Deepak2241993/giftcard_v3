@extends('layouts.front-master')

@push('csslink')
<style>
    .hiddencount { display: none !important; }

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

                    @if($ServiceUnit->fetures_original_price == 1)
                        <div class="service-price">
                            From $<del>{{ $ServiceUnit->amount }}</del>
                        </div>
                    @endif

                    @if($ServiceUnit->popular_service == 1)
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

                    <button class="book-now-btn"
                        onclick="addcart({{ $ServiceUnit->id }}, {{ $ServiceUnit->min_qty }}, 'unit')">
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

<script>
function addcart(unit_id, quantity, type) {
    $.ajax({
        url: '{{ route("cart") }}',
        method: 'POST',
        dataType: 'json',
        data: {
            _token: '{{ csrf_token() }}',
            unit_id: unit_id,
            quantity: quantity,
            type: type,
            cart_name: 'front_cart'
        },
        success: function (response) {
            if (response.success) {
                location.reload();
            }
        },
        error: function () {
            alert('Something went wrong. Please try again.');
        }
    });
}
</script>
@endpush
