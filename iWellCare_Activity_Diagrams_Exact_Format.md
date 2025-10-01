# iWellCare Healthcare Management System - Activity Diagrams (Exact Format)

## Overview
These activity diagrams follow the exact format from your uploaded image, using proper swimlanes with Patient and iWellCare System lanes.

---

## 1. Activity Diagram for User Login Process

```mermaid
graph TD
    subgraph "Patient"
        P1[Enter Username and Password]
        P2[Click Login Button]
        P3[View Dashboard]
    end
    
    subgraph "iWellCare System"
        S1[Start]
        S2[Validate Credentials]
        S3[Check User Role]
        S4[Redirect to Dashboard]
        S5[End]
    end
    
    S1 --> S2
    S2 --> P1
    P1 --> P2
    P2 --> S2
    S2 --> S3
    S3 --> S4
    S4 --> P3
    P3 --> S5
```

**Description:** In the login process, the system validates user credentials and redirects to the appropriate dashboard based on user role.

---

## 2. Activity Diagram for Patient Registration Process

```mermaid
graph TD
    subgraph "Patient"
        P1[Fill Registration Form]
        P2[Enter Personal Information]
        P3[Enter Contact Details]
        P4[Enter Medical Information]
        P5[Submit Registration]
        P6[View Success Message]
    end
    
    subgraph "iWellCare System"
        S1[Start]
        S2[Display Registration Form]
        S3[Validate Form Data]
        S4[Create User Account]
        S5[Create Patient Profile]
        S6[Mark Email as Verified]
        S7[Auto Login User]
        S8[End]
    end
    
    S1 --> S2
    S2 --> P1
    P1 --> P2
    P2 --> P3
    P3 --> P4
    P4 --> P5
    P5 --> S3
    S3 --> S4
    S4 --> S5
    S5 --> S6
    S6 --> S7
    S7 --> P6
    P6 --> S8
```

**Description:** In the registration process, the patient fills out the form with personal and medical information, and the system creates the user account and patient profile.

---

## 3. Activity Diagram for Booking Appointment Process

```mermaid
graph TD
    subgraph "Patient"
        P1[Access Booking System]
        P2[Select Doctor]
        P3[Choose Date and Time]
        P4[Enter Appointment Details]
        P5[Enter Symptoms]
        P6[Submit Booking Request]
        P7[View Confirmation]
    end
    
    subgraph "iWellCare System"
        S1[Start]
        S2[Check User Authentication]
        S3[Check User Role]
        S4[Display Available Doctors]
        S5[Check Doctor Availability]
        S6[Check Time Conflicts]
        S7[Validate Appointment Data]
        S8[Create Appointment Record]
        S9[Set Status to Pending]
        S10[Send Confirmation]
        S11[End]
    end
    
    S1 --> S2
    S2 --> S3
    S3 --> S4
    S4 --> P1
    P1 --> P2
    P2 --> S5
    S5 --> P3
    P3 --> S6
    S6 --> P4
    P4 --> P5
    P5 --> P6
    P6 --> S7
    S7 --> S8
    S8 --> S9
    S9 --> S10
    S10 --> P7
    P7 --> S11
```

**Description:** In booking an appointment, the patient selects a doctor and time slot, and the system validates availability and creates the appointment record.

---

## 4. Activity Diagram for Viewing Medical Records/Prescription

```mermaid
graph TD
    subgraph "Patient"
        P1[View Medical Records]
        P2[View Prescription Details]
        P3[View Medication Type]
        P4[View Dosage and Quantity]
        P5[View Expiration Date]
        P6[View Instructions]
    end
    
    subgraph "iWellCare System"
        S1[Start]
        S2[Display Medical Records]
        S3[Load Prescription Data]
        S4[Display Prescription Information]
        S5[Show Medication Details]
        S6[Display Dosage Information]
        S7[Show Expiration Date]
        S8[Display Instructions]
        S9[End]
    end
    
    S1 --> S2
    S2 --> P1
    P1 --> S3
    S3 --> S4
    S4 --> P2
    P2 --> S5
    S5 --> P3
    P3 --> S6
    S6 --> P4
    P4 --> S7
    S7 --> P5
    P5 --> S8
    S8 --> P6
    P6 --> S9
```

**Description:** In viewing medical records and prescription information, the system displays the medical records and prescription details, and the patient views the medication type, dosage, quantity, expiration date, and instructions.

---

## 5. Activity Diagram for Managing Patient Information

```mermaid
graph TD
    subgraph "Patient"
        P1[Access Profile]
        P2[View Personal Information]
        P3[Update Contact Details]
        P4[Update Medical Information]
        P5[Save Changes]
        P6[View Updated Information]
    end
    
    subgraph "iWellCare System"
        S1[Start]
        S2[Load Patient Profile]
        S3[Display Patient Information]
        S4[Validate Updated Data]
        S5[Update Patient Record]
        S6[Update User Account]
        S7[Save Changes to Database]
        S8[Confirm Update Success]
        S9[End]
    end
    
    S1 --> S2
    S2 --> S3
    S3 --> P1
    P1 --> P2
    P2 --> P3
    P3 --> P4
    P4 --> P5
    P5 --> S4
    S4 --> S5
    S5 --> S6
    S6 --> S7
    S7 --> S8
    S8 --> P6
    P6 --> S9
```

**Description:** In managing patient information, the patient accesses their profile, updates personal and medical information, and the system validates and saves the changes to the database.

