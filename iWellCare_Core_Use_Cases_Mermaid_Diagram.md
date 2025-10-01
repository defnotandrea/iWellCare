# iWellCare Core Use Cases - Fixed Activity Diagrams

## 1. Main System Login Process

```mermaid
graph TD
    Start([Start]) --> AccessLogin[Access Login Page]
    AccessLogin --> EnterCredentials[Enter Username/Password]
    EnterCredentials --> ValidateCredentials{Validate Credentials}
    ValidateCredentials -->|Invalid| ShowError[Show Error Message]
    ShowError --> EnterCredentials
    ValidateCredentials -->|Valid| CheckRole[Check User Role]
    CheckRole --> RedirectDashboard[Redirect to Dashboard]
    RedirectDashboard --> End([End])
    
    %% Styling
    classDef startEnd fill:#e8f5e8,stroke:#388e3c,stroke-width:3px
    classDef process fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    classDef decision fill:#fff3e0,stroke:#f57c00,stroke-width:2px
    classDef error fill:#ffebee,stroke:#d32f2f,stroke-width:2px
    
    class Start,End startEnd
    class AccessLogin,EnterCredentials,CheckRole,RedirectDashboard process
    class ValidateCredentials decision
    class ShowError error
```

## 2. User Registration Process

```mermaid
graph TD
    Start([Start]) --> AccessRegister[Access Registration Page]
    AccessRegister --> FillForm[Fill Registration Form]
    FillForm --> ValidateForm{Validate Form Data}
    ValidateForm -->|Invalid| ShowValidationErrors[Show Validation Errors]
    ShowValidationErrors --> FillForm
    ValidateForm -->|Valid| CreateUser[Create User Account]
    CreateUser --> CreatePatient[Create Patient Profile]
    CreatePatient --> MarkVerified[Mark Email as Verified]
    MarkVerified --> AutoLogin[Auto Login User]
    AutoLogin --> RedirectRole[Redirect Based on Role]
    RedirectRole --> End([End])
    
    %% Styling
    classDef startEnd fill:#e8f5e8,stroke:#388e3c,stroke-width:3px
    classDef process fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    classDef decision fill:#fff3e0,stroke:#f57c00,stroke-width:2px
    classDef error fill:#ffebee,stroke:#d32f2f,stroke-width:2px
    
    class Start,End startEnd
    class AccessRegister,FillForm,CreateUser,CreatePatient,MarkVerified,AutoLogin,RedirectRole process
    class ValidateForm decision
    class ShowValidationErrors error
```

## 3. Appointment Booking Process (Patient)

```mermaid
graph TD
    Start([Start]) --> CheckAuth{User Authenticated?}
    CheckAuth -->|No| RedirectRegister[Redirect to Registration]
    CheckAuth -->|Yes| CheckRole{User Role = Patient?}
    CheckRole -->|No| RedirectHome[Redirect to Home]
    CheckRole -->|Yes| ShowBookingForm[Show Booking Form]
    
    ShowBookingForm --> GetDoctors[Get Available Doctors]
    GetDoctors --> CheckAvailability[Check Doctor Availability]
    CheckAvailability --> DisplayDoctors[Display Doctors with Status]
    
    DisplayDoctors --> SelectDoctor[Patient Selects Doctor]
    SelectDoctor --> ValidateDoctor{Doctor Available?}
    ValidateDoctor -->|No| ShowUnavailable[Show Unavailable Message]
    ShowUnavailable --> SelectDoctor
    ValidateDoctor -->|Yes| SelectDateTime[Select Date and Time]
    
    SelectDateTime --> CheckTimeSlot{Time Slot Available?}
    CheckTimeSlot -->|No| ShowConflict[Show Time Conflict Message]
    ShowConflict --> SelectDateTime
    CheckTimeSlot -->|Yes| FillDetails[Fill Appointment Details]
    
    FillDetails --> ValidateRequest{Validate Request Data}
    ValidateRequest -->|Invalid| ShowValidationErrors[Show Validation Errors]
    ShowValidationErrors --> FillDetails
    ValidateRequest -->|Valid| CreateAppointment[Create Appointment Record]
    
    CreateAppointment --> SetStatus[Set Status to 'Pending']
    SetStatus --> RedirectLogin[Redirect to Login with Success]
    RedirectLogin --> End([End])
    
    RedirectRegister --> End
    RedirectHome --> End
    
    %% Styling
    classDef startEnd fill:#e8f5e8,stroke:#388e3c,stroke-width:3px
    classDef process fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    classDef decision fill:#fff3e0,stroke:#f57c00,stroke-width:2px
    classDef error fill:#ffebee,stroke:#d32f2f,stroke-width:2px
    
    class Start,End startEnd
    class ShowBookingForm,GetDoctors,CheckAvailability,DisplayDoctors,SelectDoctor,SelectDateTime,FillDetails,CreateAppointment,SetStatus,RedirectLogin,RedirectRegister,RedirectHome process
    class CheckAuth,CheckRole,ValidateDoctor,CheckTimeSlot,ValidateRequest decision
    class ShowUnavailable,ShowConflict,ShowValidationErrors error
```

