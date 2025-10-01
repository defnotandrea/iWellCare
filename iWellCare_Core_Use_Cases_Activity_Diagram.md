# iWellCare Healthcare Management System - Core Use Cases Activity Diagram

## Overview
This document provides a comprehensive activity diagram for the main core use cases in the iWellCare Healthcare Management System, based on the user system table and system functionality analysis.

## User System Table Analysis

### User Roles and Their Use Cases:

**Admin/Doctor (Actor)**
- Login
- Manage Appointment 
- Manage Patients Information
- Manage Consultation
- Manage Medication
- Manage Invoice 
- Manage User
- Generate Reports
- Logout

**Staff (Actor)**
- Login
- Manage Appointment 
- Manage Patients Information
- Manage Consultation
- Manage Medication
- Manage Invoice 
- Manage User (patient only)
- Generate Reports
- Logout

**Patient (Actor)**
- Login
- Manage Patient Information
- Book Appointment

## Unified Core Use Cases

Based on the analysis, the following unified use cases have been identified:

### Primary Use Cases:
1. **Login** (Common to all users)
2. **Manage Appointment** (Admin/Doctor, Staff)
3. **Manage Patient Information** (Admin/Doctor, Staff, Patient)
4. **Manage Consultation** (Admin/Doctor, Staff)
5. **Manage Medication** (Admin/Doctor, Staff)
6. **Manage Invoice** (Admin/Doctor, Staff)
7. **Manage User** (Admin/Doctor, Staff - limited to patients)
8. **Generate Reports** (Admin/Doctor, Staff)
9. **Book Appointment** (Patient)
10. **Logout** (Common to all users)

## Activity Diagram in Mermaid Format

