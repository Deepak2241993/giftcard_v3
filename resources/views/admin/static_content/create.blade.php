@extends('layouts.admin_layout')
@section('body')
    <script src="http://cdn.ckeditor.com/4.6.2/standard-all/ckeditor.js"></script>
   <section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>All Static Content</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/root') }}">Home</a></li>
                    <li class="breadcrumb-item active">All Static Content</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

        <!--end::App Content Header-->
        <!--begin::App Content-->
        <section class="content-header">
            <div class="card card-flush">
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    
              
                    <div class="app-content">
                        <!--begin::Container-->
                        <div class="container-fluid">
                            <!--begin::Row-->
                            <div class="card-body p-4">
                                @if (isset($staticContent))
                                    <form method="post" enctype="multipart/form-data"
                                        action="{{ route('static-content.update', $staticContent->id) }}" id="validation">
                                        @method('PUT')
                                    @else
                                        <form method="post" action="{{ route('static-content.store') }}"
                                            enctype="multipart/form-data">
                                @endif
                                @csrf
                                <div class="row">

                                    <div class="mb-3 col-lg-6 col-md-6">
                                        <label for="page_name" class="form-label">Page Name<span
                                                class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="page_name" placeholder="Page Name"
                                            id="page_name" value="{{ isset($staticContent) ? $staticContent->page_name : '' }}"
                                            required>
                                    </div>
                                    <div class="mb-3 col-lg-6 col-md-6">
                                        <label for="title" class="form-label">Title<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="title" placeholder="Title" id="title"
                                            value="{{ isset($staticContent) ? $staticContent->title : '' }}" required>
                                    </div>
                                    <div class="mb-3 col-lg-12 col-md-6 self">
                                        <label for="content" class="form-label">Content<span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control" name="content" id="content" cols="30" rows="10" required>{{ isset($staticContent) ? $staticContent->content : '' }}</textarea>
                                    </div>


                                    <div class="mb-3 col-lg-6">

                                        <button class="btn btn-block btn-outline-primary" type="submit"
                                            name="submit">Submit</button>
                                    </div>
                                </div>
                                </form>

                            </div>
                            <!--end::Row-->
                            <!-- /.Start col -->
                        </div>
                        <!-- /.row (main row) -->
                    </div>
                </div>
            </div>
        </section>
        <!-- /.container-fluid -->
@endsection


@push('script')
    <script>
        function couponRedeem() {
            // Get the selected radio button
            var selectedValue = document.querySelector('input[name="coupon"]:checked').value;

            // You can perform actions based on the selected value
            if (selectedValue === 'yes') {
                // Code to handle when "YES" is selected
                $('.coupon_code').show();
            } else if (selectedValue === 'no') {
                // Code to handle when "NO" is selected
                $('.coupon_code').hide();
            }
        }
    </script>




    <script>
        function geftCardSendToOther() {
            var recipientRadios = document.getElementsByName('recipient');

            for (var i = 0; i < recipientRadios.length; i++) {
                // alert(recipientRadios[i].value);
                if (recipientRadios[i].value == 'other' && recipientRadios[i].checked) {
                    // Display the selected value
                    $('.self').css({
                        'display': 'block'
                    });
                    break; // Exit the loop since we found the selected radio button
                }
                if (recipientRadios[i].value == 'self' && recipientRadios[i].checked) {
                    // Display the selected value
                    $('.self').css({
                        'display': 'none'
                    });
                    break; // Exit the loop since we found the selected radio button
                }
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 300, // set editor height
                minHeight: null, // set minimum height of editor
                maxHeight: null, // set maximum height of editor
                focus: true // set focus to editable area after initializing summernote
                popover: {
                    image: [

                        // This is a Custom Button in a new Toolbar Area
                        ['custom', ['examplePlugin']],
                        ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
                        ['float', ['floatLeft', 'floatRight', 'floatNone']],
                        ['remove', ['removeMedia']]
                    ]
                }
            });
        });
    </script>
@endpush
