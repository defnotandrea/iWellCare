

<?php $__env->startSection('title', 'Reset Password - iWellCare'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <!-- Main Card with Gradient Background -->
        <div class="card p-8" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 20px; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);">
            <div class="text-center mb-8">
                <!-- Icon with gradient background -->
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-white/20 backdrop-blur-sm mb-6">
                    <i class="fas fa-lock text-white text-2xl"></i>
                </div>
                <h2 class="text-3xl font-bold text-white mb-2">
                    Reset Password
                </h2>
                <p class="text-blue-100 text-sm">
                    <?php if(session('otp_verified')): ?>
                        Enter your new password below.
                    <?php else: ?>
                        Please enter the verification code sent to your email.
                    <?php endif; ?>
                </p>
            </div>

            <?php if(session('success')): ?>
                <div class="mb-6 bg-green-500/20 backdrop-blur-sm border border-green-500/30 rounded-xl p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-300 text-lg"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-100">
                                <?php echo e(session('success')); ?>

                            </p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="mb-6 bg-red-500/20 backdrop-blur-sm border border-red-500/30 rounded-xl p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-red-300 text-lg"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-100">
                                <?php echo e(session('error')); ?>

                            </p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(!session('otp_verified')): ?>
                <!-- OTP Verification Form -->
                <form method="POST" action="<?php echo e(route('password.verify-otp')); ?>" id="otpForm" class="space-y-6">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="email" value="<?php echo e($email ?? ''); ?>">

                    <div>
                        <label for="otp" class="block text-sm font-medium text-blue-100 mb-2">
                            Verification Code
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-key text-blue-200"></i>
                            </div>
                            <input type="text" 
                                   id="otp" 
                                   name="otp" 
                                   placeholder="Enter 6-digit code"
                                   maxlength="6"
                                   pattern="[0-9]{6}"
                                   required 
                                   autofocus
                                   class="w-full pl-10 pr-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-white/50 backdrop-blur-sm text-center text-2xl font-mono tracking-widest <?php $__errorArgs = ['otp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        </div>
                        <?php $__errorArgs = ['otp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-300">
                                <?php echo e($message); ?>

                            </p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <p class="mt-2 text-sm text-blue-200">
                            Enter the 6-digit verification code sent to your email.
                        </p>
                    </div>

                    <div>
                        <button type="submit" 
                                class="w-full bg-white/20 hover:bg-white/30 text-white font-semibold py-3 px-6 rounded-xl backdrop-blur-sm border border-white/20">
                            <i class="fas fa-check mr-2"></i>
                            Verify Code
                        </button>
                    </div>

                    <div class="text-center">
                        <button type="button" 
                                id="resendOtpBtn" 
                                disabled
                                class="text-sm text-white hover:text-blue-200 focus:outline-none focus:underline disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="fas fa-redo mr-1"></i>
                            Resend Code (<span id="resendTimer">60</span>s)
                        </button>
                    </div>
                </form>
            <?php else: ?>
                <!-- Password Reset Form -->
                <form method="POST" action="<?php echo e(route('password.update')); ?>" class="space-y-6">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="email" value="<?php echo e($email ?? ''); ?>">

                    <div>
                        <label for="password" class="block text-sm font-medium text-blue-100 mb-2">
                            New Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-blue-200"></i>
                            </div>
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Enter new password"
                                   required 
                                   autofocus
                                   class="w-full pl-10 pr-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-white/50 backdrop-blur-sm <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        </div>
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-300">
                                <?php echo e($message); ?>

                            </p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <p class="mt-2 text-sm text-blue-200">
                            Password must be at least 8 characters long.
                        </p>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-blue-100 mb-2">
                            Confirm New Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-blue-200"></i>
                            </div>
                            <input type="password" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   placeholder="Confirm new password"
                                   required
                                   class="w-full pl-10 pr-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-white/50 backdrop-blur-sm">
                        </div>
                    </div>

                    <div>
                        <button type="submit" 
                                class="w-full bg-green-500/20 hover:bg-green-500/30 text-white font-semibold py-3 px-6 rounded-xl backdrop-blur-sm border border-green-500/30">
                            <i class="fas fa-save mr-2"></i>
                            Reset Password
                        </button>
                    </div>
                </form>
            <?php endif; ?>

            <div class="mt-6 text-center">
                <p class="text-sm text-blue-100">
                    <a href="<?php echo e(route('login')); ?>" class="text-white hover:text-blue-200 focus:outline-none focus:underline font-medium">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Back to Login
                    </a>
                </p>
            </div>

            <!-- Info Card -->
            <div class="mt-6 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-200 text-lg"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-100">
                            <span class="font-semibold">Note:</span> 
                            <?php if(!session('otp_verified')): ?>
                                The verification code will expire in 10 minutes.
                            <?php else: ?>
                                Make sure to choose a strong password that you can remember.
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if(!session('otp_verified')): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const otpInput = document.getElementById('otp');
    const resendBtn = document.getElementById('resendOtpBtn');
    const resendTimer = document.getElementById('resendTimer');
    let countdown = 60;

    // Auto-format OTP input
    otpInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 6) {
            value = value.substring(0, 6);
        }
        e.target.value = value;
    });

    // Start countdown timer
    function startCountdown() {
        resendBtn.disabled = true;
        countdown = 60;
        
        const timer = setInterval(() => {
            countdown--;
            resendTimer.textContent = countdown;
            
            if (countdown <= 0) {
                clearInterval(timer);
                resendBtn.disabled = false;
                resendBtn.innerHTML = '<i class="fas fa-redo mr-1"></i>Resend Code';
            }
        }, 1000);
    }

    // Handle resend OTP
    resendBtn.addEventListener('click', function() {
        const email = document.querySelector('input[name="email"]').value;
        
        fetch('<?php echo e(route("password.resend-otp")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ email: email })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message using SweetAlert2
                Swal.fire({
                    icon: 'success',
                    title: 'Code Sent!',
                    text: data.message,
                    background: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                    color: '#fff',
                    confirmButtonColor: 'rgba(255, 255, 255, 0.2)',
                    backdrop: 'rgba(0, 0, 0, 0.4)'
                });
                
                // Start countdown again
                startCountdown();
            } else {
                // Show error message using SweetAlert2
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
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to send verification code.',
                background: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                color: '#fff',
                confirmButtonColor: 'rgba(255, 255, 255, 0.2)',
                backdrop: 'rgba(0, 0, 0, 0.4)'
            });
        });
    });

    // Start initial countdown
    startCountdown();
});
</script>
<?php endif; ?>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\auth\passwords\reset.blade.php ENDPATH**/ ?>