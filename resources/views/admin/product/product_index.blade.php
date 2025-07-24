@extends('layouts.admin_layout')
@section('body')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="mb-0">Services List</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Services
                        </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content-header">

        <!--begin::App Content-->
        <div class="app-content">
            <!--begin::Container-->
            <div class="container-fluid">

                @if (session('success'))
                    <div class="alert alert-success mt-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger mt-4">
                        {{ session('error') }}
                        @if (session('details'))
                            <pre>{{ session('details') }}</pre>
                        @endif
                    </div>
                @endif
                @if (session('import_errors') && count(session('import_errors')) > 0)
                    <div class="alert alert-danger mt-4">
                        <h4>There were some errors while importing the data:</h4>

                        <ul>
                            @foreach (session('import_errors') as $errorDetail)
                                <li>
                                    <strong>Row:</strong>
                                    <pre>{{ print_r($errorDetail['row'], true) }}</pre>
                                    <strong>Errors:</strong>
                                    <ul>
                                        @foreach ($errorDetail['errors'] as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li> <a href="{{ route('clear.errors') }}" class="btn btn-block btn-outline-danger">Clear
                                        Errors</a></li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                
                
              
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Upload and Download</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Upload Bulk Service Data -->
                            <div class="col-md-6 mb-4">
                                <form action="{{ route('services.import') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="file" class="form-label">Upload Bulk Service Data</label>
                                        <input type="file" name="file" class="form-control" accept=".csv" required>
                                    </div>
                                    <button type="submit" class="btn btn-outline-primary w-100">Import</button>
                                </form>
                            </div>
                
                            <!-- Downloads Section -->
                            <div class="col-md-6 mb-4">
                                <div class="d-flex flex-column">
                                    @if (collect($products)->isEmpty())
                                        <a href="{{ url('/services.csv') }}" class="btn btn-outline-info mb-2" download="services.csv">
                                            Download Service Template
                                        </a>
                                    @else
                                        <a href="{{ url('/admin/export-services') }}" class="btn btn-outline-info mb-2" download="services.csv">
                                            Download Service Template
                                        </a>
                                    @endif
                                    <a href="{{ url('/admin/export-categories') }}" class="btn btn-outline-warning mb-2" download="deals.csv">
                                        Download Deals Data
                                    </a>
                                    <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#media_modal">
                                        Media
                                    </button>
                                    
                                        <a href="{{ route('product.create') }}" class="btn btn-outline-dark mb-2 mt-2">Add More</a>
                                  
                                </div>
                            </div>
                        </div>               
                        
                    </div>
                </div>
                

                <table id="datatable-buttons" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#">#</th>
                        <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Buy">Buy</th>
                        <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Product Name">Product Name</th>
                        <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Image">Image</th>
                        <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Actual Price">Actual Price</th>
                        <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Deal Price">Deal Price</th>
                        <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Product Description">Product Description</th>
                        <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Type">Type</th>
                        <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Action">Action</th>

                    </tr>
                </thead>
                <tbody id="data-table-body">
                    @foreach ($products as $value)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if(isset($id))
                                <a class="btn btn-block btn-outline-primary" onclick="addcart({{ $value['id'] }}, {{ $id }})">Buy</a>
                                @else
                                <a class="btn btn-block btn-outline-primary" onclick="addcart({{ $value['id'] }})">Buy</a>
                                @endif
                            </td>
                            <td>{{ $value['product_name'] ? $value['product_name'] : 'NULL' }}
                            </td>
                            <td>
                                @php
                                    $image = explode('|', $value['product_image']);
                                @endphp
                                {{-- @foreach ($image as $imagevalue)
                                            <img src="{{ $imagevalue }}" style="height:30px; width:30px;"> |
                    @endforeach --}}
                                <img src="{{ $image[0] }}" style="height:100px; width:100px;"
                                    onerror="this.onerror=null; this.src='{{ url('/No_Image_Available.jpg') }}';">
                            </td>
                            <td>{{ $value['amount'] }}</td>
                            <td>{{ $value['discounted_amount'] }}</td>
                            <td>{!! mb_strimwidth(
                                htmlspecialchars(isset($value['short_description']) ? $value['short_description'] : 'NULL'),
                                0,
                                100,
                                '...',
                            ) !!}</td>




                            <td>{{ $value['unit_id'] != null ? 'Unit Service' : 'Normal Deals & Service' }}
                            </td>
                            <td class="text-center">
                            <a href="{{ route('product.edit', $value['id']) }}"
                            class="btn btn-sm btn-outline-primary me-1"
                            title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>

                            <form action="{{ route('product.destroy', $value['id']) }}" method="POST" class="d-inline">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-sm btn-outline-danger"
                                        type="submit"
                                        title="Delete"
                                        onclick="return confirm('Are you sure you want to delete this product?')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>



                            <!-- Button trigger modal -->




                        </tr>
                    @endforeach
                </tbody>
                {{-- {{ $paginator->links() }} --}}
            </table>
            {{-- {{ $paginator->links() }} --}}
            <!--end::Row-->
            <!-- /.Start col -->
        </div>
        <!-- /.row (main row) -->
        </div>
        <!--end::Container-->
    </section>


    <!-- Modal -->
    <div class="modal fade deepak" id="staticBackdrop_" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Gift Card Number</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h2 id="giftcardsshow"></h2>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-block btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal for Media Upload --}}

    <!-- Modal -->
    <div class="modal fade" id="media_modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="media_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="media_modalLabel">Media Upload</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="validationErrors"></div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form id="uploadForm" enctype="multipart/form-data"
                        style="display: flex; align-items: center; gap: 10px;">
                        <input type="file" class="form-control" name="images[]" id="images" multiple
                            style="width: auto;" required accept="image/jpg, image/jpeg, image/png" />
                        <button type="submit" class="btn btn-block btn-outline-success">Upload Images</button>
                    </form>
                    <!-- Display Uploaded Images -->
                    <div id="progressWrapper" style="display: none; margin-top: 10px;">
                        <progress id="progressBar" value="0" max="100"></progress>
                        <span id="progressPercentage">0%</span>
                    </div>
                    <div id="uploadedImages"></div>
                    <!-- Display Uploaded Images -->
                </div>
                <div class="modal-footer">
                    {{-- <button  class="btn btn-block btn-outline-warning" onclick="window.location.reload();">Refresh</button> --}}
                    <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                        <div class="row">
                            @foreach ($images as $key => $image)
                                <div class="col-md-2 mb-4 image-container" data-image="{{ $image }}"
                                    style="position: relative;">
                                    <div class="border border-primary"
                                        style="height:100px;width:120px;margin-top: 30px; position:relative;">
                                        <img src="{{ url('/') }}{{ Storage::url($image) }}" class="img-fluid"
                                            alt="Image" style="height:100px;width:120px;"
                                            onerror="this.onerror=null; this.src='{{ url('/No_Image_Available.jpg') }}';">
                                        <button type="button" class="rounded-circle btn-close delete-image text-danger"
                                            aria-label="Close"
                                            style="position: absolute; top: -23px; right: -24px; background: transparent; border: 1px; font-size: 20px;"><i
                                                class="fa fa-times-circle" aria-hidden="true"></i></button>

                                        <!-- Copy URL Button -->
                                        <input type="button" class="form-control btn btn-outline-success mt-1 mb-2"
                                            id="copy_url_{{ $key }}"
                                            url_link="{{ url('/') }}{{ Storage::url($image) }}" value="Copy URL"
                                            onclick="Copy({{ $key }});" />
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Media Code End --}}
@endsection

