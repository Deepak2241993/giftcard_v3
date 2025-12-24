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
                            <table id="u_content_heading_3"
                                style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                cellpadding="0" cellspacing="0" width="100%" border="0">
                                <tbody>
                                    <tr>
                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:60px 0px 0px;font-family:arial,helvetica,sans-serif;"
                                            align="left">
                                            <h1 class="v-line-height v-font-size"
                                                style="margin: 0px; color: #ffffff; line-height: 140%; text-align: center; word-wrap: break-word; font-family: Epilogue; font-size: 22px; font-weight: 400;">
                                               {{$template->title}}
                                            </h1>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- Black Section End -->

                            <!-- Black Section Content 2 -->
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
                            <!-- Black Section Content 2 -->

                             

                            <!-- Black Section Image Section -->
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
                        <div
                            style="box-sizing: border-box; height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;">
                            <p
                                style="line-height: 24px; padding: 20px; font-size: 16px; word-wrap: break-word; font-family: arial, helvetica, sans-serif;">
                                {!! str_replace( '[firstname] [lastname]', trim($maildata->fname . ' ' . ($maildata->lname ?? '')), $template->message_email ?? '') !!}
                            </p>
                            <div style="margin: 20px;">
                                {{-- Service Details --}}
                                <div style="width: 100%; overflow-x: auto; margin: 20px 0;">

                                    <table
                                        style="width: 100%; border-collapse: collapse; font-family: arial, helvetica, sans-serif;">
                                        <thead>
                                            <tr>
                                                <th
                                                    style="width: 25%; padding: 10px; font-weight: 600; color: #333; background-color: #f0f0f0; border: 1px solid #ccc;">
                                                    Service
                                                    Name</th>
                                                <th
                                                    style="width: 15%; padding: 10px; font-weight: 600; color: #333; background-color: #f0f0f0; border: 1px solid #ccc;">
                                                    Price</th>
                                                <th
                                                    style="width: 15%; padding: 10px; font-weight: 600; color: #333; background-color: #f0f0f0; border: 1px solid #ccc;">
                                                    Qty</th>
                                                <th
                                                    style="width: 25%; padding: 10px; font-weight: 600; color: #333; background-color: #f0f0f0; border: 1px solid #ccc; text-align: right;">
                                                    Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td
                                                    style="width: 25%; padding: 10px; color: #333; border: 1px solid #ccc;">
                                                    Service Name
                                                </td>

                                                <td
                                                    style="width: 15%; padding: 10px; color: #333; border: 1px solid #ccc;">
                                                    $ 200.00
                                                </td>

                                                <td
                                                    style="width: 15%; padding: 10px; color: #333; border: 1px solid #ccc;">
                                                    3
                                                </td>

                                                <td
                                                    style="width: 25%; padding: 10px; color: #333; border: 1px solid #ccc; text-align: right;">
                                                    60
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <table style="width: 100%; border-collapse: collapse;">
                                    <tbody>
                                        <tr style="background-color: #f0f0f0; border: 1px solid #ccc;">
                                            <td
                                                style="width: 50%; padding: 10px; color: #333; font-weight: bold; border: none;">
                                                Subtotal
                                            </td>
                                            <td
                                                style="width: 50%; text-align: right; padding: 10px; color: #333; font-weight: bold; border: none;">
                                               60
                                            </td>
                                        </tr>
                                        <tr style="background-color: #f0f0f0; border: 1px solid #ccc;">
                                            <td
                                                style="width: 50%; padding: 10px; color: #333; border: none;">
                                                Giftcard
                                                Applied
                                            </td>
                                            <td
                                                style="width: 50%; text-align: right; padding: 10px; color: #d9534f; border: none;">
                                                - $30
                                            </td>
                                        </tr>
                                        <tr style="background-color: #f0f0f0; border: 1px solid #ccc;">
                                            <td
                                                style="width: 50%; padding: 10px; color: #333; border: none;">
                                                Tax <span style="color: #666;">(10%)</span>
                                            </td>
                                            <td
                                                style="width: 50%; text-align: right; padding: 10px; color: #333; border: none;">
                                                +$6
                                            </td>
                                        </tr>
                                        <tr style="background-color: #e0e0e0; border: 1px solid #ccc;">
                                            <td
                                                style="width: 50%; padding: 10px; color: #333; font-weight: bold; font-size: 18px; border-top: none;">
                                                Grand Total
                                            </td>
                                            <td
                                                style="width: 50%; text-align: right; padding: 10px; color: #333; font-weight: bold; font-size: 18px; border-top: none;">
                                                $36
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                {{-- For Terms &amp;
                                Condition --}}
                                <div
                                    style="width: 100%; margin: 20px 0; font-family: Arial, Helvetica, sans-serif;">
                                    <h2 style="margin-bottom: 10px;">Terms
                                        &amp;
                                        Conditions</h2>

                                    

                                    

                                    <table
                                        style="width: 100%; border-collapse: collapse; border: 1px solid #ddd;">
                                        <thead>
                                            <tr>
                                                <th
                                                    style="padding: 10px; background: #f7f7f7; border: 1px solid #ddd; text-align: left;">
                                                    Service
                                                    Name</th>
                                                <th
                                                    style="padding: 10px; background: #f7f7f7; border: 1px solid #ddd; text-align: left;">
                                                    Terms
                                                    &amp;
                                                    Conditions</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td
                                                    style="padding: 10px; border: 1px solid #ddd; width: 35%; line-height: 1.6;">
                                                    <ul style="margin: 0; padding-left: 18px;">
                                                        
                                                        <li style="margin-bottom: 4px;">Service
                                                            Term 1</li>
                                                    </ul>
                                                </td>

                                                <td
                                                    style="padding: 10px; border: 1px solid #ddd; width: 65%; line-height: 1.6;">
                                                    <ul style="margin: 0; padding-left: 18px;">
                                                        
                                                        <li style="margin-bottom: 4px;">Condition
                                                            1</li>
                                                </td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                {{-- End Terms And
                                Conditions --}}
                            </div>

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
