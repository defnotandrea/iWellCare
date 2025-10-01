<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Dashboard - iWellCare'); ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo e(asset('assets/img/icon.png')); ?>">
    <link rel="shortcut icon" type="image/png" href="<?php echo e(asset('assets/img/icon.png')); ?>">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { 
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; 
            background: #f8fafc;
            margin: 0 !important;
            padding: 0 !important;
            overflow-x: hidden !important;
        }
        .sidebar { 
            width: 280px; 
            position: fixed; 
            left: 0; 
            top: 0; 
            height: 100vh; 
            background: linear-gradient(180deg, #1e40af 0%, #3b82f6 100%);
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15);
            z-index: 50;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }
        
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }
        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }
        .main-content { 
            margin-left: 280px; 
            min-height: 100vh;
            background: #f8fafc;
        }
        .nav-item {
            border-radius: 12px;
            margin: 6px 12px;
            position: relative;
            overflow: hidden;
        }
        .nav-item:hover {
            background: rgba(255, 255, 255, 0.15);
        }
        .nav-item.active {
            background: rgba(255, 255, 255, 0.25);
        }

        .card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.875rem;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.15s ease-in-out;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        .btn-secondary {
            background: #f1f5f9;
            color: #64748b;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
        }
        .btn-secondary:hover {
            background: #e2e8f0;
        }
        .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }
        .btn-success:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        }
        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }
        .btn-danger:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        }
        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.75rem;
            border-radius: 6px;
        }
        .form-input {
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 0.75rem;
            width: 100%;
            font-size: 14px;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        .form-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        .table-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .table-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Logo Section -->
        <div class="border-b border-blue-400/20">
            <div class="flex items-center justify-center">
                <img src="<?php echo e(asset('assets/img/iWellCare-logo.png')); ?>" alt="iWellCare" class="w-32 h-32 object-contain brightness-0 invert filter">
            </div>
        </div>

        <!-- Navigation -->
        <div class="p-4" style="flex: 1 1 auto;">
            <nav class="space-y-2" style="height: 100%;">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?> flex items-center space-x-3 px-4 py-3 text-white">
                    <i class="fas fa-tachometer-alt text-lg"></i>
                    <span class="font-medium">Dashboard</span>
                </a>
                <a href="<?php echo e(route('admin.staff.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.staff.*') ? 'active' : ''); ?> flex items-center space-x-3 px-4 py-3 text-blue-100 hover:text-white">
                    <i class="fas fa-user-cog text-lg"></i>
                    <span class="font-medium">Team</span>
                </a>
                <a href="<?php echo e(route('admin.patients.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.patients.*') ? 'active' : ''); ?> flex items-center space-x-3 px-4 py-3 text-blue-100 hover:text-white">
                    <i class="fas fa-users text-lg"></i>
                    <span class="font-medium">Patients</span>
                </a>
                <a href="<?php echo e(route('admin.appointments.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.appointments.*') ? 'active' : ''); ?> flex items-center justify-between px-4 py-3 text-blue-100 hover:text-white">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-calendar-alt text-lg"></i>
                        <span class="font-medium">Appointments</span>
                    </div>
                    <?php
                        $todayAppointmentCount = \App\Models\Appointment::whereDate('appointment_date', today())->count();
                    ?>
                    <?php if($todayAppointmentCount > 0): ?>
                        <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full"><?php echo e($todayAppointmentCount); ?></span>
                    <?php endif; ?>
                </a>
                <a href="<?php echo e(route('admin.consultations.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.consultations.*') ? 'active' : ''); ?> flex items-center space-x-3 px-4 py-3 text-blue-100 hover:text-white">
                    <i class="fas fa-stethoscope text-lg"></i>
                    <span class="font-medium">Consultations</span>
                </a>
                <a href="<?php echo e(route('admin.inventory.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.inventory.*') ? 'active' : ''); ?> flex items-center space-x-3 px-4 py-3 text-blue-100 hover:text-white">
                    <i class="fas fa-pills text-lg"></i>
                    <span class="font-medium">Inventory</span>
                </a>
                <a href="<?php echo e(route('admin.reports.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.reports.*') ? 'active' : ''); ?> flex items-center space-x-3 px-4 py-3 text-blue-100 hover:text-white">
                    <i class="fas fa-chart-bar text-lg"></i>
                    <span class="font-medium">Reports</span>
                </a>
                <a href="<?php echo e(route('admin.invoice.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.invoice.*') ? 'active' : ''); ?> flex items-center space-x-3 px-4 py-3 text-blue-100 hover:text-white">
                    <i class="fas fa-file-invoice-dollar text-lg"></i>
                    <span class="font-medium">Invoice</span>
                </a>
            </nav>
        </div>

        <!-- Logout -->
        <div class="mt-auto p-4 border-t border-blue-400/20">
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 text-blue-100 hover:text-white hover:bg-red-500/20 rounded-xl">
                    <i class="fas fa-sign-out-alt text-lg"></i>
                    <span class="font-medium">Logout</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="bg-white border-b border-gray-200 px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></h1>
                    <p class="text-gray-600 mt-1"><?php echo $__env->yieldContent('page-subtitle', 'Welcome back, ' . auth()->user()->first_name . '!'); ?></p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="bg-blue-50 px-4 py-2 rounded-lg">
                        <span class="text-blue-600 font-medium"><?php echo e(now()->format('l, F j, Y')); ?></span>
                    </div>
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-md text-blue-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <div class="p-8">
            

            <!-- Validation Errors -->
            <?php if(isset($errors) && $errors->any()): ?>
                <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-red-400 text-lg mr-3"></i>
                        <div>
                            <span class="text-red-700 font-medium">Please fix the following errors:</span>
                            <ul class="text-red-600 text-sm mt-1 list-disc list-inside">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Main Content Area -->
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Add any global JavaScript functionality here
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide flash messages after 5 seconds
            const flashMessages = document.querySelectorAll('.bg-green-50, .bg-red-50, .bg-yellow-50, .bg-blue-50');
            flashMessages.forEach(function(message) {
                setTimeout(function() {
                    message.remove();
                }, 5000);
            });
        });
    </script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html> <?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\layouts\admin.blade.php ENDPATH**/ ?>