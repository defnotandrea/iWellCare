<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Reminder - iWellCare</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            background-color: #f8f9fa;
            padding: 20px;
        }
        .email-container {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin: 20px 0;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 40px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .header p {
            margin: 8px 0 0 0;
            opacity: 0.9;
            font-size: 16px;
        }
        .content {
            padding: 40px;
        }
        .greeting {
            font-size: 18px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 20px;
        }
        .message {
            font-size: 16px;
            color: #4a5568;
            margin: 20px 0;
            line-height: 1.7;
        }
        .appointment-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 8px;
            padding: 25px;
            margin: 30px 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .appointment-card h3 {
            color: white;
            margin: 0 0 15px 0;
            font-size: 18px;
            text-align: center;
        }
        .appointment-detail {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 8px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        .appointment-detail:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9);
        }
        .detail-value {
            color: white;
            font-weight: 500;
        }
        .reminder-icon {
            text-align: center;
            font-size: 48px;
            margin-bottom: 15px;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 30px 40px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }
        .footer h3 {
            margin: 0 0 10px 0;
            color: #2d3748;
            font-size: 18px;
        }
        .footer p {
            margin: 0;
            color: #718096;
            font-size: 14px;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: white;
            margin-bottom: 8px;
        }
        .important-note {
            background-color: #fef5e7;
            border: 1px solid #f6e05e;
            border-radius: 6px;
            padding: 16px;
            margin: 20px 0;
            color: #744210;
        }
        .important-note strong {
            display: block;
            margin-bottom: 8px;
            color: #d69e2e;
        }
        .countdown {
            background-color: #f0fff4;
            border: 1px solid #9ae6b4;
            border-radius: 6px;
            padding: 12px 16px;
            margin: 20px 0;
            display: inline-block;
            color: #22543d;
        }
        .countdown strong {
            color: #38a169;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="logo">🏥 iWellCare</div>
            <h1>Appointment Reminder</h1>
            <p>Don't forget your upcoming appointment</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Hello, <?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?>!
            </div>

            <div class="message">
                This is a friendly reminder about your upcoming appointment with us. We're looking forward to seeing you!
            </div>

            <!-- Countdown -->
            <div class="countdown">
                <strong>⏰ Your appointment is coming up soon!</strong>
            </div>

            <!-- Appointment Details -->
            <div class="appointment-card">
                <div class="reminder-icon">🔔</div>
                <h3>Appointment Details</h3>
                <div class="appointment-detail">
                    <span class="detail-label">📅 Date:</span>
                    <span class="detail-value"><?php echo e($appointment->date); ?></span>
                </div>
                <div class="appointment-detail">
                    <span class="detail-label">⏰ Time:</span>
                    <span class="detail-value"><?php echo e($appointment->time); ?></span>
                </div>
                <div class="appointment-detail">
                    <span class="detail-label">👨‍⚕️ Doctor:</span>
                    <span class="detail-value"><?php echo e($appointment->doctor_name); ?></span>
                </div>
                <div class="appointment-detail">
                    <span class="detail-label">📋 Reason:</span>
                    <span class="detail-value"><?php echo e($appointment->reason); ?></span>
                </div>
            </div>

            <!-- Important Note -->
            <div class="important-note">
                <strong>📋 Important Preparation:</strong>
                Please arrive 15 minutes early for your appointment. Bring any relevant medical records, test results, or insurance information.
            </div>

            <div class="message">
                If you need to reschedule or cancel your appointment, please contact us as soon as possible. We appreciate your prompt attention to this matter.
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <h3>iWellCare</h3>
            <p>Secure • Reliable • Patient-Centered Care</p>
            <p style="margin-top: 10px; font-size: 12px; color: #a0aec0;">
                This is an automated message. Please do not reply to this email.
            </p>
        </div>
    </div>
</body>
</html><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\emails\appointment-reminder.blade.php ENDPATH**/ ?>