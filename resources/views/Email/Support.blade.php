<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
        }

        .contact-info i {
            margin-right: 5px;
        }

        /* Fix Gmail styles */
        u + #body a, a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <img src="{{ $message->embed(public_path('img/app-logo.png')) }}" alt="YM | LOGO" class="logo">
        <h1 style="font-size: 24px; color: #4b5563; font-weight: 600; margin-top: 10px;">{{ $subject }}</h1>
    </div>
    <div class="content">
        <p style="margin-bottom: 20px;">{{ $content }}</p>
        <a href="{{ $contactLink }}" class="button">{{ $contactText }}</a>
        <div class="contact-info" style="margin-top: 20px;">
            <i class="fas fa-phone-alt"></i> {{ $phoneNumber }}
        </div>
    </div>
</div>

</body>
</html>
