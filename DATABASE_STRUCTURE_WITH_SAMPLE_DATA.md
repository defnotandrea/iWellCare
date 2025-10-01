# Complete Database Structure with Sample Data for iWellCare

## Overview
This document contains the complete database structure for the iWellCare healthcare management system with all field sizes properly specified according to Laravel migration standards and MySQL best practices. Below the structure, sample patient data with Filipino names is provided.

## Database Tables

### 1. users
| Field | Type | Size | Description |
|-------|------|------|-------------|
| id | BigInt | 20 | Primary Key, Auto Increment |
| username | String | 255 | Unique username, nullable |
| email | String | 255 | Unique email, nullable |
| email_verified_at | Timestamp | - | Email verification timestamp |
| password | String | 255 | Hashed password |
| first_name | String | 255 | User's first name |
| last_name | String | 255 | User's last name |
| middle_name | String | 255 | User's middle name, nullable |
| date_of_birth | Date | - | User's date of birth |
| gender | Enum | - | Gender: male, female, other |
| phone_number | String | 255 | Contact phone number |
| street_address | String | 255 | Street address |
| city | String | 255 | City name |
| state_province | String | 255 | State or province |
| postal_code | String | 255 | Postal/ZIP code |
| country | String | 255 | Country name |
| role | Enum | - | User role: doctor, staff, patient |
| is_active | Boolean | 1 | Account active status |
| profile_photo | String | 255 | Profile photo path |
| remember_token | String | 100 | Remember me token |
| created_at | Timestamp | - | Record creation time |
| updated_at | Timestamp | - | Record update time |

### 2. patients
| Field | Type | Size | Description |
|-------|------|------|-------------|
| id | BigInt | 20 | Primary Key, Auto Increment |
| user_id | BigInt | 20 | Foreign Key to users table |
| first_name | String | 255 | Patient's first name |
| last_name | String | 255 | Patient's last name |
| contact | String | 255 | Contact information |
| email | String | 255 | Patient's email |
| address | Text | - | Patient's address |
| date_of_birth | Date | - | Patient's date of birth |
| gender | Enum | - | Gender: male, female, other |
| blood_type | String | 5 | Blood type (A+, B-, etc.) |
| emergency_contact | String | 255 | Emergency contact name |
| emergency_contact_phone | String | 255 | Emergency contact phone |
| medical_history | Text | - | Medical history notes |
| allergies | Text | - | Known allergies |
| current_medications | Text | - | Current medications |
| insurance_provider | String | 255 | Insurance provider name |
| insurance_number | String | 255 | Insurance policy number |
| registration_date | Timestamp | - | Patient registration date |
| is_active | Boolean | 1 | Patient active status |
| created_at | Timestamp | - | Record creation time |
| updated_at | Timestamp | - | Record update time |

### 3. appointments
| Field | Type | Size | Description |
|-------|------|------|-------------|
| id | BigInt | 20 | Primary Key, Auto Increment |
| patient_id | BigInt | 20 | Foreign Key to patients table |
| doctor_id | BigInt | 20 | Foreign Key to users table |
| appointment_date | Date | - | Appointment date |
| appointment_time | Time | - | Appointment time |
| type | String | 255 | Appointment type |
| status | Enum | - | Status: pending, confirmed, completed, cancelled |
| notes | Text | - | Appointment notes |
| symptoms | Text | - | Patient symptoms |
| priority | Enum | - | Priority: low, medium, high, urgent |
| duration | Integer | 11 | Duration in minutes |
| room_number | String | 255 | Room number |
| created_by | BigInt | 20 | Foreign Key to users table |
| updated_by | BigInt | 20 | Foreign Key to users table |
| created_at | Timestamp | - | Record creation time |
| updated_at | Timestamp | - | Record update time |

