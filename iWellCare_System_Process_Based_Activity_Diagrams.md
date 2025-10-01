# iWellCare Healthcare Management System - Process-Based Activity Diagrams

## Overview
This document provides activity diagrams based on the actual system processes and use cases found in the iWellCare codebase. These diagrams reflect the real workflow implemented in the system.

## System Process Analysis

Based on the codebase analysis, the following key processes have been identified:

### 1. **User Registration & Authentication Process**
### 2. **Appointment Booking Process** 
### 3. **Consultation Management Process**
### 4. **Patient Information Management Process**
### 5. **Medication & Prescription Process**
### 6. **Invoice & Billing Process**

---

## 1. User Registration & Authentication Process

```mermaid
graph TD
    Start([Start]) --> AccessRegister[User accesses registration page]
    AccessRegister --> FillForm[Fill registration form]
    
    FillForm --> ValidateForm{Validate form data}
    ValidateForm -->|Invalid| ShowErrors[Show validation errors]
    ShowErrors --> FillForm
    ValidateForm -->|Valid| CreateUser[Create user account]
    
    CreateUser --> CreatePatient[Create patient profile]
    CreatePatient --> MarkVerified[Mark email as verified]
    MarkVerified --> LoginUser[Log user in automatically]
    LoginUser --> RedirectRole[Redirect based on role]
    
    RedirectRole -->|Patient| PatientDashboard[Patient Dashboard]
    RedirectRole -->|Doctor| DoctorDashboard[Doctor Dashboard]
    RedirectRole -->|Staff| StaffDashboard[Staff Dashboard]
    
    PatientDashboard --> End([End])
    DoctorDashboard --> End
    StaffDashboard --> End
    
    %% Login Process
    Start --> AccessLogin[User accesses login page]
    AccessLogin --> EnterCredentials[Enter username/password]
    EnterCredentials --> ValidateCredentials{Validate credentials}
    ValidateCredentials -->|Invalid| ShowLoginError[Show login error]
    ShowLoginError --> EnterCredentials
    ValidateCredentials -->|Valid| CheckRole[Check user role]
    CheckRole --> RedirectRole
    
    %% Styling
    classDef process fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    classDef decision fill:#fff3e0,stroke:#f57c00,stroke-width:2px
    classDef endpoint fill:#e8f5e8,stroke:#388e3c,stroke-width:2px
    
    class AccessRegister,FillForm,CreateUser,CreatePatient,MarkVerified,LoginUser,RedirectRole,AccessLogin,EnterCredentials,CheckRole process
    class ValidateForm,ValidateCredentials decision
    class PatientDashboard,DoctorDashboard,StaffDashboard,End endpoint
```

---

## 2. Appointment Booking Process (Patient)

```mermaid
graph TD
    Start([Start]) --> CheckAuth{User authenticated?}
    CheckAuth -->|No| RedirectRegister[Redirect to registration]
    CheckAuth -->|Yes| CheckRole{User role = patient?}
    CheckRole -->|No| RedirectHome[Redirect to home]
    CheckRole -->|Yes| ShowBookingForm[Show booking form]
    
    ShowBookingForm --> GetDoctors[Get available doctors]
    GetDoctors --> CheckAvailability[Check doctor availability status]
    CheckAvailability --> DisplayDoctors[Display doctors with availability]
    
    DisplayDoctors --> SelectDoctor[Patient selects doctor]
    SelectDoctor --> ValidateDoctor{Doctor available?}
    ValidateDoctor -->|No| ShowUnavailable[Show unavailable message]
    ShowUnavailable --> SelectDoctor
    ValidateDoctor -->|Yes| SelectDateTime[Select date and time]
    
    SelectDateTime --> CheckTimeSlot{Time slot available?}
    CheckTimeSlot -->|No| ShowConflict[Show time conflict message]
    ShowConflict --> SelectDateTime
    CheckTimeSlot -->|Yes| FillDetails[Fill appointment details]
    
    FillDetails --> ValidateRequest{Validate request data}
    ValidateRequest -->|Invalid| ShowValidationErrors[Show validation errors]
    ShowValidationErrors --> FillDetails
    ValidateRequest -->|Valid| CreateAppointment[Create appointment record]
    
    CreateAppointment --> SetStatus[Set status to 'pending']
    SetStatus --> RedirectLogin[Redirect to login with success message]
    RedirectLogin --> End([End])
    
    %% Styling
    classDef process fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    classDef decision fill:#fff3e0,stroke:#f57c00,stroke-width:2px
    classDef error fill:#ffebee,stroke:#d32f2f,stroke-width:2px
    classDef endpoint fill:#e8f5e8,stroke:#388e3c,stroke-width:2px
    
    class ShowBookingForm,GetDoctors,CheckAvailability,DisplayDoctors,SelectDoctor,SelectDateTime,FillDetails,CreateAppointment,SetStatus,RedirectLogin process
    class CheckAuth,CheckRole,ValidateDoctor,CheckTimeSlot,ValidateRequest decision
    class RedirectRegister,RedirectHome,ShowUnavailable,ShowConflict,ShowValidationErrors error
    class End endpoint
```

