<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="{{route('root')}}" class="navbar-brand">
        <img src="{{ url('/medspa.png') }}" alt="Forever Medspa" class="brand-image img-circle elevation-3"
                style="opacity: .8" onerror="this.onerror=null; this.src='{{ url('/No_Image_Available.jpg') }}';">
            <span class="brand-text font-weight-light">Forever Medspa</span>
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
          <li class="nav-item">
            <a href="{{ route('patient.index') }}" class="nav-link">Patient List</a>
          </li>
          
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Orders</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="{{ route('cardgenerated-list') }}" class="dropdown-item">Giftcard Orders </a></li>
              <li><a href="{{ route('service-order-history.index') }}" class="dropdown-item">Service Orders</a></li>              
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Management</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="{{ route('category.index') }}" class="dropdown-item">Deals Management </a></li>
              <li><a href="{{ route('product.index') }}" class="dropdown-item"> Services Management</a></li>  
              <li><a href="{{ route('unit.index') }}" class="dropdown-item"> Unit Management</a></li>  
              <li><a href="{{ route('terms.index') }}" class="dropdown-item">Terms & Condition</a></li>  
              <li><a href="{{ route('coupon.index') }}" class="dropdown-item"> Giftcard Coupon</a></li>  
              <li><a href="{{ route('email-template.index') }}" class="dropdown-item"> Email Template</a></li>  
              <li><a href="{{ route('banner.index') }}" class="dropdown-item"> Slider Management</a></li>  
              <li class="dropdown-divider"></li>

              <!-- Level two dropdown-->
              <li class="dropdown-submenu dropdown-hover">
                <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Program Manage..</a>
                <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                  <li>
                    <a tabindex="-1" href="{{ route('program.index') }}" class="dropdown-item">Program List</a>
                  </li>
                  <li>
                    <a tabindex="-1" href="{{ route('program.create') }}" class="dropdown-item">Make Program</a>
                  </li>

                </ul>
              </li>
              <!-- End Level two -->            
            </ul>
          </li>
           @if(count(session()->get('cart', []))>0)
          <li class="nav-item">
          <button onclick="window.location.href='{{route('service-cart')}}'" type="button" data-toggle="dropdown" data-loading-text="Loading..."  class="btn btn-block btn-inverse btn-block btn-lg dropdown-toggle"><i class="fa fa-shopping-bag"></i> <span id="cart-total" class="hidden-xs">{{ count(session()->get('cart', [])) ? count(session()->get('cart', [])) : 0 }}
            </span></button></li>
             @endif
          <li class="nav-item">
            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                style="display: none;">
                @csrf
            </form>

            <a href="#"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="nav-link">
                <i class="nav-icon fa fa-power-off"></i>
                
            </a>
        </li>
        </ul>
       
      </div>

      <!-- Right navbar links -->
      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fas fa-comments"></i>
            <span class="badge badge-danger navbar-badge">3</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <a href="#" class="dropdown-item">
              <!-- Message Start -->
              <div class="media">
                <img src="../../dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    Brad Diesel
                    <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                  </h3>
                  <p class="text-sm">Call me whenever you can...</p>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
              </div>
              <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <!-- Message Start -->
              <div class="media">
                <img src="../../dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    John Pierce
                    <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                  </h3>
                  <p class="text-sm">I got your message bro</p>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
              </div>
              <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <!-- Message Start -->
              <div class="media">
                <img src="../../dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    Nora Silvester
                    <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                  </h3>
                  <p class="text-sm">The subject goes here</p>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
              </div>
              <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
          </div>
        </li>
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge">15</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-header">15 Notifications</span>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-envelope mr-2"></i> 4 new messages
              <span class="float-right text-muted text-sm">3 mins</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-users mr-2"></i> 8 friend requests
              <span class="float-right text-muted text-sm">12 hours</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-file mr-2"></i> 3 new reports
              <span class="float-right text-muted text-sm">2 days</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
            <i class="fas fa-th-large"></i>
          </a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- /.navbar -->