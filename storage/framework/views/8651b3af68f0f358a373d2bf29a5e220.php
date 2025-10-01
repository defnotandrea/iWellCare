

<?php $__env->startSection('title', 'Physical Examination - iWellCare'); ?>
<?php $__env->startSection('page-title', 'Physical Examination'); ?>
<?php $__env->startSection('page-subtitle', 'Record physical examination details'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Physical Examination</h1>
        <a href="<?php echo e(route('admin.consultations.show', $consultation)); ?>" class="btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Back to Consultation
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <p class="text-gray-600">Physical examination form for consultation #<?php echo e($consultation->id); ?></p>
        <!-- Placeholder content - implement physical examination form here -->
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\admin\consultations\physical-exam.blade.php ENDPATH**/ ?>