@component('mail::message')
# Refund Receipt

Dear Customer,

We have successfully processed your refund. Below are the details of your refund:

**Refund Amount:** ${{ number_format($refund->amount / 100, 2) }}  
**Refund Reason:** {{ $refund->reason ?? 'N/A' }}  
**Refund Status:** {{ $refund->status }}  
**Payment Intent:** {{ $refund->payment_intent }}  

If you have any questions regarding this refund, please don't hesitate to contact us.

Thank you for your continued trust in our service.

Best regards,  
{{ config('app.name') }}

@endcomponent
