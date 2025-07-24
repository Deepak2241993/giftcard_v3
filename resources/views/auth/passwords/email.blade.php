@extends('layouts.master-without-nav')
@section('title')
    @lang('translation.Login')
@endsection
@section('content')
    <div class="auth-page">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col-xxl-6 col-lg-4 col-md-5">
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
                                                <h5 class="mb-0">Reset Password {{ session('status') }}</h5>
                                                <p class="text-muted mt-2">Reset Password with Forever Medspa.</p>
                                            </div>
                                            @if(session('error'))
                                                <div class="alert alert-danger">
                                                    {{ session('error') }}
                                                </div>
                                            @else
                                            <div class="alert alert-success text-center my-4" role="alert">
                                                Enter your Registered Email and instructions will be sent to you!
                                            </div>
                                            @endif
                                            @if (session('status'))
                                                <div class="alert alert-success" role="alert">
                                                    {{ session('status') }}
                                                </div>
                                            @endif
                                            <form class="mt-4" action="{{route('password-reset')}}" method="POST">
                                            @csrf
                                                <div class="form-floating form-floating-custom mb-4">
                                                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" id="input-email" placeholder="Enter Email">
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    <label for="input-email">Email</label>
                                                    <div class="form-floating-icon">
                                                        <i data-feather="mail"></i>
                                                    </div>
                                                </div>
                                                <div class="mb-3 mt-4">
                                                    <button  class="btn btn-block btn-outline-primary w-100 waves-effect waves-light" type="submit">Request new password</button>
                                                </div>
                                            </form>
            
                                            <div class="mt-5 text-center">
                                                <p class="text-muted mb-0">Remember It ?  <a href="{{route('patient-login')}}"
                                                        class="text-primary fw-semibold"> Sign In </a> </p>
                                            </div>
                                            
                                        </div>
                                    </div>

                                    {{--  for Sign Up Form --}}
                                 
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
                <div class="col-xxl-6 col-lg-8 col-md-7">
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

@endsection










