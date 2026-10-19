<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>New VALUEMAP contact message</title>
</head>
<body style="font-family:Arial,sans-serif;color:#102a43;line-height:1.6">
    <h1 style="font-size:22px">New message from the VALUEMAP website</h1>
    <p><strong>Name:</strong> {{ $contactMessage->name }}</p>
    <p><strong>Email:</strong> <a href="mailto:{{ $contactMessage->email }}">{{ $contactMessage->email }}</a></p>
    <p><strong>Organisation:</strong> {{ $contactMessage->organisation ?: 'Not provided' }}</p>
    <p><strong>Subject:</strong> {{ $contactMessage->subject }}</p>
    <hr>
    <p style="white-space:pre-wrap">{{ $contactMessage->message }}</p>
    <hr>
    <p style="font-size:12px;color:#64748b">A copy of this message is also stored in the VALUEMAP administration panel.</p>
</body>
</html>
