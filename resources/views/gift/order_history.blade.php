@extends('layouts.admin_layout')
@section('body')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3 class="mb-0">Service Order History</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Orders</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Service Order History
                    </li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<section class="app-main">

    <!--begin::App Content-->
    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">

            
            
            <!--begin::Row-->
            {{-- {{ $data->onEachSide(50)->links() }} --}}
            <table id="datatable-buttons" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#">#</th>
                        <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Order Number">Order Number</th>
                        <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Invoice">Invoice</th>
                        <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Full Name">Full Name</th>
                        <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Email">Email</th>
                        <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Phone">Phone</th>
                        <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="City">City</th>
                        <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Country">Country</th>
                        <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Transaction Id">Transaction Id</th>
                        <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Total Amount">Total Amount</th>
                        <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Transaction Amount">Transaction Amount</th>
                        <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Gift Card Use">Gift Card Use</th>
                        <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Payment Status">Payment Status</th>
                        <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Transaction Status">Transaction Status</th>
                        <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Created Date & Time">Created Date & Time</th>
                    </tr>
                </thead>

                <tbody id="data-table-body">
                    @foreach($data as $key => $value)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                               
                                {{ $value->order_id }}
                               
                            </td>
                            <td>
                             
                                @if(!empty($value->payment_intent && $value->payment_status == 'paid' || $value->payment_intent && $value->payment_status == 'success'))
                                <a  class="btn btn-block btn-outline-success"
                                    href="{{ route('service-invoice', ['transaction_data' => $value->id]) }}">
                                    Invoice
                                </a>
                                @elseif($value->payment_status == 'under_process')
                                <a  class="btn btn-block btn-outline-primary"
                                    href="{{ route('service-invoice', ['transaction_data' => $value->id]) }}">
                                    Invoice
                                </a>
                                @else
                                <span class="text-danger">No Payment</span>
                                @endif
                            </td>
                            <td>{{ $value->fname . " " . $value->lname }}</td>
                            <td>{{ $value->email }}</td>
                            <td>{{ $value->phone }}</td>
                            <td>{{ $value->city }}</td>
                            <td>{{ $value->country }}</td>
                            <td>{{ $value->payment_intent }}</td>
                            <td>${{ number_format((float) $value->final_amount, 2) }}</td>
                            <td>${{ number_format((float) $value->transaction_amount, 2) }}</td>

                            <td>{{ $value->gift_card_applyed ? 'Yes' : 'No' }}
                            </td>
                            <td>
                                <span
                                    class="badge bg-{{ $value->payment_status == 'paid' || $value->payment_status == 'success' ? 'success' : 'danger' }}">
                                    {{ucfirst($value->payment_status) }}
                                </span>
                                @if($value->payment_status == 'under_process')
                                <a href="#">
                                    <span class="badge bg-warning" data-bs-toggle="modal"
                                        data-bs-target="#paymentUpdate_{{ $value['id'] }}"
                                        onclick="modalopen({{ $value['id'] }}, '{{ $value['order_id'] }}')">Update
                                        Status</span>
                                </a>
                                @endif
                            </td>
                            <td>
                                <span
                                    class="badge bg-{{ $value->transaction_status == 'complete' ? 'success' : 'danger' }}">
                                    {{ucfirst($value->transaction_status) }}
                                </span>
                            </td>
                            <td>{{ date('m-d-Y h:i:s', strtotime($value->updated_at)) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

           
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">All Services </h5>
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

{{-- for payment status update modal --}}
<div class="modal fade paymentUpdate" id="paymentUpdate_" data-bs-backdrop="static" data-bs-keyboard="false"
tabindex="-1" aria-labelledby="paymentstatus" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="paymentstatus">Payment Status Update</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
        </div>
        <div class="modal-body">
            <form method="post" action="{{route('service-order-update')}}">
                @csrf
                <div style="display: flex; flex-direction: column;">
                    <label for="transaction_id_" style="margin-right: 10px;">Transaction id:</label>
                    <input class="transaction_id form-control" type="text" id="transaction_id_" name="order_id"
                        value="" style="margin-right: 20px;" readonly>

                    <label for="payment_status_" style="margin-right: 10px;">Update Status</label>
                    <select name="payment_status" class="form-control status_id" id="payment_status_">
                        <option value="">Select Status</option>
                        <option value="paid" selected>Success</option>
                        <option value="fail">Fail</option>
                    </select>

                    <label for="comments_" style="margin-right: 10px;">Comments</label>
                    <textarea class="form-control comments_" name="comments" id="comments_" style="margin-right: 20px;"></textarea>

                    <input type="hidden" class="user_token" name="user_token"
                        value="{{ Auth::user()->user_token }}">
                    <input type="hidden" class="gift_id" id="gift_id_" name="id" value="">

                    <button type="submit"  class="btn btn-block btn-outline-primary mt-3 paymentstatusbutton" id="paymentstatusbutton"
                        gift_id="gift_id_" onclick="updatestatus(event)"><span
                            class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
                            style="display: none;"></span>Update</button>
                </div>
            </form>
        </div>
        <div class="modal-footer">
           <button type="button"  class="btn btn-block btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
</div>
{{-- Paymnet status update modal End --}}
@endsection
@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
// For Modal
        function modalopen(id, transaction_id) {
            $('#paymentUpdate_').attr('id', 'paymentUpdate_' + id);
            $('#transaction_id_').attr('id', 'transaction_id_' + id).val();
            $('#transaction_id_' + id).val(transaction_id);
            $('#payment_status_').attr('id', 'payment_status_' + id).val();
            $('.paymentstatusbutton').attr('id', 'paymentstatusbutton_' + id).val();
            $('.paymentstatusbutton').attr('gift_id', id).val();
            $('#comments_').attr('id', 'comments_' + id).val();
            $('#paymentUpdate_' + id).modal('show');
        }
        function OrderView(id, order_id) {
            $('.deepak').attr('id', 'staticBackdrop_' + id);
            $('#staticBackdrop_' + id).modal('show');

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
                success: function (response) {
                    if (response.success) {
                        // Clear previous table content
                        $('#giftcardsshow').empty();

                        // Create table structure
                        var table = $('<table class="table table-bordered table-striped">');
                        var thead = $('<thead>').html(
                            '<tr>' +
                            '<th>#</th>' +
                            '<th>Product Name</th>' +
                            '<th>Total Session</th>' +
                            '</tr>'
                        );
                        var tbody = $('<tbody>');

                        // Append header to the table
                        table.append(thead);

                        // Loop through the response result array
                        $.each(response.result, function (index, element) {
                            // Create a new row for each element
                            var row = $('<tr>').html(
                                '<td>' + (index + 1) + '</td>' +
                                '<td>' + element.product_name + '</td>' +
                                '<td>' + element.number_of_session + '</td>'
                            );
                            // Append the row to the tbody
                            tbody.append(row);
                        });

                        // Append tbody to the table
                        table.append(tbody);

                        // Append the table to #giftcardsshow
                        $('#giftcardsshow').append(table);
                    } else {
                        // Handle the case when the response is not successful
                        $('#giftcardsshow').html('<p>No services found.</p>');
                    }
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    $('#giftcardsshow').html('<p>An error occurred. Please try again later.</p>');
                }
            });


        }
//  For Seacrh Function 

    </script>

    {{--  Table --}}
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
