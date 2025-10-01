# OTP Verification System - iWellCare

## Overview

The iWellCare Healthcare System now includes a comprehensive OTP (One-Time Password) verification system for enhanced security and email verification. This system provides secure, time-limited verification codes sent via email to verify user accounts.

## Features Implemented

### ✅ **OTP Verification System**
- **6-Digit Codes**: Secure 6-digit numeric verification codes
- **10-Minute Expiration**: Codes automatically expire after 10 minutes
- **Email Delivery**: Codes are sent via email with professional templates
- **Multiple Types**: Support for email verification, password reset, and login verification
- **Automatic Cleanup**: Expired codes are automatically cleaned up

### ✅ **User Registration Integration**
- **Automatic OTP**: OTP codes are automatically sent after successful registration
- **Email Verification Required**: Users must verify their email before accessing the system
- **Seamless Flow**: Registration → OTP Verification → Dashboard access

### ✅ **Professional Email Templates**
- **Branded Design**: Consistent with iWellCare visual identity
- **Clear Instructions**: Easy-to-follow verification process
- **Security Information**: Clear expiration and security notices

## System Architecture

### Database Structure
```sql
otp_codes table:
- id (primary key)
- email (string)
- code (6-digit string)
- type (enum: email_verification, password_reset, login)
- expires_at (timestamp)
- is_used (boolean)
- created_at, updated_at
```

### Models
```
app/Models/
├── OtpCode.php                    # OTP code management
└── User.php                       # Updated with MustVerifyEmail
```

### Controllers
```
app/Http/Controllers/Auth/
├── OtpVerificationController.php  # OTP verification handling
└── RegisterController.php         # Updated with OTP integration
```

### Notifications
```
app/Notifications/
└── OtpVerificationNotification.php # OTP email notifications
```

### Views
```
resources/views/auth/
└── verify-otp.blade.php          # OTP verification interface
```

## Configuration

### Email Configuration
The OTP system uses the existing email configuration:
```env
MAIL_MAILER=log                    # For localhost testing
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="iWellCare Healthcare System"
```

### OTP Settings
- **Code Length**: 6 digits
- **Expiration Time**: 10 minutes
- **Resend Cooldown**: 60 seconds
- **Maximum Attempts**: Unlimited (with rate limiting)

## Usage

### Registration Flow
1. **User Registration**: User fills out registration form
2. **Account Creation**: User account is created in database
3. **OTP Generation**: 6-digit code is generated and stored
4. **Email Notification**: OTP code is sent to user's email
5. **Verification Page**: User is redirected to verification page
6. **Code Entry**: User enters the 6-digit code
7. **Verification**: Code is verified and user is marked as verified
8. **Dashboard Access**: User is redirected to appropriate dashboard

### Manual OTP Sending
```php
use App\Models\OtpCode;
use App\Notifications\OtpVerificationNotification;

// Generate and send OTP
$code = OtpCode::generateCode($user->email, 'email_verification');
$user->notify(new OtpVerificationNotification($code, 'email_verification'));
```

### OTP Verification
```php
use App\Models\OtpCode;

// Verify OTP code
$isValid = OtpCode::verifyCode($email, $code, 'email_verification');
if ($isValid) {
    // Mark user as verified
    $user->update(['email_verified_at' => now()]);
}
```

## API Endpoints

### OTP Verification Routes
```php
// Show verification form
GET /verify-email

// Send OTP code
POST /send-otp

// Verify OTP code
POST /verify-otp

// Resend OTP code
POST /resend-otp

// Check verification status
POST /check-verification
```

### Request/Response Examples

#### Send OTP
```json
POST /send-otp
{
    "email": "user@example.com"
}

Response:
{
    "success": true,
    "message": "Verification code sent to your email.",
    "email": "user@example.com"
}
```

#### Verify OTP
```json
POST /verify-otp
{
    "email": "user@example.com",
    "code": "123456"
}

Response:
{
    "success": true,
    "message": "Email verified successfully!",
    "redirect": "/dashboard"
}
```

## User Interface

### OTP Verification Page Features
- **Modern Design**: Clean, professional interface
- **Real-time Validation**: Instant feedback on code entry
- **Resend Timer**: 60-second cooldown between resend attempts
- **Loading States**: Visual feedback during verification
- **Error Handling**: Clear error messages for invalid codes
- **Mobile Responsive**: Works on all device sizes

