# Appointment Reminder System - iWellCare

## Overview

The iWellCare Healthcare System now includes an **automated appointment reminder system** that sends email notifications to patients 1 day before their confirmed appointments. This system helps reduce no-shows and ensures patients are well-prepared for their medical visits.

## Features

### ✅ **Automated Daily Reminders**
- **Timing**: Sends reminders exactly 1 day before confirmed appointments
- **Schedule**: Runs automatically every day at 8:00 AM
- **Target**: Only confirmed appointments (not pending, cancelled, or completed)
- **Channels**: Email + Dashboard notifications

### ✅ **Professional Email Templates**
- **Subject**: "🔔 Appointment Reminder - Tomorrow - iWellCare Clinic"
- **Content**: Complete appointment details, preparation checklist, contact information
- **Design**: Responsive, branded, professional appearance
- **Information**: Doctor details, date/time, appointment type, special notes

### ✅ **Comprehensive Reminder Content**
- **Appointment Details**: Doctor, date, time, type, notes
- **Preparation Checklist**: What to bring, arrival time, dress code
- **Contact Information**: Phone, email, address for questions/changes
- **Urgent Notice**: Clear instructions for cancellations/rescheduling

### ✅ **Dual Notification System**
- **Email Notifications**: Professional reminder emails
- **Dashboard Notifications**: Real-time updates in patient dashboard

## System Architecture

### New Files Created

```
app/Notifications/
└── AppointmentReminderNotification.php          # Reminder notification class

app/Console/Commands/
├── SendAppointmentRemindersCommand.php          # Daily reminder scheduler
└── TestAppointmentReminderCommand.php          # Testing command

resources/views/emails/
└── appointment-reminder.blade.php              # Reminder email template
```

### Modified Files

```
app/Services/NotificationService.php             # Enhanced reminder method
app/Console/Kernel.php                          # Scheduled command registration
```

## How It Works

### 1. **Daily Automation**
- **Command**: `appointments:send-reminders`
- **Schedule**: Daily at 8:00 AM
- **Process**: Finds all confirmed appointments for tomorrow
- **Delivery**: Sends email + dashboard notifications

### 2. **Reminder Logic**
```php
// Find confirmed appointments for tomorrow
$appointments = Appointment::with(['patient.user', 'doctor'])
    ->where('status', 'confirmed')
    ->whereDate('appointment_date', $tomorrow)
    ->get();
```

### 3. **Notification Delivery**
- **Email**: Professional reminder template
- **Dashboard**: Real-time notification with action buttons
- **Logging**: Comprehensive tracking of all activities

## Email Template Features

### **Visual Design**
- **Header**: iWellCare branding with clinic logo
- **Reminder Badge**: Prominent "APPOINTMENT REMINDER - TOMORROW" indicator
- **Color Coding**: Professional color scheme for different sections
- **Responsive**: Works on all devices and email clients

### **Content Sections**
1. **Appointment Details**: Complete information in organized format
2. **Important Reminders**: 6-point preparation checklist
3. **Urgent Notice**: Cancellation/rescheduling instructions
4. **Contact Information**: Multiple ways to reach the clinic
5. **Professional Footer**: Branded closing with automated notice

### **Preparation Checklist**
- ✅ Arrive 15 minutes early
- ✅ Bring valid ID
- ✅ Bring insurance information
- ✅ Bring current medications list
- ✅ Wear comfortable clothing
- ✅ Bring relevant medical records

## Configuration

### **Environment Variables**
```env
# Email Configuration (Required)
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-server.com
MAIL_PORT=587
MAIL_USERNAME=your-email@domain.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@iwellcare.com"
MAIL_FROM_NAME="iWellCare Healthcare System"
```

### **Scheduled Task**
The system automatically runs reminders daily at 8:00 AM. To ensure this works:

1. **Set up Cron Job** (Linux/Unix):
```bash
* * * * * cd /path/to/your/project && php artisan schedule:run >> /dev/null 2>&1
```

2. **Windows Task Scheduler**:
   - Create a scheduled task to run `php artisan schedule:run` every minute
   - Or use Laravel Forge, Laravel Vapor, or similar services

