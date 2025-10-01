

<?php $__env->startSection('title', 'Consultation Details - iWellCare'); ?>
<?php $__env->startSection('page-title', 'Consultation Details'); ?>
<?php $__env->startSection('page-subtitle', 'View detailed information about your consultation'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="<?php echo e(route('patient.consultations.index')); ?>" class="btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Back to Consultations
        </a>
    </div>

    <!-- Consultation Details Card -->
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-xl font-bold text-gray-900">Consultation Information</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Doctor Information -->
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-md text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900">Dr. <?php echo e($consultation->doctor->first_name); ?> <?php echo e($consultation->doctor->last_name); ?></h4>
                            <p class="text-gray-600"><?php echo e($consultation->doctor->specialization ?? 'General Medicine'); ?></p>
                        </div>
                    </div>
                    
                    <div class="bg-blue-50 rounded-lg p-4">
                        <h5 class="font-medium text-gray-900 mb-2">Consultation Details</h5>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Date:</span>
                                <span class="font-medium"><?php echo e(\Carbon\Carbon::parse($consultation->consultation_date)->format('l, F j, Y')); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Time:</span>
                                <span class="font-medium"><?php echo e(\Carbon\Carbon::parse($consultation->consultation_time)->format('g:i A')); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Duration:</span>
                                <span class="font-medium"><?php echo e($consultation->duration ?? '30'); ?> minutes</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status:</span>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                    Completed
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Patient Information -->
                <div class="space-y-4">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h5 class="font-medium text-gray-900 mb-2">Patient Information</h5>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Name:</span>
                                <span class="font-medium"><?php echo e(auth()->user()->first_name); ?> <?php echo e(auth()->user()->last_name); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Age:</span>
                                <span class="font-medium"><?php echo e(auth()->user()->date_of_birth ? \Carbon\Carbon::parse(auth()->user()->date_of_birth)->age . ' years' : 'N/A'); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Gender:</span>
                                <span class="font-medium capitalize"><?php echo e(auth()->user()->gender ?? 'N/A'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Medical Information -->
    <?php if($consultation->symptoms || $consultation->diagnosis || $consultation->treatment_plan): ?>
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-xl font-bold text-gray-900">Medical Information</h3>
        </div>
        <div class="p-6 space-y-6">
            <?php if($consultation->symptoms): ?>
            <div>
                <h4 class="font-semibold text-gray-900 mb-3">Symptoms</h4>
                <div class="bg-yellow-50 rounded-lg p-4">
                    <p class="text-gray-700"><?php echo e($consultation->symptoms); ?></p>
                </div>
            </div>
            <?php endif; ?>

            <?php if($consultation->diagnosis): ?>
            <div>
                <h4 class="font-semibold text-gray-900 mb-3">Diagnosis</h4>
                <div class="bg-red-50 rounded-lg p-4">
                    <p class="text-gray-700"><?php echo e($consultation->diagnosis); ?></p>
                </div>
            </div>
            <?php endif; ?>

            <?php if($consultation->treatment_plan): ?>
            <div>
                <h4 class="font-semibold text-gray-900 mb-3">Treatment Plan</h4>
                <div class="bg-green-50 rounded-lg p-4">
                    <p class="text-gray-700"><?php echo e($consultation->treatment_plan); ?></p>
                </div>
            </div>
            <?php endif; ?>

            <?php if($consultation->notes): ?>
            <div>
                <h4 class="font-semibold text-gray-900 mb-3">Additional Notes</h4>
                <div class="bg-blue-50 rounded-lg p-4">
                    <p class="text-gray-700"><?php echo e($consultation->notes); ?></p>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Prescriptions -->
    <?php if($consultation->prescriptions && $consultation->prescriptions->count() > 0): ?>
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-xl font-bold text-gray-900">Prescriptions</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <?php $__currentLoopData = $consultation->prescriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prescription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="font-semibold text-gray-900"><?php echo e($prescription->medication_name); ?></h4>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-700">
                            <?php echo e(ucfirst($prescription->status)); ?>

                        </span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div>
                            <span class="text-gray-600">Dosage:</span>
                            <span class="font-medium ml-1"><?php echo e($prescription->dosage); ?></span>
                        </div>
                        <div>
                            <span class="text-gray-600">Frequency:</span>
                            <span class="font-medium ml-1"><?php echo e($prescription->frequency); ?></span>
                        </div>
                        <div>
                            <span class="text-gray-600">Duration:</span>
                            <span class="font-medium ml-1"><?php echo e($prescription->duration); ?></span>
                        </div>
                    </div>
                    <?php if($prescription->instructions): ?>
                    <div class="mt-3 pt-3 border-t border-gray-200">
                        <span class="text-gray-600 text-sm">Instructions:</span>
                        <p class="text-gray-700 text-sm mt-1"><?php echo e($prescription->instructions); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Actions -->
    <div class="flex justify-end space-x-4">
        <a href="<?php echo e(route('patient.prescriptions.index')); ?>" class="btn-secondary">
            <i class="fas fa-pills mr-2"></i>View All Prescriptions
        </a>
        <a href="<?php echo e(route('patient.appointments.create')); ?>" class="btn-primary">
            <i class="fas fa-plus mr-2"></i>Book Follow-up
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.patient', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\patient\consultations\show.blade.php ENDPATH**/ ?>