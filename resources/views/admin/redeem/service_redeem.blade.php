@extends('layouts.admin_layout')
@section('body')
    @push('css')
    <style>
        .spinner-border {
        display: inline-block;
        width: 1rem;
        height: 1rem;
        vertical-align: text-bottom;
        border: 0.1em solid currentColor;
        border-right-color: transparent;
        border-radius: 50%;
        animation: spinner-border 0.75s linear infinite;
        }

        @keyframesspinner-border {
        100% {
        transform: rotate(360deg);
        }
        }
    </style>
    @endpush()
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="mb-0">Service Redeem</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Orders</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Service Redeem
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
                
                <!--begin::Row-->
                {{-- {{ $data->onEachSide(5)->links() }} --}}
                <table id="datatable-buttons" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#">#</th>
                            <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="View Order">View Order</th>
                            <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Order Number">Order Number</th>
                            <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Full Name">Full Name</th>
                            <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Email">Email</th>
                            <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Phone">Phone</th>
                            <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Transaction Amount">Transaction Amount</th>
                            <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Transaction Id">Transaction Id</th>
                            <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Created Date & Time">Created Date & Time</th>

                        </tr>
                    </thead>


                    <tbody id="data-table-body">
                        @foreach ($data as $key => $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                @if(!empty($value->payment_intent))
                                <td class="text-center">
    <a type="button" 
       class="btn btn-sm btn-outline-success me-1" 
       data-bs-toggle="modal"
       data-bs-target="#staticBackdrop_{{ $value['id'] }}"
       onclick="OrderView({{ $key }}, '{{ $value['order_id'] }}')"
       title="Redeem Service">
        <i class="fa fa-check-circle"></i>
    </a>

    <a type="button" 
       class="btn btn-sm btn-outline-danger me-1" 
       data-bs-toggle="modal"
       data-bs-target="#staticBackdrop_{{ $value['id'] }}"
       onclick="CancelView({{ $key }}, '{{ $value['order_id'] }}')"
       title="Cancel Order">
        <i class="fa fa-times-circle"></i>
    </a>

    <a type="button" 
       class="btn btn-sm btn-outline-warning" 
       data-bs-toggle="modal" 
       data-bs-target="#statement_view_{{ $value['id'] }}"
       onclick="StatementView({{ $key }}, '{{ $value['order_id'] }}')"
       title="View Statement">
        <i class="fa fa-file-text"></i>
    </a>
</td>

                                @else
                                <td> <span class="badge bg-danger">No Payment</span></td>
                                @endif
                                <td>{{ $value->order_id }}</td>
                                <td>{{ $value->fname . ' ' . $value->lname }}</td>
                                <td>{{ $value->email }}</td>
                                <td>{{ $value->phone }}</td>
                                <td>{{ $value->final_amount }}</td>
                                <td>{{ $value->payment_intent }}</td>
                                <td>{{ date('m-d-Y h:i:m', strtotime($value->updated_at)) }}
                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
                {{-- {{ $data->onEachSide(5)->links() }} --}}
                <!--end::Row-->
                <!-- /.Start col -->
            </div>
            <!-- /.row (main row) -->
        </div>
        <!--end::Container-->
    </section>

    <!-- for Show Service Order Modal -->
    <div class="modal fade deepak" id="staticBackdrop_" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">All Services </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div style="display: flex; flex-direction: column;">
                        <h3> Order Details</h3>
                        <h4 class="text-success" id="redeemed_success"></h4>
                        <h4 class="text-danger" id="redeemed_error"></h4>
                        <span class="text-danger" id="error"></span>
                        <span class="text-success" id="success"></span>
                        <h2 id="giftcardsshow" class="mt-4"></h2>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-block btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- For Statment View Modal --}}
    <div class="modal fade statement" id="statement_view_" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Service Redeem Statement</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div style="display: flex; flex-direction: column;">
                        <!-- Existing placeholders for other data -->
                        <!-- Dynamic content area for table -->
                        <div id="dynamicContent"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-block btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Statement View Modal End --}}

    {{-- Service Order Cancel Modal --}}
    <div class="modal fade cancel" id="cancel_view_" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel_cancel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel_cancel">All Services </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div style="display: flex; flex-direction: column;">

                        <h3>Order Cancel</h3>
                        <span class="text-danger" id="error"></span>
                        <span class="text-success" id="success"></span>
                        <h2 id="cancelorder" class="mt-4"></h2>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-block btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Service Order Cancel Modal End --}}
