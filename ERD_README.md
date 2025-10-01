# iWellCare ERD (Entity Relationship Diagram)

This repository contains Entity Relationship Diagrams for the iWellCare Healthcare Management System in PlantUML format.

## Files

1. **`iWellCare_ERD.puml`** - Complete ERD with all attributes and detailed relationships
2. **`iWellCare_ERD_Simplified.puml`** - Simplified ERD focusing on core entities and relationships
3. **`ERD_README.md`** - This documentation file

## How to View the ERD

### Option 1: Online PlantUML Viewer
1. Copy the content of any `.puml` file
2. Go to [PlantUML Online Server](http://www.plantuml.com/plantuml/uml/)
3. Paste the content and the diagram will be generated automatically

### Option 2: VS Code Extension
1. Install the "PlantUML" extension in VS Code
2. Open any `.puml` file
3. Right-click and select "Preview Current Diagram"

### Option 3: Local PlantUML Installation
1. Install Java Runtime Environment (JRE)
2. Download PlantUML JAR file from [PlantUML releases](https://github.com/plantuml/plantuml/releases)
3. Run: `java -jar plantuml.jar iWellCare_ERD.puml`

## System Overview

The iWellCare Healthcare Management System consists of the following core modules:

### 🔐 **User Management**
- **users** - Central user accounts with role-based access
- **otp_codes** - One-time password verification system

### 👥 **Patient Management**
- **patients** - Patient demographics and medical history
- **medical_records** - Comprehensive patient medical records

### 👨‍⚕️ **Doctor Management**
- **doctors** - Doctor profiles and specializations
- **doctor_availability_settings** - Doctor scheduling preferences

### 📅 **Appointment System**
- **appointments** - Patient appointment scheduling
- **consultations** - Medical consultation records

### 💊 **Medical Services**
- **prescriptions** - Medication prescriptions
- **medications** - Medication catalog

### 💰 **Billing System**
- **billings** - Financial billing and payment tracking

### 📦 **Inventory Management**
- **inventory** - Medical supplies and equipment
- **inventory_logs** - Inventory movement tracking

### 🔒 **Security & Sessions**
- **sessions** - User session management

## Key Relationships

### One-to-Many Relationships
- **users** → **patients** (one user can have one patient profile)
- **users** → **doctors** (one user can have one doctor profile)
- **patients** → **appointments** (one patient can have many appointments)
- **doctors** → **appointments** (one doctor can conduct many appointments)
- **appointments** → **consultations** (one appointment can lead to one consultation)
- **consultations** → **medical_records** (one consultation creates one medical record)
- **consultations** → **prescriptions** (one consultation can result in one prescription)

### Many-to-Many Relationships
- **prescriptions** ↔ **medications** (through prescription_medications table)

## Database Design Principles

1. **Normalization** - Tables are normalized to reduce data redundancy
2. **Referential Integrity** - Foreign key constraints maintain data consistency
3. **Audit Trail** - created_at, updated_at, and user tracking fields
4. **Soft Deletes** - is_active flags instead of hard deletes
5. **Role-Based Access** - User roles determine system access levels

## Data Flow

```
Patient Registration → Appointment Booking → Consultation → Medical Record → Prescription → Billing
     ↓
Inventory Management ← Prescription Medications ← Medication Catalog
```

## Notes

- **Primary Keys**: All tables use auto-incrementing bigint IDs
- **Timestamps**: Standard Laravel timestamp fields (created_at, updated_at)
- **Enums**: Used for status fields and categorical data
- **JSON Fields**: Used for flexible data structures (clinical_measurements, available_days)
- **Text Fields**: Used for long-form medical content
- **Decimal Fields**: Used for monetary amounts with 2 decimal places

## Modifications

To modify the ERD:
1. Edit the `.puml` files
2. Regenerate the diagrams using one of the viewing methods above
3. Update this README if adding new entities or relationships

## Support

For questions about the database design or ERD, refer to:
- `DATA_DICTIONARY.md` - Complete field definitions
- Database migration files in `database/migrations/`
- Model files in `app/Models/`
