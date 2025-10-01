

<?php $__env->startSection('title', 'Consultation Details - iWellCare'); ?>
<?php $__env->startSection('page-title', 'Consultation Details'); ?>
<?php $__env->startSection('page-subtitle', 'View complete consultation information'); ?>

<?php $__env->startSection('content'); ?>
<div class="consultation-content">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Consultation Details</h2>
            <p class="text-gray-600">Complete consultation information and medical records</p>
        </div>
        <div class="flex gap-3">
            <a href="<?php echo e(route('staff.consultations.edit', $consultation)); ?>" class="btn btn-secondary">
                <i class="fas fa-edit mr-2"></i>Edit Consultation
            </a>
            <button onclick="window.print()" class="btn btn-outline-secondary">
                <i class="fas fa-print mr-2"></i>Print
            </button>
            <a href="<?php echo e(route('staff.consultations.index')); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left mr-2"></i>Back to Consultations
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column - Patient & Consultation Info -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Patient Information Card -->
            <div class="card p-6">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-blue-600 text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900"><?php echo e($consultation->patient->user->first_name ?? 'N/A'); ?> <?php echo e($consultation->patient->user->last_name ?? ''); ?></h3>
                        <p class="text-gray-500">Patient ID: <?php echo e($consultation->patient->id); ?></p>
                        <p class="text-sm text-gray-600"><?php echo e($consultation->patient->user->email ?? 'No email'); ?></p>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600 font-medium">Date of Birth</span>
                        <span class="text-gray-800"><?php echo e($consultation->patient->date_of_birth ? $consultation->patient->date_of_birth->format('M d, Y') : 'N/A'); ?></span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600 font-medium">Age</span>
                        <span class="text-gray-800"><?php echo e($consultation->patient->age ?? 'N/A'); ?> years</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600 font-medium">Gender</span>
                        <span class="text-gray-800"><?php echo e(ucfirst($consultation->patient->gender ?? 'N/A')); ?></span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-600 font-medium">Phone</span>
                        <span class="text-gray-800"><?php echo e($consultation->patient->contact ?? 'N/A'); ?></span>
                    </div>
                </div>
            </div>

            <!-- Consultation Summary Card -->
            <div class="card p-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">Consultation Summary</h4>
                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600 font-medium">Consultation Date</span>
                        <span class="text-gray-800"><?php echo e($consultation->consultation_date->format('M d, Y')); ?></span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600 font-medium">Doctor</span>
                        <span class="text-gray-800"><?php echo e($consultation->doctor->first_name ?? 'N/A'); ?> <?php echo e($consultation->doctor->last_name ?? ''); ?></span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-600 font-medium">Status</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            <?php if($consultation->status === 'completed'): ?> bg-green-100 text-green-800
                            <?php elseif($consultation->status === 'in_progress'): ?> bg-yellow-100 text-yellow-800
                            <?php else: ?> bg-gray-100 text-gray-800 <?php endif; ?>">
                            <?php echo e(ucfirst(str_replace('_', ' ', $consultation->status))); ?>

                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Medical Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Chief Complaint & History -->
            <div class="card p-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">Chief Complaint & History</h4>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Chief Complaint</label>
                        <p class="text-gray-800 bg-gray-50 p-3 rounded-lg"><?php echo e($consultation->chief_complaint ?? 'Not specified'); ?></p>
                    </div>

                    <?php if($consultation->present_illness): ?>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Present Illness</label>
                        <p class="text-gray-800 bg-gray-50 p-3 rounded-lg"><?php echo e($consultation->present_illness); ?></p>
                    </div>
                    <?php endif; ?>

                    <?php if($consultation->past_medical_history): ?>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Past Medical History</label>
                        <p class="text-gray-800 bg-gray-50 p-3 rounded-lg"><?php echo e($consultation->past_medical_history); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Vital Signs & Measurements -->
            <?php if($consultation->clinical_measurements || $consultation->vital_signs): ?>
            <div class="card p-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">Vital Signs & Clinical Measurements</h4>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <?php
                        $measurements = $consultation->clinical_measurements ? json_decode($consultation->clinical_measurements, true) : [];
                        $vitals = $consultation->vital_signs ? json_decode($consultation->vital_signs, true) : [];
                        $allVitals = array_merge($measurements, $vitals);
                    ?>

                    <?php if(isset($allVitals['blood_pressure'])): ?>
                    <div class="text-center p-3 bg-red-50 rounded-lg">
                        <div class="text-2xl font-bold text-red-600"><?php echo e($allVitals['blood_pressure']); ?></div>
                        <div class="text-sm text-red-800">Blood Pressure</div>
                    </div>
                    <?php endif; ?>

                    <?php if(isset($allVitals['heart_rate'])): ?>
                    <div class="text-center p-3 bg-blue-50 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600"><?php echo e($allVitals['heart_rate']); ?></div>
                        <div class="text-sm text-blue-800">Heart Rate</div>
                    </div>
                    <?php endif; ?>

                    <?php if(isset($allVitals['temperature'])): ?>
                    <div class="text-center p-3 bg-green-50 rounded-lg">
                        <div class="text-2xl font-bold text-green-600"><?php echo e($allVitals['temperature']); ?>°C</div>
                        <div class="text-sm text-green-800">Temperature</div>
                    </div>
                    <?php endif; ?>

                    <?php if(isset($allVitals['respiratory_rate'])): ?>
                    <div class="text-center p-3 bg-purple-50 rounded-lg">
                        <div class="text-2xl font-bold text-purple-600"><?php echo e($allVitals['respiratory_rate']); ?></div>
                        <div class="text-sm text-purple-800">Respiratory Rate</div>
                    </div>
                    <?php endif; ?>

                    <?php if(isset($allVitals['height'])): ?>
                    <div class="text-center p-3 bg-yellow-50 rounded-lg">
                        <div class="text-2xl font-bold text-yellow-600"><?php echo e($allVitals['height']); ?> cm</div>
                        <div class="text-sm text-yellow-800">Height</div>
                    </div>
                    <?php endif; ?>

                    <?php if(isset($allVitals['weight'])): ?>
                    <div class="text-center p-3 bg-indigo-50 rounded-lg">
                        <div class="text-2xl font-bold text-indigo-600"><?php echo e($allVitals['weight']); ?> kg</div>
                        <div class="text-sm text-indigo-800">Weight</div>
                    </div>
                    <?php endif; ?>

                    <?php if(isset($allVitals['bmi'])): ?>
                    <div class="text-center p-3 bg-pink-50 rounded-lg">
                        <div class="text-2xl font-bold text-pink-600"><?php echo e($allVitals['bmi']); ?></div>
                        <div class="text-sm text-pink-800">BMI</div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Diagnosis & Treatment -->
            <?php if($consultation->diagnosis || $consultation->treatment_plan): ?>
            <div class="card p-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">Diagnosis & Treatment</h4>
                <div class="space-y-4">
                    <?php if($consultation->diagnosis): ?>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Diagnosis</label>
                        <p class="text-gray-800 bg-gray-50 p-3 rounded-lg"><?php echo e($consultation->diagnosis); ?></p>
                    </div>
                    <?php endif; ?>

                    <?php if($consultation->treatment_plan): ?>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Treatment Plan</label>
                        <p class="text-gray-800 bg-gray-50 p-3 rounded-lg"><?php echo e($consultation->treatment_plan); ?></p>
                    </div>
                    <?php endif; ?>

                    <?php if($consultation->prescription): ?>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Prescription</label>
                        <p class="text-gray-800 bg-gray-50 p-3 rounded-lg"><?php echo e($consultation->prescription); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Physical Examination -->
            <?php if($consultation->physical_examination): ?>
            <div class="card p-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">Physical Examination</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?php
                        $exam = json_decode($consultation->physical_examination, true);
                    ?>

                    <?php if(isset($exam['general_appearance'])): ?>
                    <div class="p-3 bg-blue-50 rounded-lg">
                        <div class="font-medium text-blue-800 mb-1">General Appearance</div>
                        <div class="text-blue-700 text-sm"><?php echo e($exam['general_appearance']); ?></div>
                    </div>
                    <?php endif; ?>

                    <?php if(isset($exam['head_neck'])): ?>
                    <div class="p-3 bg-green-50 rounded-lg">
                        <div class="font-medium text-green-800 mb-1">Head & Neck</div>
                        <div class="text-green-700 text-sm"><?php echo e($exam['head_neck']); ?></div>
                    </div>
                    <?php endif; ?>

                    <?php if(isset($exam['chest_lungs'])): ?>
                    <div class="p-3 bg-purple-50 rounded-lg">
                        <div class="font-medium text-purple-800 mb-1">Chest & Lungs</div>
                        <div class="text-purple-700 text-sm"><?php echo e($exam['chest_lungs']); ?></div>
                    </div>
                    <?php endif; ?>

                    <?php if(isset($exam['cardiovascular'])): ?>
                    <div class="p-3 bg-red-50 rounded-lg">
                        <div class="font-medium text-red-800 mb-1">Cardiovascular</div>
                        <div class="text-red-700 text-sm"><?php echo e($exam['cardiovascular']); ?></div>
                    </div>
                    <?php endif; ?>

                    <?php if(isset($exam['abdomen'])): ?>
                    <div class="p-3 bg-yellow-50 rounded-lg">
                        <div class="font-medium text-yellow-800 mb-1">Abdomen</div>
                        <div class="text-yellow-700 text-sm"><?php echo e($exam['abdomen']); ?></div>
                    </div>
                    <?php endif; ?>

                    <?php if(isset($exam['extremities'])): ?>
                    <div class="p-3 bg-indigo-50 rounded-lg">
                        <div class="font-medium text-indigo-800 mb-1">Extremities</div>
                        <div class="text-indigo-700 text-sm"><?php echo e($exam['extremities']); ?></div>
                    </div>
                    <?php endif; ?>

                    <?php if(isset($exam['neurological'])): ?>
                    <div class="p-3 bg-pink-50 rounded-lg">
                        <div class="font-medium text-pink-800 mb-1">Neurological</div>
                        <div class="text-pink-700 text-sm"><?php echo e($exam['neurological']); ?></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Notes -->
            <?php if($consultation->notes): ?>
            <div class="card p-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">Additional Notes</h4>
                <p class="text-gray-800 bg-gray-50 p-3 rounded-lg"><?php echo e($consultation->notes); ?></p>
            </div>
            <?php endif; ?>

            <!-- Allergies & Medications -->
            <?php if($consultation->allergies || $consultation->medications): ?>
            <div class="card p-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">Allergies & Current Medications</h4>
                <div class="space-y-4">
                    <?php if($consultation->allergies): ?>
                    <div class="p-3 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fas fa-exclamation-triangle text-red-600"></i>
                            <span class="font-semibold text-red-800">Allergies</span>
                        </div>
                        <p class="text-red-700"><?php echo e($consultation->allergies); ?></p>
                    </div>
                    <?php endif; ?>

                    <?php if($consultation->medications): ?>
                    <div class="p-3 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fas fa-pills text-blue-600"></i>
                            <span class="font-semibold text-blue-800">Current Medications</span>
                        </div>
                        <p class="text-blue-700"><?php echo e($consultation->medications); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
@media print {
    .btn, button, a[href]:not([href^="#"]) { display: none !important; }
    .card { border: 1px solid #e5e7eb !important; box-shadow: none !important; }
    body { background: white !important; }
    .consultation-content { max-width: none !important; margin: 0 !important; }
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.staff', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\staff\consultations\show.blade.php ENDPATH**/ ?>