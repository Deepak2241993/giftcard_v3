@extends('layouts.admin_layout')
@section('body')
 
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h3 class="mb-0">Giftcard Redeem Process</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('admin-dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Giftcard Redeem Process
                        </li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content-header">
    
    

        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            @if(count($getdata) > 0)
            <table id="datatable-buttons" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending">#</th>
                        <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending"aria-label="Gift Card Holder Name">Gift Card Holder Name</th>
                        <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending"aria-label="User Name">User Name </th>
                        <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending"aria-label="Gift Card Number">Gift Card Number</th>
                        <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending"aria-label="Gift Card Amount">Gift Card Amount</th>
                        <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending"aria-label="Gift Card Status">Gift Card Status</th>
                        {{-- <th>Created Time</th> --}}
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($getdata as $key=>$value)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $value['recipient_name'] ? $value['recipient_name']:$value['your_name'] }}</td>
                        <td>{{ $value['gift_send_to'] }}</td>
                        <td>{{ $value['giftnumber'] }}</td>
                        <td>{{ '$'.$value['total_amount'] }}</td>
                        <td>{!! $value['status']!=0?'<span class="badge text-bg-success">Active</span>':'<span class="badge text-bg-danger">Inactive</span>' !!}</td>
                        <td class="text-center">
                            @if($value['status'] != 0 && $value['total_amount'] != 0)
                                <a type="button" 
                                class="btn btn-sm btn-outline-success me-1" 
                                data-bs-toggle="modal" 
                                data-bs-target="#redeem_{{ $value['user_id'] }}" 
                                onclick="modalopen({{ $value['user_id'] }}, '{{ $value['giftnumber'] }}', '{{ $value['total_amount'] }}')" 
                                title="Redeem Giftcard">
                                    <i class="fa fa-check"></i>
                                </a>

                                <a type="button" 
                                class="btn btn-sm btn-outline-danger me-1" 
                                data-bs-toggle="modal" 
                                data-bs-target="#docancel_{{ $value['user_id'] }}" 
                                onclick="docancel({{ $value['user_id'] }}, '{{ $value['giftnumber'] }}')" 
                                title="Cancel Giftcard">
                                    <i class="fa fa-times"></i>
                                </a>
                            @endif

                            <a type="button" 
                            class="btn btn-sm btn-outline-primary" 
                            data-bs-toggle="modal" 
                            data-bs-target="#Statment_{{ $value['user_id'] }}" 
                            onclick="Statment({{ $value['user_id'] }}, '{{ $value['giftnumber'] }}')" 
                            title="View History">
                                <i class="fa fa-history"></i>
                            </a>
                        </td>

                        <!-- Button trigger modal -->
                    </tr>
                   
                    @endforeach
                </tbody>
                {{-- {{ $getdata->links() }} --}}
            </table>
            {{-- {{ $getdata->links() }} --}}
            @else
            <hr>
            <p> No Data found </p>
            @endif
            <!--end::Row-->               
                <!-- /.Start col -->
        </div>
</section>


  <!--  Redeem Modal -->
<div class="modal fade deepak" id="redeem_" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Gift Redeem Form</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form method="get" action="{{route('giftcard-search') }}">
                    <div style="display: flex; flex-direction: column;">
                        <label for="giftnumber_" style="margin-right: 10px;">Gift Number:</label>
                        <input  class="giftnumber_ form-control"type="text" id="giftnumber_" name="giftnumber" value="" style="margin-right: 20px;" readonly>

                        <label for="amount_" style="margin-right: 10px;">Amount:</label>
                        <input  type="number" id="amount_" class="amount_ form-control" min="1" max="" name="amount" style="margin-right: 20px;">
                
                        <label for="comments_" style="margin-right: 10px;">Comments</label>
                        <textarea class="form-control comments_" name="comments" id="comments_" style="margin-right: 20px;"></textarea>
                
                        <input type="hidden" class="user_token" name="user_token" value="{{ Auth::user()->user_token }}">
                        <input type="hidden" class="user_id" id="user_id_" name="user_id" value="">
                
                        <button type="button"  class="btn btn-block btn-outline-primary mt-3 redeembutton" id="" event_id="" onclick="redeemgiftcard(event)"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>Redeem</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
               <button type="button"  class="btn btn-block btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
  {{-- Do Cancel Modal --}}
