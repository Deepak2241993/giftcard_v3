@extends('layouts.master-without-nav')
@section('title')
    @lang('translation.Login')
@endsection
<style>
    @media (max-width: 768px) {
        .hide-on-mobile {
            display: none !important;
        }
    }

    @media (min-width: 769px) {
        .show-only-mobile {
            display: none !important;
        }
    }
</style>
@section('content')
    <div class="auth-page">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col-xxl-6 col-lg-4 col-md-5 d-block d-md-block">
                    <div class="auth-full-page-content d-flex p-sm-5 p-4">
                        <div class="w-100">
                            <div class="d-flex flex-column h-100">
                                
                                <div class="auth-content my-auto">
                                    <div class="md-5 text-center">
                                        <a href="{{ url('/') }}" class="d-block auth-logo">
                                            <img src="{{ URL::asset('assets/images/logo.png') }}" alt=""
                                                height="80"onerror="this.onerror=null; this.src='{{ url('/No_Image_Available.jpg') }}';">
                                        </a>
                                    </div>
                                    <div class="card mt-4">
                                        <div class="card-body" id="login_id">
                                            <div class="text-center">
                                                <h4 class="mb-0">Patient Login</h4>
                                            </div>
                                            <form class="mt-4 mb-4 pt-2 card-body" action="{{ route('patient-login') }}" method="POST">
                                                @csrf
                                                <!-- Email Input -->
                                                <div class="form-floating form-floating-custom mb-4">
                                                    <input type="text"
                                                        class="form-control @error('patient_login_id') is-invalid @enderror"
                                                        value="{{ old('patient_login_id', request()->cookie('username')) }}" id="input-username"
                                                        placeholder="Enter User Name" name="patient_login_id">
                                                    @error('patient_login_id')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    <label for="input-username">Username</label>
                                                    <div class="form-floating-icon">
                                                        <i data-feather="users"></i>
                                                    </div>
                                                </div>
                                            
                                                <!-- Password Input -->
                                                <div class="form-floating form-floating-custom mb-4 auth-pass-inputgroup">
                                                    <input type="password"
                                                        class="form-control pe-5 @error('password') is-invalid @enderror"
                                                        name="password" value="{{ request()->cookie('password') }}" id="password-input" placeholder="Enter Password">
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    <button type="button"
                                                        class="btn btn-block btn-link position-absolute h-100 end-0 top-0"
                                                        id="password-addon">
                                                        <i class="mdi mdi-eye-outline font-size-18 text-muted"></i>
                                                    </button>
                                                    <label for="password-input">Password</label>
                                                    <div class="form-floating-icon">
                                                        <i data-feather="lock"></i>
                                                    </div>
                                                </div>
                                            
                                                <!-- Remember Me Checkbox -->
                                                <div class="form-check mb-3">
                                                    <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ request()->cookie('remember') ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="remember">Remember Me</label>
                                                </div>
                                            
                                                <!-- Submit and Signup Buttons -->
                                                <div class="mb-3">
                                                    <button class="btn btn-success waves-effect waves-light" type="submit">Log In</button>
                                                    <button class="btn btn-primary waves-effect waves-light" type="button" onclick="SignUp()">Signup</button>
                                                </div>
                                                <a href="{{route('forgot-password')}}">Forgot Password? / User Name</a>
                                            </form>
                                            
                                        </div>
                                    </div>

                                    {{--  for Sign Up Form --}}
                                    <div class="card">
                                        <div class="card-body" id="signup">
                                            <div class="text-center">
                                                <h4 class="mb-0">Patient Sign Up</h4>
                                            </div>
                                            <form class="mt-4 mb-4 pt-2 card-body" method="post">
                                                @csrf
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <div data-mdb-input-init class="form-outline">
                                                            <input type="text" id="firstName" name="fname" class="form-control form-control-lg" />
                                                            <label class="form-label" for="firstName">First Name<span class="text-danger">*</span></label>
                                                        </div>
                                                        <div id="error-fname" class="text-danger mt-1"></div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div data-mdb-input-init class="form-outline">
                                                            <input type="text" id="lastName" name="lname" class="form-control form-control-lg" />
                                                            <label class="form-label" for="lastName">Last Name</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                                <div class="row g-3 mt-3">
                                                    <div class="col-md-6">
                                                        <div data-mdb-input-init class="form-outline">
                                                            <input type="email" id="emailAddress" name="email" class="form-control form-control-lg" />
                                                            <label class="form-label" for="emailAddress">Email<span class="text-danger">*</span></label>
                                                        </div>
                                                        <div id="error-email" class="text-danger mt-1"></div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div data-mdb-input-init class="form-outline">
                                                            <input type="tel" id="phoneNumber" name="phone" class="form-control form-control-lg" />
                                                            <label class="form-label" for="phoneNumber">Phone Number</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                                <div class="row g-3 mt-3">
                                                    <div class="col-md-8">
                                                        <div data-mdb-input-init class="form-outline">
                                                            <input type="text" id="User_name" name="patient_login_id" class="form-control form-control-lg" />
                                                            <label class="form-label" for="User_name">Create User Name<span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="showbalance" style="color: red; margin-top: 10px;"></div>
                                                        <div id="error-username" class="text-danger mt-1"></div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <button class="form-control btn btn-primary btn-lg" id="user_id_check" onclick="CheckUser()" type="button">
                                                            Check
                                                        </button>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div data-mdb-input-init class="form-outline">
                                                            <input type="password" id="password" name="password" class="form-control form-control-lg" />
                                                            <label class="form-label" for="password">Password<span class="text-danger">*</span></label>
                                                        </div>
                                                        <div id="error-password" class="text-danger mt-1"></div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div data-mdb-input-init class="form-outline">
                                                            <input type="password" id="cpassword" name="cpassword" class="form-control form-control-lg" />
                                                            <label class="form-label" for="cpassword">Confirm Password<span class="text-danger">*</span></label>
                                                        </div>
                                                        <div id="error-cpassword" class="text-danger mt-1"></div>
                                                    </div>
                                                </div>
                                            
                                                <div class="d-flex justify-content-between gap-3 mt-4">
                                                    <button class="btn btn-success btn-lg w-50" type="button" onclick="PatientSignIn(event)">Submit</button>
                                                    <button class="btn btn-primary btn-lg w-50" onclick="Login()" type="button">Login</button>
                                                </div>
                                                
                                            </form>
                                            

                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 mt-md-5 text-center">
                                    <p class="mb-0">©
                                        <script>
                                            document.write(new Date().getFullYear())
                                        </script> Forever Medspa . Crafted with <i
                                            class="mdi mdi-heart text-danger"></i> by <a
                                            href="https://www.thetemz.com/">TemzSolution Pvt.Ltd</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end auth full page content -->
                </div>
                <!-- end col -->
                <div class="col-xxl-6 col-lg-8 col-md-7 d-none d-md-block">
                    <div class="auth-bg pt-md-5 p-4 d-flex">
                        <div class="bg-overlay"></div>
                        <ul class="bg-bubbles">
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                        </ul>
                        <!-- end bubble effect -->
                        <div class="row justify-content-center align-items-end">
                            <div class="col-xl-7">
                                <div class="p-0 p-sm-4 px-xl-0">
                                    <div id="reviewcarouselIndicators" class="carousel slide" data-bs-ride="carousel">

                                        <!-- end carouselIndicators -->
                                        <div class="carousel-inner">
                                            <div class="carousel-item active">
                                                <div class="testi-contain text-center text-white">
                                                    <i class="bx bxs-quote-alt-left text-success display-6"></i>
                                                    <h4 class="mt-4 fw-medium lh-base text-white">
                                                        WHAT IS ACCUTITE?<br>
                                                        AccuTite is the smallest contraction device in cosmetic medicine.
                                                        With AccuTite, physicians are able to apply focal radiofrequency
                                                        contraction and prevent the need for more invasive or excisional
                                                        surgery. The AccuTite is the latest in the Radiofrequency Assisted
                                                        Lipo-coagulation (RFAL) family of technologies

                                                        FOREVER MEDSPA POWERED BY TEMZ™

                                                    </h4>

                                                    <div class="mt-4 pt-1 pb-5 mb-5">
                                                        <h5 class="font-size-16 text-white">DEEPAK KESWANI
                                                        </h5>
                                                        <p class="mb-0 text-white-50">MD</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="carousel-item">
                                                <div class="testi-contain text-center text-white">
                                                    <i class="bx bxs-quote-alt-left text-success display-6"></i>
                                                    <h4 class="mt-4 fw-medium lh-base text-white">Mature Lips<br>
                                                        Lips lay in the central lower one third of the face, this area shows
                                                        all the changes due to gravity, bone loss and deep fat loss.
                                                        Following are few of the effects of the above changes.
                                                    </h4>
                                                    <div class="mt-4 pt-1 pb-5 mb-5">
                                                        <h5 class="font-size-16 text-white">DEEPAK KESWANI
                                                        </h5>
                                                        <p class="mb-0 text-white-50">MD</p>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <!-- end carousel-inner -->
                                    </div>
                                    <!-- end review carousel -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container fluid -->
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('assets/js/pages/pass-addon.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/feather-icon.init.js') }}"></script>
    {{--  For check User Name Existing  --}}
    <script>
    $('#signup').hide();
       
        //  for open sign Form
        function SignUp() {
            $('#login_id').hide();
            $('#signup').show();
        }

        function Login() {
            $('#login_id').show();
            $('#signup').hide();
        }
        function CheckUser() {
    var user_name = $('#User_name').val();

    // Clear previous error messages
    $('#error-username').text(''); // Specific to the username error field
    $('.showbalance').hide(); // Hide previous success/error messages

    $.ajax({
        url: '{{ route('checkusername') }}',
        method: 'post',
        dataType: 'json',
        data: {
            _token: '{{ csrf_token() }}',
            username: user_name,
        },
        success: function(response) {
            if (response.success) {
                $('.showbalance').html(response.message).css('color', 'green').show();
            } else {
                $('.showbalance').html(response.message).css('color', 'red').show();
            }
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });
}



        //  For SignUp Logic Code
        function PatientSignIn(event) {
        event.preventDefault(); // Prevent form submission

        var firstName = $('#firstName').val();
        var lastName = $('#lastName').val();
        var emailAddress = $('#emailAddress').val();
        var phoneNumber = $('#phoneNumber').val();
        var User_name = $('#User_name').val();
        var password = $('#password').val();
        var cpassword = $('#cpassword').val();

        // Clear previous error messages
        $('#error-fname').text('');
        $('#error-email').text('');
        $('#error-username').text('');
        $('#error-password').text('');
        $('#error-cpassword').text('');
        $('.showbalance').hide(); // Hide previous messages

        $.ajax({
            url: '{{ route('patient-signup') }}',
            method: 'post',
            dataType: 'json',
            data: {
                _token: '{{ csrf_token() }}',
                fname: firstName,
                lname: lastName,
                email: emailAddress,
                phone: phoneNumber,
                patient_login_id: User_name,
                password: password,
                cpassword: cpassword,
            },
            success: function(response) {
                if (response.success) {
                    // Show success message
                    alert(response.message);
                    // Optionally, redirect to login or home page:
                    window.location.href = '{{route('patient-login')}}';
                } else {
                    alert('Something went wrong!');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    if (errors.fname) $('#error-fname').text(errors.fname[0]).show();
                    if (errors.email) $('#error-email').text(errors.email[0]).show();
                    if (errors.email) $('#error-email').text(errors.email).show();
                    if (errors.patient_login_id) $('#error-username').text(errors.patient_login_id[0]).show();
                    if (errors.password) $('#error-password').text(errors.password[0]).show();
                    if (errors.cpassword) $('#error-cpassword').text(errors.cpassword[0]).show();
                } else {
                    console.log(xhr.responseText);
                }
            }
        });
    }
    </script>
@endsection
