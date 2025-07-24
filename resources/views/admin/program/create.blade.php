@extends('layouts.admin_layout')
@section('body')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Program Create/Update</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/root') }}">Home</a></li>
                        <li class="breadcrumb-item active">Program Create/Update</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content-header">

        <!--begin::App Content Header-->
        @if ($errors->has('image'))
            <div class="alert alert-danger">
                {{ $errors->first('image') }}
            </div>
        @endif
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="card-body p-4">
                    @if (isset($program))
                        <form method="post" action="{{ route('program.update', $program->id) }}"
                            enctype="multipart/form-data">
                            @method('PUT')
                        @else
                            <form method="post" action="{{ route('program.store') }}" enctype="multipart/form-data">
                    @endif
                    @csrf
                    <div class="row">
                        <!-- Title -->
                        <div class="mb-3 col-lg-6">
                            <label for="title" class="form-label">Program Name</label>
                            <input class="form-control" type="text" name="program_name"
                                value="{{ isset($program) ? $program->program_name : '' }}" placeholder="Program Name">
                        </div>
                        <div class="mb-3 col-lg-12">
                            <label for="title" class="form-label">Program Description</label>
                            <textarea class="form-control summernote" name="description"> {{ isset($program) ? $program->description : '' }} </textarea>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Select Unit</label>
                                <select class="select2bs4" multiple="multiple" name="unit_id[]" data-placeholder="Select Multiple Units"
                                        style="width: 100%;" required>
                                    @if($units)
                                        @foreach($units as $value)
                                            <option value="{{ $value->id }}"
                                                
                                                @if(isset($selectedUnits) && in_array($value->id, $selectedUnits)) selected @endif>
                                                {{ $value->product_name }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option>No Unit Found</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        
                        <!-- Status -->
                        <div class="mb-3 col-lg-6">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" name="status" id="status">
                                <option value="1"
                                    {{ isset($program->status) && $program->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0"
                                    {{ isset($program->status) && $program->status == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="mb-3 col-lg-6">
                            <button class="btn btn-block btn-outline-primary form_submit" type="submit"
                                name="submit">Submit</button>
                        </div>

                        </select>
                    </div>



                </div>
                </form>
            </div>
            <!--end::Row-->
            <!-- /.Start col -->
        </div>
        <!-- /.row (section row) -->
        </div>
        <!--end::Container-->
        </div>
        <!--end::App Content-->
    </section>
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
