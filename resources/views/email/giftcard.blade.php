@php
    /*
    $mail_data=['qty'=>1,'amount'=>25,'your_name'=>'deepak','recipient_name'=>'','message'=>'test','gift_send_to'=>'deepak@thetemz.com','receipt_email'=>'deepakprasad224@gmail.com','transaction_id'=>'card_1PWvpdHXhy3bfGAtfIzHmifj'];
    $mail_data = (object) $mail_data;
*/

    $cardnumber = App\Models\GiftcardsNumbers::where('transaction_id', $mail_data->transaction_id)->get();
    $template_data = App\Models\EmailTemplate::where('id', $mail_data->event_id)->get();

    // $template_data = App\Models\EmailTemplate::where('id',5)->get();

@endphp





<!DOCTYPE HTML
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
    xmlns:o="urn:schemas-microsoft-com:office:office">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="x-apple-disable-message-reformatting">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title></title>

    <style type="text/css">
        @media only screen and (min-width: 620px) {
            .u-row {
                width: 600px !important;
            }

            .u-row .u-col {
                vertical-align: top;
            }

            .u-row .u-col-100 {
                width: 600px !important;
            }

        }

        @media (max-width: 620px) {
            .u-row-container {
                max-width: 100% !important;
                padding-left: 0px !important;
                padding-right: 0px !important;
            }

            .u-row .u-col {
                min-width: 320px !important;
                max-width: 100% !important;
                display: block !important;
            }

            .u-row {
                width: 100% !important;
            }

            .u-col {
                width: 100% !important;
            }

            .u-col>div {
                margin: 0 auto;
            }
        }

        body {
            margin: 0;
            padding: 0;
        }

        table,
        tr,
        td {
            vertical-align: top;
            border-collapse: collapse;
        }

        p {
            margin: 0;
        }

        .ie-container table,
        .mso-container table {
            table-layout: fixed;
        }

        * {
            line-height: inherit;
        }

        a[x-apple-data-detectors='true'] {
            color: inherit !important;
            text-decoration: none !important;
        }

        @media (max-width: 480px) {
            .hide-mobile {
                max-height: 0px;
                overflow: hidden;
                display: none !important;
            }
        }

        table,
        td {
            color: #000000;
        }

        #u_body a {
            color: #0000ee;
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            #u_content_heading_3 .v-font-size {
                font-size: 20px !important;
            }

            #u_content_heading_4 .v-font-size {
                font-size: 40px !important;
            }

            #u_content_heading_4 .v-line-height {
                line-height: 120% !important;
            }

            #u_content_heading_1 .v-font-size {
                font-size: 20px !important;
            }

            #u_content_text_2 .v-font-size {
                font-size: 14px !important;
            }

            #u_content_text_2 .v-line-height {
                line-height: 130% !important;
            }

            #u_content_heading_2 .v-font-size {
                font-size: 27px !important;
            }

            #u_content_heading_2 .v-line-height {
                line-height: 120% !important;
            }

            #u_content_button_3 .v-size-width {
                width: 68% !important;
            }

            #u_content_button_2 .v-size-width {
                width: 72% !important;
            }

            #u_content_menu_1 .v-padding {
                padding: 5px 25px !important;
            }
        }
    </style>

    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@500&amp;display=swap" rel="stylesheet"
        type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet" type="text/css">
</head>

