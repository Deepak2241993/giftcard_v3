
    <!-- Main Sidebar Container -->

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('root') }}" class="brand-link">
            <img src="{{ url('/medspa.png') }}" alt="Forever Medspa" class="brand-image img-circle elevation-3"
                style="opacity: .8" onerror="this.onerror=null; this.src='{{url('/No_Image_Available.jpg')}}';">
            <span class="brand-text font-weight-light">Forever Medspa</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar" style="overflow-x: auto; overflow-y: auto; max-height: 100vh; max-width: 100%;">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="@if (Auth::guard('patient')->user()->image != '') {{ URL::asset(Auth::guard('patient')->user()->image) }}@else{{ URL::asset('medspa.png') }} @endif"
                        class="img-circle elevation-2" height="50" width="50" alt="User Image" onerror="this.onerror=null; this.src='{{url('/No_Image_Available.jpg')}}';">
                </div>
                <div class="info">
                    <a href="#" class="d-block"> {{ Auth::guard('patient')->user()->fname  }}</a>
                </div>
            </div>

            <!-- SidebarSearch Form -->
            <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                        <button  class="btn btn-block btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="{{route('patient-dashboard')}}" class="nav-link {{ Request::segment(count(request()->segments())) === 'dashboard' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                               
                            </p>
                        </a>
                    </li>
                    <li class="nav-header">Orders</li>

                    <li class="nav-item">
                        <a 
                            href="{{route('my-giftcards') }}" 
                            class="nav-link {{ Request::segment(count(request()->segments())) === 'my-giftcards' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-solid fa-gift"></i>
                            <p>
                                My Giftcards
                            </p>
                        </a>
                    </li>
                   
                    <li class="nav-item">
                        <a 
                            href="{{route('my-services') }}" 
                            class="nav-link {{ Request::segment(count(request()->segments())) === 'my-services' ? 'active' : '' }}">
                            <i class="nav-icon fa fa-user-md"></i>
                            <p>
                                My Services
                            </p>
                        </a>
                    </li>
                    
                    {{-- <li class="nav-header">Appointments/Store</li>
                    <li class="nav-item">
                        <a 
                            href="{{route('my-giftcards') }}" 
                            class="nav-link ">
                            <i class="nav-icon fa fa-cart-plus"></i>
                            <p>
                                Cart
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a 
                            href="{{route('my-giftcards') }}" 
                            class="nav-link">
                            <i class="nav-icon fa fa-calendar-check"></i>
                            <p>
                                Appointments
                            </p>
                        </a>
                    </li> --}}
                   

                    {{-- Patient Management  --}}
                    
                    <li class="nav-header">Profile Settings</li>
                    <li class="nav-item">
                        <a 
                            href="{{route('patient-profile') }}" 
                            class="nav-link {{ Request::segment(count(request()->segments())) === 'patient-profile' ? 'active' : '' }}">
                            <i class="nav-icon far fa-user"></i>
                            <p>
                                Profile
                            </p>
                        </a>
                    </li>
                    
                   
                    <li class="nav-item">
                        <form id="logout-form" action="{{ route('patient-logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                     
                        <a href="#"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">
                            <i class="nav-icon fa fa-power-off"></i>
                            <p>
                                Logout
                            </p>
                        </a>
                    </li>


                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

