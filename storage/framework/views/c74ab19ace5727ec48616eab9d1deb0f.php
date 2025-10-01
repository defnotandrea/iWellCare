

<?php $__env->startSection('title', 'View Team Member'); ?>
<?php $__env->startSection('page-title', 'View Team Member'); ?>
<?php $__env->startSection('page-subtitle', 'Team member details'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center">
                <a href="<?php echo e(route('admin.staff.index')); ?>" class="text-gray-400 hover:text-gray-600 mr-4">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Team Member Details</h2>
                    <p class="text-gray-600">View and manage team member information</p>
                </div>
            </div>
        </div>

        <!-- Member Details -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-8 text-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-2xl font-bold"><?php echo e($staff->first_name); ?> <?php echo e($staff->last_name); ?></h3>
                            <p class="text-blue-100">{{ $staff->username }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <?php if($staff->is_active): ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i>
                                Active
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <i class="fas fa-times-circle mr-1"></i>
                                Inactive
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Content Section -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Personal Information -->
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Personal Information</h4>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Full Name</label>
                                <p class="mt-1 text-sm text-gray-900"><?php echo e($staff->first_name); ?> <?php echo e($staff->last_name); ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Username</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $staff->username }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Email Address</label>
                                <p class="mt-1 text-sm text-gray-900"><?php echo e($staff->email); ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Phone Number</label>
                                <p class="mt-1 text-sm text-gray-900"><?php echo e($staff->phone_number); ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Address Information</h4>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Street Address</label>
                                <p class="mt-1 text-sm text-gray-900"><?php echo e($staff->street_address); ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">City</label>
                                <p class="mt-1 text-sm text-gray-900"><?php echo e($staff->city); ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">State/Province</label>
                                <p class="mt-1 text-sm text-gray-900"><?php echo e($staff->state_province); ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Postal Code</label>
                                <p class="mt-1 text-sm text-gray-900"><?php echo e($staff->postal_code); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account Information -->
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Account Information</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Role</label>
                            <p class="mt-1 text-sm text-gray-900"><?php echo e(ucfirst($staff->role)); ?></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Status</label>
                            <p class="mt-1 text-sm text-gray-900">
                                <?php if($staff->is_active): ?>
                                    <span class="text-green-600 font-medium">Active</span>
                                <?php else: ?>
                                    <span class="text-red-600 font-medium">Inactive</span>
                                <?php endif; ?>
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Email Verified</label>
                            <p class="mt-1 text-sm text-gray-900">
                                <?php if($staff->email_verified_at): ?>
                                    <span class="text-green-600 font-medium">Verified</span>
                                <?php else: ?>
                                    <span class="text-red-600 font-medium">Not Verified</span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Timestamps -->
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Account Timeline</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Created At</label>
                            <p class="mt-1 text-sm text-gray-900"><?php echo e($staff->created_at->format('M d, Y \a\t g:i A')); ?></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Last Updated</label>
                            <p class="mt-1 text-sm text-gray-900"><?php echo e($staff->updated_at->format('M d, Y \a\t g:i A')); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex space-x-4">
                            <a href="<?php echo e(route('admin.staff.edit', $staff)); ?>" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fas fa-edit mr-2"></i>
                                Edit Member
                            </a>
                            <form method="POST" action="<?php echo e(route('admin.staff.toggle-status', $staff)); ?>" class="inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white <?php echo e($staff->is_active ? 'bg-red-600 hover:bg-red-700 focus:ring-red-500' : 'bg-green-600 hover:bg-green-700 focus:ring-green-500'); ?> focus:outline-none focus:ring-2 focus:ring-offset-2">
                                    <i class="fas <?php echo e($staff->is_active ? 'fa-user-times' : 'fa-user-check'); ?> mr-2"></i>
                                    <?php echo e($staff->is_active ? 'Deactivate' : 'Activate'); ?>

                                </button>
                            </form>
                        </div>
                        <form method="POST" action="<?php echo e(route('admin.staff.destroy', $staff)); ?>" class="inline" onsubmit="return confirm('Are you sure you want to delete this team member? This action cannot be undone.')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <i class="fas fa-trash mr-2"></i>
                                Delete Member
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\admin\staff\show.blade.php ENDPATH**/ ?>