---

## 3. Appointment Management Process (Staff/Doctor)

```mermaid
graph TD
    Start([Start]) --> AccessAppointments[Access appointment management]
    AccessAppointments --> SelectAction{Select action}
    
    SelectAction -->|Create| CreateAppointment[Create new appointment]
    SelectAction -->|View| ViewAppointments[View appointment list]
    SelectAction -->|Edit| EditAppointment[Edit existing appointment]
    SelectAction -->|Delete| DeleteAppointment[Delete appointment]
    
    %% Create Appointment Process
    CreateAppointment --> SelectPatient[Select patient]
    SelectPatient --> SelectDoctor[Select doctor]
    SelectDoctor --> CheckDoctorAvailability[Check doctor availability]
    CheckDoctorAvailability --> Available{Doctor available?}
    Available -->|No| ShowUnavailable[Show unavailable message]
    ShowUnavailable --> SelectDoctor
    Available -->|Yes| SelectDateTime[Select date and time]
    SelectDateTime --> CheckTimeConflict[Check time conflicts]
    CheckTimeConflict --> Conflict{Time conflict?}
    Conflict -->|Yes| ShowConflict[Show conflict message]
    ShowConflict --> SelectDateTime
    Conflict -->|No| FillAppointmentDetails[Fill appointment details]
    FillAppointmentDetails --> ValidateData[Validate appointment data]
    ValidateData --> SaveAppointment[Save appointment]
    SaveAppointment --> ConfirmCreated[Confirm appointment created]
    
    %% View Appointments Process
    ViewAppointments --> DisplayList[Display appointment list]
    DisplayList --> FilterOptions[Apply filters if needed]
    FilterOptions --> ShowResults[Show filtered results]
    
    %% Edit Appointment Process
    EditAppointment --> SelectAppointment[Select appointment to edit]
    SelectAppointment --> LoadDetails[Load appointment details]
    LoadDetails --> ModifyDetails[Modify appointment details]
    ModifyDetails --> ValidateChanges[Validate changes]
    ValidateChanges --> SaveChanges[Save changes]
    SaveChanges --> ConfirmUpdated[Confirm appointment updated]
    
    %% Delete Appointment Process
    DeleteAppointment --> SelectToDelete[Select appointment to delete]
    SelectToDelete --> ConfirmDelete[Confirm deletion]
    ConfirmDelete --> RemoveAppointment[Remove appointment]
    RemoveAppointment --> ConfirmDeleted[Confirm appointment deleted]
    
    ConfirmCreated --> End([End])
    ShowResults --> End
    ConfirmUpdated --> End
    ConfirmDeleted --> End
    
    %% Styling
    classDef process fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    classDef decision fill:#fff3e0,stroke:#f57c00,stroke-width:2px
    classDef error fill:#ffebee,stroke:#d32f2f,stroke-width:2px
    classDef endpoint fill:#e8f5e8,stroke:#388e3c,stroke-width:2px
    
    class AccessAppointments,CreateAppointment,SelectPatient,SelectDoctor,CheckDoctorAvailability,SelectDateTime,CheckTimeConflict,FillAppointmentDetails,ValidateData,SaveAppointment,ConfirmCreated,ViewAppointments,DisplayList,FilterOptions,ShowResults,EditAppointment,SelectAppointment,LoadDetails,ModifyDetails,ValidateChanges,SaveChanges,ConfirmUpdated,DeleteAppointment,SelectToDelete,ConfirmDelete,RemoveAppointment,ConfirmDeleted process
    class SelectAction,Available,Conflict,ValidateData,ValidateChanges,ConfirmDelete decision
    class ShowUnavailable,ShowConflict error
    class End endpoint
```

---

## 4. Consultation Management Process

