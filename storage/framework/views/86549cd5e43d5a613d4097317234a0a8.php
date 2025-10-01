

<?php $__env->startSection('title', 'Create New Appointment - iWellCare'); ?>
<?php $__env->startSection('page-title', 'Create New Appointment'); ?>
<?php $__env->startSection('page-subtitle', 'Schedule a new patient appointment'); ?>

<?php $__env->startSection('content'); ?>
<div class="appointments-content">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Create New Appointment</h1>
        <a href="<?php echo e(route('staff.appointments.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Back to Appointments
        </a>
    </div>

    <div class="card p-6">
        <form method="POST" action="<?php echo e(route('staff.appointments.store')); ?>" class="space-y-6">
            <?php echo csrf_field(); ?>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="patient_id" class="block text-sm font-medium text-gray-700 mb-2">Patient</label>
                    <select id="patient_id" name="patient_id" class="form-input w-full <?php $__errorArgs = ['patient_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                        <option value="">Select Patient</option>
                        <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($patient->id); ?>" <?php echo e(old('patient_id') == $patient->id ? 'selected' : ''); ?>>
                                <?php echo e($patient->first_name); ?> <?php echo e($patient->last_name); ?> - <?php echo e($patient->email); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['patient_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <div>
                    <label for="doctor_id" class="block text-sm font-medium text-gray-700 mb-2">Doctor</label>
                    
                    <!-- Doctor Availability Status -->
                    <div class="mb-3 p-3 bg-gray-50 border border-gray-200 rounded-lg">
                        <h4 class="text-sm font-semibold text-gray-700 mb-2">Doctor Availability Status:</h4>
                        <div class="space-y-1">
                            <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $latestSetting = $doctor->availabilitySettings->first();
                                    $availability = $latestSetting ? $latestSetting->getCurrentStatus() : [
                                        'is_available' => true,
                                        'message' => 'Available',
                                        'status' => 'available'
                                    ];
                                ?>
                                <div class="flex items-center justify-between p-2 rounded-lg <?php echo e($availability['is_available'] ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200'); ?>">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 rounded-full mr-2 <?php echo e($availability['is_available'] ? 'bg-green-500' : 'bg-red-500'); ?>"></div>
                                        <span class="font-medium text-gray-900">
                                            Dr. <?php echo e($doctor->user->first_name); ?> <?php echo e($doctor->user->last_name); ?>

                                        </span>
                                    </div>
                                    <div class="text-sm font-medium <?php echo e($availability['is_available'] ? 'text-green-700' : 'text-red-700'); ?>">
                                        <?php if($availability['is_available']): ?>
                                            <i class="fas fa-check-circle mr-1"></i>Available
                                        <?php else: ?>
                                            <i class="fas fa-times-circle mr-1"></i><?php echo e($availability['message']); ?>

                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    
                    <select id="doctor_id" name="doctor_id" class="form-input w-full <?php $__errorArgs = ['doctor_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                        <option value="">Select Doctor</option>
                        <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $latestSetting = $doctor->availabilitySettings->first();
                                $availability = $latestSetting ? $latestSetting->getCurrentStatus() : [
                                    'is_available' => true,
                                    'message' => 'Available',
                                    'status' => 'available'
                                ];
                            ?>
                            <option value="<?php echo e($doctor->id); ?>" <?php echo e(old('doctor_id') == $doctor->id ? 'selected' : ''); ?>

                                <?php if(!$availability['is_available']): ?> disabled <?php endif; ?>
                                class="<?php if(!$availability['is_available']): ?> text-red-500 <?php else: ?> text-gray-900 <?php endif; ?>"
                            >
                                Dr. <?php echo e($doctor->user->first_name); ?> <?php echo e($doctor->user->last_name); ?>

                                <?php if($availability['is_available']): ?>
                                    ✅ Available
                                <?php else: ?>
                                    ❌ <?php echo e($availability['message']); ?>

                                <?php endif; ?>
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['doctor_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="appointment_date" class="block text-sm font-medium text-gray-700 mb-2">Appointment Date</label>
                    <input type="date" id="appointment_date" name="appointment_date" 
                           value="<?php echo e(old('appointment_date')); ?>" 
                           class="form-input w-full <?php $__errorArgs = ['appointment_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                    <?php $__errorArgs = ['appointment_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <div>
                    <label for="appointment_time" class="block text-sm font-medium text-gray-700 mb-2">Appointment Time</label>
                    <input type="time" id="appointment_time" name="appointment_time" 
                           value="<?php echo e(old('appointment_time')); ?>" 
                           class="form-input w-full <?php $__errorArgs = ['appointment_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                    <?php $__errorArgs = ['appointment_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div>
                <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">Reason for Visit</label>
                <textarea id="reason" name="reason" rows="3" 
                          class="form-input w-full <?php $__errorArgs = ['reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required><?php echo e(old('reason')); ?></textarea>
                <?php $__errorArgs = ['reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select id="status" name="status" class="form-input w-full <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                    <option value="scheduled" <?php echo e(old('status') === 'scheduled' ? 'selected' : ''); ?>>Scheduled</option>
                    <option value="confirmed" <?php echo e(old('status') === 'confirmed' ? 'selected' : ''); ?>>Confirmed</option>
                    <option value="cancelled" <?php echo e(old('status') === 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                    <option value="completed" <?php echo e(old('status') === 'completed' ? 'selected' : ''); ?>>Completed</option>
                </select>
                <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="<?php echo e(route('staff.appointments.index')); ?>" class="btn btn-secondary">
                    <i class="fas fa-times mr-2"></i>Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>Create Appointment
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.staff', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\staff\appointments\create.blade.php ENDPATH**/ ?>