

<?php $__env->startSection('title', 'Patient Dashboard - iWellCare'); ?>
<?php $__env->startSection('page-title', 'Patient Dashboard'); ?>
<?php $__env->startSection('page-subtitle', 'Welcome back, ' . (auth()->user()->first_name ?? 'Patient') . '!'); ?>

<?php $__env->startSection('content'); ?>
<!-- Welcome Section with Hero Card -->
<div class="mb-6 lg:mb-8">
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-blue-600 via-purple-600 to-indigo-700 p-4 lg:p-8 text-white shadow-2xl">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="relative z-10">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div class="flex-1">
                    <h1 class="text-2xl lg:text-3xl font-bold mb-2">Welcome back, <?php echo e(auth()->user()->first_name ?? 'Patient'); ?>! 👋</h1>
                    <p class="text-blue-100 text-base lg:text-lg">Here's what's happening with your health journey today</p>
                </div>
                <div class="hidden lg:block">
                    <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                        <i class="fas fa-heartbeat text-4xl text-white"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- Decorative Elements -->
        <div class="absolute top-0 right-0 w-16 lg:w-32 h-16 lg:h-32 bg-white/10 rounded-full -translate-y-8 lg:-translate-y-16 translate-x-8 lg:translate-x-16"></div>
        <div class="absolute bottom-0 left-0 w-12 lg:w-24 h-12 lg:h-24 bg-white/10 rounded-full translate-y-6 lg:translate-y-12 -translate-x-6 lg:-translate-x-12"></div>
    </div>
</div>

<!-- Statistics Cards with Enhanced Design -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-6 lg:mb-8">
    <!-- Total Appointments Card -->
    <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 p-4 lg:p-6 text-white shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-400/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-blue-100 text-xs lg:text-sm font-medium mb-1">Total Appointments</p>
                    <p class="text-white text-2xl lg:text-3xl font-bold"><?php echo e($totalAppointments); ?></p>
                    <p class="text-blue-100 text-xs mt-1">All time</p>
                </div>
                <div class="w-10 lg:w-14 h-10 lg:h-14 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm group-hover:bg-white/30 transition-all duration-300 flex-shrink-0">
                    <i class="fas fa-calendar-alt text-white text-lg lg:text-2xl"></i>
                </div>
            </div>
        </div>
        <!-- Animated background pattern -->
        <div class="absolute -bottom-2 lg:-bottom-4 -right-2 lg:-right-4 w-12 lg:w-20 h-12 lg:h-20 bg-white/10 rounded-full group-hover:scale-110 transition-transform duration-300"></div>
    </div>

    <!-- Pending Appointments Card -->
    <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-amber-500 to-orange-500 p-4 lg:p-6 text-white shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105">
        <div class="absolute inset-0 bg-gradient-to-br from-amber-400/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-amber-100 text-xs lg:text-sm font-medium mb-1">Pending Appointments</p>
                    <p class="text-white text-2xl lg:text-3xl font-bold"><?php echo e($pendingAppointments); ?></p>
                    <p class="text-amber-100 text-xs mt-1">Awaiting confirmation</p>
                </div>
                <div class="w-10 lg:w-14 h-10 lg:h-14 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm group-hover:bg-white/30 transition-all duration-300 flex-shrink-0">
                    <i class="fas fa-clock text-white text-lg lg:text-2xl"></i>
                </div>
            </div>
        </div>
        <div class="absolute -bottom-2 lg:-bottom-4 -right-2 lg:-right-4 w-12 lg:w-20 h-12 lg:h-20 bg-white/10 rounded-full group-hover:scale-110 transition-transform duration-300"></div>
    </div>

    <!-- Completed Consultations Card -->
    <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-500 p-4 lg:p-6 text-white shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105">
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-400/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-emerald-100 text-xs lg:text-sm font-medium mb-1">Completed Consultations</p>
                    <p class="text-white text-2xl lg:text-3xl font-bold"><?php echo e($completedConsultations); ?></p>
                    <p class="text-emerald-100 text-xs mt-1">This month</p>
                </div>
                <div class="w-10 lg:w-14 h-10 lg:h-14 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm group-hover:bg-white/30 transition-all duration-300 flex-shrink-0">
                    <i class="fas fa-stethoscope text-white text-lg lg:text-2xl"></i>
                </div>
            </div>
        </div>
        <div class="absolute -bottom-2 lg:-bottom-4 -right-2 lg:-right-4 w-12 lg:w-20 h-12 lg:h-20 bg-white/10 rounded-full group-hover:scale-110 transition-transform duration-300"></div>
    </div>

    <!-- Unpaid Invoices Card -->
    <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-rose-500 to-pink-500 p-4 lg:p-6 text-white shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105">
        <div class="absolute inset-0 bg-gradient-to-br from-rose-400/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-rose-100 text-xs lg:text-sm font-medium mb-1">Unpaid Invoices</p>
                    <p class="text-white text-2xl lg:text-3xl font-bold"><?php echo e($unpaidInvoices); ?></p>
                    <p class="text-rose-100 text-xs mt-1">Requires attention</p>
                </div>
                <div class="w-10 lg:w-14 h-10 lg:h-14 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm group-hover:bg-white/30 transition-all duration-300 flex-shrink-0">
                    <i class="fas fa-receipt text-white text-lg lg:text-2xl"></i>
                </div>
            </div>
        </div>
        <div class="absolute -bottom-2 lg:-bottom-4 -right-2 lg:-right-4 w-12 lg:w-20 h-12 lg:h-20 bg-white/10 rounded-full group-hover:scale-110 transition-transform duration-300"></div>
    </div>