### UI Components
- **Code Input**: 6-digit numeric input with auto-formatting
- **Resend Button**: Timer-based resend functionality
- **Loading Modal**: Progress indication during verification
- **Alert System**: Success/error message display
- **Progress Indicators**: Visual feedback for all actions

## Security Features

### Code Security
- **Random Generation**: Cryptographically secure random codes
- **Single Use**: Codes are marked as used after verification
- **Time Limitation**: Automatic expiration after 10 minutes
- **Rate Limiting**: Built-in protection against abuse

### Email Security
- **Secure Delivery**: Codes sent via secure email channels
- **No Storage**: Codes are not stored in plain text logs
- **Audit Trail**: All OTP activities are logged for security

### Database Security
- **Encrypted Storage**: Sensitive data is properly encrypted
- **Automatic Cleanup**: Expired codes are regularly removed
- **Indexed Queries**: Optimized database performance

## Testing

### Test Commands
```bash
# Test OTP system functionality
php artisan test:otp-system

# Clean up expired OTP codes
php artisan otp:cleanup

# Test email notifications
php artisan test:email-notification
```

### Test Scenarios
1. **Registration Flow**: Complete user registration with OTP
2. **Code Verification**: Enter and verify OTP codes
3. **Expiration Testing**: Test code expiration after 10 minutes
4. **Resend Functionality**: Test resend with cooldown timer
5. **Error Handling**: Test invalid codes and error scenarios

## Maintenance

### Automated Cleanup
The system includes automatic cleanup of expired OTP codes:

```bash
# Manual cleanup
php artisan otp:cleanup

# Automated cleanup (cron job)
* * * * * php /path/to/artisan otp:cleanup
```

### Monitoring
- **Log Monitoring**: All OTP activities are logged
- **Error Tracking**: Failed verifications are tracked
- **Performance Metrics**: Code generation and verification times

## Error Handling

### Common Error Scenarios
1. **Invalid Code**: User enters wrong verification code
2. **Expired Code**: Code has expired (10 minutes)
3. **Already Used**: Code has already been used
4. **Email Not Found**: Email address doesn't exist
5. **Network Issues**: Email delivery failures

### Error Messages
- **Invalid Code**: "Invalid or expired verification code. Please try again."
- **Expired Code**: "Verification code has expired. Please request a new one."
- **Email Not Found**: "Email address not found in our records."
- **Network Error**: "Failed to send verification code. Please try again."

## Future Enhancements

### Planned Features
1. **SMS OTP**: Add SMS-based OTP delivery
2. **Two-Factor Authentication**: Extend OTP for 2FA
3. **Biometric Verification**: Add fingerprint/face recognition
4. **Advanced Security**: Implement device fingerprinting
5. **Analytics Dashboard**: OTP usage analytics

### SMS Integration
To add SMS OTP functionality:
```php
// Install SMS package
composer require twilio/sdk

// Create SMS notification
class SmsOtpNotification extends Notification
{
    public function toSms($notifiable)
    {
        return "Your iWellCare verification code is: {$this->code}";
    }
}
```

## Troubleshooting

### Common Issues

#### OTP Not Received
1. Check email spam folder
2. Verify email address is correct
3. Check email server configuration
4. Review application logs

#### Verification Fails
1. Ensure code is entered correctly
2. Check if code has expired
3. Verify code hasn't been used already
4. Check database connectivity

#### Registration Issues
1. Verify all required fields are filled
2. Check email uniqueness
3. Ensure password meets requirements
4. Review validation rules

### Debug Commands
```bash
# Check OTP table
php artisan tinker
>>> App\Models\OtpCode::all();

# Test email configuration
php artisan test:email-notification

# Check user verification status
php artisan tinker
>>> App\Models\User::first()->email_verified_at;
```

## Support

For technical support or questions about the OTP system:
- **Email**: tech-support@iwellcare.com
- **Phone**: 09352410173
- **Documentation**: Check this file for updates

---

**Last Updated**: August 2025
**Version**: 1.0
**System**: iWellCare Healthcare Management System
**Status**: ✅ Production Ready 