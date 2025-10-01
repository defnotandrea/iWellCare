<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification - iWellCare</title>
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
        .otp-container {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            margin: 30px 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .otp-code {
            font-size: 32px;
            font-weight: bold;
            color: white;
            letter-spacing: 4px;
            font-family: 'Courier New', monospace;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
        .otp-label {
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
            margin-top: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .message {
            font-size: 16px;
            color: #4a5568;
            margin: 20px 0;
            line-height: 1.7;
        }
        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 6px;
            padding: 16px;
            margin: 20px 0;
            color: #856404;
        }
        .warning strong {
            display: block;
            margin-bottom: 8px;
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
        .timer {
            background-color: #e8f4f8;
            border: 1px solid #bee3f8;
            border-radius: 6px;
            padding: 12px 16px;
            margin: 20px 0;
            display: inline-block;
        }
        .timer strong {
            color: #2b6cb0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="logo">🏥 iWellCare</div>
            <h1>OTP Verification</h1>
            <p>Secure your account with verification code</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Hello, <?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?>!
            </div>

            <div class="message">
                Thank you for using iWellCare. To complete your verification process, please use the One-Time Password (OTP) code below:
            </div>

            <!-- OTP Code Display -->
            <div class="otp-container">
                <div class="otp-code"><?php echo e($otpCode); ?></div>
                <div class="otp-label">Your Verification Code</div>
            </div>

            <div class="timer">
                <strong>⏰ Expires in 10 minutes</strong>
            </div>

            <div class="message">
                Enter this code on the verification page to complete your account setup. This code is valid for a limited time for security reasons.
            </div>

            <!-- Security Warning -->
            <div class="warning">
                <strong>🔒 Security Notice:</strong>
                If you did not request this verification code, please ignore this email. Do not share this code with anyone.
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
</html><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views/emails/otp-verification.blade.php ENDPATH**/ ?>