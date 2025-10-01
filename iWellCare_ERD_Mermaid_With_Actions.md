# iWellCare Healthcare Management System - Mermaid ERD with Action Words

This document contains the Entity Relationship Diagram for the iWellCare Healthcare Management System using Mermaid syntax, including action words to show what happens at each level.

## ERD with Action Words and System Flow

```mermaid
erDiagram
    %% Level 1: User Management - "REGISTER & AUTHENTICATE"
    users {
        bigint id PK
        varchar username
        varchar email
        varchar password
        varchar first_name
        varchar last_name
        varchar middle_name
        date date_of_birth
        enum gender
        varchar phone_number
        varchar street_address
        varchar city
        varchar state_province
        varchar postal_code
        varchar country
        enum role
        boolean is_active
        varchar profile_photo
        timestamp created_at
        timestamp updated_at
    }

    %% Level 2: Profile Creation - "CREATE PROFILES"
    patients {
        bigint id PK
        bigint user_id FK
        varchar first_name
        varchar last_name
        varchar contact
        varchar email
        text address
        date date_of_birth
        enum gender
        varchar blood_type
        varchar emergency_contact
        varchar emergency_contact_phone
        text medical_history
        text allergies
        text current_medications
        varchar insurance_provider
        varchar insurance_number
        timestamp registration_date
        boolean is_active
        timestamp created_at
        timestamp updated_at
    }

    doctors {
        bigint id PK
        bigint user_id FK
        varchar specialization
        varchar license_number
        int years_of_experience
        text qualifications
        text bio
        enum status
        decimal consultation_fee
        json available_days
        json available_hours
        varchar contact_number
        varchar emergency_contact
        text address
        varchar city
        varchar state
        varchar postal_code
        varchar country
        timestamp created_at
        timestamp updated_at
    }

    %% Level 3: Appointment Scheduling - "SCHEDULE APPOINTMENTS"
    appointments {
        bigint id PK
        bigint patient_id FK
        bigint doctor_id FK
        date appointment_date
        time appointment_time
        varchar type
        enum status
        text notes
        text symptoms
        enum priority
        int duration
        varchar room_number
        bigint created_by FK
        bigint updated_by FK
        timestamp created_at
        timestamp updated_at
    }

    %% Level 4: Medical Consultation - "CONDUCT CONSULTATIONS"
    consultations {
        bigint id PK
        bigint appointment_id FK
        bigint patient_id FK
        bigint doctor_id FK
        date consultation_date
        time consultation_time
        enum status
        text chief_complaint
        text present_illness
        text past_medical_history
        text family_history
        text social_history
        json clinical_measurements
        text symptoms
        text diagnosis
        text treatment_plan
        text prescription
        text notes
        timestamp created_at
        timestamp updated_at
    }

    %% Level 5: Record Keeping - "MAINTAIN RECORDS"
    medical_records {
        bigint id PK
        bigint patient_id FK
        bigint doctor_id FK
        bigint appointment_id FK
        varchar record_number
        date record_date
        varchar chief_complaint
        text present_illness
        text past_medical_history
        text family_history
        text social_history
        text review_of_systems
        text physical_examination
        text diagnosis
        text treatment_plan
        text medications_prescribed
        text lab_results
        text imaging_results
        text clinical_measurements
        text allergies
        text notes
        enum status
        enum record_type
        boolean is_confidential
        timestamp created_at
        timestamp updated_at
    }

    prescriptions {
        bigint id PK
        bigint patient_id FK
        bigint doctor_id FK
        bigint appointment_id FK
        varchar prescription_number
        date prescription_date
        text diagnosis
        text notes
        text instructions
        enum status
        date valid_until
        boolean is_printed
        timestamp printed_at
        timestamp created_at
        timestamp updated_at
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
        varchar status
        date payment_date
        timestamp created_at
        timestamp updated_at
    }

    %% Supporting Systems - "MANAGE SUPPORT"
    inventory {
        bigint id PK
        varchar name
        text description
        enum category
        int quantity
        int reorder_level
        date expiration_date
        decimal unit_price
        varchar supplier
        varchar location
        varchar batch_number
        text notes
        bigint created_by FK
        bigint updated_by FK
        timestamp last_updated
        boolean is_active
        boolean archived
        timestamp created_at
        timestamp updated_at
    }

    otp_codes {
        bigint id PK
        varchar email
        varchar code
        enum type
        timestamp expires_at
        boolean is_used
        timestamp created_at
        timestamp updated_at
    }

    %% Relationships with Action Words
    users ||--|| patients : "REGISTERS"
    users ||--|| doctors : "EMPLOYS"
    users ||--o{ inventory : "MANAGES"
    users ||--o{ otp_codes : "VERIFIES"

    patients ||--o{ appointments : "BOOKS"
    doctors ||--o{ appointments : "ACCEPTS"

    appointments ||--|| consultations : "TRIGGERS"
    appointments ||--|| billings : "GENERATES"

    consultations ||--|| medical_records : "CREATES"
    consultations ||--|| prescriptions : "ISSUES"
```

