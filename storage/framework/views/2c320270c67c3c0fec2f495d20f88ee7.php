

<?php $__env->startSection('title', 'My Consultations - iWellCare'); ?>
<?php $__env->startSection('page-title', 'My Consultations'); ?>
<?php $__env->startSection('page-subtitle', 'View your consultation history and medical records'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="card p-6" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Consultations</p>
                    <p class="text-white text-3xl font-bold"><?php echo e($consultations->count()); ?></p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-stethoscope text-white text-xl"></i>
                </div>
            </div>
        </div>

        <div class="card p-6" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">This Month</p>
                    <p class="text-white text-3xl font-bold"><?php echo e($consultations->where('consultation_date', '>=', now()->startOfMonth())->count()); ?></p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-calendar text-white text-xl"></i>
                </div>
            </div>
        </div>

        <div class="card p-6" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Last Consultation</p>
                    <p class="text-white text-lg font-bold"><?php echo e($consultations->first() ? \Carbon\Carbon::parse($consultations->first()->consultation_date)->format('M d, Y') : 'None'); ?></p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clock text-white text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Consultations List -->
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-xl font-bold text-gray-900">Consultation History</h3>
        </div>
        <div class="p-6">
            <?php if($consultations->count() > 0): ?>
                <div class="space-y-4">
                    <?php $__currentLoopData = $consultations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $consultation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-stethoscope text-blue-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">Dr. <?php echo e($consultation->doctor->first_name); ?> <?php echo e($consultation->doctor->last_name); ?></h4>
                                    <p class="text-sm text-gray-600"><?php echo e(\Carbon\Carbon::parse($consultation->consultation_date)->format('l, F j, Y')); ?> at <?php echo e(\Carbon\Carbon::parse($consultation->consultation_time)->format('g:i A')); ?></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                    Completed
                                </span>
                                <a href="<?php echo e(route('patient.consultations.show', $consultation)); ?>" class="btn-primary text-sm">
                                    <i class="fas fa-eye mr-2"></i>View Details
                                </a>
                            </div>
                        </div>
                        
                        <?php if($consultation->diagnosis): ?>
                        <div class="bg-gray-50 rounded-lg p-4 mb-4">
                            <h5 class="font-medium text-gray-900 mb-2">Diagnosis</h5>
                            <p class="text-gray-700"><?php echo e($consultation->diagnosis); ?></p>
                        </div>
                        <?php endif; ?>
                        
                        <?php if($consultation->treatment_plan): ?>
                        <div class="bg-blue-50 rounded-lg p-4">
                            <h5 class="font-medium text-gray-900 mb-2">Treatment Plan</h5>
                            <p class="text-gray-700"><?php echo e($consultation->treatment_plan); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                
                <!-- Pagination -->
                <?php if($consultations->hasPages()): ?>
                <div class="mt-6">
                    <?php echo e($consultations->links()); ?>

                </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-stethoscope text-gray-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Consultations Found</h3>
                    <p class="text-gray-600 mb-6">You haven't had any consultations yet. Book an appointment to get started.</p>
                    <a href="<?php echo e(route('patient.appointments.create')); ?>" class="btn-primary">
                        <i class="fas fa-plus mr-2"></i>Book Appointment
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.patient', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\patient\consultations\index.blade.php ENDPATH**/ ?>