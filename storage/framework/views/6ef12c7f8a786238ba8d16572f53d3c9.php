
<?php $__env->startSection('title', 'Create Invoice - iWellCare'); ?>
<?php $__env->startSection('page-title', 'Create Invoice'); ?>
<?php $__env->startSection('page-subtitle', 'Generate a new patient invoice'); ?>
<?php $__env->startSection('content'); ?>

<div class="billing-content">
    <div class="card p-3 md:p-4 max-w-3xl mx-auto bg-gradient-to-br from-white to-green-50/30 border border-green-100/50 shadow-lg hover:shadow-xl transition-all duration-300">
        <?php if($errors->any()): ?>
            <div class="bg-red-50 border border-red-200 text-red-800 p-3 rounded-lg mb-4 shadow-sm">
                <div class="flex items-center gap-2 mb-2">
                    <i class="fas fa-exclamation-triangle text-red-500"></i>
                    <span class="font-semibold">Please fix the following errors:</span>
                </div>
                <ul class="list-disc list-inside ml-6">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-file-invoice-dollar text-green-600 text-lg"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Invoice Details</h3>
                <p class="text-sm text-gray-500">Fill in the patient and payment information</p>
            </div>
        </div>
        
        <form action="<?php echo e(route('staff.invoice.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            
            <!-- Patient Information Section -->
            <div class="bg-green-50/50 rounded-lg p-3 md:p-4 mb-4 border border-green-100">
                <h4 class="text-base font-semibold text-green-800 mb-3 flex items-center gap-2">
                    <i class="fas fa-user text-green-600"></i>
                    Patient Information
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6">
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-semibold text-sm mb-2">Patient</label>
                    <div class="relative">
                        <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <select name="patient_id" class="form-input w-full pl-10 <?php $__errorArgs = ['patient_id'];
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
                                    <?php echo e($patient->first_name); ?> <?php echo e($patient->last_name); ?> (<?php echo e($patient->email ?? 'No email'); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
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
                
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-semibold text-sm mb-2">Appointment (Optional)</label>
                    <div class="relative">
                        <i class="fas fa-calendar absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <select name="appointment_id" class="form-input w-full pl-10 <?php $__errorArgs = ['appointment_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <option value="">No appointment linked</option>
                            <?php $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($appointment->id); ?>" <?php echo e(old('appointment_id') == $appointment->id ? 'selected' : ''); ?>>
                                    <?php echo e($appointment->appointment_date->format('M d, Y h:i A')); ?> - <?php echo e($appointment->patient->first_name ?? ''); ?> <?php echo e($appointment->patient->last_name ?? ''); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <?php $__errorArgs = ['appointment_id'];
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
           </div>

           <!-- Billing Details Section -->
           <div class="bg-blue-50/50 rounded-lg p-3 md:p-4 mb-4 border border-blue-100">
               <h4 class="text-base font-semibold text-blue-800 mb-3 flex items-center gap-2">
                   <i class="fas fa-calculator text-blue-600"></i>
                   Billing Details
               </h4>
               <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6">
                <div>
                    <label class="block text-gray-700 font-semibold text-sm mb-2">Consultation Fee (₱)</label>
                    <div class="relative">
                        <i class="fas fa-stethoscope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="number" name="consultation_fee" class="form-input w-full pl-10 <?php $__errorArgs = ['consultation_fee'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               min="0" step="0.01" value="<?php echo e(old('consultation_fee')); ?>" placeholder="0.00" required>
                    </div>
                    <?php $__errorArgs = ['consultation_fee'];
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
                    <label class="block text-gray-700 font-semibold text-sm mb-2">Medication Fee (₱)</label>
                    <div class="relative">
                        <i class="fas fa-pills absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="number" name="medication_fee" class="form-input w-full pl-10 <?php $__errorArgs = ['medication_fee'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               min="0" step="0.01" value="<?php echo e(old('medication_fee', 0)); ?>" placeholder="0.00">
                    </div>
                    <?php $__errorArgs = ['medication_fee'];
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
                    <label class="block text-gray-700 font-semibold text-sm mb-2">Laboratory Fee (₱)</label>
                    <div class="relative">
                        <i class="fas fa-flask absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="number" name="laboratory_fee" class="form-input w-full pl-10 <?php $__errorArgs = ['laboratory_fee'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               min="0" step="0.01" value="<?php echo e(old('laboratory_fee', 0)); ?>" placeholder="0.00">
                    </div>
                    <?php $__errorArgs = ['laboratory_fee'];
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
                    <label class="block text-gray-700 font-semibold text-sm mb-2">Other Fees (₱)</label>
                    <div class="relative">
                        <i class="fas fa-plus-circle absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="number" name="other_fees" class="form-input w-full pl-10 <?php $__errorArgs = ['other_fees'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               min="0" step="0.01" value="<?php echo e(old('other_fees', 0)); ?>" placeholder="0.00">
                    </div>
                    <?php $__errorArgs = ['other_fees'];
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
                    <label class="block text-gray-700 font-semibold text-sm mb-2">Payment Status</label>
                    <div class="relative">
                        <i class="fas fa-check-circle absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <select name="status" class="form-input w-full pl-10 <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <option value="paid" <?php echo e(old('status') == 'paid' ? 'selected' : ''); ?>>Paid</option>
                            <option value="unpaid" <?php echo e(old('status') == 'unpaid' ? 'selected' : ''); ?>>Unpaid</option>
                        </select>
                    </div>
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
                
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-semibold text-sm mb-2">Payment Date</label>
                    <div class="relative">
                        <i class="fas fa-calendar-day absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="date" name="payment_date" class="form-input w-full pl-10 <?php $__errorArgs = ['payment_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               value="<?php echo e(old('payment_date', date('Y-m-d'))); ?>" required>
                    </div>
                    <?php $__errorArgs = ['payment_date'];
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
           </div>

           <!-- Payment Information Section -->
           <div class="bg-purple-50/50 rounded-lg p-3 md:p-4 mb-4 border border-purple-100">
               <h4 class="text-base font-semibold text-purple-800 mb-3 flex items-center gap-2">
                   <i class="fas fa-credit-card text-purple-600"></i>
                   Payment Information
               </h4>
               <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6">
                   <div>
                       <label class="block text-gray-700 font-semibold text-sm mb-2">Payment Status</label>
                       <div class="relative">
                           <i class="fas fa-check-circle absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                           <select name="status" class="form-input w-full pl-10 <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                               <option value="paid" <?php echo e(old('status') == 'paid' ? 'selected' : ''); ?>>Paid</option>
                               <option value="unpaid" <?php echo e(old('status') == 'unpaid' ? 'selected' : ''); ?>>Unpaid</option>
                           </select>
                       </div>
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

                   <div>
                       <label class="block text-gray-700 font-semibold text-sm mb-2">Payment Date</label>
                       <div class="relative">
                           <i class="fas fa-calendar-day absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                           <input type="date" name="payment_date" class="form-input w-full pl-10 <?php $__errorArgs = ['payment_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                  value="<?php echo e(old('payment_date', date('Y-m-d'))); ?>" required>
                       </div>
                       <?php $__errorArgs = ['payment_date'];
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
           </div>
            
            <div class="flex flex-col sm:flex-row justify-end gap-4 mt-6 pt-4 border-t border-gray-100">
                <a href="<?php echo e(route('staff.invoice.index')); ?>" class="btn btn-secondary hover:bg-gray-100 hover:border-gray-300 transition-all duration-200 order-2 sm:order-1">
                    <i class="fas fa-times mr-2"></i>Cancel
                </a>
                <button type="submit" class="btn btn-primary bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 order-1 sm:order-2">
                    <i class="fas fa-save mr-2"></i>Create Invoice
                </button>
            </div>
        </form>
    </div>
</div>

<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.staff', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\staff\invoice\create.blade.php ENDPATH**/ ?>