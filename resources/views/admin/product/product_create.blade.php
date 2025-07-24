@extends('layouts.admin_layout')
@section('body')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="mb-0">Service Create</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Service Add/Update
                        </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content-header">
        <!--begin::App Content-->
        <div class="app-content">
            @if (session()->has('error'))
                <span class="alert alert-danger">
                    {{ session()->get('error') }}
                </span>
            @endif
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        @if (isset($data))
                            <form method="post" action="{{ route('product.update', $data['id']) }}"
                                enctype="multipart/form-data">
                                @method('PUT')
                            @else
                                <form method="post" action="{{ route('product.store') }}" enctype="multipart/form-data">
                        @endif
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-lg-6 self">
                                <label for="product_name" class="form-label">Service Name<span
                                        class="text-danger">*</span></label>
                                <input class="form-control" id="product_name" required type="text" name="product_name"
                                    value="{{ isset($data) ? $data['product_name'] : '' }}" placeholder="Product Name"
                                    onkeyup="slugCreate()">
                            </div>
                            <div class="mb-3 col-lg-6 self">
                                <label for="product_slug" class="form-label">Service Slug<span
                                        class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="product_slug"
                                    value="{{ isset($data) ? $data['product_slug'] : '' }}" placeholder="Slug"
                                    id="product_slug">
                            </div>
                            <div class="mb-3 col-lg-6 self">
                                <label class="form-label">Select Service Category <span class="text-danger">*</span></label>
                                @if ($category)
                                    @foreach ($category as $value)
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="cat_id[]"
                                                value="{{ $value['id'] }}"
                                                {{ isset($data['cat_id']) && (is_array($data['cat_id']) ? in_array($value['id'], $data['cat_id']) : $data['cat_id'] == $value['id']) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="cat_{{ $value['id'] }}">
                                                {{ $value['cat_name'] }}
                                            </label>
                                        </div>
                                    @endforeach
                                @else
                                    <div>No Category Found</div>
                                @endif
                            </div>
                            <div class="mb-3 col-lg-6 self">
                                <label class="form-label">Select Unit </label>
                                @if ($units)
                                    @foreach ($units as $value)
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input unit-checkbox" name="unit_id[]"
                                                value="{{ $value['id'] }}"
                                                {{ isset($data['unit_id']) && (is_array($data['unit_id']) ? in_array($value['id'], $data['unit_id']) : $data['unit_id'] == $value['id']) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="cat_{{ $value['id'] }}">
                                                {{ $value['product_name'] }}
                                            </label>
                                        </div>
                                    @endforeach
                                @else
                                    <div>No Unit Found</div>
                                @endif
                            </div>




                            <div class="mb-12 col-lg-12 self">
                                <label for="short_description" class="form-label">Short Description
                                    <span class="text-danger"> (Text Limit 100 Word)</span>
                                </label>
                                <textarea name="short_description" id="short_description" class="form-control" required rows="4">{{ isset($data) ? $data['short_description'] : '' }}</textarea>
                                <span id="count" class="text-danger"></span>
                            </div>
                            <div class="mb-12 col-lg-12 self mt-3">
                                <label for="product_description" class="form-label">Long Description</label>
                                <textarea name="product_description" id="product_description" class="form-control summernote" onkeyup="calculate()">{{ isset($data) ? $data['product_description'] : '' }}</textarea>
                            </div>
                            {{-- <div class="mb-12 col-lg-12 self mt-3 UnitHideShow">
                    <label for="prerequisites" class="form-label">Prerequisites</label>
                    <textarea name="prerequisites" id="prerequisites"
                        class="form-control summernote">{{ isset($data) ? $data['prerequisites'] : '' }}</textarea>
                </div> --}}


                            @php
                                if (isset($data)) {
                                    $image = explode('|', $data['product_image']);
                                }
                            @endphp
                            @if (isset($image))
                                <div class=" col-md-12 mt-4 box" style="border:solid 1px;" id="image_class">
                                    <button type="button"
                                        style="
                        background-color: red;
                        color: #ffffff;
                        border: red;
                        width: 30px;
                        height: 25px;
                        justify-content: flex-start;
                        align-items: center;

                    "
                                        onclick="hideImage({{ 1 }})">X</button>
                                    <div class="row">

                                        @foreach ($image as $key => $imagevalue)
                                            @isset($imagevalue)
                                                <div class="mb-3 col-lg-4 self">
                                                    <label for="product_image" class="form-label">Service Image</label><br>
                                                    <img src="{{ $imagevalue }}" class="mb-4"
                                                        style="width:100%; height:200px; margin-right: -20px;"
                                                        onerror="this.onerror=null; this.src='{{ url('/No_Image_Available.jpg') }}';">

                                                </div>
                                            @endisset
                                        @endforeach
                                    </div>

                                </div>
                            @endif

                            {{-- <div class="mb-3 col-lg-12 self" id="image_field"
                    style="display:{{ isset($data['id']) ? 'none' : 'block' }}">
                    <label for="product_image" class="form-label">Service Image<span
                            class="text-danger">* 350 X 350 Px Size Should be between 10kb to 2mb</span></label><br>
                    <input class="form-control" id="image" type="file" name="product_image[]" multiple
                        {{ isset($data) ? '' : 'required' }}>
                </div> --}}

                            <div class="mb-3 col-lg-6 mt-4 self mt-2 numberInputContainer">
                                <label for="amount" class="form-label">Service Original Price<span
                                        class="text-danger">*</span>
                                </label>
                                <input class="form-control float_class" type="number" min="0" name="amount"
                                    value="{{ isset($data) ? $data['amount'] : '' }}"
                                    placeholder="Service Original Price" step="0.01">
                                <input class="form-control" type="hidden" min="0" name="id"
                                    value="{{ isset($data) ? $data['id'] : '' }}">
                            </div>
                            <div class="mb-3 col-lg-6 mt-4 self mt-2 numberInputContainer">
                                <label for="discounted_amount" class="form-label">Service Price<span
                                        class="text-danger">*</span></label>
                                <input class="form-control float_class" type="number" min="0"
                                    name="discounted_amount" value="{{ isset($data) ? $data['discounted_amount'] : '' }}"
                                    placeholder="Service Price" step="0.01">
                            </div>
                            <div class="mb-3 col-lg-6 mt-4 self UnitHideShow">
                                <label for="session_number" class="form-label">Number of session<span
                                        class="text-danger">*</span></label>
                                <input class="form-control" type="number" min="1" name="session_number"
                                    value="{{ isset($data) ? $data['session_number'] : '1' }}"
                                    placeholder="Number Of Session" required id="session_number">
                            </div>
                            <div class="mb-3 col-lg-6 mt-4">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-control" name="status" id='status'>
                                    <option
                                        value="1"{{ isset($data['status']) && $data['status'] == 1 ? 'selected' : '' }}>
                                        Active</option>
                                    <option
                                        value="0"{{ isset($data['status']) && $data['status'] == 0 ? 'selected' : '' }}>
                                        Inactive</option>
                                </select>
                            </div>

                            {{-- <div class="mb-12 col-lg-12 self">
                    <label for="search_keywords" class="form-label">Search Keywords</label>
                    <textarea name="search_keywords" id="search_keywords" rows="4"
                        class="form-control">{{ isset($data) ? $data['search_keywords'] : '' }}</textarea>

                </div> --}}
                            <div class="mb-12 col-lg-12 mt-4 self">
                                <label for="meta_title" class="form-label">Meta Title</label>
                                <textarea name="meta_title" id="meta_title" rows="4" class="form-control">{{ isset($data) ? $data['meta_title'] : '' }}</textarea>
                            </div>
                            <div class="mb-12 col-lg-12 mt-4 self">
                                <label for="meta_description" class="form-label">Meta Description</label>
                                <textarea name="meta_description" id="meta_description" rows="4" class="form-control">{{ isset($data) ? $data['meta_description'] : '' }}</textarea>
                            </div>
                            <div class="mb-12 col-lg-12 mt-4 self">
                                <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                <textarea name="meta_keywords" id="meta_keywords" rows="4" class="form-control">{{ isset($data) ? $data['meta_keywords'] : '' }}</textarea>
                            </div>

                            <div class="mb-3 col-lg-12 mt-4">
                                <label for="from" class="form-label">Popular Services</label>
                                <select class="form-control" name="popular_service" id="from">
                                    <option value="1"
                                        {{ isset($data['popular_service']) && $data['popular_service'] == 1 ? 'selected' : '' }}>
                                        Yes</option>
                                    <option value="0"
                                        {{ isset($data['popular_service']) && $data['popular_service'] == 0 ? 'selected' : '' }}>
                                        No</option>
                                </select>
                            </div>
                            {{-- <div class="mb-3 col-lg-6">
                                <label for="giftcard_redemption" class="form-label">Giftcard Redeem</label>
                                <select class="form-control" name="giftcard_redemption" id="giftcard_redemption">
                                    <option value="0"
                                        {{ isset($data['giftcard_redemption']) && $data['giftcard_redemption'] == 0 ? 'selected' : '' }}>
                                        No</option>
                                    <option value="1"
                                        {{ isset($data['giftcard_redemption']) && $data['giftcard_redemption'] == 1 ? 'selected' : '' }}>
                                        Yes</option>
                                </select>
                            </div> --}}
                            
                                <div class="mb-3 col-lg-3 mt-4">
                                    <button class="btn btn-block btn-outline-primary w-100" type="submit" id="submitBtn">
                                        Submit
                                    </button>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
                    <!--end::Row-->
    </section>
@endsection

@push('script')
    <script>
        // For Input type Number Field is Hide
        $(document).ready(function() {
            // Function to toggle the number input visibility
            function toggleNumberInput() {
                if ($('.unit-checkbox:checked').length > 0) {
                    $('.numberInputContainer').hide();
                    $('.UnitHideShow').hide();

                } else {
                    $('.numberInputContainer').show();
                    $('.UnitHideShow').show();

                }
            }
            // Initial check on page load
            toggleNumberInput();
            // Toggle visibility when any checkbox is clicked
            $('.unit-checkbox').on('change', function() {
                toggleNumberInput();
            });
        });
        // For Input type Number Field is Hide*********

        // For Input type Take Float Value
        const totalAmt = document.getElementByClass("float_class");
        totalAmt.addEventListener("change", (e) => {
            // e.preventDefault(e);
            const result = parseFloat(e.target.value);
            console.log(result)
        });

        // For Input type Take Float Value End
        function hideImage() {
            $('#image_class').hide();
            $('#image_field').show();
        }
    </script>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 300, // Set height of the editor
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
        function slugCreate() {
            $.ajax({
                url: '{{ route('slugCreate') }}',
                method: "post",
                dataType: "json",
                data: {
                    _token: '{{ csrf_token() }}',
                    product_name: $('#product_name').val(),
                },
                success: function(response) {
                    if (response.success) {
                        $('#product_slug').val(response.slug);
                    } else {
                        $('.showbalance').html(response.error).show();
                    }
                }
            });
        }
    </script>
    <script>
        var calculate = function() {
            var string = document.getElementById('short_description').value;
            var words = string.trim().split(/\s+/).filter(word => word.length > 0);
            var wordCount = words.length;

            if (wordCount > 100) {
                document.getElementById('short_description').value = words.slice(0, 100).join(' ');
                wordCount = 100;
            }

            document.getElementById('count').innerHTML = wordCount + " / 100 words";
        };

        // Add event listener to count words when the content changes
        document.getElementById('short_description').addEventListener('input', calculate);
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('input[name="cat_id[]"]');
            const submitBtn = document.getElementById('submitBtn');

            function toggleSubmitButton() {
                const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
                submitBtn.disabled = !anyChecked;
            }

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', toggleSubmitButton);
            });

            // Initial check on page load
            toggleSubmitButton();
        });
    </script>
@endpush
