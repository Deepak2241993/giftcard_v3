<div style="line-height: 24px; padding: 20px; font-size: 16px; word-wrap: break-word; font-family: arial, helvetica, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" role="presentation"
       style="margin-top:20px;border-collapse:collapse;
              font-family:Arial,Helvetica,sans-serif;
              font-size:14px;color:#333333;">

    <!-- TABLE HEADER -->
    <tr style="background-color:#fca52a;color:#ffffff;">
        <th style="padding:12px 10px;text-align:center;font-weight:600;border:1px solid #f0a020;">
            #
        </th>
        <th style="padding:12px 10px;text-align:left;font-weight:600;border:1px solid #f0a020;">
            Transaction No
        </th>
        <th style="padding:12px 10px;text-align:left;font-weight:600;border:1px solid #f0a020;">
            Gift Card No
        </th>
        <th style="padding:12px 10px;text-align:left;font-weight:600;border:1px solid #f0a020;">
            Date
        </th>
        <th style="padding:12px 10px;text-align:left;font-weight:600;border:1px solid #f0a020;">
            Message
        </th>
        <th style="padding:12px 10px;text-align:right;font-weight:600;border:1px solid #f0a020;">
            Amount
        </th>
    </tr>

    <!-- TABLE BODY -->
    @foreach ($maildata->result as $key => $item)
        <tr style="background-color:{{ $key % 2 == 0 ? '#ffffff' : '#fafafa' }};">
            <td style="padding:10px;text-align:center;border:1px solid #dddddd;">
                {{ $key + 1 }}
            </td>
            <td style="padding:10px;border:1px solid #dddddd;word-break:break-word;">
                {{ $item['transaction_id'] }}
            </td>
            <td style="padding:10px;border:1px solid #dddddd;font-weight:600;">
                {{ $item['giftnumber'] }}
            </td>
            <td style="padding:10px;border:1px solid #dddddd;white-space:nowrap;">
                {{ date('d M Y', strtotime($item['updated_at'])) }}
            </td>
            <td style="padding:10px;border:1px solid #dddddd;color:#555555;">
                {{ $item['comments'] }}
            </td>
            <td style="padding:10px;text-align:right;border:1px solid #dddddd;font-weight:600;">
                {{ number_format($item['actual_paid_amount'] ?? 0, 2) }}
            </td>
        </tr>
    @endforeach
</table>
</div>
