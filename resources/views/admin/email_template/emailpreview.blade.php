@extends('layouts.admin_layout')

@section('body')

<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office">

<head></head>

<body class="clean-body u_body"
style="margin: 0;padding: 0;-webkit-text-size-adjust: 100%;background-color: #e7e7e7;color: #000000">


<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="x-apple-disable-message-reformatting">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<table id="u_body"
style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 320px;Margin: 0 auto;background-color: #e7e7e7;width:100%"
cellpadding="0" cellspacing="0">
<tbody>
<tr style="vertical-align: top">
<td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">

    <!-- Header Section -->
    <div class="u-row-container" style="padding: 0px;background-color: transparent">
        <div class="u-row"
            style="margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
            <div
                style="border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;">
                <div class="u-col u-col-100"
                    style="max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;">
                    <div style="background-color: #000000;height: 100%;width: 100% !important;">
                        <div style="box-sizing: border-box; height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">
                            <div class="logo" style="background-color:#fca52a; padding:20px;">
                                <a class="navbar-brand" href="https://myforevermedspa.com"><img
                                        src="{{$template->logo}}" alt="image"
                                        style="height:70px;"></a>
                            </div>
                            <!-- Header Black Section -->
                            @if($template->title)
                            <table id="u_content_heading_3"
                                style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                cellpadding="0" cellspacing="0" width="100%" border="0">
                                <tbody>
                                    <tr>
                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:60px 0px 0px;font-family:arial,helvetica,sans-serif;"
                                            align="left">
                                            <h1 class="v-line-height v-font-size"
                                                style="margin: 0px; color: #ffffff; line-height: 140%; text-align: center; word-wrap: break-word; font-family: Epilogue; font-size: 22px; font-weight: 400;">
                                               {!! $template->title !!}
                                            </h1>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            @endif
                            <!-- Black Section End -->

                            <!-- Black Section Content 2 -->
                            @if($template->secondtitle)
                            <table id="u_content_heading_4"
                                style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                cellpadding="0" cellspacing="0" width="100%" border="0">
                                <tbody>
                                    <tr>
                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:0px;font-family:arial,helvetica,sans-serif;"
                                            align="left">
                                            <h1 class="v-line-height v-font-size"
                                                style="margin: 0px; color: #ffffff; line-height: 140%; text-align: center; word-wrap: break-word; font-family: Epilogue; font-size: 46px; font-weight: 400;">
                                                {{$template->secondtitle}}
                                            </h1>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            @endif()
                            <!-- Black Section Content 2 -->

                             

                            <!-- Black Section Image Section -->
                            @if($template->header_image)
                            <table style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                cellpadding="0" cellspacing="0" width="100%" border="0">
                                <tbody>
                                    <tr>
                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:0px;font-family:arial,helvetica,sans-serif;"
                                            align="left">
                                            <table width="100%" cellpadding="0" cellspacing="0"
                                                border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="padding-right: 0px;padding-left: 0px;"
                                                            align="center">
                                                            <img align="center" border="0"
                                                                src=" {{$template->header_image}}"
                                                                alt="image" title="image"
                                                                style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;width: 100%;max-width: 600px;"
                                                                width="600">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            @endif()
                            <!-- Black Image Section End  -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header Section -->

    <!-- Body Section -->
    <div class="u-row-container" style="padding: 0px;background-color: transparent">
        <div class="u-row"
            style="margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
            <div
                style="border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;">
                <div class="u-col u-col-100"
                    style="max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;">
                    <div
                        style="background-color: #ffffff;height: 100%;width: 100% !important;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;">
                        <div style="box-sizing: border-box; height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;">
                            <p
                                style="line-height: 24px; padding: 20px; font-size: 16px; word-wrap: break-word; font-family: arial, helvetica, sans-serif;">
                                {!! str_replace( '[firstname] [lastname]', trim($maildata->fname . ' ' . ($maildata->lname ?? '')), $template->message_email ?? '') !!}
                            </p>

                            {{-- For Additional Services --}}
                             @switch($template->id)

                            @case(1)
                                @include('email.include.servicePurchase')
                                @break

                            @case(2)
                                @include('email.include.serviceRedeem')
                                @break
                            @case(3)
                                @include('email.include.dealCancel')
                                @break
                            @case(4)
                                @include('email.include.refundReceipt')
                                @break
                            @case(5)
                                @include('email.include.emailVerify')
                                @break
                            @case(6)
                                @include('email.include.registration')
                                @break
                            @case(7)
                                @include('email.include.forgetpassword')
                                @break
                            @default
                                {{-- intentionally empty --}}
                            @endswitch

                            <hr>
                            <table id="u_content_text_2" style="font-family:arial,helvetica,sans-serif;"
                                role="presentation" cellpadding="0" cellspacing="0" width="100%"
                                border="0">
                                
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Body Section -->

    <!-- Social Media Section -->
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
                            <table id="u_content_button_2"
                                style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                cellpadding="0" cellspacing="0" width="100%" border="0">
                                <tbody>
                                    <tr>
                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:30px 10px;font-family:arial,helvetica,sans-serif;"
                                            align="left">
                                            <div align="center">
                                                {{-- Footer
                                                start --}}
                                                <table style="font-family:arial,helvetica,sans-serif;"
                                                    role="presentation" cellpadding="0" cellspacing="0"
                                                    width="100%" border="0">
                                                    <tbody>
                                                        <tr>
                                                            <td style="overflow-wrap:break-word;word-break:break-word;padding:20px 50px 10px;font-family:arial,helvetica,sans-serif;"
                                                                align="left">
                                                                <div class="v-line-height v-font-size"
                                                                    style="font-size: 14px; color: #000000; line-height: 140%; text-align: center; word-wrap: break-word;">
                                                                    <p
                                                                        style="font-size: 14px; line-height: 140%;">
                                                                        
                                                                       {!! $template->social_message !!}
                                                                    </p>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table style="font-family:arial,helvetica,sans-serif;"
                                                    role="presentation" cellpadding="0" cellspacing="0"
                                                    width="100%" border="0">
                                                    <tbody>
                                                        <tr>
                                                            <td style="overflow-wrap:break-word;word-break:break-word;padding:10px 10px 60px;font-family:arial,helvetica,sans-serif;"
                                                                align="left">
                                                                <div align="center">
                                                                    <div style="display: table; max-width:187px;">
                                                                        
                                                                        <table align="left" border="0"
                                                                            cellspacing="0"
                                                                            cellpadding="0" width="32"
                                                                            height="32"
                                                                            style="width: 32px !important;height: 32px !important;display: inline-block;border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;margin-right: 15px">
                                                                            <tbody>
                                                                                <tr
                                                                                    style="vertical-align: top">
                                                                                    <td align="left"
                                                                                        valign="middle"
                                                                                        style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">
                                                                                        <a href="{{ $template->social_media_1_url }}"
                                                                                            title="Website"
                                                                                            target="_blank">
                                                                                            <img src={{ $template->social_media_1 }} width="32" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: none;height: auto;float: none;max-width: 32px !important" onerror="this.onerror=null; this.src='{{url('/No_Image_Available.jpg')}}';">
                                                                                        </a>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>

                                                                        <table align="left" border="0"
                                                                            cellspacing="0"
                                                                            cellpadding="0" width="32"
                                                                            height="32"
                                                                            style="width: 32px !important;height: 32px !important;display: inline-block;border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;margin-right: 15px">
                                                                            <tbody>
                                                                                <tr
                                                                                    style="vertical-align: top">
                                                                                    <td align="left"
                                                                                        valign="middle"
                                                                                        style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">
                                                                                        <a href="{{ $template->social_media_2_url }}"
                                                                                            title="Facebook"
                                                                                            target="_blank">
                                                                                            <img src="{{ $template->social_media_2 }}"
                                                                                                alt="Facebook"
                                                                                                title="Facebook"
                                                                                                width="32"
                                                                                                style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: none;height: auto;float: none;max-width: 32px !important"
                                                                                                onerror="this.onerror=null; this.src='{{url('/No_Image_Available.jpg')}}';">
                                                                                        </a>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>

                                                                        <table align="left" border="0"
                                                                            cellspacing="0"
                                                                            cellpadding="0" width="32"
                                                                            height="32"
                                                                            style="width: 32px !important;height: 32px !important;display: inline-block;border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;margin-right: 15px">
                                                                            <tbody>
                                                                                <tr
                                                                                    style="vertical-align: top">
                                                                                    <td align="left"
                                                                                        valign="middle"
                                                                                        style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">
                                                                                        <a href="{{ $template->social_media_3_url }}"
                                                                                            title="Twitter"
                                                                                            target="_blank">
                                                                                            <img src="{{ $template->social_media_3 }}"
                                                                                                alt="Twitter"
                                                                                                title="Twitter"
                                                                                                width="32"
                                                                                                style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: none;height: auto;float: none;max-width: 32px !important"
                                                                                                onerror="this.onerror=null; this.src='{{url('/No_Image_Available.jpg')}}';">
                                                                                        </a>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>

                                                                        <table align="left" border="0"
                                                                            cellspacing="0"
                                                                            cellpadding="0" width="32"
                                                                            height="32"
                                                                            style="width: 32px !important;height: 32px !important;display: inline-block;border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;margin-right: 0px">
                                                                            <tbody>
                                                                                <tr
                                                                                    style="vertical-align: top">
                                                                                    <td align="left"
                                                                                        valign="middle"
                                                                                        style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">
                                                                                        <a href="{{ $template->social_media_4_url }}"
                                                                                            title="Instagram"
                                                                                            target="_blank">
                                                                                            <img src="{{ $template->social_media_4 }}"
                                                                                                alt="Instagram"
                                                                                                title="Instagram"
                                                                                                width="32"
                                                                                                style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: none;height: auto;float: none;max-width: 32px !important"
                                                                                                onerror="this.onerror=null; this.src='{{url('/No_Image_Available.jpg')}}';">
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
                                                <p> {!! $template->footer_message !!}</p>
                                                {{-- Footer end --}}
                                                <p>
                                                    <a href="{{ $template->button_link }}"
                                                        target="_blank" style="display:inline-block; padding:12px 28px; background:#fca52a; color:#ffffff; font-family:Arial, sans-serif; font-size:16px; font-weight:600; text-decoration:none; border-radius:30px; box-shadow:0 4px 10px rgba(0,0,0,0.2); letter-spacing:0.5px; margin-top:20px;"> {{ $template->button_text }}
                                                    </a>
                                                </p>

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
    <!-- Social Media Section End -->

    <!-- Footer Section -->
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
                                                <p style="font-size: 18px; line-height: 140%;">
                                                    {{ $template->footer_contact }}
                                                </p>
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
                                                            <span>&nbsp;</span>
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
    <!-- Footer Section End -->
    
</td>
</tr>
</tbody>
</table>

{{-- {{dd($maildata)}} --}}
</body>

</html>

@endsection

