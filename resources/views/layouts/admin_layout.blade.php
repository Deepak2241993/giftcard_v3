
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Forever Medspa | Dashboard</title>



   <!-- Google Font: Source Sans Pro -->
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
   <!-- Font Awesome -->
   <link rel="stylesheet" href="{{url('/')}}/plugins/fontawesome-free/css/all.min.css">
   <!-- daterange picker -->
   <link rel="stylesheet" href="{{url('/')}}/plugins/daterangepicker/daterangepicker.css">
   <!-- iCheck for checkboxes and radio inputs -->
   <link rel="stylesheet" href="{{url('/')}}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
   <!-- Bootstrap Color Picker -->
   <link rel="stylesheet" href="{{url('/')}}/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
   <!-- Tempusdominus Bootstrap 4 -->
   <link rel="stylesheet" href="{{url('/')}}/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
   <!-- Select2 -->
   <link rel="stylesheet" href="{{url('/')}}/plugins/select2/css/select2.min.css">
   <link rel="stylesheet" href="{{url('/')}}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
   <!-- Bootstrap4 Duallistbox -->
   <link rel="stylesheet" href="{{url('/')}}/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
   <!-- BS Stepper -->
   <link rel="stylesheet" href="{{url('/')}}/plugins/bs-stepper/css/bs-stepper.min.css">
   <!-- dropzonejs -->
   <link rel="stylesheet" href="{{url('/')}}/plugins/dropzone/min/dropzone.min.css">
   <!-- Theme style -->
   <link rel="stylesheet" href="{{url('/')}}/dist/css/adminlte.min.css">
    <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  {{-- For Sweet Alert --}}
  <link rel="stylesheet" href="{{url('/')}}/plugins/summernote/summernote-bs4.min.css">
     <!-- DataTables -->
     <link rel="stylesheet" href="{{url('/')}}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
     <link rel="stylesheet" href="{{url('/')}}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
     <link rel="stylesheet" href="{{url('/')}}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

   <link rel="stylesheet" href="{{url('/')}}/dist/css/deepak.css">
  <link rel="stylesheet" href="{{url('/')}}/dist/toastr/toastr.css">
<!-- for Font giftcardsale page -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.3.0/css/all.min.css" integrity="sha256-/4UQcSmErDzPCMAiuOiWPVVsNN2s3ZY/NsmXNcj0IFc=" crossorigin="anonymous">
{{--  For Auto Seach --}}
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@stack('css')
</head>
{{-- <body class="hold-transition sidebar-mini"> --}}
<body class="hold-transition sidebar-collapse layout-top-nav">
  
<div class="wrapper">
  <!-- Navbar -->
    {{-- <x-topbar/> --}}
    <x-admin_topbar/>
  <!-- /.navbar -->

    <!-- Main Sidebar Container -->
       <x-sidebar/>
    <!-- Content Wrapper. Contains page content -->
    <div class="container content-wrapper" style="overflow-x: auto; overflow-y: auto; max-height: 100vh; max-width: 100%;">
 
         @yield('body')
    </div>
      <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        </aside>

    <x-footer/>
        <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    <x-footerscript/>
    <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
   
   
    @stack('script')
    <!--end::Script-->
</body><!--end::Body-->

</html>