```mermaid
graph TD
    Start([Start]) --> AccessConsultation[Access consultation management]
    AccessConsultation --> SelectAction{Select action}
    
    SelectAction -->|Start New| StartConsultation[Start new consultation]
    SelectAction -->|View| ViewConsultations[View consultation history]
    SelectAction -->|Update| UpdateConsultation[Update consultation]
    
    %% Start New Consultation Process
    StartConsultation --> SelectPatient[Select patient]
    SelectPatient --> SelectAppointment[Select appointment]
    SelectAppointment --> LoadPatientHistory[Load patient medical history]
    LoadPatientHistory --> EnterChiefComplaint[Enter chief complaint]
    EnterChiefComplaint --> EnterPresentIllness[Enter present illness]
    EnterPresentIllness --> EnterMedicalHistory[Enter past medical history]
    EnterMedicalHistory --> EnterFamilyHistory[Enter family history]
    EnterFamilyHistory --> EnterSocialHistory[Enter social history]
    
    EnterSocialHistory --> RecordVitalSigns[Record clinical measurements]
    RecordVitalSigns --> PerformPhysicalExam[Perform physical examination]
    PerformPhysicalExam --> EnterFindings[Enter physical examination findings]
    EnterFindings --> MakeDiagnosis[Make diagnosis]
    MakeDiagnosis --> CreateTreatmentPlan[Create treatment plan]
    CreateTreatmentPlan --> PrescribeMedication[Prescribe medications]
    PrescribeMedication --> SetFollowUp[Set follow-up date if needed]
    SetFollowUp --> AddConsultationNotes[Add consultation notes]
    AddConsultationNotes --> SaveConsultation[Save consultation record]
    SaveConsultation --> UpdateMedicalRecord[Update patient medical record]
    UpdateMedicalRecord --> CreatePrescription[Create prescription record]
    CreatePrescription --> ConfirmCompleted[Confirm consultation completed]
    
    %% View Consultations Process
    ViewConsultations --> DisplayList[Display consultation list]
    DisplayList --> ApplyFilters[Apply date/patient filters]
    ApplyFilters --> ShowResults[Show filtered consultations]
    ShowResults --> ViewDetails[View consultation details if selected]
    
    %% Update Consultation Process
    UpdateConsultation --> SelectConsultation[Select consultation to update]
    SelectConsultation --> LoadConsultation[Load consultation details]
    LoadConsultation --> ModifyDetails[Modify consultation details]
    ModifyDetails --> ValidateChanges[Validate changes]
    ValidateChanges --> SaveChanges[Save changes]
    SaveChanges --> UpdateRecords[Update related records]
    UpdateRecords --> ConfirmUpdated[Confirm consultation updated]
    
    ConfirmCompleted --> End([End])
    ViewDetails --> End
    ConfirmUpdated --> End
    
    %% Styling
    classDef process fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    classDef decision fill:#fff3e0,stroke:#f57c00,stroke-width:2px
    classDef endpoint fill:#e8f5e8,stroke:#388e3c,stroke-width:2px
    
    class AccessConsultation,StartConsultation,SelectPatient,SelectAppointment,LoadPatientHistory,EnterChiefComplaint,EnterPresentIllness,EnterMedicalHistory,EnterFamilyHistory,EnterSocialHistory,RecordVitalSigns,PerformPhysicalExam,EnterFindings,MakeDiagnosis,CreateTreatmentPlan,PrescribeMedication,SetFollowUp,AddConsultationNotes,SaveConsultation,UpdateMedicalRecord,CreatePrescription,ConfirmCompleted,ViewConsultations,DisplayList,ApplyFilters,ShowResults,ViewDetails,UpdateConsultation,SelectConsultation,LoadConsultation,ModifyDetails,ValidateChanges,SaveChanges,UpdateRecords,ConfirmUpdated process
    class SelectAction,ValidateChanges decision
    class End endpoint
```

---

## 5. Patient Information Management Process

