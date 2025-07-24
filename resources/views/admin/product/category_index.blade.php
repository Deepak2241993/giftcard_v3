@extends('layouts.admin_layout')
@section('body')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="mb-0">Services Deals/Categories</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Services Deals/Categories
                        </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content-header">

        <div class="app-content">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->

                
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
                                <li> <a href="{{ route('clear.errors') }}"  class="btn btn-block btn-outline-danger">Clear Errors</a></li>
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
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0">Search Data</h4>
                        </div>
                        <div class="card-body">
                            <!-- Top Section with Buttons and Search Form -->
                           
                
                            <!-- Bulk Data Upload & Template Download Section -->
                            <div class="row">
                                <!-- Bulk Data Upload -->
                                <div class="col-md-4 mb-4">
                                    <div class="card shadow-sm p-3">
                                        
                                        <form action="{{ route('categories.import') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="file">Choose CSV File(for Upload Bulk Data)</label>
                                                <input type="file" accept=".csv" name="file" class="form-control" required>
                                            </div>
                                            <button type="submit" class="btn btn-outline-primary w-100">Import</button>
                                        </form>
                                    </div>
                                      <!-- Deals Template Download & Media Button -->
                                    
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="card shadow-sm p-3">
                                        <h5>Deals Template</h5>
                                        @if ($paginator->isEmpty())
                                            <a href="{{ url('/deals.csv') }}" class="btn btn-outline-info w-100" download="deals.csv">Download Template</a>
                                        @else
                                            <a href="{{ url('/admin/export-categories-with-full-data') }}" class="btn btn-outline-info w-100" download="deals.csv">Download Full Data</a>
                                        @endif
                                        <button type="button" class="btn btn-outline-primary w-100 mt-3" data-toggle="modal" data-target="#media_modal">Media</button>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <!-- Search Form -->
                                    <h5>Search</h5>
                                    <form method="GET" action="{{ route('category.index') }}" class="d-flex w-100">
                                        @csrf
                                        <input type="text" class="form-control" id="cat_name" name="cat_name" placeholder="Deals Name" aria-label="Deals Name">
                                        <input type="hidden" id="user_token" name="user_token" value="{{ Auth::user()->user_token }}">
                                        <button type="submit" class="btn btn-outline-success ml-2">Search</button>
                                    </form>
                                </div>
                
                              
                            </div>
                             <div class="row mb-4">
                                <div class="col-md-2">
                                    <!-- Add More Button -->
                                    <a href="{{ route('category.create') }}" class="btn btn-dark w-100">Add More</a>
                                </div>
                
                                
                            </div>
                        </div>
                    </div>
                </div>
                
                

                @if ($paginator->isEmpty())
                    <p>No categories found.</p>
                @else
                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Deals/Categories Name</th>
                                {{-- <th>Categories Image</th> --}}
                                <th>Short Description</th>
                                <th>Start</th>
                                <th>End</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paginator as $value)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $value['cat_name'] ?? 'NULL' }}
                                    </td>
                                    {{-- <td>
                                        @if (isset($value['cat_image']))
                                            <img src="{{ $value['cat_image'] }}" style="height:100px; width:100px;" onerror="this.onerror=null; this.src='{{url('/No_Image_Available.jpg')}}';">
                                        @else
                                            No Image
                                        @endif
                                    </td> --}}
                                    <td>{!! mb_strimwidth($value['cat_description'] ?? 'NULL', 0, 200, '...') !!}</td>
                                    <td>{{ isset($value['deal_start_date']) ? date('m-d-Y h:i:s', strtotime($value['deal_start_date'])) : 'No Date' }}
                                    <td>{{ isset($value['deal_end_date']) ? date('m-d-Y h:i:s', strtotime($value['deal_end_date'])) : 'No Date' }}
                                    </td>
                                    <td>{{ isset($value['created_at']) ? date('m-d-Y h:i:s', strtotime($value['created_at'])) : 'No Date' }}
                                    </td>
                                    <td>
                                        <a href="{{ route('category.edit', $value['id']) }}"
                                             class="btn btn-block btn-outline-primary">Edit</a>
                                        <form action="{{ route('category.destroy', $value['id']) }}" method="POST"
                                            style="display:inline;">
                                            @method('DELETE')
                                            @csrf
                                            <button  class="btn btn-block btn-outline-danger" type="submit">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody><br>
                        {{ $paginator->links() }}
                    </table>
                @endif

                <!-- Display pagination links -->
                {{ $paginator->links() }}


                <!--end::Row-->
                <!-- /.Start col -->
            </div>
            <!-- /.row (main row) -->
        </div>
        <!--end::Container-->
        </main>


        <!-- Modal -->
        <div class="modal fade deepak" id="staticBackdrop_" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                       <button type="button"  class="btn btn-block btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal for Media Upload --}}
        <!-- Progress Bar -->


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
                            <button type="submit"  class="btn btn-block btn-outline-success">Upload Images</button>
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
                                <div class="col-md-2 mb-4 image-container" data-image="{{ $image }}" style="position: relative;">
                                    <div class="border border-primary" style="height:100px;width:120px;margin-top: 30px; position:relative;">
                                        <img src="{{ url('/') }}{{ Storage::url($image) }}" class="img-fluid" alt="Image" style="height:100px;width:120px;" onerror="this.onerror=null; this.src='{{url('/No_Image_Available.jpg')}}';">
                                        <button type="button" class="rounded-circle btn-close delete-image text-danger" aria-label="Close" style="position: absolute; top: -23px; right: -24px; background: transparent; border: 1px; font-size: 20px;"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
                                        
                                        <!-- Copy URL Button -->
                                        <input type="button" class="form-control btn btn-outline-success mt-1 mb-2" id="copy_url_{{ $key }}" url_link="{{ url('/') }}{{ Storage::url($image) }}" value="Copy URL" onclick="Copy({{ $key }});" />
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
        <!-- For Multiple Image upload Code -->

<script>
            document.getElementById('uploadForm').addEventListener('submit', function (e) {
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
    xhr.upload.addEventListener('progress', function (e) {
        if (e.lengthComputable) {
            let percentComplete = Math.round((e.loaded / e.total) * 100);
            document.getElementById('progressBar').value = percentComplete;
            document.getElementById('progressPercentage').innerText = percentComplete + '%';
            document.getElementById('progressWrapper').style.display = 'block';
        }
    });

    // On upload complete
    xhr.onload = function () {
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
    xhr.onerror = function () {
        console.log("Error during upload.");
    };

    // Open the request and send the FormData
    xhr.open('POST', '{{ url('/admin/upload-multiple-images') }}', true);
    xhr.send(formData);
});

    </script>
{{--  For Image Delete  --}}
<script>
    $(document).ready(function() {
        // When the delete button is clicked
        $('.delete-image').on('click', function() {
            // Get the parent div that contains the image and image path
            var imageContainer = $(this).closest('.image-container');
            var image = imageContainer.data('image');

            // Send an AJAX request to delete the image
            $.ajax({
                url: '{{ url("/admin/delete-image")}}', // Your route to handle image deletion
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', // Include CSRF token
                    image: image
                },
                success: function(response) {
                    if (response.success) {
                        // Remove the image container on successful delete
                        imageContainer.remove();
                    } else {
                        alert('Error deleting image');
                    }
                },
                error: function() {
               
                    alert('Error deleting image');
                }
            });
        });
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
        $('#copy_url_'+getkey).val('Copied')
        // alert("URL copied to clipboard: " + url);
    }).catch(function(error) {
        console.error("Could not copy text: ", error);
    });
}    
</script>
    @endpush
    