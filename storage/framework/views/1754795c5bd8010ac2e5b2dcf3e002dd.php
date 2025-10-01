

<?php $__env->startSection('title', 'Start Consultation - iWellCare'); ?>
<?php $__env->startSection('page-title', 'Start New Consultation'); ?>
<?php $__env->startSection('page-subtitle', 'Begin a consultation with a patient'); ?>

<?php $__env->startSection('content'); ?>
<div class="consultations-content">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Start New Consultation</h2>
            <p class="text-gray-600">Begin a consultation with a patient</p>
        </div>
        <div class="flex gap-3">
            <a href="<?php echo e(route('staff.consultations.index')); ?>" class="btn btn-secondary flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Consultations</span>
            </a>
        </div>
    </div>

    <!-- Main Form -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Patient Info & Clinical Measurements -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Patient Selection Card -->
            <div class="card">
                <div class="px-6 py-4 border-b border-blue-200 bg-blue-50">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-user text-blue-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-blue-900">Patient Information</h3>
                            <p class="text-blue-600 text-sm">Select patient and basic details</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <form action="<?php echo e(route('staff.consultations.store')); ?>" method="POST" id="consultationForm">
                        <?php echo csrf_field(); ?>
                        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
                        
                        <!-- Appointment Selection -->
                        <div class="mb-6">
                            <label for="appointment_id" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-calendar-check text-gray-400 mr-2"></i>Appointment (Optional)
                            </label>
                            <select name="appointment_id" id="appointment_id"
                                    class="form-input w-full">
                                <option value="">Select from upcoming appointments</option>
                                <?php $__currentLoopData = $appointments ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($appointment && is_object($appointment)): ?>
                                        <option value="<?php echo e($appointment->id ?? ''); ?>" data-patient="<?php echo e($appointment->patient_id ?? ''); ?>" data-doctor="<?php echo e($appointment->doctor?->user_id ?? ''); ?>" data-date="<?php echo e($appointment->appointment_date ?? ''); ?>" data-time="<?php echo e($appointment->appointment_time ?? ''); ?>">
                                            <?php echo e($appointment->patient?->user?->first_name ?? ''); ?> <?php echo e($appointment->patient?->user?->last_name ?? ''); ?> -
                                            Dr. <?php echo e($appointment->doctor?->user?->first_name ?? ''); ?> <?php echo e($appointment->doctor?->user?->last_name ?? ''); ?> -
                                            <?php echo e($appointment->appointment_date ? \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') : 'N/A'); ?> at <?php echo e($appointment->appointment_time ?? 'N/A'); ?>

                                        </option>
                                    <?php endif; ?>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <p class="mt-1 text-xs text-gray-500">Selecting an appointment will auto-fill patient and doctor information</p>
                        </div>

                        <!-- Patient Selection -->
                        <div class="mb-6">
                            <label for="patient_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Patient <span class="text-red-500">*</span>
                            </label>
                            <select name="patient_id" id="patient_id"
                                    class="form-input w-full <?php $__errorArgs = ['patient_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    required>
                                <option value="">Select Patient</option>
                                <?php $__currentLoopData = $patients ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($patient): ?>
                                        <option value="<?php echo e($patient->id); ?>" <?php echo e(old('patient_id', $selectedPatientId ?? '') == $patient->id ? 'selected' : ''); ?>>
                                            <?php echo e($patient->first_name ?? ''); ?> <?php echo e($patient->last_name ?? ''); ?> - <?php echo e($patient->email ?? 'No Email'); ?>

                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['patient_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Consultation Date -->
                        <div class="mb-6">
                            <label for="consultation_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Consultation Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="consultation_date" id="consultation_date" 
                                   class="form-input w-full <?php $__errorArgs = ['consultation_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('consultation_date', date('Y-m-d'))); ?>" required>
                            <?php $__errorArgs = ['consultation_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Doctor Selection -->
                        <div class="mb-6">
                            <label for="doctor_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Doctor <span class="text-red-500">*</span>
                            </label>
                            <select name="doctor_id" id="doctor_id"
                                    class="form-input w-full <?php $__errorArgs = ['doctor_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    required>
                                <option value="">Select Doctor</option>
                                <?php $__currentLoopData = $doctors ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($doctor): ?>
                                        <option value="<?php echo e($doctor->user_id); ?>" <?php echo e(old('doctor_id') == $doctor->user_id ? 'selected' : ''); ?>>
                                            Dr. <?php echo e($doctor->user->first_name ?? ''); ?> <?php echo e($doctor->user->last_name ?? ''); ?> - <?php echo e($doctor->specialization ?? 'General'); ?>

                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['doctor_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                </div>
            </div>

            <!-- Clinical Measurements Card -->
            <div class="card">
                <div class="px-6 py-4 border-b border-green-200 bg-green-50">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-heartbeat text-green-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-green-900">Clinical Measurements</h3>
                            <p class="text-green-600 text-sm">Record patient clinical measurements</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Blood Pressure -->
                        <div>
                            <label for="blood_pressure" class="block text-sm font-medium text-gray-700 mb-2">
                                Blood Pressure
                            </label>
                            <input type="text" name="blood_pressure" id="blood_pressure" 
                                   class="form-input w-full" 
                                   placeholder="120/80 mmHg">
                        </div>

                        <!-- Heart Rate -->
                        <div>
                            <label for="heart_rate" class="block text-sm font-medium text-gray-700 mb-2">
                                Heart Rate
                            </label>
                            <input type="text" name="heart_rate" id="heart_rate" 
                                   class="form-input w-full" 
                                   placeholder="72 bpm">
                        </div>

                        <!-- Temperature -->
                        <div>
                            <label for="temperature" class="block text-sm font-medium text-gray-700 mb-2">
                                Temperature
                            </label>
                            <input type="text" name="temperature" id="temperature" 
                                   class="form-input w-full" 
                                   placeholder="98.6°F">
                        </div>

                        <!-- Respiratory Rate -->
                        <div>
                            <label for="respiratory_rate" class="block text-sm font-medium text-gray-700 mb-2">
                                Respiratory Rate
                            </label>
                            <input type="text" name="respiratory_rate" id="respiratory_rate" 
                                   class="form-input w-full" 
                                   placeholder="16/min">
                        </div>

                        <!-- Height -->
                        <div>
                            <label for="height" class="block text-sm font-medium text-gray-700 mb-2">
                                Height
                            </label>
                            <input type="text" name="height" id="height" 
                                   class="form-input w-full" 
                                   placeholder="170 cm">
                        </div>

                        <!-- Weight -->
                        <div>
                            <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">
                                Weight
                            </label>
                            <input type="text" name="weight" id="weight" 
                                   class="form-input w-full" 
                                   placeholder="70 kg">
                        </div>

                        <!-- BMI -->
                        <div class="col-span-2">
                            <label for="bmi" class="block text-sm font-medium text-gray-700 mb-2">
                                BMI (Auto-calculated)
                            </label>
                            <input type="text" name="bmi" id="bmi" 
                                   class="form-input w-full bg-gray-50" 
                                   placeholder="24.2" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Medical Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Chief Complaint Card -->
            <div class="card">
                <div class="px-6 py-4 border-b border-red-200 bg-red-50">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-exclamation-triangle text-red-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-red-900">Chief Complaint</h3>
                            <p class="text-red-600 text-sm">Patient's main reason for visit</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="mb-4">
                        <label for="chief_complaint" class="block text-sm font-medium text-gray-700 mb-2">
                            Chief Complaint <span class="text-red-500">*</span>
                        </label>
                        <textarea name="chief_complaint" id="chief_complaint" rows="3" 
                                  class="form-input w-full <?php $__errorArgs = ['chief_complaint'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                  placeholder="Enter the patient's main complaint or reason for visit..." required><?php echo e(old('chief_complaint')); ?></textarea>
                        <?php $__errorArgs = ['chief_complaint'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            <!-- Medical History Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Present Illness -->
                <div class="card">
                    <div class="px-4 py-4 border-b border-yellow-200 bg-yellow-50">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-clock text-yellow-600"></i>
                            </div>
                            <div>
                                <h3 class="text-md font-semibold text-yellow-900">Present Illness</h3>
                                <p class="text-yellow-600 text-xs">Current symptoms</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        <textarea name="present_illness" id="present_illness" rows="4" 
                                  class="form-input w-full <?php $__errorArgs = ['present_illness'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                  placeholder="Describe the history and progression of the current illness..."><?php echo e(old('present_illness')); ?></textarea>
                        <?php $__errorArgs = ['present_illness'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <!-- Past Medical History -->
                <div class="card">
                    <div class="px-4 py-4 border-b border-purple-200 bg-purple-50">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-history text-purple-600"></i>
                            </div>
                            <div>
                                <h3 class="text-md font-semibold text-purple-900">Past Medical History</h3>
                                <p class="text-purple-600 text-xs">Previous conditions</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        <textarea name="past_medical_history" id="past_medical_history" rows="4" 
                                  class="form-input w-full <?php $__errorArgs = ['past_medical_history'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                  placeholder="Relevant past medical conditions, surgeries, etc..."><?php echo e(old('past_medical_history')); ?></textarea>
                        <?php $__errorArgs = ['past_medical_history'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <!-- Current Medications -->
                <div class="card">
                    <div class="px-4 py-4 border-b border-blue-200 bg-blue-50">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-pills text-blue-600"></i>
                            </div>
                            <div>
                                <h3 class="text-md font-semibold text-blue-900">Current Medications</h3>
                                <p class="text-blue-600 text-xs">Active prescriptions</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        <textarea name="medications" id="medications" rows="4" 
                                  class="form-input w-full <?php $__errorArgs = ['medications'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                  placeholder="List current medications and dosages..."><?php echo e(old('medications')); ?></textarea>
                        <?php $__errorArgs = ['medications'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <!-- Allergies -->
                <div class="card">
                    <div class="px-4 py-4 border-b border-orange-200 bg-orange-50">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-exclamation-circle text-orange-600"></i>
                            </div>
                            <div>
                                <h3 class="text-md font-semibold text-orange-900">Allergies</h3>
                                <p class="text-orange-600 text-xs">Known allergies</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        <textarea name="allergies" id="allergies" rows="4" 
                                  class="form-input w-full <?php $__errorArgs = ['allergies'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                  placeholder="List any known allergies..."><?php echo e(old('allergies')); ?></textarea>
                        <?php $__errorArgs = ['allergies'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card">
                <div class="p-6">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-4">
                            <button type="button" id="saveDraftBtn" class="btn btn-secondary flex items-center gap-2">
                                <i class="fas fa-save"></i>
                                <span>Save Draft</span>
                            </button>
                            <button type="button" id="previewBtn" class="btn btn-secondary flex items-center gap-2">
                                <i class="fas fa-eye"></i>
                                <span>Preview</span>
                            </button>
                        </div>
                        <div class="flex items-center space-x-3">
                            <a href="<?php echo e(route('staff.consultations.index')); ?>" class="btn btn-secondary">
                                Cancel
                            </a>
                            <button type="submit" form="consultationForm" class="btn btn-primary flex items-center gap-2">
                                <i class="fas fa-stethoscope"></i>
                                <span>Start Consultation</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set consultation date to today by default
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('consultation_date').value = today;
    
    // Auto-calculate BMI when height and weight are entered
    const heightInput = document.getElementById('height');
    const weightInput = document.getElementById('weight');
    const bmiInput = document.getElementById('bmi');
    
    function calculateBMI() {
        const height = parseFloat(heightInput.value);
        const weight = parseFloat(weightInput.value);
        
        if (height && weight && height > 0) {
            const heightInMeters = height / 100; // Convert cm to meters
            const bmi = weight / (heightInMeters * heightInMeters);
            bmiInput.value = bmi.toFixed(1);
        }
    }
    
    heightInput.addEventListener('input', calculateBMI);
    weightInput.addEventListener('input', calculateBMI);
    
    // Auto-fill appointment data when appointment is selected
    const appointmentSelect = document.getElementById('appointment_id');
    appointmentSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            const patientId = selectedOption.getAttribute('data-patient');
            const doctorId = selectedOption.getAttribute('data-doctor');
            const appointmentDate = selectedOption.getAttribute('data-date');

            // Auto-fill patient
            document.getElementById('patient_id').value = patientId;

            // Auto-fill doctor
            document.getElementById('doctor_id').value = doctorId;

            // Auto-fill consultation date
            if (appointmentDate) {
                document.getElementById('consultation_date').value = appointmentDate;
            }

            // Fetch patient data
            if (patientId) {
                fetchPatientData(patientId);
            }
        }
    });

    // Auto-fetch patient data when patient is selected
    const patientSelect = document.getElementById('patient_id');
    patientSelect.addEventListener('change', function() {
        const patientId = this.value;
        if (patientId) {
            fetchPatientData(patientId);
        } else {
            clearPatientData();
        }
    });
    
    // Save Draft Button Functionality
    const saveDraftBtn = document.getElementById('saveDraftBtn');
    saveDraftBtn.addEventListener('click', function() {
        saveDraft();
    });
    
    // Preview Button Functionality
    const previewBtn = document.getElementById('previewBtn');
    previewBtn.addEventListener('click', function() {
        previewConsultation();
    });
    
    // Save Draft Function
    function saveDraft() {
        const formData = new FormData(document.getElementById('consultationForm'));
        formData.append('status', 'draft');
        
        fetch('<?php echo e(route("staff.consultations.store")); ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage('Draft saved successfully!', 'success');
            } else {
                showMessage('Error saving draft: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('Error saving draft. Please try again.', 'error');
        });
    }
    
    // Preview Consultation Function
    function previewConsultation() {
        const formData = new FormData(document.getElementById('consultationForm'));
        
        // Create preview modal
        const modalId = 'previewModal';
        
        // Remove existing modal if any
        const existingModal = document.getElementById(modalId);
        if (existingModal) {
            existingModal.remove();
        }
        
        // Create modal HTML
        const modalHtml = `
            <div id="${modalId}" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full mx-4 transform transition-all max-h-[90vh] overflow-y-auto">
                    <div class="px-8 py-6">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-eye text-blue-600 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900">Consultation Preview</h3>
                                    <p class="text-gray-600 text-sm">Review consultation details before saving</p>
                                </div>
                            </div>
                            <button onclick="closePreviewModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>
                        
                        <div class="mb-6">
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                                <h4 class="font-semibold text-gray-900 mb-4">Consultation Details</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p><strong>Patient:</strong> ${(() => {
                                            const select = document.getElementById('patient_id');
                                            return select.selectedIndex >= 0 ? select.options[select.selectedIndex].text : 'Not selected';
                                        })()}</p>
                                        <p><strong>Doctor:</strong> ${(() => {
                                            const select = document.getElementById('doctor_id');
                                            return select.selectedIndex >= 0 ? select.options[select.selectedIndex].text : 'Not selected';
                                        })()}</p>
                                        <p><strong>Date:</strong> ${document.getElementById('consultation_date').value || 'Not set'}</p>
                                    </div>
                                    <div>
                                        <p><strong>Chief Complaint:</strong> ${document.getElementById('chief_complaint').value || 'Not specified'}</p>
                                        <p><strong>Blood Pressure:</strong> ${document.getElementById('blood_pressure').value || 'Not recorded'}</p>
                                        <p><strong>Heart Rate:</strong> ${document.getElementById('heart_rate').value || 'Not recorded'}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-end space-x-3">
                            <button onclick="closePreviewModal()" 
                                    class="px-6 py-2 bg-gray-600 text-white rounded-lg font-semibold hover:bg-gray-700 transition-colors">
                                Close
                            </button>
                            <button onclick="submitConsultation()" 
                                    class="px-6 py-2 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition-colors">
                                Start Consultation
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Add modal to body
        document.body.insertAdjacentHTML('beforeend', modalHtml);
        
        // Show modal with animation
        const modal = document.getElementById(modalId);
        const modalContent = modal.querySelector('.bg-white');
        modalContent.style.transform = 'scale(0.9)';
        setTimeout(() => {
            modalContent.style.transform = 'scale(1)';
        }, 10);
    }
    
    // Submit Consultation Function
    function submitConsultation() {
        document.getElementById('consultationForm').submit();
    }
    
    // Close Preview Modal Function
    function closePreviewModal() {
        const modal = document.getElementById('previewModal');
        if (modal) {
            const modalContent = modal.querySelector('.bg-white');
            modalContent.style.transform = 'scale(0.9)';
            setTimeout(() => {
                modal.remove();
            }, 200);
        }
    }
    
    // Fetch patient data via AJAX
    function fetchPatientData(patientId) {
        showLoadingState();

        fetch(`/staff/consultations/fetch-patient-data?patient_id=${patientId}`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.patient) {
                populatePatientData(data.patient);
            } else {
                console.error('Error fetching patient data:', data.message || 'Patient not found');
                showMessage('Error fetching patient data: ' + (data.message || 'Patient not found'), 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('Error fetching patient data. Please try again.', 'error');
        })
        .finally(() => {
            hideLoadingState();
        });
    }
    
    // Populate form fields with patient data
    function populatePatientData(patient) {
        if (patient.past_medical_history) {
            document.getElementById('past_medical_history').value = patient.past_medical_history;
        }
        if (patient.medications) {
            document.getElementById('medications').value = patient.medications;
        }
        if (patient.allergies) {
            document.getElementById('allergies').value = patient.allergies;
        }
        
        showMessage('Patient data loaded successfully!', 'success');
    }
    
    // Clear patient data
    function clearPatientData() {
        document.getElementById('past_medical_history').value = '';
        document.getElementById('medications').value = '';
        document.getElementById('allergies').value = '';
    }
    
    // Show loading state
    function showLoadingState() {
        const submitBtn = document.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Loading...</span>';
        submitBtn.disabled = true;
    }
    
    // Hide loading state
    function hideLoadingState() {
        const submitBtn = document.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<i class="fas fa-stethoscope"></i><span>Start Consultation</span>';
        submitBtn.disabled = false;
    }
    
    // Show message modal
    function showMessage(message, type) {
        const modalId = 'messageModal';
        
        // Remove existing modal if any
        const existingModal = document.getElementById(modalId);
        if (existingModal) {
            existingModal.remove();
        }
        
        // Create modal HTML
        const modalHtml = `
            <div id="${modalId}" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all">
                    <div class="px-8 py-6">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-${type === 'success' ? 'green' : 'red'}-500 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} text-white text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900">${type === 'success' ? 'Success' : 'Error'}</h3>
                                    <p class="text-gray-600 text-sm">${type === 'success' ? 'Operation completed' : 'Something went wrong'}</p>
                                </div>
                            </div>
                            <button onclick="closeMessageModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>
                        
                        <div class="mb-6">
                            <div class="bg-${type === 'success' ? 'green' : 'red'}-50 border-l-4 border-${type === 'success' ? 'green' : 'red'}-400 p-4 rounded-r-lg">
                                <p class="text-${type === 'success' ? 'green' : 'red'}-700">${message}</p>
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <button onclick="closeMessageModal()" 
                                    class="px-6 py-2 bg-gray-600 text-white rounded-lg font-semibold hover:bg-gray-700 transition-colors">
                                OK
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Add modal to body
        document.body.insertAdjacentHTML('beforeend', modalHtml);
        
        // Show modal with animation
        const modal = document.getElementById(modalId);
        const modalContent = modal.querySelector('.bg-white');
        modalContent.style.transform = 'scale(0.9)';
        setTimeout(() => {
            modalContent.style.transform = 'scale(1)';
        }, 10);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            closeMessageModal();
        }, 5000);
    }
    
    // Close message modal
    function closeMessageModal() {
        const modal = document.getElementById('messageModal');
        if (modal) {
            const modalContent = modal.querySelector('.bg-white');
            modalContent.style.transform = 'scale(0.9)';
            setTimeout(() => {
                modal.remove();
            }, 200);
        }
    }
    
    // Make functions globally available
    window.closeMessageModal = closeMessageModal;
    window.closePreviewModal = closePreviewModal;
    window.submitConsultation = submitConsultation;
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.staff', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\staff\consultations\create.blade.php ENDPATH**/ ?>