## Complete Mermaid ERD Notations with Actions

### **1. Diagram Declaration Notation**
```mermaid
erDiagram
```
**Action**: **INITIATES** the Entity Relationship Diagram
- **What it does**: Tells Mermaid "This is an ERD diagram"
- **Required**: Must be the first line (case-sensitive)

### **2. Entity Definition Notation**
```mermaid
entity_name {
    data_type field_name PK/FK
}
```
**Action**: **DEFINES** a database table with its structure
- **`entity_name`**: Table name (e.g., `users`, `patients`)
- **`{}`**: Curly braces contain all table fields
- **`PK`**: Primary Key identifier
- **`FK`**: Foreign Key identifier

### **3. Data Type Notations**
```mermaid
bigint id PK          %% Action: IDENTIFIES unique records
string username       %% Action: STORES text data
date date_of_birth    %% Action: RECORDS dates
time appointment_time %% Action: CAPTURES time
datetime created_at   %% Action: TRACKS creation timestamps
decimal amount        %% Action: CALCULATES financial values
int quantity          %% Action: COUNTS items
boolean is_active     %% Action: CONTROLS status
json available_days   %% Action: STORES structured data
```

### **4. Relationship Notations with Actions**

#### **One-to-One Relationship**
```mermaid
users ||--|| patients : "REGISTERS"
```
**Action**: **REGISTERS** - One user creates one patient profile
- **`||--||`**: One-to-one relationship
- **Action Word**: "REGISTERS" (what the user does)

#### **One-to-Many Relationship**
```mermaid
patients ||--o{ appointments : "BOOKS"
```
**Action**: **BOOKS** - One patient can book many appointments
- **`||--o{`**: One-to-many relationship
- **Action Word**: "BOOKS" (what the patient does)

#### **Many-to-Many Relationship**
```mermaid
doctors o{--o{ specializations : "HAS"
```
**Action**: **HAS** - Doctors can have multiple specializations
- **`o{--o{`**: Many-to-many relationship
- **Action Word**: "HAS" (what the doctor possesses)

### **5. Comment Notations**
```mermaid
%% Level 1: User Management - "REGISTER & AUTHENTICATE"
```
**Action**: **ORGANIZES** and **EXPLAINS** diagram sections
- **`%%`**: Starts a comment line
- **Purpose**: Groups related entities and explains their function

### **6. Field Constraint Notations**
```mermaid
bigint user_id FK     %% Action: LINKS to users table
bigint id PK          %% Action: UNIQUELY IDENTIFIES records
enum status           %% Action: RESTRICTS to predefined values
boolean is_active     %% Action: ENABLES/DISABLES records
```

## Action-Oriented Relationship Examples

### **User Management Actions**
```mermaid
erDiagram
    users {
        bigint id PK
        string username
        string email
        string role
    }
    
    patients {
        bigint id PK
        bigint user_id FK
        string first_name
        string last_name
    }
    
    doctors {
        bigint id PK
        bigint user_id FK
        string specialization
    }
    
    %% Action: REGISTERS (creates patient profile)
    users ||--|| patients : "REGISTERS"
    
    %% Action: EMPLOYS (hires doctor)
    users ||--|| doctors : "EMPLOYS"
```

