# Password Reset OTP System

## Overview

The Password Reset OTP System provides a secure, OTP-based password reset functionality for the iWellCare application. This system replaces traditional password reset links with time-limited, single-use verification codes sent via email.

## Features

### 🔐 Security Features
- **6-digit numeric OTP codes** with 10-minute expiration
- **Single-use codes** - each OTP can only be used once
- **Rate limiting** - prevents spam and abuse
- **Session-based verification** - ensures proper flow completion
- **Automatic cleanup** of expired OTPs

### 📧 User Experience
- **Intuitive flow**: Email → OTP → New Password
- **Resend functionality** with 60-second cooldown timer
- **Real-time validation** and error handling
- **Responsive design** with modern UI
- **Clear feedback** at each step

### 🛠 Technical Features
- **Modular architecture** - reusable OTP system
- **Comprehensive logging** for debugging and monitoring
- **Test commands** for system validation
- **Error handling** with user-friendly messages

## System Architecture

### Components

1. **Controllers**
   - `ForgotPasswordController` - Handles email requests and OTP generation
   - `ResetPasswordController` - Manages OTP verification and password reset

2. **Models**
   - `OtpCode` - Manages OTP generation, verification, and cleanup
   - `User` - Handles password updates

3. **Notifications**
   - `OtpVerificationNotification` - Sends OTP emails with type-specific content

4. **Views**
   - `auth/passwords/email.blade.php` - Email request form
   - `auth/passwords/reset.blade.php` - OTP verification and password reset form

5. **Routes**
   - Password reset flow routes with proper middleware

## User Flow

### 1. Password Reset Request
```
User clicks "Forgot Password" → Enters email → System validates email → Sends OTP
```

### 2. OTP Verification
```
User receives email → Enters 6-digit code → System verifies OTP → Shows password form
```

### 3. Password Reset
```
User enters new password → Confirms password → System updates password → Redirects to login
```

## API Endpoints

### Password Reset Request
- **URL**: `POST /forgot-password`
- **Purpose**: Request password reset OTP
- **Parameters**: `email`
- **Response**: Redirect to OTP verification form

### OTP Verification
- **URL**: `POST /reset-password/verify-otp`
- **Purpose**: Verify OTP and proceed to password reset
- **Parameters**: `email`, `otp`
- **Response**: Redirect to password reset form

### Password Update
- **URL**: `POST /reset-password`
- **Purpose**: Update user password
- **Parameters**: `password`, `password_confirmation`
- **Response**: Redirect to login with success message

### Resend OTP
- **URL**: `POST /password/resend-otp`
- **Purpose**: Resend OTP code
- **Parameters**: `email`
- **Response**: JSON response with success/error status

## Database Schema

### otp_codes Table
```sql
CREATE TABLE otp_codes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    code VARCHAR(6) NOT NULL,
    type ENUM('email_verification', 'password_reset', 'login') DEFAULT 'email_verification',
    expires_at TIMESTAMP NOT NULL,
    is_used BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_email_type (email, type),
    INDEX idx_expires_at (expires_at),
    INDEX idx_is_used (is_used)
);
```

## Security Measures

### OTP Generation
- **6-digit numeric codes** using `random_int()`
- **10-minute expiration** from generation time
- **Unique per email and type** combination

### Rate Limiting
- **One active OTP per email** for password reset
- **60-second cooldown** for resend functionality
- **Automatic cleanup** of expired codes

### Session Security
- **Email stored in session** during reset process
- **OTP verification flag** prevents bypass
- **Session cleanup** after successful reset

## Configuration

### Environment Variables
```env
MAIL_MAILER=log  # For local development
MAIL_FROM_ADDRESS=noreply@iwellcare.com
MAIL_FROM_NAME="iWellCare"
```

### OTP Settings (in OtpCode model)
```php
const EXPIRY_MINUTES = 10;
const CODE_LENGTH = 6;
const MAX_ATTEMPTS = 3;
```

## Testing

