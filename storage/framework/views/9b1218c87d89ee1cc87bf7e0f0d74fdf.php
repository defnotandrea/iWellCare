
<?php $__env->startSection('title', 'Profile - iWellCare'); ?>
<?php $__env->startSection('page-title', 'Staff Profile'); ?>
<?php $__env->startSection('page-subtitle', 'Manage your account settings and preferences'); ?>
<?php $__env->startSection('content'); ?>

<?php if(session('success')): ?>
    <div class="bg-green-100 text-green-800 p-4 rounded mb-6 flex items-center gap-2">
        <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Profile Section -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Profile Overview Card -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Profile Overview</h3>
                        <p class="text-sm text-gray-500">Your account information</p>
                    </div>
                </div>
            </div>
            
            <div class="flex items-start gap-6 mb-6">
                <div class="w-24 h-24 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-cog text-white text-3xl"></i>
                </div>
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <h2 class="text-2xl font-bold text-gray-800"><?php echo e($user->first_name ?? 'Staff'); ?> <?php echo e($user->last_name ?? ''); ?></h2>
                        <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-full">
                            <i class="fas fa-shield-alt mr-1"></i> <?php echo e(ucfirst($user->role ?? 'staff')); ?>

                        </span>
                    </div>
                    <div class="text-gray-600 mb-1"><?php echo e($user->email ?? 'staff@email.com'); ?></div>
                    <div class="text-gray-500 text-sm">Username: <?php echo e($user->username ?? 'staffuser'); ?></div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="text-gray-600 font-medium">Full Name</span>
                        <span class="text-gray-800"><?php echo e($user->first_name ?? 'Staff'); ?> <?php echo e($user->last_name ?? ''); ?></span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="text-gray-600 font-medium">Email Address</span>
                        <span class="text-gray-800"><?php echo e($user->email ?? 'staff@email.com'); ?></span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="text-gray-600 font-medium">Username</span>
                        <span class="text-gray-800"><?php echo e($user->username ?? 'staffuser'); ?></span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="text-gray-600 font-medium">Role</span>
                        <span class="text-gray-800 capitalize"><?php echo e($user->role ?? 'staff'); ?></span>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="text-gray-600 font-medium">Account Status</span>
                        <span class="inline-flex items-center px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full">
                            <i class="fas fa-check-circle mr-1"></i> Active
                        </span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="text-gray-600 font-medium">Member Since</span>
                        <span class="text-gray-800"><?php echo e($user->created_at ? $user->created_at->format('M d, Y') : 'N/A'); ?></span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="text-gray-600 font-medium">Last Login</span>
                        <span class="text-gray-800"><?php echo e($user->last_login_at ? \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() : 'Never'); ?></span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="text-gray-600 font-medium">Profile Updated</span>
                        <span class="text-gray-800"><?php echo e($user->updated_at ? $user->updated_at->format('M d, Y') : 'N/A'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-8">
        <!-- Account Status Card -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-shield-alt text-green-600 text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Account Status</h3>
                        <p class="text-sm text-gray-500">Security overview</p>
                    </div>
                </div>
            </div>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-green-600 text-sm"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Account Active</span>
                    </div>
                    <span class="text-xs text-green-600 bg-green-100 px-2 py-1 rounded-full">Verified</span>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-clock text-blue-600 text-sm"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Last Login</span>
                    </div>
                    <span class="text-xs text-blue-600"><?php echo e($user->last_login_at ? \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() : 'Never'); ?></span>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-calendar text-yellow-600 text-sm"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Member Since</span>
                    </div>
                    <span class="text-xs text-yellow-600"><?php echo e($user->created_at ? $user->created_at->format('M d') : 'N/A'); ?></span>
                </div>
            </div>
        </div>

        <!-- Danger Zone Card -->
        <div class="card p-6 border border-red-200 bg-red-50">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-red-600 text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-red-800">Danger Zone</h3>
                        <p class="text-sm text-red-600">Irreversible actions</p>
                    </div>
                </div>
            </div>
            
            <div class="space-y-4">
                <div class="p-4 bg-white rounded-lg border border-red-200">
                    <div class="flex items-start justify-between">
                        <div>
                            <h4 class="font-semibold text-red-800 mb-1">Delete Account</h4>
                            <p class="text-sm text-red-600 mb-3">Permanently delete your account and all associated data. This action cannot be undone.</p>
                        </div>
                    </div>
                    <form action="<?php echo e(route('staff.profile.destroy')); ?>" method="POST" onsubmit="return confirm('Are you absolutely sure you want to delete your account? This action cannot be undone and will permanently remove all your data.');">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger w-full flex items-center justify-center gap-2">
                            <i class="fas fa-trash"></i> Delete Account
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.staff', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\staff\profile\index.blade.php ENDPATH**/ ?>