# iWellCare Healthcare Management System - Complete ERD with Actions, Notations & Cardinality

This document contains the complete Entity Relationship Diagram for the iWellCare Healthcare Management System using Mermaid syntax, including action words, notation explanations, and cardinality mappings.

## Complete ERD with Actions and Cardinality

```mermaid
erDiagram
    %% Level 1: User Management - "REGISTER & AUTHENTICATE"
    users {
        bigint id PK
        string username
        string email
        string password
        string first_name
        string last_name
        string middle_name
        date date_of_birth
        string gender
        string phone_number
        string street_address
        string city
        string state_province
        string postal_code
        string country
        string role
        boolean is_active
        string profile_photo
        datetime created_at
        datetime updated_at
    }

    %% Level 2: Profile Creation - "CREATE PROFILES"
    patients {
        bigint id PK
        bigint user_id FK
        string first_name
        string last_name
        string contact
        string email
        string address
        date date_of_birth
        string gender
        string blood_type
        string emergency_contact
        string emergency_contact_phone
        string medical_history
        string allergies
        string current_medications
        string insurance_provider
        string insurance_number
        datetime registration_date
        boolean is_active
        datetime created_at
        datetime updated_at
    }

    doctors {
        bigint id PK
        bigint user_id FK
        string specialization
        string license_number
        int years_of_experience
        string qualifications
        string bio
        string status
        decimal consultation_fee
        string available_days
        string available_hours
        string contact_number
        string emergency_contact
        string address
        string city
        string state
        string postal_code
        string country
        datetime created_at
        datetime updated_at
    }

    %% Level 3: Appointment Scheduling - "SCHEDULE APPOINTMENTS"
    appointments {
        bigint id PK
        bigint patient_id FK
        bigint doctor_id FK
        date appointment_date
        time appointment_time
        string type
        string status
        string notes
        string symptoms
        string priority
        int duration
        string room_number
        bigint created_by FK
        bigint updated_by FK
        datetime created_at
        datetime updated_at
    }

    %% Level 4: Medical Consultation - "CONDUCT CONSULTATIONS"
    consultations {
        bigint id PK
        bigint appointment_id FK
        bigint patient_id FK
        bigint doctor_id FK
        date consultation_date
        time consultation_time
        string status
        string chief_complaint
        string present_illness
        string past_medical_history
        string family_history
        string social_history
        string clinical_measurements
        string symptoms
        string diagnosis
        string treatment_plan
        string prescription
        string notes
        datetime created_at
        datetime updated_at
    }

    %% Level 5: Record Keeping - "MAINTAIN RECORDS"
    medical_records {
        bigint id PK
        bigint patient_id FK
        bigint doctor_id FK
        bigint appointment_id FK
        string record_number
        date record_date
        string chief_complaint
        string present_illness
        string past_medical_history
        string family_history
        string social_history
        string review_of_systems
        string physical_examination
        string diagnosis
        string treatment_plan
        string medications_prescribed
        string lab_results
        string imaging_results
        string clinical_measurements
        string allergies
        string notes
        string status
        string record_type
        boolean is_confidential
        datetime created_at
        datetime updated_at
    }

    prescriptions {
        bigint id PK
        bigint patient_id FK
        bigint doctor_id FK
        bigint appointment_id FK
        string prescription_number
        date prescription_date
        string diagnosis
        string notes
        string instructions
        string status
        date valid_until
        boolean is_printed
        datetime printed_at
        datetime created_at
        datetime updated_at
    }

    %% Level 6: Financial Management - "PROCESS BILLING"
    billings {
        bigint id PK
        bigint patient_id FK
        bigint appointment_id FK
        decimal amount
        decimal consultation_fee
        decimal medication_fee
        decimal laboratory_fee
        decimal other_fees
        decimal total_amount
        string status
        date payment_date
        datetime created_at
        datetime updated_at
    }

    %% Supporting Systems - "MANAGE SUPPORT"
    inventory {
        bigint id PK
        string name
        string description
        string category
        int quantity
        int reorder_level
        date expiration_date
        decimal unit_price
        string supplier
        string location
        string batch_number
        string notes
        bigint created_by FK
        bigint updated_by FK
        datetime last_updated
        boolean is_active
        boolean archived
        datetime created_at
        datetime updated_at
    }

    otp_codes {
        bigint id PK
        string email
        string code
        string type
        datetime expires_at
        boolean is_used
        datetime created_at
        datetime updated_at
    }

    %% Relationships with Actions and Cardinality
    %% 1..1 relationships (One-to-One)
    users ||--|| patients : "REGISTERS"
    users ||--|| doctors : "EMPLOYS"
    appointments ||--|| consultations : "TRIGGERS"
    appointments ||--|| billings : "GENERATES"
    consultations ||--|| medical_records : "CREATES"
    consultations ||--|| prescriptions : "ISSUES"

    %% 1..* relationships (One-to-Many)
    users ||--o{ inventory : "MANAGES"
    users ||--o{ otp_codes : "VERIFIES"
    patients ||--o{ appointments : "BOOKS"
    doctors ||--o{ appointments : "ACCEPTS"
```

