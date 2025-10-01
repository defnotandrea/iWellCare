# Email Notification System - iWellCare

## Overview

The iWellCare Healthcare System now includes a comprehensive email notification system that automatically sends professional, branded emails to patients for various appointment-related events. The system also includes optional SMS functionality for enhanced communication.

## Features Implemented

### ✅ **Email Notifications**
- **Appointment Booking Confirmation** - Sent when a patient books an appointment
- **Appointment Confirmation** - Sent when staff confirms an appointment
- **Appointment Status Updates** - Sent for cancellations, rescheduling, completion, etc.
- **Custom Email Templates** - Professional, branded email templates with iWellCare styling

### ✅ **SMS Notifications (Optional)**
- **SMS Reminders** - Short text messages for appointment updates
- **Configurable** - Can be enabled/disabled via environment variable
- **Multiple Message Types** - Booking, confirmation, cancellation, rescheduling, reminders

### ✅ **Professional Email Templates**
- **Responsive Design** - Works on desktop and mobile devices
- **iWellCare Branding** - Consistent with the healthcare system's visual identity
- **Clear Information** - Appointment details, instructions, and contact information
- **Call-to-Action Buttons** - Direct links to view appointment details

## System Architecture

### Notification Classes
```
app/Notifications/
├── AppointmentBookingNotification.php      # Booking confirmation emails
├── AppointmentConfirmationNotification.php # Confirmation emails
├── AppointmentStatusUpdateNotification.php # Status change emails
├── AppointmentSMSNotification.php         # SMS notifications
└── CustomMailNotification.php            # Base class for custom emails
```

### Email Templates
```
resources/views/emails/
├── layout.blade.php                      # Base email layout
├── appointment-booking.blade.php         # Booking confirmation template
└── appointment-confirmation.blade.php    # Confirmation template
```

### Service Layer
```
app/Services/
└── NotificationService.php               # Centralized notification handling
```

## Configuration

### Email Configuration (.env)
```env
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

# SMS Configuration (Optional)
ENABLE_SMS_NOTIFICATIONS=false
```

### For Production Email Setup
Replace the mail configuration with your actual email provider:

```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-server.com
MAIL_PORT=587
MAIL_USERNAME=your-email@domain.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@iwellcare.com"
MAIL_FROM_NAME="iWellCare Healthcare System"
```

## Usage

### Automatic Notifications

The system automatically sends notifications when:

1. **Patient Books Appointment**
   - Email: Booking confirmation with appointment details
   - SMS: Short confirmation message (if enabled)

2. **Staff Confirms Appointment**
   - Email: Detailed confirmation with instructions
   - SMS: Confirmation message (if enabled)

3. **Appointment Status Changes**
   - Email: Status-specific messages (cancelled, rescheduled, completed)
   - SMS: Status update message (if enabled)

### Manual Notification Sending

```php
use App\Services\NotificationService;

$notificationService = app(NotificationService::class);

// Send booking notification
$notificationService->sendAppointmentBookingNotification($appointment);

// Send confirmation notification
$notificationService->sendAppointmentConfirmationNotification($appointment);

// Send status update notification
$notificationService->sendAppointmentStatusUpdateNotification($appointment, 'pending', 'confirmed');

// Send reminder notification
$notificationService->sendAppointmentReminderNotification($appointment);
```

## Email Templates

### Appointment Booking Email
- **Subject**: "Appointment Booking Confirmation - iWellCare"
- **Content**: Appointment details, next steps, contact information
- **Features**: Professional styling, clear instructions, contact details

### Appointment Confirmation Email
- **Subject**: "Appointment Confirmed - iWellCare"
- **Content**: Confirmed appointment details, arrival instructions, location info
- **Features**: Detailed instructions, location details, what to expect

### Email Template Features
- **Responsive Design**: Works on all devices
- **Professional Styling**: iWellCare branding and colors
- **Clear Information**: Easy-to-read appointment details
- **Contact Information**: Clinic phone number (09352410173)
- **Call-to-Action**: Direct links to view appointment details

## SMS Integration

### SMS Message Types
1. **Booking**: Confirmation of appointment booking
2. **Confirmation**: Appointment confirmed with instructions
3. **Cancelled**: Appointment cancellation notice
4. **Rescheduled**: Appointment rescheduling notification
5. **Reminder**: Day-before appointment reminder

### SMS Configuration
```env
ENABLE_SMS_NOTIFICATIONS=true  # Enable SMS notifications
```

### SMS Provider Integration
To integrate with an actual SMS provider (like Twilio, Nexmo, etc.):

1. Install the SMS provider package
2. Create a custom SMS channel
3. Update the `AppointmentSMSNotification` class
4. Configure provider credentials in `.env`

## Contact Information

All email templates include the clinic's contact information:
- **Phone**: 09352410173
- **Email**: info@iwellcare.com
- **Address**: Capitulacio Street Zone 2, Bangued, Abra

## Error Handling

The notification system includes comprehensive error handling:

- **Logging**: All notification attempts are logged
- **Error Recovery**: Failed notifications are logged with error details
- **Graceful Degradation**: System continues working even if notifications fail

## Testing

### Test Email Notifications
```bash
# Send test email
php artisan tinker
$appointment = App\Models\Appointment::first();
$notificationService = app(App\Services\NotificationService::class);
$notificationService->sendAppointmentBookingNotification($appointment);
```

### View Email Logs
```bash
# Check notification logs
tail -f storage/logs/laravel.log | grep "notification"
```

## Security Features

- **Email Validation**: Ensures valid email addresses
- **Rate Limiting**: Prevents notification spam
- **Queue Processing**: Handles notifications asynchronously
- **Error Logging**: Comprehensive error tracking

## Future Enhancements

### Planned Features
1. **Email Preferences**: Allow patients to choose notification types
2. **Multi-language Support**: Support for multiple languages
3. **Advanced SMS Integration**: Full SMS provider integration
4. **Notification History**: Track all sent notifications
5. **Template Customization**: Admin interface for email templates

### SMS Provider Integration
To add actual SMS functionality:

1. **Install SMS Package**:
   ```bash
   composer require twilio/sdk
   ```

2. **Create SMS Channel**:
   ```php
   // app/Notifications/Channels/SMSChannel.php
   ```

3. **Configure Provider**:
   ```env
   TWILIO_SID=your-twilio-sid
   TWILIO_TOKEN=your-twilio-token
   TWILIO_FROM=your-twilio-number
   ```

## Support

For technical support or questions about the notification system:
- **Email**: tech-support@iwellcare.com
- **Phone**: 09352410173
- **Documentation**: Check this file for updates

---

**Last Updated**: January 2025
**Version**: 1.0
**System**: iWellCare Healthcare Management System 