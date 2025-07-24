{{-- <!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
</head>
<body>
    <h1>{{ $title }}</h1>
    <p>PDF generated on {{ $date }}</p>
</body>
</html> --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms and Conditions</title>
    <style>
        /* Page and font styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        /* Header styling */
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding: 20px 0;
        }
        .header img {
            max-width: 150px;
        }
        .header h1 {
            margin: 10px 0 5px;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
            color: #666;
        }
        /* Content styling */
        .content {
            padding: 20px 0;
        }
        .content h2 {
            font-size: 18px;
            margin-top: 20px;
            color: #333;
        }
        .content p {
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 15px;
        }
        /* Footer styling */
        .footer {
            border-top: 1px solid #333;
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #666;
            position: absolute;
            bottom: 20px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Letterhead Header -->
        <div class="header">
            <div>
            <img src="{{url('/logo.png')}}" alt="Forever Mdespa">
            </div>
            <h1>{{$company}}</h1>
            <p>{{$address_1}}</p>
            <p>{{$address_2}}</p>
            <p>Email: {{$email}} | Phone: {{$phone}}</p>
        </div>

        <!-- Content Section -->
        <div class="content">
        <div style="text-align: right;">Date:.{{ $date }}</div>
            {!! $terms !!}
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; {{$company}}. All rights reserved.</p>
            <p>For more information, visit https://forevermedspanj.com/ or contact us at {{$phone}}.</p>
        </div>
    </div>
</body>
</html>
