
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            text-align: center;
            padding: 10px 0;
        }
        .email-header img {
            max-width: 150px;
        }
        .email-body {
            padding: 20px;
            line-height: 1.6;
            color: #333333;
        }
        .email-body h2 {
            color: #333333;
        }
        .email-body p {
            margin: 15px 0;
        }
        .email-body a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #ffffff;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
        }
        .email-footer {
            text-align: center;
            margin-top: 20px;
            color: #888888;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header with Logo -->
        <div class="email-header">
            <img src="{{url('/images/gifts/logo.png')}}" alt="Forever Medspa">
        </div>

        <!-- Email Body -->
        <div class="container">
            <h1>Email Verification</h1>
            <p>Thank you for registering with us. Please verify your email address by clicking the button below:</p>

            <p>
                <a href="{{ route('patient_email_verify', ['token' => $data['tokenverify']]) }}" target="_blank">Verify Email</a>
            </p>
   
            <p>If you did not create this account, you can ignore this email.</p>
            <div class="footer">
                {{-- <p>&copy; {{date('Y')}} Your Company. All rights reserved.</p> --}}
            </div>
        </div>Thank you, <br> The {{ config('app.name') }} Team</p>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