<div class="modal fade prasad" id="docancel_" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cancel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancel">Gift Card Cancel Form</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
                </div>
                <div class="modal-body">
                    <form method="get" action="{{route('giftcard-search') }}">
                        <div style="display: flex; flex-direction: column;">
                            <label for="cancel_giftnumber_" style="margin-right: 10px;">Gift Number:</label>
                            <input  class="cancel_giftnumber_ form-control"type="text" id="cancel_giftnumber_" name="giftnumber" value="" style="margin-right: 20px;" readonly>
                    
                            <label for="cancel_comments_" style="margin-right: 10px;">Comments</label>
                            <textarea class="form-control cancel_comments_" name="comments"style="margin-right: 20px;"></textarea>
                    
                            <input type="hidden" class="user_token" name="user_token" value="{{ Auth::user()->user_token }}">
                            <input type="hidden" class="cancel_user_id" id="cancel_user_id_" name="cancel_user_id" value="">
                    
                            <button type="button"  class="btn btn-block btn-outline-primary mt-3 cancel_button" id="" event_id=""  onclick="cancelgiftcard(event)"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>Cancel Giftcard</button>
                        </div>
                    </form>
                </div>
            <div class="modal-footer">
               <button type="button"  class="btn btn-block btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
{{-- Do cancel modal End --}}
  {{--  For Statment Mpdal --}}
    <div class="modal fade Statment" id="Statment_" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Gift Card History</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
                </div>
                <div class="modal-body">
                    <table class="statment_view table table-striped"></table>
                    <b><span class="text-danger">*</span>Any Transaction Number starting with the prefix "CANCEL", denotes the particular Giftcard has been cancelled and is inactive henceforth</b>
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
    function Statment(id,giftcardnumber){
    $('.Statment').attr('id', 'Statment_' + id);

    $.ajax({
        url: '{{ route('giftcardstatment') }}',
        method: "post",
        dataType: "json",
        data: {
            _token: '{{ csrf_token() }}',
            gift_card_number: giftcardnumber,
            user_token: '{{Auth::user()->user_token}}',
        },
        success: function(response) {
    console.log(response);
    if(response.status == 200) {
        $('#Statment_' + id).modal('show');

        // Clear the content of the statment_view element
        $('.statment_view').empty();

        // Create the table header
        var tableHeader = `
            <tr>
                <th>Sl No.</th>
                <th>Transaction Number</th>
                <th>Card Number</th>
                <th>Date</th>
                <th>Message</th>
                <th>Value Amount</th>
                <th>Actual Paid Amount</th>
            </tr>
        `;
        // Append the table header to statment_view
        $('.statment_view').append(tableHeader);

        // Iterate over each element in the response.result array
        $.each(response.result, function(index, element) {
    // Parse the date string into a JavaScript Date object
    var date = new Date(element.updated_at);
    
    // Format the date components
    var formattedDate = (date.getMonth() + 1) + '-' + date.getDate() + '-' + date.getFullYear();

    // Create a new row for each element
    var newRow = `
        <tr>
            <td>${index + 1}</td>
            <td>${element.transaction_id}</td>
            <td>${element.giftnumber}</td>
            <td>${formattedDate}</td>
            <td>${element.comments ? element.comments : 'Self'}</td>
            <td>$${element.amount}</td>
            <td>$${element.actual_paid_amount}</td>
        </tr>
    `;

    // Append the new row to the element with class "statment_view"
    $('.statment_view').append(newRow);
});

        var totalamount = `
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><b><u>Available Amount</u></b></td>
            <td><b><u>Refund</u></b></td>
        </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><b>$${response.TotalAmount}</b></td>
                    <td><b>$${response.actual_paid_amount}</b></td>
                </tr>
            `;
            $('.statment_view').append(totalamount);
    } else {
        $('#Statment_' + id).modal('show');
        $('.statment_view').html(response.error);
    }
}

    });
    }



