@extends('layouts.admin_layout')
@section('body')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="mb-0">Service Unit</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Service Unit
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
                

                @if (session('message'))
                    <div class="alert alert-success mt-4">
                        {{ session('message') }}
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
                <table id="datatable-buttons" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#">#</th>
                            <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Unit Name">Unit Name</th>
                            <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Orignal Price">Orignal Price</th>
                            <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Discounted Price">Discounted Price</th>
                            <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Status">Status</th>
                            <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Action">Action</th>

                        </tr>
                    </thead>
                    <tbody id="data-table-body">
                        @foreach ($result as $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ $value->product_name ? $value->product_name: 'N/A' }}
                                </td>
                                <td>{{ $value->amount }}</td>
                                <td>{{ $value->discounted_amount }}</td>
                                <td>{{ $value->status == 1 ?  "Active":"Inactive" }}</td>
                                
                                <td>
                                    <a href="{{ route('unit.edit', $value['id']) }}"  class="btn btn-block btn-outline-primary">Edit</a>
                                    <a href="{{ route('unitdelete', $value['id']) }}"  class="btn btn-block btn-outline-danger">Delete</a>
                                    <a class="btn btn-block btn-outline-primary" onclick="addcart({{ $value['id'] }})">Buy</a>
                                  
                                </td>


                                <!-- Button trigger modal -->




                            </tr>
                        @endforeach
                    </tbody>
                    
                </table>
                {{-- {{ $result->links() }} --}}
                <!--end::Row-->
                <!-- /.Start col -->
            </div>
            <!-- /.row (main row) -->
        </div>
        <!--end::Container-->
    </section>

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
        function addcart(id) {
            $.ajax({
                url: '{{ route('cart') }}',
                method: "post",
                dataType: "json",
                data: {
                    _token: '{{ csrf_token() }}',
                    unit_id: id,
                    type: "unit"
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
        function SearchView() {
    var service_name = $('#service_name').val();
    $.ajax({
        url: '{{ route('unit-search') }}', // API endpoint
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
                            <td>${value.amount || '0.00'}</td>
                            <td>${value.discounted_amount || '0.00'}</td>
                            <td>${value.short_description ? value.short_description.substring(0, 100) + '...' : 'N/A'}</td>
                            <td>${value.unit_id !== null ? 'Unit Service' : 'Normal Deals & Service'}</td>
                            <td>
                                <a href="/product/${value.id}/edit" class="btn btn-block btn-outline-primary">Edit</a>
                                <form action="/product/${value.id}" method="POST" style="display:inline;">
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