## 4. Appointment Management Process (Staff/Doctor)

```mermaid
graph TD
    Start([Start]) --> AccessAppointments[Access Appointment Management]
    AccessAppointments --> SelectAction{Select Action}
    
    SelectAction -->|Create| CreateAppointment[Create New Appointment]
    SelectAction -->|View| ViewAppointments[View Appointment List]
    SelectAction -->|Edit| EditAppointment[Edit Existing Appointment]
    SelectAction -->|Delete| DeleteAppointment[Delete Appointment]
    
    %% Create Appointment Process
    CreateAppointment --> SelectPatient[Select Patient]
    SelectPatient --> SelectDoctor[Select Doctor]
    SelectDoctor --> CheckDoctorAvailability[Check Doctor Availability]
    CheckDoctorAvailability --> Available{Doctor Available?}
    Available -->|No| ShowUnavailable[Show Unavailable Message]
    ShowUnavailable --> SelectDoctor
    Available -->|Yes| SelectDateTime[Select Date and Time]
    SelectDateTime --> CheckTimeConflict[Check Time Conflicts]
    CheckTimeConflict --> Conflict{Time Conflict?}
    Conflict -->|Yes| ShowConflict[Show Conflict Message]
    ShowConflict --> SelectDateTime
    Conflict -->|No| FillAppointmentDetails[Fill Appointment Details]
    FillAppointmentDetails --> ValidateData[Validate Appointment Data]
    ValidateData --> SaveAppointment[Save Appointment]
    SaveAppointment --> ConfirmCreated[Confirm Appointment Created]
    
    %% View Appointments Process
    ViewAppointments --> DisplayList[Display Appointment List]
    DisplayList --> FilterOptions[Apply Filters if Needed]
    FilterOptions --> ShowResults[Show Filtered Results]
    
    %% Edit Appointment Process
    EditAppointment --> SelectAppointment[Select Appointment to Edit]
    SelectAppointment --> LoadDetails[Load Appointment Details]
    LoadDetails --> ModifyDetails[Modify Appointment Details]
    ModifyDetails --> ValidateChanges[Validate Changes]
    ValidateChanges --> SaveChanges[Save Changes]
    SaveChanges --> ConfirmUpdated[Confirm Appointment Updated]
    
    %% Delete Appointment Process
    DeleteAppointment --> SelectToDelete[Select Appointment to Delete]
    SelectToDelete --> ConfirmDelete[Confirm Deletion]
    ConfirmDelete --> RemoveAppointment[Remove Appointment]
    RemoveAppointment --> ConfirmDeleted[Confirm Appointment Deleted]
    
    ConfirmCreated --> End([End])
    ShowResults --> End
    ConfirmUpdated --> End
    ConfirmDeleted --> End
    
    %% Styling
    classDef startEnd fill:#e8f5e8,stroke:#388e3c,stroke-width:3px
    classDef process fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    classDef decision fill:#fff3e0,stroke:#f57c00,stroke-width:2px
    classDef error fill:#ffebee,stroke:#d32f2f,stroke-width:2px
    
    class Start,End startEnd
    class AccessAppointments,CreateAppointment,SelectPatient,SelectDoctor,CheckDoctorAvailability,SelectDateTime,CheckTimeConflict,FillAppointmentDetails,ValidateData,SaveAppointment,ConfirmCreated,ViewAppointments,DisplayList,FilterOptions,ShowResults,EditAppointment,SelectAppointment,LoadDetails,ModifyDetails,ValidateChanges,SaveChanges,ConfirmUpdated,DeleteAppointment,SelectToDelete,ConfirmDelete,RemoveAppointment,ConfirmDeleted process
    class SelectAction,Available,Conflict,ValidateData,ValidateChanges,ConfirmDelete decision
    class ShowUnavailable,ShowConflict error
```