```mermaid
graph TD
    Start([Start]) --> AccessPatientInfo[Access patient information]
    AccessPatientInfo --> CheckRole{User role?}
    
    CheckRole -->|Patient| PatientSelfService[Patient self-service]
    CheckRole -->|Staff/Doctor| StaffPatientManagement[Staff/Doctor patient management]
    
    %% Patient Self-Service Process
    PatientSelfService --> ViewOwnInfo[View own information]
    ViewOwnInfo --> UpdateOwnInfo[Update own information]
    UpdateOwnInfo --> ValidateOwnData[Validate own data]
    ValidateOwnData --> SaveOwnChanges[Save own changes]
    SaveOwnChanges --> ConfirmOwnUpdated[Confirm information updated]
    
    %% Staff/Doctor Patient Management Process
    StaffPatientManagement --> SelectAction{Select action}
    SelectAction -->|View| ViewPatientList[View patient list]
    SelectAction -->|Add| AddNewPatient[Add new patient]
    SelectAction -->|Update| UpdatePatientInfo[Update patient information]
    SelectAction -->|View Details| ViewPatientDetails[View patient details]
    
    %% View Patient List Process
    ViewPatientList --> DisplayPatients[Display patient list]
    DisplayPatients --> ApplyFilters[Apply search filters]
    ApplyFilters --> ShowFilteredResults[Show filtered results]
    
    %% Add New Patient Process
    AddNewPatient --> FillPatientForm[Fill patient registration form]
    FillPatientForm --> ValidatePatientData[Validate patient data]
    ValidatePatientData --> CreateUserAccount[Create user account]
    CreateUserAccount --> CreatePatientProfile[Create patient profile]
    CreatePatientProfile --> ConfirmPatientAdded[Confirm patient added]
    
    %% Update Patient Information Process
    UpdatePatientInfo --> SelectPatient[Select patient to update]
    SelectPatient --> LoadPatientData[Load patient data]
    LoadPatientData --> ModifyPatientData[Modify patient information]
    ModifyPatientData --> ValidateChanges[Validate changes]
    ValidateChanges --> SavePatientChanges[Save patient changes]
    SavePatientChanges --> ConfirmPatientUpdated[Confirm patient updated]
    
    %% View Patient Details Process
    ViewPatientDetails --> SelectPatientToView[Select patient to view]
    SelectPatientToView --> LoadFullDetails[Load full patient details]
    LoadFullDetails --> DisplayDetails[Display patient details]
    DisplayDetails --> ViewMedicalHistory[View medical history if needed]
    ViewMedicalHistory --> ViewAppointments[View appointments if needed]
    ViewAppointments --> ViewConsultations[View consultations if needed]
    
    ConfirmOwnUpdated --> End([End])
    ShowFilteredResults --> End
    ConfirmPatientAdded --> End
    ConfirmPatientUpdated --> End
    ViewConsultations --> End
    
    %% Styling
    classDef process fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    classDef decision fill:#fff3e0,stroke:#f57c00,stroke-width:2px
    classDef endpoint fill:#e8f5e8,stroke:#388e3c,stroke-width:2px
    
    class AccessPatientInfo,PatientSelfService,ViewOwnInfo,UpdateOwnInfo,ValidateOwnData,SaveOwnChanges,ConfirmOwnUpdated,StaffPatientManagement,ViewPatientList,DisplayPatients,ApplyFilters,ShowFilteredResults,AddNewPatient,FillPatientForm,ValidatePatientData,CreateUserAccount,CreatePatientProfile,ConfirmPatientAdded,UpdatePatientInfo,SelectPatient,LoadPatientData,ModifyPatientData,ValidateChanges,SavePatientChanges,ConfirmPatientUpdated,ViewPatientDetails,SelectPatientToView,LoadFullDetails,DisplayDetails,ViewMedicalHistory,ViewAppointments,ViewConsultations process
    class CheckRole,SelectAction,ValidateOwnData,ValidatePatientData,ValidateChanges decision
    class End endpoint
```

---

## 6. Medication & Prescription Process

