<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Staff Panel - iWellCare')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/img/icon.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/icon.png') }}">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
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
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
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
        .table-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .table-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem;
        }
        .form-input {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.75rem 1rem;
        }
        .form-input:focus {
            border-color: #059669;
            box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
            outline: none;
        }

        
        /* Fix for modal overlapping issues */
        .modal-backdrop {
            z-index: 1040 !important;
        }
        .modal {
            z-index: 1050 !important;
        }
        .modal-dialog {
            z-index: 1055 !important;
        }
        .modal.show {
            display: block !important;
        }
        .modal.fade.show {
            opacity: 1 !important;
        }
        
        /* Additional modal fixes */
        .modal-content {
            z-index: 1056 !important;
        }
        
        /* Ensure buttons don't overlap */
        .btn {
            position: relative;
            z-index: 1;
        }
        
        /* Fix for any form elements */
        .form-control, .form-select, .form-label {
            position: relative;
            z-index: 1;
        }
        
        /* Fix for inventory modal overlapping with sidebar */
        .sidebar {
            z-index: 1000 !important;
        }
        
        /* Ensure logout button doesn't overlap with modals */
        .sidebar form[action*="logout"] {
            z-index: 1001 !important;
            position: relative;
        }
        
        /* Fix for inventory content overlapping */
        .inventory-content {
            position: relative;
            z-index: 1;
        }
        
        /* Ensure proper stacking for all interactive elements */
        .nav-item {
            z-index: 1002 !important;
        }
        
        /* Fix for any potential form overlaps in inventory */
        .form-input, .form-select {
            position: relative;
        }
        
        /* Fix for sidebar layout and logout positioning */
        .sidebar {
            display: flex;
            flex-direction: column;
        }
        
        .sidebar nav {
            flex: 1;
        }
        
        .sidebar .mt-auto {
            margin-top: auto;
        }
        
                /* Ensure logout button has proper spacing */
        .sidebar form[action*="logout"] {
            margin-top: auto;
        }
        }
        
        /* Fix for prescriptions and other content sections */
        .prescriptions-content,
        .appointments-content,
        .consultations-content,
        .patients-content,
        .billing-content,
        .reports-content,
        .profile-content,
        .dashboard-content {
            position: relative;
            z-index: 1;
        }
        
        /* Ensure main content areas don't overlap */
        .main-content > div {
            position: relative;
            z-index: 1;
        }
        
        /* Fix for any modal content overlapping with other sections */
        .modal-content {
            z-index: 1056 !important;
            position: relative;
        }
        
        /* Ensure proper stacking order for all content sections */
        .card {
            position: relative;
            z-index: 1;
        }
        
        /* Fix for table content overlapping */
        .overflow-x-auto {
            position: relative;
            z-index: 1;
        }

    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar flex flex-col" id="staff-sidebar">
        <!-- Logo Section -->
        <div class="logo-section border-b border-blue-400/20">
            <div class="flex items-center justify-center">
                <div class="relative">
                    <img src="{{ asset('assets/img/iWellCare-logo.png') }}" alt="iWellCare" class="w-32 h-32 object-contain brightness-0 invert filter">
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="p-4 flex-1">
            <nav class="space-y-2">
                <a href="{{ route('staff.dashboard') }}" class="nav-item {{ request()->routeIs('staff.dashboard') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 text-white">
                    <i class="fas fa-tachometer-alt text-lg"></i>
                    <span class="font-medium">Dashboard</span>
                </a>
                
                <a href="{{ route('staff.appointments.index') }}" class="nav-item {{ request()->routeIs('staff.appointments.*') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 text-blue-100 hover:text-white">
                    <i class="fas fa-calendar-check text-lg"></i>
                    <span class="font-medium">Appointments</span>
                </a>
                
                <a href="{{ route('staff.consultations.index') }}" class="nav-item {{ request()->routeIs('staff.consultations.*') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 text-blue-100 hover:text-white">
                    <i class="fas fa-stethoscope text-lg"></i>
                    <span class="font-medium">Consultations</span>
                </a>
                
                <a href="{{ route('staff.patients.index') }}" class="nav-item {{ request()->routeIs('staff.patients.*') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 text-blue-100 hover:text-white">
                    <i class="fas fa-users text-lg"></i>
                    <span class="font-medium">Patients</span>
                </a>
                
                <a href="{{ route('staff.doctor-availability.index') }}" class="nav-item {{ request()->routeIs('staff.doctor-availability.*') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 text-blue-100 hover:text-white">
                    <i class="fas fa-user-check text-lg"></i>
                    <span class="font-medium">Doctor Availability</span>
                </a>
                
                <a href="{{ route('staff.billing.index') }}" class="nav-item {{ request()->routeIs('staff.billing.*') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 text-blue-100 hover:text-white">
                    <i class="fas fa-file-invoice-dollar text-lg"></i>
                    <span class="font-medium">Invoice</span>
                </a>
                
                <a href="{{ route('staff.inventory.index') }}" class="nav-item {{ request()->routeIs('staff.inventory.*') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 text-blue-100 hover:text-white">
                    <i class="fas fa-boxes text-lg"></i>
                    <span class="font-medium">Inventory</span>
                </a>
                
                <a href="{{ route('staff.prescriptions.index') }}" class="nav-item {{ request()->routeIs('staff.prescriptions.*') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 text-blue-100 hover:text-white">
                    <i class="fas fa-pills text-lg"></i>
                    <span class="font-medium">Prescriptions</span>
                </a>
                
                <a href="{{ route('staff.reports.index') }}" class="nav-item {{ request()->routeIs('staff.reports.*') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 text-blue-100 hover:text-white">
                    <i class="fas fa-chart-bar text-lg"></i>
                    <span class="font-medium">Reports</span>
                </a>
                
                <a href="{{ route('staff.profile.index') }}" class="nav-item {{ request()->routeIs('staff.profile.*') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 text-blue-100 hover:text-white">
                    <i class="fas fa-user-cog text-lg"></i>
                    <span class="font-medium">Profile</span>
                </a>
            </nav>
        </div>
        
        <!-- Spacer to ensure logout doesn't overlap -->
        <div class="flex-1"></div>

        <!-- Logout -->
        <div class="mt-auto p-4 border-t border-blue-400/20">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 text-blue-100 hover:text-white hover:bg-red-500/30 rounded-xl group relative overflow-hidden">
                    <i class="fas fa-sign-out-alt text-lg relative z-10"></i>
                    <span class="font-medium relative z-10">Logout</span>
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
                    <h1 class="text-3xl font-bold text-gray-900">@yield('page-title', 'Staff Panel')</h1>
                    <p class="text-gray-600 mt-1">@yield('page-subtitle', 'Welcome to the staff panel')</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="bg-blue-50 px-4 py-2 rounded-lg">
                        <span class="text-blue-600 font-medium">{{ now()->format('l, F j, Y') }}</span>
                    </div>
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-cog text-blue-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <div class="p-8">
            <!-- Session Messages -->
            @if (session('success'))
                <div class="mb-6 bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-blue-400 text-lg mr-3"></i>
                        <span class="text-blue-700 font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-red-400 text-lg mr-3"></i>
                        <span class="text-red-700 font-medium">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Validation Errors -->
            @if (isset($errors) && $errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-red-400 text-lg mr-3"></i>
                        <div>
                            <span class="text-red-700 font-medium">Please fix the following errors:</span>
                            <ul class="text-red-600 text-sm mt-1 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Main Content Area -->
            @yield('content')
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

    @stack('scripts')
</body>
</html>