### 4. consultations
| Field | Type | Size | Description |
|-------|------|------|-------------|
| id | BigInt | 20 | Primary Key, Auto Increment |
| appointment_id | BigInt | 20 | Foreign Key to appointments table |
| patient_id | BigInt | 20 | Foreign Key to patients table |
| doctor_id | BigInt | 20 | Foreign Key to users table |
| consultation_date | Date | - | Consultation date |
| consultation_time | Time | - | Consultation time |
| status | Enum | - | Status: scheduled, in_progress, completed, cancelled |
| chief_complaint | Text | - | Chief complaint |
| present_illness | Text | - | Present illness details |
| past_medical_history | Text | - | Past medical history |
| family_history | Text | - | Family medical history |
| social_history | Text | - | Social history |
| clinical_measurements | JSON | - | Clinical measurements data |
| symptoms | Text | - | Patient symptoms |
| diagnosis | Text | - | Medical diagnosis |
| treatment_plan | Text | - | Treatment plan |
| prescription | Text | - | Prescription details |
| notes | Text | - | Consultation notes |
| physical_examination | JSON | - | Physical examination data |
| prescription_notes | Text | - | Prescription notes |
| follow_up_date | Date | - | Follow-up appointment date |
| follow_up_notes | Text | - | Follow-up notes |
| consultation_notes | Text | - | General consultation notes |
| created_by | BigInt | 20 | Foreign Key to users table |
| updated_by | BigInt | 20 | Foreign Key to users table |
| created_at | Timestamp | - | Record creation time |
| updated_at | Timestamp | - | Record update time |

### 5. billings
| Field | Type | Size | Description |
|-------|------|------|-------------|
| id | BigInt | 20 | Primary Key, Auto Increment |
| patient_id | BigInt | 20 | Foreign Key to patients table |
| appointment_id | BigInt | 20 | Foreign Key to appointments table |
| amount | Decimal | 10,2 | Base amount |
| consultation_fee | Decimal | 10,2 | Consultation fee |
| medication_fee | Decimal | 10,2 | Medication fee |
| laboratory_fee | Decimal | 10,2 | Laboratory fee |
| other_fees | Decimal | 10,2 | Other miscellaneous fees |
| total_amount | Decimal | 10,2 | Total billing amount |
| status | String | 255 | Billing status |
| payment_date | Date | - | Payment date |
| created_at | Timestamp | - | Record creation time |
| updated_at | Timestamp | - | Record update time |

### 6. doctors
| Field | Type | Size | Description |
|-------|------|------|-------------|
| id | BigInt | 20 | Primary Key, Auto Increment |
| user_id | BigInt | 20 | Foreign Key to users table |
| specialization | String | 255 | Medical specialization |
| license_number | String | 255 | Medical license number |
| years_of_experience | Integer | 11 | Years of medical experience |
| qualifications | Text | - | Medical qualifications |
| bio | Text | - | Doctor biography |
| status | Enum | - | Status: active, inactive, suspended |
| consultation_fee | Decimal | 10,2 | Consultation fee amount |
| available_days | JSON | - | Available working days |
| available_hours | JSON | - | Available working hours |
| contact_number | String | 255 | Contact phone number |
| emergency_contact | String | 255 | Emergency contact |
| address | Text | - | Office address |
| city | String | 255 | City name |
| state | String | 255 | State name |
| postal_code | String | 255 | Postal code |
| country | String | 255 | Country name |
| created_at | Timestamp | - | Record creation time |
| updated_at | Timestamp | - | Record update time |

### 7. prescriptions
| Field | Type | Size | Description |
|-------|------|------|-------------|
| id | BigInt | 20 | Primary Key, Auto Increment |
| patient_id | BigInt | 20 | Foreign Key to users table |
| doctor_id | BigInt | 20 | Foreign Key to users table |
| appointment_id | BigInt | 20 | Foreign Key to appointments table |
| prescription_number | String | 255 | Unique prescription number |
| prescription_date | Date | - | Prescription date |
| diagnosis | Text | - | Medical diagnosis |
| notes | Text | - | Prescription notes |
| instructions | Text | - | Medication instructions |
| status | Enum | - | Status: active, completed, cancelled |
| valid_until | Date | - | Prescription validity date |
| is_printed | Boolean | 1 | Print status |
| printed_at | Timestamp | - | Print timestamp |
| created_at | Timestamp | - | Record creation time |
| updated_at | Timestamp | - | Record update time |

