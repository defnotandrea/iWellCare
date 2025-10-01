# iWellCare Data Dictionary

## A
**appointments** = id + patient_id + doctor_id + appointment_date + appointment_time + type + status + notes + symptoms + priority + duration + room_number + created_by + updated_by + created_at + updated_at

**amount** = 10₂ {Legal_Number}

**address** = 255₁ {Legal_Character}

**age** = 50₁ {Legal_Number}

**article** = 255₁ {Legal_Character}

**appointment_date** = {yyyy-mm-dd}

**appointment_time** = {hh:mm:ss}

**archived** = 1₁ {Legal_Boolean}

**archived_at** = {yyyy-mm-dd hh:mm:ss}

**available_days** = {JSON_Array}

**available_hours** = {JSON_Array}

## B
**billings** = id + patient_id + appointment_id + amount + consultation_fee + medication_fee + laboratory_fee + other_fees + total_amount + status + payment_date + created_at + updated_at

**bills** = id + patient_id + amount + status + billing_date

**blood_pressure** = 255₁ {Legal_Character}

**blood_type** = 5₁ {Legal_Character}

**bio** = {Text}

**batch_number** = 255₁ {Legal_Character}

## C
**consultations** = id + appointment_id + patient_id + doctor_id + consultation_date + consultation_time + status + chief_complaint + present_illness + past_medical_history + family_history + social_history + clinical_measurements + symptoms + diagnosis + treatment_plan + prescription + notes + physical_examination + prescription_notes + follow_up_date + follow_up_notes + consultation_notes + created_by + updated_by + created_at + updated_at

**consult_datetime** = {yyyy-mm-dd hh:mm:ss}

**consultation_fee** = 10₂ {Legal_Number}

**created_at** = {yyyy-mm-dd hh:mm:ss}

**city** = 255₁ {Legal_Character}

**country** = 255₁ {Legal_Character}

**contact** = 255₁ {Legal_Character}

**contact_number** = 255₁ {Legal_Character}

**chief_complaint** = 255₁ {Legal_Character}

**clinical_measurements** = {JSON_Object}

**category** = {Enum: medicine, supplies, equipment}

## D
**date_issued** = {mm/dd/yyyy}

**date_time** = {yyyy-mm-dd hh:mm:ss}

**description** = 255₁ {Legal_Character}

**dob** = {mm/dd/yyyy}

**date_of_birth** = {yyyy-mm-dd}

**diagnosis** = {Text}

**duration** = 50₁ {Legal_Number}

**dosage** = 255₁ {Legal_Character}

## E
**email** = 255₁ {Legal_Character}

**email_verified_at** = {yyyy-mm-dd hh:mm:ss}

**emergency_contact** = 255₁ {Legal_Character}

**emergency_contact_phone** = 255₁ {Legal_Character}

**expiration_date** = {yyyy-mm-dd}

**equipment** = 255₁ {Legal_Character}

## F
**first_name** = 255₁ {Legal_Character}

**follow_up_date** = {yyyy-mm-dd}

**follow_up_notes** = {Text}

**family_history** = {Text}

## G
**grand_total** = 10₂ {Legal_Number}

**gender** = {Enum: male, female, other}

## H
**height** = 10₂ {Legal_Number}

## I
**id** = 50₁ {Legal_Number}

**invoice_items** = id + invoice_id + article + unit_cost + quantity + amount

**invoices** = id + patient_id + invoice_no + date_issued + total_sales + less_sc + net_of_sc + withholding + grand_total + created_at

**invoice_id** = 50₁ {Legal_Number}

**inventory** = id + name + description + category + quantity + reorder_level + expiration_date + unit_price + supplier + location + batch_number + notes + created_by + updated_by + last_updated + is_active + archived + created_at + updated_at

**is_active** = 50₁ {Legal_Number}

**instructions** = {Text}

**insurance_provider** = 255₁ {Legal_Character}

**insurance_number** = 255₁ {Legal_Character}

**imaging_results** = {Text}

## L
**last_name** = 255₁ {Legal_Character}

**lab_request_items** = id + lab_request_id + test_code + test_name

**lab_requests** = id + patient_id + test_name + test_type + request_date + requested_at + status + created_at

**lab_results** = id + request_id + result + resulted_at

**license_number** = 255₁ {Legal_Character}

**location** = 255₁ {Legal_Character}

**laboratory_fee** = 10₂ {Legal_Number}

**less_sc** = 10₂ {Legal_Number}

## M
**medical_records** = id + patient_id + doctor_id + appointment_id + record_number + record_date + chief_complaint + present_illness + past_medical_history + family_history + social_history + review_of_systems + physical_examination + diagnosis + treatment_plan + medications_prescribed + lab_results + imaging_results + clinical_measurements + allergies + notes + status + record_type + is_confidential + archived_at + created_at + updated_at

**medications** = id + name + type + dosage + quantity + expiration_date + created_at

**medication** = 255₁ {Legal_Character}

