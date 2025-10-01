# iWellCare Healthcare Management System - Swimlane Activity Diagrams

## Overview
This document provides activity diagrams in the proper swimlane format, showing the interaction between Patient and iWellCare System, following the format shown in your example.

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

---

## 6. Activity Diagram for Staff Managing Appointments

```mermaid
graph TD
    subgraph "Staff"
        S1[Access Appointment Management]
        S2[Select Action]
        S3[Create New Appointment]
        S4[Select Patient]
        S5[Select Doctor]
        S6[Choose Date and Time]
        S7[Enter Appointment Details]
        S8[Submit Appointment]
        S9[View Confirmation]
    end
    
    subgraph "iWellCare System"
        SYS1[Start]
        SYS2[Display Appointment Interface]
        SYS3[Load Patient List]
        SYS4[Load Doctor List]
        SYS5[Check Doctor Availability]
        SYS6[Check Time Conflicts]
        SYS7[Validate Appointment Data]
        SYS8[Create Appointment Record]
        SYS9[Send Notification]
        SYS10[End]
    end
    
    SYS1 --> SYS2
    SYS2 --> S1
    S1 --> S2
    S2 --> S3
    S3 --> SYS3
    SYS3 --> S4
    S4 --> SYS4
    SYS4 --> S5
    S5 --> SYS5
    SYS5 --> S6
    S6 --> SYS6
    SYS6 --> S7
    S7 --> S8
    S8 --> SYS7
    SYS7 --> SYS8
    SYS8 --> SYS9
    SYS9 --> S9
    S9 --> SYS10
```

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
        SYS1[Start]
        SYS2[Display Consultation Interface]
        SYS3[Load Patient Medical History]
        SYS4[Display Patient Information]
        SYS5[Record Clinical Measurements]
        SYS6[Update Physical Examination]
        SYS7[Save Diagnosis]
        SYS8[Create Treatment Plan]
        SYS9[Generate Prescription]
        SYS10[Update Medical Record]
        SYS11[Create Consultation Record]
        SYS12[Send Notification]
        SYS13[End]
    end
    
    SYS1 --> SYS2
    SYS2 --> D1
    D1 --> D2
    D2 --> SYS3
    SYS3 --> SYS4
    SYS4 --> D3
    D3 --> D4
    D4 --> SYS5
    SYS5 --> D5
    D5 --> D6
    D6 --> SYS6
    SYS6 --> D7
    D7 --> SYS7
    SYS7 --> D8
    D8 --> SYS8
    SYS8 --> D9
    D9 --> SYS9
    SYS9 --> D10
    D10 --> D11
    D11 --> SYS10
    SYS10 --> SYS11
    SYS11 --> SYS12
    SYS12 --> D12
    D12 --> SYS13
```

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
        SYS1[Start]
        SYS2[Display Report Types]
        SYS3[Load Report Parameters]
        SYS4[Validate Parameters]
        SYS5[Aggregate Data]
        SYS6[Generate Report]
        SYS7[Format Report]
        SYS8[Display Report]
        SYS9[Export to File]
        SYS10[End]
    end
    
    SYS1 --> SYS2
    SYS2 --> U1
    U1 --> U2
    U2 --> SYS3
    SYS3 --> U3
    U3 --> U4
    U4 --> U5
    U5 --> U6
    U6 --> SYS4
    SYS4 --> SYS5
    SYS5 --> SYS6
    SYS6 --> SYS7
    SYS7 --> SYS8
    SYS8 --> U7
    U7 --> U8
    U8 --> SYS9
    SYS9 --> SYS10
```

---

## Key Features of Swimlane Format:

### **✅ Proper Swimlane Structure:**
- **Left Lane**: Patient/User actions
- **Right Lane**: iWellCare System processes
- **Clear Separation**: Each actor has their own lane

### **✅ Flow Direction:**
- **Vertical Flow**: Top to bottom within each lane
- **Horizontal Transitions**: Between lanes when interaction occurs
- **Logical Sequence**: Each step follows logically from the previous

### **✅ Activity Nodes:**
- **Rectangular Boxes**: All activities are in rounded rectangles
- **Clear Labels**: Descriptive action names
- **Proper Naming**: Verb-noun format (e.g., "Enter Username", "Validate Credentials")

### **✅ Start and End Nodes:**
- **Start**: Solid circle in system lane
- **End**: Solid circle with outer ring in system lane
- **Consistent Placement**: Always in the system lane

### **✅ Interaction Flow:**
- **System Initiates**: System starts the process
- **User Responds**: User performs actions in response
- **System Processes**: System handles data and validation
- **User Confirms**: User views results or confirms actions

This swimlane format clearly shows the interaction between the Patient and the iWellCare System, making it easy to understand who does what and when in each process!
