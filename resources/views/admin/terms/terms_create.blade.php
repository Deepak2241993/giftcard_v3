@extends('layouts.admin_layout')
@section('body')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="mb-0">Terms & Condition</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Terms & Condition Add/Update
                        </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content-header">
        <!--begin::App Content-->
        <div class="app-content">
            <span class="text-danger">
                @if (session()->has('error'))
                    {{ session()->get('error') }}
                @endif
            </span>
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="card-body p-4">
                    @if (isset($term))
                        <form method="post" action="{{ route('terms.update', $term['id']) }}"
                            enctype="multipart/form-data">
                            @method('PUT')
                        @else
                            <form method="post" action="{{ route('terms.store') }}" enctype="multipart/form-data">
                    @endif
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-lg-6 self">
                            <label class="form-label">Select Service <span class="text-danger">*</span></label>
                            @if ($services)
                                @foreach ($services as $value)
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="service_id[]"
                                            value="{{ $value['id'] }}"
                                            {{ isset($term['service_id']) && (is_array($term['service_id']) ? in_array($value['id'], $term['service_id']) : $term['service_id'] == $value['id']) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="cat_{{ $value['id'] }}">
                                            {{ $value['product_name'] }}
                                        </label>
                                    </div>
                                @endforeach
                            @else
                                <div>No Services Found</div>
                            @endif
                        </div>
                        <div class="mb-3 col-lg-6 self">
                            <label class="form-label">Select Units <span class="text-danger">*</span></label>
                            @if ($units)
                                @foreach ($units as $value)
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="unit_id[]"
                                            value="{{ $value['id'] }}"
                                            {{ isset($term['unit_id']) && (is_array($term['unit_id']) ? in_array($value['id'], $term['unit_id']) : $term['unit_id'] == $value['id']) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="cat_{{ $value['id'] }}">
                                            {{ $value['product_name'] }}
                                        </label>
                                    </div>
                                @endforeach
                            @else
                                <div>No Units Found</div>
                            @endif
                        </div>
                        <div class="mb-12 col-lg-12 self">
                            <label for="description" class="form-label">Short Description
                                <span class="text-danger"> (Text Limit 50 Word)</span>
                            </label>
                            <textarea name="description" id="description" class="form-control summernote" required>{{ isset($term) ? $term['description'] : '' }}</textarea>
                            <span id="count" class="text-danger"></span>
                        </div>
                        <div class="mb-3 col-lg-6">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" name="status" id='status'>
                                <option
                                    value="1"{{ isset($terms->status) && $terms->status == 1 ? 'selected' : '' }}>
                                    Active</option>
                                <option
                                    value="0"{{ isset($terms->status) && $terms->status == 0 ? 'selected' : '' }}>
                                    Inactive</option>
                            </select>
                        </div>
                        <div class="mb-3 col-lg-6 mt-4">
                            <button  class="btn btn-block btn-outline-primary" type="submit" id="submitBtn">Submit</button>
                        </div>
                    </div>
                    </form>
                </div>
                <!--end::Row-->
    </section>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 300, // Set height of the editor
            width: 860, // Set width of the editor
            focus: true, // Focus the editor on load
            fontSizes: ['8', '9', '10', '11', '12', '14', '18', '22', '24', '36', '48', '64', '82', '150'], // Font sizes
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


    
    
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('input[name="service_id[]"]');
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
    </script> --}}
@endpush