---

## 6. Activity Diagram for Staff Managing Appointments

```mermaid
graph TD
    subgraph "Staff"
        ST1[Access Appointment Management]
        ST2[Select Action]
        ST3[Create New Appointment]
        ST4[Select Patient]
        ST5[Select Doctor]
        ST6[Choose Date and Time]
        ST7[Enter Appointment Details]
        ST8[Submit Appointment]
        ST9[View Confirmation]
    end
    
    subgraph "iWellCare System"
        S1[Start]
        S2[Display Appointment Interface]
        S3[Load Patient List]
        S4[Load Doctor List]
        S5[Check Doctor Availability]
        S6[Check Time Conflicts]
        S7[Validate Appointment Data]
        S8[Create Appointment Record]
        S9[Send Notification]
        S10[End]
    end
    
    S1 --> S2
    S2 --> ST1
    ST1 --> ST2
    ST2 --> ST3
    ST3 --> S3
    S3 --> ST4
    ST4 --> S4
    S4 --> ST5
    ST5 --> S5
    S5 --> ST6
    ST6 --> S6
    S6 --> ST7
    ST7 --> ST8
    ST8 --> S7
    S7 --> S8
    S8 --> S9
    S9 --> ST9
    ST9 --> S10
```

**Description:** In managing appointments, the staff creates new appointments by selecting patients and doctors, and the system validates availability and creates the appointment record.

---

## 7. Activity Diagram for Doctor Managing Consultations

```mermaid
graph TD
    subgraph "Doctor"
        D1[Access Consultation Management]
        D2[Select Patient]
        D3[Review Patient History]
        D4[Record Vital Signs]
        D5[Perform Physical Examination]
        D6[Enter Examination Findings]
        D7[Make Diagnosis]
        D8[Create Treatment Plan]
        D9[Prescribe Medications]
        D10[Set Follow-up Date]
        D11[Save Consultation]
        D12[View Confirmation]
    end
    
    subgraph "iWellCare System"
        S1[Start]
        S2[Display Consultation Interface]
        S3[Load Patient Medical History]
        S4[Display Patient Information]
        S5[Record Clinical Measurements]
        S6[Update Physical Examination]
        S7[Save Diagnosis]
        S8[Create Treatment Plan]
        S9[Generate Prescription]
        S10[Update Medical Record]
        S11[Create Consultation Record]
        S12[Send Notification]
        S13[End]
    end
    
    S1 --> S2
    S2 --> D1
    D1 --> D2
    D2 --> S3
    S3 --> S4
    S4 --> D3
    D3 --> D4
    D4 --> S5
    S5 --> D5
    D5 --> D6
    D6 --> S6
    S6 --> D7
    D7 --> S7
    S7 --> D8
    D8 --> S8
    S8 --> D9
    D9 --> S9
    S9 --> D10
    D10 --> D11
    D11 --> S10
    S10 --> S11
    S11 --> S12
    S12 --> D12
    D12 --> S13
```

**Description:** In managing consultations, the doctor reviews patient history, performs examinations, makes diagnoses, and creates treatment plans, while the system records all medical data and updates patient records.

---

## 8. Activity Diagram for Viewing Reports

```mermaid
graph TD
    subgraph "Staff/Doctor"
        U1[Access Reports Section]
        U2[Select Report Type]
        U3[Set Report Parameters]
        U4[Choose Date Range]
        U5[Select Filters]
        U6[Generate Report]
        U7[View Generated Report]
        U8[Export Report]
    end
    
    subgraph "iWellCare System"
        S1[Start]
        S2[Display Report Types]
        S3[Load Report Parameters]
        S4[Validate Parameters]
        S5[Aggregate Data]
        S6[Generate Report]
        S7[Format Report]
        S8[Display Report]
        S9[Export to File]
        S10[End]
    end
    
    S1 --> S2
    S2 --> U1
    U1 --> U2
    U2 --> S3
    S3 --> U3
    U3 --> U4
    U4 --> U5
    U5 --> U6
    U6 --> S4
    S4 --> S5
    S5 --> S6
    S6 --> S7
    S7 --> S8
    S8 --> U7
    U7 --> U8
    U8 --> S9
    S9 --> S10
```

**Description:** In viewing reports, the staff or doctor selects report types and parameters, and the system aggregates data, generates formatted reports, and provides export functionality.

---

## Key Features of This Format:

### **✅ Swimlane Structure:**
- **Left Lane**: Patient/Staff/Doctor actions
- **Right Lane**: iWellCare System processes
- **Clear Separation**: Each actor has their own dedicated lane

### **✅ Flow Direction:**
- **Vertical Flow**: Top to bottom within each lane
- **Horizontal Transitions**: Between lanes when interaction occurs
- **Logical Sequence**: Each step follows logically from the previous

### **✅ Activity Nodes:**
- **Rectangular Boxes**: All activities in rounded rectangles
- **Clear Labels**: Descriptive action names
- **Proper Naming**: Verb-noun format

### **✅ Start and End Nodes:**
- **Start**: Solid circle in system lane
- **End**: Solid circle with outer ring in system lane
- **Consistent Placement**: Always in the system lane

### **✅ Description Text:**
- **Below Each Diagram**: Clear explanation of the process
- **Consistent Format**: "In [process name], the [actor] [action], and the system [action]."

This format exactly matches your uploaded image structure with proper swimlanes, clear flow direction, and descriptive text below each diagram!
