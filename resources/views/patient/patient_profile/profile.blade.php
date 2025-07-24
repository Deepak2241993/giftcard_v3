@extends('layouts.patient_layout')
@section('body')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Profile</li>
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

                            <p class="text-muted text-center">{{ $patient->patient_login_id }}</p>


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
                                {{-- <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity
                                        Timeline</a></li> --}}
                                <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Profile
                                        Settings</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane" id="activity">
                                     {{-- For Search --}}
                                     <div class="d-flex justify-content-end mb-3">
                                        <form method="GET" action="" class="d-flex align-items-center">
                                          <label for="start_time" class="me-2">Start Time:</label>
                                          <input type="date" id="start_time" name="start_time" value="{{ request('start_time') }}" class="form-control me-2">
                                          
                                          <label for="end_time" class="me-2">End Time:</label>
                                          <input type="date" id="end_time" name="end_time" value="{{ request('end_time') }}" class="form-control me-2">
  
                                          <button type="submit" class="btn btn-primary me-2">Filter</button> |
                                          <a href="{{ url()->current() }}" class="btn btn-secondary">Reset</a>
                                        </form>
                                      </div>
                                      {{-- Search Line Time --}}
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
                                                        {{-- <div class="timeline-footer">
                            <a href="#" class="btn btn-primary btn-sm">Read more</a>
                            <a href="#" class="btn btn-danger btn-sm">Delete</a>
                          </div> --}}
                                                    </div>
                                                </div>
                                                <!-- END timeline item -->
                                            @endforeach
                                        @else
                                            <p>No Giftcard History</p>
                                        @endif
                                        <!-- timeline item -->

                                        <!-- END timeline item -->

                                        <!-- END timeline item -->
                                        <div>
                                            <i class="far fa-clock bg-gray"></i>
                                        </div>
                                    </div>
                                    <!-- /.post -->
                                </div>
                                <!-- /.tab-pane -->


                                <div class="active tab-pane" id="settings">

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
                                                <input type="text" name="phone" class="form-control" id="phone"
                                                    placeholder="Phone" value="{{ $patient->phone }}" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputExperience" class="col-sm-2 col-form-label">Address</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" id="inputExperience" name="address" placeholder="Experience">{{ $patient->address }}</textarea>
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
                                <!-- /.tab-pane -->
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