@push('script')
    <script>
        function cardview(id, tid) {
            $('.deepak').attr('id', 'staticBackdrop_' + id);
            $('#staticBackdrop_' + id).modal('show');

            $.ajax({
                url: '{{ route('cardview-route') }}',
                method: "post",
                dataType: "json",
                data: {
                    _token: '{{ csrf_token() }}',
                    tid: tid,
                    user_token: '{{ Auth::user()->user_token }}',
                },
                success: function(response) {
                    if (response.success) {
                        $('#giftcardsshow').empty();
                        $.each(response.result, function(index, element) {
                            // Create a new element with the giftnumber
                            var newElement = $('<div>').html(element.giftnumber);

                            // Append the new element to #giftcardsshow
                            $('#giftcardsshow').append(newElement);
                        });

                    }
                }
            });
        }
    </script>
    <script>
        function addcart(id,patient_id) {
            $.ajax({
                url: '{{ route('cart') }}',
                method: "post",
                dataType: "json",
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: id,
                    patient_id: patient_id,
                    quantity: 1,
                    type: "product"
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        $('.showbalance').html(response.error).show();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Handle the error here
                    $('.showbalance').html('An error occurred. Please try again.').show();
                }
            });
        }
    </script>

    <!-- For Multiple Image upload Code -->
    <script>
        document.getElementById('uploadForm').addEventListener('submit', function(e) {
            e.preventDefault();

            let formData = new FormData();
            let files = document.getElementById('images').files;

            // Append all images to FormData
            for (let i = 0; i < files.length; i++) {
                formData.append('images[]', files[i]);
            }

            // Append the CSRF token to FormData
            formData.append('_token', '{{ csrf_token() }}');

            let xhr = new XMLHttpRequest();

            // Update progress
            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    let percentComplete = Math.round((e.loaded / e.total) * 100);
                    document.getElementById('progressBar').value = percentComplete;
                    document.getElementById('progressPercentage').innerText = percentComplete + '%';
                    document.getElementById('progressWrapper').style.display = 'block';
                }
            });

            // On upload complete
            xhr.onload = function() {
                document.getElementById('progressWrapper').style.display = 'none';

                if (xhr.status === 200) {
                    let response = JSON.parse(xhr.responseText);

                    // Clear previous errors and images
                    document.getElementById('validationErrors').innerHTML = '';
                    document.getElementById('uploadedImages').innerHTML = '';

                    // Show successfully uploaded images
                    if (response.files.length > 0) {
                        let uploadedImagesDiv = document.getElementById('uploadedImages');
                        response.files.forEach(file => {
                            let img = document.createElement('img');
                            img.src = '{{ url('/') }}' + file;
                            img.style.width = '100px';
                            img.style.margin = '5px';
                            uploadedImagesDiv.appendChild(img);
                        });
                    }

                    // Show validation errors
                    if (response.errors.length > 0) {
                        let errorDiv = document.getElementById('validationErrors');
                        response.errors.forEach(error => {
                            let errorItem = document.createElement('div');
                            errorItem.className = 'alert alert-danger';
                            errorItem.innerText = error;
                            errorDiv.appendChild(errorItem);
                        });
                    }
                } else {
                    console.log("Error during upload.");
                }
            };

            // Error handling
            xhr.onerror = function() {
                console.log("Error during upload.");
            };

            // Open the request and send the FormData
            xhr.open('POST', '{{ url('/admin/upload-multiple-images') }}', true);
            xhr.send(formData);
        });
    </script>
    <script>
        function Copy(getkey) {
            // Get the button element using its unique id
            var copyButton = document.getElementById("copy_url_" + getkey);

            // Get the URL from the 'url_link' attribute
            var url = copyButton.getAttribute("url_link");

            // Use the modern clipboard API to copy the URL
            navigator.clipboard.writeText(url).then(function() {
                $('#copy_url_' + getkey).val('Copied')
                // alert("URL copied to clipboard: " + url);
            }).catch(function(error) {
                console.error("Could not copy text: ", error);
            });
        }
