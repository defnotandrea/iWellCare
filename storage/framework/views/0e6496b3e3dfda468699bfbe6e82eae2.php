

<?php $__env->startSection('title', 'Prescription Details - iWellCare'); ?>
<?php $__env->startSection('page-title', 'Prescription Details'); ?>
<?php $__env->startSection('page-subtitle', 'View detailed prescription information'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="<?php echo e(route('patient.prescriptions.index')); ?>" class="btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Back to Prescriptions
        </a>
    </div>

    <!-- Prescription Details Card -->
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-xl font-bold text-gray-900">Prescription Information</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Medication Information -->
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-pills text-purple-600 text-xl"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900"><?php echo e($prescription->medication_name); ?></h4>
                            <p class="text-gray-600">Prescribed by Dr. <?php echo e($prescription->doctor->first_name); ?> <?php echo e($prescription->doctor->last_name); ?></p>
                        </div>
                    </div>
                    
                    <div class="bg-purple-50 rounded-lg p-4">
                        <h5 class="font-medium text-gray-900 mb-2">Prescription Details</h5>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Dosage:</span>
                                <span class="font-medium"><?php echo e($prescription->dosage); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Frequency:</span>
                                <span class="font-medium"><?php echo e($prescription->frequency); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Duration:</span>
                                <span class="font-medium"><?php echo e($prescription->duration); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status:</span>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    <?php if($prescription->status === 'active'): ?> bg-green-100 text-green-700
                                    <?php elseif($prescription->status === 'completed'): ?> bg-blue-100 text-blue-700
                                    <?php else: ?> bg-gray-100 text-gray-700 <?php endif; ?>">
                                    <?php echo e(ucfirst($prescription->status)); ?>

                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Prescribed Date:</span>
                                <span class="font-medium"><?php echo e(\Carbon\Carbon::parse($prescription->created_at)->format('M d, Y')); ?></span>
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

    <!-- Instructions -->
    <?php if($prescription->instructions): ?>
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-xl font-bold text-gray-900">Instructions</h3>
        </div>
        <div class="p-6">
            <div class="bg-blue-50 rounded-lg p-4">
                <p class="text-gray-700"><?php echo e($prescription->instructions); ?></p>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Related Consultation -->
    <?php if($prescription->consultation): ?>
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-xl font-bold text-gray-900">Related Consultation</h3>
        </div>
        <div class="p-6">
            <div class="bg-gray-50 rounded-lg p-4">
                <h5 class="font-medium text-gray-900 mb-2">Consultation Details</h5>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Date:</span>
                        <span class="font-medium"><?php echo e(\Carbon\Carbon::parse($prescription->consultation->consultation_date)->format('M d, Y')); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Doctor:</span>
                        <span class="font-medium">Dr. <?php echo e($prescription->consultation->doctor->first_name); ?> <?php echo e($prescription->consultation->doctor->last_name); ?></span>
                    </div>
                    <?php if($prescription->consultation->diagnosis): ?>
                    <div class="mt-3 pt-3 border-t border-gray-200">
                        <span class="text-gray-600 text-sm">Diagnosis:</span>
                        <p class="text-gray-700 text-sm mt-1"><?php echo e($prescription->consultation->diagnosis); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Actions -->
    <div class="flex justify-end space-x-4">
        <a href="<?php echo e(route('patient.consultations.index')); ?>" class="btn-secondary">
            <i class="fas fa-stethoscope mr-2"></i>View Consultations
        </a>
        <a href="<?php echo e(route('patient.appointments.create')); ?>" class="btn-primary">
            <i class="fas fa-plus mr-2"></i>Book Follow-up
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.patient', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\patient\prescriptions\show.blade.php ENDPATH**/ ?>