@endsection
@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function StatementView(id, order_id) {
            $('.statement').attr('id', 'statement_view_' + id);
            $('#statement_view_' + id).modal('show');

            // AJAX request to fetch data
            $.ajax({
                url: '{{ route('service-statement') }}',
                method: "post",
                dataType: "json",
                data: {
                    _token: '{{ csrf_token() }}',
                    order_id: order_id
                },
                success: function(response) {
                    if (response.success) {
                        var servicePurchases = response.servicePurchases;
                        var serviceRedeem = response.serviceRedeem;

                        var tableHTML = `
                <table cellpadding="0" cellspacing="0" style="font-family:Open Sans,-apple-system,BlinkMacSystemFont,Roboto,Helvetica Neue,Helvetica,Arial,sans-serif;border-collapse:collapse;width:100%; background-color: #f9f9f9; margin: 20px 0;">
                    <tbody>
                        <tr>
                            <td class="content" align="center" style="padding:40px 48px; background-color: #fca52a; color: #ffffff;">
                                <h1 style="font-weight:300;font-size:28px;line-height:130%;margin:16px 0; text-align:center;">Service Redeem Statement</h1>
                            </td>
                        </tr>
                        <tr>
                            <td class="content" style="padding:40px 48px; background-color: #ffffff;">
                                
                                <table border="1" cellspacing="0" cellpadding="10" style="font-family:Open Sans,-apple-system,BlinkMacSystemFont,Roboto,Helvetica Neue,Helvetica,Arial,sans-serif;border-collapse:collapse;width:100%; border: 1px solid #ddd; margin-top: 20px;">
                                    <tr style="background-color: #fca52a; color: white;">
                                        <th style="padding: 10px; text-align: left;">Transaction Date</th>
                                        <th style="padding: 10px; text-align: left;">Transaction Number</th>
                                        <th style="padding: 10px; text-align: left;">Service Name</th>
                                        <th style="padding: 10px; text-align: left;">Message</th>
                                        <th style="padding: 10px; text-align: left;">Service Session</th>

                                        <th style="padding: 10px; text-align: left;">Service Session Redeem</th>
                                    </tr>`;

                        // Loop through each purchase to show credits
                        $.each(servicePurchases, function(index, item) {
                            tableHTML += `
                    <tr style="background-color: #f2f2f2;">
                        <td style="padding: 10px;">${new Date(item.updated_at).toLocaleDateString()}</td>
                        <td style="padding: 10px;">${item.order_id}</td>
                      <td style="padding: 10px;">
                        ${item.service_type === 'product' ? item.product_name : ''}
                        ${item.service_type === 'unit' ? item.unit_name : ''}
</td>
                        <td style="padding: 10px;">Buy</td>
                        <td style="padding: 10px;">${item.number_of_session ? item.number_of_session : 'NULL'}</td>
                        <td style="padding: 10px;">--</td>
                    </tr>`;
                        });

                        // Loop through each redemption to show debits
                        $.each(serviceRedeem, function(index, value) {
                            tableHTML += `
                    <tr>
                        <td style="padding: 10px;">${new Date(value.updated_at).toLocaleDateString()}</td>
                        <td style="padding: 10px;">${value.transaction_id}</td>

                        <td style="padding: 10px;">
                        ${value.service_type === 'product' ? value.product_name : ''}
                        ${value.service_type === 'unit' ? value.unit_name : ''}
                            </td>
                        <td style="padding: 10px;">${value.comments ? value.comments : ''}</td>
                        <td style="padding: 10px;">--</td>
                        <td style="padding: 10px;">${value.number_of_session_use}</td>
                    </tr>`;
                        });

                        tableHTML += `</table>
                                
                            </td>
                        </tr>
                    </tbody>
                </table>`;

                        // Append the table HTML to the modal body
                        $('#statement_view_' + id + ' .modal-body').html(tableHTML);
                    } else {
                        // Handle case when response is not successful
                        $('#statement_view_' + id + ' .modal-body').html('<p>No statement found.</p>');
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    $('#statement_view_' + id + ' .modal-body').html(
                        '<p>An error occurred. Please try again later.</p>');
                }
            });
        }


        // Do Cancel Service ******************************************
        function CancelView(id, order_id) {
            $('.cancel').attr('id', 'cancel_view_' + id);
            $('#cancel_view_' + id).modal('show');
            $.ajax({
                url: '{{ route('order-search') }}',
                method: "post",
                dataType: "json",
                data: {
                    _token: '{{ csrf_token() }}',
                    order_id: order_id,
                    email: "",
                    phone: "",
                    user_token: '{{ Auth::user()->user_token }}',
                },
                success: function(response) {
                    if (response.success) {
                        // Clear previous table content
                        $('#cancelorder').empty();

                        // Create form and table structure
                        var form = $('<form>', {
                            action: '{{ route('do-cancel') }}',
                            method: 'POST'
                        });
                        var table = $('<table class="table table-bordered table-striped">');
                        var thead = $('<thead>').html(
                            '<tr>' +
                            '<th>#</th>' +
                            '<th>Product Name</th>' +
                            '<th>Total Session</th>' +
                            '<th>Remaining Session</th>' +
                            '<th>Session Usage</th>' +
                            '<th>Refund Amount</th>' +
                            '<th>Remarks</th>' +
                            '<th>Action</th>' +
                            '</tr>'
                        );
                        var tbody = $('<tbody>');

                        // Append header to the table
                        table.append(thead);

                        // Loop through the response result array
                        $.each(response.result, function(index, element) {
                            // Determine if the row should be disabled
                            var isDisabled = element.remaining_sessions === 0 ? 'disabled' : '';
                            var rowClass = element.remaining_sessions === 0 ?
                                'class="disabled-row"' : '';

                            // Create a new row for each element
                            var row = $('<tr ' + rowClass + '>').html(
                                `<td>${index + 1}</td>
                        <td>
                            ${element.service_type === 'product' ? element.product_name : ''}
                            ${element.service_type === 'unit' ? element.unit_name : ''}
                            </td>
                        <td>${element.number_of_session}</td>
                        <td id="row_${index + 1}">${element.remaining_sessions}</td>
                        <td>
                            <input type="hidden" name="refund_amount" value="${element.refund_amount > 0 ? element.refund_amount : 0}">
                            <input type="hidden" name="product_id" value="${element.service_id}">
                            <input type="hidden" name="service_type" value="${element.service_type}">
                            <input type="hidden" name="service_order_id" value="${element.service_order_id}">
                            <input type="hidden" name="patient_login_id" value="${element.patient_login_id}">
                         
                            <input type="hidden" name="order_id" value="${element.order_id}">
                            <input  onkeyup="valueValidate(this, ${element.remaining_sessions})" 
                                   onchange="valueValidate(this, ${element.remaining_sessions})" 
                                   type="hidden" 
                                   max="${element.remaining_sessions}" 
                                   min="0" 
                                   name="number_of_session_use" 
                                   value="${element.remaining_sessions}" 
                                   class="form-control" 
                                   ${isDisabled}>${element.remaining_sessions}
                        </td>
                         <td>
                           $${(element.refund_amount > 0 ? element.refund_amount : 0).toFixed(2)}


                        </td>
                        <td>
                            <textarea class="form-control" name="comments" ${isDisabled}></textarea>
                        </td>
                        <td>
                            <button type="button"  class="btn btn-block btn-outline-danger mt-2 submit-btn" ${isDisabled}>
                                <span class="spinner-border spinner-border-sm" style="display: none;"></span>
                                Do Cancel
                            </button>
                        </td>`

                            );

                            // Append the row to the tbody
                            tbody.append(row);
                        });

                        // Append tbody to the table
                        table.append(tbody);

                        // Append table to form
                        form.append(table);

                        // Append form to #cancelorder
                        $('#cancelorder').append(form);

                        // Add event listener for submit button clicks
                        $('.submit-btn').click(function() {
                            var button = $(this);
                            var spinner = button.find('.spinner-border');

                            // Show the spinner
                            spinner.show();
                            button.prop('disabled', true);

                            var currentRow = button.closest('tr');
                            var number_of_session_use = currentRow.find(
                                'input[name="number_of_session_use"]').val();
                            var remaining_sessions = currentRow.find('td:nth-child(4)')
                                .text(); // get remaining sessions value from table cell

                            // Validate that the number of sessions to use does not exceed remaining sessions
                            if (parseInt(number_of_session_use) > parseInt(
                                    remaining_sessions)) {
                                alert(
                                    'You cannot redeem more sessions than the remaining sessions.');
                                spinner.hide();
                                button.prop('disabled', false);
                                return; // Stop the form submission
                            }

                            var rowData = {
                                _token: '{{ csrf_token() }}', // Add CSRF token
                                product_id: currentRow.find('input[name="product_id"]')
                                    .val(),
                                service_order_id: currentRow.find('input[name="service_order_id"]')
                                    .val(),
                                service_type: currentRow.find('input[name="service_type"]')
                                    .val(),
                                refund_amount: currentRow.find(
                                    'input[name="refund_amount"]').val(),
                                order_id: currentRow.find('input[name="order_id"]').val(),
                                number_of_session_use: number_of_session_use,
                                comments: currentRow.find('textarea[name="comments"]').val(),
                                patient_login_id: currentRow.find(
                                    'input[name="patient_login_id"]').val(),
                            };

                            $.ajax({
                                url: form.attr('action'),
                                method: form.attr('method'),
                                data: rowData, // Send only the current row data
                                success: function(response) {
                                    if (response.success) {
                                        // Display a success message
                                        alert('Action completed successfully.');
                                        $('#success').html();
                                        // Disable the current row's input fields and button
                                        currentRow.find('input, textarea, button')
                                            .prop('disabled', true);
                                    } else {
                                        alert('Action failed. Please try again.');
                                    }
                                },
                                error: function(xhr, status, error) {
                                    alert(
                                        'An error occurred. Please try again later.');
                                },
                                complete: function() {
                                    // Hide the spinner and enable the button after the request completes
                                    spinner.hide();
                                    button.prop('disabled', true);
                                }
                            });
                        });

                    } else {
                        // Handle the case when the response is not successful
                        $('#cancel_order').html('<p>No services found.</p>');
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    $('#cancel_order').html('<p>An error occurred. Please try again later.</p>');
                }
            });
        }






        //  Order Cancel Code End ***********************************************************************


        //  For Order View Code Start ********************************************************************
        function OrderView(id, order_id) {
            $('#redeemed_error').html('');
            $('#redeemed_success').html('');
            $('.deepak').attr('id', 'staticBackdrop_' + id);
            $('#staticBackdrop_' + id).modal('show');

            $.ajax({
                url: '{{ route('redeemcalculation') }}',
                method: "post",
                dataType: "json",
                data: {
                    _token: '{{ csrf_token() }}',
                    order_id: order_id,
                    user_token: '{{ Auth::user()->user_token }}',
                },
                success: function(response) {
                    if (response.success) {
                        var servicePurchases = response.servicePurchases;
                        $('#giftcardsshow').empty();

                        var form = $('<form>', {
                            action: '{{ route('redeem-services') }}',
                            method: 'POST'
                        });

                        var table = $('<table class="table table-bordered table-striped">');
                        var thead = $('<thead>').html(
                            '<tr>' +
                            '<th>#</th>' +
                            '<th>Service Name</th>' +
                            '<th>Total Sessions</th>' +
                            '<th>Remaining Sessions</th>' +
                            '<th>Session Usage</th>' +
                            '<th>Message</th>' +
                            '<th>Action</th>' +
                            '</tr>'
                        );
                        table.append(thead);
                        var tbody = $('<tbody>');

                        $.each(servicePurchases, function(index, element) {
                            var isDisabled = element.remaining_sessions === 0 ? 'disabled' : '';
                            var rowClass = element.remaining_sessions === 0 ? 'class="disabled-row"' :
                                '';

                            var row = $('<tr ' + rowClass + '>').html(
                                `<td>${index + 1}</td>
                        <td>
                            ${element.service_type === 'product' ? element.product_name : ''}
                            ${element.service_type === 'unit' ? element.unit_name : ''}
                        </td>
                        <td>${element.number_of_session || 0}</td>
                        <td id="row_${index + 1}">${element.remaining_sessions || 0}</td>
                        <td>
                            <input type="hidden" name="service_id[]" value="${element.service_id}">
                            <input type="hidden" name="order_id[]" value="${element.order_id}">
                            <input type="hidden" name="service_type[]" value="${element.service_type}">
                            <input type="hidden" name="service_order_id[]" value="${element.id}">
                            <input type="hidden" name="patient_login_id[]" value="${element.patient_login_id}">
                            <input onkeyup="valueValidate(this, ${element.remaining_sessions})" 
                                   onchange="valueValidate(this, ${element.remaining_sessions})" 
                                   type="number" 
                                   max="${element.remaining_sessions}" 
                                   min="0" 
                                   name="number_of_session_use[]" 
                                   value="${element.remaining_sessions}" 
                                   class="form-control" 
                                   ${isDisabled}>
                        </td>
                        <td>
                            <textarea class="form-control" name="comments[]" ${isDisabled ? 'disabled' : ''}>
                                ${isDisabled ? 'All Redeemed' : 'Redeem'}
                            </textarea>
                        </td>
                        <td>
                            <button type="button" class="btn btn-block btn-outline-primary mt-2 submit-btn" 
                                onclick="handleRedeemClick(this)" 
                                ${isDisabled ? 'disabled' : ''}>
                                <span class="spinner-border spinner-border-sm" style="display: none;"></span>
                                Redeem
                            </button>
                        </td>`
                            );

                            tbody.append(row);
                        });

                        table.append(tbody);
                        form.append(table);
                        $('#giftcardsshow').append(form);
                    } else {
                        $('#giftcardsshow').html('<p>No services found.</p>');
                    }
                },
                error: function() {
                    $('#giftcardsshow').html('<p>An error occurred. Please try again later.</p>');
                }
            });
        }

        function handleRedeemClick(button) {
            if (confirm('Are you sure you want to redeem this?')) {
                var spinner = $(button).find('.spinner-border');
                var currentRow = $(button).closest('tr');
                var number_of_session_use = currentRow.find('input[name="number_of_session_use[]"]').val();
                var remaining_sessions = currentRow.find('td:nth-child(4)')
            .text(); // Get remaining sessions value from table cell
                // Validate session usage
                if (parseInt(number_of_session_use) > parseInt(remaining_sessions)) {
                    alert('You cannot redeem more sessions than the remaining sessions.');
                    spinner.hide();
                    button.prop('disabled', false);
                    return; // Stop the form submission
                }
                spinner.show();
                $(button).prop('disabled', true);

                var rowData = {
                    _token: '{{ csrf_token() }}', // Add CSRF token
                    product_id: currentRow.find('input[name="service_id[]"]').val(),
                    order_id: currentRow.find('input[name="order_id[]"]').val(),
                    service_type: currentRow.find('input[name="service_type[]"]').val(),
                    service_order_id: currentRow.find('input[name="service_order_id[]"]').val(),
                    number_of_session_use: number_of_session_use,
                    comments: currentRow.find('textarea[name="comments[]"]').val(),
                    patient_login_id: currentRow.find('input[name="patient_login_id[]"]').val()
                };

                $.ajax({
                    url: '{{ route('redeem-services') }}',
                    method: 'POST',
                    data: rowData,
                    success: function(response) {
                        if (response.success) {
                            $('#redeemed_success').html(response.message);
                            currentRow.find('input, textarea, button').prop('disabled', true);
                            currentRow.addClass('completed-row');
                        } else {
                            $('#redeemed_error').html('Action failed. Please try again.');
                            $(button).prop('disabled', false);
                        }
                        spinner.hide();
                    },
                    error: function() {
                        alert('An error occurred. Please try again later.');
                        spinner.hide();
                        $(button).prop('disabled', false);
                    }
                });
            }
        }


        // For Value Validate 
        function valueValidate(inputElement, maxValue) {
            var currentValue = parseInt(inputElement.value);

            if (currentValue > maxValue) {
                alert('Entered value is greater than the remaining value.');
                inputElement.value = maxValue; // Set the value to the max value
            } else if (currentValue < 0) {
                alert('Value cannot be less than 0.');
                inputElement.value = 0; // Set the value to the minimum value
            }
        }

        // Inspect Page Lock
        // Disable right-click context menu




        // document.addEventListener('contextmenu', function(event) {
        //     event.preventDefault();
        // });

        // // Disable F12, Ctrl+Shift+I, Ctrl+Shift+J, and Ctrl+U (view source)
        // document.addEventListener('keydown', function(event) {
        //     // F12 key
        //     if (event.keyCode === 123) {
        //         event.preventDefault();
        //     }
        //     // Ctrl+Shift+I (Inspect)
        //     if (event.ctrlKey && event.shiftKey && event.keyCode === 73) {
        //         event.preventDefault();
        //     }
        //     // Ctrl+Shift+J (Console)
        //     if (event.ctrlKey && event.shiftKey && event.keyCode === 74) {
        //         event.preventDefault();
        //     }
        //     // Ctrl+U (View Source)
        //     if (event.ctrlKey && event.keyCode === 85) {
        //         event.preventDefault();
        //     }
        // });
    </script>

<script>
    $(function () {
      $("#datatable-buttons").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>
@endpush
