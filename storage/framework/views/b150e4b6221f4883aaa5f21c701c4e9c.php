

<?php $__env->startSection('content'); ?>
<!-- Main Content -->
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <!-- Staff Metrics (styled like Staff Dashboard) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Staff -->
        <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 p-6 text-white shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-400/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium mb-1">Total Staff</p>
                        <p class="text-white text-3xl font-bold"><?php echo e($totalStaff); ?></p>
                        <p class="text-blue-100 text-xs mt-1">Active: <?php echo e($activeStaff); ?></p>
                    </div>
                    <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm group-hover:bg-white/30 transition-all duration-300">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                </div>
            </div>
            <div class="absolute -bottom-4 -right-4 w-20 h-20 bg-white/10 rounded-full group-hover:scale-110 transition-transform duration-300"></div>
        </div>

        <!-- Staff Appointments This Month -->
        <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-amber-500 to-orange-500 p-6 text-white shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105">
            <div class="absolute inset-0 bg-gradient-to-br from-amber-400/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-amber-100 text-sm font-medium mb-1">Appointments This Month</p>
                        <p class="text-white text-3xl font-bold"><?php echo e($staffAppointmentsThisMonth); ?></p>
                        <p class="text-amber-100 text-xs mt-1">This week: <?php echo e($staffAppointmentsThisWeek); ?></p>
                    </div>
                    <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm group-hover:bg-white/30 transition-all duration-300">
                        <i class="fas fa-calendar-check text-white text-2xl"></i>
                    </div>
                </div>
            </div>
            <div class="absolute -bottom-4 -right-4 w-20 h-20 bg-white/10 rounded-full group-hover:scale-110 transition-transform duration-300"></div>
        </div>

        <!-- Staff Consultations This Month -->
        <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-rose-500 to-pink-500 p-6 text-white shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105">
            <div class="absolute inset-0 bg-gradient-to-br from-rose-400/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-rose-100 text-sm font-medium mb-1">Consultations This Month</p>
                        <p class="text-white text-3xl font-bold"><?php echo e($staffConsultationsThisMonth); ?></p>
                        <p class="text-rose-100 text-xs mt-1">This week: <?php echo e($staffConsultationsThisWeek); ?></p>
                    </div>
                    <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm group-hover:bg-white/30 transition-all duration-300">
                        <i class="fas fa-stethoscope text-white text-2xl"></i>
                    </div>
                </div>
            </div>
            <div class="absolute -bottom-4 -right-4 w-20 h-20 bg-white/10 rounded-full group-hover:scale-110 transition-transform duration-300"></div>
        </div>

        <!-- New Staff This Month -->
        <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-500 p-6 text-white shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-400/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-emerald-100 text-sm font-medium mb-1">New Staff This Month</p>
                        <p class="text-white text-3xl font-bold"><?php echo e($newStaffThisMonth); ?></p>
                        <p class="text-emerald-100 text-xs mt-1">This week: <?php echo e($newStaffThisWeek); ?></p>
                    </div>
                    <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm group-hover:bg-white/30 transition-all duration-300">
                        <i class="fas fa-user-plus text-white text-2xl"></i>
                    </div>
                </div>
            </div>
            <div class="absolute -bottom-4 -right-4 w-20 h-20 bg-white/10 rounded-full group-hover:scale-110 transition-transform duration-300"></div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white shadow-lg rounded-xl p-6 mb-8">
        <h3 class="text-xl font-bold text-gray-900 mb-6">Quick Actions</h3>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <a href="<?php echo e(route('admin.staff.create')); ?>" class="group flex flex-col items-center p-4 bg-gradient-to-br from-green-50 to-green-100 rounded-xl hover:from-green-100 hover:to-green-200 transition-all">
                <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mb-2">
                    <i class="fas fa-user-plus text-white text-lg"></i>
                </div>
                <span class="text-green-900 font-semibold text-center text-sm">Add Staff</span>
            </a>

            <a href="<?php echo e(route('admin.consultations.create')); ?>" class="group flex flex-col items-center p-4 bg-gradient-to-br from-teal-50 to-teal-100 rounded-xl hover:from-teal-100 hover:to-teal-200 transition-all">
                <div class="w-10 h-10 bg-teal-500 rounded-lg flex items-center justify-center mb-2">
                    <i class="fas fa-stethoscope text-white text-lg"></i>
                </div>
                <span class="text-teal-900 font-semibold text-center text-sm">New Consultation</span>
            </a>

            <a href="<?php echo e(route('admin.prescriptions.create')); ?>" class="group flex flex-col items-center p-4 bg-gradient-to-br from-cyan-50 to-cyan-100 rounded-xl hover:from-cyan-100 hover:to-cyan-200 transition-all">
                <div class="w-10 h-10 bg-cyan-500 rounded-lg flex items-center justify-center mb-2">
                    <i class="fas fa-prescription-bottle text-white text-lg"></i>
                </div>
                <span class="text-cyan-900 font-semibold text-center text-sm">Create Prescription</span>
            </a>

            <a href="<?php echo e(route('admin.inventory.create')); ?>" class="group flex flex-col items-center p-4 bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl hover:from-emerald-100 hover:to-emerald-200 transition-all">
                <div class="w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center mb-2">
                    <i class="fas fa-boxes text-white text-lg"></i>
                </div>
                <span class="text-emerald-900 font-semibold text-center text-sm">Add Inventory</span>
            </a>

            <a href="<?php echo e(route('admin.doctor-availability.index')); ?>" class="group flex flex-col items-center p-4 bg-gradient-to-br from-violet-50 to-violet-100 rounded-xl hover:from-violet-100 hover:to-violet-200 transition-all">
                <div class="w-10 h-10 bg-violet-500 rounded-lg flex items-center justify-center mb-2">
                    <i class="fas fa-clock text-white text-lg"></i>
                </div>
                <span class="text-violet-900 font-semibold text-center text-sm">Doctor Availability</span>
            </a>

            <a href="<?php echo e(route('admin.invoice.create')); ?>" class="group flex flex-col items-center p-4 bg-gradient-to-br from-rose-50 to-rose-100 rounded-xl hover:from-rose-100 hover:to-rose-200 transition-all">
                <div class="w-10 h-10 bg-rose-500 rounded-lg flex items-center justify-center mb-2">
                    <i class="fas fa-plus-circle text-white text-lg"></i>
                </div>
                <span class="text-rose-900 font-semibold text-center text-sm">Create Invoice</span>
            </a>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Top Staff by Appointments -->
        <div class="bg-white shadow-lg rounded-xl">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-900">Top Staff by Appointments</h3>
                <p class="text-sm text-gray-600">This month</p>
            </div>
            <div class="p-6">
                <?php if($topStaffByAppointments->count() > 0): ?>
                    <div class="space-y-4">
                        <?php $__currentLoopData = $topStaffByAppointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $staff): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-blue-600"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-semibold text-gray-900">
                                        <?php echo e($staff->first_name); ?> <?php echo e($staff->last_name); ?>

                                    </p>
                                    <p class="text-xs text-gray-500">
                                        <?php echo e($staff->username); ?>

                                    </p>
                                </div>
                            </div>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                <?php echo e($staff->created_appointments_count); ?> appointments
                            </span>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-calendar-times text-gray-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-500 font-medium">No appointment data available</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Top Staff by Consultations -->
        <div class="bg-white shadow-lg rounded-xl">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-900">Top Staff by Consultations</h3>
                <p class="text-sm text-gray-600">This month</p>
            </div>
            <div class="p-6">
                <?php if($topStaffByConsultations->count() > 0): ?>
                    <div class="space-y-4">
                        <?php $__currentLoopData = $topStaffByConsultations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $staff): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-green-600"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-semibold text-gray-900">
                                        <?php echo e($staff->first_name); ?> <?php echo e($staff->last_name); ?>

                                    </p>
                                    <p class="text-xs text-gray-500">
                                        <?php echo e($staff->username); ?>

                                    </p>
                                </div>
                            </div>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                <?php echo e($staff->created_consultations_count); ?> consultations
                            </span>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-stethoscope text-gray-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-500 font-medium">No consultation data available</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Recent Staff Activities -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
        <!-- Recent Staff Appointments -->
        <div class="bg-white shadow-lg rounded-xl">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-900">Recent Staff Appointments</h3>
            </div>
            <div class="p-6">
                <?php if($recentStaffAppointments->count() > 0): ?>
                    <div class="space-y-3">
                        <?php $__currentLoopData = $recentStaffAppointments->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-blue-600 text-sm"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-semibold text-gray-900">
                                        <?php echo e($appointment->patient->first_name ?? 'Unknown'); ?> <?php echo e($appointment->patient->last_name ?? 'Patient'); ?>

                                    </p>
                                    <p class="text-xs text-gray-500">
                                        Created by: <?php echo e($appointment->createdBy->first_name ?? 'Unknown'); ?> <?php echo e($appointment->createdBy->last_name ?? 'Staff'); ?>

                                    </p>
                                </div>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                <?php if($appointment->status === 'confirmed'): ?> bg-green-100 text-green-800
                                <?php elseif($appointment->status === 'pending'): ?> bg-yellow-100 text-yellow-800
                                <?php else: ?> bg-gray-100 text-gray-800 <?php endif; ?>">
                                <?php echo e(ucfirst($appointment->status)); ?>

                            </span>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-8">
                        <p class="text-gray-500 font-medium">No recent staff appointments</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Recent Staff Consultations -->
        <div class="bg-white shadow-lg rounded-xl">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-900">Recent Staff Consultations</h3>
            </div>
            <div class="p-6">
                <?php if($recentStaffConsultations->count() > 0): ?>
                    <div class="space-y-3">
                        <?php $__currentLoopData = $recentStaffConsultations->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $consultation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-stethoscope text-green-600 text-sm"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-semibold text-gray-900">
                                        <?php echo e($consultation->patient->first_name ?? 'Unknown'); ?> <?php echo e($consultation->patient->last_name ?? 'Patient'); ?>

                                    </p>
                                    <p class="text-xs text-gray-500">
                                        Created by: <?php echo e($consultation->createdBy->first_name ?? 'Unknown'); ?> <?php echo e($consultation->createdBy->last_name ?? 'Staff'); ?>

                                    </p>
                                </div>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                <?php if($consultation->status === 'completed'): ?> bg-green-100 text-green-800
                                <?php elseif($consultation->status === 'in_progress'): ?> bg-yellow-100 text-yellow-800
                                <?php else: ?> bg-gray-100 text-gray-800 <?php endif; ?>">
                                <?php echo e(ucfirst($consultation->status)); ?>

                            </span>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-8">
                        <p class="text-gray-500 font-medium">No recent staff consultations</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- System Health -->
    <div class="grid grid-cols-1 lg:grid-cols-1 gap-8 mt-8">
        <div class="bg-white shadow-lg rounded-xl">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-900">System Health</h3>
            </div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm font-medium text-gray-500">Database Status</span>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                        <?php if($systemHealth['status'] === 'healthy'): ?> bg-green-100 text-green-800
                        <?php elseif($systemHealth['status'] === 'warning'): ?> bg-yellow-100 text-yellow-800
                        <?php else: ?> bg-red-100 text-red-800 <?php endif; ?>">
                        <?php echo e(ucfirst($systemHealth['status'])); ?>

                    </span>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Database:</span>
                        <span class="font-medium"><?php echo e($systemHealth['database'] ?? 'Unknown'); ?></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Tables:</span>
                        <span class="font-medium"><?php echo e($systemHealth['tables'] ?? 'Unknown'); ?></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Message:</span>
                        <span class="font-medium"><?php echo e($systemHealth['message'] ?? 'No message'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\admin\dashboard.blade.php ENDPATH**/ ?>