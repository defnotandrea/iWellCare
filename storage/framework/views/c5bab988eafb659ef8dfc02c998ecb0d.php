<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Patient Portal - iWellCare'); ?></title>
    
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
        
        /* Fixed sidebar like staff layout */
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
        }
        
        /* Hide mobile overlay and button to mirror staff design */
        .sidebar-overlay { display: none !important; }
        .mobile-menu-btn { display: none !important; }
        
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
        
        /* Main content mirrors staff layout */
        .main-content { 
            margin-left: 280px; 
            min-height: 100vh;
            background: #f8fafc;
        }
        
        .nav-item {
            border-radius: 16px;
            margin: 8px 16px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .nav-item:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(4px);
        }
        
        .nav-item.active {
            background: rgba(255, 255, 255, 0.25);
            box-shadow: 0 4px 20px rgba(255, 255, 255, 0.1);
        }
        
        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: linear-gradient(180deg, #fbbf24, #f59e0b);
            border-radius: 0 2px 2px 0;
        }

        .card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(30, 64, 175, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(30, 64, 175, 0.4);
        }
        
        
        /* Enhanced Sidebar Logo */
        .sidebar-logo {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        /* Enhanced Navigation Icons */
        .nav-icon {
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .nav-item:hover .nav-icon {
            transform: scale(1.1);
        }
        
        /* Header simplified to staff style */
        .page-header { background: white; border-bottom: 1px solid #e5e7eb; }
        .page-title { font-size: 1.875rem; font-weight: 700; color: #111827; }
        .page-subtitle { color: #64748b; font-weight: 500; }
        
        /* Mobile navigation improvements */
        @media (max-width: 1023px) {
            .nav-item {
                margin: 4px 12px;
                padding: 0.75rem 1rem;
            }
            
            .nav-item span {
                font-size: 0.95rem;
            }
            
            .sidebar-logo img {
                width: 80px;
                height: 80px;
            }
            
            .sidebar-logo {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>

    

    <!-- Sidebar -->
    <div id="sidebar" class="sidebar">
        <!-- Logo Section -->
        <div class="sidebar-logo">
            <div class="flex items-center justify-center">
                <img src="<?php echo e(asset('assets/img/iWellCare-logo.png')); ?>" alt="iWellCare" class="w-32 h-32 object-contain brightness-0 invert filter">
            </div>
        </div>

        <!-- Navigation -->
        <div class="p-4">
            <nav class="space-y-2">
                <a href="<?php echo e(route('patient.dashboard')); ?>" class="nav-item <?php echo e(request()->routeIs('patient.dashboard') ? 'active' : ''); ?> flex items-center space-x-4 px-4 py-4 text-white">
                    <div class="nav-icon">
                        <i class="fas fa-tachometer-alt text-lg"></i>
                    </div>
                    <span class="font-semibold">Dashboard</span>
                </a>
                
                <a href="<?php echo e(route('patient.appointments.index')); ?>" class="nav-item <?php echo e(request()->routeIs('patient.appointments.*') ? 'active' : ''); ?> flex items-center space-x-4 px-4 py-4 text-blue-100 hover:text-white">
                    <div class="nav-icon">
                        <i class="fas fa-calendar-check text-lg"></i>
                    </div>
                    <span class="font-semibold">Appointments</span>
                </a>
                
                <a href="<?php echo e(route('patient.consultations.index')); ?>" class="nav-item <?php echo e(request()->routeIs('patient.consultations.*') ? 'active' : ''); ?> flex items-center space-x-4 px-4 py-4 text-blue-100 hover:text-white">
                    <div class="nav-icon">
                        <i class="fas fa-stethoscope text-lg"></i>
                    </div>
                    <span class="font-semibold">Consultations</span>
                </a>
                
                <a href="<?php echo e(route('patient.prescriptions.index')); ?>" class="nav-item <?php echo e(request()->routeIs('patient.prescriptions.*') ? 'active' : ''); ?> flex items-center space-x-4 px-4 py-4 text-blue-100 hover:text-white">
                    <div class="nav-icon">
                        <i class="fas fa-pills text-lg"></i>
                    </div>
                    <span class="font-semibold">Prescriptions</span>
                </a>
                
                <a href="<?php echo e(route('patient.medical-records.index')); ?>" class="nav-item <?php echo e(request()->routeIs('patient.medical-records.*') ? 'active' : ''); ?> flex items-center space-x-4 px-4 py-4 text-blue-100 hover:text-white">
                    <div class="nav-icon">
                        <i class="fas fa-file-medical text-lg"></i>
                    </div>
                    <span class="font-semibold">Medical Records</span>
                </a>
                
                <a href="<?php echo e(route('patient.invoice.index')); ?>" class="nav-item <?php echo e(request()->routeIs('patient.invoice.*') ? 'active' : ''); ?> flex items-center space-x-4 px-4 py-4 text-blue-100 hover:text-white">
                    <div class="nav-icon">
                        <i class="fas fa-receipt text-lg"></i>
                    </div>
                    <span class="font-semibold">Invoices</span>
                </a>
                
                <a href="<?php echo e(route('patient.profile.edit')); ?>" class="nav-item <?php echo e(request()->routeIs('patient.profile.*') ? 'active' : ''); ?> flex items-center space-x-4 px-4 py-4 text-blue-100 hover:text-white">
                    <div class="nav-icon">
                        <i class="fas fa-user-circle text-lg"></i>
                    </div>
                    <span class="font-semibold">Profile</span>
                </a>
            </nav>
            
            <!-- User Info Section -->
            <div class="mt-8 p-4 bg-white/10 rounded-2xl backdrop-blur-sm">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-white text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <div class="text-white font-semibold"><?php echo e(auth()->user()->first_name); ?> <?php echo e(auth()->user()->last_name); ?></div>
                            <div class="text-blue-100 text-sm">Patient</div>
                        </div>
                    </div>
                    <a href="<?php echo e(route('patient.appointments.create')); ?>" class="w-8 h-8 bg-blue-500 hover:bg-blue-600 rounded-lg flex items-center justify-center text-white text-sm transition-colors" title="New Consultation">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>

                <!-- Logout Button -->
                <form method="POST" action="<?php echo e(route('logout')); ?>" class="mt-3">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="w-full flex items-center justify-center space-x-2 px-3 py-2 bg-white/20 hover:bg-white/30 rounded-xl text-white text-sm font-medium transition-all duration-300 hover:scale-105">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header (staff-like) -->
        <div class="bg-white border-b border-gray-200 px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></h1>
                    <p class="text-gray-600 mt-1"><?php echo $__env->yieldContent('page-subtitle', 'Welcome to your patient portal'); ?></p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="bg-blue-50 px-4 py-2 rounded-lg">
                        <span class="text-blue-600 font-medium"><?php echo e(now()->format('l, F j, Y')); ?></span>
                    </div>
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-blue-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <div class="p-8">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>

    <script>
        // Page Load Initialization
        document.addEventListener('DOMContentLoaded', function() {
            // Initialization code here
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Hover effects for cards
        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-4px)';
                this.style.boxShadow = '0 12px 20px rgba(0, 0, 0, 0.08)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.06)';
            });
        });
    </script>
</body>
</html> <?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\layouts\patient.blade.php ENDPATH**/ ?>