@extends('layouts.front-master')
@section('body')
<div id="wish" class="about-box" style="padding-bottom: 0;">
	<div class="about-a1">
		<div class="container" style="text-align: center;">
            <table class="table table-striped p-4 mt-5">
        
                  <tr><th scope="col">From Name</th><td>{{ session('gift_details')['from_name'] ?? 'Null'  }}</td></tr>
                  <tr><th scope="col">To Name</th><td>{{ session('gift_details')['to_name']  ?? 'Null'  }}</td></tr>
                  <tr><th scope="col">From Email</th><td>{{ session('gift_details')['from']   ?? 'Null' }}</td></tr>
                  <tr><th scope="col">To Email</th><td>{{ session('gift_details')['to']  ?? 'Null'  }}</td></tr>
                  <tr><th scope="col">Amount</th><td>$ {{$giftDetails['amount']   ?? 'Null' }}</td></tr>
            </table>
            <form action="{{url('/payment')}}" method="POST" class="mb-4">
                @csrf
                <script
                src="https://checkout.stripe.com/checkout.js"
                class="stripe-button"
                data-key= "{{env('STRIPE_KEY')}}"
                data-name="Forever Medspa"
                data-description="Forever Medspa Giftcards"
                data-amount="{{$giftDetails['amount'] * 100 }}"
                data-email="info@forevermedspanj.com"
                data-image="{{url('/images/gifts/logo.png')}}"
                data-currency="usd">
                </script>
            </form>
        </div>
    </div>
</div>
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
  @endsection