## 5. Consultation Management Process

```mermaid
graph TD
    Start([Start]) --> AccessConsultation[Access Consultation Management]
    AccessConsultation --> SelectAction{Select Action}
    
    SelectAction -->|Start New| StartConsultation[Start New Consultation]
    SelectAction -->|View| ViewConsultations[View Consultation History]
    SelectAction -->|Update| UpdateConsultation[Update Consultation]
    
    %% Start New Consultation Process
    StartConsultation --> SelectPatient[Select Patient]
    SelectPatient --> SelectAppointment[Select Appointment]
    SelectAppointment --> LoadPatientHistory[Load Patient Medical History]
    LoadPatientHistory --> EnterChiefComplaint[Enter Chief Complaint]
    EnterChiefComplaint --> EnterPresentIllness[Enter Present Illness]
    EnterPresentIllness --> EnterMedicalHistory[Enter Past Medical History]
    EnterMedicalHistory --> EnterFamilyHistory[Enter Family History]
    EnterFamilyHistory --> EnterSocialHistory[Enter Social History]
    
    EnterSocialHistory --> RecordVitalSigns[Record Clinical Measurements]
    RecordVitalSigns --> PerformPhysicalExam[Perform Physical Examination]
    PerformPhysicalExam --> EnterFindings[Enter Physical Examination Findings]
    EnterFindings --> MakeDiagnosis[Make Diagnosis]
    MakeDiagnosis --> CreateTreatmentPlan[Create Treatment Plan]
    CreateTreatmentPlan --> PrescribeMedication[Prescribe Medications]
    PrescribeMedication --> SetFollowUp[Set Follow-up Date if Needed]
    SetFollowUp --> AddConsultationNotes[Add Consultation Notes]
    AddConsultationNotes --> SaveConsultation[Save Consultation Record]
    SaveConsultation --> UpdateMedicalRecord[Update Patient Medical Record]
    UpdateMedicalRecord --> CreatePrescription[Create Prescription Record]
    CreatePrescription --> ConfirmCompleted[Confirm Consultation Completed]
    
    %% View Consultations Process
    ViewConsultations --> DisplayList[Display Consultation List]
    DisplayList --> ApplyFilters[Apply Date/Patient Filters]
    ApplyFilters --> ShowResults[Show Filtered Consultations]
    ShowResults --> ViewDetails[View Consultation Details if Selected]
    
    %% Update Consultation Process
    UpdateConsultation --> SelectConsultation[Select Consultation to Update]
    SelectConsultation --> LoadConsultation[Load Consultation Details]
    LoadConsultation --> ModifyDetails[Modify Consultation Details]
    ModifyDetails --> ValidateChanges[Validate Changes]
    ValidateChanges --> SaveChanges[Save Changes]
    SaveChanges --> UpdateRecords[Update Related Records]
    UpdateRecords --> ConfirmUpdated[Confirm Consultation Updated]
    
    ConfirmCompleted --> End([End])
    ViewDetails --> End
    ConfirmUpdated --> End
    
    %% Styling
    classDef startEnd fill:#e8f5e8,stroke:#388e3c,stroke-width:3px
    classDef process fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    classDef decision fill:#fff3e0,stroke:#f57c00,stroke-width:2px
    
    class Start,End startEnd
    class AccessConsultation,StartConsultation,SelectPatient,SelectAppointment,LoadPatientHistory,EnterChiefComplaint,EnterPresentIllness,EnterMedicalHistory,EnterFamilyHistory,EnterSocialHistory,RecordVitalSigns,PerformPhysicalExam,EnterFindings,MakeDiagnosis,CreateTreatmentPlan,PrescribeMedication,SetFollowUp,AddConsultationNotes,SaveConsultation,UpdateMedicalRecord,CreatePrescription,ConfirmCompleted,ViewConsultations,DisplayList,ApplyFilters,ShowResults,ViewDetails,UpdateConsultation,SelectConsultation,LoadConsultation,ModifyDetails,ValidateChanges,SaveChanges,UpdateRecords,ConfirmUpdated process
    class SelectAction,ValidateChanges decision
```

