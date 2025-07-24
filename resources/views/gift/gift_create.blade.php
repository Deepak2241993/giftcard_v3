@extends('layouts.master')
@section('title') @lang('translation.Basic_Elements')  @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Forms @endslot
@slot('title') Giftcards Add @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Giftcards</h4>
               
            </div>
            <div class="card-body p-4">

                <form method="post" action="{{route('gift.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        {{-- <div class="mb-3 col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="recipient" value="other" id="otherRadio"checked onclick="geftCardSendToOther()">
                                <label class="form-check-label" for="otherRadio">Purchase for Someone Else</label>
                                
                            </div>
                            
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="recipient" value="self" id="selfRadio"  onclick="geftCardSendToOther()">
                                <label class="form-check-label" for="selfRadio">Purchase for Myself</label>
                            </div>
                        </div> --}}
                        <div class="mb-3 col-lg-12">
                            <label for="amount" class="form-label">Amount(in $)</label>
                            <input class="form-control" type="text" name="amount" value="" placeholder="$ 100" id="amount">
                        </div>
                        <div class="mb-3 col-lg-6 self">
                            <label for="to" class="form-label">To</label>
                            <input class="form-control" type="email" name="to" value="" placeholder="to@domain.com" id="to">
                        </div>
                        <div class="mb-3 col-lg-6">
                            <label for="from" class="form-label">From</label>
                            <input class="form-control" type="email" name="from" value="" placeholder="from@domain.com" id="from">
                            <input class="form-control" type="hidden" name="user_id" value="{{Auth::user()->id}}">
                        </div>
                        <div class="mb-3 col-lg-12">
                            <label for="msg" class="form-label">Message</label>
                            <textarea name="msg" id="msg" autocomplete="off" rows="4" class="form-control">Message</textarea>
                            
                        </div>
                        <div class="mb-3 col-lg-6">
                            <label for="to_name" class="form-label">To Name</label>
                            <input class="form-control" type="text" name="to_name" value="" placeholder="To Name" id="to_name">
                        </div>
                        <div class="mb-3 col-lg-6 self">
                            <label for="from_name" class="form-label">From Name</label>
                            <input class="form-control" type="text" name="from_name" value="" placeholder="From Name" id="from_name">
                        </div>
                        
                        <div class="mb-3 col-lg-6">
                            <label class="form-label">Apply Coupon</label><br>
                            
                            <label for="coupon-yes">
                                <input type="radio" id="coupon-yes" value="yes" name="coupon" checked onclick="couponRedeem()"> YES
                            </label>
                            
                            <label for="coupon-no">
                                <input type="radio" id="coupon-no" value="no" name="coupon"  onclick="couponRedeem()"> NO
                            </label>
                        </div>
                        <div class="mb-3 col-lg-6 coupon_code" id="coupon_code_section">
                            <label for="coupon_code" class="form-label">Coupon Code</label>
                            <input class="form-control"  type="text" name="coupon_code" value="" placeholder="Coupon Code" id="coupon_code">
                        </div>
                        <div class="mb-3 col-lg-6">
                            
                            <button  class="btn btn-block btn-outline-primary" type="submit" name="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div> <!-- end col -->
</div>
<!-- end row -->

@endsection
@section('script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    function couponRedeem() {
        // Get the selected radio button
        var selectedValue = document.querySelector('input[name="coupon"]:checked').value;

        // You can perform actions based on the selected value
        if (selectedValue === 'yes') {
            // Code to handle when "YES" is selected
            $('.coupon_code').show();
        } else if (selectedValue === 'no') {
            // Code to handle when "NO" is selected
            $('.coupon_code').hide();
        }
    }
</script>

<script>
    
      function geftCardSendToOther(){
        var recipientRadios = document.getElementsByName('recipient');
    
        for (var i = 0; i < recipientRadios.length; i++) {
          // alert(recipientRadios[i].value);
        if (recipientRadios[i].value=='other' && recipientRadios[i].checked) {
          // Display the selected value
          $('.self').css({'display':'block'});
          break; // Exit the loop since we found the selected radio button
        }
        if (recipientRadios[i].value=='self' && recipientRadios[i].checked) {
          // Display the selected value
          $('.self').css({'display':'none'});
          break; // Exit the loop since we found the selected radio button
        } 
      }
      }
    
     
      </script>
@endsection
