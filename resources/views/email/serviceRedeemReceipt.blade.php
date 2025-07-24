@php
use App\Models\ServiceOrder;
use App\Models\ServiceRedeem;

// Fetch service purchases
$orderId = $data->order_id;

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



<div id=":18p" class="a3s aiL msg-1377519352946152473">
    <u></u>
    <div bgcolor="#f5f7fb">
        <div class="container">
            <center>
                <table cellspacing="0" cellpadding="0"
                    style="font-family:Open Sans,-apple-system,BlinkMacSystemFont,Roboto,Helvetica Neue,Helvetica,Arial,sans-serif;border-collapse:collapse;"
                    bgcolor="#f5f7fb">
                    <tbody>
                        <tr>
                            <table cellspacing="0" cellpadding="0"
                                style="font-family:Open Sans,-apple-system,BlinkMacSystemFont,Roboto,Helvetica Neue,Helvetica,Arial,sans-serif;border-collapse:collapse;width:100%;max-width:640px;text-align:left">
                                <tbody>
                                    <tr>
                                        <td
                                            style="font-family:Open Sans,-apple-system,BlinkMacSystemFont,Roboto,Helvetica Neue,Helvetica,Arial,sans-serif;padding:8px">
                                            <table cellpadding="0" cellspacing="0"
                                                style="font-family:Open Sans,-apple-system,BlinkMacSystemFont,Roboto,Helvetica Neue,Helvetica,Arial,sans-serif;border-collapse:collapse;width:100%">
                                                <tbody>
                                                    <tr>
                                                        <td
                                                            style="font-family:Open Sans,-apple-system,BlinkMacSystemFont,Roboto,Helvetica Neue,Helvetica,Arial,sans-serif;padding-top:24px;padding-bottom:24px">
                                                            <table cellspacing="0" cellpadding="0"
                                                                style="font-family:Open Sans,-apple-system,BlinkMacSystemFont,Roboto,Helvetica Neue,Helvetica,Arial,sans-serif;border-collapse:collapse;width:100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td
                                                                            style="font-family:Open Sans,-apple-system,BlinkMacSystemFont,Roboto,Helvetica Neue,Helvetica,Arial,sans-serif">
                                                                            <a href="https://myforevermedspa.com/"
                                                                                style="color:#467fcf;text-decoration:none"
                                                                                target="_blank"
                                                                                data-saferedirecturl="https://myforevermedspa.com/"><img
                                                                                    src="{{url('/images/gifts/logo.png')}}"
                                                                                    width="150" height="60"
                                                                                    alt="Forever Medspa"
                                                                                    style="line-height:100%;outline:none;text-decoration:none;vertical-align:baseline;font-size:0;border:0 none"
                                                                                    class="CToWUd" data-bit="iit"></a>
                                                                        </td>
                                                                        <td style="font-family:Open Sans,-apple-system,BlinkMacSystemFont,Roboto,Helvetica Neue,Helvetica,Arial,sans-serif"
                                                                            align="right"></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div>
                                                <table cellpadding="0" cellspacing="0"
                                                    style="font-family:Open Sans,-apple-system,BlinkMacSystemFont,Roboto,Helvetica Neue,Helvetica,Arial,sans-serif;border-collapse:collapse;width:100%;border-radius:3px;border:1px solid #f0f0f0"
                                                    bgcolor="#ffffff">
                                                    <tbody>
                                                        <tr>
                                                            <td
                                                                style="font-family:Open Sans,-apple-system,BlinkMacSystemFont,Roboto,Helvetica Neue,Helvetica,Arial,sans-serif">
                                                                <table cellpadding="0" cellspacing="0"
                                                                    style="font-family:Open Sans,-apple-system,BlinkMacSystemFont,Roboto,Helvetica Neue,Helvetica,Arial,sans-serif;border-collapse:collapse;width:100%; background-color: #f9f9f9; margin: 20px 0;">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="content" align="center"
                                                                                style="padding:40px 48px; background-color: #fca52a; color: #ffffff;">
                                                                                <h1
                                                                                    style="font-weight:300;font-size:28px;line-height:130%;margin:16px 0; text-align:center;">
                                                                                    Service Redeem Statement</h1>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="content"
                                                                                style="padding:40px 48px; background-color: #ffffff;">
                                                                                <p style="margin:0 0 1em">Dear
                                                                                    {{ $data->fname ? $data->fname . ' ' . $data->lname : '' }},
                                                                                </p>
                                                                                <p>We’ve attached your latest Service
                                                                                    Redeem Statement. You’ll be able to
                                                                                    see the summary of transactions made
                                                                                    for the Service use.</p>

                                                                                <table border="1" cellspacing="0"
                                                                                    cellpadding="10"
                                                                                    style="font-family:Open Sans,-apple-system,BlinkMacSystemFont,Roboto,Helvetica Neue,Helvetica,Arial,sans-serif;border-collapse:collapse;width:100%; border: 1px solid #ddd; margin-top: 20px;">
                                                                                    <tr
                                                                                        style="background-color: #fca52a; color: white;">
                                                                                        <th
                                                                                            style="padding: 10px; text-align: left;">
                                                                                            Transaction Date</th>
                                                                                        <th
                                                                                            style="padding: 10px; text-align: left;">
                                                                                            Transaction Number</th>
                                                                                        <th
                                                                                            style="padding: 10px; text-align: left;">
                                                                                            Service Name</th>
                                                                                        <th
                                                                                            style="padding: 10px; text-align: left;">
                                                                                            Message</th>
                                                                                        <th
                                                                                            style="padding: 10px; text-align: left;">
                                                                                            Service Session Purchases
                                                                                        </th>
                                                                                        <th
                                                                                            style="padding: 10px; text-align: left;">
                                                                                            Service Session Redeem</th>
                                                                                    </tr>

                                                                                    @php
                                                                                        $balance = 0; // Initial balance
                                                                                    @endphp

                                                                                    <!-- Loop through each purchase to show credits -->
                                                                                    @foreach ($servicePurchases as $item)
                                                                                        <tr
                                                                                            style="background-color: #f2f2f2;">
                                                                                            <td style="padding: 10px;">
                                                                                                {{ date('m-d-Y', strtotime($item->updated_at)) }}
                                                                                            </td>
                                                                                            <td style="padding: 10px;">
                                                                                                {{ $item->order_id }}
                                                                                            </td>
                                                                                            <td style="padding: 10px;">
                                                                                                {{--  For Product Name --}}
                                                                                                @if($item->service_type == 'product')
                                                                                                {{ $item->product_name }}
                                                                                                @endif
                                                                                                {{--  For Unit Name --}}
                                                                                                @if($item->service_type == 'unit')
                                                                                                {{ $item->unit_name }}
                                                                                                @endif
                                                                                            </td>
                                                                                            <td style="padding: 10px;">
                                                                                                Buy</td>
                                                                                            <td style="padding: 10px;">
                                                                                                {{ $item->number_of_session }}
                                                                                            </td> <!-- Credit -->
                                                                                            <td style="padding: 10px;">
                                                                                                --</td>
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
                                                                                                @if($value->service_type == 'product')
                                                                                             
                                                                                                {{ $value->product_name }}
                                                                                                @endif
                                                                                                {{--  For Unit Name --}}
                                                                                                @if($value->service_type == 'unit')
                                                                                                
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

                                                                                <p>Got a question? Please email to <a
                                                                                        href="mail:info@forevermedspanj.com">info@forevermedspanj.com</a>
                                                                                    or visit the nearest MedSpa Wellness
                                                                                    Center.</p>

                                                                                <table cellspacing="0" cellpadding="0"
                                                                                    style="border-collapse:collapse;width:100%; margin-top: 20px;">
                                                                                    <tr>
                                                                                        <td style="width:1%;padding-right:16px"
                                                                                            valign="top">
                                                                                            <img src="{{url('/images/gifts/logo.png')}}"
                                                                                                width="150"
                                                                                                height="60"
                                                                                                alt=""
                                                                                                style="line-height:100%;border:0 none;outline:none;text-decoration:none;vertical-align:baseline;font-size:0;" onerror="this.onerror=null; this.src='{{url('/No_Image_Available.jpg')}}';">
                                                                                        </td>
                                                                                        <td valign="middle"></td>
                                                                                    </tr>
                                                                                </table>

                                                                                <table style="margin-top: 10px;">
                                                                                    <tr>
                                                                                        <td>Team Forever Medspa</td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>


                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <table cellspacing="0" cellpadding="0"
                                                style="font-family:Open Sans,-apple-system,BlinkMacSystemFont,Roboto,Helvetica Neue,Helvetica,Arial,sans-serif;border-collapse:collapse;width:100%">
                                                <tbody>
                                                    <tr>
                                                        <td
                                                            style="font-family:Open Sans,-apple-system,BlinkMacSystemFont,Roboto,Helvetica Neue,Helvetica,Arial,sans-serif;padding-top:48px;padding-bottom:48px">
                                                            <table cellspacing="0" cellpadding="0"
                                                                style="font-family:Open Sans,-apple-system,BlinkMacSystemFont,Roboto,Helvetica Neue,Helvetica,Arial,sans-serif;border-collapse:collapse;width:100%;color:#9eb0b7;text-align:center;font-size:13px">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="center"
                                                                            style="font-family:Open Sans,-apple-system,BlinkMacSystemFont,Roboto,Helvetica Neue,Helvetica,Arial,sans-serif;padding-bottom:16px">
                                                                            To get the latest updates click on&nbsp;<a
                                                                                href="https://www.facebook.com/ForeverMedSpaNJ/"
                                                                                style="color:#9eb0b7;text-decoration-line:none"
                                                                                target="_blank"
                                                                                data-saferedirecturl="https://www.facebook.com/ForeverMedSpaNJ/"><span
                                                                                    style="text-decoration-line:underline">Facebook</span></a>&nbsp;</a>
                                                                            and <a
                                                                                href="https://p2h9234f.r.ap-south-1.awstrack.me/L0/https:%2F%2Fwww.instagram.com%2FForever Medspa_official%2F/1/0109018ef271a7ff-cf8fd1c8-a19f-4fe9-b381-ec1b5fb3d7b4-000000/jwEVYSgjqs8rqY_NmEARTdpTcko=151"
                                                                                style="color:#9eb0b7;text-decoration-line:none"
                                                                                target="_blank"
                                                                                data-saferedirecturl="https://www.instagram.com/forevermedspa/?igshid=12r8tjjaqsyy6"><span
                                                                                    style="text-decoration-line:underline">Instagram</span></a>.
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td
                                                                            style="font-family:Open Sans,-apple-system,BlinkMacSystemFont,Roboto,Helvetica Neue,Helvetica,Arial,sans-serif;padding-right:24px;padding-left:24px">
                                                                            ⓒ {{ date('Y') }} Forever MedSpa
                                                                            Wellness Center<br><a
                                                                                href="https://forevermedspanj.com/"
                                                                                style="color:#9eb0b7;text-decoration:none"
                                                                                target="_blank"
                                                                                data-saferedirecturl="https://forevermedspanj.com/">Home</a>
                                                                            |
                                                                            <a href="https://myforevermedspa.com/"
                                                                                style="color:#9eb0b7;text-decoration:none"
                                                                                target="_blank"
                                                                                data-saferedirecturl="https://myforevermedspa.com/">Buy
                                                                                Giftcard</a> <br>468 Paterson Ave East
                                                                            Rutherford NJ, 07073
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td
                                                                            style="font-family:Open Sans,-apple-system,BlinkMacSystemFont,Roboto,Helvetica Neue,Helvetica,Arial,sans-serif;padding-top:16px">
                                                                            This is an auto-generated email. Please do
                                                                            not reply.
                                                                            <p>Need assistance? visit our <a
                                                                                    href="https://maps.app.goo.gl/9vrG1mfqvEr1MqVY8"
                                                                                    style="color:#9eb0b7;text-decoration:underline"
                                                                                    target="_blank"
                                                                                    data-saferedirecturl="https://maps.app.goo.gl/9vrG1mfqvEr1MqVY8"><span
                                                                                        style="text-decoration:underline">Forever
                                                                                        MedSpa Wellness
                                                                                        Center</span></a>.</p>
                                                                            <p></p>
                                                                            <hr>
                                                                            <p style="text-align:left">
                                                                                <strong></strong>
                                                                            </p>
                                                                            <p style="text-align:left">
                                                                                <strong>Disclaimer<br></strong>The
                                                                                information contained in this e-mailer
                                                                                has not been prepared taking into
                                                                                account specific
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </center>
        </div>
        <img alt="" src="{{url('/images/gifts/logo.png')}}"
            style="display:none;width:1px;height:1px" class="CToWUd" data-bit="iit">
        <div class="yj6qo"></div>
        <div class="adL"></div>
    </div>
    <div class="adL">
    </div>
</div>