**medication_fee** = 10₂ {Legal_Number}

**middle_name** = 255₁ {Legal_Character}

**medical_history** = {Text}

**medications_prescribed** = {Text}

## N
**net_of_sc** = 10₂ {Legal_Number}

**notes** = 255₁ {Legal_Character}

**name** = 255₁ {Legal_Character}

## O
**occupation** = 255₁ {Legal_Character}

**other_fees** = 10₂ {Legal_Number}

## P
**patient_id** = 50₁ {Legal_Number}

**payment_date** = {yyyy-mm-dd hh:mm:ss}

**payments** = id + bill_id + amount + payment_date

**prescriptions** = id + patient_id + doctor_id + appointment_id + prescription_number + prescription_date + diagnosis + notes + instructions + status + valid_until + is_printed + printed_at + created_at + updated_at

**purpose** = 255₁ {Legal_Character}

**prescription_notes** = {Text}

**prescription_number** = 255₁ {Legal_Character}

**prescription_date** = {yyyy-mm-dd}

**phone_number** = 255₁ {Legal_Character}

**postal_code** = 255₁ {Legal_Character}

**priority** = {Enum: low, medium, high, urgent}

**profile_photo** = 255₁ {Legal_Character}

**physical_examination** = {Text}

**present_illness** = {Text}

**past_medical_history** = {Text}

## Q
**quantity** = 50₁ {Legal_Number}

**qualifications** = {Text}

## R
**record_date** = {yyyy-mm-dd hh:mm:ss}

**record_datetime** = {yyyy-mm-dd hh:mm:ss}

**record_type** = {Enum: consultation, follow_up, emergency, routine}

**reorder_level** = 50₁ {Legal_Number}

**request_date** = {yyyy-mm-dd hh:mm:ss}

**requested_at** = {yyyy-mm-dd hh:mm:ss}

**room_number** = 255₁ {Legal_Character}

**registration_date** = {yyyy-mm-dd hh:mm:ss}

**review_of_systems** = {Text}

**resulted_at** = {yyyy-mm-dd hh:mm:ss}

## S
**sex** = 255₁ {Legal_Character}

**status** = 255₁ {Legal_Character}

**test_code** = 50₁ {Legal_Character}

**test_name** = 255₁ {Legal_Character}

**supplier** = 255₁ {Legal_Character}

**street_address** = 255₁ {Legal_Character}

**state_province** = 255₁ {Legal_Character}

**state** = 255₁ {Legal_Character}

**symptoms** = {Text}

**social_history** = {Text}

**specialization** = 255₁ {Legal_Character}

**suspended** = 255₁ {Legal_Character}

## T
**total_amount** = 10₂ {Legal_Number}

**total_sales** = 10₂ {Legal_Number}

**type** = 255₁ {Legal_Character}

**treatment_plan** = {Text}

## U
**unit_cost** = 10₂ {Legal_Number}

**unit_price** = 10₂ {Legal_Number}

**username** = 255₁ {Legal_Character}

**users** = id + username + email + email_verified_at + password + first_name + last_name + middle_name + date_of_birth + gender + phone_number + street_address + city + state_province + postal_code + country + role + is_active + profile_photo + remember_token + created_at + updated_at

**updated_by** = 50₁ {Legal_Number}

**updated_at** = {yyyy-mm-dd hh:mm:ss}

## V
**valid_until** = {yyyy-mm-dd}

## W
**weight** = 10₂ {Legal_Number}

**withholding** = 10₂ {Legal_Number}

## Y
**years_of_experience** = 50₁ {Legal_Number}

## Z
**zip_code** = 255₁ {Legal_Character}

---

## Additional Tables

**doctors** = id + user_id + specialization + license_number + years_of_experience + qualifications + bio + status + consultation_fee + available_days + available_hours + contact_number + emergency_contact + address + city + state + postal_code + country + created_at + updated_at

**inventory_logs** = id + item_id + adjustment_quantity + notes + adjusted_by + adjusted_at

**otp_codes** = id + email + code + type + expires_at + is_used + created_at + updated_at

**prescription_medications** = id + prescription_id + medication_id + dosage + frequency + duration + instructions + created_at + updated_at

**doctor_availability_settings** = id + doctor_id + day_of_week + start_time + end_time + is_available + created_at + updated_at

**sessions** = id + user_id + ip_address + user_agent + payload + last_activity + created_at + updated_at

---

## Data Types Legend
- **50₁** = Integer (unsigned)
- **255₁** = String with max length 255
- **10₂** = Decimal with 10 total digits and 2 decimal places
- **1₁** = Boolean
- **{Text}** = Long text field
- **{JSON_Object}** = JSON data type
- **{JSON_Array}** = JSON array data type
- **{Enum: values}** = Enumeration with specific allowed values
- **{yyyy-mm-dd}** = Date format
- **{hh:mm:ss}** = Time format
- **{yyyy-mm-dd hh:mm:ss}** = DateTime format
- **{mm/dd/yyyy}** = Date format (US style) 