@extends('layouts.admin_layout')
@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">

                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">



                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header border-0 d-flex justify-content-between">
                                <h3 class="card-title">Gift Cards Transaction Overview</h3>
                                <a href="{{ url('admin/cardgenerated-list') }}" class="btn btn-primary btn-sm">See All</a>
                            </div>

                            <div class="card-body">
                                <div class="row">

                                    <div class="col-md-3">
                                        <div class="info-box bg-info">
                                            <span class="info-box-icon"><i class="fas fa-calendar-day"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Today's Transactions</span>
                                                <span class="info-box-number">{{ $todayGiftcards }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="info-box bg-warning">
                                            <span class="info-box-icon"><i class="fas fa-calendar-minus"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Yesterday</span>
                                                <span class="info-box-number">{{ $yesterdayGiftcards }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="info-box bg-success">
                                            <span class="info-box-icon"><i class="fas fa-calendar-week"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Last 7 Days</span>
                                                <span class="info-box-number">{{ $last7DaysGiftcards }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="info-box bg-danger">
                                            <span class="info-box-icon"><i class="fas fa-calendar-alt"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Last Months</span>
                                                <span class="info-box-number">{{ $lastMonthGiftcards }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>



                <div class="row mt-3">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header border-0 d-flex justify-content-between">
                                <h3 class="card-title">Service Sales Overview</h3>
                                <a href="{{ url('admin/service-order-history') }}" class="btn btn-primary btn-sm">See
                                    All</a>
                            </div>

                            <div class="card-body">
                                <div class="row">

                                    <div class="col-md-3">
                                        <div class="info-box bg-info">
                                            <span class="info-box-icon"><i class="fas fa-calendar-day"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Today's Sales</span>
                                                <span class="info-box-number">{{ $todayServiceSales }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="info-box bg-warning">
                                            <span class="info-box-icon"><i class="fas fa-calendar-minus"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Yesterday</span>
                                                <span class="info-box-number">{{ $yesterdayServiceSales }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="info-box bg-success">
                                            <span class="info-box-icon"><i class="fas fa-calendar-week"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Last 7 Days</span>
                                                <span class="info-box-number">{{ $last7DaysServiceSales }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="info-box bg-danger">
                                            <span class="info-box-icon"><i class="fas fa-calendar-alt"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Last Months</span>
                                                <span class="info-box-number">{{ $lastMonthServiceSales }}</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row mt-3">
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





















                <div class="row">
                    {{-- <div class="col-lg-6">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Online Store Visitors</h3>
                  <a href="javascript:void(0);">View Report</a>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg">820</span>
                    <span>Visitors Over Time</span>
                  </p>
                  <p class="ml-auto d-flex flex-column text-right">
                    <span class="text-success">
                      <i class="fas fa-arrow-up"></i> 12.5%
                    </span>
                    <span class="text-muted">Since last week</span>
                  </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                  <canvas id="visitors-chart" height="200"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> This Week
                  </span>

                  <span>
                    <i class="fas fa-square text-gray"></i> Last Week
                  </span>
                </div>
              </div>
            </div>
            <!-- /.card -->

            <div class="card">
              <div class="card-header border-0">
                <h3 class="card-title">Products</h3>
                <div class="card-tools">
                  <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-download"></i>
                  </a>
                  <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-bars"></i>
                  </a>
                </div>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-striped table-valign-middle">
                  <thead>
                  <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Sales</th>
                    <th>More</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                    <td>
                      <img src="{{url('/')}}/dist/img/default-150x150.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                      Some Product
                    </td>
                    <td>$13 USD</td>
                    <td>
                      <small class="text-success mr-1">
                        <i class="fas fa-arrow-up"></i>
                        12%
                      </small>
                      12,000 Sold
                    </td>
                    <td>
                      <a href="#" class="text-muted">
                        <i class="fas fa-search"></i>
                      </a>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <img src="{{url('/')}}/dist/img/default-150x150.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                      Another Product
                    </td>
                    <td>$29 USD</td>
                    <td>
                      <small class="text-warning mr-1">
                        <i class="fas fa-arrow-down"></i>
                        0.5%
                      </small>
                      123,234 Sold
                    </td>
                    <td>
                      <a href="#" class="text-muted">
                        <i class="fas fa-search"></i>
                      </a>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <img src="{{url('/')}}/dist/img/default-150x150.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                      Amazing Product
                    </td>
                    <td>$1,230 USD</td>
                    <td>
                      <small class="text-danger mr-1">
                        <i class="fas fa-arrow-down"></i>
                        3%
                      </small>
                      198 Sold
                    </td>
                    <td>
                      <a href="#" class="text-muted">
                        <i class="fas fa-search"></i>
                      </a>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <img src="{{url('/')}}/dist/img/default-150x150.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                      Perfect Item
                      <span class="badge bg-danger">NEW</span>
                    </td>
                    <td>$199 USD</td>
                    <td>
                      <small class="text-success mr-1">
                        <i class="fas fa-arrow-up"></i>
                        63%
                      </small>
                      87 Sold
                    </td>
                    <td>
                      <a href="#" class="text-muted">
                        <i class="fas fa-search"></i>
                      </a>
                    </td>
                  </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.card -->
          </div> --}}
                    <!-- /.col-md-6 -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">Gift Card Sales</h3>
                                    <a href="javascript:void(0);">View Report</a>
                                </div>
                            </div>

                            <div class="card-body">

                                <div class="d-flex">
                                    <p class="d-flex flex-column">
                                        <span class="text-bold text-lg">
                                            ${{ number_format($thisMonthGiftcardSales ?? 0, 2) }}
                                        </span>
                                        <span>Sales This Month</span>
                                    </p>

                                    <p class="ml-auto d-flex flex-column text-right">
                                        <span
                                            class="{{ isset($giftcardSalesGrowth) && $giftcardSalesGrowth >= 0 ? 'text-success' : 'text-danger' }}">
                                            <i
                                                class="fas fa-arrow-{{ isset($giftcardSalesGrowth) && $giftcardSalesGrowth >= 0 ? 'up' : 'down' }}"></i>
                                            {{ number_format($giftcardSalesGrowth ?? 0, 1) }}%
                                        </span>
                                        <span class="text-muted">vs Last Month</span>
                                    </p>
                                </div>

                                <div class="position-relative mb-4">
                                    <canvas id="giftcard-sales-chart" height="200"></canvas>
                                </div>

                                <div class="d-flex flex-row justify-content-end">
                                    <span class="mr-2">
                                        <i class="fas fa-square text-primary"></i> Sales
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- /.card -->

                        <div class="card">
                            <div class="card-header border-transparent">
                                <h3 class="card-title">Latest Orders</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table m-0">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Item</th>
                                                <th>Status</th>
                                                <th>Popularity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><a href="pages/examples/invoice.html">OR9842</a></td>
                                                <td>Call of Duty IV</td>
                                                <td><span class="badge badge-success">Shipped</span></td>
                                                <td>
                                                    <div class="sparkbar" data-color="#00a65a" data-height="20">
                                                        90,80,90,-70,61,-83,63</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><a href="pages/examples/invoice.html">OR1848</a></td>
                                                <td>Samsung Smart TV</td>
                                                <td><span class="badge badge-warning">Pending</span></td>
                                                <td>
                                                    <div class="sparkbar" data-color="#f39c12" data-height="20">
                                                        90,80,-90,70,61,-83,68</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><a href="pages/examples/invoice.html">OR7429</a></td>
                                                <td>iPhone 6 Plus</td>
                                                <td><span class="badge badge-danger">Delivered</span></td>
                                                <td>
                                                    <div class="sparkbar" data-color="#f56954" data-height="20">
                                                        90,-80,90,70,-61,83,63</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><a href="pages/examples/invoice.html">OR7429</a></td>
                                                <td>Samsung Smart TV</td>
                                                <td><span class="badge badge-info">Processing</span></td>
                                                <td>
                                                    <div class="sparkbar" data-color="#00c0ef" data-height="20">
                                                        90,80,-90,70,-61,83,63</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><a href="pages/examples/invoice.html">OR1848</a></td>
                                                <td>Samsung Smart TV</td>
                                                <td><span class="badge badge-warning">Pending</span></td>
                                                <td>
                                                    <div class="sparkbar" data-color="#f39c12" data-height="20">
                                                        90,80,-90,70,61,-83,68</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><a href="pages/examples/invoice.html">OR7429</a></td>
                                                <td>iPhone 6 Plus</td>
                                                <td><span class="badge badge-danger">Delivered</span></td>
                                                <td>
                                                    <div class="sparkbar" data-color="#f56954" data-height="20">
                                                        90,-80,90,70,-61,83,63</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><a href="pages/examples/invoice.html">OR9842</a></td>
                                                <td>Call of Duty IV</td>
                                                <td><span class="badge badge-success">Shipped</span></td>
                                                <td>
                                                    <div class="sparkbar" data-color="#00a65a" data-height="20">
                                                        90,80,90,-70,61,-83,63</div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                                <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Place New Order</a>
                                <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All
                                    Orders</a>
                            </div>
                            <!-- /.card-footer -->
                        </div>
                    </div>
                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@push('script')
    <!-- OPTIONAL SCRIPTS -->
    <script src="{{ url('/') }}/plugins/chart.js/Chart.min.js"></script>
    <script src="{{ url('/') }}/dist/js/pages/dashboard3.js"></script>
@endpush