**Actions Explained**:
- **"REGISTERS"**: Users register patients into the system
- **"EMPLOYS"**: Users hire and employ doctors

### **Appointment Flow Actions**
```mermaid
erDiagram
    patients {
        bigint id PK
        string first_name
    }
    
    doctors {
        bigint id PK
        string specialization
    }
    
    appointments {
        bigint id PK
        bigint patient_id FK
        bigint doctor_id FK
        date appointment_date
    }
    
    %% Action: BOOKS (patient schedules appointment)
    patients ||--o{ appointments : "BOOKS"
    
    %% Action: ACCEPTS (doctor accepts appointment)
    doctors ||--o{ appointments : "ACCEPTS"
```

**Actions Explained**:
- **"BOOKS"**: Patients book multiple appointments
- **"ACCEPTS"**: Doctors accept multiple appointments

### **Medical Process Actions**
```mermaid
erDiagram
    appointments {
        bigint id PK
        date appointment_date
    }
    
    consultations {
        bigint id PK
        bigint appointment_id FK
        text diagnosis
    }
    
    medical_records {
        bigint id PK
        bigint appointment_id FK
        text notes
    }
    
    %% Action: TRIGGERS (appointment starts consultation)
    appointments ||--|| consultations : "TRIGGERS"
    
    %% Action: CREATES (consultation creates medical record)
    consultations ||--|| medical_records : "CREATES"
```

**Actions Explained**:
- **"TRIGGERS"**: Appointment triggers the consultation process
- **"CREATES"**: Consultation creates medical records

## Complete Action Flow Notation

```mermaid
erDiagram
    %% Level 1: REGISTER & AUTHENTICATE
    users ||--|| patients : "REGISTERS"
    users ||--|| doctors : "EMPLOYS"
    
    %% Level 2: CREATE PROFILES
    patients ||--o{ appointments : "BOOKS"
    doctors ||--o{ appointments : "ACCEPTS"
    
    %% Level 3: SCHEDULE APPOINTMENTS
    appointments ||--|| consultations : "TRIGGERS"
    appointments ||--|| billings : "GENERATES"
    
    %% Level 4: CONDUCT CONSULTATIONS
    consultations ||--|| medical_records : "CREATES"
    consultations ||--|| prescriptions : "ISSUES"
    
    %% Supporting Actions
    users ||--o{ inventory : "MANAGES"
    users ||--o{ otp_codes : "VERIFIES"
```

## Action Words by System Level

| **Level** | **Notation** | **Action** | **What Happens** |
|-----------|---------------|------------|-------------------|
| 🔐 **1** | `users \|\|--\|\| patients` | **"REGISTERS"** | Users register patients |
| 👥 **2** | `patients \|\|--o{ appointments` | **"BOOKS"** | Patients book appointments |
| 📅 **3** | `appointments \|\|--\|\| consultations` | **"TRIGGERS"** | Appointments trigger consultations |
| 🩺 **4** | `consultations \|\|--\|\| medical_records` | **"CREATES"** | Consultations create records |
| 📋 **5** | `consultations \|\|--\|\| prescriptions` | **"ISSUES"** | Consultations issue prescriptions |
| 💰 **6** | `appointments \|\|--\|\| billings` | **"GENERATES"** | Appointments generate bills |

## How to Read Action-Oriented Notations

### **Step 1: Identify the Entities**
```mermaid
users ||--|| patients : "REGISTERS"
```
- **Left Entity**: `users` (who performs the action)
- **Right Entity**: `patients` (who receives the action)

### **Step 2: Understand the Relationship Type**
- **`||--||`**: One-to-one (one user registers one patient)
- **`||--o{`**: One-to-many (one patient books many appointments)
- **`o{--o{`**: Many-to-many (many doctors have many specializations)

### **Step 3: Read the Action Word**
- **"REGISTERS"**: The user registers the patient
- **"BOOKS"**: The patient books appointments
- **"TRIGGERS"**: The appointment triggers the consultation