```mermaid
graph TD
    Start([Start]) --> AccessMedication[Access medication management]
    AccessMedication --> SelectAction{Select action}
    
    SelectAction -->|View Inventory| ViewInventory[View medication inventory]
    SelectAction -->|Add Medication| AddMedication[Add new medication]
    SelectAction -->|Update Stock| UpdateStock[Update stock levels]
    SelectAction -->|View Prescriptions| ViewPrescriptions[View prescriptions]
    SelectAction -->|Create Prescription| CreatePrescription[Create prescription]
    
    %% View Inventory Process
    ViewInventory --> DisplayInventory[Display medication inventory]
    DisplayInventory --> CheckStockLevels[Check stock levels]
    CheckStockLevels --> ShowLowStock[Show low stock alerts if any]
    ShowLowStock --> FilterInventory[Apply inventory filters]
    FilterInventory --> ShowFilteredInventory[Show filtered inventory]
    
    %% Add Medication Process
    AddMedication --> FillMedicationForm[Fill medication details form]
    FillMedicationForm --> ValidateMedicationData[Validate medication data]
    ValidateMedicationData --> CheckDuplicate[Check for duplicate medication]
    CheckDuplicate --> Duplicate{Duplicate exists?}
    Duplicate -->|Yes| ShowDuplicateError[Show duplicate error]
    ShowDuplicateError --> FillMedicationForm
    Duplicate -->|No| SaveMedication[Save medication to inventory]
    SaveMedication --> ConfirmMedicationAdded[Confirm medication added]
    
    %% Update Stock Process
    UpdateStock --> SelectMedication[Select medication to update]
    SelectMedication --> EnterStockUpdate[Enter stock update details]
    EnterStockUpdate --> ValidateStockData[Validate stock data]
    ValidateStockData --> UpdateStockLevel[Update stock level]
    UpdateStockLevel --> ConfirmStockUpdated[Confirm stock updated]
    
    %% View Prescriptions Process
    ViewPrescriptions --> DisplayPrescriptions[Display prescription list]
    DisplayPrescriptions --> ApplyPrescriptionFilters[Apply prescription filters]
    ApplyPrescriptionFilters --> ShowFilteredPrescriptions[Show filtered prescriptions]
    ShowFilteredPrescriptions --> ViewPrescriptionDetails[View prescription details if selected]
    
    %% Create Prescription Process
    CreatePrescription --> SelectPatient[Select patient]
    SelectPatient --> SelectConsultation[Select consultation]
    SelectConsultation --> AddMedications[Add medications to prescription]
    AddMedications --> SetDosage[Set dosage and instructions]
    SetDosage --> ValidatePrescription[Validate prescription]
    ValidatePrescription --> CheckDrugInteractions[Check drug interactions]
    CheckDrugInteractions --> Interactions{Drug interactions?}
    Interactions -->|Yes| ShowInteractionWarning[Show interaction warning]
    ShowInteractionWarning --> ModifyPrescription[Modify prescription]
    ModifyPrescription --> ValidatePrescription
    Interactions -->|No| SavePrescription[Save prescription]
    SavePrescription --> GeneratePrescriptionNumber[Generate prescription number]
    GeneratePrescriptionNumber --> ConfirmPrescriptionCreated[Confirm prescription created]
    
    ShowFilteredInventory --> End([End])
    ConfirmMedicationAdded --> End
    ConfirmStockUpdated --> End
    ViewPrescriptionDetails --> End
    ConfirmPrescriptionCreated --> End
    
    %% Styling
    classDef process fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    classDef decision fill:#fff3e0,stroke:#f57c00,stroke-width:2px
    classDef error fill:#ffebee,stroke:#d32f2f,stroke-width:2px
    classDef endpoint fill:#e8f5e8,stroke:#388e3c,stroke-width:2px
    
    class AccessMedication,ViewInventory,DisplayInventory,CheckStockLevels,ShowLowStock,FilterInventory,ShowFilteredInventory,AddMedication,FillMedicationForm,ValidateMedicationData,CheckDuplicate,SaveMedication,ConfirmMedicationAdded,UpdateStock,SelectMedication,EnterStockUpdate,ValidateStockData,UpdateStockLevel,ConfirmStockUpdated,ViewPrescriptions,DisplayPrescriptions,ApplyPrescriptionFilters,ShowFilteredPrescriptions,ViewPrescriptionDetails,CreatePrescription,SelectPatient,SelectConsultation,AddMedications,SetDosage,ValidatePrescription,CheckDrugInteractions,SavePrescription,GeneratePrescriptionNumber,ConfirmPrescriptionCreated process
    class SelectAction,Duplicate,Interactions,ValidateMedicationData,ValidateStockData,ValidatePrescription decision
    class ShowDuplicateError,ShowInteractionWarning,ModifyPrescription error
    class End endpoint
```

---

## 7. Invoice & Billing Process

