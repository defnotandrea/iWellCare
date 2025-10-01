# iWellCare Healthcare Management System - Input Process Output (IPO) Diagrams

## A. User Management Operations

### 1. Add User Data
- **INPUT**: User Information (First Name, Last Name, Email, Password, Role)
- **PROCESS**: Add User Data
- **OUTPUT**: New User Data

### 2. Edit User Data
- **INPUT**: First Name, Last Name, Email, Role
- **PROCESS**: Edit User Data
- **OUTPUT**: Edited User Data

### 3. Search User Data
- **INPUT**: First Name, Last Name, Email
- **PROCESS**: Search User Data
- **OUTPUT**: Searched User Data

### 4. Delete User Data
- **INPUT**: User ID, User Information
- **PROCESS**: Delete User Data
- **OUTPUT**: Deleted User Data

## B. Patient Management Operations

### 1. Add Patient Data
- **INPUT**: Patient Information (Name, Age, Gender, Contact, Medical History)
- **PROCESS**: Add Patient Data
- **OUTPUT**: New Patient Data

### 2. Edit Patient Data
- **INPUT**: Patient Name, Patient ID, Medical History
- **PROCESS**: Edit Patient Data
- **OUTPUT**: Edited Patient Data

### 3. Search Patient Data
- **INPUT**: Patient Name, Patient ID, Contact Number
- **PROCESS**: Search Patient Data
- **OUTPUT**: Searched Patient Data

### 4. View Patient Records
- **INPUT**: Patient ID, Date Range
- **PROCESS**: Retrieve Patient Records
- **OUTPUT**: Patient Medical Records

## C. Doctor Management Operations

### 1. Add Doctor Data
- **INPUT**: Doctor Information (Name, Specialization, License, Contact)
- **PROCESS**: Add Doctor Data
- **OUTPUT**: New Doctor Data

### 2. Edit Doctor Data
- **INPUT**: Doctor Name, Specialization, License Number
- **PROCESS**: Edit Doctor Data
- **OUTPUT**: Edited Doctor Data

### 3. Search Doctor Data
- **INPUT**: Doctor Name, Specialization, License Number
- **PROCESS**: Search Doctor Data
- **OUTPUT**: Searched Doctor Data

### 4. Assign Doctor to Patient
- **INPUT**: Doctor ID, Patient ID, Assignment Date
- **PROCESS**: Assign Doctor to Patient
- **OUTPUT**: Doctor-Patient Assignment

## D. Appointment Management Operations

### 1. Book Appointment
- **INPUT**: Patient Data, Doctor Data, Appointment Date/Time
- **PROCESS**: Book Appointment
- **OUTPUT**: New Appointment

### 2. Edit Appointment
- **INPUT**: Appointment ID, New Date/Time, Patient/Doctor Changes
- **PROCESS**: Edit Appointment
- **OUTPUT**: Edited Appointment

### 3. Cancel Appointment
- **INPUT**: Appointment ID, Cancellation Reason
- **PROCESS**: Cancel Appointment
- **OUTPUT**: Cancelled Appointment

### 4. Search Appointments
- **INPUT**: Date Range, Patient Name, Doctor Name
- **PROCESS**: Search Appointments
- **OUTPUT**: Searched Appointments

### 5. View Appointment Schedule
- **INPUT**: Date, Doctor ID, Patient ID
- **PROCESS**: Retrieve Appointment Schedule
- **OUTPUT**: Appointment Schedule

## E. Consultation Management Operations

### 1. Add Consultation
- **INPUT**: Patient Data, Doctor Data, Symptoms, Diagnosis
- **PROCESS**: Add Consultation
- **OUTPUT**: New Consultation

### 2. Edit Consultation
- **INPUT**: Consultation ID, Updated Symptoms, Diagnosis
- **PROCESS**: Edit Consultation
- **OUTPUT**: Edited Consultation

### 3. Search Consultations
- **INPUT**: Patient Name, Doctor Name, Date Range
- **PROCESS**: Search Consultations
- **OUTPUT**: Searched Consultations

### 4. View Consultation History
- **INPUT**: Patient ID, Date Range
- **PROCESS**: Retrieve Consultation History
- **OUTPUT**: Consultation History

## F. Billing Management Operations

### 1. Generate Bill
- **INPUT**: Patient Data, Services Rendered, Consultation Fees
- **PROCESS**: Generate Bill
- **OUTPUT**: New Bill

### 2. Edit Bill
- **INPUT**: Bill ID, Updated Services, Fee Adjustments
- **PROCESS**: Edit Bill
- **OUTPUT**: Edited Bill

