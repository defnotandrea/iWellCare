

<?php $__env->startSection('title', 'Medical Records - iWellCare'); ?>
<?php $__env->startSection('page-title', 'Medical Records'); ?>
<?php $__env->startSection('page-subtitle', 'View your lab results and medical history'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="card p-6" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Records</p>
                    <p class="text-white text-3xl font-bold"><?php echo e($medicalRecords->count()); ?></p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-file-medical text-white text-xl"></i>
                </div>
            </div>
        </div>

        <div class="card p-6" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Lab Results</p>
                    <p class="text-white text-3xl font-bold"><?php echo e($medicalRecords->where('type', 'lab_result')->count()); ?></p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-flask text-white text-xl"></i>
                </div>
            </div>
        </div>

        <div class="card p-6" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">This Year</p>
                    <p class="text-white text-3xl font-bold"><?php echo e($medicalRecords->where('created_at', '>=', now()->startOfYear())->count()); ?></p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-calendar text-white text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Medical Records List -->
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-xl font-bold text-gray-900">Medical Records</h3>
        </div>
        <div class="p-6">
            <?php if($medicalRecords->count() > 0): ?>
                <div class="space-y-4">
                    <?php $__currentLoopData = $medicalRecords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-file-medical text-green-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900"><?php echo e($record->title); ?></h4>
                                    <p class="text-sm text-gray-600"><?php echo e(ucfirst($record->type)); ?> • <?php echo e(\Carbon\Carbon::parse($record->created_at)->format('M d, Y')); ?></p>
                                    <p class="text-sm text-gray-600">Recorded by Dr. <?php echo e($record->doctor->first_name); ?> <?php echo e($record->doctor->last_name); ?></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="<?php echo e(route('patient.medical-records.show', $record)); ?>" class="btn-primary text-sm">
                                    <i class="fas fa-eye mr-2"></i>View Details
                                </a>
                            </div>
                        </div>
                        
                        <?php if($record->description): ?>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-700"><?php echo e(Str::limit($record->description, 200)); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                
                <!-- Pagination -->
                <?php if($medicalRecords->hasPages()): ?>
                <div class="mt-6">
                    <?php echo e($medicalRecords->links()); ?>

                </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-file-medical text-gray-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Medical Records Found</h3>
                    <p class="text-gray-600 mb-6">Your medical records will appear here after consultations and lab tests.</p>
                    <a href="<?php echo e(route('patient.appointments.create')); ?>" class="btn-primary">
                        <i class="fas fa-plus mr-2"></i>Book Appointment
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.patient', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\patient\medical-records\index.blade.php ENDPATH**/ ?>