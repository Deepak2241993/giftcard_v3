@extends('layouts.master')
@section('title') @lang('translation.Basic_Elements')  @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Forms @endslot
@slot('title') Giftcards Redeem @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Giftcards Redeem</h4>
                @if(session()->has('error'))
                
                    {{ session()->get('error') }}
            @endif
            </div>
            <div class="card-body p-4">

                <form method="post" action="{{route('giftcards-redeem')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-lg-6 self">
                            <label for="amount" class="form-label">Amount</label>
                            <input class="form-control" type="number" name="amount" value="" placeholder="$ 0.0" id="amount">
                        </div>
                        <div class="mb-3 col-lg-6 self">
                            <label for="code" class="form-label">Giftcards Code</label>
                            <input class="form-control" type="text" name="code" min="12" value="" placeholder="xxxx" id="code">
                        </div>
                        <div class="mb-3 col-lg-12">
                            <label for="comment" class="form-label">Comment</label>
                            <textarea name="comment" id="comment" autocomplete="off" rows="4" class="form-control">Comment</textarea>
                            
                        </div>
                       
                        <div class="mb-3 mt-4 col-lg-6">
                            
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
