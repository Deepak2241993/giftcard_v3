<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Account Created - Forever Medspa</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f9f9f9; color: #333333;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #f9f9f9; padding: 30px 0;">
        <tr>
            <td align="center">
                <table width="600" border="0" cellspacing="0" cellpadding="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);">
                    <!-- Header Section -->
                    <tr>
                        <td align="center" style="padding: 20px 0; background-color: #FCA52A;">
                            <img src="{{url('/images/gifts/logo.png')}}" alt="Forever Medspa" style="max-width: 150px;" />
                        </td>
                    </tr>
                    
                    <!-- Body Section -->
                    <tr>
                        <td style="padding: 40px; text-align: left;">
                            <h2 style="color: #333333;">Welcome to Forever Medspa, {{$full_name}}!</h2>
                            <p>We are thrilled to have you on board. Your account has been successfully created, and you can now log in using the credentials below:</p>
                            
                            <p><strong>Username:</strong> {{ $patient_login_id }}</p>
                            <p><strong>Password:</strong> {{ $password }}</p>

                            <p>To get started, simply click the button below to log in:</p>
                            <p>
                                <a href="{{ url('/patient-login') }}" style="display: inline-block; padding: 12px 24px; font-size: 16px; background-color: #007BFF; color: #ffffff; text-decoration: none; border-radius: 4px;">Log In Now</a>
                            </p>

                            <p>If you have any questions or face any issues, feel free to reach out to us. We're here to help!</p>
                            <p>Best regards,</p>
                            <p><strong>FOREVER-MEDSPA</strong></p>
                        </td>
                    </tr>

                    <!-- Footer Section -->
                    <tr>
                        <td style="text-align: center; padding: 20px; background-color: #f4f4f4; color: #888888; font-size: 12px;">
                            &copy; {{ date('Y') }} {{ config('app.name') }}. All Rights Reserved.
                            <br />
                            Need help? <a href="mailto:info@forevermedspanj.com" style="color: #FCA52A; text-decoration: none;">Contact Support</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
