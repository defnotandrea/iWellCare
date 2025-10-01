

<?php $__env->startSection('title', 'Staff Dashboard - iWellCare'); ?>
<?php $__env->startSection('page-title', 'Staff Dashboard'); ?>
<?php $__env->startSection('page-subtitle', 'Welcome back, ' . (auth()->user()->first_name ?? 'Staff') . '!'); ?>

<?php $__env->startSection('content'); ?>
<!-- Statistics Cards with Enhanced Design -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Today's Appointments Card -->
    <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 p-6 text-white shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-400/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium mb-1">Today's Appointments</p>
                    <p class="text-white text-3xl font-bold"><?php echo e($todaysAppointments ?? 0); ?></p>
                    <p class="text-blue-100 text-xs mt-1">Scheduled for today</p>
                </div>
                <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm group-hover:bg-white/30 transition-all duration-300">
                    <i class="fas fa-calendar-check text-white text-2xl"></i>
                </div>
            </div>
        </div>
        <div class="absolute -bottom-4 -right-4 w-20 h-20 bg-white/10 rounded-full group-hover:scale-110 transition-transform duration-300"></div>
    </div>

    <!-- Pending Confirmations Card -->
    <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-amber-500 to-orange-500 p-6 text-white shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105">
        <div class="absolute inset-0 bg-gradient-to-br from-amber-400/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-amber-100 text-sm font-medium mb-1">Pending Confirmations</p>
                    <p class="text-white text-3xl font-bold"><?php echo e($pendingConfirmations ?? 0); ?></p>
                    <p class="text-amber-100 text-xs mt-1">Awaiting approval</p>
                </div>
                <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm group-hover:bg-white/30 transition-all duration-300">
                    <i class="fas fa-clock text-white text-2xl"></i>
                </div>
            </div>
        </div>
        <div class="absolute -bottom-4 -right-4 w-20 h-20 bg-white/10 rounded-full group-hover:scale-110 transition-transform duration-300"></div>
    </div>

    <!-- Low Inventory Items Card -->
    <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-rose-500 to-pink-500 p-6 text-white shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105">
        <div class="absolute inset-0 bg-gradient-to-br from-rose-400/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-rose-100 text-sm font-medium mb-1">Low Inventory Items</p>
                    <p class="text-white text-3xl font-bold"><?php echo e($lowInventory ?? 0); ?></p>
                    <p class="text-rose-100 text-xs mt-1">Need restocking</p>
                </div>
                <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm group-hover:bg-white/30 transition-all duration-300">
                    <i class="fas fa-boxes text-white text-2xl"></i>
                </div>
            </div>
        </div>
        <div class="absolute -bottom-4 -right-4 w-20 h-20 bg-white/10 rounded-full group-hover:scale-110 transition-transform duration-300"></div>
    </div>

    <!-- Unpaid Bills Card -->
    <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-500 p-6 text-white shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105">
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-400/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-emerald-100 text-sm font-medium mb-1">Unpaid Bills</p>
                    <p class="text-white text-3xl font-bold"><?php echo e($unpaidBills ?? 0); ?></p>
                    <p class="text-emerald-100 text-xs mt-1">Requires attention</p>
                </div>
                <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm group-hover:bg-white/30 transition-all duration-300">
                    <i class="fas fa-file-invoice-dollar text-white text-2xl"></i>
                </div>
            </div>
        </div>
        <div class="absolute -bottom-4 -right-4 w-20 h-20 bg-white/10 rounded-full group-hover:scale-110 transition-transform duration-300"></div>
    </div>
</div>

