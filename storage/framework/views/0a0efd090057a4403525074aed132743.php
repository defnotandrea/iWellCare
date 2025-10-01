

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <!-- Main Card with Gradient Background -->
        <div class="card p-8" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 20px; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);">
            <div class="text-center mb-8">
                <!-- Icon with gradient background -->
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-white/20 backdrop-blur-sm mb-6">
                    <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-white mb-2">
                    Email Verification
                </h2>
                <?php if($email): ?>
                    <p class="text-blue-100 text-sm">
                        We've sent a 6-digit verification code to:<br>
                        <span class="font-semibold text-white"><?php echo e($email); ?></span>
                    </p>
                <?php else: ?>
                    <p class="text-blue-100 text-sm">
                        Enter your email address to receive a verification code.
                    </p>
                <?php endif; ?>
            </div>

            <?php if(!$email): ?>
                <!-- Email Input Form -->
                <form id="emailForm" class="space-y-6">
                    <?php echo csrf_field(); ?>
                    <div>
                        <label for="email" class="block text-sm font-medium text-blue-100 mb-2">
                            Email Address
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-blue-200"></i>
                            </div>
                            <input id="email" name="email" type="email" required 
                                   class="w-full pl-10 pr-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-white/50 backdrop-blur-sm"
                                   placeholder="Enter your email address">
                        </div>
                    </div>

                    <div>
                        <button type="submit" id="sendOtpBtn"
                                class="w-full bg-white/20 hover:bg-white/30 text-white font-semibold py-3 px-6 rounded-xl backdrop-blur-sm border border-white/20">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Send Verification Code
                        </button>
                    </div>
                </form>
            <?php else: ?>
                <!-- OTP Verification Form -->
                <form id="otpForm" class="space-y-6">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="email" value="<?php echo e($email); ?>">
                    
                    <div>
                        <label for="code" class="block text-sm font-medium text-blue-100 mb-2">
                            Enter Verification Code
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-key text-blue-200"></i>
                            </div>
                            <input id="code" name="code" type="text" required maxlength="6"
                                   class="w-full pl-10 pr-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-white/50 backdrop-blur-sm text-center text-2xl font-mono tracking-widest"
                                   placeholder="000000" autocomplete="off">
                        </div>
                    </div>

                    <div>
                        <button type="submit" id="verifyBtn"
                                class="w-full bg-white/20 hover:bg-white/30 text-white font-semibold py-3 px-6 rounded-xl backdrop-blur-sm border border-white/20">
                            <i class="fas fa-check mr-2"></i>
                            Verify Email
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-blue-100 mb-3">Didn't receive the code?</p>
                    <button type="button" id="resendBtn"
                            class="text-sm text-white hover:text-blue-200 focus:outline-none focus:underline">
                        <i class="fas fa-redo mr-1"></i>
                        Resend Code
                    </button>
                </div>
            <?php endif; ?>

            <!-- Info Card -->
            <div class="mt-6 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-200 text-lg"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-100">
                            <span class="font-semibold">Note:</span> The verification code will expire in 10 minutes.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Modal with Gradient -->
