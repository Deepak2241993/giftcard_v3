{{-- @php
$code=collect(str_split($mail_data[0]['code'], 4))->implode(' ');
$from=$mail_data[0]['from'];
$msg=$mail_data[0]['msg'];
$to=$mail_data[0]['to'];
$amount=$mail_data[0]['amount'];
$from_name=$mail_data[0]['from_name'];
$to_name=$mail_data[0]['to_name'];
if(isset($mail_data['html_code']))
{
$string=$mail_data['html_code'];
$search = array("['from']", "['msg']", "['to']","['amount']","['from_name']","['code']","['to_name']");
$replace = array("$from", "$msg", "$to","$amount","$from_name","$code","$to_name");
$newString = str_replace($search, $replace, $string);
}
@endphp
@if (isset($string))
{!! $newString !!}
@else --}}

@php
    $patient = App\Models\Patient::where('patient_login_id', $mail_data->gift_send_to)->first();
@endphp

<table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="table-layout:fixed;background-color:#f5f7fb;margin:0;padding:20px 0;">
    <tr>
        <td align="center" valign="top">
            <!-- Outer Container -->
            <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="max-width:620px;margin:0 auto;">
                <tr>
                    <td align="left" valign="top" style="padding:0 10px;">

                        <!-- Top Spacer -->
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                            <tr>
                                <td height="20" style="font-size:1px;line-height:1px;">&nbsp;</td>
                            </tr>
                        </table>

                        <!-- Main Card -->
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#ffffff;border-radius:8px;overflow:hidden;">
                            <tr>
                                <td style="padding:0;">

                                    <!-- Header with Logo -->
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#ffffff;padding:20px 24px 0 24px;">
                                        <tr>
                                            <td align="left" valign="middle">
                                                <a href="https://forevermedspanj.com/" style="text-decoration:none;" target="_blank">
                                                    <img src="{{ url('/images/gifts/logo.png') }}"
                                                         width="150"
                                                         alt="Forever Medspa"
                                                         style="max-width:100%;height:auto;border:0;display:block;line-height:100%;outline:0;font-size:14px;color:#1b1b1b;"
                                                         onerror="this.onerror=null; this.src='{{ url('/No_Image_Available.jpg') }}';">
                                                </a>
                                            </td>
                                        </tr>
                                    </table>

                                    <!-- Big Title / Intro -->
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="padding:24px 24px 10px 24px;">
                                        <tr>
                                            <td style="font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:30px;font-weight:800;line-height:40px;letter-spacing:-0.6px;color:#151515;">
                                                Thank you for your order
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="16" style="font-size:1px;line-height:1px;">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:16px;line-height:26px;letter-spacing:-0.2px;color:#6b6b6b;">
                                                We really appreciate you purchasing this gift card and hope that the recipient loves it!<br><br>
                                                <img src="{{ url('/images/gifts/logo.png') }}"
                                                     width="100"
                                                     height="50"
                                                     alt="Forever Medspa"
                                                     style="border:0;line-height:100%;outline:0;font-size:14px;color:#151515;"
                                                     onerror="this.onerror=null; this.src='{{ url('/No_Image_Available.jpg') }}';"><br><br>
                                                From: <strong>Forever Medspa</strong>
                                            </td>
                                        </tr>
                                    </table>

                                    <!-- Two-Column: Generated By / Gifted To -->
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="padding:10px 24px 0 24px;">
                                        <tr>
                                            <!-- Col 1 -->
                                            <td valign="top" width="50%" style="padding:10px 10px 10px 0;">
                                                <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                                                    <tr>
                                                        <td style="border-bottom:1px solid #e5e5e5;padding:0 0 8px;font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:16px;font-weight:bold;color:#151515;">
                                                            Giftcard Generated By
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td height="8" style="font-size:1px;line-height:1px;">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:16px;line-height:24px;color:#151515;max-width:260px;word-wrap:break-word;">
                                                            {{ $mail_data->your_name }}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>

                                            <!-- Col 2 -->
                                            <td valign="top" width="50%" style="padding:10px 0 10px 10px;">
                                                <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                                                    <tr>
                                                        <td style="border-bottom:1px solid #e5e5e5;padding:0 0 8px;font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:16px;font-weight:bold;color:#151515;">
                                                            Gifted To
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td height="8" style="font-size:1px;line-height:1px;">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:16px;line-height:24px;color:#151515;max-width:260px;word-wrap:break-word;">
                                                            {{ $mail_data->recipient_name }}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>

                                    <!-- Two-Column: Message / Shipping -->
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="padding:0 24px;">
                                        <tr>
                                            <!-- Message -->
                                            <td valign="top" width="50%" style="padding:10px 10px 10px 0;">
                                                <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                                                    <tr>
                                                        <td style="border-bottom:1px solid #e5e5e5;padding:0 0 8px;font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:16px;font-weight:bold;color:#151515;">
                                                            Message
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td height="8" style="font-size:1px;line-height:1px;">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:16px;line-height:24px;color:#151515;white-space:pre-wrap;word-wrap:break-word;">
                                                            {{ $mail_data->message }}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>

                                            <!-- Shipping -->
                                            <td valign="top" width="50%" style="padding:10px 0 10px 10px;">
                                                <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                                                    <tr>
                                                        <td style="border-bottom:1px solid #e5e5e5;padding:0 0 8px;font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:16px;font-weight:bold;color:#151515;">
                                                            Shipping
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td height="8" style="font-size:1px;line-height:1px;">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:16px;line-height:24px;color:#151515;word-wrap:break-word;">
                                                            The gift card will be sent to
                                                            <strong>{{ $patient->email ?? $mail_data->gift_send_to }}</strong>,
                                                            addressed to <strong>{{ $mail_data->recipient_name }}</strong>.
                                                            {{-- <a href="https://beta.download.yourgift.cards/download-zip/order/pdf/7f0a841a-2f15-4527-cc0c-08dc2f769b14" style="color:#333333" id="m_1192176901181685102primary-button" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://beta.download.yourgift.cards/download-zip/order/pdf/7f0a841a-2f15-4527-cc0c-08dc2f769b14&amp;source=gmail&amp;ust=1708259681213000&amp;usg=AOvVaw0HIVajL0nNOSHNcYre8BAy">download now</a>) --}}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>

                                    <!-- Spacer -->
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                                        <tr>
                                            <td height="20" style="font-size:1px;line-height:1px;">&nbsp;</td>
                                        </tr>
                                    </table>

                                    <!-- Order Summary -->
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="padding:0 24px 24px 24px;">
                                        <tr>
                                            <td valign="top">
                                                <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                                                    <tr>
                                                        <th align="left" style="font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:16px;color:#151515;padding:10px 10px 10px 0;border-bottom:1px solid #e5e5e5;">
                                                            Item
                                                        </th>
                                                        <th align="right" style="font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:16px;color:#151515;padding:10px 10px 10px 0;border-bottom:1px solid #e5e5e5;">
                                                            Qty
                                                        </th>
                                                        <th align="right" style="font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:16px;color:#151515;padding:10px 0 10px 0;border-bottom:1px solid #e5e5e5;">
                                                            Amount
                                                        </th>
                                                    </tr>

                                                    <!-- Line Item -->
                                                    <tr>
                                                        <td valign="top" style="padding:16px 10px 16px 0;border-bottom:1px solid #e5e5e5;">
                                                            <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                                                                <tr>
                                                                    <td style="font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:18px;font-weight:500;color:#151515;line-height:26px;">
                                                                        ${{ $mail_data->amount }} gift card
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="4" style="font-size:1px;line-height:1px;">&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:14px;line-height:22px;color:#9b9b9b;">
                                                                        For use at Forever Medspa
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td valign="top" align="right" style="padding:16px 10px 16px 0;border-bottom:1px solid #e5e5e5;font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:16px;color:#9b9b9b;">
                                                            {{ $mail_data->qty }}
                                                        </td>
                                                        <td valign="top" align="right" style="padding:16px 0 16px 0;border-bottom:1px solid #e5e5e5;font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:16px;color:#151515;">
                                                            ${{ $mail_data->amount }}
                                                        </td>
                                                    </tr>

                                                    @if ($mail_data->discount != '' && $mail_data->discount != null)
                                                        <tr>
                                                            <td colspan="3" height="12" style="font-size:1px;line-height:1px;">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" align="right" style="font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:16px;color:#40be65;padding:0 10px 0 0;">
                                                                Discount:
                                                            </td>
                                                            <td align="right" style="font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:16px;color:#40be65;">
                                                                -{{ $mail_data->discount }}
                                                            </td>
                                                        </tr>
                                                    @endif

                                                    <tr>
                                                        <td colspan="3" height="16" style="font-size:1px;line-height:1px;">&nbsp;</td>
                                                    </tr>

                                                    <!-- Total -->
                                                    <tr>
                                                        <td colspan="3" align="right" style="padding-top:16px;border-top:2px solid #e5e5e5;font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:22px;font-weight:bold;line-height:30px;color:#151515;">
                                                            Total: ${{ $mail_data->transaction_amount }}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>

                                    <!-- Help / Phone -->
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="padding:0 24px 24px 24px;">
                                        <tr>
                                            <td style="font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:14px;line-height:22px;color:#6b6b6b;">
                                                Have questions? Call or text us at
                                                <a href="tel:+12013404809" style="color:#fca52a;text-decoration:none;">(201)&nbsp;340-4809</a>
                                                and our team will be happy to assist you.
                                            </td>
                                        </tr>
                                    </table>

                                </td>
                            </tr>
                        </table>

                        <!-- Spacer Before Footer Card -->
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                            <tr>
                                <td height="8" style="font-size:1px;line-height:1px;">&nbsp;</td>
                            </tr>
                        </table>

                        <!-- Footer Card -->
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background-color:#ffffff;border-radius:8px;">
                            <tr>
                                <td valign="top" style="padding:24px 24px 20px 24px;">

                                    <!-- Footer Text -->
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                                        <tr>
                                            <td style="font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:14px;line-height:22px;color:#9b9b9b;">
                                                © All rights reserved.<br>
                                                Sent by Forever Medspa on behalf of <a style="color:#fca52a;text-decoration:none;">Forever Medspa</a>.<br>
                                                <a href="https://forevermedspanj.com/" target="_blank" style="color:#fca52a;text-decoration:none;">
                                                    https://www.forevermedspanj.com/
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="20" style="font-size:1px;line-height:1px;">&nbsp;</td>
                                        </tr>
                                    </table>

                                    <!-- CTA Buttons + Small Logo -->
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                                        <tr>
                                            <td align="center" valign="top">
                                                <!-- CTA 1 -->
                                                <a href="{{ route('patient-login') }}"
                                                   target="_blank"
                                                   style="
                                                       display:inline-block;
                                                       background-color:#fca52a;
                                                       color:#ffffff;
                                                       text-decoration:none;
                                                       padding:12px 26px;
                                                       font-size:16px;
                                                       font-weight:bold;
                                                       border-radius:30px;
                                                       font-family:Arial, sans-serif;
                                                       letter-spacing:0.3px;
                                                       margin-bottom:12px;
                                                   ">
                                                    Sign Up to Track Your Giftcards
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="top">
                                                <!-- CTA 2 -->
                                                <a href="https://forevermedspanj.com/services/book-appointments/"
                                                   target="_blank"
                                                   style="
                                                       display:inline-block;
                                                       padding:12px 28px;
                                                       background:#fca52a;
                                                       color:#ffffff;
                                                       font-family:Arial, sans-serif;
                                                       font-size:16px;
                                                       font-weight:600;
                                                       text-decoration:none;
                                                       border-radius:30px;
                                                       box-shadow:0 4px 10px rgba(0,0,0,0.15);
                                                       letter-spacing:0.5px;
                                                       margin-top:8px;
                                                   ">
                                                    Book your Appointment
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="20" style="font-size:1px;line-height:1px;">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td align="left" valign="top">
                                                <img src="{{ url('/images/gifts/logo.png') }}"
                                                     width="80"
                                                     height="40"
                                                     alt="Forever Medspa"
                                                     style="border:0;line-height:100%;outline:0;font-size:14px;color:#151515;"
                                                     onerror="this.onerror=null; this.src='{{ url('/No_Image_Available.jpg') }}';">
                                            </td>
                                        </tr>
                                    </table>

                                </td>
                            </tr>
                        </table>

                        <!-- Bottom Spacer -->
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                            <tr>
                                <td height="20" style="font-size:1px;line-height:1px;">&nbsp;</td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

{{-- @endif --}}