//  For Seacrh Function 
function SearchView() {
    var service_name = $('#service_name').val();
    $.ajax({
        url: '{{ route('service-search') }}', // API endpoint
        method: "GET",
        dataType: "json",
        data: {
            service_name: service_name,
        },
        success: function (response) {
            if (response.status === 'success' && response.data.data.length > 0) {
                var tableBody = $('#data-table-body'); // ID of your table body
                tableBody.empty(); // Clear existing rows

                // Loop through the response data and populate the table
                $.each(response.data.data, function (key, value) {
                    // Format date
                    var updatedDate = value.updated_at
                        ? new Date(value.updated_at).toLocaleString('en-US', {
                              month: '2-digit',
                              day: '2-digit',
                              year: 'numeric',
                              hour: '2-digit',
                              minute: '2-digit',
                              second: '2-digit',
                          })
                        : 'N/A';

                    // Handle product images dynamically
                    var productImages = value.product_image ? value.product_image.split('|') : [];
                    var firstImage = productImages.length > 0 ? productImages[0] : '{{ url("/No_Image_Available.jpg") }}';

                    // Append rows
                    tableBody.append(`
                        <tr>
                            <td>${key + 1}</td>
                            <td><a class="btn btn-block btn-outline-primary" onclick="addcart(${value.id})">Buy</a></td>
                            <td>${value.product_name || 'N/A'}</td>
                            <td>
                                <img src="${firstImage}" style="height:100px; width:100px;"
                                    onerror="this.onerror=null; this.src='{{ url('/No_Image_Available.jpg') }}';">
                            </td>
                            <td>${value.amount || '0.00'}</td>
                            <td>${value.discounted_amount || '0.00'}</td>
                            <td>${value.short_description ? value.short_description.substring(0, 100) + '...' : 'N/A'}</td>
                            <td>${value.unit_id !== null ? 'Unit Service' : 'Normal Deals & Service'}</td>
                            <td>
                                <a href="{{url('/')}}/admin/product/${value.id}/edit" class="btn btn-block btn-outline-primary">Edit</a>
                                <form action="{{url('/')}}/admin/product/${value.id}" method="POST" style="display:inline;">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-block btn-outline-danger" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    `);
                });
            } else {
                // Handle empty results
                $('#data-table-body').empty().append('<tr><td colspan="9">No results found.</td></tr>');
            }
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
            alert('An error occurred while fetching data.');
        },
    });
}



    </script>
{{-- For Data Table --}}
<script>
    $(function () {
      $("#datatable-buttons").DataTable({
        "responsive": true, "lengthChange": true, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>
@endpush
