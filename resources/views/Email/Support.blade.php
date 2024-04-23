<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #d3e3fd;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #e4e7eb;
        }

        .logo {
            max-width: 100px;
            height: auto;
            margin: 0 auto;
        }

        .content {
            padding: 20px;
            font-size: 16px;
            color: #374151;
            line-height: 1.6;
        }

        .button {
            display: inline-block;
            color: #ffffff;
            background-color: #3b82f6;
            border-radius: 4px;
            padding: 10px 20px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #2563eb;
        }

        .contact-info {
            margin-top: 20px;
            font-size: 14px;
            color: #6b7280;
            text-align: center;
        }

        .contact-info i {
            margin-right: 5px;
        }

        /* Fix Gmail styles */
        u+#body a,
        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        .details {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            margin: 20px auto;
            text-align: center;
        }

        .footer {
            background-color: #808080;
            color: #ffffff;
            text-align: center;
            padding: 10px 0;
            font-size: 14px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <img src="{{ $message->embed(public_path('img/app-logo.png')) }}" alt="YM | LOGO" class="logo">
            <h1 style="font-size: 24px; color: #ffffff; font-weight: 600; margin-top: 10px;">{{ $subject }}</h1>
        </div>
        <div class="content">
            <div class="details">
                <p>{{ $content }}</p>
                <a href="{{ $contactLink }}" class="button">{{ $contactText }}</a>
                <div class="contact-info" style="margin-top: 20px;">
                    <i class="fas fa-phone-alt" style="color: #6b7280;"></i> {{ $phoneNumber }}
                </div>
            </div>
        </div>
        <div class="footer">
            <p>&copy; 2024 YM | Medical Appointments. All rights reserved.</p>
            <p style="font-size: 12px;">This is an automated email. Please do not reply.</p>
        </div>
    </div>

</body>

</html>
