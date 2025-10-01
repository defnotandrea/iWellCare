<?php $__env->startSection('title', 'Set Doctor Availability - iWellCare'); ?>
<?php $__env->startSection('page-title', 'Set Doctor Availability'); ?>
<?php $__env->startSection('page-subtitle', 'Set doctor availability for appointments'); ?>

<?php $__env->startSection('content'); ?>
<div class="doctor-availability-content">
    <div class="flex justify-end items-center mb-6">
        <a href="<?php echo e(route('staff.doctor-availability.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Back to Availability
        </a>
    </div>

    <div class="card p-6 max-w-4xl mx-auto">
        <?php if($errors->any()): ?>
            <div class="bg-red-100 text-red-800 p-4 rounded mb-6">
                <ul class="list-disc list-inside">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Single Date Setup -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Set Single Date Availability</h3>
            <form action="<?php echo e(route('staff.doctor-availability.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Doctor Selection -->
                    <div>
                        <label for="doctor_id" class="block text-sm font-medium text-gray-700 mb-2">Select Doctor *</label>
                        <select name="doctor_id" id="doctor_id" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" required>
                            <option value="">Choose a doctor...</option>
                            <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($doctor->id); ?>" <?php echo e(old('doctor_id') == $doctor->id ? 'selected' : (!old('doctor_id') && $loop->first ? 'selected' : '')); ?>>
                                    Dr. <?php echo e($doctor->user->first_name ?? 'N/A'); ?> <?php echo e($doctor->user->last_name ?? ''); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- Date Selection -->
                    <div>
                        <label for="availability_date" class="block text-sm font-medium text-gray-700 mb-2">Availability Date *</label>
                        <input type="date" name="availability_date" id="availability_date"
                               value="<?php echo e(old('availability_date')); ?>"
                               class="form-input w-full" required min="<?php echo e(date('Y-m-d')); ?>">
                        <p class="text-sm text-gray-500 mt-1">Select the date when the doctor will be available</p>
                    </div>

                    <!-- Time Range -->
                    <div>
                        <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">Start Time *</label>
                        <input type="time" name="start_time" id="start_time"
                               value="<?php echo e(old('start_time', '09:00')); ?>"
                               class="form-input w-full" required>
                    </div>
                    <div>
                        <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">End Time *</label>
                        <input type="time" name="end_time" id="end_time"
                               value="<?php echo e(old('end_time', '17:00')); ?>"
                               class="form-input w-full" required>
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Availability Status *</label>
                        <select name="status" id="status" class="form-input w-full" required>
                            <option value="available" <?php echo e(old('status') === 'available' ? 'selected' : ''); ?>>Available</option>
                            <option value="unavailable" <?php echo e(old('status') === 'unavailable' ? 'selected' : ''); ?>>Unavailable</option>
                            <option value="on_leave" <?php echo e(old('status') === 'on_leave' ? 'selected' : ''); ?>>On Leave</option>
                        </select>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                        <textarea name="notes" id="notes" rows="3"
                                  class="form-input w-full"
                                  placeholder="Any additional notes about availability..."><?php echo e(old('notes')); ?></textarea>
                    </div>
                </div>
                
                <div class="flex justify-end gap-4 mt-6 pt-4 border-t border-gray-200">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i>Set Availability
                    </button>
                </div>
            </form>
        </div>

        <!-- Bulk Setup Section -->
        <div class="border-t border-gray-200 pt-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Setup</h3>
            <p class="text-gray-600 mb-4">Set availability for multiple dates at once</p>
            
            <form action="<?php echo e(route('staff.doctor-availability.bulk-update')); ?>" method="POST" id="bulkForm">
                <?php echo csrf_field(); ?>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Doctor Selection -->
                    <div>
                        <label for="bulk_doctor_id" class="block text-sm font-medium text-gray-700 mb-2">Select Doctor</label>
                        <select name="doctor_id" id="bulk_doctor_id" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" required>
                            <option value="">Choose a doctor...</option>
                            <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($doctor->id); ?>">
                                    Dr. <?php echo e($doctor->user->first_name ?? 'N/A'); ?> <?php echo e($doctor->user->last_name ?? ''); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- Date Range -->
                    <div>
                        <label for="date_range" class="block text-sm font-medium text-gray-700 mb-2">Date Range</label>
                        <div class="flex gap-2">
                            <input type="date" name="start_date" id="start_date"
                                   class="form-input flex-1" placeholder="Start Date">
                            <input type="date" name="end_date" id="end_date"
                                   class="form-input flex-1" placeholder="End Date">
                        </div>
                    </div>

                    <!-- Time Range -->
                    <div>
                        <label for="bulk_start_time" class="block text-sm font-medium text-gray-700 mb-2">Time Range</label>
                        <div class="flex gap-2">
                            <input type="time" name="start_time" id="bulk_start_time"
                                   value="09:00" class="form-input flex-1">
                            <input type="time" name="end_time" id="bulk_end_time"
                                   value="17:00" class="form-input flex-1">
                        </div>
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="bulk_status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" id="bulk_status" class="form-input w-full">
                            <option value="available">Available</option>
                            <option value="unavailable">Unavailable</option>
                            <option value="on_leave">On Leave</option>
                        </select>
                    </div>
                </div>

                <!-- Notes -->
                <div class="mt-4">
                    <label for="bulk_notes" class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                    <textarea name="notes" id="bulk_notes" rows="2"
                              class="form-input w-full"
                              placeholder="Notes for all selected dates..."></textarea>
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-calendar-plus mr-2"></i>Set Multiple Dates
                    </button>
                </div>
            </form>
        </div>
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
    
    // Bulk form validation
    const bulkForm = document.getElementById('bulkForm');
    bulkForm.addEventListener('submit', function(e) {
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;
        
        if (startDate && endDate && startDate > endDate) {
            e.preventDefault();
            alert('Start date must be before or equal to end date');
            return false;
        }
        
        if (!startDate || !endDate) {
            e.preventDefault();
            alert('Please select both start and end dates');
            return false;
        }
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.staff', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\staff\doctor-availability\create.blade.php ENDPATH**/ ?>