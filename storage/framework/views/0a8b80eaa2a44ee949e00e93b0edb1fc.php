<?php
    $user = Auth::user();
    $role = $user->role ?? 'guest';

    // Get appointment counts based on role
    if ($role === 'patient') {
        $patientModel = $user->patient ?? null;
        $appointmentCount = $patientModel ? $patientModel->appointments()->count() : 0;
    } elseif ($role === 'doctor') {
        $appointmentCount = \App\Models\Appointment::where('doctor_id', $user->id)->count();
    } elseif ($role === 'staff') {
        $appointmentCount = \App\Models\Appointment::count();
    } else {
        $appointmentCount = 0;
    }
?>

<div class="h-full bg-white border-r border-gray-200 flex flex-col">
    <!-- User Info Section -->
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-user-md text-white text-lg"></i>
            </div>
            <div class="flex-1 min-w-0">
                <div class="font-semibold text-gray-900 truncate"><?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?></div>
                <div class="text-sm text-gray-500 capitalize"><?php echo e($role); ?></div>
                <?php
                    $panelLabel = $role === 'doctor' ? 'Doctor Panel' : ($role === 'staff' ? 'Staff Panel' : ($role === 'patient' ? 'Patient Panel' : ''));
                ?>
                <div class="text-xs text-gray-400 mt-1"><?php echo e($panelLabel); ?></div>
            </div>
        </div>
    </div>

    <!-- Navigation Section -->
    <div class="flex-1 overflow-y-auto p-4">
        <nav class="space-y-2">
        <?php if($role === 'doctor'): ?>
            <!-- Doctor Navigation -->
            <a class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600 shadow-sm' : ''); ?>" href="<?php echo e(route('admin.dashboard')); ?>">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center <?php echo e(request()->routeIs('doctor.dashboard') ? 'bg-blue-200' : ''); ?>">
                    <i class="fas fa-tachometer-alt text-blue-600 text-sm"></i>
                </div>
                <span class="font-medium">Dashboard</span>
            </a>
            
            <a class="flex items-center justify-between px-4 py-3 rounded-xl text-gray-700 hover:bg-green-50 hover:text-green-600 transition-all duration-200 <?php echo e(request()->routeIs('doctor.appointments.*') ? 'bg-green-50 text-green-600 border-r-4 border-green-600 shadow-sm' : ''); ?>" href="<?php echo e(route('doctor.appointments.index')); ?>">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center <?php echo e(request()->routeIs('doctor.appointments.*') ? 'bg-green-200' : ''); ?>">
                        <i class="fas fa-calendar-check text-green-600 text-sm"></i>
                    </div>
                    <span class="font-medium">Appointments</span>
                </div>
                <?php if($appointmentCount > 0): ?>
                    <span class="bg-green-600 text-white text-xs font-bold px-2 py-1 rounded-full min-w-[20px] text-center"><?php echo e($appointmentCount); ?></span>
                <?php endif; ?>
            </a>
            
            <a class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition-all duration-200 <?php echo e(request()->routeIs('doctor.patients.*') ? 'bg-purple-50 text-purple-600 border-r-4 border-purple-600 shadow-sm' : ''); ?>" href="<?php echo e(route('doctor.patients.index')); ?>">
                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center <?php echo e(request()->routeIs('doctor.patients.*') ? 'bg-purple-200' : ''); ?>">
                    <i class="fas fa-users text-purple-600 text-sm"></i>
                </div>
                <span class="font-medium">Patients</span>
            </a>
            
            <a class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-all duration-200 <?php echo e(request()->routeIs('doctor.staff.*') ? 'bg-orange-50 text-orange-600 border-r-4 border-orange-600 shadow-sm' : ''); ?>" href="<?php echo e(route('doctor.staff.index')); ?>">
                <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center <?php echo e(request()->routeIs('doctor.staff.*') ? 'bg-orange-200' : ''); ?>">
                    <i class="fas fa-user-cog text-orange-600 text-sm"></i>
                </div>
                <span class="font-medium">Staff Management</span>
            </a>
            
            <a class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-red-50 hover:text-red-600 transition-all duration-200 <?php echo e(request()->routeIs('doctor.prescriptions.*') ? 'bg-red-50 text-red-600 border-r-4 border-red-600 shadow-sm' : ''); ?>" href="<?php echo e(route('doctor.prescriptions.index')); ?>">
                <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center <?php echo e(request()->routeIs('doctor.prescriptions.*') ? 'bg-red-200' : ''); ?>">
                    <i class="fas fa-pills text-red-600 text-sm"></i>
                </div>
                <span class="font-medium">Prescriptions</span>
            </a>
            
            <a class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-all duration-200 <?php echo e(request()->routeIs('doctor.inventory.*') ? 'bg-indigo-50 text-indigo-600 border-r-4 border-indigo-600 shadow-sm' : ''); ?>" href="<?php echo e(route('doctor.inventory.index')); ?>">
                <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center <?php echo e(request()->routeIs('doctor.inventory.*') ? 'bg-indigo-200' : ''); ?>">
                    <i class="fas fa-boxes text-indigo-600 text-sm"></i>
                </div>
                <span class="font-medium">Inventory</span>
            </a>
            
            <a class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-teal-50 hover:text-teal-600 transition-all duration-200 <?php echo e(request()->routeIs('doctor.reports.*') ? 'bg-teal-50 text-teal-600 border-r-4 border-teal-600 shadow-sm' : ''); ?>" href="<?php echo e(route('doctor.reports.index')); ?>">
                <div class="w-8 h-8 bg-teal-100 rounded-lg flex items-center justify-center <?php echo e(request()->routeIs('doctor.reports.*') ? 'bg-teal-200' : ''); ?>">
                    <i class="fas fa-chart-bar text-teal-600 text-sm"></i>
                </div>
                <span class="font-medium">Reports</span>
            </a>
            
        <?php elseif($role === 'staff'): ?>
            <!-- Staff Navigation -->
            <a class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-green-50 hover:text-green-600 transition-all duration-200 <?php echo e(request()->routeIs('staff.dashboard') ? 'bg-green-50 text-green-600 border-r-4 border-green-600 shadow-sm' : ''); ?>" href="<?php echo e(route('staff.dashboard')); ?>">
                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center <?php echo e(request()->routeIs('staff.dashboard') ? 'bg-green-200' : ''); ?>">
                    <i class="fas fa-tachometer-alt text-green-600 text-sm"></i>
                </div>
                <span class="font-medium">Dashboard</span>
            </a>
            
            <a class="flex items-center justify-between px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 <?php echo e(request()->routeIs('staff.appointments.*') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600 shadow-sm' : ''); ?>" href="<?php echo e(route('staff.appointments.index')); ?>">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center <?php echo e(request()->routeIs('staff.appointments.*') ? 'bg-blue-200' : ''); ?>">
                        <i class="fas fa-calendar-check text-blue-600 text-sm"></i>
                    </div>
                    <span class="font-medium">Appointments</span>
                </div>
                <?php if($appointmentCount > 0): ?>
                    <span class="bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded-full min-w-[20px] text-center"><?php echo e($appointmentCount); ?></span>
                <?php endif; ?>
            </a>
            
            <a class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition-all duration-200 <?php echo e(request()->routeIs('staff.consultations.*') ? 'bg-purple-50 text-purple-600 border-r-4 border-purple-600 shadow-sm' : ''); ?>" href="<?php echo e(route('staff.consultations.index')); ?>">
                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center <?php echo e(request()->routeIs('staff.consultations.*') ? 'bg-purple-200' : ''); ?>">
                    <i class="fas fa-stethoscope text-purple-600 text-sm"></i>
                </div>
                <span class="font-medium">Consultations</span>
            </a>
            
            <a class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-all duration-200 <?php echo e(request()->routeIs('staff.patients.*') ? 'bg-orange-50 text-orange-600 border-r-4 border-orange-600 shadow-sm' : ''); ?>" href="<?php echo e(route('staff.patients.index')); ?>">
                <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center <?php echo e(request()->routeIs('staff.patients.*') ? 'bg-orange-200' : ''); ?>">
                    <i class="fas fa-users text-orange-600 text-sm"></i>
                </div>
                <span class="font-medium">Patients</span>
            </a>
            
            <a class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-teal-50 hover:text-teal-600 transition-all duration-200 <?php echo e(request()->routeIs('staff.doctor-availability.*') ? 'bg-teal-50 text-teal-600 border-r-4 border-teal-600 shadow-sm' : ''); ?>" href="<?php echo e(route('staff.doctor-availability.index')); ?>">
                <div class="w-8 h-8 bg-teal-100 rounded-lg flex items-center justify-center <?php echo e(request()->routeIs('staff.doctor-availability.*') ? 'bg-teal-200' : ''); ?>">
                    <i class="fas fa-user-check text-teal-600 text-sm"></i>
                </div>
                <span class="font-medium">Doctor Availability</span>
            </a>
            
            <a class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-all duration-200 <?php echo e(request()->routeIs('staff.inventory.*') ? 'bg-indigo-50 text-indigo-600 border-r-4 border-indigo-600 shadow-sm' : ''); ?>" href="<?php echo e(route('staff.inventory.index')); ?>">
                <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center <?php echo e(request()->routeIs('staff.inventory.*') ? 'bg-indigo-200' : ''); ?>">
                    <i class="fas fa-boxes text-indigo-600 text-sm"></i>
                </div>
                <span class="font-medium">Inventory</span>
            </a>
            
            <a class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-yellow-50 hover:text-yellow-600 transition-all duration-200 <?php echo e(request()->routeIs('staff.invoice.*') ? 'bg-yellow-50 text-yellow-600 border-r-4 border-yellow-600 shadow-sm' : ''); ?>" href="<?php echo e(route('staff.invoice.index')); ?>">
                <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center <?php echo e(request()->routeIs('staff.invoice.*') ? 'bg-yellow-200' : ''); ?>">
                    <i class="fas fa-file-invoice-dollar text-yellow-600 text-sm"></i>
                </div>
                <span class="font-medium">Invoice</span>
            </a>
            
            <a class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-pink-50 hover:text-pink-600 transition-all duration-200 <?php echo e(request()->routeIs('staff.prescriptions.*') ? 'bg-pink-50 text-pink-600 border-r-4 border-pink-600 shadow-sm' : ''); ?>" href="<?php echo e(route('staff.prescriptions.index')); ?>">
                <div class="w-8 h-8 bg-pink-100 rounded-lg flex items-center justify-center <?php echo e(request()->routeIs('staff.prescriptions.*') ? 'bg-pink-200' : ''); ?>">
                    <i class="fas fa-pills text-pink-600 text-sm"></i>
                </div>
                <span class="font-medium">Prescriptions</span>
            </a>
            
            <a class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-red-50 hover:text-red-600 transition-all duration-200 <?php echo e(request()->routeIs('staff.reports.*') ? 'bg-red-50 text-red-600 border-r-4 border-red-600 shadow-sm' : ''); ?>" href="<?php echo e(route('staff.reports.index')); ?>">
                <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center <?php echo e(request()->routeIs('staff.reports.*') ? 'bg-red-200' : ''); ?>">
                    <i class="fas fa-chart-bar text-red-600 text-sm"></i>
                </div>
                <span class="font-medium">Reports</span>
            </a>
            
        <?php elseif($role === 'patient'): ?>
            <!-- Patient Navigation -->
            <a class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition-all duration-200 <?php echo e(request()->routeIs('patient.dashboard') ? 'bg-purple-50 text-purple-600 border-r-4 border-purple-600 shadow-sm' : ''); ?>" href="<?php echo e(route('patient.dashboard')); ?>">
                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center <?php echo e(request()->routeIs('patient.dashboard') ? 'bg-purple-200' : ''); ?>">
                    <i class="fas fa-tachometer-alt text-purple-600 text-sm"></i>
                </div>
                <span class="font-medium">Dashboard</span>
            </a>
            
            <a class="flex items-center justify-between px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 <?php echo e(request()->routeIs('patient.appointments.*') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600 shadow-sm' : ''); ?>" href="<?php echo e(route('patient.appointments.index')); ?>">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center <?php echo e(request()->routeIs('patient.appointments.*') ? 'bg-blue-200' : ''); ?>">
                        <i class="fas fa-calendar-check text-blue-600 text-sm"></i>
                    </div>
                    <span class="font-medium">Appointments</span>
                </div>
                <?php if($appointmentCount > 0): ?>
                    <span class="bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded-full min-w-[20px] text-center"><?php echo e($appointmentCount); ?></span>
                <?php endif; ?>
            </a>
            
            <a class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-green-50 hover:text-green-600 transition-all duration-200 <?php echo e(request()->routeIs('patient.consultations.*') ? 'bg-green-50 text-green-600 border-r-4 border-green-600 shadow-sm' : ''); ?>" href="<?php echo e(route('patient.consultations.index')); ?>">
                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center <?php echo e(request()->routeIs('patient.consultations.*') ? 'bg-green-200' : ''); ?>">
                    <i class="fas fa-stethoscope text-green-600 text-sm"></i>
                </div>
                <span class="font-medium">Consultations</span>
            </a>
            
            <a class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-red-50 hover:text-red-600 transition-all duration-200 <?php echo e(request()->routeIs('patient.prescriptions.*') ? 'bg-red-50 text-red-600 border-r-4 border-red-600 shadow-sm' : ''); ?>" href="<?php echo e(route('patient.prescriptions.index')); ?>">
                <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center <?php echo e(request()->routeIs('patient.prescriptions.*') ? 'bg-red-200' : ''); ?>">
                    <i class="fas fa-pills text-red-600 text-sm"></i>
                </div>
                <span class="font-medium">Prescriptions</span>
            </a>
            
            <a class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-all duration-200 <?php echo e(request()->routeIs('patient.medical-records.*') ? 'bg-orange-50 text-orange-600 border-r-4 border-orange-600 shadow-sm' : ''); ?>" href="<?php echo e(route('patient.medical-records.index')); ?>">
                <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center <?php echo e(request()->routeIs('patient.medical-records.*') ? 'bg-orange-200' : ''); ?>">
                    <i class="fas fa-file-medical text-orange-600 text-sm"></i>
                </div>
                <span class="font-medium">Medical Records</span>
            </a>
            
            <a class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-teal-50 hover:text-teal-600 transition-all duration-200 <?php echo e(request()->routeIs('patient.invoice.*') ? 'bg-teal-50 text-teal-600 border-r-4 border-teal-600 shadow-sm' : ''); ?>" href="<?php echo e(route('patient.invoice.index')); ?>">
                <div class="w-8 h-8 bg-teal-100 rounded-lg flex items-center justify-center <?php echo e(request()->routeIs('patient.invoice.*') ? 'bg-teal-200' : ''); ?>">
                    <i class="fas fa-file-invoice-dollar text-teal-600 text-sm"></i>
                </div>
                <span class="font-medium">Invoice</span>
            </a>
        <?php endif; ?>

        <!-- Divider -->
        <div class="border-t border-gray-200 my-6"></div>

        <!-- Common Navigation -->
        <?php if($role === 'doctor'): ?>
            <a class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200 <?php echo e(request()->routeIs('doctor.profile.*') ? 'bg-gray-50 text-gray-900 border-r-4 border-gray-600 shadow-sm' : ''); ?>" href="<?php echo e(route('doctor.profile.index')); ?>">
                <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center <?php echo e(request()->routeIs('doctor.profile.*') ? 'bg-gray-200' : ''); ?>">
                    <i class="fas fa-user text-gray-600 text-sm"></i>
                </div>
                <span class="font-medium">Profile</span>
            </a>
        <?php elseif($role === 'staff'): ?>
            <a class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200 <?php echo e(request()->routeIs('staff.profile.*') ? 'bg-gray-50 text-gray-900 border-r-4 border-gray-600 shadow-sm' : ''); ?>" href="<?php echo e(route('staff.profile.index')); ?>">
                <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center <?php echo e(request()->routeIs('staff.profile.*') ? 'bg-gray-200' : ''); ?>">
                    <i class="fas fa-user text-gray-600 text-sm"></i>
                </div>
                <span class="font-medium">Profile</span>
            </a>
        <?php elseif($role === 'patient'): ?>
            <a class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200 <?php echo e(request()->routeIs('patient.profile.*') ? 'bg-gray-50 text-gray-900 border-r-4 border-gray-600 shadow-sm' : ''); ?>" href="<?php echo e(route('patient.profile.index')); ?>">
                <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center <?php echo e(request()->routeIs('patient.profile.*') ? 'bg-gray-200' : ''); ?>">
                    <i class="fas fa-user text-gray-600 text-sm"></i>
                </div>
                <span class="font-medium">Profile</span>
            </a>
        <?php endif; ?>
        
        <!-- Logout Section -->
        <div class="mt-6 p-4 bg-red-50 rounded-xl">
            <form method="POST" action="<?php echo e(route('logout')); ?>" class="w-full">
                <?php echo csrf_field(); ?>
                <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-red-700 hover:bg-red-100 transition-all duration-200">
                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-sign-out-alt text-red-600 text-sm"></i>
                    </div>
                    <span class="font-medium">Logout</span>
                </button>
            </form>
        </div>
    </nav>
</div> <?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\layouts\sidebar.blade.php ENDPATH**/ ?>