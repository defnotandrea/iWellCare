

<?php $__env->startSection('title', 'My Invoices - iWellCare'); ?>
<?php $__env->startSection('page-title', 'My Invoices'); ?>
<?php $__env->startSection('page-subtitle', 'View your billing history and payment status'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="card p-6" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Invoices</p>
                    <p class="text-white text-3xl font-bold"><?php echo e($invoices->count()); ?></p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-receipt text-white text-xl"></i>
                </div>
            </div>
        </div>

        <div class="card p-6" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Unpaid</p>
                    <p class="text-white text-3xl font-bold"><?php echo e($invoices->where('status', 'unpaid')->count()); ?></p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-exclamation-circle text-white text-xl"></i>
                </div>
            </div>
        </div>

        <div class="card p-6" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Amount</p>
                    <p class="text-white text-3xl font-bold">₱<?php echo e(number_format($invoices->sum('amount'), 2)); ?></p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-white text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Invoices List -->
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-xl font-bold text-gray-900">Invoice History</h3>
        </div>
        <div class="p-6">
            <?php if($invoices->count() > 0): ?>
                <div class="space-y-4">
                    <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-receipt text-orange-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">Invoice #<?php echo e($invoice->invoice_number); ?></h4>
                                    <p class="text-sm text-gray-600"><?php echo e($invoice->description); ?></p>
                                    <p class="text-sm text-gray-600"><?php echo e(\Carbon\Carbon::parse($invoice->created_at)->format('M d, Y')); ?></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-gray-900">₱<?php echo e(number_format($invoice->amount, 2)); ?></p>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                        <?php if($invoice->status === 'paid'): ?> bg-green-100 text-green-700
                                        <?php elseif($invoice->status === 'unpaid'): ?> bg-red-100 text-red-700
                                        <?php else: ?> bg-yellow-100 text-yellow-700 <?php endif; ?>">
                                        <?php echo e(ucfirst($invoice->status)); ?>

                                    </span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <a href="<?php echo e(route('patient.invoice.show', $invoice)); ?>" class="btn-primary text-sm">
                                        <i class="fas fa-eye mr-2"></i>View Details
                                    </a>
                                    <?php if($invoice->status === 'unpaid'): ?>
                                    <a href="<?php echo e(route('patient.invoice.download', $invoice)); ?>" class="btn-secondary text-sm">
                                        <i class="fas fa-download mr-2"></i>Download
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <?php if($invoice->appointment): ?>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h5 class="font-medium text-gray-900 mb-2">Related Appointment</h5>
                            <p class="text-gray-700">Dr. <?php echo e($invoice->appointment->doctor->first_name); ?> <?php echo e($invoice->appointment->doctor->last_name); ?> - <?php echo e(\Carbon\Carbon::parse($invoice->appointment->appointment_date)->format('M d, Y')); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                
                <!-- Pagination -->
                <?php if($invoices->hasPages()): ?>
                <div class="mt-6">
                    <?php echo e($invoices->links()); ?>

                </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-receipt text-gray-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Invoices Found</h3>
                    <p class="text-gray-600 mb-6">Your invoices will appear here after consultations and services.</p>
                    <a href="<?php echo e(route('patient.appointments.create')); ?>" class="btn-primary">
                        <i class="fas fa-plus mr-2"></i>Book Appointment
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.patient', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\patient\invoice\index.blade.php ENDPATH**/ ?>