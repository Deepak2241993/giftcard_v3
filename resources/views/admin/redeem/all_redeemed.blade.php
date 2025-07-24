@extends('layouts.admin_layout')
@section('body')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Service Cancel List</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Cancel
                            </li>
                        </ol>
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
               
                <form class="mt-2" method="get" action="{{ route('cancel-service') }}">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label for="transaction_id">Transaction/Strip/OrderNumber</label>
                            <input type="text" class="form-control" id="transaction_id" name="transaction_id" placeholder="Transaction/Strip/OrderNumber" value="{{ request('transaction_id') }}">
                        </div>
                        
                        <div class="col-md-1">
                            <input type="hidden" name="user_token" value="{{ Auth::user()->user_token }}">
                            <button type="submit"  class="btn btn-block btn-outline-success mt-4">Search</button>
                        </div>
                    </div>
                </form>
                
                

                    <span class="text-success">
                        @if (session()->has('success'))
                            {{ session()->get('success') }}
                        @endif
                    </span>
                

                
                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Service Name</th>
                                <th>Order Number</th>
                                <th>Refund Amount</th>
                                <th>Transaction Id</th>
                                <th>Strip Track Id</th>
                                <th>Refund Date Time</th>
                               

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cancel_deals as $value)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    
                                    <td>{{ $value['service_name'] ? $value['service_name'] : 'NULL' }}</td>
                                    <td>
                                        {{ $value['order_id'] ? $value['order_id'] : 'NULL' }}
                                        
                                    </td>
                                    <td>${{$value['refund_amount']}}</td>
                                    <td>{{$value['transaction_id']}}</td>
                                    <td>{{$value['payment_intent']}}</td>
                                    
                                    <td>{{ date('m-d-Y h:i:s', strtotime($value['updated_at'])) }}</td>
                                    


                                    <!-- Button trigger modal -->




                                </tr>
                            @endforeach
                        </tbody>
                        {{ $cancel_deals->links() }}
                    </table>
                    {{ $cancel_deals->links() }}
                <!--end::Row-->
                <!-- /.Start col -->
            </div>
            <!-- /.row (main row) -->
        </div>
        <!--end::Container-->
        </div>
        <!--end::App Content-->
    </main>


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
                   <button type="button"  class="btn btn-block btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
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
             url: '{{route("cart")}}',
             method: "post",
             dataType: "json",
             data: {
                 _token: '{{csrf_token() }}',
                 product_id: id,
                 quantity: 1,
                 type: "product"
             },
             success: function (response) {
                 if (response.success) {
                    location.reload();
                 } else {
                     $('.showbalance').html(response.error).show();
                 }
             },
             error: function (jqXHR, textStatus, errorThrown) {
                 // Handle the error here
                 $('.showbalance').html('An error occurred. Please try again.').show();
             }
         });
     }
     
     </script>
@endpush
