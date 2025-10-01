# iWellCare Healthcare Management System - ERD Documentation

## Overview
This document provides the Entity Relationship Diagram (ERD) for the iWellCare Healthcare Management System, a comprehensive healthcare management platform built with Laravel.

## System Architecture

### Core Entities

#### 1. Users (Authentication & Authorization)
- **Purpose**: Central authentication and user management
- **Key Features**:
  - Multi-role support (doctor, staff, patient)
  - Profile management
  - Availability tracking for doctors
  - Session management

#### 2. Patients
- **Purpose**: Patient information and medical profiles
- **Key Features**:
  - Personal and medical information
  - Insurance details
  - Emergency contacts
  - Medical history tracking

#### 3. Doctors
- **Purpose**: Doctor profiles and professional information
- **Key Features**:
  - Specialization and qualifications
  - License management
  - Availability scheduling
  - Consultation fees

#### 4. Appointments
- **Purpose**: Appointment scheduling and management
- **Key Features**:
  - Date and time scheduling
  - Priority levels
  - Status tracking
  - Room assignment

#### 5. Consultations
- **Purpose**: Medical consultation records
- **Key Features**:
  - Comprehensive medical notes
  - Diagnosis and treatment plans
  - Follow-up scheduling
  - Vital signs recording

#### 6. Prescriptions
- **Purpose**: Medication prescription management
- **Key Features**:
  - Prescription tracking
  - Validity periods
  - Status management
  - Print functionality

#### 7. Medical Records
- **Purpose**: Comprehensive patient medical history
- **Key Features**:
  - Complete medical documentation
  - Record categorization
  - Confidentiality controls
  - Archival system

#### 8. Billings
- **Purpose**: Financial transaction management
- **Key Features**:
  - Payment tracking
  - Status management
  - Amount calculation

#### 9. Medications
- **Purpose**: Pharmacy and inventory management
- **Key Features**:
  - Drug information
  - Stock management
  - Pricing
  - Expiration tracking

## Key Relationships

### 1. User Role Management
- **Users → Patients**: One-to-one relationship (a user can have one patient profile)
- **Users → Doctors**: One-to-one relationship (a user can have one doctor profile)

### 2. Patient Care Workflow
- **Patients → Appointments**: One-to-many (patients can have multiple appointments)
- **Appointments → Consultations**: One-to-one (appointments lead to consultations)
- **Consultations → Prescriptions**: One-to-many (consultations can result in multiple prescriptions)
- **Consultations → Medical Records**: One-to-many (consultations generate medical records)

### 3. Doctor Management
- **Doctors → Appointments**: One-to-many (doctors conduct multiple appointments)
- **Doctors → Consultations**: One-to-many (doctors conduct multiple consultations)
- **Doctors → Prescriptions**: One-to-many (doctors prescribe multiple medications)

### 4. Medication Management
- **Medications → Prescriptions**: One-to-many (medications can be prescribed multiple times)
- **Users → Medications**: One-to-many (staff manage medication inventory)

## Database Design Principles

### 1. Normalization
- The database follows 3NF (Third Normal Form)
- Proper foreign key relationships
- Minimal data redundancy

### 2. Scalability
- Indexed foreign keys for performance
- Proper data types for storage efficiency
- JSON fields for flexible data storage

### 3. Security
- Password hashing
- Role-based access control
- Audit trails through activity logs

### 4. Data Integrity
- Foreign key constraints
- Check constraints for enums
- Unique constraints where appropriate

## File Structure

### ERD Files
- `iWellCare_ERD_Diagram.puml`: Complete detailed ERD with all entities and relationships
- `iWellCare_ERD_Simplified.puml`: Simplified ERD focusing on core entities

### How to View
1. Use PlantUML to render the .puml files
2. Online PlantUML editor: http://www.plantuml.com/plantuml/
3. VS Code extension: PlantUML
4. IntelliJ IDEA plugin: PlantUML integration

## System Features

### 1. User Management
- Multi-role authentication
- Profile management
- Session handling

### 2. Appointment System
- Scheduling and booking
- Status tracking
- Priority management
- Room assignment

### 3. Medical Records
- Comprehensive documentation
- History tracking
- Confidentiality controls
- Archival system

### 4. Prescription Management
- Digital prescriptions
- Validity tracking
- Print functionality
- Status management

### 5. Billing System
- Payment tracking
- Status management
- Financial reporting

### 6. Inventory Management
- Medication tracking
- Stock management
- Expiration monitoring
- Reorder alerts

## Technical Stack

- **Framework**: Laravel (PHP)
- **Database**: MySQL
- **Authentication**: Laravel Sanctum
- **Frontend**: Blade templates with CSS/JavaScript
- **File Storage**: Local file system
- **PDF Generation**: DomPDF

## Security Considerations

1. **Authentication**: Secure password hashing
2. **Authorization**: Role-based access control
3. **Data Protection**: Input validation and sanitization
4. **Audit Trail**: Activity logging for all operations
5. **Session Management**: Secure session handling

## Performance Optimizations

1. **Database Indexing**: Strategic indexes on foreign keys and frequently queried fields
2. **Query Optimization**: Efficient Eloquent relationships
3. **Caching**: Session and query caching
4. **File Management**: Optimized file upload and storage

## Future Enhancements

1. **API Development**: RESTful API for mobile applications
2. **Real-time Features**: WebSocket integration for live updates
3. **Advanced Reporting**: Comprehensive analytics and reporting
4. **Integration**: Third-party healthcare system integration
5. **Mobile App**: Native mobile applications

## Conclusion

The iWellCare system provides a comprehensive healthcare management solution with a well-structured database design that supports scalability, security, and maintainability. The ERD demonstrates clear relationships between entities and follows database design best practices. 