<div id="loadingModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-8 border w-96 shadow-2xl rounded-2xl" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-white/20 mb-6">
                <svg class="h-8 w-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-white" id="loadingMessage">
                Verifying your email...
            </h3>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let resendTimer = 60;
    let resendInterval;
    
    <?php if($email): ?>
        // Auto-focus on code input
        document.getElementById('code').focus();
        
        // Handle OTP form submission
        document.getElementById('otpForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            document.getElementById('loadingMessage').textContent = 'Verifying your email...';
            document.getElementById('loadingModal').classList.remove('hidden');
            
            fetch('<?php echo e(route("otp.verify")); ?>', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('loadingModal').classList.add('hidden');
                
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Email Verified!',
                        text: data.message,
                        confirmButtonText: 'Continue',
                        background: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                        color: '#fff',
                        confirmButtonColor: 'rgba(255, 255, 255, 0.2)',
                        backdrop: 'rgba(0, 0, 0, 0.4)'
                    }).then((result) => {
                        window.location.href = data.redirect || '<?php echo e(route("home")); ?>';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Verification Failed',
                        text: data.message,
                        background: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                        color: '#fff',
                        confirmButtonColor: 'rgba(255, 255, 255, 0.2)',
                        backdrop: 'rgba(0, 0, 0, 0.4)'
                    });
                }
            })
            .catch(error => {
                document.getElementById('loadingModal').classList.add('hidden');
                
                Swal.fire({
                    icon: 'error',
                    title: 'Verification Failed',
                    text: 'An error occurred. Please try again.',
                    background: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                    color: '#fff',
                    confirmButtonColor: 'rgba(255, 255, 255, 0.2)',
                    backdrop: 'rgba(0, 0, 0, 0.4)'
                });
            });
        });
        
        // Handle resend OTP
        document.getElementById('resendBtn').addEventListener('click', function() {
            const email = '<?php echo e($email); ?>';
            
            document.getElementById('loadingMessage').textContent = 'Sending verification code...';
            document.getElementById('loadingModal').classList.remove('hidden');
            
            fetch('<?php echo e(route("otp.resend")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    email: email
                })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('loadingModal').classList.add('hidden');
                
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Code Sent!',
                        text: data.message,
                        background: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                        color: '#fff',
                        confirmButtonColor: 'rgba(255, 255, 255, 0.2)',
                        backdrop: 'rgba(0, 0, 0, 0.4)'
                    });
                    
                    // Start resend timer
                    startResendTimer();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed to Send Code',
                        text: data.message,
                        background: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                        color: '#fff',
                        confirmButtonColor: 'rgba(255, 255, 255, 0.2)',
                        backdrop: 'rgba(0, 0, 0, 0.4)'
                    });
                }
            })
            .catch(error => {
                document.getElementById('loadingModal').classList.add('hidden');
                
                Swal.fire({
                    icon: 'error',
                    title: 'Failed to Send Code',
                    text: 'Failed to send verification code.',
                    background: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                    color: '#fff',
                    confirmButtonColor: 'rgba(255, 255, 255, 0.2)',
                    backdrop: 'rgba(0, 0, 0, 0.4)'
                });
            });
        });
        
        // Start resend timer
        startResendTimer();
        
        function startResendTimer() {
            resendTimer = 60;
            const resendBtn = document.getElementById('resendBtn');
            resendBtn.disabled = true;
            
            resendInterval = setInterval(function() {
                resendTimer--;
                resendBtn.textContent = `Resend Code (${resendTimer}s)`;
                
                if (resendTimer <= 0) {
                    clearInterval(resendInterval);
                    resendBtn.disabled = false;
                    resendBtn.innerHTML = '<i class="fas fa-redo mr-1"></i>Resend Code';
                }
            }, 1000);
        }
    <?php else: ?>
        // Handle email form submission
        document.getElementById('emailForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            document.getElementById('loadingMessage').textContent = 'Sending verification code...';
            document.getElementById('loadingModal').classList.remove('hidden');
            
            fetch('<?php echo e(route("otp.send")); ?>', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('loadingModal').classList.add('hidden');
                
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Code Sent!',
                        text: data.message,
                        confirmButtonText: 'Continue',
                        background: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                        color: '#fff',
                        confirmButtonColor: 'rgba(255, 255, 255, 0.2)',
                        backdrop: 'rgba(0, 0, 0, 0.4)'
                    }).then((result) => {
                        // Reload the page to show the OTP form
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed to Send Code',
                        text: data.message,
                        background: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                        color: '#fff',
                        confirmButtonColor: 'rgba(255, 255, 255, 0.2)',
                        backdrop: 'rgba(0, 0, 0, 0.4)'
                    });
                }
            })
            .catch(error => {
                document.getElementById('loadingModal').classList.add('hidden');
                
                Swal.fire({
                    icon: 'error',
                    title: 'Failed to Send Code',
                    text: 'Failed to send verification code.',
                    background: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                    color: '#fff',
                    confirmButtonColor: 'rgba(255, 255, 255, 0.2)',
                    backdrop: 'rgba(0, 0, 0, 0.4)'
                });
            });
        });
    <?php endif; ?>
    
    // Format OTP input
    const codeInput = document.getElementById('code');
    if (codeInput) {
        codeInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    }
});
</script>
<?php $__env->stopPush(); ?> 
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\auth\verify-otp.blade.php ENDPATH**/ ?>