```mermaid
graph TD
    Start([Start]) --> Login[Login]
    
    %% Login Process
    Login --> Auth{Authentication}
    Auth -->|Success| RoleCheck{Check User Role}
    Auth -->|Failed| LoginError[Display Error Message]
    LoginError --> Login
    
    %% Role-based Routing
    RoleCheck -->|Admin/Doctor| AdminDashboard[Admin/Doctor Dashboard]
    RoleCheck -->|Staff| StaffDashboard[Staff Dashboard]
    RoleCheck -->|Patient| PatientDashboard[Patient Dashboard]
    
    %% Admin/Doctor Use Cases
    AdminDashboard --> AdminMenu{Admin/Doctor Menu}
    AdminMenu -->|Manage Appointments| ManageAppointment
    AdminMenu -->|Manage Patients| ManagePatientInfo
    AdminMenu -->|Manage Consultations| ManageConsultation
    AdminMenu -->|Manage Medications| ManageMedication
    AdminMenu -->|Manage Invoices| ManageInvoice
    AdminMenu -->|Manage Users| ManageUser
    AdminMenu -->|Generate Reports| GenerateReports
    AdminMenu -->|Logout| Logout
    
    %% Staff Use Cases
    StaffDashboard --> StaffMenu{Staff Menu}
    StaffMenu -->|Manage Appointments| ManageAppointment
    StaffMenu -->|Manage Patients| ManagePatientInfo
    StaffMenu -->|Manage Consultations| ManageConsultation
    StaffMenu -->|Manage Medications| ManageMedication
    StaffMenu -->|Manage Invoices| ManageInvoice
    StaffMenu -->|Manage Users (Patients Only)| ManageUserPatient
    StaffMenu -->|Generate Reports| GenerateReports
    StaffMenu -->|Logout| Logout
    
    %% Patient Use Cases
    PatientDashboard --> PatientMenu{Patient Menu}
    PatientMenu -->|Manage My Information| ManagePatientInfo
    PatientMenu -->|Book Appointment| BookAppointment
    PatientMenu -->|Logout| Logout
    
    %% Include Use Cases (Common Processes)
    ManageAppointment --> IncludeValidateAvailability[<<include>> Validate Doctor Availability]
    ManageAppointment --> IncludeCheckConflicts[<<include>> Check Time Conflicts]
    ManageAppointment --> IncludeSendNotification[<<include>> Send Appointment Notification]
    
    ManageConsultation --> IncludeRecordVitals[<<include>> Record Vital Signs]
    ManageConsultation --> IncludeCreatePrescription[<<include>> Create Prescription]
    ManageConsultation --> IncludeUpdateMedicalRecord[<<include>> Update Medical Record]
    
    ManageMedication --> IncludeCheckInventory[<<include>> Check Medication Inventory]
    ManageMedication --> IncludeValidatePrescription[<<include>> Validate Prescription]
    ManageMedication --> IncludeUpdateStock[<<include>> Update Stock Levels]
    
    ManageInvoice --> IncludeCalculateCharges[<<include>> Calculate Service Charges]
    ManageInvoice --> IncludeGenerateInvoice[<<include>> Generate Invoice Document]
    ManageInvoice --> IncludeProcessPayment[<<include>> Process Payment]
    
    BookAppointment --> IncludeValidateAvailability
    BookAppointment --> IncludeCheckConflicts
    BookAppointment --> IncludeSendNotification
    
    %% Extend Use Cases (Optional Processes)
    ManageAppointment --> ExtendReschedule[<<extend>> Reschedule Appointment]
    ManageAppointment --> ExtendCancel[<<extend>> Cancel Appointment]
    
    ManageConsultation --> ExtendFollowUp[<<extend>> Schedule Follow-up]
    ManageConsultation --> ExtendReferral[<<extend>> Create Referral]
    
    ManagePatientInfo --> ExtendUpdateProfile[<<extend>> Update Profile Photo]
    ManagePatientInfo --> ExtendEmergencyContact[<<extend>> Update Emergency Contact]
    
    GenerateReports --> ExtendExportReport[<<extend>> Export Report]
    GenerateReports --> ExtendScheduleReport[<<extend>> Schedule Recurring Report]
    
    %% Logout Process
    Logout --> End([End])
    
    %% Styling
    classDef primaryUseCase fill:#e1f5fe,stroke:#01579b,stroke-width:2px
    classDef includeUseCase fill:#f3e5f5,stroke:#4a148c,stroke-width:2px
    classDef extendUseCase fill:#e8f5e8,stroke:#1b5e20,stroke-width:2px
    classDef decision fill:#fff3e0,stroke:#e65100,stroke-width:2px
    
    class ManageAppointment,ManagePatientInfo,ManageConsultation,ManageMedication,ManageInvoice,ManageUser,GenerateReports,BookAppointment primaryUseCase
    class IncludeValidateAvailability,IncludeCheckConflicts,IncludeSendNotification,IncludeRecordVitals,IncludeCreatePrescription,IncludeUpdateMedicalRecord,IncludeCheckInventory,IncludeValidatePrescription,IncludeUpdateStock,IncludeCalculateCharges,IncludeGenerateInvoice,IncludeProcessPayment includeUseCase
    class ExtendReschedule,ExtendCancel,ExtendFollowUp,ExtendReferral,ExtendUpdateProfile,ExtendEmergencyContact,ExtendExportReport,ExtendScheduleReport extendUseCase
    class Auth,RoleCheck,AdminMenu,StaffMenu,PatientMenu decision
```

## Detailed Use Case Explanations

### Primary Use Cases

#### 1. Login
- **Actors**: Admin/Doctor, Staff, Patient
- **Description**: Authenticate user credentials and establish session
- **Preconditions**: User has valid account
- **Postconditions**: User is logged in and redirected to appropriate dashboard

#### 2. Manage Appointment
- **Actors**: Admin/Doctor, Staff
- **Description**: Create, view, update, and manage appointment schedules
- **Includes**: Validate Doctor Availability, Check Time Conflicts, Send Appointment Notification
- **Extends**: Reschedule Appointment, Cancel Appointment

#### 3. Manage Patient Information
- **Actors**: Admin/Doctor, Staff, Patient
- **Description**: View and update patient personal and medical information
- **Extends**: Update Profile Photo, Update Emergency Contact
- **Note**: Patients can only manage their own information

#### 4. Manage Consultation
- **Actors**: Admin/Doctor, Staff
- **Description**: Conduct medical consultations, record findings, and create treatment plans
- **Includes**: Record Vital Signs, Create Prescription, Update Medical Record
- **Extends**: Schedule Follow-up, Create Referral