### **Step 4: Follow the Flow**
1. **Users REGISTER patients** → Patient profiles created
2. **Patients BOOK appointments** → Appointments scheduled
3. **Appointments TRIGGER consultations** → Medical process begins
4. **Consultations CREATE records** → Medical history maintained

## Benefits of Action-Oriented Notations

- **🎯 Clear Intent**: Shows what each entity does
- **🔄 Process Flow**: Illustrates the system workflow
- **👥 Stakeholder Understanding**: Non-technical people can follow the process
- **📚 Documentation**: Perfect for training and SOPs
- **🔍 System Analysis**: Helps identify bottlenecks and improvements

## Corrected ERD with Your Data Types

Here's the corrected version using your preferred data type notation:

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

    %% Relationships with Action Words
    users ||--|| patients : "REGISTERS"
    users ||--|| doctors : "EMPLOYS"
    users ||--o{ inventory : "MANAGES"
    users ||--o{ otp_codes : "VERIFIES"

    patients ||--o{ appointments : "BOOKS"
    doctors ||--o{ appointments : "ACCEPTS"

    appointments ||--|| consultations : "TRIGGERS"
    appointments ||--|| billings : "GENERATES"

    consultations ||--|| medical_records : "CREATES"
    consultations ||--|| prescriptions : "ISSUES"
```

## Key Mermaid ERD Notation Elements

### **1. Diagram Declaration**
```mermaid
erDiagram
```
- **Must start with**: `erDiagram` (case-sensitive)
- **This tells Mermaid**: "This is an Entity Relationship Diagram"

### **2. Entity Definition**
```mermaid
entity_name {
    data_type field_name PK/FK
}
```
- **Entity name**: Table name in lowercase
- **Curly braces**: `{}` contain the entity attributes
- **PK**: Primary Key identifier
- **FK**: Foreign Key identifier

### **3. Data Types**
- **`bigint`**: Large integer (64-bit)
- **`string`**: Variable-length character string
- **`date`**: Date only (YYYY-MM-DD)
- **`time`**: Time only (HH:MM:SS)
- **`datetime`**: Date and time combined
- **`decimal`**: Decimal number with precision
- **`int`**: Integer (32-bit)
- **`boolean`**: True/False value
- **`json`**: JSON formatted data

### **4. Relationship Syntax**
```mermaid
entity1 ||--|| entity2 : "relationship_label"
```
- **`||--||`**: One-to-one relationship
- **`||--o{`**: One-to-many relationship
- **`o{--o{`**: Many-to-many relationship
- **`relationship_label`**: Description of the relationship

### **5. Comments**
```mermaid
%% This is a comment
```
- **`%%`**: Starts a comment line
- **Useful for**: Organizing sections, explaining relationships

## Action-Oriented System Flow Diagram

```mermaid
flowchart TD
    A[🔐 REGISTER USERS] --> B[👥 CREATE PROFILES]
    B --> C[📅 SCHEDULE APPOINTMENTS]
    C --> D[🩺 CONDUCT CONSULTATIONS]
    D --> E[📋 MAINTAIN RECORDS]
    E --> F[💰 PROCESS BILLING]
    
    B --> B1[👤 Patient Profile]
    B --> B2[👨‍⚕️ Doctor Profile]
    
    E --> E1[📊 Medical Records]
    E --> E2[💊 Prescriptions]
    
    G[🔧 SUPPORTING SYSTEMS] --> G1[📦 Inventory Management]
    G --> G2[🔐 OTP Verification]
    G --> G3[🛡️ Security & Access Control]
    
    A -.-> G
    B -.-> G
    
    %% Action Verbs
    A1[REGISTER] --> A
    B1[CREATE] --> B
    C1[SCHEDULE] --> C
    D1[CONDUCT] --> D
    E1[MAINTAIN] --> E
    F1[PROCESS] --> F
    G1[MANAGE] --> G
```

## Detailed Action Flow with Verbs

```mermaid
flowchart TD
    %% User Management Actions
    A[🔐 REGISTER & AUTHENTICATE] --> A1[Create Account]
    A --> A2[Set Role]
    A --> A3[Enable/Disable Access]
    
    %% Profile Creation Actions
    B[👥 CREATE PROFILES] --> B1[Register Patient]
    B --> B2[Hire Doctor]
    B --> B3[Collect Information]
    B --> B4[Verify Credentials]
    
    %% Appointment Actions
    C[📅 SCHEDULE APPOINTMENTS] --> C1[Check Availability]
    C --> C2[Book Time Slot]
    C --> C3[Assign Room]
    C --> C4[Send Confirmations]
    
    %% Consultation Actions
    D[🩺 CONDUCT CONSULTATIONS] --> D1[Examine Patient]
    D --> D2[Record Symptoms]
    D --> D3[Make Diagnosis]
    D --> D4[Plan Treatment]
    
    %% Record Actions
    E[📋 MAINTAIN RECORDS] --> E1[Update Medical History]
    E --> E2[Issue Prescriptions]
    E --> E3[Store Lab Results]
    E --> E4[Track Progress]
    
    %% Billing Actions
    F[💰 PROCESS BILLING] --> F1[Calculate Fees]
    F --> F2[Generate Invoice]
    F --> F3[Process Payment]
    F --> F4[Send Receipts]
    
    %% Supporting Actions
    G[🔧 SUPPORTING SYSTEMS] --> G1[Track Inventory]
    G --> G2[Verify OTP]
    G --> G3[Manage Security]
    G --> G4[Monitor Access]
```

## Action Words Summary by Level

### **Level 1: User Management** 🔐
- **Action**: REGISTER & AUTHENTICATE
- **Verbs**: Create, Login, Verify, Enable, Disable
- **What Happens**: Users sign up, get authenticated, and access the system

### **Level 2: Profile Creation** 👥
- **Action**: CREATE PROFILES
- **Verbs**: Register, Hire, Collect, Verify, Store
- **What Happens**: Patient and doctor profiles are created with detailed information

### **Level 3: Appointment Scheduling** 📅
- **Action**: SCHEDULE APPOINTMENTS
- **Verbs**: Check, Book, Assign, Send, Confirm
- **What Happens**: Appointments are scheduled, rooms assigned, confirmations sent

### **Level 4: Medical Consultation** 🩺
- **Action**: CONDUCT CONSULTATIONS
- **Verbs**: Examine, Record, Diagnose, Plan, Treat
- **What Happens**: Doctors examine patients, make diagnoses, and plan treatments

### **Level 5: Record Keeping** 📋
- **Action**: MAINTAIN RECORDS
- **Verbs**: Update, Issue, Store, Track, Maintain
- **What Happens**: Medical records are updated, prescriptions issued, progress tracked

### **Level 6: Financial Management** 💰
- **Action**: PROCESS BILLING
- **Verbs**: Calculate, Generate, Process, Send, Collect
- **What Happens**: Bills are calculated, invoices generated, payments processed

### **Supporting Systems** 🔧
- **Action**: MANAGE SUPPORT
- **Verbs**: Track, Verify, Monitor, Manage, Control
- **What Happens**: Inventory tracked, security verified, access controlled

## How to Use These Action-Oriented Diagrams

1. **Copy the Mermaid code** from any section above
2. **Paste into Mermaid-compatible editors**:
   - GitHub/GitLab (in Markdown files)
   - Notion
   - Mermaid Live Editor: https://mermaid.live/
   - VS Code with Mermaid extension

3. **Use for different purposes**:
   - **Complete ERD**: For technical documentation
   - **Action Flow**: For stakeholder presentations
   - **Detailed Actions**: For process documentation

## Benefits of Action-Oriented Approach

- **Clear Process Flow**: Shows what happens at each step
- **Stakeholder Friendly**: Non-technical people can understand the system
- **Process Documentation**: Perfect for SOPs and training materials
- **System Analysis**: Helps identify bottlenecks and improvement areas
- **User Stories**: Supports agile development and requirements gathering
