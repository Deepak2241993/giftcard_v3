<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 10px 0;
            border-bottom: 1px solid #dddddd;
        }
        .header h1 {
            margin: 0;
            color: #007bff;
        }
        .content {
            padding: 20px 0;
        }
        .content h2 {
            color: #007bff;
        }
        .invoice-details {
            margin-bottom: 20px;
        }
        .invoice-details th, .invoice-details td {
            text-align: left;
            padding: 5px 0;
        }
        .invoice-details th {
            width: 150px;
            color: #555555;
        }
        .footer {
            text-align: center;
            padding: 10px 0;
            border-top: 1px solid #dddddd;
            color: #555555;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Invoice</h1>
        </div>
        <div class="content">
            <h2>Thank you for your purchase!</h2>
            <p>Dear {{customer_name}},</p>
            <p>We appreciate your business. Here are the details of your recent transaction:</p>
            <table class="invoice-details">
                <tr>
                    <th>Order ID:</th>
                    <td>{{order_id}}</td>
                </tr>
                <tr>
                    <th>Transaction ID:</th>
                    <td>{{transaction_id}}</td>
                </tr>
                <tr>
                    <th>Payment Status:</th>
                    <td>{{payment_status}}</td>
                </tr>
                <tr>
                    <th>Transaction Date:</th>
                    <td>{{transaction_date}}</td>
                </tr>
                <tr>
                    <th>Transaction Amount:</th>
                    <td>${{transaction_amount}}</td>
                </tr>
                <tr>
                    <th>Payment Method:</th>
                    <td>{{payment_method}}</td>
                </tr>
            </table>
            <p>If you have any questions or need further assistance, please feel free to contact us at {{support_email}}.</p>
            <p>Best regards,<br>{{company_name}}</p>
        </div>
        <div class="footer">
            <p>&copy; {{current_year}} {{company_name}}. All rights reserved.</p>
            <p>{{company_address}}</p>
        </div>
    </div>
</body>
</html>