</div>

<!-- Quick Actions Section -->
<div class="mb-6 lg:mb-8">
    <div class="card p-4 lg:p-6">
        <h3 class="text-lg lg:text-xl font-semibold text-gray-800 mb-4">Quick Actions</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-4">
            <a href="<?php echo e(route('patient.appointments.create')); ?>" class="group flex items-center p-3 lg:p-4 bg-gradient-to-r from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 rounded-xl transition-all duration-300 hover:scale-105 hover:shadow-lg">
                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mr-3 lg:mr-4 group-hover:bg-blue-600 transition-colors duration-300">
                    <i class="fas fa-calendar-plus text-white text-lg"></i>
                </div>
                <div>
                    <p class="font-semibold text-blue-800 text-sm lg:text-base">Book Appointment</p>
                    <p class="text-blue-600 text-xs">Schedule new consultation</p>
                </div>
            </a>
            
            <a href="<?php echo e(route('patient.appointments.index')); ?>" class="group flex items-center p-3 lg:p-4 bg-gradient-to-r from-green-50 to-green-100 hover:from-green-100 hover:to-green-200 rounded-xl transition-all duration-300 hover:scale-105 hover:shadow-lg">
                <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3 lg:mr-4 group-hover:bg-green-600 transition-colors duration-300">
                    <i class="fas fa-calendar-check text-white text-lg"></i>
                </div>
                <div>
                    <p class="font-semibold text-green-800 text-sm lg:text-base">View Appointments</p>
                    <p class="text-green-600 text-xs">Check your schedule</p>
                </div>
            </a>
            
            <a href="<?php echo e(route('patient.medical-records.index')); ?>" class="group flex items-center p-3 lg:p-4 bg-gradient-to-r from-purple-50 to-purple-100 hover:from-purple-100 hover:to-purple-200 rounded-xl transition-all duration-300 hover:scale-105 hover:shadow-lg">
                <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center mr-3 lg:mr-4 group-hover:bg-purple-600 transition-colors duration-300">
                    <i class="fas fa-file-medical text-white text-lg"></i>
                </div>
                <div>
                    <p class="font-semibold text-purple-800 text-sm lg:text-base">Medical Records</p>
                    <p class="text-purple-600 text-xs">View your history</p>
                </div>
            </a>
            
            <a href="<?php echo e(route('patient.profile.edit')); ?>" class="group flex items-center p-3 lg:p-4 bg-gradient-to-r from-orange-50 to-orange-100 hover:from-orange-100 hover:to-orange-200 rounded-xl transition-all duration-300 hover:scale-105 hover:shadow-lg">
                <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center mr-3 lg:mr-4 group-hover:bg-orange-600 transition-colors duration-300">
                    <i class="fas fa-user-edit text-white text-lg"></i>
                </div>
                <div>
                    <p class="font-semibold text-orange-800 text-sm lg:text-base">Update Profile</p>
                    <p class="text-orange-600 text-xs">Manage your info</p>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- Recent Activity Section -->
