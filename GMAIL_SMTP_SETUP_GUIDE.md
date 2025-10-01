# Gmail SMTP Setup Guide for iWellCare Healthcare System

## 🎯 Complete Gmail SMTP Configuration

This guide will help you configure Gmail SMTP for the iWellCare Healthcare System to send emails for appointments, notifications, and other healthcare communications.

## 📋 Prerequisites

1. **Gmail Account**: You need a Gmail account
2. **2-Factor Authentication**: Must be enabled on your Google account
3. **App Password**: Generated from Google Account settings

## 🔧 Step-by-Step Setup

### Step 1: Enable 2-Factor Authentication

1. Go to [Google Account Settings](https://myaccount.google.com/)
2. Navigate to **Security** → **2-Step Verification**
3. Enable 2-Step Verification if not already enabled

### Step 2: Generate App Password

1. Go to [Google Account Settings](https://myaccount.google.com/)
2. Navigate to **Security** → **2-Step Verification** → **App passwords**
3. Click **Generate** for a new app password
4. Select **Mail** as the app type
5. Copy the generated 16-character password

### Step 3: Update .env Configuration

Update your `.env` file with the following settings:

```env
# Gmail SMTP Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-gmail@gmail.com
MAIL_PASSWORD=your-16-character-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-gmail@gmail.com
MAIL_FROM_NAME="iWellCare Healthcare"
```

**Replace the following:**
- `your-gmail@gmail.com` with your actual Gmail address
- `your-16-character-app-password` with the App Password generated in Step 2

### Step 4: Test the Configuration

Run the test command to verify your Gmail SMTP setup:

```bash
php artisan mail:test-gmail your-test-email@example.com
```

## ✅ Verification Checklist

- [ ] 2-Factor Authentication enabled on Google account
- [ ] App Password generated and copied
- [ ] .env file updated with correct Gmail credentials
- [ ] Test email sent successfully
- [ ] No authentication errors in logs

## 🔍 Troubleshooting

### Common Issues and Solutions

#### 1. Authentication Failed
**Error**: `Authentication failed for [your-email@gmail.com]`

**Solution**:
- Verify your App Password is correct (16 characters)
- Ensure 2-Factor Authentication is enabled
- Check that you're using the App Password, not your regular Gmail password

#### 2. Connection Timeout
**Error**: `Connection could not be established`

**Solution**:
- Verify `MAIL_HOST=smtp.gmail.com`
- Verify `MAIL_PORT=587`
- Verify `MAIL_ENCRYPTION=tls`
- Check your internet connection

#### 3. "Less Secure Apps" Error
**Error**: `Username and Password not accepted`

**Solution**:
- Disable "Less secure app access" in Google Account settings
- Use App Passwords instead of regular passwords
- Ensure 2-Factor Authentication is enabled

#### 4. Rate Limiting
**Error**: `Daily sending quota exceeded`

**Solution**:
- Gmail has a daily sending limit of 500 emails for regular accounts
- Consider using Google Workspace for higher limits
- Implement email queuing for bulk sends

## 📧 Email Features in iWellCare

With Gmail SMTP configured, the following email features will work:

### 1. Appointment Notifications
- Appointment confirmation emails
- Appointment reminder emails
- Cancellation notifications

### 2. Patient Communications
- Welcome emails for new patients
- Password reset emails
- Account verification emails

### 3. Staff Notifications
- New appointment alerts
- Patient registration notifications
- System alerts and reports

### 4. Healthcare Communications
- Medical report notifications
- Prescription updates
- Follow-up appointment reminders

## 🔒 Security Best Practices

1. **Never commit .env file** to version control
2. **Use App Passwords** instead of regular passwords
3. **Enable 2-Factor Authentication** on your Google account
4. **Regularly rotate App Passwords** for security
5. **Monitor email sending logs** for unusual activity

## 📊 Monitoring and Logs

Check email logs in Laravel:
```bash
tail -f storage/logs/laravel.log
```

View email queue status:
```bash
php artisan queue:work
```

## 🚀 Production Deployment

For production environments:

1. **Use Environment Variables**: Set MAIL_* variables in your hosting environment
2. **Enable Email Queuing**: Use `QUEUE_CONNECTION=database` for better performance
3. **Monitor Quotas**: Keep track of Gmail's daily sending limits
4. **Backup Configuration**: Document your email setup for disaster recovery

## 📞 Support

If you encounter issues:

1. Check the Laravel logs: `storage/logs/laravel.log`
2. Verify Gmail account settings
3. Test with the provided command: `php artisan mail:test-gmail`
4. Review this guide for troubleshooting steps

---

**Last Updated**: $(Get-Date -Format "yyyy-MM-dd")
**Version**: 1.0
**System**: iWellCare Healthcare Management System 