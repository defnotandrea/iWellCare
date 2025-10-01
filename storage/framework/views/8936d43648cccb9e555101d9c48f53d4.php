<?php $__env->startSection('title', 'Reports - iWellCare'); ?>
<?php $__env->startSection('page-title', 'Medical Reports'); ?>
<?php $__env->startSection('page-subtitle', 'Print lab results and medical records'); ?>
<?php $__env->startSection('content'); ?>

<!-- Quick Action Buttons -->
<div class="card p-6 mb-6">
    <div class="flex justify-between items-center mb-4">
        <div>
            <h3 class="font-semibold text-lg">Generate Reports</h3>
            <p class="text-gray-600">Access detailed analytics and export reports</p>
        </div>
        <div class="flex space-x-3">
            <a href="<?php echo e(route('staff.reports.inventory')); ?>" class="btn btn-primary">
                <i class="fas fa-boxes mr-2"></i>Inventory Report
            </a>
            <a href="<?php echo e(route('staff.reports.exportPdf')); ?>" class="btn btn-secondary" target="_blank">
                <i class="fas fa-file-pdf mr-1"></i>Export Medical Records
            </a>
        </div>
    </div>
</div>
<div class="card p-6 mb-6">
    <div class="flex justify-between items-center mb-4">
        <div class="font-semibold text-lg">Medical Records</div>
        <a href="<?php echo e(route('staff.reports.exportPdf')); ?>" class="btn btn-secondary" target="_blank"><i class="fas fa-file-pdf mr-1"></i>Export to PDF</a>
    </div>
    <?php if(session('success')): ?>
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <table class="min-w-full text-sm mb-6">
        <thead>
            <tr class="text-left text-gray-500">
                <th class="py-2 px-4">Patient</th>
                <th class="py-2 px-4">Type</th>
                <th class="py-2 px-4">Date</th>
                <th class="py-2 px-4">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $medicalRecords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="py-2 px-4"><?php echo e($record->patient->first_name ?? '-'); ?> <?php echo e($record->patient->last_name ?? ''); ?></td>
                    <td class="py-2 px-4"><?php echo e(ucfirst($record->record_type)); ?></td>
                    <td class="py-2 px-4"><?php echo e($record->record_date ? $record->record_date->format('Y-m-d') : '-'); ?></td>
                    <td class="py-2 px-4">
                        <a href="#" class="btn btn-primary btn-sm">Print</a>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="4" class="py-4 text-center text-gray-400">No medical records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div class="mt-4"><?php echo e($medicalRecords->links()); ?></div>
</div>
<div class="card p-6 mb-6">
    <div class="font-semibold text-lg mb-4">Consultations</div>
    <table class="min-w-full text-sm">
        <thead>
            <tr class="text-left text-gray-500">
                <th class="py-2 px-4">Patient</th>
                <th class="py-2 px-4">Doctor</th>
                <th class="py-2 px-4">Date</th>
                <th class="py-2 px-4">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $consultations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $consultation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="py-2 px-4"><?php echo e($consultation->patient->first_name ?? '-'); ?> <?php echo e($consultation->patient->last_name ?? ''); ?></td>
                    <td class="py-2 px-4"><?php echo e($consultation->doctor->first_name ?? '-'); ?> <?php echo e($consultation->doctor->last_name ?? ''); ?></td>
                    <td class="py-2 px-4"><?php echo e($consultation->consultation_date ? $consultation->consultation_date->format('Y-m-d') : '-'); ?></td>
                    <td class="py-2 px-4">
                        <a href="#" class="btn btn-primary btn-sm">Print</a>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="4" class="py-4 text-center text-gray-400">No consultations found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div class="mt-4"><?php echo e($consultations->links()); ?></div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.staff', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\staff\reports\index.blade.php ENDPATH**/ ?>