## Complete Cardinality Mapping with Actions

### **1..1 Relationships (One-to-One)**
```mermaid
erDiagram
    %% 1..1 = One user registers exactly one patient
    users ||--|| patients : "REGISTERS"
    
    %% 1..1 = One user employs exactly one doctor
    users ||--|| doctors : "EMPLOYS"
    
    %% 1..1 = One appointment triggers exactly one consultation
    appointments ||--|| consultations : "TRIGGERS"
    
    %% 1..1 = One appointment generates exactly one billing
    appointments ||--|| billings : "GENERATES"
    
    %% 1..1 = One consultation creates exactly one medical record
    consultations ||--|| medical_records : "CREATES"
    
    %% 1..1 = One consultation issues exactly one prescription
    consultations ||--|| prescriptions : "ISSUES"
```

**Cardinality**: `1..1` = **Exactly One to Exactly One**
- **Action**: Each entity performs one specific action with one other entity
- **Example**: One user registers one patient, one appointment triggers one consultation

### **1..* Relationships (One-to-Many)**
```mermaid
erDiagram
    %% 1..* = One user manages many inventory items
    users ||--o{ inventory : "MANAGES"
    
    %% 1..* = One user verifies many OTP codes
    users ||--o{ otp_codes : "VERIFIES"
    
    %% 1..* = One patient books many appointments
    patients ||--o{ appointments : "BOOKS"
    
    %% 1..* = One doctor accepts many appointments
    doctors ||--o{ appointments : "ACCEPTS"
```

**Cardinality**: `1..*` = **One to Many**
- **Action**: One entity performs actions with multiple instances of another entity
- **Example**: One patient can book multiple appointments, one doctor can accept multiple appointments

## Complete Notation Reference

### **Mermaid ERD Notations**
```mermaid
erDiagram
    %% Entity Definition
    entity_name {
        data_type field_name PK/FK
    }
    
    %% Relationship Types
    entity1 ||--|| entity2 : "1..1 relationship"
    entity1 ||--o{ entity2 : "1..* relationship"
    entity1 o{--|| entity2 : "0..1 relationship"
    entity1 o{--o{ entity2 : "0..* relationship"
```

### **Cardinality Notations with Actions**

| **Cardinality** | **Mermaid** | **Action Example** | **What Happens** |
|-----------------|--------------|-------------------|-------------------|
| **`1..1`** | `\|\|--\|\|` | **"REGISTERS"** | One user registers one patient |
| **`1..*`** | `\|\|--o{` | **"BOOKS"** | One patient books many appointments |
| **`0..1`** | `o{--\|\|` | **"ASSIGNS"** | Zero or one doctor assigned to room |
| **`0..*`** | `o{--o{` | **"MANAGES"** | Zero or many inventory items managed |

## Action Flow with Cardinality

### **Level 1: User Management (1..1)**
```mermaid
erDiagram
    users ||--|| patients : "REGISTERS (1..1)"
    users ||--|| doctors : "EMPLOYS (1..1)"
```
**Actions**: 
- **REGISTERS**: One user creates one patient profile
- **EMPLOYS**: One user hires one doctor

### **Level 2: Profile Creation (1..*)**
```mermaid
erDiagram
    patients ||--o{ appointments : "BOOKS (1..*)"
    doctors ||--o{ appointments : "ACCEPTS (1..*)"
```
**Actions**:
- **BOOKS**: One patient can book multiple appointments
- **ACCEPTS**: One doctor can accept multiple appointments

### **Level 3: Appointment Processing (1..1)**
```mermaid
erDiagram
    appointments ||--|| consultations : "TRIGGERS (1..1)"
    appointments ||--|| billings : "GENERATES (1..1)"
```
**Actions**:
- **TRIGGERS**: One appointment triggers one consultation
- **GENERATES**: One appointment generates one billing record

