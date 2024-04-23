<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Appointment Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            max-width: 150px;
        }

        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        .appointment-details {
            margin-bottom: 30px;
        }

        .appointment-details p {
            margin: 10px 0;
            font-size: 16px;
            color: #333;
            line-height: 1.5;
        }

        .footer {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border-radius: 0 0 10px 10px;
            font-size: 14px;
            text-align: center;
        }

        .footer p {
            margin: 0;
        }

        @media screen and (max-width: 768px) {
            .container {
                width: 100%;
                border-radius: 0;
            }

            .header img {
                max-width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('img/app-logo.png') }}" alt="Your App Logo">
        </div>
        <h1>Appointment Details</h1>
        <div class="appointment-details">
            <p><strong>Date:</strong> {{ $appointment->appointment_date }}</p>
            <p><strong>Reason:</strong> {{ $appointment->reason }}</p>
            <p><strong>Status:</strong> {{ $appointment->status }}</p>
            <p><strong>Patient Disponibility:</strong> {{ $appointment->Patient_Disponibility }}</p>
            <p><strong>Doctor Comment:</strong> {{ $appointment->doctor_comment }}</p>
        </div>
        <div class="footer">
            <p>© YM Medical Appointments | Phone: +212 12345678 | Email: no.reply.ym.system@gmail.com</p>
        </div>
    </div>
</body>

</html>