<div class="mb-6 lg:mb-8">
    <div class="card p-4 lg:p-6">
        <h3 class="text-lg lg:text-xl font-semibold text-gray-800 mb-4">Recent Activity</h3>
        <div class="space-y-3 lg:space-y-4">
            <?php if($recentAppointments && $recentAppointments->count() > 0): ?>
                <?php $__currentLoopData = $recentAppointments->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex items-center p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3 lg:mr-4 flex-shrink-0">
                        <i class="fas fa-calendar text-blue-600 text-sm lg:text-base"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-gray-800 text-sm lg:text-base truncate">
                            Appointment with Dr. <?php echo e($appointment->doctor ? $appointment->doctor->first_name . ' ' . $appointment->doctor->last_name : 'Unknown Doctor'); ?>

                        </p>
                        <p class="text-gray-600 text-xs lg:text-sm">
                            <?php echo e(\Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y')); ?> at <?php echo e(\Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A')); ?>

                        </p>
                    </div>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                        <?php if($appointment->status === 'confirmed'): ?> bg-green-100 text-green-700
                        <?php elseif($appointment->status === 'pending'): ?> bg-yellow-100 text-yellow-700
                        <?php elseif($appointment->status === 'cancelled'): ?> bg-red-100 text-red-700
                        <?php else: ?> bg-gray-100 text-gray-700 <?php endif; ?>">
                        <?php echo e(ucfirst($appointment->status)); ?>

                    </span>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-calendar-times text-gray-400 text-2xl"></i>
                    </div>
                    <p class="text-gray-500 text-sm lg:text-base">No recent appointments</p>
                    <p class="text-gray-400 text-xs lg:text-sm mt-1">Book your first appointment to get started</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Health Tips Section -->
<div class="mb-6 lg:mb-8">
    <div class="card p-4 lg:p-6">
        <h3 class="text-lg lg:text-xl font-semibold text-gray-800 mb-4">Health Tips</h3>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
            <div class="p-4 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl border-l-4 border-blue-400">
                <div class="flex items-start">
                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                        <i class="fas fa-lightbulb text-white text-sm"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-blue-800 text-sm lg:text-base mb-1">Stay Hydrated</h4>
                        <p class="text-blue-700 text-xs lg:text-sm">Drink at least 8 glasses of water daily to maintain good health and energy levels.</p>
                    </div>
                </div>
            </div>
            
            <div class="p-4 bg-gradient-to-br from-green-50 to-green-100 rounded-xl border-l-4 border-green-400">
                <div class="flex items-start">
                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                        <i class="fas fa-heart text-white text-sm"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-green-800 text-sm lg:text-base mb-1">Regular Exercise</h4>
                        <p class="text-green-700 text-xs lg:text-sm">Aim for at least 30 minutes of moderate physical activity most days of the week.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Emergency Contact Section -->
<div class="mb-6 lg:mb-8">
    <div class="card p-4 lg:p-6 bg-gradient-to-r from-red-50 to-red-100 border border-red-200">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-red-500 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                <i class="fas fa-phone-alt text-white text-lg"></i>
            </div>
            <div class="flex-1">
                <h3 class="font-semibold text-red-800 text-base lg:text-lg mb-1">Emergency Contact</h3>
                <p class="text-red-700 text-sm lg:text-base">For urgent medical assistance, call our emergency line immediately</p>
                <p class="text-red-600 font-semibold text-sm lg:text-base mt-1">Emergency: 09352410173</p>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.patient', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views/patient/dashboard.blade.php ENDPATH**/ ?>