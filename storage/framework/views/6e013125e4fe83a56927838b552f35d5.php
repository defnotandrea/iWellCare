<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'iWellCare')); ?><?php if (! empty(trim($__env->yieldContent('title')))): ?> - <?php echo $__env->yieldContent('title'); ?><?php endif; ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo e(asset('assets/img/icon.png')); ?>">
    <link rel="shortcut icon" type="image/png" href="<?php echo e(asset('assets/img/icon.png')); ?>">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Additional CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Custom Styles -->
    <style>
        :root {
            /* Primary Healthcare Colors */
            --primary-color: #1e40af;
            --primary-dark: #1e3a8a;
            --primary-light: #3b82f6;
            --primary-lighter: #60a5fa;
            
            /* Secondary Colors */
            --secondary-color: #475569;
            --secondary-light: #64748b;
            
            /* Accent Colors */
            --accent-color: #059669;
            --accent-light: #10b981;
            --accent-lighter: #34d399;
            
            /* Status Colors */
            --success-color: #059669;
            --success-light: #10b981;
            --warning-color: #d97706;
            --warning-light: #f59e0b;
            --danger-color: #dc2626;
            --danger-light: #ef4444;
            --info-color: #0891b2;
            --info-light: #06b6d4;
            
            /* Background Colors */
            --bg-light: #f8fafc;
            --bg-lighter: #f1f5f9;
            --bg-white: #ffffff;
            --bg-dark: #0f172a;
            --bg-darker: #020617;
            
            /* Text Colors */
            --text-dark: #0f172a;
            --text-medium: #334155;
            --text-light: #64748b;
            --text-muted: #94a3b8;
            --text-white: #ffffff;
            
            /* Border Colors */
            --border-color: #e2e8f0;
            --border-light: #f1f5f9;
            --border-dark: #cbd5e1;
            
            /* Shadow System */
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            
            /* Border Radius */
            --border-radius: 12px;
            --border-radius-sm: 8px;
            --border-radius-lg: 16px;
            --border-radius-xl: 20px;
            
            /* Healthcare Specific Colors */
            --health-blue: #1e40af;
            --health-green: #059669;
            --health-teal: #0891b2;
            --health-orange: #d97706;
            --health-red: #dc2626;
            --health-purple: #7c3aed;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            line-height: 1.6;
            font-size: 16px;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Typography */
        h1, h2, h3, h4, h5, h6 {
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 1rem;
            color: var(--text-dark);
        }

        h1 { font-size: 2.5rem; }
        h2 { font-size: 2rem; }
        h3 { font-size: 1.75rem; }
        h4 { font-size: 1.5rem; }
        h5 { font-size: 1.25rem; }
        h6 { font-size: 1rem; }

        p {
            margin-bottom: 1rem;
            color: var(--text-light);
        }

        .lead {
            font-size: 1.125rem;
            font-weight: 400;
            line-height: 1.7;
        }

        /* Navigation */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            padding: 1rem 0;
            transition: all 0.3s ease;
        }

        .navbar-brand {
            color: var(--text-dark);
            font-weight: 800;
            font-size: 1.6rem;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            color: var(--primary-color);
            transform: translateY(-1px);
        }

        .brand-text {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-light);
            margin-left: 0.75rem;
            line-height: 1.2;
            transition: color 0.3s ease;
        }

        .navbar-nav .nav-link {
            font-weight: 500;
            color: var(--text-light);
            padding: 0.5rem 1rem;
            border-radius: var(--border-radius-sm);
            transition: all 0.3s ease;
            margin: 0 0.25rem;
        }

        .navbar-nav .nav-link:hover {
            color: var(--primary-color);
            background-color: rgba(37, 99, 235, 0.1);
            transform: translateY(-1px);
        }

        .navbar-nav .btn {
            border-radius: var(--border-radius-sm);
            font-weight: 600;
            padding: 0.5rem 1.5rem;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .navbar-nav .btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .navbar-nav .btn-outline-primary {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .navbar-nav .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .navbar-nav .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .navbar-nav .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        /* Buttons */
        .btn {
            border-radius: var(--border-radius-sm);
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            color: white;
        }

        .btn-outline-primary {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .btn-light {
            background-color: white;
            border-color: white;
            color: var(--text-dark);
        }

        .btn-light:hover {
            background-color: #f8fafc;
            border-color: #f8fafc;
            color: var(--text-dark);
        }

        .btn-outline-light {
            border-color: white;
            color: white;
        }

        .btn-outline-light:hover {
            background-color: white;
            border-color: white;
            color: var(--text-dark);
        }

        .btn-lg {
            padding: 1rem 2rem;
            font-size: 1.125rem;
        }

        /* Cards */
        .card {
            border: none;
            box-shadow: var(--shadow-md);
            border-radius: var(--border-radius);
            transition: all 0.3s ease;
            background: var(--bg-white);
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
        }

        .card-body {
            padding: 2rem;
        }

        .card-title {
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1rem;
        }

        .card-text {
            color: var(--text-light);
            line-height: 1.6;
        }

        /* Alerts */
        .alert {
            border: none;
            border-radius: var(--border-radius-sm);
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow-sm);
        }

        .alert-success {
            background-color: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
            border-left: 4px solid var(--success-color);
        }

        .alert-danger {
            background-color: rgba(239, 68, 68, 0.1);
            color: var(--danger-color);
            border-left: 4px solid var(--danger-color);
        }

        .alert-warning {
            background-color: rgba(245, 158, 11, 0.1);
            color: var(--warning-color);
            border-left: 4px solid var(--warning-color);
        }

        .alert-info {
            background-color: rgba(6, 182, 212, 0.1);
            color: var(--info-color);
            border-left: 4px solid var(--info-color);
        }

        /* Forms */
        .form-control, .form-select {
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: var(--bg-white);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            outline: none;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        /* Sections */
        .section {
            padding: 4rem 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 1rem;
        }

        .section-title p {
            font-size: 1.125rem;
            color: var(--text-light);
            max-width: 600px;
            margin: 0 auto;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            color: white;
            padding: 6rem 0;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .hero-section .container {
            position: relative;
            z-index: 1;
        }

        /* Features Section */
        .features-section {
            background: var(--bg-light);
            padding: 5rem 0;
        }

        .feature-card {
            text-align: center;
            padding: 2rem;
            background: var(--bg-white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            transition: all 0.3s ease;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
        }

        .feature-card i {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
        }

        /* Services Section */
        .services-section {
            padding: 5rem 0;
            background: var(--bg-white);
        }

        .service-card {
            text-align: center;
            padding: 2rem;
            background: var(--bg-white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            transition: all 0.3s ease;
            height: 100%;
            border: 1px solid var(--border-color);
        }

        .service-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
            border-color: var(--primary-color);
        }

        .service-card i {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
        }

        /* Footer */
        footer {
            background: var(--bg-dark);
            color: white;
            padding: 4rem 0 2rem;
        }

        footer h5, footer h6 {
            color: white;
            margin-bottom: 1.5rem;
        }

        footer p, footer li {
            color: var(--text-muted);
        }

        footer a {
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        footer a:hover {
            color: white;
        }

        .hover-white:hover {
            color: white !important;
            transition: color 0.3s ease;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .brand-text {
                font-size: 0.9rem;
            }
            
            .hero-section {
                padding: 4rem 0;
            }
            
            .section {
                padding: 3rem 0;
            }
            
            .section-title h2 {
                font-size: 2rem;
            }
        }

        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 1.4rem;
            }
            
            .brand-text {
                display: none;
            }
            
            .btn-lg {
                padding: 0.75rem 1.5rem;
                font-size: 1rem;
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Loading States */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        /* Custom Scrollbar - Disabled */
        ::-webkit-scrollbar {
            width: 0px;
            display: none;
        }

        ::-webkit-scrollbar-track {
            display: none;
        }

        ::-webkit-scrollbar-thumb {
            display: none;
        }

        ::-webkit-scrollbar-thumb:hover {
            display: none;
        }

        /* Hide scrollbar for all elements */
        * {
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* Internet Explorer 10+ */
        }

        /* Hide scrollbar for webkit browsers */
        *::-webkit-scrollbar {
            display: none;
        }
    </style>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <div id="app">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg fixed-top">
            <div class="container">
                <a class="navbar-brand" href="<?php echo e(route('home')); ?>">
                    <img src="<?php echo e(asset('assets/img/iWellCare-logo.png')); ?>" alt="iWellCare" height="40" class="me-2">
                    <span class="brand-text">Adult Wellness Clinic and Medical Laboratory</span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <?php if(auth()->guard()->guest()): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('login')); ?>">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('register')); ?>">Register</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-user-circle me-1"></i>
                                    <?php echo e(Auth::user()->full_name); ?>

                                </a>
                                <ul class="dropdown-menu">
                                    <?php if(Auth::user()->role === 'doctor'): ?>
                                        <li><a class="dropdown-item" href="<?php echo e(route('doctor.dashboard')); ?>">Dashboard</a></li>
                                        <li><a class="dropdown-item" href="<?php echo e(route('doctor.profile.index')); ?>">Profile</a></li>
                                    <?php elseif(Auth::user()->role === 'staff'): ?>
                                        <li><a class="dropdown-item" href="<?php echo e(route('staff.dashboard')); ?>">Dashboard</a></li>
                                        <li><a class="dropdown-item" href="<?php echo e(route('staff.profile.index')); ?>">Profile</a></li>
                                    <?php elseif(Auth::user()->role === 'patient'): ?>
                                        <li><a class="dropdown-item" href="<?php echo e(route('patient.dashboard')); ?>">Dashboard</a></li>
                                        <li><a class="dropdown-item" href="<?php echo e(route('patient.profile.index')); ?>">Profile</a></li>
                                    <?php endif; ?>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="dropdown-item">Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div style="margin-top: 80px;">
            <!-- Page Content -->
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>

    <!-- Alert Modal -->
    <?php if(session('success') || session('error') || session('warning') || session('info') || $errors->any()): ?>
    <div id="alertModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" style="display: none;">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all">
            <div class="px-8 py-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <?php if(session('success')): ?>
                            <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-check-circle text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Success</h3>
                                <p class="text-gray-600 text-sm">Operation completed successfully</p>
                            </div>
                        <?php elseif(session('error')): ?>
                            <div class="w-12 h-12 bg-red-500 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-exclamation-circle text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Error</h3>
                                <p class="text-gray-600 text-sm">Something went wrong</p>
                            </div>
                        <?php elseif(session('warning')): ?>
                            <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Warning</h3>
                                <p class="text-gray-600 text-sm">Please take note</p>
                            </div>
                        <?php elseif(session('info')): ?>
                            <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-info-circle text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Information</h3>
                                <p class="text-gray-600 text-sm">Important information</p>
                            </div>
                        <?php elseif($errors->any()): ?>
                            <div class="w-12 h-12 bg-red-500 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-exclamation-circle text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Validation Error</h3>
                                <p class="text-gray-600 text-sm">Please check the form</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <button onclick="closeAlertModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <div class="mb-6">
                    <?php if(session('success')): ?>
                        <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg">
                            <p class="text-green-700"><?php echo e(session('success')); ?></p>
                        </div>
                    <?php elseif(session('error')): ?>
                        <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg">
                            <p class="text-red-700"><?php echo e(session('error')); ?></p>
                        </div>
                    <?php elseif(session('warning')): ?>
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg">
                            <p class="text-yellow-700"><?php echo e(session('warning')); ?></p>
                        </div>
                    <?php elseif(session('info')): ?>
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg">
                            <p class="text-blue-700"><?php echo e(session('info')); ?></p>
                        </div>
                    <?php elseif($errors->any()): ?>
                        <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg">
                            <ul class="text-red-700 space-y-1">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="flex items-start">
                                        <i class="fas fa-times-circle mr-2 mt-0.5 text-red-500"></i>
                                        <?php echo e($error); ?>

                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="flex justify-end">
                    <button onclick="closeAlertModal()" 
                            class="px-6 py-2 bg-gray-600 text-white rounded-lg font-semibold hover:bg-gray-700 transition-colors">
                        OK
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init();

        // Alert Modal Functions
        function showAlertModal() {
            const modal = document.getElementById('alertModal');
            if (modal) {
                modal.style.display = 'flex';
                // Add animation
                const modalContent = modal.querySelector('.bg-white');
                modalContent.style.transform = 'scale(0.9)';
                setTimeout(() => {
                    modalContent.style.transform = 'scale(1)';
                }, 10);
            }
        }

        function closeAlertModal() {
            const modal = document.getElementById('alertModal');
            if (modal) {
                const modalContent = modal.querySelector('.bg-white');
                modalContent.style.transform = 'scale(0.9)';
                setTimeout(() => {
                    modal.style.display = 'none';
                }, 200);
            }
        }

        // Show alert modal on page load if there are messages
        document.addEventListener('DOMContentLoaded', function() {
            <?php if(session('success') || session('error') || session('warning') || session('info') || $errors->any()): ?>
                showAlertModal();
            <?php endif; ?>
        });

        // Close modal when clicking outside
        document.addEventListener('click', function(e) {
            const modal = document.getElementById('alertModal');
            if (modal && e.target === modal) {
                closeAlertModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAlertModal();
            }
        });
    </script>

    <script src="<?php echo e(asset('assets/js/logout-handler.js')); ?>"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html> <?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\layouts\landing.blade.php ENDPATH**/ ?>