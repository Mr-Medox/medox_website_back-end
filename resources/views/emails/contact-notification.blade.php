<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Contact Form Submission</title>
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
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .content {
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #e9ecef;
            border-radius: 5px;
        }
        .field {
            margin-bottom: 15px;
        }
        .field-label {
            font-weight: bold;
            color: #495057;
        }
        .field-value {
            margin-top: 5px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 3px;
        }
        .footer {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
            font-size: 12px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>New Contact Form Submission</h2>
        <p>You have received a new message through your portfolio website contact form.</p>
    </div>

    <div class="content">
        <div class="field">
            <div class="field-label">Name:</div>
            <div class="field-value">{{ $contact->name }}</div>
        </div>

        <div class="field">
            <div class="field-label">Email:</div>
            <div class="field-value">{{ $contact->email }}</div>
        </div>

        @if($contact->phone)
        <div class="field">
            <div class="field-label">Phone:</div>
            <div class="field-value">{{ $contact->phone }}</div>
        </div>
        @endif

        @if($contact->company)
        <div class="field">
            <div class="field-label">Company:</div>
            <div class="field-value">{{ $contact->company }}</div>
        </div>
        @endif

        <div class="field">
            <div class="field-label">Subject:</div>
            <div class="field-value">{{ $contact->subject }}</div>
        </div>

        <div class="field">
            <div class="field-label">Message:</div>
            <div class="field-value">{{ $contact->message }}</div>
        </div>

        @if($contact->project_type)
        <div class="field">
            <div class="field-label">Project Type:</div>
            <div class="field-value">{{ $contact->project_type }}</div>
        </div>
        @endif

        @if($contact->budget)
        <div class="field">
            <div class="field-label">Budget:</div>
            <div class="field-value">{{ $contact->budget }}</div>
        </div>
        @endif

        @if($contact->timeline)
        <div class="field">
            <div class="field-label">Timeline:</div>
            <div class="field-value">{{ $contact->timeline }}</div>
        </div>
        @endif

        <div class="field">
            <div class="field-label">Submitted:</div>
            <div class="field-value">{{ $contact->created_at->format('F j, Y \a\t g:i A') }}</div>
        </div>
    </div>

    <div class="footer">
        <p>This message was sent from your portfolio website contact form.</p>
        <p>IP Address: {{ $contact->ip_address }}</p>
        <p>User Agent: {{ $contact->user_agent }}</p>
    </div>
</body>
</html>
