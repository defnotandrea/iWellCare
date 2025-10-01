
<?php $__env->startSection('title', 'Appointments - iWellCare'); ?>
<?php $__env->startSection('page-title', 'My Appointments'); ?>
<?php $__env->startSection('page-subtitle', 'Manage your appointments and schedule new ones'); ?>
<?php $__env->startSection('content'); ?>

<div class="space-y-4 lg:space-y-6">
    <!-- Appointment Count -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-4 mb-4 lg:mb-6">
        <div class="card p-3 lg:p-4">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs lg:text-sm font-medium text-gray-600">Total Appointments</p>
                    <p class="text-lg lg:text-2xl font-bold text-gray-900"><?php echo e($appointments->total()); ?></p>
                </div>
                <div class="w-8 lg:w-10 h-8 lg:h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-calendar text-blue-600 text-sm lg:text-base"></i>
                </div>
            </div>
        </div>
        
        <div class="card p-3 lg:p-4">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs lg:text-sm font-medium text-gray-600">Confirmed</p>
                    <p class="text-lg lg:text-2xl font-bold text-green-600"><?php echo e($appointments->where('status', 'confirmed')->count()); ?></p>
                </div>
                <div class="w-8 lg:w-10 h-8 lg:h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-check text-green-600 text-sm lg:text-base"></i>
                </div>
            </div>
        </div>
        
        <div class="card p-3 lg:p-4">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs lg:text-sm font-medium text-gray-600">Pending</p>
                    <p class="text-lg lg:text-2xl font-bold text-yellow-600"><?php echo e($appointments->where('status', 'pending')->count()); ?></p>
                </div>
                <div class="w-8 lg:w-10 h-8 lg:h-10 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-clock text-yellow-600 text-sm lg:text-base"></i>
                </div>
            </div>
        </div>
        
        <div class="card p-3 lg:p-4">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs lg:text-sm font-medium text-gray-600">Cancelled</p>
                    <p class="text-lg lg:text-2xl font-bold text-red-600"><?php echo e($appointments->where('status', 'cancelled')->count()); ?></p>
                </div>
                <div class="w-8 lg:w-10 h-8 lg:h-10 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-times text-red-600 text-sm lg:text-base"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="flex flex-col sm:flex-row gap-3 lg:gap-4 mb-4 lg:mb-6">
        <a href="<?php echo e(route('patient.appointments.create')); ?>" class="inline-flex items-center justify-center px-4 py-2 lg:py-3 border border-transparent text-sm lg:text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 shadow-sm">
            <i class="fas fa-plus mr-2"></i>
            Book New Appointment
        </a>
    </div>

    <!-- Appointments List -->
    <div class="card">
        <div class="p-4 lg:p-6 border-b border-gray-200">
            <h3 class="text-base lg:text-lg font-semibold text-gray-800">All Appointments</h3>
        </div>
        
        <?php if($appointments->count() > 0): ?>
            <div class="divide-y divide-gray-200">
                <?php $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="p-4 lg:p-6">
                    <div class="flex flex-col gap-3 lg:gap-4">
                        <!-- Mobile Layout -->
                        <div class="block lg:hidden">
                            <div class="flex items-start gap-3 mb-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-calendar-alt text-blue-600 text-sm"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-1">
                                        <h4 class="font-semibold text-gray-800 text-sm truncate">Dr. <?php echo e($appointment->doctor && $appointment->doctor->user ? $appointment->doctor->user->first_name . ' ' . $appointment->doctor->user->last_name : 'Unknown Doctor'); ?></h4>
                                    </div>
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2 text-xs text-gray-600">
                                            <i class="fas fa-calendar text-gray-400"></i>
                                            <?php echo e(\Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y')); ?>

                                        </div>
                                        <div class="flex items-center gap-2 text-xs text-gray-600">
                                            <i class="fas fa-clock text-gray-400"></i>
                                            <?php echo e(\Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A')); ?>

                                        </div>
                                        <div class="flex items-center gap-2 text-xs text-gray-600">
                                            <i class="fas fa-user-md text-gray-400"></i>
                                            <?php echo e($appointment->type ?? 'General Consultation'); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    <?php if($appointment->status === 'confirmed'): ?> bg-green-100 text-green-700
                                    <?php elseif($appointment->status === 'pending'): ?> bg-yellow-100 text-yellow-700
                                    <?php elseif($appointment->status === 'cancelled'): ?> bg-red-100 text-red-700
                                    <?php else: ?> bg-gray-100 text-gray-700 <?php endif; ?>">
                                    <?php echo e(ucfirst($appointment->status)); ?>

                                </span>
                                
                                <div class="flex items-center gap-2">
                                    <a href="<?php echo e(route('patient.appointments.show', $appointment)); ?>" class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-md text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                        <i class="fas fa-eye mr-1"></i>
                                        View
                                    </a>
                                    <?php if($appointment->status === 'pending'): ?>
                                    <form method="POST" action="<?php echo e(route('patient.appointments.cancel', $appointment)); ?>" class="inline" onsubmit="return confirm('Are you sure you want to cancel this appointment?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-red-300 rounded-md text-xs font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                            <i class="fas fa-times mr-1"></i>
                                            Cancel
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Desktop Layout -->
                        <div class="hidden lg:flex lg:items-center lg:justify-between">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-calendar-alt text-blue-600"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <h4 class="font-semibold text-gray-800">Dr. <?php echo e($appointment->doctor && $appointment->doctor->user ? $appointment->doctor->user->first_name . ' ' . $appointment->doctor->user->last_name : 'Unknown Doctor'); ?></h4>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                            <?php if($appointment->status === 'confirmed'): ?> bg-green-100 text-green-700
                                            <?php elseif($appointment->status === 'pending'): ?> bg-yellow-100 text-yellow-700
                                            <?php elseif($appointment->status === 'cancelled'): ?> bg-red-100 text-red-700
                                            <?php else: ?> bg-gray-100 text-gray-700 <?php endif; ?>">
                                            <?php echo e(ucfirst($appointment->status)); ?>

                                        </span>
                                    </div>
                                    <div class="text-sm text-gray-600 mb-2">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-calendar text-gray-400"></i>
                                            <?php echo e(\Carbon\Carbon::parse($appointment->appointment_date)->format('l, M d, Y')); ?>

                                        </div>
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-clock text-gray-400"></i>
                                            <?php echo e(\Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A')); ?>

                                        </div>
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-user-md text-gray-400"></i>
                                            <?php echo e($appointment->type ?? 'General Consultation'); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-3">
                                <a href="<?php echo e(route('patient.appointments.show', $appointment)); ?>" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                    <i class="fas fa-eye mr-2"></i>
                                    View Details
                                </a>
                                <?php if($appointment->status === 'pending'): ?>
                                <form method="POST" action="<?php echo e(route('patient.appointments.cancel', $appointment)); ?>" class="inline" onsubmit="return confirm('Are you sure you want to cancel this appointment?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PATCH'); ?>
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-red-300 rounded-md text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                        <i class="fas fa-times mr-2"></i>
                                        Cancel
                                    </button>
                                </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            
            <!-- Pagination -->
            <?php if($appointments->hasPages()): ?>
            <div class="px-4 lg:px-6 py-4 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Showing <?php echo e($appointments->firstItem()); ?> to <?php echo e($appointments->lastItem()); ?> of <?php echo e($appointments->total()); ?> results
                    </div>
                    <div class="flex items-center space-x-2">
                        <?php echo e($appointments->links()); ?>

                    </div>
                </div>
            </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="p-8 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-calendar-times text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No appointments found</h3>
                <p class="text-gray-500 mb-6">You haven't scheduled any appointments yet.</p>
                <a href="<?php echo e(route('patient.appointments.create')); ?>" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i>
                    Book Your First Appointment
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.patient', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\patient\appointments\index.blade.php ENDPATH**/ ?>