<!-- Quick Actions with Enhanced Design -->
<div class="mb-8">
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-bolt text-white text-lg"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Quick Actions</h3>
                    <p class="text-gray-600">Common tasks and shortcuts</p>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                <!-- Manage Appointments -->
                <a href="<?php echo e(route('staff.appointments.index')); ?>" class="group relative overflow-hidden p-5 border border-gray-200 rounded-xl hover:border-blue-300 hover:bg-gradient-to-br hover:from-blue-50 hover:to-indigo-50 transition-all duration-300 hover:shadow-lg hover:scale-105">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-calendar-check text-white text-xl"></i>
                        </div>
                        <span class="text-blue-900 font-semibold text-sm">Manage Appointments</span>
                    </div>
                    <div class="absolute top-0 right-0 w-16 h-16 bg-blue-100/50 rounded-full -translate-y-8 translate-x-8 group-hover:scale-150 transition-transform duration-300"></div>
                </a>
                
                <!-- Patient Management -->
                <a href="<?php echo e(route('staff.patients.index')); ?>" class="group relative overflow-hidden p-5 border border-gray-200 rounded-xl hover:border-green-300 hover:bg-gradient-to-br hover:from-green-50 hover:to-emerald-50 transition-all duration-300 hover:shadow-lg hover:scale-105">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-users text-white text-xl"></i>
                        </div>
                        <span class="text-green-900 font-semibold text-sm">Patient Management</span>
                    </div>
                    <div class="absolute top-0 right-0 w-16 h-16 bg-green-100/50 rounded-full -translate-y-8 translate-x-8 group-hover:scale-150 transition-transform duration-300"></div>
                </a>
                
                <!-- Create Invoice -->
                <a href="<?php echo e(route('staff.billing.create')); ?>" class="group relative overflow-hidden p-5 border border-gray-200 rounded-xl hover:border-purple-300 hover:bg-gradient-to-br hover:from-purple-50 hover:to-violet-50 transition-all duration-300 hover:shadow-lg hover:scale-105">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-violet-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-file-invoice-dollar text-white text-xl"></i>
                        </div>
                        <span class="text-purple-900 font-semibold text-sm">Create Invoice</span>
                    </div>
                    <div class="absolute top-0 right-0 w-16 h-16 bg-purple-100/50 rounded-full -translate-y-8 translate-x-8 group-hover:scale-150 transition-transform duration-300"></div>
                </a>
                
                <!-- Inventory -->
                <a href="<?php echo e(route('staff.inventory.index')); ?>" class="group relative overflow-hidden p-5 border border-gray-200 rounded-xl hover:border-orange-300 hover:bg-gradient-to-br hover:from-orange-50 hover:to-amber-50 transition-all duration-300 hover:shadow-lg hover:scale-105">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-amber-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-boxes text-white text-xl"></i>
                        </div>
                        <span class="text-orange-900 font-semibold text-sm">Inventory</span>
                    </div>
                    <div class="absolute top-0 right-0 w-16 h-16 bg-orange-100/50 rounded-full -translate-y-8 translate-x-8 group-hover:scale-150 transition-transform duration-300"></div>
                </a>
                
                <!-- Prescriptions -->
                <a href="<?php echo e(route('staff.prescriptions.index')); ?>" class="group relative overflow-hidden p-5 border border-gray-200 rounded-xl hover:border-pink-300 hover:bg-gradient-to-br hover:from-pink-50 hover:to-rose-50 transition-all duration-300 hover:shadow-lg hover:scale-105">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-14 h-14 bg-gradient-to-br from-pink-500 to-rose-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-pills text-white text-xl"></i>
                        </div>
                        <span class="text-pink-900 font-semibold text-sm">Prescriptions</span>
                    </div>
                    <div class="absolute top-0 right-0 w-16 h-16 bg-pink-100/50 rounded-full -translate-y-8 translate-x-8 group-hover:scale-150 transition-transform duration-300"></div>
                </a>
                
                <!-- Consultations -->
                <a href="<?php echo e(route('staff.consultations.index')); ?>" class="group relative overflow-hidden p-5 border border-gray-200 rounded-xl hover:border-indigo-300 hover:bg-gradient-to-br hover:from-indigo-50 hover:to-blue-50 transition-all duration-300 hover:shadow-lg hover:scale-105">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-blue-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-stethoscope text-white text-xl"></i>
                        </div>
                        <span class="text-indigo-900 font-semibold text-sm">Consultations</span>
                    </div>
                    <div class="absolute top-0 right-0 w-16 h-16 bg-indigo-100/50 rounded-full -translate-y-8 translate-x-8 group-hover:scale-150 transition-transform duration-300"></div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Appointments -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-calendar text-white text-lg"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Recent Appointments</h3>
                </div>
                <a href="<?php echo e(route('staff.appointments.index')); ?>" class="text-blue-600 hover:text-blue-700 text-sm font-semibold hover:underline transition-colors">View All</a>
            </div>
        </div>
        
        <div class="p-6">
            <?php if(isset($recentAppointments) && $recentAppointments->count() > 0): ?>
                <div class="space-y-4">
                    <?php $__currentLoopData = $recentAppointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="group p-4 border border-gray-200 rounded-xl hover:border-blue-300 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-calendar-alt text-white"></i>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-800"><?php echo e($appointment->patient ? $appointment->patient->first_name . ' ' . $appointment->patient->last_name : 'Unknown Patient'); ?></div>
                                    <div class="text-sm text-gray-600"><?php echo e($appointment->doctor ? $appointment->doctor->first_name . ' ' . $appointment->doctor->last_name : 'Unknown Doctor'); ?> • <?php echo e(\Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y')); ?></div>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                <?php if($appointment->status === 'confirmed'): ?> bg-green-100 text-green-700 border border-green-200
                                <?php elseif($appointment->status === 'pending'): ?> bg-yellow-100 text-yellow-700 border border-yellow-200
                                <?php else: ?> bg-gray-100 text-gray-700 border border-gray-200 <?php endif; ?>">
                                <?php echo e(ucfirst($appointment->status)); ?>

                            </span>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-calendar-times text-gray-400 text-xl"></i>
                    </div>
                    <p class="text-gray-500">No recent appointments</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Recent Patients -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-users text-white text-lg"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Recent Patients</h3>
                </div>
                <a href="<?php echo e(route('staff.patients.index')); ?>" class="text-green-600 hover:text-green-700 text-sm font-semibold hover:underline transition-colors">View All</a>
            </div>
        </div>
        
        <div class="p-6">
            <?php if(isset($recentPatients) && $recentPatients->count() > 0): ?>
                <div class="space-y-4">
                    <?php $__currentLoopData = $recentPatients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="group p-4 border border-gray-200 rounded-xl hover:border-green-300 hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50 transition-all duration-300">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-user text-white"></i>
                            </div>
                            <div class="flex-1">
                                <div class="font-semibold text-gray-800"><?php echo e($patient->first_name); ?> <?php echo e($patient->last_name); ?></div>
                                <div class="text-sm text-gray-600"><?php echo e($patient->email); ?></div>
                            </div>
                            <a href="<?php echo e(route('staff.patients.show', $patient)); ?>" class="w-8 h-8 bg-green-100 hover:bg-green-200 rounded-lg flex items-center justify-center text-green-600 hover:text-green-700 transition-colors">
                                <i class="fas fa-eye text-sm"></i>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-users text-gray-400 text-xl"></i>
                    </div>
                    <p class="text-gray-500">No recent patients</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.staff', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\staff\dashboard.blade.php ENDPATH**/ ?>