### **Level 4: Medical Records (1..1)**
```mermaid
erDiagram
    consultations ||--|| medical_records : "CREATES (1..1)"
    consultations ||--|| prescriptions : "ISSUES (1..1)"
```
**Actions**:
- **CREATES**: One consultation creates one medical record
- **ISSUES**: One consultation issues one prescription

### **Supporting Systems (1..*)**
```mermaid
erDiagram
    users ||--o{ inventory : "MANAGES (1..*)"
    users ||--o{ otp_codes : "VERIFIES (1..*)"
```
**Actions**:
- **MANAGES**: One user manages multiple inventory items
- **VERIFIES**: One user verifies multiple OTP codes

## Complete System Flow with Actions and Cardinality

```mermaid
flowchart TD
    A[🔐 REGISTER USERS] --> B[👥 CREATE PROFILES]
    B --> C[📅 SCHEDULE APPOINTMENTS]
    C --> D[🩺 CONDUCT CONSULTATIONS]
    D --> E[📋 MAINTAIN RECORDS]
    E --> F[💰 PROCESS BILLING]
    
    %% Cardinality Indicators
    A1[1..1] --> A
    B1[1..*] --> B
    C1[1..1] --> C
    D1[1..1] --> D
    E1[1..1] --> E
    F1[1..1] --> F
    
    %% Action Words
    A2[REGISTER] --> A
    B2[CREATE] --> B
    C2[SCHEDULE] --> C
    D2[CONDUCT] --> D
    E2[MAINTAIN] --> E
    F2[PROCESS] --> F
```

## Action Words by Cardinality Level

| **Level** | **Cardinality** | **Action** | **Mermaid** | **What Happens** |
|-----------|------------------|------------|--------------|-------------------|
| 🔐 **1** | **1..1** | **"REGISTERS"** | `\|\|--\|\|` | One user registers one patient |
| 👥 **2** | **1..*** | **"BOOKS"** | `\|\|--o{` | One patient books many appointments |
| 📅 **3** | **1..1** | **"TRIGGERS"** | `\|\|--\|\|` | One appointment triggers one consultation |
| 🩺 **4** | **1..1** | **"CREATES"** | `\|\|--\|\|` | One consultation creates one medical record |
| 📋 **5** | **1..1** | **"ISSUES"** | `\|\|--\|\|` | One consultation issues one prescription |
| 💰 **6** | **1..1** | **"GENERATES"** | `\|\|--\|\|` | One appointment generates one billing |

## How to Read the Complete Notation

### **Step 1: Identify Cardinality**
```mermaid
users ||--|| patients : "REGISTERS"
```
- **`||--||`**: This is a `1..1` relationship
- **Cardinality**: One user relates to exactly one patient

### **Step 2: Read the Action**
- **"REGISTERS"**: The action performed by the user
- **What happens**: The user registers the patient

### **Step 3: Understand the Flow**
```mermaid
patients ||--o{ appointments : "BOOKS"
```
- **`||--o{`**: This is a `1..*` relationship
- **Cardinality**: One patient can relate to many appointments
- **Action**: The patient books multiple appointments

### **Step 4: Follow the Complete Chain**
1. **Users REGISTER patients** (1..1) → Patient profiles created
2. **Patients BOOK appointments** (1..*) → Multiple appointments scheduled
3. **Appointments TRIGGER consultations** (1..1) → One consultation per appointment
4. **Consultations CREATE records** (1..1) → One medical record per consultation

## Benefits of Complete Notation

- **🎯 Precise Relationships**: Shows exact cardinality between entities
- **🔄 Clear Actions**: Demonstrates what each entity does
- **📊 Mathematical Accuracy**: Uses standard ERD notation
- **👥 Stakeholder Clarity**: Both technical and non-technical people understand
- **🔍 System Analysis**: Helps identify bottlenecks and optimization opportunities

## Summary of Notations Used

| **Element** | **Notation** | **Purpose** |
|-------------|---------------|-------------|
| **Entity** | `entity_name {}` | Defines database tables |
| **Primary Key** | `PK` | Uniquely identifies records |
| **Foreign Key** | `FK` | Links to other tables |
| **One-to-One** | `\|\|--\|\|` | 1..1 relationship |
| **One-to-Many** | `\|\|--o{` | 1..* relationship |
| **Action Label** | `: "ACTION"` | Describes what happens |
| **Comments** | `%% text` | Organizes and explains |

Now you have the **complete ERD** with actions, Mermaid notations, and cardinality mappings! 🎉
