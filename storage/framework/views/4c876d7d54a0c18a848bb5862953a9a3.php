

<?php $__env->startSection('title', 'Edit Doctor Availability - iWellCare'); ?>
<?php $__env->startSection('page-title', 'Edit Doctor Availability'); ?>
<?php $__env->startSection('page-subtitle', 'Modify doctor availability settings'); ?>

<?php $__env->startSection('content'); ?>
<div class="doctor-availability-content">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Edit Doctor Availability</h2>
            <p class="text-gray-600">Modify the doctor's availability settings</p>
        </div>
        <a href="<?php echo e(route('staff.doctor-availability.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Back to Availability
        </a>
    </div>

    <div class="card p-6 max-w-2xl mx-auto">
        <?php if($errors->any()): ?>
            <div class="bg-red-100 text-red-800 p-4 rounded mb-6">
                <ul class="list-disc list-inside">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('staff.doctor-availability.update', $availability->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="space-y-6">
                <!-- Doctor Selection -->
                <div>
                    <label for="doctor_id" class="block text-sm font-medium text-gray-700 mb-2">Select Doctor *</label>
                    <select name="doctor_id" id="doctor_id" class="form-input w-full" required>
                        <option value="">Choose a doctor...</option>
                        <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($doctor->id); ?>" <?php echo e(old('doctor_id', $availability->doctor_id) == $doctor->id ? 'selected' : ''); ?>>
                                Dr. <?php echo e($doctor->user->first_name ?? 'N/A'); ?> <?php echo e($doctor->user->last_name ?? ''); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <!-- Date Selection -->
                <div>
                    <label for="availability_date" class="block text-sm font-medium text-gray-700 mb-2">Availability Date *</label>
                    <input type="date" name="availability_date" id="availability_date"
                           value="<?php echo e(old('availability_date', $availability->availability_date)); ?>"
                           class="form-input w-full" required>
                    <p class="text-sm text-gray-500 mt-1">Select the date when the doctor will be available</p>
                </div>

                <!-- Time Range -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">Start Time *</label>
                        <input type="time" name="start_time" id="start_time"
                               value="<?php echo e(old('start_time', $availability->start_time)); ?>"
                               class="form-input w-full" required>
                    </div>
                    <div>
                        <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">End Time *</label>
                        <input type="time" name="end_time" id="end_time"
                               value="<?php echo e(old('end_time', $availability->end_time)); ?>"
                               class="form-input w-full" required>
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Availability Status *</label>
                    <select name="status" id="status" class="form-input w-full" required>
                        <option value="available" <?php echo e(old('status', $availability->status) === 'available' ? 'selected' : ''); ?>>Available</option>
                        <option value="unavailable" <?php echo e(old('status', $availability->status) === 'unavailable' ? 'selected' : ''); ?>>Unavailable</option>
                        <option value="on_leave" <?php echo e(old('status', $availability->status) === 'on_leave' ? 'selected' : ''); ?>>On Leave</option>
                    </select>
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                    <textarea name="notes" id="notes" rows="3"
                              class="form-input w-full"
                              placeholder="Any additional notes about availability..."><?php echo e(old('notes', $availability->notes)); ?></textarea>
                </div>
            </div>

            <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-gray-200">
                <a href="<?php echo e(route('staff.doctor-availability.index')); ?>" class="btn btn-secondary">
                    <i class="fas fa-times mr-2"></i>Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>Update Availability
                </button>
            </div>
        </form>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validate time inputs
    const startTime = document.getElementById('start_time');
    const endTime = document.getElementById('end_time');

    function validateTime() {
        if (startTime.value && endTime.value) {
            if (startTime.value >= endTime.value) {
                endTime.setCustomValidity('End time must be after start time');
            } else {
                endTime.setCustomValidity('');
            }
        }
    }

    startTime.addEventListener('change', validateTime);
    endTime.addEventListener('change', validateTime);
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.staff', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\staff\doctor-availability\edit.blade.php ENDPATH**/ ?>