## 6. Patient Information Management Process

```mermaid
graph TD
    Start([Start]) --> AccessPatientInfo[Access Patient Information]
    AccessPatientInfo --> CheckRole{User Role?}
    
    CheckRole -->|Patient| PatientSelfService[Patient Self-Service]
    CheckRole -->|Staff/Doctor| StaffPatientManagement[Staff/Doctor Patient Management]
    
    %% Patient Self-Service Process
    PatientSelfService --> ViewOwnInfo[View Own Information]
    ViewOwnInfo --> UpdateOwnInfo[Update Own Information]
    UpdateOwnInfo --> ValidateOwnData[Validate Own Data]
    ValidateOwnData --> SaveOwnChanges[Save Own Changes]
    SaveOwnChanges --> ConfirmOwnUpdated[Confirm Information Updated]
    
    %% Staff/Doctor Patient Management Process
    StaffPatientManagement --> SelectAction{Select Action}
    SelectAction -->|View| ViewPatientList[View Patient List]
    SelectAction -->|Add| AddNewPatient[Add New Patient]
    SelectAction -->|Update| UpdatePatientInfo[Update Patient Information]
    SelectAction -->|View Details| ViewPatientDetails[View Patient Details]
    
    %% View Patient List Process
    ViewPatientList --> DisplayPatients[Display Patient List]
    DisplayPatients --> ApplyFilters[Apply Search Filters]
    ApplyFilters --> ShowFilteredResults[Show Filtered Results]
    
    %% Add New Patient Process
    AddNewPatient --> FillPatientForm[Fill Patient Registration Form]
    FillPatientForm --> ValidatePatientData[Validate Patient Data]
    ValidatePatientData --> CreateUserAccount[Create User Account]
    CreateUserAccount --> CreatePatientProfile[Create Patient Profile]
    CreatePatientProfile --> ConfirmPatientAdded[Confirm Patient Added]
    
    %% Update Patient Information Process
    UpdatePatientInfo --> SelectPatient[Select Patient to Update]
    SelectPatient --> LoadPatientData[Load Patient Data]
    LoadPatientData --> ModifyPatientData[Modify Patient Information]
    ModifyPatientData --> ValidateChanges[Validate Changes]
    ValidateChanges --> SavePatientChanges[Save Patient Changes]
    SavePatientChanges --> ConfirmPatientUpdated[Confirm Patient Updated]
    
    %% View Patient Details Process
    ViewPatientDetails --> SelectPatientToView[Select Patient to View]
    SelectPatientToView --> LoadFullDetails[Load Full Patient Details]
    LoadFullDetails --> DisplayDetails[Display Patient Details]
    DisplayDetails --> ViewMedicalHistory[View Medical History if Needed]
    ViewMedicalHistory --> ViewAppointments[View Appointments if Needed]
    ViewAppointments --> ViewConsultations[View Consultations if Needed]
    
    ConfirmOwnUpdated --> End([End])
    ShowFilteredResults --> End
    ConfirmPatientAdded --> End
    ConfirmPatientUpdated --> End
    ViewConsultations --> End
    
    %% Styling
    classDef startEnd fill:#e8f5e8,stroke:#388e3c,stroke-width:3px
    classDef process fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    classDef decision fill:#fff3e0,stroke:#f57c00,stroke-width:2px
    
    class Start,End startEnd
    class AccessPatientInfo,PatientSelfService,ViewOwnInfo,UpdateOwnInfo,ValidateOwnData,SaveOwnChanges,ConfirmOwnUpdated,StaffPatientManagement,ViewPatientList,DisplayPatients,ApplyFilters,ShowFilteredResults,AddNewPatient,FillPatientForm,ValidatePatientData,CreateUserAccount,CreatePatientProfile,ConfirmPatientAdded,UpdatePatientInfo,SelectPatient,LoadPatientData,ModifyPatientData,ValidateChanges,SavePatientChanges,ConfirmPatientUpdated,ViewPatientDetails,SelectPatientToView,LoadFullDetails,DisplayDetails,ViewMedicalHistory,ViewAppointments,ViewConsultations process
    class CheckRole,SelectAction,ValidateOwnData,ValidatePatientData,ValidateChanges decision
```

