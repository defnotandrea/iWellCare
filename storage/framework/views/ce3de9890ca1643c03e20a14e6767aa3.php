
<?php $__env->startSection('title', 'Edit Profile - iWellCare'); ?>
<?php $__env->startSection('page-title', 'Edit Profile'); ?>
<?php $__env->startSection('page-subtitle', 'Update your staff information'); ?>
<?php $__env->startSection('content'); ?>
<div class="profile-content">
    <div class="card p-6 max-w-xl mx-auto">
        <?php if($errors->any()): ?>
            <div class="bg-red-100 text-red-800 p-2 rounded mb-4">
                <ul class="list-disc pl-5">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>
        <form action="<?php echo e(route('staff.profile.update')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">First Name</label>
                <input type="text" name="first_name" class="form-input w-full" value="<?php echo e(old('first_name', $user->first_name)); ?>" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Last Name</label>
                <input type="text" name="last_name" class="form-input w-full" value="<?php echo e(old('last_name', $user->last_name)); ?>" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Email</label>
                <input type="email" name="email" class="form-input w-full" value="<?php echo e(old('email', $user->email)); ?>" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Username</label>
                <input type="text" name="username" class="form-input w-full" value="<?php echo e(old('username', $user->username)); ?>" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Password</label>
                <input type="password" name="password" class="form-input w-full" placeholder="Leave blank to keep current password">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="<?php echo e(route('staff.profile.index')); ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.staff', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\staff\profile\edit.blade.php ENDPATH**/ ?>