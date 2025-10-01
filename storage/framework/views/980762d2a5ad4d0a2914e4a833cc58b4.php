

<?php $__env->startSection('title', 'Edit Consultation - iWellCare'); ?>
<?php $__env->startSection('page-title', 'Edit Consultation'); ?>
<?php $__env->startSection('page-subtitle', 'Update consultation details'); ?>

<?php $__env->startSection('content'); ?>
<div class="consultation-content">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Edit Consultation</h2>
            <p class="text-gray-600">Update consultation information and details</p>
        </div>
        <div class="flex gap-3">
            <a href="<?php echo e(route('staff.consultations.show', $consultation)); ?>" class="btn btn-secondary">
                <i class="fas fa-eye mr-2"></i>View Consultation
            </a>
            <a href="<?php echo e(route('staff.consultations.index')); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left mr-2"></i>Back to Consultations
            </a>
        </div>
    </div>

    <div class="card p-6 max-w-4xl mx-auto">
        <?php if($errors->any()): ?>
            <div class="bg-red-100 text-red-800 p-4 rounded mb-6">
                <ul class="list-disc list-inside">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('staff.consultations.update', $consultation)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Consultation Information</h3>
                </div>

                <div>
                    <label for="patient_id" class="block text-sm font-medium text-gray-700 mb-2">Patient *</label>
                    <select name="patient_id" id="patient_id" class="form-input w-full" required>
                        <option value="">Select Patient</option>
                        <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($patient->id); ?>" <?php echo e(old('patient_id', $consultation->patient_id) == $patient->id ? 'selected' : ''); ?>>
                                <?php echo e($patient->user->first_name ?? 'N/A'); ?> <?php echo e($patient->user->last_name ?? ''); ?> (<?php echo e($patient->user->email ?? 'No email'); ?>)
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div>
                    <label for="doctor_id" class="block text-sm font-medium text-gray-700 mb-2">Doctor *</label>
                    <select name="doctor_id" id="doctor_id" class="form-input w-full" required>
                        <option value="">Select Doctor</option>
                        <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($doctor->user->id); ?>" <?php echo e(old('doctor_id', $consultation->doctor_id) == $doctor->user->id ? 'selected' : ''); ?>>
                                Dr. <?php echo e($doctor->user->first_name ?? 'N/A'); ?> <?php echo e($doctor->user->last_name ?? ''); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div>
                    <label for="consultation_date" class="block text-sm font-medium text-gray-700 mb-2">Consultation Date *</label>
                    <input type="date" name="consultation_date" id="consultation_date"
                           value="<?php echo e(old('consultation_date', $consultation->consultation_date ? $consultation->consultation_date->format('Y-m-d') : '')); ?>"
                           class="form-input w-full" required>
                </div>

                <div>
                    <label for="consultation_time" class="block text-sm font-medium text-gray-700 mb-2">Consultation Time</label>
                    <input type="time" name="consultation_time" id="consultation_time"
                           value="<?php echo e(old('consultation_time', $consultation->consultation_time ? $consultation->consultation_time->format('H:i') : '')); ?>"
                           class="form-input w-full">
                </div>

                <!-- Medical Information -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 mt-6">Medical Information</h3>
                </div>

                <div class="md:col-span-2">
                    <label for="chief_complaint" class="block text-sm font-medium text-gray-700 mb-2">Chief Complaint *</label>
                    <textarea name="chief_complaint" id="chief_complaint" rows="3"
                              class="form-input w-full" required
                              placeholder="Patient's main complaint or reason for visit"><?php echo e(old('chief_complaint', $consultation->chief_complaint)); ?></textarea>
                </div>

                <div class="md:col-span-2">
                    <label for="present_illness" class="block text-sm font-medium text-gray-700 mb-2">Present Illness</label>
                    <textarea name="present_illness" id="present_illness" rows="4"
                              class="form-input w-full"
                              placeholder="Detailed description of current illness"><?php echo e(old('present_illness', $consultation->present_illness)); ?></textarea>
                </div>

                <div class="md:col-span-2">
                    <label for="past_medical_history" class="block text-sm font-medium text-gray-700 mb-2">Past Medical History</label>
                    <textarea name="past_medical_history" id="past_medical_history" rows="3"
                              class="form-input w-full"
                              placeholder="Previous medical conditions, surgeries, etc."><?php echo e(old('past_medical_history', $consultation->past_medical_history)); ?></textarea>
                </div>

                <div class="md:col-span-2">
                    <label for="medications" class="block text-sm font-medium text-gray-700 mb-2">Current Medications</label>
                    <textarea name="medications" id="medications" rows="3"
                              class="form-input w-full"
                              placeholder="List current medications and dosages"><?php echo e(old('medications', $consultation->medications)); ?></textarea>
                </div>

                <div class="md:col-span-2">
                    <label for="allergies" class="block text-sm font-medium text-gray-700 mb-2">Allergies</label>
                    <textarea name="allergies" id="allergies" rows="2"
                              class="form-input w-full"
                              placeholder="Known allergies"><?php echo e(old('allergies', $consultation->allergies)); ?></textarea>
                </div>

                <!-- Vital Signs -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 mt-6">Initial Vital Signs</h3>
                </div>

                <div>
                    <label for="blood_pressure" class="block text-sm font-medium text-gray-700 mb-2">Blood Pressure</label>
                    <input type="text" name="blood_pressure" id="blood_pressure"
                           value="<?php echo e(old('blood_pressure', $consultation->clinical_measurements ? json_decode($consultation->clinical_measurements, true)['blood_pressure'] ?? '' : '')); ?>"
                           class="form-input w-full" placeholder="e.g., 120/80 mmHg">
                </div>

                <div>
                    <label for="heart_rate" class="block text-sm font-medium text-gray-700 mb-2">Heart Rate</label>
                    <input type="text" name="heart_rate" id="heart_rate"
                           value="<?php echo e(old('heart_rate', $consultation->clinical_measurements ? json_decode($consultation->clinical_measurements, true)['heart_rate'] ?? '' : '')); ?>"
                           class="form-input w-full" placeholder="e.g., 72 bpm">
                </div>

                <div>
                    <label for="temperature" class="block text-sm font-medium text-gray-700 mb-2">Temperature</label>
                    <input type="text" name="temperature" id="temperature"
                           value="<?php echo e(old('temperature', $consultation->clinical_measurements ? json_decode($consultation->clinical_measurements, true)['temperature'] ?? '' : '')); ?>"
                           class="form-input w-full" placeholder="e.g., 36.5°C">
                </div>

                <div>
                    <label for="respiratory_rate" class="block text-sm font-medium text-gray-700 mb-2">Respiratory Rate</label>
                    <input type="text" name="respiratory_rate" id="respiratory_rate"
                           value="<?php echo e(old('respiratory_rate', $consultation->clinical_measurements ? json_decode($consultation->clinical_measurements, true)['respiratory_rate'] ?? '' : '')); ?>"
                           class="form-input w-full" placeholder="e.g., 16 breaths/min">
                </div>

                <div>
                    <label for="height" class="block text-sm font-medium text-gray-700 mb-2">Height</label>
                    <input type="text" name="height" id="height"
                           value="<?php echo e(old('height', $consultation->clinical_measurements ? json_decode($consultation->clinical_measurements, true)['height'] ?? '' : '')); ?>"
                           class="form-input w-full" placeholder="e.g., 170 cm">
                </div>

                <div>
                    <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">Weight</label>
                    <input type="text" name="weight" id="weight"
                           value="<?php echo e(old('weight', $consultation->clinical_measurements ? json_decode($consultation->clinical_measurements, true)['weight'] ?? '' : '')); ?>"
                           class="form-input w-full" placeholder="e.g., 70 kg">
                </div>

                <div>
                    <label for="bmi" class="block text-sm font-medium text-gray-700 mb-2">BMI</label>
                    <input type="text" name="bmi" id="bmi"
                           value="<?php echo e(old('bmi', $consultation->clinical_measurements ? json_decode($consultation->clinical_measurements, true)['bmi'] ?? '' : '')); ?>"
                           class="form-input w-full" placeholder="e.g., 24.2">
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" id="status" class="form-input w-full">
                        <option value="in_progress" <?php echo e(old('status', $consultation->status) === 'in_progress' ? 'selected' : ''); ?>>In Progress</option>
                        <option value="completed" <?php echo e(old('status', $consultation->status) === 'completed' ? 'selected' : ''); ?>>Completed</option>
                        <option value="cancelled" <?php echo e(old('status', $consultation->status) === 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-gray-200">
                <a href="<?php echo e(route('staff.consultations.show', $consultation)); ?>" class="btn btn-secondary">
                    <i class="fas fa-times mr-2"></i>Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>Update Consultation
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.staff', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\staff\consultations\edit.blade.php ENDPATH**/ ?>