### 3. Process Payment
- **INPUT**: Bill ID, Payment Amount, Payment Method
- **PROCESS**: Process Payment
- **OUTPUT**: Payment Receipt

### 4. Search Bills
- **INPUT**: Patient Name, Date Range, Payment Status
- **PROCESS**: Search Bills
- **OUTPUT**: Searched Bills

### 5. View Payment History
- **INPUT**: Patient ID, Date Range
- **PROCESS**: Retrieve Payment History
- **OUTPUT**: Payment History

## G. Inventory Management Operations

### 1. Add Inventory Item
- **INPUT**: Item Information (Name, Quantity, Category, Price)
- **PROCESS**: Add Inventory Item
- **OUTPUT**: New Inventory Item

### 2. Edit Inventory Item
- **INPUT**: Item ID, Updated Quantity, Price, Category
- **PROCESS**: Edit Inventory Item
- **OUTPUT**: Edited Inventory Item

### 3. Search Inventory
- **INPUT**: Item Name, Category, Price Range
- **PROCESS**: Search Inventory
- **OUTPUT**: Searched Inventory Items

### 4. Update Stock
- **INPUT**: Item ID, New Quantity, Stock Movement Type
- **PROCESS**: Update Stock
- **OUTPUT**: Updated Stock Level

### 5. Generate Inventory Report
- **INPUT**: Date Range, Category, Stock Level Threshold
- **PROCESS**: Generate Inventory Report
- **OUTPUT**: Inventory Report

## H. Notification Management Operations

### 1. Send Appointment Reminder
- **INPUT**: Appointment Data, Patient Contact, Reminder Time
- **PROCESS**: Send Appointment Reminder
- **OUTPUT**: Sent Reminder Notification

### 2. Send SMS Notification
- **INPUT**: Patient Phone Number, Message Content
- **PROCESS**: Send SMS Notification
- **OUTPUT**: Sent SMS Notification

### 3. Send Email Notification
- **INPUT**: Patient Email, Email Content, Subject
- **PROCESS**: Send Email Notification
- **OUTPUT**: Sent Email Notification

### 4. Schedule Notifications
- **INPUT**: Notification Type, Recipient, Schedule Time
- **PROCESS**: Schedule Notifications
- **OUTPUT**: Scheduled Notification

## I. Report Generation Operations

### 1. Generate Patient Report
- **INPUT**: Patient ID, Report Type, Date Range
- **PROCESS**: Generate Patient Report
- **OUTPUT**: Patient Report

### 2. Generate Financial Report
- **INPUT**: Date Range, Report Category, Payment Status
- **PROCESS**: Generate Financial Report
- **OUTPUT**: Financial Report

### 3. Generate Appointment Report
- **INPUT**: Date Range, Doctor ID, Patient Category
- **PROCESS**: Generate Appointment Report
- **OUTPUT**: Appointment Report

### 4. Export Data
- **INPUT**: Data Type, Format, Date Range
- **PROCESS**: Export Data
- **OUTPUT**: Exported Data File

## J. Authentication Operations

### 1. User Login
- **INPUT**: Username/Email, Password
- **PROCESS**: Authenticate User
- **OUTPUT**: Authentication Result

### 2. User Registration
- **INPUT**: Registration Information (Name, Email, Password)
- **PROCESS**: Register User
- **OUTPUT**: New User Account

### 3. Password Reset
- **INPUT**: Email Address, Reset Token
- **PROCESS**: Reset Password
- **OUTPUT**: New Password

### 4. OTP Verification
- **INPUT**: Phone Number, OTP Code
- **PROCESS**: Verify OTP
- **OUTPUT**: Verification Result

## K. System Administration Operations

### 1. Manage User Roles
- **INPUT**: User ID, Role Assignment, Permissions
- **PROCESS**: Manage User Roles
- **OUTPUT**: Updated User Role

### 2. System Configuration
- **INPUT**: Configuration Parameters, Settings
- **PROCESS**: Update System Configuration
- **OUTPUT**: Updated System Settings

### 3. Database Backup
- **INPUT**: Backup Type, Backup Location
- **PROCESS**: Create Database Backup
- **OUTPUT**: Backup File

### 4. System Maintenance
- **INPUT**: Maintenance Tasks, Schedule
- **PROCESS**: Perform System Maintenance
- **OUTPUT**: Maintenance Report

---

*This document provides a comprehensive overview of all Input-Process-Output operations within the iWellCare Healthcare Management System, following the standard IPO diagram format with clear input data, processing steps, and output results for each system operation.* 