### 8. prescription_medications
| Field | Type | Size | Description |
|-------|------|------|-------------|
| id | BigInt | 20 | Primary Key, Auto Increment |
| prescription_id | BigInt | 20 | Foreign Key to prescriptions table |
| medication_name | String | 255 | Medication name |
| dosage | String | 255 | Dosage information |
| frequency | String | 255 | Frequency of administration |
| duration | String | 255 | Duration of treatment |
| quantity | String | 255 | Quantity prescribed |
| instructions | Text | - | Special instructions |
| created_at | Timestamp | - | Record creation time |
| updated_at | Timestamp | - | Record update time |

### 9. sessions
| Field | Type | Size | Description |
|-------|------|------|-------------|
| id | String | 255 | Primary Key (session ID) |
| user_id | BigInt | 20 | Foreign Key to users table |
| ip_address | String | 45 | User's IP address |
| user_agent | Text | - | User's browser/device info |
| payload | LongText | - | Session data payload |
| last_activity | Integer | 11 | Last activity timestamp |

### 10. doctor_availability_settings
| Field | Type | Size | Description |
|-------|------|------|-------------|
| id | BigInt | 20 | Primary Key, Auto Increment |
| doctor_id | BigInt | 20 | Foreign Key to users table |
| is_available | Boolean | 1 | Availability status |
| unavailable_message | String | 255 | Unavailability message |
| unavailable_until | Timestamp | - | Unavailable until timestamp |
| status | String | 255 | Availability status |
| notes | Text | - | Additional notes |
| set_by | BigInt | 20 | Foreign Key to users table |
| created_at | Timestamp | - | Record creation time |
| updated_at | Timestamp | - | Record update time |

### 11. medical_records
| Field | Type | Size | Description |
|-------|------|------|-------------|
| id | BigInt | 20 | Primary Key, Auto Increment |
| patient_id | BigInt | 20 | Foreign Key to users table |
| doctor_id | BigInt | 20 | Foreign Key to doctors table |
| appointment_id | BigInt | 20 | Foreign Key to appointments table |
| record_number | String | 255 | Unique record number |
| record_date | Date | - | Record date |
| chief_complaint | String | 255 | Chief complaint |
| present_illness | Text | - | Present illness details |
| past_medical_history | Text | - | Past medical history |
| family_history | Text | - | Family medical history |
| social_history | Text | - | Social history |
| review_of_systems | Text | - | Review of systems |
| physical_examination | Text | - | Physical examination |
| diagnosis | Text | - | Medical diagnosis |
| treatment_plan | Text | - | Treatment plan |
| medications_prescribed | Text | - | Prescribed medications |
| lab_results | Text | - | Laboratory results |
| imaging_results | Text | - | Imaging results |
| clinical_measurements | Text | - | Clinical measurements |
| allergies | Text | - | Known allergies |
| notes | Text | - | General notes |
| status | Enum | - | Status: active, archived, deleted |
| record_type | Enum | - | Type: consultation, follow_up, emergency, routine |
| is_confidential | Boolean | 1 | Confidentiality flag |
| archived_at | Timestamp | - | Archive timestamp |
| created_at | Timestamp | - | Record creation time |
| updated_at | Timestamp | - | Record update time |

### 12. inventory
| Field | Type | Size | Description |
|-------|------|------|-------------|
| id | BigInt | 20 | Primary Key, Auto Increment |
| name | String | 255 | Item name |
| description | Text | - | Item description |
| category | Enum | - | Category: medicine, supplies, equipment |
| quantity | Integer | 11 | Current stock quantity |
| reorder_level | Integer | 11 | Reorder threshold |
| expiration_date | Date | - | Expiration date |
| unit_price | Decimal | 10,2 | Unit price |
| supplier | String | 255 | Supplier name |
| location | String | 255 | Storage location |
| batch_number | String | 255 | Batch number |
| notes | Text | - | Additional notes |
| last_updated | Timestamp | - | Last update timestamp |
| updated_by | BigInt | 20 | Foreign Key to users table |
| created_by | BigInt | 20 | Foreign Key to users table |
| is_active | Boolean | 1 | Active status |
| archived | Boolean | 1 | Archive status |
| created_at | Timestamp | - | Record creation time |
| updated_at | Timestamp | - | Record update time |

