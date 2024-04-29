<!DOCTYPE html>
<html>

<head>
    <title>New Application Submitted</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .logo {
            max-width: 150px;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        h2 {
            text-align: center;
            color: #333333;
        }

        p {
            margin-bottom: 15px;
            line-height: 1.6;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            color: #777777;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container">
        <img src="{{ $message->embed(public_path('img/app-logo.png')) }}" alt="YM | LOGO" class="logo">
        <hr>
        <h2>New Application Submitted</h2>
        <p><strong>Name:</strong> {{ $name }}</p>
        <p><strong>Email:</strong> {{ $email }}</p>
        <p><strong>Details:</strong> {{ $details }}</p>
        <p><strong>CV and personal information have been attached.</strong></p>
        <p>Contact us: <a href="https://example.com/contact">Contact us</a></p>
        <p>Phone Number: +1234567890</p>
        <hr>
        <div class="footer">
            <p>This is an automated message. Please do not reply to this email.</p>
        </div>
    </div>
</body>

</html>