```mermaid
graph TD
    Start([Start]) --> AccessBilling[Access billing management]
    AccessBilling --> SelectAction{Select action}
    
    SelectAction -->|View Invoices| ViewInvoices[View invoice list]
    SelectAction -->|Create Invoice| CreateInvoice[Create new invoice]
    SelectAction -->|Update Invoice| UpdateInvoice[Update invoice]
    SelectAction -->|Process Payment| ProcessPayment[Process payment]
    
    %% View Invoices Process
    ViewInvoices --> DisplayInvoices[Display invoice list]
    DisplayInvoices --> ApplyInvoiceFilters[Apply invoice filters]
    ApplyInvoiceFilters --> ShowFilteredInvoices[Show filtered invoices]
    ShowFilteredInvoices --> ViewInvoiceDetails[View invoice details if selected]
    
    %% Create Invoice Process
    CreateInvoice --> SelectPatient[Select patient]
    SelectPatient --> SelectConsultation[Select consultation]
    SelectConsultation --> CalculateCharges[Calculate service charges]
    CalculateCharges --> AddServiceItems[Add service items]
    AddServiceItems --> CalculateTotal[Calculate total amount]
    CalculateTotal --> GenerateInvoiceNumber[Generate invoice number]
    GenerateInvoiceNumber --> SaveInvoice[Save invoice]
    SaveInvoice --> ConfirmInvoiceCreated[Confirm invoice created]
    
    %% Update Invoice Process
    UpdateInvoice --> SelectInvoice[Select invoice to update]
    SelectInvoice --> LoadInvoiceData[Load invoice data]
    LoadInvoiceData --> ModifyInvoiceData[Modify invoice details]
    ModifyInvoiceData --> ValidateChanges[Validate changes]
    ValidateChanges --> SaveChanges[Save invoice changes]
    SaveChanges --> ConfirmInvoiceUpdated[Confirm invoice updated]
    
    %% Process Payment Process
    ProcessPayment --> SelectInvoiceToPay[Select invoice to pay]
    SelectInvoiceToPay --> EnterPaymentDetails[Enter payment details]
    EnterPaymentDetails --> ValidatePayment[Validate payment information]
    ValidatePayment --> ProcessPaymentTransaction[Process payment transaction]
    ProcessPaymentTransaction --> UpdateInvoiceStatus[Update invoice status]
    UpdateInvoiceStatus --> GenerateReceipt[Generate payment receipt]
    GenerateReceipt --> ConfirmPaymentProcessed[Confirm payment processed]
    
    ViewInvoiceDetails --> End([End])
    ConfirmInvoiceCreated --> End
    ConfirmInvoiceUpdated --> End
    ConfirmPaymentProcessed --> End
    
    %% Styling
    classDef process fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    classDef decision fill:#fff3e0,stroke:#f57c00,stroke-width:2px
    classDef endpoint fill:#e8f5e8,stroke:#388e3c,stroke-width:2px
    
    class AccessBilling,ViewInvoices,DisplayInvoices,ApplyInvoiceFilters,ShowFilteredInvoices,ViewInvoiceDetails,CreateInvoice,SelectPatient,SelectConsultation,CalculateCharges,AddServiceItems,CalculateTotal,GenerateInvoiceNumber,SaveInvoice,ConfirmInvoiceCreated,UpdateInvoice,SelectInvoice,LoadInvoiceData,ModifyInvoiceData,ValidateChanges,SaveChanges,ConfirmInvoiceUpdated,ProcessPayment,SelectInvoiceToPay,EnterPaymentDetails,ValidatePayment,ProcessPaymentTransaction,UpdateInvoiceStatus,GenerateReceipt,ConfirmPaymentProcessed process
    class SelectAction,ValidateChanges,ValidatePayment decision
    class End endpoint
```

---

## Use Case Relationships Summary

### **Include Relationships (Always Executed)**
- **Validate User Credentials** ← Login, Registration
- **Check User Role** ← All authenticated processes
- **Validate Doctor Availability** ← Appointment Booking, Appointment Management
- **Check Time Conflicts** ← Appointment Booking, Appointment Management
- **Validate Patient Data** ← Patient Information Management
- **Record Vital Signs** ← Consultation Management
- **Update Medical Record** ← Consultation Management
- **Check Drug Interactions** ← Prescription Management
- **Calculate Service Charges** ← Invoice Management

### **Extend Relationships (Optional Features)**
- **Reschedule Appointment** → Appointment Management
- **Cancel Appointment** → Appointment Management
- **Schedule Follow-up** → Consultation Management
- **Create Referral** → Consultation Management
- **Export Reports** → All Management Processes
- **Send Notifications** → All Processes
- **Print Prescription** → Prescription Management
- **Generate Receipt** → Invoice Management

### **System Process Flow**
1. **Authentication** → Role-based access control
2. **Data Validation** → Input validation and error handling
3. **Database Operations** → Create, Read, Update, Delete operations
4. **Business Logic** → Application-specific processing
5. **User Feedback** → Confirmation messages and error handling
6. **Session Management** → User session handling

These activity diagrams reflect the actual system processes implemented in the iWellCare Healthcare Management System, showing the real workflow from user interaction to database operations.