#### 5. Manage Medication
- **Actors**: Admin/Doctor, Staff
- **Description**: Manage medication inventory and prescriptions
- **Includes**: Check Medication Inventory, Validate Prescription, Update Stock Levels

#### 6. Manage Invoice
- **Actors**: Admin/Doctor, Staff
- **Description**: Create, view, and manage billing invoices
- **Includes**: Calculate Service Charges, Generate Invoice Document, Process Payment

#### 7. Manage User
- **Actors**: Admin/Doctor, Staff (limited to patients)
- **Description**: Manage user accounts and permissions
- **Note**: Staff can only manage patient accounts

#### 8. Generate Reports
- **Actors**: Admin/Doctor, Staff
- **Description**: Generate various system reports and analytics
- **Extends**: Export Report, Schedule Recurring Report

#### 9. Book Appointment
- **Actors**: Patient
- **Description**: Schedule new appointments with available doctors
- **Includes**: Validate Doctor Availability, Check Time Conflicts, Send Appointment Notification

#### 10. Logout
- **Actors**: Admin/Doctor, Staff, Patient
- **Description**: End user session and return to login screen

### Include Use Cases (Common Processes)

#### Validate Doctor Availability
- **Description**: Check if selected doctor is available for the requested time
- **Used by**: Manage Appointment, Book Appointment

#### Check Time Conflicts
- **Description**: Verify no scheduling conflicts exist for the requested time slot
- **Used by**: Manage Appointment, Book Appointment

#### Send Appointment Notification
- **Description**: Send confirmation/update notifications to relevant parties
- **Used by**: Manage Appointment, Book Appointment

#### Record Vital Signs
- **Description**: Record patient's vital signs during consultation
- **Used by**: Manage Consultation

#### Create Prescription
- **Description**: Generate prescription for prescribed medications
- **Used by**: Manage Consultation

#### Update Medical Record
- **Description**: Update patient's medical history with consultation findings
- **Used by**: Manage Consultation

#### Check Medication Inventory
- **Description**: Verify medication availability in inventory
- **Used by**: Manage Medication

#### Validate Prescription
- **Description**: Validate prescription details and drug interactions
- **Used by**: Manage Medication

#### Update Stock Levels
- **Description**: Update medication inventory levels
- **Used by**: Manage Medication

#### Calculate Service Charges
- **Description**: Calculate total charges for services provided
- **Used by**: Manage Invoice

#### Generate Invoice Document
- **Description**: Create formatted invoice document
- **Used by**: Manage Invoice

#### Process Payment
- **Description**: Handle payment processing for invoices
- **Used by**: Manage Invoice

### Extend Use Cases (Optional Processes)

#### Reschedule Appointment
- **Description**: Change appointment date/time when needed
- **Extends**: Manage Appointment

#### Cancel Appointment
- **Description**: Cancel existing appointments
- **Extends**: Manage Appointment

#### Schedule Follow-up
- **Description**: Schedule follow-up appointments after consultation
- **Extends**: Manage Consultation

#### Create Referral
- **Description**: Create referral to specialist or other healthcare provider
- **Extends**: Manage Consultation

#### Update Profile Photo
- **Description**: Upload or change user profile photo
- **Extends**: Manage Patient Information

#### Update Emergency Contact
- **Description**: Update emergency contact information
- **Extends**: Manage Patient Information

#### Export Report
- **Description**: Export generated reports in various formats
- **Extends**: Generate Reports

#### Schedule Recurring Report
- **Description**: Set up automated recurring report generation
- **Extends**: Generate Reports

## System Flow Summary

1. **Authentication Phase**: All users start with login process
2. **Role-based Access**: System routes users to appropriate dashboards based on role
3. **Core Operations**: Each role has access to specific use cases based on permissions
4. **Shared Processes**: Common operations use include relationships for consistency
5. **Optional Extensions**: Additional features available through extend relationships
6. **Session Management**: All users can logout to end their session

This activity diagram provides a comprehensive view of the iWellCare system's core functionality, showing how different user roles interact with the system and how use cases are organized through include and extend relationships.
