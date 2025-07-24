@if (isset($mail_data) && $mail_data['send_mail'] == 'yes')
    {!! $mail_data['message'] !!}
@else
    <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="table-layout:fixed">
        <tbody>
            <tr>
                <td align="center" valign="top">
                    <table class="m_1217764301369836700pc-email-container" width="100%" align="center" border="0"
                        cellpadding="0" cellspacing="0" role="presentation" style="margin:0 auto;max-width:620px">
                        <tbody>
                            <tr>
                                <td align="left" valign="top" style="padding:0 10px">
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0"
                                        role="presentation">
                                        <tbody>
                                            <tr>
                                                <td height="20" style="font-size:1px;line-height:1px">&nbsp;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0"
                                        role="presentation">
                                        <tbody>
                                            <tr>
                                                <td valign="top">
                                                    <table border="0" cellpadding="0" cellspacing="0"
                                                        role="presentation" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td class="m_1217764301369836700pc-sm-p-30-10 m_1217764301369836700pc-xs-p-25-0"
                                                                    bgcolor="#ffffff"
                                                                    style="padding:40px 20px;background:#ffffff;border-radius:8px"
                                                                    valign="top">
                                                                    <table border="0" cellpadding="0"
                                                                        cellspacing="0" role="presentation"
                                                                        width="100%">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td bgcolor="#ffffff" valign="middle"
                                                                                    style="padding:0 20px;background-color:#ffffff;font-size:0">
                                                                                    <div class="m_1217764301369836700pc-sm-mw-100pc"
                                                                                        style="width:100%;vertical-align:middle">
                                                                                        <table width="100%"
                                                                                            border="0"
                                                                                            cellpadding="0"
                                                                                            cellspacing="0"
                                                                                            role="presentation">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td valign="top"
                                                                                                        style="padding:0"
                                                                                                        align="left">
                                                                                                        <a href="https://myforevermedspa.com/"
                                                                                                            style="text-decoration:none"
                                                                                                            target="_blank"
                                                                                                            data-saferedirecturl="https://myforevermedspa.com/">
                                                                                                            <img src="{{url('/images/gifts/logo.png')}}"
                                                                                                                width="150"
                                                                                                                height=""
                                                                                                                alt="Forever Medspa"
                                                                                                                style="max-width:100%;height:auto;border:0;line-height:100%;outline:0;font-size:14px;color:#1b1b1b"
                                                                                                                class="CToWUd"
                                                                                                                data-bit="iit" onerror="this.onerror=null; this.src='{{url('/No_Image_Available.jpg')}}';">
                                                                                                        </a>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="line-height:1px;font-size:1px"
                                                                                    height="40">&nbsp;</td>
                                                                            </tr>
                                                                        </tbody>
                                                                        <tbody>
                                                                            <tr>
                                                                                @if (!empty($mail_data->recipient_name))
                                                                                    <td class="m_1217764301369836700pc-sm-fs-30"
                                                                                        style="font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:36px;font-weight:800;line-height:46px;letter-spacing:-0.6px;color:#151515;padding:0 20px;vertical-align:top"
                                                                                        valign="top"
                                                                                        id="m_1217764301369836700intro-title">
                                                                                        You've just been sent a gift
                                                                                        card!</td>
                                                                                @else
                                                                                    <td class="m_1217764301369836700pc-sm-fs-30"
                                                                                        style="font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:36px;font-weight:800;line-height:46px;letter-spacing:-0.6px;color:#151515;padding:0 20px;vertical-align:top"
                                                                                        valign="top"
                                                                                        id="m_1217764301369836700intro-title">
                                                                                        You've just received a gift
                                                                                        card!</td>
                                                                                @endif
                                                                            </tr>

                                                                            <tr>
                                                                                <td style="line-height:1px;font-size:1px"
                                                                                    height="25">&nbsp;</td>
                                                                            </tr>
                                                                        </tbody>
                                                                        <tbody>
                                                                            @if (!empty($mail_data->recipient_name))
                                                                                <tr>
                                                                                    <td class="m_1217764301369836700pc-sm-fs-18 m_1217764301369836700pc-xs-fs-16"
                                                                                        style="font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:18px;line-height:30px;letter-spacing:-0.2px;color:#9b9b9b;padding:0 20px"
                                                                                        valign="top"
                                                                                        id="m_1217764301369836700intro-text">
                                                                                        {{ $mail_data->your_name }} just
                                                                                        sent you {{ $mail_data->qty }} x
                                                                                        ${{ round($mail_data->amount) }}
                                                                                        to use at <a
                                                                                            href="https://myforevermedspa.com/"
                                                                                            target="_blank"
                                                                                            data-saferedirecturl="https://myforevermedspa.com/">Forever
                                                                                            Medspa</a>. on date:
                                                                                        {{ \Carbon\Carbon::parse($mail_data->created_at)->format('m-d-Y') }}
                                                                                    </td>
                                                                                </tr>
                                                                            @else
                                                                                <tr>
                                                                                    <td class="m_1217764301369836700pc-sm-fs-18 m_1217764301369836700pc-xs-fs-16"
                                                                                        style="font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:18px;line-height:30px;letter-spacing:-0.2px;color:#9b9b9b;padding:0 20px"
                                                                                        valign="top"
                                                                                        id="m_1217764301369836700intro-text">
                                                                                        Dear
                                                                                        {{ $mail_data->your_name }},<br>
                                                                                        You have received a gift card
                                                                                        purchase {{ $mail_data->qty }} x
                                                                                        ${{ round(($mail_data->amount)) }}
                                                                                        to use at <a
                                                                                            href="https://myforevermedspa.com/"
                                                                                            target="_blank"
                                                                                            data-saferedirecturl="https://myforevermedspa.com/">Forever
                                                                                            Medspa</a>. on date:
                                                                                        {{ \Carbon\Carbon::parse($mail_data->created_at)->format('m-d-Y') }}
                                                                                    </td>
                                                                                </tr>
                                                                            @endif
                                                                            <tr>
                                                                                <td style="line-height:1px;font-size:1px"
                                                                                    height="25">&nbsp;</td>
                                                                            </tr>
                                                                        </tbody>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="m_1217764301369836700pc-sm-fs-18 m_1217764301369836700pc-xs-fs-16"
                                                                                    style="font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:18px;line-height:30px;letter-spacing:-0.2px;color:#9b9b9b;padding:0 20px"
                                                                                    valign="top">
                                                                                    <div class="m_1217764301369836700pc-sm-mw-100pc"
                                                                                        style="display:inline-block;width:100%;max-width:520px;vertical-align:middle">
                                                                                        <table width="100%"
                                                                                            border="0"
                                                                                            cellpadding="0"
                                                                                            cellspacing="0"
                                                                                            role="presentation">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td valign="top"
                                                                                                        style="font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:36px;font-weight:800;line-height:46px;letter-spacing:-0.6px;color:#151515;padding:0px;vertical-align:top"
                                                                                                        align="left">
                                                                                                        <p>${{ round($mail_data->amount) }}
                                                                                                            Giftcards
                                                                                                        </p>

                                                                                                    </td>
                                                                                                </tr>
                                                                                                @if (!empty($mail_data->recipient_name))
                                                                                                    <tr>
                                                                                                        <td valign="top"
                                                                                                            style="font-family: 'Fira Sans',Roboto,Arial,sans-serif;
                                                                            font-size: 18px;
                                                                            line-height: 30px;
                                                                            letter-spacing: -0.2px;
                                                                            color: #9b9b9b;
                                                                            padding: 0px;"
                                                                                                            align="left">
                                                                                                            <p>For use
                                                                                                                at
                                                                                                                Forever
                                                                                                                Medspa
                                                                                                            </p>
                                                                                                        </td>
                                                                                                    </tr>

                                                                                                    <tr>
                                                                                                        <td valign="top"
                                                                                                            style="font-family: 'Fira Sans',Roboto,Arial,sans-serif;
                                                                            font-size: 18px;
                                                                            line-height: 30px;
                                                                            letter-spacing: -0.2px;
                                                                            color: #9b9b9b;
                                                                            padding: 0px;"
                                                                                                            align="left">
                                                                                                            <span>To
                                                                                                            </span>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td valign="top"
                                                                                                            style="font-family: 'Fira Sans',Roboto,Arial,sans-serif;
                                                                           
                                                                            color: #9b9b9b;"
                                                                                                            align="left">
                                                                                                            <p>{{ $mail_data->recipient_name }}
                                                                                                            </p>
                                                                                                        </td>
                                                                                                    </tr>

                                                                                                    <tr>
                                                                                                        <td valign="top"
                                                                                                            style="font-family: 'Fira Sans',Roboto,Arial,sans-serif;
                                                                              font-size: 18px;
                                                                            line-height: 30px;
                                                                            letter-spacing: -0.2px;
                                                                            color: #9b9b9b;
                                                                            padding: 0px;"
                                                                                                            align="left">
                                                                                                            <span>From
                                                                                                            </span>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td valign="top"
                                                                                                            style="font-family: 'Fira Sans',Roboto,Arial,sans-serif;color: #9b9b9b;"
                                                                                                            align="left">
                                                                                                            <p>{{ $mail_data->your_name }}
                                                                                                            </p>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td valign="top"
                                                                                                            style="font-family: 'Fira Sans',Roboto,Arial,sans-serif;
                                                                            font-size: 15px;
                                                                            line-height: 30px;
                                                                            letter-spacing: -0.2px;
                                                                            color: #9b9b9b;
                                                                            padding: 0px;"
                                                                                                            align="left">
                                                                                                            <h3>Message
                                                                                                            </h3>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td
                                                                                                            valign="top"align="left">
                                                                                                            <p>{{ $mail_data->message }}
                                                                                                            </p>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                @endif
                                                                                            </tbody>

                                                                                        </table>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                            <tr>
                                                                                <td height="20"
                                                                                    style="font-size:1px;line-height:1px">
                                                                                    <hr>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td height="10">
                                                                                    <h3>Giftcards Number</h3>
                                                                                </td>
                                                                            </tr>
                                                                        <tbody>
                                                                            @php
                                                                                $cardnumber = App\Models\GiftcardsNumbers::where(
                                                                                    'transaction_id',
                                                                                    $mail_data->transaction_id,
                                                                                )->get();
                                                                            @endphp
                                                                            @foreach ($cardnumber as $value)
                                                                                <tr>
                                                                                    <td class="m_4043362051198468644pc-sm-fs-18 m_4043362051198468644pc-xs-fs-16"
                                                                                        style="font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:18px;line-height:30px;letter-spacing:-0.2px;color:#9b9b9b;padding:0 0px"
                                                                                        valign="top"
                                                                                        id="m_4043362051198468644intro-text">
                                                                                        <h2>{{ $value->giftnumber }}
                                                                                        </h2>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                            </tr>
                                                        </tbody>
                                                        <tbody>
                                                            <tr>
                                                                <td style="padding:0 20px" valign="top">
                                                                    <table border="0" cellpadding="0"
                                                                        cellspacing="0" role="presentation"
                                                                        width="100%">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td valign="top"
                                                                                    style="padding:0 10px 0 0"
                                                                                    align="center">
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="line-height:1px;font-size:1px"
                                                                    height="10">&nbsp;</td>
                                                            </tr>
                                                        </tbody>
                                                        <tbody>
                                                            <tr>
                                                                <td style="line-height:1px;font-size:1px"
                                                                    height="25">&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="m_1217764301369836700pc-sm-fs-18 m_1217764301369836700pc-xs-fs-16"
                                                                    style="font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:18px;line-height:30px;letter-spacing:-0.2px;color:#9b9b9b;padding:0 20px"
                                                                    valign="top"
                                                                    id="m_1217764301369836700signature">
                                                                    We hope you love Forever Medspa Giftcard...
                                                                    .<br><br>From Forever Medspa<br>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0"
                                        role="presentation">
                                        <tbody>
                                            <tr>
                                                <td height="8" style="font-size:1px;line-height:1px">&nbsp;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                        role="presentation">
                                        <tbody>
                                            <tr>
                                                <td class="m_1217764301369836700pc-sm-p-31-20-39 m_1217764301369836700pc-xs-p-15-10-25"
                                                    style="padding:31px 30px;background-color:#ffffff;border-radius:8px"
                                                    valign="top" bgcolor="#ffffff">
                                                    <table border="0" cellpadding="0" cellspacing="0"
                                                        width="100%" role="presentation">
                                                        <tbody>
                                                            <tr>
                                                                <td valign="top" style="font-size:0">
                                                                    <div class="m_1217764301369836700pc-sm-mw-100pc"
                                                                        style="display:inline-block;width:100%;max-width:445px;vertical-align:top">
                                                                        <table width="100%" border="0"
                                                                            cellpadding="0" cellspacing="0"
                                                                            role="presentation">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td class="m_1217764301369836700pc-xs-p-15-10"
                                                                                        style="line-height:20px;letter-spacing:-0.2px;font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:14px;color:#9b9b9b;padding:0 10px"
                                                                                        valign="top">
                                                                                        © All rights reserved.<br>Sent
                                                                                        by Forever Medspa <a
                                                                                            href="https://myforevermedspa.com/"
                                                                                            target="_blank"
                                                                                            data-saferedirecturl="https://myforevermedspa.com/">Forever
                                                                                            Medspa</a>.
                                                                                        <br>
                                                                                        468 Paterson Ave East Rutherford
                                                                                        NJ, 07073
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="m_1217764301369836700pc-sm-mw-100pc"
                                                                        style="display:inline-block;width:100%;max-width:65px;vertical-align:top">
                                                                        <table width="100%" border="0"
                                                                            cellpadding="0" cellspacing="0"
                                                                            role="presentation">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td valign="top"
                                                                                        style="padding:0 0 10px">
                                                                                        <table border="0"
                                                                                            cellpadding="0"
                                                                                            cellspacing="0"
                                                                                            role="presentation">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td valign="middle"
                                                                                                        style="padding:0 10px">
                                                                                                        <img src="{{url('/images/gifts/logo.png')}}"
                                                                                                            width="80"
                                                                                                            height="40"
                                                                                                            alt="Gift Up!"
                                                                                                            style="border:0;line-height:100%;outline:0;font-size:14px;color:#151515"
                                                                                                            class="CToWUd"
                                                                                                            data-bit="iit" onerror="this.onerror=null; this.src='{{url('/No_Image_Available.jpg')}}';">
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
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
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                        <tbody>
                            <tr>
                                <td height="20" style="font-size:1px;line-height:1px">&nbsp;</td>
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
@endif
