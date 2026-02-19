@extends('layouts.admin_layout')
@section('body')
    <div class="content">
    <div class="container-fluid">

        <!-- ================================
            GIFT CARD TRANSACTION OVERVIEW
        ================================= -->
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card">
                    <div class="card-header border-0 d-flex justify-content-between">
                        <h3 class="card-title">Gift Cards Transaction Overview</h3>
                        <a href="{{ url('admin/cardgenerated-list') }}" class="btn btn-primary btn-sm">See All</a>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            <!-- Today -->
                            <div class="col-md-3">
                                <div class="info-box bg-info">
                                    <span class="info-box-icon"><i class="fas fa-calendar-day"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Today's Transactions</span>
                                        <span class="info-box-number">{{ $todayGiftcards }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Yesterday -->
                            <div class="col-md-3">
                                <div class="info-box bg-warning">
                                    <span class="info-box-icon"><i class="fas fa-calendar-minus"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Yesterday</span>
                                        <span class="info-box-number">{{ $yesterdayGiftcards }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Last 7 Days -->
                            <div class="col-md-3">
                                <div class="info-box bg-success">
                                    <span class="info-box-icon"><i class="fas fa-calendar-week"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Last 7 Days</span>
                                        <span class="info-box-number">{{ $last7DaysGiftcards }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Last Month -->
                            <div class="col-md-3">
                                <div class="info-box bg-danger">
                                    <span class="info-box-icon"><i class="fas fa-calendar-alt"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Last Month</span>
                                        <span class="info-box-number">{{ $lastMonthGiftcards }}</span>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row mt-3">
                            <!-- This Month -->
                            <div class="col-md-3">
                                <div class="info-box bg-primary">
                                    <span class="info-box-icon"><i class="fas fa-calendar"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">This Month</span>
                                        <span class="info-box-number">{{ $thisMonthGiftcards }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>



        <!-- ================================
            SERVICE SALES OVERVIEW
        ================================= -->
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card">
                    <div class="card-header border-0 d-flex justify-content-between">
                        <h3 class="card-title">Service Sales Overview</h3>
                        <a href="{{ url('admin/service-order-history') }}" class="btn btn-primary btn-sm">See All</a>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            <!-- Today -->
                            <div class="col-md-3">
                                <div class="info-box bg-info">
                                    <span class="info-box-icon"><i class="fas fa-calendar-day"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Today's Sales</span>
                                        <span class="info-box-number">{{ $todayServiceSales }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Yesterday -->
                            <div class="col-md-3">
                                <div class="info-box bg-warning">
                                    <span class="info-box-icon"><i class="fas fa-calendar-minus"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Yesterday</span>
                                        <span class="info-box-number">{{ $yesterdayServiceSales }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Last 7 Days -->
                            <div class="col-md-3">
                                <div class="info-box bg-success">
                                    <span class="info-box-icon"><i class="fas fa-calendar-week"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Last 7 Days</span>
                                        <span class="info-box-number">{{ $last7DaysServiceSales }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Last Month -->
                            <div class="col-md-3">
                                <div class="info-box bg-danger">
                                    <span class="info-box-icon"><i class="fas fa-calendar-alt"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Last Month</span>
                                        <span class="info-box-number">{{ $lastMonthServiceSales }}</span>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row mt-3">
                            <!-- This Month -->
                            <div class="col-md-3">
                                <div class="info-box bg-primary">
                                    <span class="info-box-icon"><i class="fas fa-calendar"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">This Month</span>
                                        <span class="info-box-number">{{ $thisMonthServiceSales }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>



        <!-- ================================
            COMPARISON CHARTS ROW
        ================================= -->
        <div class="row">

            <!-- Giftcard Chart -->
            <div class="col-lg-6 mb-4">
                <div class="card chart-card">
                    <div class="card-header border-0 d-flex justify-content-between">
                        <h3 class="card-title">Gift Card Sales Comparison</h3>
                        <a href="#" class="btn btn-primary btn-sm">View Report</a>
                    </div>

                    <div class="card-body">
                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">${{ number_format($thisMonthGiftcardSales,2) }}</span>
                                <span>Sales This Month</span>
                            </p>

                            <p class="ml-auto d-flex flex-column text-right">
                                <span class="{{ $giftcardSalesGrowth >= 0 ? 'text-success' : 'text-danger' }}">
                                    <i class="fas fa-arrow-{{ $giftcardSalesGrowth >=0 ? 'up':'down' }}"></i>
                                    {{ number_format($giftcardSalesGrowth,1) }}%
                                </span>
                                <span class="text-muted">vs Last Month</span>
                            </p>
                        </div>

                        <div class="position-relative mb-4" style="height:280px;">
                            <canvas id="giftcard-sales-comparison-chart"></canvas>
                        </div>

                        <div class="d-flex flex-row justify-content-end">
                            <span class="mr-3"><i class="fas fa-square text-primary"></i> {{ now()->year }}</span>
                            <span><i class="fas fa-square text-secondary"></i> {{ now()->subYear()->year }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service Chart -->
            <div class="col-lg-6 mb-4">
                <div class="card chart-card">
                    <div class="card-header border-0 d-flex justify-content-between">
                        <h3 class="card-title">Service Sales Comparison</h3>
                        <a href="#" class="btn btn-primary btn-sm">View Report</a>
                    </div>

                    <div class="card-body">

                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">${{ number_format($thisMonthServiceSales,2) }}</span>
                                <span>Sales This Month</span>
                            </p>

                            <p class="ml-auto d-flex flex-column text-right">
                                <span class="{{ $thisMonthServiceSales >= $lastMonthServiceSales ? 'text-success':'text-danger' }}">
                                    <i class="fas fa-arrow-{{ $thisMonthServiceSales >= $lastMonthServiceSales ? 'up':'down' }}"></i>
                                    {{ $lastMonthServiceSales > 0 ? number_format((($thisMonthServiceSales-$lastMonthServiceSales)/$lastMonthServiceSales)*100,1) : 100 }}%
                                </span>
                                <span class="text-muted">vs Last Month</span>
                            </p>
                        </div>

                        <div class="position-relative mb-4" style="height:280px;">
                            <canvas id="service-sales-comparison-chart"></canvas>
                        </div>

                        <div class="d-flex flex-row justify-content-end">
                            <span class="mr-3"><i class="fas fa-square text-primary"></i> {{ now()->year }}</span>
                            <span><i class="fas fa-square text-secondary"></i> {{ now()->subYear()->year }}</span>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            {{-- For Most Sold Products --}}
            <div class="col-lg-6 mt-4">
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title">Most Sold Products</h3>
                    </div>

                    <div class="card-body p-0">
                        <table class="table table-striped m-0">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Qty Sold</th>
                                    <th>Revenue</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($topProducts as $item)
                                <tr>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ $item->cat_name ?? 'N/A' }}</td>
                                    <td><strong>{{ $item->total_qty }}</strong></td>
                                    <td>${{ number_format($item->total_revenue, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
            {{-- For Category Wise --}}
            <div class="col-lg-6 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Campaign-wise Revenue</h3>
                    </div>

                    <div class="card-body p-0">
                        <table class="table table-hover m-0">
                            <thead>
                                <tr>
                                    <th>Campaign</th>
                                    <th>Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($campaignRevenue as $c)
                                    <tr>
                                        <td>{{ $c->cat_name ?? 'Uncategorized' }}</td>
                                        <td>${{ number_format($c->total_revenue, 2) }}</td>
                                    </tr>
                                @endforeach

                                <tr class="bg-light font-weight-bold">
                                    <td>Total Deals Revenue</td>
                                    <td>${{ number_format($totalDealsRevenue, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>


        <div class="row mt-4">
            <!-- Giftcard Pie Chart -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-0 d-flex justify-content-between">
                        <h3 class="card-title">Giftcard Order Status</h3>
                    </div>

                    <div class="card-body">
                        <div style="height:300px;">
                            <canvas id="giftcard-order-pie"></canvas>
                        </div>

                        <ul class="mt-3 list-group">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Total Orders</span>
                                <strong>{{ $giftcardTotalOrders }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Completed</span>
                                <strong>{{ $giftcardCompletedOrders }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Pending / In-progress</span>
                                <strong>{{ $giftcardPendingOrders }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Cancelled / Refunded</span>
                                <strong>{{ $giftcardCancelledOrders }}</strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Service Order Pie Chart -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-0 d-flex justify-content-between">
                        <h3 class="card-title">Service Order Status</h3>
                    </div>

                    <div class="card-body">
                        <div style="height:300px;">
                            <canvas id="service-order-pie"></canvas>
                        </div>

                        <ul class="mt-3 list-group">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Total Orders</span>
                                <strong>{{ $serviceTotalOrders }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Completed</span>
                                <strong>{{ $serviceCompletedOrders }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Pending / In-progress</span>
                                <strong>{{ $servicePendingOrders }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Cancelled / Refunded</span>
                                <strong>{{ $serviceCancelledOrders }}</strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
{{-- GIftCard Metrix --}}
        <div class="row mt-4">
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Giftcard Status Overview</h3>
                </div>

                <div class="card-body">
                    <canvas id="giftcard-pie-chart" height="200"></canvas>
                </div>
            </div>

        </div>
        <div class="card mt-4">
            <div class="card-header">
                <h3 class="card-title">Last 12 Months Redemption Trend</h3>
            </div>

            <div class="card-body">
                <canvas id="giftcard-redemption-trend-chart" height="200"></canvas>
            </div>
        </div>




    </div>
</div>

@endsection
@push('script')
    <!-- OPTIONAL SCRIPTS -->
    <script src="{{ url('/') }}/plugins/chart.js/Chart.min.js"></script>
    <script src="{{ url('/') }}/dist/js/pages/dashboard3.js"></script>
    <script>
        $(function() {

            var ctx = document.getElementById('giftcard-sales-comparison-chart').getContext('2d');

            var months = @json($monthsList);
            var currentYearData = @json($currentYearData);
            var lastYearData = @json($lastYearData);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [{
                            label: "{{ now()->year }} Sales ($)",
                            data: currentYearData,
                            backgroundColor: "rgba(60,141,188,0.8)",
                            borderColor: "rgba(60,141,188,1)",
                            borderWidth: 1
                        },
                        {
                            label: "{{ now()->subYear()->year }} Sales ($)",
                            data: lastYearData,
                            backgroundColor: "rgba(210,214,222,0.8)",
                            borderColor: "rgba(210,214,222,1)",
                            borderWidth: 1
                        }
                    ]
                },

                options: {
                    responsive: true,
                    maintainAspectRatio: false,

                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                callback: function(value) {
                                    return "$" + value;
                                }
                            }
                        }],
                        xAxes: [{
                            barPercentage: 0.45,
                            categoryPercentage: 0.6
                        }]
                    }
                }
            });

        });
    </script>

    <script>
        $(function() {

            var ctx = document.getElementById('service-sales-comparison-chart').getContext('2d');

            var months = @json($serviceMonthsList);
            var currentYearData = @json($serviceCurrentYearData);
            var lastYearData = @json($serviceLastYearData);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [{
                            label: "{{ now()->year }} Sales ($)",
                            data: currentYearData,
                            backgroundColor: "rgba(0,123,255,0.8)",
                            borderColor: "rgba(0,123,255,1)",
                            borderWidth: 1
                        },
                        {
                            label: "{{ now()->subYear()->year }} Sales ($)",
                            data: lastYearData,
                            backgroundColor: "rgba(180,180,180,0.7)",
                            borderColor: "rgba(150,150,150,1)",
                            borderWidth: 1
                        }
                    ]
                },

                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                callback: value => "$" + value
                            }
                        }],
                        xAxes: [{
                            barPercentage: 0.45,
                            categoryPercentage: 0.6
                        }]
                    }
                }
            });

        });
    </script>

    {{-- PI Cahrt Script --}}
    <script>
$(function () {

    // -----------------------------
    // Giftcard Order Pie Chart
    // -----------------------------
    new Chart(document.getElementById("giftcard-order-pie"), {
        type: 'pie',
        data: {
            labels: ["Completed", "Pending", "Cancelled"],
            datasets: [{
                data: [
                    {{ $giftcardCompletedOrders }},
                    {{ $giftcardPendingOrders }},
                    {{ $giftcardCancelledOrders }}
                ],
                backgroundColor: [
                    "rgba(40, 167, 69, 0.8)",   // green
                    "rgba(255, 193, 7, 0.8)",   // yellow
                    "rgba(220, 53, 69, 0.8)"    // red
                ],
                borderColor: [
                    "rgba(40, 167, 69, 1)",
                    "rgba(255, 193, 7, 1)",
                    "rgba(220, 53, 69, 1)"
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });


    // -----------------------------
    // Service Order Pie Chart
    // -----------------------------
    new Chart(document.getElementById("service-order-pie"), {
        type: 'pie',
        data: {
            labels: ["Completed", "Pending", "Cancelled"],
            datasets: [{
                data: [
                    {{ $serviceCompletedOrders }},
                    {{ $servicePendingOrders }},
                    {{ $serviceCancelledOrders }}
                ],
                backgroundColor: [
                    "rgba(40, 167, 69, 0.8)",   // green
                    "rgba(255, 193, 7, 0.8)",   // yellow
                    "rgba(220, 53, 69, 0.8)"    // red
                ],
                borderColor: [
                    "rgba(40, 167, 69, 1)",
                    "rgba(255, 193, 7, 1)",
                    "rgba(220, 53, 69, 1)"
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

});
</script>

{{-- For Giftcard Metrix --}}
<script>
    var gcPie = new Chart(document.getElementById('giftcard-pie-chart').getContext('2d'), {
    type: "pie",
    data: {
        labels: ["Sold", "Redeemed", "Cancelled"],
        datasets: [{
            data: [
                {{ $totalGiftcardsSold }},
                {{ $totalGiftcardsRedeemed }},
                {{ $totalGiftcardsCancelled }}
            ],
            backgroundColor: ["#007bff", "#28a745", "#dc3545"]
        }]
    }
});



new Chart(document.getElementById('giftcard-redemption-trend-chart'), {
    type: "line",
    data: {
        labels: @json($trendMonths),
        datasets: [{
            label: "Redeemed",
            data: @json($trendCount),
            borderColor: "#28a745",
            fill: false,
            borderWidth: 2
        }]
    }
});

</script>

@endpush