<body class="clean-body u_body"
    style="margin: 0;padding: 0;-webkit-text-size-adjust: 100%;background-color: #e7e7e7;color: #000000">

    <table id="u_body"
        style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 320px;Margin: 0 auto;background-color: #e7e7e7;width:100%"
        cellpadding="0" cellspacing="0">
        <tbody>
            <tr style="vertical-align: top">
                <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">




                    <div class="u-row-container" style="padding: 0px;background-color: transparent">
                        <div class="u-row"
                            style="margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
                            <div
                                style="border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;">

                                <div class="u-col u-col-100"
                                    style="max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;">
                                    <div style="background-color: #000000;height: 100%;width: 100% !important;">

                                        <div
                                            style="box-sizing: border-box; height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">
                                            <div class="logo" style="background-color:#fca52a; padding:20px;">
                                                <a class="navbar-brand" href="https://myforevermedspa.com"><img
                                                        src="{{ url('/images/gifts/logo.png') }}" alt="image"
                                                        style="height:70px;"></a>
                                            </div>
                                            <table id="u_content_heading_3"
                                                style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                                cellpadding="0" cellspacing="0" width="100%" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:60px 0px 0px;font-family:arial,helvetica,sans-serif;"
                                                            align="left">

                                                            <h1 class="v-line-height v-font-size"
                                                                style="margin: 0px; color: #ffffff; line-height: 140%; text-align: center; word-wrap: break-word; font-family: Epilogue; font-size: 22px; font-weight: 400;">
                                                                Celebrate with Us!</h1>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <table id="u_content_heading_4"
                                                style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                                cellpadding="0" cellspacing="0" width="100%" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:0px;font-family:arial,helvetica,sans-serif;"
                                                            align="left">

                                                            <h1 class="v-line-height v-font-size"
                                                                style="margin: 0px; color: #ffffff; line-height: 140%; text-align: center; word-wrap: break-word; font-family: Epilogue; font-size: 46px; font-weight: 400;">
                                                                A Special Gift</h1>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <table id="u_content_heading_1"
                                                style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                                cellpadding="0" cellspacing="0" width="100%" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:0px;font-family:arial,helvetica,sans-serif;"
                                                            align="left">

                                                            <h1 class="v-line-height v-font-size"
                                                                style="margin: 0px; color: #ffffff; line-height: 140%; text-align: center; word-wrap: break-word; font-family: Epilogue; font-size: 22px; font-weight: 400;">
                                                                @if (!empty($mail_data->recipient_name))
                                                                    {{ 'Received From ' . ucFirst($mail_data->your_name) }}
                                                                    @else{{ 'Just for You' }}
                                                                @endif
                                                            </h1>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>


                                            <table style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                                cellpadding="0" cellspacing="0" width="100%" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:0px;font-family:arial,helvetica,sans-serif;"
                                                            align="left">

                                                            <table width="100%" cellpadding="0" cellspacing="0"
                                                                border="0">
                                                                <tr>
                                                                    <td style="padding-right: 0px;padding-left: 0px;"
                                                                        align="center">

                                                                        <img align="center" border="0"
                                                                            src="@if (!empty($template_data[0]['image'])) {{ $template_data[0]['image'] }}@else{{ url('/email_template/med.png') }} @endif"
                                                                            alt="image" title="image"
                                                                            style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;width: 100%;max-width: 600px;"
                                                                            width="600" />

                                                                    </td>
                                                                </tr>
                                                            </table>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>


                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>





                    <div class="u-row-container" style="padding: 0px;background-color: transparent">
                        <div class="u-row"
                            style="margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
                            <div
                                style="border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;">

                                <div class="u-col u-col-100"
                                    style="max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;">
                                    <div
                                        style="background-color: #ffffff;height: 100%;width: 100% !important;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;">

                                        <div
                                            style="box-sizing: border-box; height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;">

                                            <p
                                                style="line-height: 24px;padding:20px; font-size: 16px; word-wrap: break-word; font-family:arial,helvetica,sans-serif;">
                                                Dear <b>
                                                    @if (!empty($mail_data->recipient_name))
                                                        {{ ucFirst($mail_data->recipient_name) }}
                                                        @else{{ ucFirst($mail_data->your_name) }}
                                                    @endif
                                                </b>,<br>
                                                @if (!empty($template_data[0]['message_email']))
                                                    {{ $template_data[0]['message_email'] }}
                                                @else
                                                    Thank you for choosing My Forever Medspa! We can't wait for you to
                                                    experience relaxation and rejuvenation with your gift card.
                                                @endif
                                            </p>


                                            <table id="u_content_text_2"
                                                style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                                cellpadding="0" cellspacing="0" width="100%" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:40px 10px 10px;font-family:arial,helvetica,sans-serif;"
                                                            align="left">

                                                            <div class="v-line-height v-font-size"
                                                                style="font-size: 14px; line-height: 140%; text-align: center; word-wrap: break-word;">
                                                                <p style="line-height: 130%;">At My Forever MedSpa, we
                                                                    believe that every special occasion deserves to</p>
                                                                <p style="line-height: 130%;">be celebrated in style.
                                                                    Whether it's a birthday, anniversary,</p>
                                                                <p style="line-height: 130%;">or just a "just because"
                                                                    moment, we're here to make it unforgettable. </p>
                                                            </div>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <table id="u_content_heading_2"
                                                style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                                cellpadding="0" cellspacing="0" width="100%" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:30px 0px 0px;font-family:arial,helvetica,sans-serif;"
                                                            align="left">

                                                            <h1 class="v-line-height v-font-size"
                                                                style="margin: 0px; color: #000000; line-height: 140%; text-align: center; word-wrap: break-word; font-family: Epilogue; font-size: 40px; font-weight: 700;">
                                                                Your Exclusive Gift:</h1>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <table style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                                cellpadding="0" cellspacing="0" width="100%" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;"
                                                            align="left">

                                                            <div class="v-line-height v-font-size"
                                                                style="font-size: 16px; line-height: 140%; text-align: center; word-wrap: break-word;">
                                                                @if (!empty($mail_data->recipient_name))
                                                                    <p style="line-height: 140%;padding:20px;">To
                                                                        celebrate this day with you,
                                                                        {{ ucFirst($mail_data->your_name) }} has gifted
                                                                        you a voucher for your next happy session at the
                                                                        My Forever Medspa Wellness Centre.<br>
                                                                        @if (!empty($mail_data->recipient_name))
                                                                            {{ ucFirst($mail_data->your_name) }} sent
                                                                            you {{ $mail_data->qty }} x
                                                                            ${{ round($mail_data->amount) }}

                                                                            gift card to use at <br><a
                                                                                href="https://myforevermedspa.com/"
                                                                                target="_blank"
                                                                                data-saferedirecturl="https://myforevermedspa.com/">Forever
                                                                                Medspa</a>.
                                                                        @else
                                                                            You have received a gift card purchase
                                                                            {{ $mail_data->qty }} x
                                                                            ${{ round($mail_data->amount) }}
                                                                            gift card to use at<br><a
                                                                                href="https://myforevermedspa.com/"
                                                                                target="_blank"
                                                                                data-saferedirecturl="https://myforevermedspa.com/">Forever
                                                                                Medspa</a>.
                                                                        @endif
                                                                    </p>
                                                                @else
                                                                    {{--  For Other Section Sending Gift Message --}}

                                                                    <p style="line-height: 140%;padding:20px;">
                                                                        {{ ucFirst($mail_data->your_name) }}, at My
                                                                        Forever Medspa Wellness Centre we emphasise the
                                                                        value of Self Care and we see that you do too!
                                                                        Lets celebrate this with your exclusively
                                                                        purchased Giftcard for the nex session with My
                                                                        Forever Medspa.
                                                                        <br>
                                                                        {{ ucFirst($mail_data->your_name) }} you are
                                                                        purchased {{ $mail_data->qty }} x
                                                                        ${{ round($mail_data->amount) }}
                                                                        gift card to use at <br><a
                                                                            href="https://myforevermedspa.com/"
                                                                            target="_blank"
                                                                            data-saferedirecturl="https://myforevermedspa.com/">Forever
                                                                            Medspa</a>.
                                                                    </p>
                                                                @endif

                                                            </div>

                                                            {{-- Gift Sender Details Start --}}
                                                            <div class="m_1192176901181685102pc-sm-mw-100pc"
                                                                style="display:inline-block;max-width:280px;width:100%;vertical-align:top;overflow:hidden">
                                                                <table border="0" cellpadding="0" cellspacing="0"
                                                                    role="presentation" width="100%">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="padding:10px 20px"
                                                                                valign="top">
                                                                                <table border="0" cellpadding="0"
                                                                                    cellspacing="0"
                                                                                    role="presentation"
                                                                                    width="100%">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td style="border-bottom:1px solid #e5e5e5;padding:0 0 10px;letter-spacing:-0.2px;line-height:26px;font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:16px;font-weight:bold;color:#151515"
                                                                                                valign="top">Giftcard
                                                                                                Generated By:</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td height="10"
                                                                                                style="font-size:1px;line-height:1px">
                                                                                                &nbsp;</td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td style="letter-spacing:-0.2px;line-height:26px;font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:16px;color:#151515;max-width:260px;overflow:hidden;text-overflow:ellipsis;word-wrap:break-word"
                                                                                                valign="top">
                                                                                                {{ $mail_data->your_name }}

                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            {{-- To Section --}}
                                                            <div class="m_1192176901181685102pc-sm-mw-100pc"
                                                                style="display:inline-block;max-width:280px;width:100%;vertical-align:top;overflow:hidden">
                                                                <table border="0" cellpadding="0" cellspacing="0"
                                                                    role="presentation" width="100%">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="padding:10px 20px"
                                                                                valign="top">
                                                                                <table border="0" cellpadding="0"
                                                                                    cellspacing="0"
                                                                                    role="presentation"
                                                                                    width="100%">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td style="border-bottom:1px solid #e5e5e5;padding:0 0 10px;letter-spacing:-0.2px;line-height:26px;font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:16px;font-weight:bold;color:#151515"
                                                                                                valign="top">Gifted
                                                                                                To</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td height="10"
                                                                                                style="font-size:1px;line-height:1px">
                                                                                                &nbsp;</td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td style="letter-spacing:-0.2px;line-height:26px;font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:16px;color:#151515;max-width:260px;overflow:hidden;text-overflow:ellipsis;word-wrap:break-word"
                                                                                                valign="top">
                                                                                                {{ $mail_data->recipient_name }}

                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                            {{-- Message Section start --}}
                                                            @if (!empty($mail_data->recipient_name))
                                                                <div class="m_1192176901181685102pc-sm-mw-100pc"
                                                                    style="display:inline-block;max-width:600px;width:100%;vertical-align:top">
                                                                    <table border="0" cellpadding="0"
                                                                        cellspacing="0" role="presentation"
                                                                        width="100%">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="padding:10px 20px"
                                                                                    valign="top">
                                                                                    <table border="0"
                                                                                        cellpadding="0"
                                                                                        cellspacing="0"
                                                                                        role="presentation"
                                                                                        width="100%">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td style="border-bottom:1px solid #e5e5e5;padding:0 0 10px;letter-spacing:-0.2px;line-height:26px;font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:16px;font-weight:bold;color:#151515"
                                                                                                    valign="top">
                                                                                                    Message</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td height="10"
                                                                                                    style="font-size:1px;line-height:1px">
                                                                                                    &nbsp;</td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td style="letter-spacing:-0.2px;line-height:26px;font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:16px;color:#151515;max-width:260px;overflow:hidden;text-overflow:ellipsis;word-wrap:break-word;"
                                                                                                    valign="top"
                                                                                                    id="m_1192176901181685102message">
                                                                                                    {{ $mail_data->message }}
                                                                                                </td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            @endif
                                                            {{-- Gift Sender Details End --}}

                                                        </td>
                                                </tbody>
                                            </table>
                                            {{-- for Gift card Hedding --}}
                                            <table id="u_content_heading_2"
                                                style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                                cellpadding="0" cellspacing="0" width="100%" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:30px 0px 0px;font-family:arial,helvetica,sans-serif;"
                                                            align="left">
                                                            <div style="text-align: center; margin-top: 20px;">
                                                                <a href="{{ route('patient-login') }}"
                                                                    target="_blank"
                                                                    style="display: inline-block; background-color: #007bff; color: white; text-decoration: none; 
                                                                           padding: 15px 30px; font-size: 18px; font-weight: bold; border-radius: 5px; 
                                                                           font-family: Arial, sans-serif;">
                                                                    Sign Up to Track Your Giftcards
                                                                </a>
                                                            </div>
                                                            <h1 class="v-line-height v-font-size"
                                                                style="margin: 0px; color: #000000; line-height: 140%; text-align: center; word-wrap: break-word; font-family: Epilogue; font-size: 40px; font-weight: 700;">
                                                                Giftcard Details:
                                                            </h1>

                                                        </td>
                                                    </tr>
                                                    {{-- Gift Card Generate --}}
                                                    <tr>
                                                        <td>
                                                            @foreach ($cardnumber as $value)
                                                                <div class="u-row-container"
                                                                    style="padding: 36px 0px;background-image: url('{{ url('/email_template') }}/giftcards_number_show.png');background-repeat: no-repeat;background-position: center center;background-color: transparent">
                                                                    <div class="u-row"
                                                                        style="margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
                                                                        <div
                                                                            style="border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;">

                                                                            <div class="u-col u-col-100"
                                                                                style="max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;">
                                                                                <div
                                                                                    style="height: 100%;width: 100% !important;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;">

                                                                                    <div
                                                                                        style="box-sizing: border-box; height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;">
                                                                                        <table id="u_content_button_3"
                                                                                            style="font-family:arial,helvetica,sans-serif;"
                                                                                            role="presentation"
                                                                                            cellpadding="0"
                                                                                            cellspacing="0"
                                                                                            width="100%"
                                                                                            border="0">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;"
                                                                                                        align="left">

                                                                                                        <div
                                                                                                            align="center">

                                                                                                            {{-- <a href="#" target="_blank" class="v-button v-size-width v-font-size" style="box-sizing: border-box;display: inline-block;text-decoration: none;-webkit-text-size-adjust: none;text-align: center;color: #FFFFFF; background-color: #fca52a; border-radius: 4px;-webkit-border-radius: 4px; -moz-border-radius: 4px; width:45%; max-width:100%; overflow-wrap: break-word; word-break: break-word; word-wrap:break-word; mso-border-alt: none;font-size: 21px;"> --}}
                                                                                                            <span
                                                                                                                class="v-line-height v-padding v-button v-size-width v-font-size"
                                                                                                                style="display:block;padding:10px 20px;line-height:120%; box-sizing: border-box;display: inline-block;text-decoration: none;-webkit-text-size-adjust: none;text-align: center;color: #FFFFFF; background-color: #fca52a; border-radius: 4px;-webkit-border-radius: 4px; -moz-border-radius: 4px; width:45%; max-width:100%; overflow-wrap: break-word; word-break: break-word; word-wrap:break-word; mso-border-alt: none;font-size: 21px;"><span
                                                                                                                    style="line-height: 25.2px;">{{ $value->giftnumber }}</span></span>
                                                                                                            {{-- </a> --}}
                                                                                                        </div>

                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                    {{-- Gift Card Generate end --}}
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:20px 50px 10px;font-family:arial,helvetica,sans-serif;"
                                                            align="left">

                                                            <div class="v-line-height v-font-size"
                                                                style="font-size: 14px; color: #000000; line-height: 140%; text-align: center; word-wrap: break-word;">
                                                                <p style="font-size: 14px; line-height: 140%;">
                                                                    @if (!empty($template_data[0]['footer_message']))
                                                                        {{ $template_data[0]['footer_message'] }}
                                                                    @else
                                                                        Happy Shopping!
                                                                    @endif

                                                                </p>
                                                            </div>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:10px 10px 60px;font-family:arial,helvetica,sans-serif;"
                                                            align="left">

                                                            <div align="center">
                                                                <div style="display: table; max-width:187px;">

                                                                    <table align="left" border="0"
                                                                        cellspacing="0" cellpadding="0"
                                                                        width="32" height="32"
                                                                        style="width: 32px !important;height: 32px !important;display: inline-block;border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;margin-right: 15px">
                                                                        <tbody>
                                                                            <tr style="vertical-align: top">
                                                                                <td align="left" valign="middle"
                                                                                    style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">
                                                                                    <a href="https://www.facebook.com/ForeverMedSpaNJ/"
                                                                                        title="Facebook"
                                                                                        target="_blank">
                                                                                        <img src="{{ url('/') }}/email_template/facebook.png"
                                                                                            alt="Facebook"
                                                                                            title="Facebook"
                                                                                            width="32"
                                                                                            style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: none;height: auto;float: none;max-width: 32px !important"
                                                                                            onerror="this.onerror=null; this.src='{{ url('/No_Image_Available.jpg') }}';">
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>

                                                                    <table align="left" border="0"
                                                                        cellspacing="0" cellpadding="0"
                                                                        width="32" height="32"
                                                                        style="width: 32px !important;height: 32px !important;display: inline-block;border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;margin-right: 15px">
                                                                        <tbody>
                                                                            <tr style="vertical-align: top">
                                                                                <td align="left" valign="middle"
                                                                                    style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">
                                                                                    <a href="https://x.com/ForeverMedSpaNJ"
                                                                                        title="Twitter"
                                                                                        target="_blank">
                                                                                        <img src="{{ url('/') }}/email_template/twitter.png"
                                                                                            alt="Twitter"
                                                                                            title="Twitter"
                                                                                            width="32"
                                                                                            style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: none;height: auto;float: none;max-width: 32px !important"
                                                                                            onerror="this.onerror=null; this.src='{{ url('/No_Image_Available.jpg') }}';">
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>



                                                                    <table align="left" border="0"
                                                                        cellspacing="0" cellpadding="0"
                                                                        width="32" height="32"
                                                                        style="width: 32px !important;height: 32px !important;display: inline-block;border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;margin-right: 0px">
                                                                        <tbody>
                                                                            <tr style="vertical-align: top">
                                                                                <td align="left" valign="middle"
                                                                                    style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">
                                                                                    <a href="https://www.instagram.com/forevermedspa/?hl=en"
                                                                                        title="Instagram"
                                                                                        target="_blank">
                                                                                        <img src="{{ url('/') }}/email_template/instagram.png"
                                                                                            alt="Instagram"
                                                                                            title="Instagram"
                                                                                            width="32"
                                                                                            style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: none;height: auto;float: none;max-width: 32px !important"
                                                                                            onerror="this.onerror=null; this.src='{{ url('/No_Image_Available.jpg') }}';">
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>

                                                                </div>
                                                            </div>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            {{-- for Gift card Hedding --}}
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="u-row-container" style="padding: 5px 0px 0px;background-color: transparent">
                        <div class="u-row"
                            style="margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
                            <div
                                style="border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;">

                                <div class="u-col u-col-100"
                                    style="max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;">
                                    <div
                                        style="background-color: #fca52a;height: 100%;width: 100% !important;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;">
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div
                                            style="box-sizing: border-box; height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;">
                                            <!--<![endif]-->

                                            <table style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                                cellpadding="0" cellspacing="0" width="100%" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:60px 50px 20px;font-family:arial,helvetica,sans-serif;"
                                                            align="left">

                                                            <div class="v-line-height v-font-size"
                                                                style="font-size: 14px; color: #ffffff; line-height: 140%; text-align: center; word-wrap: break-word;">
                                                                <p style="font-size: 18px; line-height: 140%;">Forever
                                                                    Medspa Forever Medspa.<br>
                                                                    468 Paterson Ave East Rutherford NJ, 07073<br>
                                                                    ©{{ date('Y') }} All rights reserved. </p>
                                                            </div>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <table style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                                cellpadding="0" cellspacing="0" width="100%" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:10px 0px 0px;font-family:arial,helvetica,sans-serif;"
                                                            align="left">

                                                            <table height="0px" align="center" border="0"
                                                                cellpadding="0" cellspacing="0" width="100%"
                                                                style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 1px solid #000000;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                                                <tbody>
                                                                    <tr style="vertical-align: top">
                                                                        <td
                                                                            style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;font-size: 0px;line-height: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                                                            <span>&#160;</span>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>






                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

</body>

</html>
