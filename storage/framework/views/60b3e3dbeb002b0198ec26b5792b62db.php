

<?php $__env->startSection('title', 'Forgot Password - iWellCare'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <!-- Main Card with Gradient Background -->
        <div class="card p-8" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 20px; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);">
            <div class="text-center mb-8">
                <!-- Icon with gradient background -->
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-white/20 backdrop-blur-sm mb-6">
                    <i class="fas fa-key text-white text-2xl"></i>
                </div>
                <h2 class="text-3xl font-bold text-white mb-2">
                    Forgot Password
                </h2>
                <p class="text-blue-100 text-sm">
                    Enter your email address and we'll send you a verification code to reset your password.
                </p>
            </div>

            <?php if(session('status')): ?>
                <div class="mb-6 bg-green-500/20 backdrop-blur-sm border border-green-500/30 rounded-xl p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-300 text-lg"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-100">
                                <?php echo e(session('status')); ?>

                            </p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(session('info')): ?>
                <div class="mb-6 bg-blue-500/20 backdrop-blur-sm border border-blue-500/30 rounded-xl p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-300 text-lg"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-100">
                                <?php echo e(session('info')); ?>

                            </p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('password.email')); ?>" class="space-y-6">
                <?php echo csrf_field(); ?>

                <div>
                    <label for="email" class="block text-sm font-medium text-blue-100 mb-2">
                        Email Address
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-blue-200"></i>
                        </div>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="<?php echo e(old('email')); ?>" 
                               placeholder="Enter your email address"
                               required 
                               autofocus
                               class="w-full pl-10 pr-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-white/50 backdrop-blur-sm <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    </div>
                    <?php $__errorArgs = ['email'];
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
                </div>

                <div>
                    <button type="submit" 
                            class="w-full bg-white/20 hover:bg-white/30 text-white font-semibold py-3 px-6 rounded-xl backdrop-blur-sm border border-white/20">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Send Reset Code
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-blue-100">
                    Remember your password? 
                    <a href="<?php echo e(route('login')); ?>" class="text-white hover:text-blue-200 focus:outline-none focus:underline font-medium">
                        <i class="fas fa-sign-in-alt mr-1"></i>
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
                            <span class="font-semibold">Note:</span> The reset code will be sent to your email address and will expire in 10 minutes.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\auth\passwords\email.blade.php ENDPATH**/ ?>