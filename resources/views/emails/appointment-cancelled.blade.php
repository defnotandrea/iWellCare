<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Appointment Cancelled</title>
    <style>
        body { font-family: Arial, sans-serif; color: #111827; }
        .card { max-width: 560px; margin: 0 auto; padding: 16px; border: 1px solid #e5e7eb; border-radius: 8px; }
        .title { color: #dc2626; }
        .muted { color: #6b7280; font-size: 12px; }
    </style>
    </head>
<body>
    <div class="card">
        <h2 class="title">Your appointment is cancelled</h2>
        <p>Hi {{ $user->first_name }},</p>
        <p>We are sorry to inform you that your appointment has been cancelled.</p>
        <ul>
            <li><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</li>
            <li><strong>Time:</strong> {{ substr($appointment->appointment_time,0,5) }}</li>
            <li><strong>Status:</strong> Cancelled</li>
        </ul>
        <p class="muted">If this was a mistake, please book a new appointment.</p>
        <p class="muted">This is an automated message from iWellCare.</p>
    </div>
</body>
</html>

