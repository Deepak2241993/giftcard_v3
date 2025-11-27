@extends('layouts.admin_layout')
@section('body')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3 class="mb-0">Terms &amp; Condition</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Terms &amp; Condition Add/Update</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <!-- Alert -->
        @if (session()->has('error'))
            <div class="alert alert-danger">{{ session()->get('error') }}</div>
        @endif

        <!-- Card -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">{{ isset($term) ? 'Update Term' : 'Add Term' }}</h5>
            </div>

            <div class="card-body">
                @if (isset($term))
                    <form method="post" action="{{ route('terms.update', $term['id']) }}" enctype="multipart/form-data">
                        @method('PUT')
                @else
                    <form method="post" action="{{ route('terms.store') }}" enctype="multipart/form-data">
                @endif
                    @csrf

                    <div class="row">
                        <!-- Services (left) -->
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Select Service <span class="text-danger">*</span></label>
                            <div class="card card-sm">
                                <div class="card-body" style="max-height:220px; overflow:auto;">
                                    @if ($services && count($services))
                                        @foreach ($services as $value)
                                            @php $svcId = 'service_'.$value['id']; @endphp
                                            <div class="form-check">
                                                <input id="{{ $svcId }}" type="checkbox" class="form-check-input service-checkbox" name="service_id[]" value="{{ $value['id'] }}"
                                                    {{ isset($term['service_id']) && (is_array($term['service_id']) ? in_array($value['id'], $term['service_id']) : $term['service_id'] == $value['id']) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="{{ $svcId }}">{{ $value['product_name'] }}</label>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="text-muted">No Services Found</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Units (right) -->
                        <div class="mb-3 col-md-6">
    <label class="form-label">Select Units <span class="text-danger">*</span></label>

    <div class="card card-sm">
        <div id="unitContainer" class="card-body" style="max-height:220px; overflow:auto;">
            <div class="text-muted">Select a service first…</div>
        </div>
    </div>
</div>


                        <!-- Description -->
                        <div class="mb-3 col-12">
                            <label for="description" class="form-label">Short Description
                                {{-- <span class="text-danger"> (Text Limit 50 words)</span> --}}
                            </label>
                            <textarea name="description" id="description" class="form-control summernote" required>{{ old('description', isset($term) ? $term['description'] : '') }}</textarea>
                            <small id="count" class="form-text text-danger mt-1"></small>
                        </div>

                        <!-- Status -->
                        <div class="mb-3 col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" name="status" id="status">
                                <option value="1" {{ isset($term['status']) && $term['status'] == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ isset($term['status']) && $term['status'] == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <!-- Submit -->
                        <div class="mb-3 col-md-6 d-flex align-items-end">
                            <button class="btn btn-primary w-100" type="submit" id="submitBtn">Submit</button>
                        </div>
                    </div>
                </form>
            </div> <!-- card-body -->
        </div> <!-- card -->
    </div> <!-- container -->
</section>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        // Summernote - responsive: remove fixed width
        $('.summernote').summernote({
            height: 300,
            focus: true,
            fontSizes: ['8','9','10','11','12','14','18','22','24','36','48','64','82','150'],
            toolbar: [
                ['history', ['undo','redo']],
                ['style', ['bold','italic','underline','strikethrough']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul','ol','paragraph']],
                ['insert', ['picture','link']]
            ],
            popover: {
                image: [
                    ['custom', ['examplePlugin']],
                    ['imagesize', ['imageSize100','imageSize50','imageSize25']],
                    ['float', ['floatLeft','floatRight','floatNone']],
                    ['remove', ['removeMedia']]
                ]
            }
        });

        // const maxWords = 50;
        const $desc = $('#description');
        const $count = $('#count');
        const $submitBtn = $('#submitBtn');
        const $serviceCheckboxes = $('.service-checkbox');
        const $unitCheckboxes = $('.unit-checkbox');

        // function updateWordCount() {
        //     // get text from summernote if initialized
        //     let text = '';
        //     if ($desc.summernote) {
        //         text = $desc.summernote('isEmpty') ? '' : $desc.summernote('code').replace(/<\/?[^>]+(>|$)/g, " ");
        //     } else {
        //         text = $desc.val();
        //     }
        //     // normalize whitespace and count words
        //     text = text.replace(/\s+/g, ' ').trim();
        //     const words = text === '' ? 0 : text.split(' ').filter(Boolean).length;
        //     $count.text(words + ' / ' + maxWords + ' words');
        //     if (words > maxWords) {
        //         $count.addClass('text-danger');
        //     } else {
        //         $count.removeClass('text-danger');
        //     }
        //     validateSubmit();
        // }

        // Enable submit only if at least one service/unit checked AND word count <= max
        function anyChecked() {
            return $serviceCheckboxes.is(':checked') || $unitCheckboxes.is(':checked');
        }

        function validateSubmit() {
            // count
            let words = ($count.text().split('/')[0].trim()) || '0';
            words = parseInt(words);
            const withinLimit = !isNaN(words) ? words <= maxWords : true;
            $submitBtn.prop('disabled', !(anyChecked() && withinLimit));
        }

        // events
        // trigger every time the summernote content changes
        $desc.on('summernote.change', function(we, contents, $editable) {
            updateWordCount();
        });

        // also check on manual input (fallback)
        $desc.on('input', updateWordCount);

        $serviceCheckboxes.add($unitCheckboxes).on('change', validateSubmit);

        // initial checks on page load
        setTimeout(updateWordCount, 300); // small delay for summernote init
        validateSubmit();
    });
</script>

<script>
$(document).ready(function () {

    function loadUnits(preSelectedUnits = []) {
        let selectedServices = [];
        $(".service-checkbox:checked").each(function () {
            selectedServices.push($(this).val());
        });

        if (selectedServices.length === 0) {
            $("#unitContainer").html('<div class="text-muted">Select a service first…</div>');
            return;
        }

        $.ajax({
            url: "{{ route('get-units-by-service') }}",
            method: "POST",
            data: {
                service_ids: selectedServices,
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                let units = response.units;

                let html = "";
                units.forEach(function (unit) {
                    const checked = preSelectedUnits.includes(unit.id.toString()) ? "checked" : "";
                    html += `
                        <div class="form-check">
                            <input type="checkbox" ${checked}
                                   class="form-check-input unit-checkbox" 
                                   name="unit_id[]" 
                                   value="${unit.id}" />
                            <label class="form-check-label">${unit.product_name}</label>
                        </div>`;
                });

                $("#unitContainer").html(html);
            }
        });
    }

    // Auto-load units on EDIT page
    @if(isset($term))
        loadUnits(@json($term['unit_id']));
    @endif

    $(".service-checkbox").on("change", function() {
        loadUnits([]);
    });

});

</script>

@endpush
