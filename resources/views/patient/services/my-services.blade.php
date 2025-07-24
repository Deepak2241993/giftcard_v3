@extends('layouts.patient_layout')
@section('body')
    @push('css')
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
    @endpush()
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="mb-0">My Services</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Orders</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            My Services
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
                {{ $data->onEachSide(5)->links() }}
                <table id="datatable-buttons" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>View Order</th>
                            <th>Invoice</th>
                            <th>Order Number</th>
                            {{-- <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone</th> --}}
                            <th>Transaction Amount</th>
                            <th>Transaction Id</th>
                            <th>Created Date & Time</th>

                        </tr>
                    </thead>


                    <tbody id="data-table-body">
                        @foreach ($data as $key => $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>  <a  class="btn btn-block btn-outline-primary"
                                    href="{{ route('patient-invoice', ['transaction_data' => encrypt($value->id)]) }}" class="btn btn-primary">Invoice Download</a>
                                    
                               </td>
                                
                                @if(!empty($value->payment_intent))
                                <td>
                                    <a type="button" class="btn btn-block btn-outline-dark"
                                        data-bs-toggle="modal" data-bs-target="#statement_view_{{ $value['id'] }}"
                                        onclick="StatementView({{ $key }},'{{ $value['order_id'] }}')">
                                        Statement
                                    </a>
                                </td>
                                @else
                                <td> <span class="badge bg-danger">No Payment</span></td>
                                @endif
                                <td>{{ $value->order_id }}</td>
                                {{-- <td>{{ $value->fname . ' ' . $value->lname }}</td>
                                <td>{{ $value->email }}</td>
                                <td>{{ $value->phone }}</td> --}}
                                <td>{{ $value->final_amount }}</td>
                                <td>{{ $value->payment_intent }}</td>
                                <td>{{ date('m-d-Y h:i:m', strtotime($value->updated_at)) }}
                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
                {{ $data->links() }}
                <!--end::Row-->
                <!-- /.Start col -->
            </div>
            <!-- /.row (main row) -->
        </div>
        <!--end::Container-->
    </section>

    
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
@endpush