## 7. Include and Extend Relationships Diagram

```mermaid
graph TD
    %% Main Use Cases
    Login[Login Process] --> ValidateCredentials[<<include>> Validate Credentials]
    Login --> CheckRole[<<include>> Check User Role]
    
    BookAppointment[Book Appointment] --> ValidateAvailability[<<include>> Validate Doctor Availability]
    BookAppointment --> CheckConflicts[<<include>> Check Time Conflicts]
    BookAppointment --> SendNotification[<<include>> Send Notification]
    
    ManageAppointment[Manage Appointment] --> ValidateAvailability
    ManageAppointment --> CheckConflicts
    ManageAppointment --> SendNotification
    
    ManageConsultation[Manage Consultation] --> RecordVitals[<<include>> Record Vital Signs]
    ManageConsultation --> CreatePrescription[<<include>> Create Prescription]
    ManageConsultation --> UpdateMedicalRecord[<<include>> Update Medical Record]
    
    ManagePatientInfo[Manage Patient Information] --> ValidatePatientData[<<include>> Validate Patient Data]
    ManagePatientInfo --> SaveChanges[<<include>> Save Changes]
    
    ManageMedication[Manage Medication] --> CheckInventory[<<include>> Check Medication Inventory]
    ManageMedication --> ValidatePrescription[<<include>> Validate Prescription]
    ManageMedication --> UpdateStock[<<include>> Update Stock Levels]
    
    ManageInvoice[Manage Invoice] --> CalculateCharges[<<include>> Calculate Service Charges]
    ManageInvoice --> GenerateInvoice[<<include>> Generate Invoice Document]
    ManageInvoice --> ProcessPayment[<<include>> Process Payment]
    
    GenerateReports[Generate Reports] --> AggregateData[<<include>> Aggregate Data]
    GenerateReports --> FormatReport[<<include>> Format Report]
    
    %% Extend Relationships (Optional)
    ManageAppointment -.->|extend| RescheduleAppointment[Reschedule Appointment]
    ManageAppointment -.->|extend| CancelAppointment[Cancel Appointment]
    
    ManageConsultation -.->|extend| ScheduleFollowUp[Schedule Follow-up]
    ManageConsultation -.->|extend| CreateReferral[Create Referral]
    
    ManagePatientInfo -.->|extend| UpdateProfilePhoto[Update Profile Photo]
    ManagePatientInfo -.->|extend| UpdateEmergencyContact[Update Emergency Contact]
    
    GenerateReports -.->|extend| ExportReport[Export Report]
    GenerateReports -.->|extend| ScheduleRecurringReport[Schedule Recurring Report]
    
    %% Styling
    classDef mainUseCase fill:#e3f2fd,stroke:#1976d2,stroke-width:2px
    classDef includeUseCase fill:#e8f5e8,stroke:#388e3c,stroke-width:2px
    classDef extendUseCase fill:#fff3e0,stroke:#f57c00,stroke-width:2px
    
    class Login,BookAppointment,ManageAppointment,ManageConsultation,ManagePatientInfo,ManageMedication,ManageInvoice,GenerateReports mainUseCase
    class ValidateCredentials,CheckRole,ValidateAvailability,CheckConflicts,SendNotification,RecordVitals,CreatePrescription,UpdateMedicalRecord,ValidatePatientData,SaveChanges,CheckInventory,ValidatePrescription,UpdateStock,CalculateCharges,GenerateInvoice,ProcessPayment,AggregateData,FormatReport includeUseCase
    class RescheduleAppointment,CancelAppointment,ScheduleFollowUp,CreateReferral,UpdateProfilePhoto,UpdateEmergencyContact,ExportReport,ScheduleRecurringReport extendUseCase
```

