

<?php $__env->startSection('title', 'My Prescriptions - iWellCare'); ?>
<?php $__env->startSection('page-title', 'My Prescriptions'); ?>
<?php $__env->startSection('page-subtitle', 'View your medication prescriptions and treatment plans'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="card p-6" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Prescriptions</p>
                    <p class="text-white text-3xl font-bold"><?php echo e($prescriptions->count()); ?></p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-pills text-white text-xl"></i>
                </div>
            </div>
        </div>

        <div class="card p-6" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Active Prescriptions</p>
                    <p class="text-white text-3xl font-bold"><?php echo e($prescriptions->where('status', 'active')->count()); ?></p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-white text-xl"></i>
                </div>
            </div>
        </div>

        <div class="card p-6" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Completed</p>
                    <p class="text-white text-3xl font-bold"><?php echo e($prescriptions->where('status', 'completed')->count()); ?></p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-calendar-check text-white text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Prescriptions List -->
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-xl font-bold text-gray-900">Prescription History</h3>
        </div>
        <div class="p-6">
            <?php if($prescriptions->count() > 0): ?>
                <div class="space-y-4">
                    <?php $__currentLoopData = $prescriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prescription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-pills text-purple-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900"><?php echo e($prescription->medication_name); ?></h4>
                                    <p class="text-sm text-gray-600">Prescribed by Dr. <?php echo e($prescription->doctor->first_name); ?> <?php echo e($prescription->doctor->last_name); ?></p>
                                    <p class="text-sm text-gray-600"><?php echo e(\Carbon\Carbon::parse($prescription->created_at)->format('M d, Y')); ?></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                    <?php if($prescription->status === 'active'): ?> bg-green-100 text-green-700
                                    <?php elseif($prescription->status === 'completed'): ?> bg-blue-100 text-blue-700
                                    <?php else: ?> bg-gray-100 text-gray-700 <?php endif; ?>">
                                    <?php echo e(ucfirst($prescription->status)); ?>

                                </span>
                                <a href="<?php echo e(route('patient.prescriptions.show', $prescription)); ?>" class="btn-primary text-sm">
                                    <i class="fas fa-eye mr-2"></i>View Details
                                </a>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div class="bg-gray-50 rounded-lg p-3">
                                <span class="text-sm text-gray-600">Dosage</span>
                                <p class="font-medium text-gray-900"><?php echo e($prescription->dosage); ?></p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <span class="text-sm text-gray-600">Frequency</span>
                                <p class="font-medium text-gray-900"><?php echo e($prescription->frequency); ?></p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <span class="text-sm text-gray-600">Duration</span>
                                <p class="font-medium text-gray-900"><?php echo e($prescription->duration); ?></p>
                            </div>
                        </div>
                        
                        <?php if($prescription->instructions): ?>
                        <div class="bg-blue-50 rounded-lg p-4">
                            <h5 class="font-medium text-gray-900 mb-2">Instructions</h5>
                            <p class="text-gray-700 text-sm"><?php echo e($prescription->instructions); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                
                <!-- Pagination -->
                <?php if($prescriptions->hasPages()): ?>
                <div class="mt-6">
                    <?php echo e($prescriptions->links()); ?>

                </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-pills text-gray-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Prescriptions Found</h3>
                    <p class="text-gray-600 mb-6">You haven't been prescribed any medications yet.</p>
                    <a href="<?php echo e(route('patient.appointments.create')); ?>" class="btn-primary">
                        <i class="fas fa-plus mr-2"></i>Book Appointment
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.patient', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\patient\prescriptions\index.blade.php ENDPATH**/ ?>