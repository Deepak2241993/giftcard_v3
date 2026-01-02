<!DOCTYPE html>
<html lang="en" style="margin:0; padding:0;">
<head>
    <meta charset="UTF-8">
    <title>Refund Receipt</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f5f7fb;
            font-family: 'Open Sans', Arial, sans-serif;
        }
        .email-wrapper {
            max-width: 650px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #eee;
        }
        .header-bar {
            background: #fca52a;
            color: #fff;
            padding: 30px 20px;
            text-align: center;
            font-size: 26px;
            font-weight: 600;
        }
        .content {
            padding: 35px 40px;
            color: #3c3c3c;
            font-size: 16px;
            line-height: 26px;
        }
        .footer {
            padding: 25px 30px;
            text-align: center;
            font-size: 13px;
            color: #9b9b9b;
            background: #ffffff;
            border-top: 1px solid #eee;
        }
        .btn {
            display: inline-block;
            padding: 12px 25px;
            background: #fca52a;
            color: #ffffff;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            border-radius: 30px;
            margin-top: 20px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }
        .panel {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 6px;
            border: 1px solid #e5e5e5;
            margin: 25px 0;
            font-size: 16px;
        }
        .logo {
            text-align:center;
            padding: 30px 0 10px;
        }
        .logo img {
            width:150px;
            height:auto;
        }
    </style>
</head>

<body>

<br>

<!-- Wrapper -->
<div class="email-wrapper">

    <!-- Logo -->
    <div class="logo">
        <img src="{{ url('/images/gifts/logo.png') }}"
             alt="Forever Medspa"
             onerror="this.src='{{ url('/No_Image_Available.jpg') }}';">
    </div>

    <!-- Header Bar -->
    <div class="header-bar">
        Refund Receipt
    </div>

    <!-- Email Body -->
    <div class="content">
        <p>Dear {{ $refund->customer_name ?? 'Customer' }},</p>

        <p>Your refund has been successfully processed. Below are the details:</p>

        <div class="panel">
            <strong>Refund Amount:</strong> ${{ number_format($refund->amount / 100, 2) }}<br>
            <strong>Refund Reason:</strong> {{ $refund->reason ?? 'N/A' }}<br>
            <strong>Refund Status:</strong> {{ ucfirst($refund->status) }}<br>
            <strong>Payment Intent:</strong> {{ $refund->payment_intent }}<br>
        </div>

        <p>If you have any questions regarding this refund, please feel free to contact us anytime.</p>

        <center>
            <a href="{{ config('app.url') }}" class="btn">Visit Website</a>
        </center>

        <br>
        <p>Warm regards, <br>
            <strong>{{ config('app.name') }} Team</strong>
        </p>
    </div>

    <!-- Footer -->
    <div class="footer">
        © {{ date('Y') }} Forever Medspa Wellness Center. All rights reserved.<br>
        468 Paterson Ave, East Rutherford NJ 07073<br>
        <a href="https://forevermedspanj.com/" style="color:#9b9b9b; text-decoration:none;">forevermedspanj.com</a>
    </div>

</div>

<br>

</body>
</html>
