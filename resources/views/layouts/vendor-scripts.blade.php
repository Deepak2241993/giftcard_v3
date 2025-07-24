<!-- JAVASCRIPT -->
@if(route('email-template.create')!=url()->current() && Request::segment(2)!='email-template')
{
<script src="{{ URL::asset('/assets/libs/jquery/jquery.min.js') }}"></script> 
}
@endif

<script src="{{ URL::asset('/assets/libs/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/metismenu/metismenu.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/node-waves/node-waves.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/feather-icons/feather-icons.min.js') }}"></script>
<!-- pace js -->
<script src="{{ URL::asset('assets/libs/pace-js/pace-js.min.js') }}"></script>
@yield('script')
@yield('script-bottom')

