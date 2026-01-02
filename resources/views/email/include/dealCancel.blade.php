@php
    $servicePurchases = App\Models\ServiceOrder::select('service_orders.*', 'products.product_name')
        ->join('products', 'service_orders.service_id', '=', 'products.id')
        ->where('service_orders.order_id', $maildata->order_id)
        ->get();

    $serviceRedeem = App\Models\ServiceRedeem::select('service_redeems.*', 'products.product_name','products.amount','products.discounted_amount')
        ->join('products', 'service_redeems.product_id', '=', 'products.id')
        ->where('service_redeems.order_id', $maildata->order_id)
        ->get();

    // Calculate total amount
    $remaning_number_of_session = $servicePurchases->sum('number_of_session') - $serviceRedeem->sum('number_of_session_use');

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
            Service Session Redeem
        </th>
        <th style="padding: 10px; text-align: left;">
            Refund Balance
        </th>


    </tr>




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
                {{ $item->product_name }}
            </td>
            <td style="padding: 10px;">
                Buy</td>
            <td style="padding: 10px;">
                {{ $item->number_of_session }}
            </td> <!-- Credit -->
            <td style="padding: 10px;">
                --</td>
            <td style="padding: 10px;">
                --</td>


        </tr>
    @endforeach

    <!-- Loop through each redemption to show debits -->
    @foreach ($serviceRedeem as $value)
        <tr>
            <td style="padding: 10px;">
                {{ date('m-d-Y', strtotime($value->updated_at)) }}
            </td>
            <td style="padding: 10px;">
                {{ $value->transaction_id }}
            </td>
            <td style="padding: 10px;">
                {{ $value->product_name }}
            </td>
            <td style="padding: 10px;">
                {{ $value->comments ?: '' }}
            </td>
            <td style="padding: 10px;">
                --</td>
            <td style="padding: 10px;">
                {{ $value->number_of_session_use }}
            </td>
            <td style="padding: 10px;">
                {{ $value->refund_amount }}
            </td>

            <!-- Debit -->
        </tr>
    @endforeach
    {{-- <tr>
<td colspan="4"></td>
<th>Refundable Amount</th>
<td>{{$totalAmount }}
</td>
</tr> --}}
</table>