### 13. inventory_logs
| Field | Type | Size | Description |
|-------|------|------|-------------|
| id | BigInt | 20 | Primary Key, Auto Increment |
| item_id | BigInt | 20 | Foreign Key to inventory table |
| adjustment_quantity | Integer | 11 | Quantity adjustment |
| notes | Text | - | Adjustment notes |
| adjusted_by | BigInt | 20 | Foreign Key to users table |
| adjusted_at | Timestamp | - | Adjustment timestamp |

### 14. otp_codes
| Field | Type | Size | Description |
|-------|------|------|-------------|
| id | BigInt | 20 | Primary Key, Auto Increment |
| email | String | 255 | User's email |
| code | String | 6 | OTP code |
| type | Enum | - | Type: email_verification, password_reset, login |
| expires_at | Timestamp | - | Expiration timestamp |
| is_used | Boolean | 1 | Usage status |
| created_at | Timestamp | - | Record creation time |
| updated_at | Timestamp | - | Record update time |

### 15. medications
| Field | Type | Size | Description |
|-------|------|------|-------------|
| id | Int | 11 | Primary Key, Auto Increment |
| name | String | 255 | Medication name |
| generic_name | String | 255 | Generic name |
| brand_name | String | 255 | Brand name |
| category | String | 100 | Medication category |
| dosage_form | String | 50 | Dosage form |
| strength | String | 50 | Medication strength |
| manufacturer | String | 255 | Manufacturer name |
| description | Text | - | Medication description |
| side_effects | Text | - | Side effects |
| contraindications | Text | - | Contraindications |
| storage_instructions | Text | - | Storage instructions |
| quantity | Int | 11 | Stock quantity |
| reorder_level | Int | 11 | Reorder threshold |
| unit_price | Decimal | 10,2 | Unit price |
| expiration_date | Date | - | Expiration date |
| prescription_required | Boolean | 1 | Prescription requirement |
| is_active | Boolean | 1 | Active status |
| created_by | Int | 11 | Foreign Key to users table |
| updated_by | Int | 11 | Foreign Key to users table |
| created_at | Timestamp | - | Record creation time |
| updated_at | Timestamp | - | Record update time |

### 16. medication_prescriptions
| Field | Type | Size | Description |
|-------|------|------|-------------|
| id | Int | 11 | Primary Key, Auto Increment |
| medication_id | Int | 11 | Foreign Key to medications table |
| patient_id | Int | 11 | Foreign Key to users table |
| prescribed_by | Int | 11 | Foreign Key to users table |
| dosage | String | 100 | Dosage information |
| frequency | String | 100 | Frequency of administration |
| duration | String | 100 | Duration of treatment |
| quantity | Int | 11 | Quantity prescribed |
| instructions | Text | - | Special instructions |
| status | Enum | - | Status: active, completed, cancelled |
| prescribed_at | Timestamp | - | Prescription timestamp |

### 17. activity_logs
| Field | Type | Size | Description |
|-------|------|------|-------------|
| id | Int | 11 | Primary Key, Auto Increment |
| user_id | Int | 11 | Foreign Key to users table |
| action | String | 255 | Action performed |
| description | Text | - | Action description |
| ip_address | String | 45 | User's IP address |
| user_agent | Text | - | User's browser/device info |
| created_at | Timestamp | - | Record creation time |

## Field Size Summary

### String Fields
- **255 characters**: Most string fields (names, emails, addresses, etc.)
- **100 characters**: Specialized fields (dosage, frequency, duration)
- **50 characters**: Short fields (dosage_form, strength)
- **45 characters**: IP addresses
- **6 characters**: OTP codes
- **5 characters**: Blood type