### Manual Testing
1. **Navigate to login page**
2. **Click "Forgot Password"**
3. **Enter email address**
4. **Check email for OTP**
5. **Enter OTP code**
6. **Set new password**
7. **Verify login with new password**

### Automated Testing
```bash
# Test password reset OTP system
php artisan test:password-reset-otp test@example.com

# Test general OTP system
php artisan test:otp-system

# Clean up expired OTPs
php artisan otp:cleanup
```

## Error Handling

### Common Error Scenarios
1. **Invalid email** - User-friendly error message
2. **Expired OTP** - Clear expiration message
3. **Invalid OTP** - Validation error with retry option
4. **Network issues** - Graceful fallback with retry
5. **Session timeout** - Redirect to email request

### Error Messages
- "We could not find a user with that email address."
- "Invalid or expired verification code. Please try again."
- "A password reset code has already been sent to your email."
- "There was an error sending the password reset code. Please try again."

## Monitoring and Logging

### Log Events
- **OTP generation** - Email, type, timestamp
- **OTP verification** - Success/failure, email
- **Password reset** - Success/failure, email
- **Error events** - Detailed error information

### Log Levels
- **INFO**: Successful operations
- **WARNING**: Rate limiting, expired codes
- **ERROR**: System failures, validation errors

## Maintenance

### Scheduled Tasks
```bash
# Add to crontab for automatic cleanup
* * * * * cd /path/to/project && php artisan otp:cleanup
```

### Database Maintenance
- **Regular cleanup** of expired OTPs
- **Monitor table size** for performance
- **Archive old records** if needed

## Integration Points

### Email System
- **Laravel Mail** for OTP delivery
- **Queue support** for async processing
- **Template customization** per OTP type

### Authentication System
- **Laravel Auth** integration
- **Session management** for flow control
- **Password validation** rules

### Frontend Integration
- **AJAX calls** for resend functionality
- **Real-time validation** for better UX
- **Responsive design** for mobile support

## Future Enhancements

### Planned Features
- **SMS OTP delivery** as alternative
- **Multi-factor authentication** integration
- **Advanced rate limiting** with IP tracking
- **Audit logging** for security compliance
- **Admin dashboard** for OTP management

### Performance Optimizations
- **Redis caching** for OTP storage
- **Queue processing** for email delivery
- **Database indexing** optimization
- **CDN integration** for static assets

## Troubleshooting

### Common Issues

#### OTP Not Received
1. **Check email configuration** in `.env`
2. **Verify email address** is correct
3. **Check spam folder** for OTP emails
4. **Review mail logs** for delivery status

#### Invalid OTP Error
1. **Check OTP expiration** (10 minutes)
2. **Verify code format** (6 digits)
3. **Ensure single use** - OTP becomes invalid after use
4. **Check for typos** in code entry

#### Session Issues
1. **Clear browser cache** and cookies
2. **Check session configuration**
3. **Verify route middleware** setup
4. **Review session storage** settings

### Debug Commands
```bash
# Check OTP status
php artisan tinker
>>> App\Models\OtpCode::where('email', 'test@example.com')->get();

# Test email configuration
php artisan test:email-notification

# Verify routes
php artisan route:list | grep password
```

## Security Best Practices

### Implementation
- ✅ **HTTPS enforcement** for all password reset requests
- ✅ **CSRF protection** on all forms
- ✅ **Input validation** and sanitization
- ✅ **Rate limiting** to prevent abuse
- ✅ **Secure session handling**

### Monitoring
- ✅ **Log all password reset attempts**
- ✅ **Monitor for suspicious activity**
- ✅ **Regular security audits**
- ✅ **Keep dependencies updated**

### User Education
- ✅ **Clear security instructions**
- ✅ **Password strength requirements**
- ✅ **Account security reminders**
- ✅ **Phishing awareness**

## Conclusion

The Password Reset OTP System provides a secure, user-friendly alternative to traditional password reset links. With comprehensive error handling, monitoring, and testing capabilities, it ensures a reliable password recovery experience while maintaining high security standards.

For support or questions about the password reset OTP system, please refer to the application logs or contact the development team. 