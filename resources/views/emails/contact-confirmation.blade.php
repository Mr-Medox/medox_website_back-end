<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thank You for Your Message</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 30px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        .content {
            background-color: #ffffff;
            padding: 30px;
            border: 1px solid #e9ecef;
            border-radius: 5px;
        }
        .message-box {
            background-color: #f8f9fa;
            padding: 20px;
            border-left: 4px solid #007bff;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 5px;
            text-align: center;
            font-size: 14px;
            color: #6c757d;
        }
        .cta-button {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Thank You for Your Message!</h1>
        <p>We've received your inquiry and will get back to you soon.</p>
    </div>

    <div class="content">
        <p>Dear {{ $contact->name }},</p>
        
        <p>Thank you for reaching out to us! We have received your message regarding <strong>"{{ $contact->subject }}"</strong> and truly appreciate your interest in our services.</p>

        <div class="message-box">
            <h3>Your Message:</h3>
            <p><em>"{{ $contact->message }}"</em></p>
        </div>

        <p>Our team will review your inquiry and respond within 24 hours. In the meantime, feel free to:</p>
        
        <ul>
            <li>Browse our <a href="{{ url('/portfolio') }}">portfolio</a> to see our recent work</li>
            <li>Read our <a href="{{ url('/blog') }}">blog</a> for insights and tips</li>
            <li>Learn more <a href="{{ url('/about') }}">about us</a> and our services</li>
        </ul>

        <div style="text-align: center;">
            <a href="{{ url('/portfolio') }}" class="cta-button">View Our Portfolio</a>
        </div>

        <p>If you have any urgent questions, please don't hesitate to contact us directly.</p>

        <p>Best regards,<br>
        <strong>{{ config('app.name') }} Team</strong></p>
    </div>

    <div class="footer">
        <p>This is an automated confirmation email. Please do not reply to this message.</p>
        <p>If you need to send additional information, please use our <a href="{{ url('/contact') }}">contact form</a>.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html>