## Usage

### **Manual Testing**

#### Test with Sample Appointment
```bash
php artisan test:appointment-reminder
```

#### Test Specific Appointment
```bash
php artisan test:appointment-reminder {appointment_id}
```

#### Manual Daily Reminder
```bash
php artisan appointments:send-reminders
```

### **Monitoring and Logs**

#### Check Reminder Logs
```bash
tail -f storage/logs/laravel.log | grep "appointment reminder"
```

#### View Scheduled Tasks
```bash
php artisan schedule:list
```

## Dashboard Notifications

### **Reminder Notifications**
- **Type**: `appointment_reminder`
- **Icon**: Bell icon
- **Color**: Info (Blue)
- **Action**: "View Details" button
- **Content**: Appointment summary with tomorrow's date

### **Notification Display**
```php
[
    'type' => 'appointment_reminder',
    'title' => 'Appointment Reminder - Tomorrow',
    'message' => 'Your appointment with Dr. Smith is scheduled for tomorrow at 2:00 PM',
    'icon' => 'bell',
    'color' => 'info',
    'action_text' => 'View Details',
    'action_url' => '/patient/appointments/{id}'
]
```

## Error Handling

### **Comprehensive Logging**
- **Success Logs**: Detailed tracking of sent reminders
- **Error Logs**: Full error details with stack traces
- **Validation Logs**: Patient/user existence checks
- **Email Logs**: Delivery confirmation and failures

### **Fallback Mechanisms**
- **Patient Validation**: Checks patient and user existence
- **Email Validation**: Ensures patient has valid email
- **Status Validation**: Only processes confirmed appointments
- **Error Recovery**: Continues processing other appointments if one fails

## Testing

### **Test Scenarios**

1. **Valid Confirmed Appointment**
   - Should send email + dashboard notification
   - Should log success

2. **Patient Without Email**
   - Should skip and log warning
   - Should continue with other appointments

3. **Non-Confirmed Appointment**
   - Should be skipped
   - Should show appropriate warning

4. **Missing Patient/User**
   - Should skip and log error
   - Should continue processing

### **Test Commands**

```bash
# Test the entire system
php artisan test:appointment-reminder

# Test specific appointment
php artisan test:appointment-reminder 123

# Run manual daily reminder
php artisan appointments:send-reminders

# Check scheduled tasks
php artisan schedule:list
```

## Maintenance

### **Daily Operations**
- **Automatic**: System runs reminders daily at 8:00 AM
- **Logging**: All activities logged for monitoring
- **Error Handling**: Failed reminders logged with details
- **Performance**: Processes all appointments efficiently

### **Monitoring**
- **Success Rate**: Track successful vs failed reminders
- **Email Delivery**: Monitor email delivery success
- **System Health**: Check for any recurring errors
- **Performance**: Monitor processing time and resource usage

### **Troubleshooting**
- **Check Logs**: Review `storage/logs/laravel.log`
- **Test Commands**: Use test commands to verify functionality
- **Email Configuration**: Verify SMTP settings
- **Database**: Ensure appointments have correct status and relationships

## Future Enhancements

### **Planned Features**
- **Multiple Reminder Times**: 3 days, 1 day, and same-day reminders
- **Customizable Templates**: Admin-configurable reminder content
- **Patient Preferences**: Allow patients to choose reminder frequency
- **Analytics Dashboard**: Track reminder effectiveness and no-show reduction

## Contact Information

For technical support or questions about the reminder system:

- **Phone**: 09352410173
- **Email**: info@iwellcare.com
- **Address**: Capitulacion Street Zone 2, Bangued, Abra

## Summary

The Appointment Reminder System provides:

✅ **Automated daily reminders** for confirmed appointments  
✅ **Professional email templates** with comprehensive information  
✅ **Dashboard notifications** for real-time updates  
✅ **Robust error handling** and comprehensive logging  
✅ **Easy testing and monitoring** capabilities  

This system significantly improves patient engagement and reduces no-shows by ensuring patients are well-informed and prepared for their appointments.
