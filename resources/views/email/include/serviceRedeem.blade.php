@php
use App\Models\ServiceOrder;
use App\Models\ServiceRedeem;
 // Fetch service purchases
$orderId = $maildata->order_id;

            // Fetch service purchases with product and unit details
            $servicePurchases = ServiceOrder::select(
                'service_orders.*', 
                'products.product_name', 
                'service_units.product_name as unit_name'
            )
            ->leftJoin('products', 'service_orders.service_id', '=', 'products.id')
            ->leftJoin('service_units', 'service_orders.service_id', '=', 'service_units.id')
            ->where('service_orders.order_id', $orderId)
            ->get();

            // Fetch service redeems with product and unit details
            $serviceRedeem = ServiceRedeem::select(
                'service_redeems.*',
                'products.product_name',
                'service_units.product_name as unit_name'
            )
            ->leftJoin('products', 'service_redeems.product_id', '=', 'products.id')
            ->leftJoin('service_units', 'service_redeems.product_id', '=', 'service_units.id')
            ->where('service_redeems.order_id', $orderId)
            ->get();

            // Calculate total remaining sessions
            $totalAmount = $servicePurchases->sum('number_of_session') - $serviceRedeem->sum('number_of_session_use');
@endphp
 <table border="1" cellspacing="0" cellpadding="10"
     style="font-family:Open Sans,-apple-system,BlinkMacSystemFont,Roboto,Helvetica Neue,Helvetica,Arial,sans-serif;border-collapse:collapse;width:100%; border: 1px solid #ddd; margin-top: 20px;">
     <tr style="background-color: #fca52a; color: white;">
         <th style="padding: 10px; text-align: left;">
             Transaction Date</th>
         <th style="padding: 10px; text-align: left;">
             Transaction Number</th>
         <th style="padding: 10px; text-align: left;">
             Service Name</th>
         <th style="padding: 10px; text-align: left;">
             Message</th>
         <th style="padding: 10px; text-align: left;">
             Service Session Purchases
         </th>
         <th style="padding: 10px; text-align: left;">
             Service Session Redeem</th>
     </tr>

     @php
         $balance = 0; // Initial balance
     @endphp

     <!-- Loop through each purchase to show credits -->
     @foreach ($servicePurchases as $item)
         <tr style="background-color: #f2f2f2;">
             <td style="padding: 10px;">
                 {{ date('m-d-Y', strtotime($item->updated_at)) }}
             </td>
             <td style="padding: 10px;">
                 {{ $item->order_id }}
             </td>
             <td style="padding: 10px;">
                 {{--  For Product Name --}}
                 @if ($item->service_type == 'product')
                     {{ $item->product_name }}
                 @endif
                 {{--  For Unit Name --}}
                 @if ($item->service_type == 'unit')
                     {{ $item->unit_name }}
                 @endif
             </td>
             <td style="padding: 10px;">Buy</td>
             <td style="padding: 10px;">{{ $item->number_of_session }}</td> 
             <!-- Credit -->
             <td style="padding: 10px;">--</td>
         </tr>
     @endforeach

     <!-- Loop through each redemption to show debits -->

     @foreach ($serviceRedeem as $value)
         @php
             $balance -= $value->number_of_session_use; // Subtract from balance for each redemption
         @endphp
         <tr>
             <td style="padding: 10px;">
                 {{ date('m-d-Y', strtotime($value->updated_at)) }}
             </td>
             <td style="padding: 10px;">
                 {{ $value->transaction_id }}
             </td>
             <td style="padding: 10px;">
                 @if ($value->service_type == 'product')
                     {{ $value->product_name }}
                 @endif
                 {{--  For Unit Name --}}
                 @if ($value->service_type == 'unit')
                     {{ $value->unit_name }}
                 @endif
             </td>
             <td style="padding: 10px;">
                 {{ $value->comments ?: '' }}
             </td>
             <td style="padding: 10px;">
                 --</td>
             <td style="padding: 10px;">
                 {{ $value->number_of_session_use }}
             </td> <!-- Debit -->
         </tr>
     @endforeach
 </table>
