# Gmail SMTP Configuration for iWellCare

## Email Configuration Setup

To use Gmail SMTP for sending appointment confirmation emails, update your `.env` file with the following settings:

### 1. Update .env file

```env
# Email Configuration
MAIL_MAILER=gmail
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="iWellCare Healthcare System"
```

### 2. Gmail App Password Setup

**Important:** You need to use an App Password, not your regular Gmail password.

1. Go to your Google Account settings: https://myaccount.google.com/
2. Navigate to Security → 2-Step Verification
3. Enable 2-Step Verification if not already enabled
4. Go to Security → App passwords
5. Generate a new app password for "Mail"
6. Use this 16-character password in your .env file

### 3. Gmail Account Requirements

- 2-Step Verification must be enabled
- Less secure app access should be disabled (default for new accounts)
- Use App Password instead of regular password

### 4. Testing the Configuration

After updating the .env file, test the email functionality:

```bash
php artisan test:email
```

### 5. Alternative Configuration Options

If you prefer to use a different email service, you can also configure:

#### Mailgun
```env
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=your-domain.com
MAILGUN_SECRET=your-mailgun-secret
```

#### SendGrid
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your-sendgrid-api-key
MAIL_ENCRYPTION=tls
```

### 6. Troubleshooting

- **Connection failed**: Check if port 587 is not blocked by firewall
- **Authentication failed**: Verify username and app password
- **TLS error**: Ensure encryption is set to 'tls'
- **Rate limiting**: Gmail has daily sending limits (500 emails/day for regular accounts)

### 7. Security Notes

- Never commit .env file to version control
- Use environment-specific configurations for production
- Regularly rotate app passwords
- Monitor email sending logs for any issues
