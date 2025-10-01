<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="cache-control" content="no-cache, no-store, must-revalidate">
    <meta name="pragma" content="no-cache">
    <meta name="expires" content="0">

    <title>@yield('title', 'Adult Wellness Clinic')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/img/icon.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/icon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        },
                        health: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        }
                    },
                    animation: {
                        'fadeIn': 'fadeIn 0.5s ease-in-out',
                        'slideUp': 'slideUp 0.5s ease-out',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    }
                }
            }
        }
    </script>

    <style>
        :root {
            --primary-color: #3b82f6;
            --secondary-color: #64748b;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --light-color: #f8fafc;
            --dark-color: #1e293b;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --border-color: #e2e8f0;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --bg-light: #f8fafc;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .health-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
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
            color: var(--text-dark);
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .navbar-nav .nav-link:hover {
            color: var(--primary-color);
            background-color: rgba(59, 130, 246, 0.1);
        }

        .navbar-nav .nav-link.active {
            color: var(--primary-color);
            background-color: rgba(59, 130, 246, 0.1);
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            text-decoration: none;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 0.875rem;
            line-height: 1.25rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, #2563eb 100%);
            color: white;
            box-shadow: var(--shadow-sm);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .btn-secondary {
            background: var(--secondary-color);
            color: white;
        }

        .btn-secondary:hover {
            background: #475569;
            transform: translateY(-1px);
        }

        .btn-success {
            background: var(--success-color);
            color: white;
        }

        .btn-success:hover {
            background: #059669;
            transform: translateY(-1px);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline:hover {
            background: var(--primary-color);
            color: white;
        }

        /* Cards */
        .card {
            background: white;
            border-radius: 1rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .card-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            background: rgba(248, 250, 252, 0.5);
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Forms */
        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        /* Alerts */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            border-color: rgba(16, 185, 129, 0.2);
            color: #065f46;
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            border-color: rgba(239, 68, 68, 0.2);
            color: #991b1b;
        }

        .alert-warning {
            background: rgba(245, 158, 11, 0.1);
            border-color: rgba(245, 158, 11, 0.2);
            color: #92400e;
        }

        .alert-info {
            background: rgba(59, 130, 246, 0.1);
            border-color: rgba(59, 130, 246, 0.2);
            color: #1e40af;
        }

        /* Utilities */
        .text-primary { color: var(--primary-color) !important; }
        .text-secondary { color: var(--secondary-color) !important; }
        .text-success { color: var(--success-color) !important; }
        .text-warning { color: var(--warning-color) !important; }
        .text-danger { color: var(--danger-color) !important; }
        .text-light { color: var(--text-light) !important; }
        .text-dark { color: var(--text-dark) !important; }

        .bg-primary { background-color: var(--primary-color) !important; }
        .bg-secondary { background-color: var(--secondary-color) !important; }
        .bg-success { background-color: var(--success-color) !important; }
        .bg-warning { background-color: var(--warning-color) !important; }
        .bg-danger { background-color: var(--danger-color) !important; }
        .bg-light { background-color: var(--light-color) !important; }
        .bg-dark { background-color: var(--dark-color) !important; }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar-nav {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .card {
                margin-bottom: 1rem;
            }
            
            h1 { font-size: 2rem; }
            h2 { font-size: 1.75rem; }
            h3 { font-size: 1.5rem; }
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        .slide-up {
            animation: slideUp 0.6s ease-out;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

    </style>
</head>
<body class="antialiased flex flex-col min-h-screen">

    <!-- Navigation -->
    <nav class="navbar fixed top-0 left-0 right-0 z-50" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <!-- Logo and Brand -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="navbar-brand">
                        <img src="{{ asset('assets/img/iWellCare-logo.png') }}" alt="iWellCare Logo" class="h-12 w-auto mr-3">
                        <span class="text-lg">ADULT WELLNESS CLINIC AND MEDICAL LABORATORY</span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-primary">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-outline">
                            <i class="fas fa-user-plus mr-2"></i>Register
                        </a>
                    @else
                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-primary-600 transition-colors">
                                <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-primary-600"></i>
                                </div>
                                <span class="font-medium">{{ Auth::user()->first_name }}</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            
                            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2">
                                <div class="px-4 py-2 border-b border-gray-100">
                                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->full_name }}</p>
                                    <p class="text-xs text-gray-500 capitalize">{{ Auth::user()->role }}</p>
                                </div>
                                
                                @if(Auth::user()->role === 'doctor')
                                    <a href="{{ route('doctor.profile.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                        <i class="fas fa-user-cog mr-2"></i>Profile
                                    </a>
                                @elseif(Auth::user()->role === 'staff')
                                    <a href="{{ route('staff.profile.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                        <i class="fas fa-user-cog mr-2"></i>Profile
                                    </a>
                                @elseif(Auth::user()->role === 'patient')
                                    <a href="{{ route('patient.profile.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                        <i class="fas fa-user-cog mr-2"></i>Profile
                                    </a>
                                @endif
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-700 hover:text-primary-600">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation -->
            <div x-show="mobileMenuOpen" x-transition class="md:hidden mt-4 pb-4 border-t border-gray-200">
                @guest
                    <div class="flex flex-col space-y-2">
                        <a href="{{ route('login') }}" class="btn btn-primary w-full justify-center">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-outline w-full justify-center">
                            <i class="fas fa-user-plus mr-2"></i>Register
                        </a>
                    </div>
                @else
                    <div class="flex flex-col space-y-2">
                        <div class="px-4 py-2 border-b border-gray-100">
                            <p class="text-sm font-medium text-gray-900">{{ Auth::user()->full_name }}</p>
                            <p class="text-xs text-gray-500 capitalize">{{ Auth::user()->role }}</p>
                        </div>
                        
                        @if(Auth::user()->role === 'doctor')
                            <a href="{{ route('doctor.profile.index') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-user-cog mr-2"></i>Profile
                            </a>
                        @elseif(Auth::user()->role === 'staff')
                            <a href="{{ route('staff.profile.index') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-user-cog mr-2"></i>Profile
                            </a>
                        @elseif(Auth::user()->role === 'patient')
                            <a href="{{ route('patient.profile.index') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-user-cog mr-2"></i>Profile
                            </a>
                        @endif
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </button>
                        </form>
                    </div>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="pt-16 flex-1">
        @auth
            <!-- Sidebar for authenticated users -->
            <div class="flex min-h-screen">
                <div class="w-64 bg-white shadow-lg fixed left-0 top-16 z-40 border-r border-gray-200">
                    @include('layouts.sidebar')
                </div>
                <div class="flex-1 ml-64">
                    <div class="min-h-screen bg-gray-50">
                        <!-- Page Content -->
                        @yield('content')
                    </div>
                </div>
            </div>
        @else
            <!-- Full width for guests -->
            <div class="min-h-screen">
                <!-- Page Content -->
                @yield('content')
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-gray-900 to-gray-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Company Info -->
                <div>
                    <h3 class="text-lg font-bold mb-4">ADULT WELLNESS CLINIC AND MEDICAL LABORATORY</h3>
                    <p class="text-gray-300 text-sm mb-4">
                        Your trusted partner in healthcare. We provide comprehensive medical services with a focus on patient care and wellness.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-facebook text-lg"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-twitter text-lg"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-instagram text-lg"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-white transition-colors">Home</a></li>
                        <li><a href="#contact" class="text-gray-300 hover:text-white transition-colors">Contact</a></li>
                        @guest
                            <li><a href="{{ route('login') }}" class="text-gray-300 hover:text-white transition-colors">Patient Login</a></li>
                            <li><a href="{{ route('register') }}" class="text-gray-300 hover:text-white transition-colors">Register</a></li>
                        @else
                            <li><a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-white transition-colors">Dashboard</a></li>
                        @endguest
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Contact Info</h4>
                    <div class="space-y-3 text-sm text-gray-300">
                        <div class="flex items-start">
                            <i class="fas fa-phone mr-3 mt-1 text-blue-400"></i>
                            <div>
                                <p class="font-medium">Phone</p>
                                <p>09352410173</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-envelope mr-3 mt-1 text-green-400"></i>
                            <div>
                                <p class="font-medium">Email</p>
                                <p>adultwellnessclinicandm@gmail.com</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-map-marker-alt mr-3 mt-1 text-red-400"></i>
                            <div>
                                <p class="font-medium">Address</p>
                                <p>Capitulacion Street, Zone 2<br>Bangued, Abra</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} Adult Wellness Clinic and Medical Laboratory. All rights reserved.</p>
                    <div class="flex space-x-6 mt-4 md:mt-0">
                        <a href="{{ route('privacy-policy') }}" class="text-gray-400 hover:text-white transition-colors text-sm">Privacy Policy</a>
                        <a href="{{ route('terms-of-service') }}" class="text-gray-400 hover:text-white transition-colors text-sm">Terms of Service</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Alert Modal -->
    @if(session('success') || session('error') || session('warning') || session('info') || $errors->any())
    <div id="alertModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" style="display: none;">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all">
            <div class="px-8 py-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        @if(session('success'))
                            <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-check-circle text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Success</h3>
                                <p class="text-gray-600 text-sm">Operation completed successfully</p>
                            </div>
                        @elseif(session('error'))
                            <div class="w-12 h-12 bg-red-500 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-exclamation-circle text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Error</h3>
                                <p class="text-gray-600 text-sm">Something went wrong</p>
                            </div>
                        @elseif(session('warning'))
                            <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Warning</h3>
                                <p class="text-gray-600 text-sm">Please take note</p>
                            </div>
                        @elseif(session('info'))
                            <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-info-circle text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Information</h3>
                                <p class="text-gray-600 text-sm">Important information</p>
                            </div>
                        @elseif($errors->any())
                            <div class="w-12 h-12 bg-red-500 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-exclamation-circle text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Validation Error</h3>
                                <p class="text-gray-600 text-sm">Please check the form</p>
                            </div>
                        @endif
                    </div>
                    <button onclick="closeAlertModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <div class="mb-6">
                    @if(session('success'))
                        <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg">
                            <p class="text-green-700">{{ session('success') }}</p>
                        </div>
                    @elseif(session('error'))
                        <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg">
                            <p class="text-red-700">{{ session('error') }}</p>
                        </div>
                    @elseif(session('warning'))
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg">
                            <p class="text-yellow-700">{{ session('warning') }}</p>
                        </div>
                    @elseif(session('info'))
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg">
                            <p class="text-blue-700">{{ session('info') }}</p>
                        </div>
                    @elseif($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg">
                            <ul class="text-red-700 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li class="flex items-start">
                                        <i class="fas fa-times-circle mr-2 mt-0.5 text-red-500"></i>
                                        {{ $error }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
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
    @endif

    <!-- Scripts -->
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

        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize mobile menu
            window.mobileMenuOpen = false;

            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.sidebar');

            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });

                // Close sidebar when clicking outside
                document.addEventListener('click', function(e) {
                    if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                        sidebar.classList.remove('show');
                    }
                });
            }

            // Show alert modal on page load if there are messages
            @if(session('success') || session('error') || session('warning') || session('info') || $errors->any())
                showAlertModal();
            @endif
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

    <script src="{{ asset('assets/js/logout-handler.js') }}"></script>
    <script src="{{ asset('assets/js/real-time-service.js') }}"></script>
    @stack('scripts')
</body>
</html>