### Numeric Fields
- **BigInt (20)**: Primary keys, foreign keys, large integers
- **Int (11)**: Regular integers, quantities, durations
- **Decimal (10,2)**: Monetary amounts, prices
- **Boolean (1)**: True/false values

### Text Fields
- **Text**: Variable length text (descriptions, notes, medical records)
- **LongText**: Very long text (session payloads)
- **JSON**: Structured data (clinical measurements, availability settings)

### Date/Time Fields
- **Date**: Date only
- **Time**: Time only
- **Timestamp**: Date and time with timezone support

## Database Relationships

The database uses proper foreign key relationships to maintain data integrity:
- Users table is the central table for authentication
- Patients, doctors, and staff are linked to users
- Appointments link patients and doctors
- Consultations are based on appointments
- Prescriptions are linked to patients, doctors, and appointments
- Medical records track patient health information
- Inventory manages medical supplies and equipment
- Billing tracks financial transactions

## Indexes

Each table includes appropriate indexes for optimal query performance:
- Primary keys are automatically indexed
- Foreign keys are indexed for join operations
- Composite indexes on frequently queried combinations
- Status and date fields are indexed for filtering

## Sample Patient Data (5 Records with Filipino Names and Abra Municipality Addresses)

| id | user_id | first_name | last_name | contact | email | address | date_of_birth | gender | blood_type | emergency_contact | emergency_contact_phone | medical_history | allergies | current_medications | insurance_provider | insurance_number | registration_date | is_active |
|----|---------|------------|-----------|---------|-------|---------|---------------|--------|------------|-------------------|--------------------------|-----------------|-----------|-------------------|-------------------|------------------|-------------------|-----------|
| 1 | 1 | Juan | dela Cruz | +63 917 123 4567 | juan.delacruz@email.com | Barangay Zone 1, Bangued, Abra | 1985-03-15 | male | O+ | Maria dela Cruz | +63 917 123 4568 | Hypertension diagnosed in 2010 | None | Amlodipine 5mg daily | PhilHealth | PH123456789 | 2024-01-15 10:00:00 | 1 |
| 2 | 2 | Maria | Santos | +63 918 234 5678 | maria.santos@email.com | Poblacion, Boliney, Abra | 1990-07-22 | female | A+ | Jose Santos | +63 918 234 5679 | Asthma since childhood | Dust, pollen | Salbutamol inhaler as needed | Maxicare | MC987654321 | 2024-02-20 14:30:00 | 1 |
| 3 | 3 | Jose | Reyes | +63 919 345 6789 | jose.reyes@email.com | Barangay North Poblacion, Bucay, Abra | 1978-11-08 | male | B+ | Ana Reyes | +63 919 345 6790 | Diabetes Type 2, 2015 | Shellfish | Metformin 500mg twice daily | Intellicare | IC456789123 | 2024-03-10 09:15:00 | 1 |
| 4 | 4 | Ana | Garcia | +63 920 456 7890 | ana.garcia@email.com | Centro East, Bucloc, Abra | 1995-05-30 | female | AB+ | Pedro Garcia | +63 920 456 7891 | Migraine headaches | Chocolate, caffeine | Sumatriptan as needed | Avega | AV789123456 | 2024-04-05 16:45:00 | 1 |
| 5 | 5 | Pedro | Lopez | +63 921 567 8901 | pedro.lopez@email.com | Poblacion Norte, Daguioman, Abra | 1982-09-12 | male | O- | Rosa Lopez | +63 921 567 8902 | High cholesterol, 2018 | None | Atorvastatin 20mg daily | Medicard | MD321654987 | 2024-05-12 11:20:00 | 1 |

This database structure provides a robust foundation for a comprehensive healthcare management system with proper data types, sizes, and relationships. The sample data includes authentic Filipino names commonly used in the Philippines, with realistic medical conditions and contact information.