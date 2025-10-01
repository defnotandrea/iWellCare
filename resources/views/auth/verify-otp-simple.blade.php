<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Email Verification - iWellCare</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/img/icon.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/icon.png') }}">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="{{ asset('assets/js/modal-utils.js') }}"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Main Card -->
            <div class="bg-white rounded-xl shadow-2xl border border-gray-200 p-8">
                <div class="text-center mb-8">
                    <!-- Icon -->
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-blue-100 mb-6">
                        <i class="fas fa-envelope text-blue-600 text-2xl"></i>
                    </div>
                    
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">
                        Email Verification
                    </h2>
                    
                    @if($email)
                        <p class="text-gray-600 text-sm">
                            We've sent a 6-digit verification code to:<br>
                            <span class="font-semibold text-gray-900">{{ $email }}</span>
                        </p>
                    @else
                        <p class="text-gray-600 text-sm">
                            Enter your email address to receive a verification code.
                        </p>
                    @endif
                </div>

                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-500 text-lg"></i>
                            </div>
                            <div class="ml-3">
                                <div class="text-sm text-red-800">
                                    @foreach($errors->all() as $error)
                                        <p class="mb-1">{{ $error }}</p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('otp_code'))
                    <!-- OTP Code Display (Fallback) -->
                    <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-key text-yellow-600 text-lg"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">
                                    Email Sending Failed - Use This Code
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-yellow-700 mb-2">
                                        Your verification code is:
                                    </p>
                                    <div class="bg-yellow-100 border border-yellow-300 rounded-lg p-3 text-center">
                                        <span class="text-2xl font-bold text-yellow-800 font-mono tracking-widest">
                                            {{ session('otp_code') }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-yellow-600 mt-2">
                                        This code will expire in 10 minutes.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(!$email)
                    <!-- Email Input Form -->
                    <form method="POST" action="{{ route('otp.send') }}" class="space-y-6">
                        @csrf
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Address
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input id="email" name="email" type="email" required 
                                       class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Enter your email address">
                            </div>
                        </div>

                        <div>
                            <button type="submit" 
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Send Verification Code
                            </button>
                        </div>
                    </form>
                @else
                    <!-- OTP Verification Form -->
                    <form method="POST" action="{{ route('otp.verify') }}" class="space-y-6">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}">
                        
                        <div>
                            <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                                Enter Verification Code
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-key text-gray-400"></i>
                                </div>
                                <input id="code" name="code" type="text" required maxlength="6"
                                       class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-center text-2xl font-mono tracking-widest"
                                       placeholder="000000" autocomplete="off">
                            </div>
                        </div>

                        <div>
                            <button type="submit" 
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg">
                                <i class="fas fa-check mr-2"></i>
                                Verify Email
                            </button>
                        </div>
                    </form>

                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-600 mb-3">Didn't receive the code?</p>
                        <form method="POST" action="{{ route('otp.resend') }}" class="inline" id="resendForm">
                            @csrf
                            <input type="hidden" name="email" value="{{ $email }}">
                            <button type="submit" 
                                    class="text-sm text-blue-600 hover:text-blue-800 focus:outline-none focus:underline"
                                    id="resendBtn">
                                <i class="fas fa-redo mr-1"></i>
                                Resend Code
                            </button>
                        </form>
                    </div>
                @endif

                <!-- Info Card -->
                <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-500 text-lg"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                <span class="font-semibold">Note:</span> The verification code will expire in 10 minutes.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Simple form validation
        document.addEventListener('DOMContentLoaded', function() {
            const codeInput = document.getElementById('code');
            if (codeInput) {
                codeInput.addEventListener('input', function() {
                    this.value = this.value.replace(/[^0-9]/g, '');
                });
            }

            // Handle OTP verification form submission
            const otpForm = document.querySelector('form[action="{{ route("otp.verify") }}"]');
            if (otpForm) {
                otpForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    const submitBtn = this.querySelector('button[type="submit"]');
                    const originalText = submitBtn.innerHTML;
                    
                    // Show loading state
                    submitBtn.innerHTML = '<i class="fas fa-spinner mr-2"></i>Verifying...';
                    submitBtn.disabled = true;
                    
                    fetch('{{ route("otp.verify") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show success modal
                            showSuccessModal(data.message, data.redirect);
                        } else {
                            // Show error message
                            showError(data.message);
                            submitBtn.innerHTML = originalText;
                            submitBtn.disabled = false;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showError('An error occurred. Please try again.');
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    });
                });
            }
        });

        function showSuccessModal(message, redirectUrl) {
            // Create modal HTML
            const modalHTML = `
                <div id="successModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                        <div class="mt-3 text-center">
                            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                                <i class="fas fa-check text-green-600 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Success!</h3>
                            <div class="mt-2 px-7 py-3">
                                <p class="text-sm text-gray-500">${message}</p>
                            </div>
                            <div class="items-center px-4 py-3">
                                <button id="redirectBtn" class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-colors duration-200">
                                    <i class="fas fa-sign-in-alt mr-2"></i>Go to Login
                                </button>
                                <p class="text-xs text-gray-500 mt-2">You'll be redirected to the home page after login</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // Add modal to page
            document.body.insertAdjacentHTML('beforeend', modalHTML);
            
            // Handle redirect button click
            document.getElementById('redirectBtn').addEventListener('click', function() {
                window.location.href = redirectUrl;
            });
            
            // Auto redirect after 3 seconds
            setTimeout(() => {
                window.location.href = redirectUrl;
            }, 3000);
        }

        function showError(message) {
            // Create error notification
            const errorHTML = `
                <div id="errorNotification" class="fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded z-50 max-w-sm">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <span class="text-sm">${message}</span>
                        <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-red-700 hover:text-red-900">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            `;
            
            // Remove existing error notifications
            const existingError = document.getElementById('errorNotification');
            if (existingError) {
                existingError.remove();
            }
            
            // Add new error notification
            document.body.insertAdjacentHTML('beforeend', errorHTML);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                const errorNotif = document.getElementById('errorNotification');
                if (errorNotif) {
                    errorNotif.remove();
                }
            }, 5000);
        }

        // Handle resend form submission
        document.getElementById('resendForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const resendBtn = document.getElementById('resendBtn');
            const originalText = resendBtn.innerHTML;

            // Disable button and show loading
            resendBtn.disabled = true;
            resendBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Resending...';

            const formData = new FormData(this);

            fetch('{{ route("otp.resend") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showSuccess(data.message);
                    // Reset countdown if there was one
                    clearInterval(countdownInterval);
                    startResendCountdown(30);
                } else {
                    if (data.fallback && data.code) {
                        // Show fallback OTP code
                        showFallbackOtp(data.code);
                        // Still start countdown since we sent something
                        startResendCountdown(30);
                    } else if (data.remaining_time) {
                        // Rate limited, show countdown
                        showError(data.message);
                        startResendCountdown(data.remaining_time);
                    } else {
                        showError(data.message);
                        // Re-enable button immediately on error
                        resendBtn.innerHTML = originalText;
                        resendBtn.disabled = false;
                        return;
                    }
                }
                // Only re-enable if not showing countdown
                if (!data.remaining_time) {
                    resendBtn.innerHTML = originalText;
                    resendBtn.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                let errorMessage = 'An error occurred. Please try again.';
                if (error.response) {
                    console.error('Response status:', error.response.status);
                    console.error('Response data:', error.response.data);
                    if (error.response.status === 419) {
                        errorMessage = 'Session expired. Please refresh the page and try again.';
                    } else if (error.response.status === 500) {
                        errorMessage = 'Server error. Please try again later.';
                    }
                }
                showError(errorMessage);
                resendBtn.innerHTML = originalText;
                resendBtn.disabled = false;
            });
        });

        let countdownInterval;

        function startResendCountdown(seconds) {
            const resendBtn = document.getElementById('resendBtn');
            let timeLeft = seconds;

            resendBtn.disabled = true;
            resendBtn.innerHTML = `<i class="fas fa-clock mr-1"></i>Wait ${timeLeft}s`;

            countdownInterval = setInterval(() => {
                timeLeft--;
                resendBtn.innerHTML = `<i class="fas fa-clock mr-1"></i>Wait ${timeLeft}s`;

                if (timeLeft <= 0) {
                    clearInterval(countdownInterval);
                    resendBtn.innerHTML = '<i class="fas fa-redo mr-1"></i>Resend Code';
                    resendBtn.disabled = false;
                }
            }, 1000);
        }

        function showFallbackOtp(code) {
            const fallbackHTML = `
                <div id="fallbackNotification" class="fixed top-4 right-4 z-50 max-w-sm">
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 shadow-lg">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-key text-yellow-600 text-lg"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">
                                    Email Failed - Use This Code
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-yellow-700 mb-2">
                                        Your verification code is:
                                    </p>
                                    <div class="bg-yellow-100 border border-yellow-300 rounded-lg p-3 text-center">
                                        <span class="text-2xl font-bold text-yellow-800 font-mono tracking-widest">
                                            ${code}
                                        </span>
                                    </div>
                                    <p class="text-xs text-yellow-600 mt-2">
                                        This code will expire in 10 minutes.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            document.body.insertAdjacentHTML('beforeend', fallbackHTML);
            
            // Auto remove after 30 seconds
            setTimeout(() => {
                const fallbackNotif = document.getElementById('fallbackNotification');
                if (fallbackNotif) {
                    fallbackNotif.remove();
                }
            }, 30000);
        }
    </script>
</body>
</html> 