## Use Case Relationships Summary

### **Include Relationships (Always Executed)**
- **Validate Credentials** ← Login Process
- **Check User Role** ← Login Process
- **Validate Doctor Availability** ← Manage Appointment, Book Appointment
- **Check Time Conflicts** ← Manage Appointment, Book Appointment  
- **Send Notification** ← Manage Appointment, Book Appointment
- **Record Vital Signs** ← Manage Consultation
- **Create Prescription** ← Manage Consultation
- **Update Medical Record** ← Manage Consultation
- **Validate Patient Data** ← Manage Patient Information
- **Save Changes** ← Manage Patient Information
- **Check Medication Inventory** ← Manage Medication
- **Validate Prescription** ← Manage Medication
- **Update Stock Levels** ← Manage Medication
- **Calculate Service Charges** ← Manage Invoice
- **Generate Invoice Document** ← Manage Invoice
- **Process Payment** ← Manage Invoice
- **Aggregate Data** ← Generate Reports
- **Format Report** ← Generate Reports

### **Extend Relationships (Conditionally Executed)**
- **Reschedule Appointment** → Manage Appointment
- **Cancel Appointment** → Manage Appointment
- **Schedule Follow-up** → Manage Consultation
- **Create Referral** → Manage Consultation
- **Update Profile Photo** → Manage Patient Information
- **Update Emergency Contact** → Manage Patient Information
- **Export Report** → Generate Reports
- **Schedule Recurring Report** → Generate Reports

## **Fixed Activity Diagram Features:**

### **✅ Proper Symbols Used:**
- **`([Start])`** and **`([End])`** - Correct start/end nodes
- **`[Action]`** - Proper action rectangles
- **`{Decision}`** - Correct decision diamonds
- **`<<include>>`** - Include relationships
- **`<<extend>>`** - Extend relationships with dotted lines

### **✅ Correct Alignment:**
- **Top to Bottom Flow** - Logical process progression
- **Left to Right Branching** - Clear decision paths
- **Proper Error Handling** - Separate error paths
- **Consistent Styling** - Color-coded elements

### **✅ Based on Real System Processes:**
- **Authentication Flow** - Actual login/registration process
- **Appointment Booking** - Real validation and availability checks
- **Consultation Management** - Complete medical workflow
- **Patient Management** - Role-based access control
- **Include/Extend Relationships** - Proper UML relationships

The diagrams now follow proper activity diagram conventions and reflect the actual iWellCare system processes!
