@extends('layouts.admin_layout')
@section('body')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Patient Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Patient Profile</li>

                    </ol>
                </div>
                @if (session()->has('error'))
                    <span class="alert alert-danger">
                        {{ session()->get('error') }}
                    </span>
                @endif
                @if (session()->has('success'))
                    <span class="alert alert-success">
                        {{ session()->get('success') }}
                    </span>
                @endif
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" src="{{ $patient->image }}"
                                    style="height:100px; width:100px;"
                                    onerror="this.onerror=null; this.src='{{ url('/No_Image_Available.jpg') }}';">
                            </div>

                            <h3 class="profile-username text-center">{{ $patient->fname . ' ' . $patient->lname }}</h3>

                            <p class="text-muted text-center">Patient</p>


                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- About Me Box -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">About Me</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <strong><i class="fas fa-phone-alt mr-1"></i> Phone</strong>

                            <p class="text-muted">{{ $patient->phone }}</p>

                            <hr>
                            <strong><i class="fas fa-envelope mr-1"></i> Email</strong>

                            <p class="text-muted">{{ $patient->email }}</p>

                            <hr>

                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                            <p class="text-muted">{{ $patient->address }}</p>
                            <p class="text-muted">Zip Code: {{ $patient->zip_code }}</p>

                            <hr>




                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                {{-- <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity Timeline</a></li> --}}
                                <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Profile Settings</a></li>
                                <li class="nav-item"><a class="nav-link" href="#giftcards" data-toggle="tab">Giftcards Orders</a></li>
                                {{-- <li class="nav-item"><a class="nav-link" href="#services" data-toggle="tab">Services Orders</a></li> --}}
                                <li class="nav-item"><a class="nav-link" href="#buysection" data-toggle="tab">Buy</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{route('giftcardredeemPatientList',['id'=>$patient->id])}}">Giftcard Redeem</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{route('service-redeem-patient-list',['id'=>$patient->id])}}">Service Redeem</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">

                                {{-- <div class="active tab-pane" id="activity">
                                    <h4 class="mb-4">Time Line</h4>
                                    
                                    <div class="mb-3">
                                        <form method="GET" action="">
                                            <div class="row align-items-end g-2">
                                                <div class="col-auto">
                                                    <label for="start_time" class="form-label">Start Time:</label>
                                                    <input type="date" id="start_time" name="start_time"
                                                        value="{{ request('start_time') }}"
                                                        class="form-control form-control-sm">
                                                </div>

                                                <div class="col-auto">
                                                    <label for="end_time" class="form-label">End Time:</label>
                                                    <input type="date" id="end_time" name="end_time"
                                                        value="{{ request('end_time') }}"
                                                        class="form-control form-control-sm">
                                                </div>

                                                <div class="col-auto">
                                                    <label class="form-label invisible">Filter</label>
                                                    <button type="submit" class="btn btn-sm btn-primary w-100">Filter</button>
                                                </div>

                                                <div class="col-auto">
                                                    <label class="form-label invisible">Reset</label>
                                                    <a href="{{ url()->current() }}" class="btn btn-sm btn-secondary w-100">Reset</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    
                                    <!-- Post -->
                                    <div class="timeline timeline-inverse">
                                        @if ($timeline)
                                            @foreach ($timeline as $key => $value)
                                                <!-- timeline time label -->
                                                <div class="time-label">
                                                    <span
                                                        class="bg-{{ $value->event_type == 'Giftcard Purchase'
                                                            ? 'success'
                                                            : ($value->event_type == 'Giftcard Redeem'
                                                                ? 'primary'
                                                                : ($value->event_type == 'Order Placed'
                                                                    ? 'warning'
                                                                    : ($value->event_type == 'Service Redeem'
                                                                        ? 'primary'
                                                                        : ($value->event_type == 'Service Cancel'
                                                                            ? 'danger'
                                                                            : ($value->event_type == 'Service Refund'
                                                                                ? 'primary'
                                                                                : ($value->event_type == 'Login'
                                                                                    ? 'success'
                                                                                    : ($value->event_type == 'Logout'
                                                                                        ? 'danger'
                                                                                        : ($value->event_type == 'Patient Created'
                                                                                            ? 'primary'
                                                                                            : ($value->event_type == 'Transaction Completed'
                                                                                                ? 'success'
                                                                                                : 'danger'))))))))) }}">

                                                        {{ date('d-m-Y', strtotime($value->created_at)) }}
                                                    </span>
                                                </div>
                                                <!-- /.timeline-label -->
                                                <!-- timeline item -->
                                                <div>
                                                    @if ($value->event_type == 'Giftcard Purchase')
                                                        <i class="fas fa-solid fa-gift bg-success"></i>
                                                    @elseif($value->event_type == 'Giftcard Redeem')
                                                        <i class="fas fa-solid fa fa-barcode bg-primary"></i>
                                                    @elseif($value->event_type == 'Order Placed')
                                                        <i class="fas fa fa-check-square bg-warning"></i>
                                                    @elseif($value->event_type == 'Transaction Completed')
                                                        <i class="fas fa-credit-card-alt bg-success"></i>
                                                    @elseif($value->event_type == 'Service Redeem')
                                                        <i class="fas  fa fa-user-md bg-primary"></i>
                                                    @elseif($value->event_type == 'Service Cancel')
                                                        <i class="fas  fa fa-ban bg-danger"></i>
                                                    @elseif($value->event_type == 'Service Refund')
                                                        <i class="fas fa fa-undo bg-primary"></i>
                                                    @elseif($value->event_type == 'Login')
                                                        <i class="fas fa-power-off bg-success"></i>
                                                    @elseif($value->event_type == 'Logout')
                                                        <i class="fas fa-power-off bg-danger"></i>
                                                    @elseif($value->event_type == 'Patient Created')
                                                        <i class="fas fa fa-user-md bg-primary"></i>
                                                    @else
                                                        <i class="fas fa fa-ban bg-danger"></i>
                                                    @endif

                                                    <div class="timeline-item">
                                                        <span class="time"><i class="far fa-clock"></i>
                                                            {{ date('h:i:s', strtotime($value->created_at)) }}</span>

                                                        <h3 class="timeline-header">{{ $value->subject }}</h3>

                                                        <div class="timeline-body">
                                                            {!! $value->metadata !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- END timeline item -->
                                            @endforeach
                                        @else
                                            <p>No Giftcard History</p>
                                        @endif
                                        <!-- timeline item -->

                                        <div>
                                            <i class="far fa-clock bg-gray"></i>
                                        </div>
                                    </div>
                                    <!-- /.post -->
                                </div> --}}

                                {{-- For Settings --}}
                                <div class="active tab-pane" id="settings">
                                    <h4 class="mb-4">Profile Settings</h4>
                                    <form class="form-horizontal" method="post"
                                        action="{{ route('patient.update', $patient->id) }}" novalidate="novalidate"
                                        enctype="multipart/form-data">
                                        @method('PUT')
                                        @csrf
                                        <div class="form-group row">
                                            <label for="fanme" class="col-sm-2 col-form-label">First Name<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-sm-4">
                                                <input type="text" name="fname" class="form-control" id="fanme"
                                                    placeholder="First Name" value="{{ $patient->fname }}" required>
                                            </div>
                                            <label for="lname" class="col-sm-2 col-form-label">Last Name</label>
                                            <div class="col-sm-4">
                                                <input type="text" name="lname" class="form-control" id="lname"
                                                    placeholder="Last Name" value="{{ $patient->lname }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Email<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="email" name="email" class="form-control"
                                                    id="inputEmail" placeholder="Email" value="{{ $patient->email }}"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="phone" class="col-sm-2 col-form-label">Phone<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="phone"
                                                    placeholder="Phone" name="phone" value="{{ $patient->phone }}" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputExperience" class="col-sm-2 col-form-label">Address</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="address" id="inputExperience" placeholder="Experience">{{ $patient->address }}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="City" class="col-sm-2 col-form-label">City</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="City"
                                                    placeholder="City" name="city" value="{{ $patient->city }}">
                                            </div>
                                            <label for="Country" class="col-sm-2 col-form-label">Country</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="country"
                                                    placeholder="Country" name="country" value="{{ $patient->country }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="State" class="col-sm-2 col-form-label">Zip Code</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="State"
                                                    placeholder="Zip Code" name="zip_code" value="{{ $patient->zip_code }}">
                                            </div>
                                            <label for="Password" class="col-sm-2 col-form-label">Password</label>
                                            <div class="col-sm-4">
                                                <input type="password" name="password" class="form-control"
                                                    id="password" placeholder="Password">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Profile Image</label>
                                            <div class="col-sm-10">
                                                <input type="file" class="form-control" id="image"
                                                    name="image">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-info">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                {{-- For Orders  --}}
                                <div class="tab-pane" id="giftcards">
                                    <h4>Giftcards Orders </h4>
                                    <div class="col-12 col-sm-12">
                                        <div class="card card-primary card-outline card-tabs">
                                            <div class="card-header p-0 pt-1 border-bottom-0">
                                                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="custom-tabs-three-received-tab" data-toggle="pill"
                                                            href="#custom-tabs-three-home" role="tab"
                                                            aria-controls="custom-tabs-three-home" aria-selected="true">My
                                                            Giftcard</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="custom-tabs-three-send-tab" data-toggle="pill"
                                                            href="#custom-tabs-three-profile" role="tab"
                                                            aria-controls="custom-tabs-three-profile" aria-selected="false">Send</a>
                                                    </li>

                                                </ul>
                                            </div>
                                            <div class="card-body">
                                                <div class="scroll-container">
                                                    <div style="overflow: scroll">
                                                        <div class="tab-content" id="custom-tabs-three-tabContent">
                                                            {{-- For Mygiftcards Sends --}}
                                                            <div class="tab-pane fade show active" id="custom-tabs-three-home"
                                                                role="tabpanel" aria-labelledby="custom-tabs-three-received-tab">
                                                                @if ($mygiftcards->count())
                                                                    <table id="datatable-buttons"
                                                                        class="table table-bordered table-striped">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>#</th>
                                                                                <th>Giftcard Number</th>
                                                                                <th>Giftcard History</th>
                                                                                <th>Generated Date & Time</th>
                                                                                <th>Sender Name</th>
                                                                                {{-- <th>Message</th> --}}
                                                                                {{-- <th>Sender's Email</th> --}}
                                                                                <th>Coupon Code</th>
                                                                                <th>Qty</th>
                                                                                <th>Giftcard Value</th>
                                                                                <th>Discount</th>
                                                                                <th>Paid Amount</th>
                                                                                <th>Payment Status</th>
                                                                                <th>Transaction Id</th>

                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="data-table-body">
                                                                            @foreach ($mygiftcards as $key => $value)
                                                                                <tr>
                                                                                    <td>{{ $loop->iteration }}</td>
                                                                                    <td>
                                                                                        <a type="button"
                                                                                            class="btn btn-block btn-outline-primary"
                                                                                            data-bs-toggle="modal"
                                                                                            data-bs-target="#staticBackdrop_{{ $value['id'] }}"
                                                                                            onclick="cardview({{ $value['id'] }},'{{ $value['transaction_id'] }}')">
                                                                                            View
                                                                                        </a>

                                                                                    </td>
                                                                                    <td>
                                                                                        <a type="button" class="btn btn-block btn-outline-dark" href="{{route('giftcards-statement-admin-view', $value['id'])}}">
                                                                            History
                                                                        </a>
                                                                                       
                                                                                    </td>
                                                                                    <td><?php echo date('m-d-Y h:i:A', strtotime($value['created_at'])); ?></td>
                                                                                
                                                                                    <td>
                                                                                        @if ($value['gift_send_to'] == $value['receipt_email'])
                                                                                        Self
                                                                                        @elseif ($value['gift_send_to'] != $value['receipt_email'])
                                                                                            {{$value['your_name']}}
                                                                                        @else{
                                                                                            {{!! "<span class='badge bg-primary'>".$value['your_name']."</span>" !!}}
                                                                                        }
                                                                                        @endif
                                                                                    </td>
                                                                                    {{-- <td>{{ $value['recipient_name'] ? $value['message'] : '---' }} --}}
                                                                                    </td>
                                                                                    {{-- <td>{{ $value['recipient_name'] ? $value['receipt_email'] : 'Medspa' }}</td> --}}
                                                                                    <td class="text-uppercase">
                                                                                        {{ $value['coupon_code'] ? $value['coupon_code'] : '----' }}
                                                                                    </td>
                                                                                    <td>{{ $value['qty'] ? $value['qty'] : '----' }}</td>
                                                                                    <td>{{ $value['amount'] ? '$' . $value['amount'] : '$ 0' }}
                                                                                    </td>
                                                                                    <td>{{ $value['discount'] ? '$' . $value['discount'] : '$ 0' }}
                                                                                    </td>
                                                                                    <td>{{ $value['transaction_amount'] ? '$' . $value['transaction_amount'] : '$ 0' }}
                                                                                    </td>

                                                                                    <td>
                                                                                        @if ($value['payment_status'] == 'succeeded')
                                                                                            <span
                                                                                                class="badge bg-success">{{ ucFirst($value['payment_status']) }}</span>
                                                                                        @elseif($value['payment_status'] == 'processing')
                                                                                            <span
                                                                                                class="badge bg-primary">{{ ucFirst($value['payment_status']) }}</span>
                                                                                        @elseif($value['payment_status'] == 'amount_capturable_updated')
                                                                                            <span
                                                                                                class="badge bg-warning">{{ ucFirst($value['payment_status']) }}</span>
                                                                                        @elseif($value['payment_status'] == 'payment_failed')
                                                                                            <span
                                                                                                class="badge bg-danger">{{ ucFirst($value['payment_status']) }}</span>
                                                                                        @else
                                                                                            <span class="badge bg-danger">Incompleted</span>
                                                                                        @endif
                                                                                    </td>
                                                                                    <td>{{ $value['transaction_id'] }}</td>





                                                                                    <!-- Button trigger modal -->
                                                                                </tr>
                                                                            @endforeach
                                                                            <br>
                                                                            {{ $mygiftcards->links() }}
                                                                        </tbody>
                                                                    </table>
                                                                    {{ $mygiftcards->links() }}
                                                                @else
                                                                    <hr>
                                                                    <p> No data found</p>
                                                                @endif
                                                            </div>
                                                            {{-- All Giftcard Send  --}}

                                                            <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel"
                                                                aria-labelledby="custom-tabs-three-send-tab">
                                                                @if ($sendgiftcards->count())
                                                                <table id="datatable-buttons"
                                                                    class="table table-bordered table-striped">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Giftcard Number</th>
                                                                            <th>Giftcard History</th>
                                                                            <th>Generated Date & Time</th>
                                                                            <th>Sent to</th>
                                                                            <th>Message</th>
                                                                            {{-- <th>Sender's Email</th> --}}
                                                                            <th>Coupon Code</th>
                                                                            <th>Qty</th>
                                                                            <th>Giftcard Value</th>
                                                                            <th>Discount</th>
                                                                            <th>Paid Amount</th>
                                                                            <th>Payment Status</th>
                                                                            <th>Transaction Id</th>

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="data-table-body">
                                                                        @foreach ($sendgiftcards as $key => $value)
                                                                            <tr>
                                                                                <td>{{ $loop->iteration }}</td>
                                                                                <td>
                                                                                    <a type="button"
                                                                                        class="btn btn-block btn-outline-primary"
                                                                                        data-bs-toggle="modal"
                                                                                        data-bs-target="#staticBackdrop_{{ $value['id'] }}"
                                                                                        onclick="cardview({{ $value['id'] }},'{{ $value['transaction_id'] }}')">
                                                                                        View
                                                                                    </a>

                                                                                </td>
                                                                                <td>
                                                                                    <a type="button"
                                                                                        class="btn btn-block btn-outline-dark"
                                                                                        href="{{ route('giftcards-statement-admin-view', $value['id']) }}">
                                                                                        History
                                                                                    </a>

                                                                                </td>
                                                                                <td><?php echo date('m-d-Y h:i:A', strtotime($value['created_at'])); ?></td>
                                                                                </td>
                                                                                <td>
                                                                                    
                                                                                        @if ($value['recipient_name'] != null && ($value['gift_send_to'] != $value['receipt_email']))
                                                                                            {{$value['recipient_name']}}
                                                                                        @else
                                                                                            <span class='badge bg-primary'>{{$value['your_name']}}</span>
                                                                                        
                                                                                        @endif
                                                                                </td>
                                                                                <td>{{ $value['recipient_name'] ? $value['message'] : '---' }}
                                                                                </td>
                                                                                {{-- <td>{{ $value['recipient_name'] ? $value['receipt_email'] : 'Medspa' }}</td> --}}
                                                                                <td class="text-uppercase">
                                                                                    {{ $value['coupon_code'] ? $value['coupon_code'] : '----' }}
                                                                                </td>
                                                                                <td>{{ $value['qty'] ? $value['qty'] : '----' }}</td>
                                                                                <td>{{ $value['amount'] ? '$' . $value['amount'] : '$ 0' }}
                                                                                </td>
                                                                                <td>{{ $value['discount'] ? '$' . $value['discount'] : '$ 0' }}
                                                                                </td>
                                                                                <td>{{ $value['transaction_amount'] ? '$' . $value['transaction_amount'] : '$ 0' }}
                                                                                </td>

                                                                                <td>
                                                                                    @if ($value['payment_status'] == 'succeeded')
                                                                                        <span
                                                                                            class="badge bg-success">{{ ucFirst($value['payment_status']) }}</span>
                                                                                    @elseif($value['payment_status'] == 'processing')
                                                                                        <span
                                                                                            class="badge bg-primary">{{ ucFirst($value['payment_status']) }}</span>
                                                                                    @elseif($value['payment_status'] == 'amount_capturable_updated')
                                                                                        <span
                                                                                            class="badge bg-warning">{{ ucFirst($value['payment_status']) }}</span>
                                                                                    @elseif($value['payment_status'] == 'payment_failed')
                                                                                        <span
                                                                                            class="badge bg-danger">{{ ucFirst($value['payment_status']) }}</span>
                                                                                    @else
                                                                                        <span class="badge bg-danger">Incompleted</span>
                                                                                    @endif
                                                                                </td>
                                                                                <td>{{ $value['transaction_id'] }}</td>





                                                                                <!-- Button trigger modal -->
                                                                            </tr>
                                                                        @endforeach
                                                                        <br>
                                                                        {{ $sendgiftcards->links() }}
                                                                    </tbody>
                                                                </table>
                                                                {{ $sendgiftcards->links() }}
                                                            @else
                                                                <hr>
                                                                <p> No data found</p>
                                                            @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /.card -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                   {{-- For Services Orders  --}}
                                {{-- <div class="tab-pane" id="services">
                                    <h4>Services Orders </h4>
                                        <div class="col-12 col-sm-12">
                                            <div class="card card-primary card-outline card-tabs">
                                                <div class="card-header p-0 pt-1 border-bottom-0">
                                                    <div class="card-body">
                                                        <div class="scroll-container">
                                                            <div style="overflow: scroll">
                                                                <div class="tab-content" id="custom-tabs-three-tabContent">
                                                                    <div class="tab-pane fade show active" id="custom-tabs-three-home"
                                                                        role="tabpanel" aria-labelledby="custom-tabs-three-received-tab">
                                                                        @if ($sevice_orders->count())
                                                                            <table id="datatable-buttons"
                                                                                class="table table-bordered table-striped">
                                                                                <thead>
                                                                                <tr>
                                                                                    <th>#</th>
                                                                                    <th>View Order</th>
                                                                                    <th>Invoice</th>
                                                                                    <th>Order Number</th>
                                                                                    <th>Full Name</th>
                                                                                    <th>Email</th>
                                                                                    <th>Phone</th>
                                                                                    <th>Transaction Amount</th>
                                                                                    <th>Transaction Id</th>
                                                                                    <th>Created Date & Time</th>

                                                                                </tr>
                                                                                </thead>
                                                                                <tbody id="data-table-body">
                                                                                    @foreach ($sevice_orders as $key => $value)
                                                                                    <tr>
                                                                                        <td>{{ $loop->iteration }}</td>
                                                                                        <td>  <a  class="btn btn-block btn-outline-primary"
                                                                                            href="{{ route('service-invoice',$value->id) }}" class="btn btn-primary">Invoice Download</a>
                                                                                            
                                                                                    </td>
                                                                                        
                                                                                        @if(!empty($value->payment_intent))
                                                                                        <td>
                                                                                            <a type="button" class="btn btn-block btn-outline-dark"
                                                                                                data-bs-toggle="modal" data-bs-target="#statement_view_{{ $value['id'] }}"
                                                                                                onclick="StatementView({{ $key }},'{{ $value['order_id'] }}')">
                                                                                                Statement
                                                                                            </a>
                                                                                        </td>
                                                                                        @else
                                                                                        <td> <span class="badge bg-danger">No Payment</span></td>
                                                                                        @endif
                                                                                        <td>{{ $value->order_id }}</td>
                                                                                        <td>{{ $value->fname . ' ' . $value->lname }}</td>
                                                                                        <td>{{ $value->email }}</td>
                                                                                        <td>{{ $value->phone }}</td>
                                                                                        <td>{{ $value->final_amount }}</td>
                                                                                        <td>{{ $value->payment_intent }}</td>
                                                                                        <td>{{ date('m-d-Y h:i:m', strtotime($value->updated_at)) }}
                                                                                        </td>

                                                                                    </tr>
                                                                                @endforeach
                                                                                    <br>
                                                                                    {{ $sevice_orders->links() }}
                                                                                </tbody>
                                                                            </table>
                                                                            {{ $sevice_orders->links() }}
                                                                        @else
                                                                            <hr>
                                                                            <p> No data found</p>
                                                                        @endif
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                            <!-- /.card -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div> --}}
                                   {{-- For Buy  --}}
                                <div class="tab-pane" id="buysection">
                                    <h4>Buy </h4>
                                        <div class="col-12 col-sm-12">
                                            <div class="card card-primary card-outline card-tabs">
                                                <div class="card-header p-0 pt-1 border-bottom-0 m-4">
                                                   <a href="{{route('giftcards-sale',['id'=>$patient->id])}}" class="btn btn-primary">Giftcard Buy</a>
                                                   <a href="{{route('service-buy-from-patient',['id'=>$patient->id])}}" class="btn btn-dark">Service & Deals Sale</a>
                                                   <a href="{{route('program-sale',['id'=>$patient->id])}}" class="btn btn-warning">Program Sale</a>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
<div class="modal fade deepak" id="staticBackdrop_" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Gift Card Number</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h2 id="giftcardsshow"></h2>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-block btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
</div>

{{-- Service history Modal Code --}}
{{-- For Statment View Modal --}}
    <div class="modal fade statement" id="statement_view_" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Service Redeem Statement</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div style="display: flex; flex-direction: column;">
                        <!-- Existing placeholders for other data -->
                        <!-- Dynamic content area for table -->
                        <div id="dynamicContent"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-block btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Statement View Modal End --}}
    <!-- /.content-wrapper -->
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 300, // Set height of the editor
                width: 860, // Set width of the editor
                focus: true, // Focus the editor on load
                fontSizes: ['8', '9', '10', '11', '12', '14', '18', '22', '24', '36', '48', '64', '82',
                    '150'
                ], // Font sizes
                toolbar: [
                    ['undo', ['undo']],
                    ['redo', ['redo']],
                    ['style', ['bold', 'italic', 'underline']],
                    ['font', ['strikethrough']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ol', 'paragraph']],
                    ['insert', ['picture', 'link']] // Add picture button for image upload
                    // ['para', ['ul','ol', 'paragraph']],
                ],
                popover: {
                    image: [
                        ['custom', ['examplePlugin']],
                        ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
                        ['float', ['floatLeft', 'floatRight', 'floatNone']],
                        ['remove', ['removeMedia']]
                    ]
                }
            });
        });
    // Service Use History Modal Code
    function StatementView(id, order_id) {
            $('.statement').attr('id', 'statement_view_' + id);
            $('#statement_view_' + id).modal('show');

            // AJAX request to fetch data
            $.ajax({
                url: '{{ route('service-statement') }}',
                method: "post",
                dataType: "json",
                data: {
                    _token: '{{ csrf_token() }}',
                    order_id: order_id
                },
                success: function(response) {
                    if (response.success) {
                        var servicePurchases = response.servicePurchases;
                        var serviceRedeem = response.serviceRedeem;

                        var tableHTML = `
                <table cellpadding="0" cellspacing="0" style="font-family:Open Sans,-apple-system,BlinkMacSystemFont,Roboto,Helvetica Neue,Helvetica,Arial,sans-serif;border-collapse:collapse;width:100%; background-color: #f9f9f9; margin: 20px 0;">
                    <tbody>
                        <tr>
                            <td class="content" align="center" style="padding:40px 48px; background-color: #fca52a; color: #ffffff;">
                                <h1 style="font-weight:300;font-size:28px;line-height:130%;margin:16px 0; text-align:center;">Service Redeem Statement</h1>
                            </td>
                        </tr>
                        <tr>
                            <td class="content" style="padding:40px 48px; background-color: #ffffff;">
                                
                                <table border="1" cellspacing="0" cellpadding="10" style="font-family:Open Sans,-apple-system,BlinkMacSystemFont,Roboto,Helvetica Neue,Helvetica,Arial,sans-serif;border-collapse:collapse;width:100%; border: 1px solid #ddd; margin-top: 20px;">
                                    <tr style="background-color: #fca52a; color: white;">
                                        <th style="padding: 10px; text-align: left;">Transaction Date</th>
                                        <th style="padding: 10px; text-align: left;">Transaction Number</th>
                                        <th style="padding: 10px; text-align: left;">Service Name</th>
                                        <th style="padding: 10px; text-align: left;">Message</th>
                                        <th style="padding: 10px; text-align: left;">Service Session</th>

                                        <th style="padding: 10px; text-align: left;">Service Session Redeem</th>
                                    </tr>`;

                        // Loop through each purchase to show credits
                        $.each(servicePurchases, function(index, item) {
                            tableHTML += `
                    <tr style="background-color: #f2f2f2;">
                        <td style="padding: 10px;">${new Date(item.updated_at).toLocaleDateString()}</td>
                        <td style="padding: 10px;">${item.order_id}</td>
                      <td style="padding: 10px;">
                        ${item.service_type === 'product' ? item.product_name : ''}
                        ${item.service_type === 'unit' ? item.unit_name : ''}
</td>
                        <td style="padding: 10px;">Buy</td>
                        <td style="padding: 10px;">${item.number_of_session ? item.number_of_session : 'NULL'}</td>
                        <td style="padding: 10px;">--</td>
                    </tr>`;
                        });

                        // Loop through each redemption to show debits
                        $.each(serviceRedeem, function(index, value) {
                            tableHTML += `
                    <tr>
                        <td style="padding: 10px;">${new Date(value.updated_at).toLocaleDateString()}</td>
                        <td style="padding: 10px;">${value.transaction_id}</td>

                        <td style="padding: 10px;">
                        ${value.service_type === 'product' ? value.product_name : ''}
                        ${value.service_type === 'unit' ? value.unit_name : ''}
                            </td>
                        <td style="padding: 10px;">${value.comments ? value.comments : ''}</td>
                        <td style="padding: 10px;">--</td>
                        <td style="padding: 10px;">${value.number_of_session_use}</td>
                    </tr>`;
                        });

                        tableHTML += `</table>
                                
                            </td>
                        </tr>
                    </tbody>
                </table>`;

                        // Append the table HTML to the modal body
                        $('#statement_view_' + id + ' .modal-body').html(tableHTML);
                    } else {
                        // Handle case when response is not successful
                        $('#statement_view_' + id + ' .modal-body').html('<p>No statement found.</p>');
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    $('#statement_view_' + id + ' .modal-body').html(
                        '<p>An error occurred. Please try again later.</p>');
                }
            });
        }
    </script>
    {{-- For Modal Code --}}
    <script>
        //  Giftcard View Modal Code
        function cardview(id, tid) {
            $('.deepak').attr('id', 'staticBackdrop_' + id);
            $('#staticBackdrop_' + id).modal('show');

            $.ajax({
                url: '{{ route('cardview-route') }}',
                method: "post",
                dataType: "json",
                data: {
                    _token: '{{ csrf_token() }}',
                    tid: tid,
                    user_token: 'FOREVER-MEDSPA',
                },
                success: function(response) {
                    if (response.success) {
                        $('#giftcardsshow').empty();
                        $.each(response.result, function(index, element) {
                            // Create a new element with the giftnumber
                            var newElement = $('<div>').html(element.giftnumber);

                            // Append the new element to #giftcardsshow
                            $('#giftcardsshow').append(newElement);
                        });

                    }
                }
            });
        }
        

    </script>
    <script>
        function toggleSelectOptions() {
            var dealsRadio = document.getElementById('dealsRadio');
            var servicesRadio = document.getElementById('servicesRadio');
            var dealsSelect = document.getElementById('dealsSelect');
            var servicesSelect = document.getElementById('servicesSelect');

            // Toggle visibility based on selected radio button
            if (dealsRadio.checked) {
                dealsSelect.style.display = 'block';
                servicesSelect.style.display = 'none';
            } else if (servicesRadio.checked) {
                servicesSelect.style.display = 'block';
                dealsSelect.style.display = 'none';
            }
        }

        function seturl(data) {
            // Define the base URLs with placeholders for dynamic segments
            var unitBaseUrl = @json(route('unit-details', ['product_slug' => 'placeholder', 'unitslug' => 'placeholder']));
            var productDetailsBaseUrl = @json(route('productdetails', ['slug' => 'placeholder']));

            if (data === 'unit') {
                var deals = $('#deals').val(); // Get the value of the deals field
                if (deals) {
                    // Replace placeholders with actual values
                    var updatedUrl = unitBaseUrl.replace('placeholder', 'banners').replace('placeholder', deals);
                    $('#url').val(updatedUrl); // Set the updated URL in the input field
                } else {
                    alert('Please select a deal!');
                }
            }

            if (data === 'services') {
                var services = $('#services').val(); // Get the value of the services field
                if (services) {
                    // Replace placeholder with actual value
                    var updatedUrl = productDetailsBaseUrl.replace('placeholder', services);
                    $('#url').val(updatedUrl); // Set the updated URL in the input field
                } else {
                    alert('Please select a service!');
                }
            }
        }
    </script>
@endpush
