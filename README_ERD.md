# iWellCare Healthcare Management System - Entity Relationship Diagrams

This repository contains comprehensive Entity Relationship Diagrams (ERDs) for the iWellCare Healthcare Management System, created in PlantUML format.

## Files Overview

### 1. `iWellCare_ERD.puml` - Detailed ERD
- **Complete database schema** with all fields and data types
- **All relationships** between entities
- **Full attribute details** for each table
- **Comprehensive view** of the entire system architecture

### 2. `iWellCare_ERD_Simplified.puml` - Simplified ERD
- **Core entities** and their key attributes
- **Essential relationships** without field-level details
- **Easier to read** and understand
- **Quick overview** of system structure

## System Overview

The iWellCare system is a comprehensive healthcare management platform with the following core modules:

### 🔐 User Management
- **Users**: Central authentication and role management
- **OTP Codes**: Two-factor authentication and verification
- **Sessions**: User session management

### 👨‍⚕️ Medical Staff Management
- **Doctors**: Physician profiles, specializations, and credentials
- **Doctor Availability Settings**: Scheduling and availability management

### 👥 Patient Management
- **Patients**: Patient demographics and medical history
- **Medical Records**: Comprehensive health records and documentation

### 📅 Appointment & Consultation
- **Appointments**: Scheduling and appointment management
- **Consultations**: Medical consultation records and documentation

### 💊 Prescription Management
- **Prescriptions**: Medication prescriptions and orders
- **Prescription Medications**: Detailed medication instructions

### 💰 Billing & Finance
- **Invoices**: Financial billing and payment tracking

### 📦 Inventory Management
- **Inventory**: Medical supplies, equipment, and medications
- **Inventory Logs**: Stock movement and adjustment tracking

## Key Relationships

### One-to-One Relationships
- User ↔ Doctor Profile
- User ↔ Patient Profile
- Appointment ↔ Consultation

### One-to-Many Relationships
- User → Appointments (as patient)
- Doctor → Appointments
- Patient → Medical Records
- Consultation → Prescriptions
- Prescription → Prescription Medications

### Many-to-Many Relationships
- Users ↔ Roles (through role field)
- Doctors ↔ Specializations (through specialization field)

## How to Use These ERDs

### Option 1: Online PlantUML Viewer
1. Copy the content of any `.puml` file
2. Visit [PlantUML Online Server](http://www.plantuml.com/plantuml/uml/)
3. Paste the content and view the diagram

### Option 2: VS Code Extension
1. Install the "PlantUML" extension in VS Code
2. Open any `.puml` file
3. Use `Ctrl+Shift+P` and run "PlantUML: Preview Current Diagram"

### Option 3: Local PlantUML Installation
1. Install Java Runtime Environment (JRE)
2. Install PlantUML JAR file
3. Run: `java -jar plantuml.jar iWellCare_ERD.puml`

### Option 4: Command Line (if PlantUML is installed)
```bash
plantuml iWellCare_ERD.puml
plantuml iWellCare_ERD_Simplified.puml
```

## Database Schema Highlights

### Core Tables
- **users**: Central user management with role-based access
- **doctors**: Extended doctor profiles and specializations
- **patients**: Patient demographics and medical information
- **appointments**: Scheduling and appointment tracking
- **consultations**: Medical consultation documentation
- **prescriptions**: Medication prescription management
- **medical_records**: Comprehensive health record storage
- **inventory**: Medical supply and equipment management
- **invoices**: Financial billing and payment tracking

### Supporting Tables
- **otp_codes**: Two-factor authentication
- **doctor_availability_settings**: Doctor scheduling
- **prescription_medications**: Detailed medication instructions
- **inventory_logs**: Stock movement tracking
- **sessions**: User session management
- **notifications**: System notifications
- **failed_jobs**: Background job failure tracking

## Business Logic

### Appointment Workflow
1. Patient books appointment
2. Staff confirms appointment
3. Doctor conducts consultation
4. Consultation generates medical records
5. Prescriptions are created if needed
6. Invoice is generated for billing

### User Role Hierarchy
- **Admin**: Full system access
- **Staff**: Patient management, scheduling, billing
- **Doctor**: Patient care, prescriptions, medical records
- **Patient**: Appointment booking, record viewing

### Data Integrity
- Foreign key constraints maintain referential integrity
- Soft deletes preserve historical data
- Audit trails track all changes
- Role-based access control ensures security

## Technical Specifications

### Database Engine
- **Primary**: MySQL/MariaDB
- **Compatible**: PostgreSQL, SQLite

### Framework
- **Backend**: Laravel (PHP)
- **Frontend**: Blade templates with Bootstrap
- **Authentication**: Laravel Sanctum

### Data Types
- **Primary Keys**: Auto-incrementing bigint
- **Timestamps**: Laravel standard created_at/updated_at
- **JSON Fields**: For flexible data storage (arrays, objects)
- **Enums**: For status and type fields

## Maintenance Notes

### Regular Tasks
- Monitor inventory levels and reorder points
- Review and archive old medical records
- Clean up expired OTP codes
- Audit user access and permissions

### Backup Strategy
- Daily database backups
- File storage backups for medical records
- Configuration backup for system settings

## Support and Documentation

For additional information about the iWellCare system:
- Check the main project documentation
- Review the Laravel application code
- Consult the database migration files
- Examine the model relationships in the codebase

---

*Generated from iWellCare Healthcare Management System - Laravel Application*
