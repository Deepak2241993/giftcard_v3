@extends('layouts.master')
@section('title') @lang('translation.Basic_Elements')  @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Forms @endslot
@slot('title') Giftcards History @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Giftcards</h4>
                <form action="{{route('giftcards-history')}}" method="post">
                    <div class="row">
                    @csrf
                    <div class="mb-3 col-lg-3 self">
                        <label for="to" class="form-label">Enter Giftcard Number</label>
                        <input class="form-control" type="text" name="code"  placeholder="xxxx" id="to">
                    </div>
                    <div class="mb-3 col-lg-3 self">
                      <label for="to" class="form-label">Email</label>
                      <input class="form-control" type="email" name="code"  placeholder="xxxx" id="to">
                  </div>
                    <div class="mt-4 col-lg-3 self">
                       
                        <button class="form-control btn btn-outline-primary" type="submit">Submit</button>
                    </div>
                </div>
                </form>
               
            </div>
            @if(isset($history))
            <div class="card-body p-4">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">To Name</th>
                        <th scope="col">From Name</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Redeem Status</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($history as $key=>$value)
                      <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{ $value->to_name ?? 'null' }}<br>{{ $value->to ?? '' }}</td>
                        <td>{{ $value->from_name ?? 'null' }}<br>{{ $value->from ?? '' }}</td>
                        <td>{{ '$ '.($value->useamount) ?? '$ 0.0' }}</td>
                        <td>
                          @php
                             $data = App\Models\GiftcardRedeem::where('code', $value->code)
                                    ->where('created_at','<=', $value->tilldate)
                                    ->sum('amount');
                          @endphp
                          {{-- {{($value->amount)-($data)}} --}}

                          {{ ($value->amount)-($data) == 0 ? 'Full Use' : 'Partial Use' }}
                        </td>
                      </tr>
                      @endforeach
                      
                    </tbody>
                  </table>
            </div>
            @endif
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
