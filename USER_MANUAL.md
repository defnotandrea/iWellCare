# iWellCare Healthcare Management System - User Manual

## Table of Contents

1. [Introduction](#introduction)
2. [System Overview](#system-overview)
3. [Getting Started](#getting-started)
   - [User Registration](#user-registration)
   - [Email Verification](#email-verification)
   - [Login Process](#login-process)
4. [User Roles and Permissions](#user-roles-and-permissions)
5. [Patient User Guide](#patient-user-guide)
   - [Patient Dashboard](#patient-dashboard)
   - [Booking Appointments](#booking-appointments)
   - [Managing Appointments](#managing-appointments)
   - [Medical Records](#medical-records)
   - [Prescription History](#prescription-history)
   - [Billing and Payments](#billing-and-payments)
6. [Admin User Guide](#admin-user-guide)
   - [Admin Dashboard](#admin-dashboard)
   - [User Management](#user-management)
   - [System Monitoring](#system-monitoring)
   - [Reports and Analytics](#reports-and-analytics)
7. [Doctor User Guide](#doctor-user-guide)
   - [Doctor Dashboard](#doctor-dashboard)
   - [Managing Consultations](#managing-consultations)
   - [Patient Medical Records](#patient-medical-records)
   - [Prescription Management](#prescription-management)
   - [Doctor Availability](#doctor-availability)
8. [Staff User Guide](#staff-user-guide)
   - [Staff Dashboard](#staff-dashboard)
   - [Appointment Management](#appointment-management)
   - [Billing Management](#billing-management)
   - [Inventory Management](#inventory-management)
9. [Common Features](#common-features)
   - [Notifications](#notifications)
   - [Profile Management](#profile-management)
   - [Password Management](#password-management)
10. [Troubleshooting](#troubleshooting)
11. [Contact Support](#contact-support)

---

## Introduction

Welcome to iWellCare, a comprehensive healthcare management system designed to streamline healthcare operations and improve patient care. This user manual provides detailed guidance for all users of the system, including patients, administrators, doctors, and staff members.

### What is iWellCare?

iWellCare is a modern, web-based healthcare management platform that offers:

- **Patient Management**: Complete patient records and medical history tracking
- **Appointment Scheduling**: Easy booking and management of medical appointments
- **Medical Consultations**: Comprehensive consultation workflow and documentation
- **Prescription Management**: Digital prescription system with medication tracking
- **Billing & Payments**: Integrated billing and payment processing
- **Medical Records**: Secure digital health records management
- **Inventory Management**: Medical supplies and medication tracking
- **Real-time Notifications**: Instant updates via email and dashboard notifications

### Key Features

- **Role-Based Access Control**: Secure access based on user roles and permissions
- **Real-time Communication**: Instant notifications for appointment updates
- **Mobile-Responsive Design**: Access from any device
- **Data Security**: Encrypted data storage and secure authentication
- **Audit Trails**: Complete tracking of all system activities

---

## System Overview

### User Roles

iWellCare supports four main user roles, each with specific permissions and access levels:

#### 1. **Patient**
- Book and manage appointments
- View medical records and history
- Access prescription information
- View billing and payment history
- Receive notifications about appointments

#### 2. **Administrator**
- Full system access and configuration
- User account management
- System monitoring and maintenance
- Generate reports and analytics
- Manage system settings

#### 3. **Doctor**
- Conduct medical consultations
- Access and update patient medical records
- Create and manage prescriptions
- Set availability and schedule
- View appointment schedules

#### 4. **Staff**
- Manage appointment scheduling
- Handle billing and payments
- Manage inventory and supplies
- Assist with patient coordination
- Generate reports

### System Architecture

The system is built using modern web technologies:
- **Backend**: Laravel 10 framework
- **Database**: MySQL
- **Frontend**: Bootstrap 5, responsive design
- **Authentication**: Secure login with role-based permissions
- **Notifications**: Email and real-time dashboard notifications

---

## Getting Started

### User Registration

To use iWellCare, you must first create a user account. The registration process is designed to be simple and secure.

#### Step 1: Access Registration Page
- Navigate to the registration page at: `http://your-domain.com/register`
- This page contains the patient registration form

#### Step 2: Fill Out Personal Information
Enter the following required information:
- **First Name**: Your first name
- **Last Name**: Your last name
- **Username**: Choose a unique username (4-20 characters, letters, numbers, underscores only)
- **Email**: Your email address (used for verification and notifications)
- **Phone Number**: Your contact number
- **Street Address**: Your complete address
- **City**: Your city
- **State/Province**: Your state or province
- **Postal Code**: Your postal code (optional)
- **Date of Birth**: Your birth date
- **Gender**: Select your gender
- **Blood Type**: Your blood type (optional)

#### Step 3: Set Security Information
- **Password**: Create a strong password
  - Minimum 10 characters
  - Must contain: uppercase, lowercase, number, special character
  - No common patterns or consecutive identical characters
- **Confirm Password**: Re-enter your password

#### Step 4: Submit Registration
- Click the "Register" button
- The system will validate your information
- If successful, you'll be redirected to email verification

### Email Verification

After successful registration, you must verify your email address before accessing the system.

#### Step 1: Check Your Email
- Look for a verification email from iWellCare
- Check your spam/junk folder if not found in inbox
- The email contains a 6-digit verification code

#### Step 2: Enter Verification Code
- On the verification page, enter the 6-digit code
- Click "Verify Email" to complete verification
- Codes expire after 10 minutes for security

#### Step 3: Access Your Account
- After verification, you'll be automatically logged in
- You'll be redirected to your role-specific dashboard

### Login Process

#### Step 1: Access Login Page
- Navigate to: `http://your-domain.com/login`

#### Step 2: Enter Credentials
- **Username**: Your registered username
- **Password**: Your account password

#### Step 3: Login
- Click "Login" to access your account
- You'll be redirected to your dashboard based on your role

#### Forgot Password?
- Click "Forgot Password?" link
- Enter your email address
- Follow the password reset instructions sent to your email

---

## User Roles and Permissions

### Patient Role
**Permissions:**
- View personal dashboard with health statistics
- Book new appointments
- View and manage existing appointments
- Access medical records and history
- View prescriptions and medication history
- Access billing and payment information
- Update personal profile information
- Receive appointment notifications

**Restrictions:**
- Cannot access other patients' information
- Cannot modify medical records (read-only access)
- Cannot manage billing (view-only access)

### Administrator Role
**Permissions:**
- Full access to all system features
- Create, edit, and delete user accounts
- Manage patient records
- Oversee appointment scheduling
- Access all billing and payment information
- Manage inventory and supplies
- Generate system reports
- Configure system settings
- Monitor system performance

**Restrictions:**
- None (full system access)

### Doctor Role
**Permissions:**
- Access assigned patients' medical records
- Conduct and document medical consultations
- Create and manage prescriptions
- Update patient medical history
- Set personal availability schedule
- View appointment schedules
- Access consultation history

**Restrictions:**
- Cannot access patients not assigned to them
- Cannot modify billing information
- Cannot manage user accounts
- Cannot access inventory management

### Staff Role
**Permissions:**
- Manage appointment scheduling and confirmations
- Process billing and payments
- Manage inventory and supplies
- Assist with patient coordination
- Generate operational reports
- Update appointment statuses
- Handle patient inquiries

**Restrictions:**
- Cannot access medical records
- Cannot create prescriptions
- Cannot conduct consultations
- Cannot manage user accounts
- Cannot modify system settings

---

## Patient User Guide

### Patient Dashboard

The patient dashboard is your central hub for managing your healthcare journey.

#### Dashboard Overview
- **Welcome Message**: Personalized greeting with your name
- **Health Statistics**: Overview of your appointments, consultations, and billing
- **Quick Actions**: Fast access to common tasks
- **Recent Activity**: Latest appointments and updates
- **Health Tips**: General wellness information
- **Emergency Contact**: Important contact information

#### Statistics Cards
- **Total Appointments**: All your appointments (past and future)
- **Pending Appointments**: Appointments awaiting confirmation
- **Completed Consultations**: Finished medical consultations
- **Unpaid Invoices**: Outstanding payments requiring attention

#### Quick Actions
- **Book Appointment**: Schedule a new consultation
- **View Appointments**: See all your appointments
- **Medical Records**: Access your health history
- **Update Profile**: Modify your personal information

### Booking Appointments

#### Step 1: Access Booking Page
- From dashboard, click "Book Appointment"
- Or navigate to Appointments → Create New

#### Step 2: Select Doctor
- Choose from available doctors
- View doctor availability status
- Select preferred doctor for your consultation

#### Step 3: Choose Date and Time
- Select appointment date (future dates only)
- Choose available time slot
- System shows doctor availability in real-time

#### Step 4: Provide Details
- **Reason for Visit**: Describe your medical concern
- **Additional Notes**: Any special requirements or information

#### Step 5: Confirm Booking
- Review all information
- Submit appointment request
- Receive confirmation notification

### Managing Appointments

#### Viewing Appointments
- Access via "View Appointments" from dashboard
- See all appointments: upcoming, completed, cancelled
- Filter by status, date, or doctor

#### Appointment Statuses
- **Scheduled**: Initial booking, awaiting confirmation
- **Confirmed**: Staff-approved appointment
- **Completed**: Finished consultation
- **Cancelled**: Cancelled appointment

#### Rescheduling Appointments
- Click "Reschedule" on pending appointments
- Select new date and time
- Confirm changes
- Receive notification of changes

#### Cancelling Appointments
- Click "Cancel" on pending appointments
- Provide cancellation reason (optional)
- Confirm cancellation
- Receive confirmation notification

### Medical Records

#### Accessing Records
- From dashboard, click "Medical Records"
- View complete medical history
- Organized by date and consultation type

#### Record Types
- **Consultation Notes**: Doctor's examination notes
- **Diagnosis**: Medical diagnoses and conditions
- **Treatment Plans**: Recommended treatments
- **Test Results**: Laboratory and imaging results
- **Vital Signs**: Blood pressure, temperature, etc.

#### Downloading Records
- Click "Download" on individual records
- PDF format available for printing
- Secure access with date/time stamps

### Prescription History

#### Viewing Prescriptions
- Access via Medical Records section
- See all current and past prescriptions
- Organized by date prescribed

#### Prescription Details
- **Medication Name**: Drug name and dosage
- **Instructions**: How to take the medication
- **Duration**: Length of treatment
- **Refills**: Number of refills remaining
- **Prescribing Doctor**: Which doctor prescribed it

#### Medication Reminders
- System notifications for medication schedules
- Refill reminders when prescriptions are running low
- Integration with pharmacy systems (future feature)

### Billing and Payments

#### Viewing Invoices
- Access via dashboard "Unpaid Invoices" card
- See all billing history
- Filter by payment status

#### Invoice Details
- **Services Rendered**: Description of medical services
- **Charges**: Itemized billing amounts
- **Insurance Coverage**: Applied insurance adjustments
- **Total Amount**: Final amount due
- **Payment Status**: Paid, pending, overdue

#### Making Payments
- Click "Pay Now" on unpaid invoices
- Secure payment processing
- Multiple payment methods supported
- Payment confirmation and receipts

---

## Admin User Guide

### Admin Dashboard

The admin dashboard provides a comprehensive overview of system operations.

#### System Statistics
- **Total Users**: Count of all registered users by role
- **Active Patients**: Currently active patient accounts
- **Today's Appointments**: Appointments scheduled for today
- **System Performance**: Server status and response times

#### Quick Actions
- **User Management**: Create and manage user accounts
- **System Settings**: Configure system parameters
- **Reports**: Generate various system reports
- **Backup**: System backup and maintenance

### User Management

#### Creating Users
1. Navigate to User Management section
2. Click "Create New User"
3. Select user role (Admin, Doctor, Staff, Patient)
4. Fill in user information
5. Set initial password
6. Assign appropriate permissions

#### Managing Users
- **Edit User Information**: Update user details and roles
- **Reset Passwords**: Force password reset for users
- **Deactivate Accounts**: Temporarily disable user access
- **Delete Users**: Permanently remove user accounts (use with caution)

#### Role Assignment
- Assign appropriate roles based on job functions
- Modify role permissions as needed
- Audit role changes for security

### System Monitoring

#### User Activity
- Monitor user login activity
- Track system usage patterns
- Identify inactive accounts
- Generate user activity reports

#### System Health
- Database performance monitoring
- Server resource usage
- Error log monitoring
- Automated alert system

#### Security Monitoring
- Failed login attempts
- Suspicious activity detection
- Audit trail review
- Security incident response

### Reports and Analytics

#### Available Reports
- **User Reports**: User registration and activity statistics
- **Appointment Reports**: Appointment scheduling and completion rates
- **Financial Reports**: Billing and payment summaries
- **Medical Reports**: Consultation and treatment statistics
- **System Reports**: Performance and usage analytics

#### Generating Reports
1. Select report type from Reports menu
2. Choose date range and filters
3. Generate report in desired format (PDF, Excel, CSV)
4. Schedule automatic report generation

---

## Doctor User Guide

### Doctor Dashboard

The doctor dashboard focuses on patient care and schedule management.

#### Today's Schedule
- **Upcoming Appointments**: Today's patient appointments
- **Consultation Status**: Current and completed consultations
- **Patient Queue**: Waiting patients and consultation flow

#### Patient Statistics
- **Active Patients**: Patients under your care
- **Consultations This Month**: Number of consultations performed
- **Pending Tasks**: Follow-ups and pending items

### Managing Consultations

#### Starting a Consultation
1. From dashboard, click on upcoming appointment
2. Review patient information and appointment details
3. Begin consultation documentation

#### Consultation Process
1. **Patient History**: Review medical history and previous consultations
2. **Physical Examination**: Document examination findings
3. **Diagnosis**: Record medical diagnosis
4. **Treatment Plan**: Outline treatment recommendations
5. **Prescription**: Create medication prescriptions if needed

#### Documentation
- **SOAP Notes**: Subjective, Objective, Assessment, Plan format
- **Vital Signs**: Record blood pressure, temperature, etc.
- **Examination Findings**: Document physical examination results
- **Treatment Instructions**: Clear patient instructions

### Patient Medical Records

#### Accessing Records
- From consultation screen or patient search
- View complete patient medical history
- Access previous consultations and treatments

#### Updating Records
- Add new consultation notes
- Update medical history
- Record test results and follow-ups
- Maintain accurate patient information

### Prescription Management

#### Creating Prescriptions
1. During consultation, click "Create Prescription"
2. Select medications from inventory
3. Specify dosage and instructions
4. Set prescription duration and refills

#### Prescription Details
- **Medication Selection**: Choose from available medications
- **Dosage Instructions**: Clear dosage and timing instructions
- **Duration**: Length of treatment
- **Refills**: Number of allowed refills
- **Special Instructions**: Additional medication guidance

#### Prescription History
- View all prescriptions for a patient
- Track medication history
- Monitor prescription refills

### Doctor Availability

#### Setting Availability
1. Access Availability Settings
2. Set working hours for each day
3. Mark unavailable dates (vacation, conferences)
4. Set appointment intervals

#### Managing Schedule
- View current availability
- Block time slots for special activities
- Handle emergency situations
- Coordinate with staff for scheduling

---

## Staff User Guide

### Staff Dashboard

The staff dashboard focuses on operational tasks and patient coordination.

#### Today's Tasks
- **Pending Appointments**: Appointments requiring confirmation
- **Today's Schedule**: All appointments for the day
- **Billing Tasks**: Outstanding invoices and payments
- **Inventory Alerts**: Low stock warnings

#### Operational Statistics
- **Appointments Today**: Number of appointments scheduled
- **Completed Tasks**: Tasks completed today
- **Pending Items**: Items requiring attention

### Appointment Management

#### Confirming Appointments
1. Review pending appointments
2. Verify patient and doctor availability
3. Confirm appointment details
4. Send confirmation notifications

#### Managing Schedule
- View daily appointment calendar
- Handle walk-in patients
- Reschedule appointments as needed
- Coordinate with doctors and patients

#### Appointment Workflow
1. **Initial Booking**: Patient books appointment
2. **Staff Review**: Staff reviews and confirms
3. **Doctor Assignment**: Ensure doctor availability
4. **Patient Notification**: Send confirmation
5. **Day of Appointment**: Check-in and coordination

### Billing Management

#### Processing Bills
1. Access patient billing information
2. Review services rendered
3. Calculate charges and insurance adjustments
4. Generate invoices

#### Payment Processing
- Accept various payment methods
- Process insurance claims
- Handle payment plans
- Generate receipts and statements

#### Billing Reports
- Track outstanding payments
- Monitor collection rates
- Generate financial reports
- Identify billing issues

### Inventory Management

#### Stock Monitoring
- View current inventory levels
- Monitor low stock alerts
- Track expiration dates
- Manage stock movements

#### Inventory Tasks
- **Receive Shipments**: Record incoming supplies
- **Issue Supplies**: Track usage and distribution
- **Stock Counts**: Perform inventory audits
- **Reorder Management**: Generate purchase orders

#### Inventory Reports
- Stock level reports
- Usage statistics
- Expiration tracking
- Cost analysis

---

## Common Features

### Notifications

#### Email Notifications
- **Appointment Confirmations**: When appointments are confirmed
- **Appointment Reminders**: Before scheduled appointments
- **Status Updates**: Changes to appointment status
- **Prescription Notifications**: New prescriptions available
- **Billing Notifications**: Invoice and payment updates

#### Dashboard Notifications
- **Real-time Updates**: Instant notifications in dashboard
- **Color-coded Alerts**: Different colors for different types
- **Action Buttons**: Direct links to relevant pages
- **Notification History**: View past notifications

#### Managing Notifications
- Mark notifications as read
- Delete old notifications
- Configure notification preferences (future feature)
- View notification history

### Profile Management

#### Updating Personal Information
1. Access Profile Settings
2. Update contact information
3. Modify personal details
4. Upload profile photo

#### Security Settings
- Change password
- Update email address
- Manage two-factor authentication (future feature)
- View login history

### Password Management

#### Changing Password
1. Go to Profile → Security Settings
2. Enter current password
3. Enter new password (follow requirements)
4. Confirm new password
5. Save changes

#### Password Requirements
- Minimum 10 characters
- At least 1 uppercase letter
- At least 1 lowercase letter
- At least 1 number
- At least 1 special character
- No common patterns

#### Forgot Password
1. Click "Forgot Password?" on login page
2. Enter your email address
3. Check email for reset instructions
4. Follow the secure reset link
5. Create new password

---

## Troubleshooting

### Common Issues

#### Login Problems
**Issue**: Cannot log in to account
**Solutions**:
- Verify username and password are correct
- Check if Caps Lock is on
- Try resetting password
- Clear browser cache and cookies
- Try different browser

**Issue**: Account locked after failed attempts
**Solutions**:
- Wait 15 minutes for automatic unlock
- Contact administrator for manual unlock
- Use password reset if needed

#### Email Verification Issues
**Issue**: Didn't receive verification email
**Solutions**:
- Check spam/junk folder
- Wait a few minutes for delivery
- Click "Resend Code" on verification page
- Verify email address is correct
- Contact support if still not received

**Issue**: Verification code expired
**Solutions**:
- Request new verification code
- Complete verification within 10 minutes
- Check email immediately after registration

#### Appointment Booking Issues
**Issue**: Cannot book appointment
**Solutions**:
- Ensure all required fields are filled
- Check doctor availability
- Select future date and time
- Verify account is verified

**Issue**: Appointment not showing
**Solutions**:
- Refresh dashboard
- Check appointment status
- Contact staff for confirmation
- Check email for notifications

#### Dashboard Loading Issues
**Issue**: Dashboard not loading properly
**Solutions**:
- Refresh the page (Ctrl + F5)
- Clear browser cache
- Try different browser
- Check internet connection
- Contact technical support

### Technical Issues

#### Browser Compatibility
- Use modern browsers (Chrome, Firefox, Safari, Edge)
- Enable JavaScript
- Allow cookies
- Update browser to latest version

#### Mobile Access
- Use responsive design optimized for mobile
- Some features may be limited on very small screens
- Download mobile app when available (future feature)

#### File Upload Issues
- Check file size limits (usually 10MB)
- Supported formats: PDF, JPG, PNG for documents
- Ensure stable internet connection
- Try smaller files if upload fails

### Data and Privacy

#### Data Security
- All data is encrypted in transit and at rest
- Secure authentication required for access
- Regular security audits performed
- Compliance with healthcare privacy regulations

#### Data Backup
- Automatic daily backups
- Secure off-site storage
- Regular backup testing
- Data recovery procedures in place

---

## Contact Support

### Support Channels

#### Technical Support
- **Email**: tech-support@iwellcare.com
- **Phone**: 09352410173
- **Hours**: Monday - Friday, 8:00 AM - 6:00 PM (GMT+8)
- **Response Time**: Within 24 hours for urgent issues

#### Emergency Support
- **Emergency Line**: 09352410173
- **Available**: 24/7 for critical system issues
- **Priority**: Immediate response for system downtime

#### User Assistance
- **Help Desk**: help@iwellcare.com
- **Documentation**: Online user manual and FAQs
- **Training**: User training sessions available

### Reporting Issues

#### Bug Reports
When reporting technical issues, please include:
- **Browser and version**
- **Operating system**
- **Steps to reproduce the issue**
- **Error messages (if any)**
- **Screenshots (if applicable)**
- **Date and time of occurrence**

#### Feature Requests
For new feature suggestions:
- **Clear description of requested feature**
- **Business justification**
- **Priority level (low, medium, high)**
- **Expected benefits**

### System Status

#### Status Page
- Visit: http://status.iwellcare.com
- Real-time system status
- Scheduled maintenance notifications
- Incident history and updates

#### Maintenance Windows
- **Scheduled Maintenance**: Every Sunday 2:00 AM - 4:00 AM (GMT+8)
- **Emergency Maintenance**: As needed with advance notice
- **System Updates**: Deployed during low-usage hours

---

**Document Version**: 1.0
**Last Updated**: September 2025
**System Version**: iWellCare v1.0
**Contact**: support@iwellcare.com

*This user manual is regularly updated. Please check for the latest version.*