function modalopen(id,giftcardnumber,amount) {
    $('.deepak').attr('id', 'redeem_' + id);
    $('.user_id').attr('id', 'user_id_' + id);
    $('#user_id_'+id).val(id);

    // for Giftcard value set 
    $('.giftnumber_').attr('id', 'giftnumber_' + id);
    $('#giftnumber_' + id).val(giftcardnumber);

    $('.redeembutton').attr('id', 'redeembutton_' + id);
    $('.redeembutton').attr('event_id',+id);
    
    $('.amount_').attr('id', 'amount_' + id);
    $('#amount_'+id).attr('max', amount);
    $('.comments_').attr('id', 'comments_' + id);
    // for Giftcard value set
    $('#redeem_' + id).modal('show');
}
function redeemgiftcard(event) {

    var id = event.target.getAttribute('event_id');
    var amountInput = $('#amount_' + id);
    var enteredAmount = amountInput.val();
    var isValid = true;

    // Check if the entered amount is a valid number and within the specified range
    if (isNaN(enteredAmount) || enteredAmount < parseInt(amountInput.attr('min')) || enteredAmount > parseInt(amountInput.attr('max'))) {
        amountInput.addClass('is-invalid'); // Add Bootstrap's 'is-invalid' class for styling
        alert('The input amount does not match the giftcard amount');
        isValid = false;
    } else {
        amountInput.removeClass('is-invalid'); // Remove 'is-invalid' class if the input is valid
    }

    // Proceed with AJAX request only if input is valid
    if (isValid) {
    //  For adding spinner
    var button = $('#redeembutton_' + id);
    button.attr('disabled', true);
    button.find('.spinner-border').show();
    // spinner code end
        $.ajax({
            url: '{{ route('giftcardredeem') }}',
            method: "post",
            dataType: "json",
            data: {
                _token: '{{ csrf_token() }}',
                amount: enteredAmount,
                gift_card_number: $('#giftnumber_' + id).val(),
                comments: $('#comments_' + id).val(),
                user_token: '{{ Auth::user()->user_token }}',
                user_id: $('#user_id_' + id).val(),
            },
            success: function(response) {
                console.log(response.success);
                if (response.success) {
                    $("#redeem_" + id).hide();
                    $('.sucess').empty();
                    $('.sucess').html('<h2 class="text-success">' + response.success + '</h2>');
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                } else {
                    $('.sucess').empty();
                    $('.sucess').html('<h2 class="text-error">' + response.error + '</h2>');
                }
            }
        });
    }
}

// Do Cancel Script
function docancel(id,giftcardnumber) {
    $('.prasad').attr('id', 'docancel_' + id);
    $('.cancel_user_id').attr('id', 'cancel_user_id_' + id);
    $('#cancel_user_id_'+id).val(id);

    // for Giftcard value set 
    $('.cancel_giftnumber_').attr('id', 'cancel_giftnumber_' + id);
    $('#cancel_giftnumber_' + id).val(giftcardnumber);
    //  for Comments Add
    $('.cancel_comments_').attr('id', 'cancel_comments_' + id);

    $('.cancel_button').attr('id', 'cancel_button_' + id);
    $('#cancel_button_' + id).attr('event_id',id);
    
    // $('.cance_comments_'+id).attr('id', 'cance_comments_' + id);
    // for Giftcard value set
    $('#docancel_' + id).modal('show');
}

// Call Cancle API 

function cancelgiftcard(event) {
    var id = event.target.getAttribute('event_id');
    var amountInput = $('#amount_' + id);
    var enteredAmount = amountInput.val();
    var isValid = true;
    //  For adding spinner
    var button = $('#cancel_button_' + id);
    button.attr('disabled', true);
    button.find('.spinner-border').show();
    // spinner code end

    // Proceed with AJAX request only if input is valid
    if (isValid) {
        $.ajax({
            url: '{{ route('giftcancel') }}',
            method: "post",
            dataType: "json",
            data: {
                _token: '{{ csrf_token() }}',
                gift_card_number: $('#cancel_giftnumber_' + id).val(),
                comments: $('#cancel_comments_' + id).val(),
                user_token: '{{ Auth::user()->user_token }}',
                user_id: $('#cancel_user_id_' + id).val(),
            },
            success: function(response) {
                console.log(response.success);
                if (response.success) {
                    $("#redeem_" + id).hide();
                    $('.sucess').empty();
                    $('.sucess').html('<h2 class="text-success">' + response.success + '</h2>');
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                } else {
                    $('.sucess').empty();
                    $('.sucess').html('<h2 class="text-error">' + response.error + '</h2>');
                }
            }
        });
    }
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
