

<?php $__env->startSection('title', 'Edit Patient - iWellCare'); ?>
<?php $__env->startSection('page-title', 'Edit Patient'); ?>
<?php $__env->startSection('page-subtitle', 'Update patient information'); ?>

<?php $__env->startSection('content'); ?>
<div class="patients-content">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Edit Patient Information</h2>
            <p class="text-gray-600">Update patient details and medical information</p>
        </div>
        <a href="<?php echo e(route('admin.patients.show', $patient)); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Back to Patient
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

        <form action="<?php echo e(route('admin.patients.update', $patient)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Basic Information</h3>
                </div>
                
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name *</label>
                    <input type="text" name="first_name" id="first_name" 
                           value="<?php echo e(old('first_name', $patient->first_name)); ?>" 
                           class="form-input w-full" required>
                </div>
                
                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Last Name *</label>
                    <input type="text" name="last_name" id="last_name" 
                           value="<?php echo e(old('last_name', $patient->last_name)); ?>" 
                           class="form-input w-full" required>
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                    <input type="email" name="email" id="email" 
                           value="<?php echo e(old('email', $patient->email)); ?>" 
                           class="form-input w-full" required>
                </div>
                
                <div>
                    <label for="contact" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                    <input type="text" name="contact" id="contact" 
                           value="<?php echo e(old('contact', $patient->contact)); ?>" 
                           class="form-input w-full" placeholder="+63 912 345 6789">
                </div>
                
                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                    <input type="date" name="date_of_birth" id="date_of_birth"
                           value="<?php echo e(old('date_of_birth', $patient->date_of_birth ? date('Y-m-d', strtotime($patient->date_of_birth)) : '')); ?>"
                           class="form-input w-full">
                </div>
                
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                    <select name="gender" id="gender" class="form-input w-full">
                        <option value="">Select Gender</option>
                        <option value="male" <?php echo e(old('gender', $patient->gender) === 'male' ? 'selected' : ''); ?>>Male</option>
                        <option value="female" <?php echo e(old('gender', $patient->gender) === 'female' ? 'selected' : ''); ?>>Female</option>
                        <option value="other" <?php echo e(old('gender', $patient->gender) === 'other' ? 'selected' : ''); ?>>Other</option>
                    </select>
                </div>
                
                <div>
                    <label for="blood_type" class="block text-sm font-medium text-gray-700 mb-2">Blood Type</label>
                    <select name="blood_type" id="blood_type" class="form-input w-full">
                        <option value="">Select Blood Type</option>
                        <option value="A+" <?php echo e(old('blood_type', $patient->blood_type) === 'A+' ? 'selected' : ''); ?>>A+</option>
                        <option value="A-" <?php echo e(old('blood_type', $patient->blood_type) === 'A-' ? 'selected' : ''); ?>>A-</option>
                        <option value="B+" <?php echo e(old('blood_type', $patient->blood_type) === 'B+' ? 'selected' : ''); ?>>B+</option>
                        <option value="B-" <?php echo e(old('blood_type', $patient->blood_type) === 'B-' ? 'selected' : ''); ?>>B-</option>
                        <option value="AB+" <?php echo e(old('blood_type', $patient->blood_type) === 'AB+' ? 'selected' : ''); ?>>AB+</option>
                        <option value="AB-" <?php echo e(old('blood_type', $patient->blood_type) === 'AB-' ? 'selected' : ''); ?>>AB-</option>
                        <option value="O+" <?php echo e(old('blood_type', $patient->blood_type) === 'O+' ? 'selected' : ''); ?>>O+</option>
                        <option value="O-" <?php echo e(old('blood_type', $patient->blood_type) === 'O-' ? 'selected' : ''); ?>>O-</option>
                    </select>
                </div>
                
                <div>
                    <label for="is_active" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="is_active" id="is_active" class="form-input w-full">
                        <option value="1" <?php echo e(old('is_active', $patient->is_active) ? 'selected' : ''); ?>>Active</option>
                        <option value="0" <?php echo e(old('is_active', $patient->is_active) ? '' : 'selected'); ?>>Inactive</option>
                    </select>
                </div>
                
                <!-- Address Information -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 mt-6">Address Information</h3>
                </div>
                
                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                    <textarea name="address" id="address" rows="3" 
                              class="form-input w-full" 
                              placeholder="Enter complete address..."><?php echo e(old('address', $patient->address)); ?></textarea>
                </div>
                
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700 mb-2">City</label>
                    <input type="text" name="city" id="city" 
                           value="<?php echo e(old('city', $patient->city)); ?>" 
                           class="form-input w-full" placeholder="e.g., Manila">
                </div>
                
                <div>
                    <label for="state" class="block text-sm font-medium text-gray-700 mb-2">State/Province</label>
                    <input type="text" name="state" id="state" 
                           value="<?php echo e(old('state', $patient->state)); ?>" 
                           class="form-input w-full" placeholder="e.g., Metro Manila">
                </div>
                
                <div>
                    <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">Postal Code</label>
                    <input type="text" name="postal_code" id="postal_code" 
                           value="<?php echo e(old('postal_code', $patient->postal_code)); ?>" 
                           class="form-input w-full" placeholder="e.g., 1000">
                </div>
                
                <div>
                    <label for="country" class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                    <input type="text" name="country" id="country" 
                           value="<?php echo e(old('country', $patient->country ?? 'Philippines')); ?>" 
                           class="form-input w-full">
                </div>
                
                <!-- Medical Information -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 mt-6">Medical Information</h3>
                </div>
                
                <div class="md:col-span-2">
                    <label for="allergies" class="block text-sm font-medium text-gray-700 mb-2">Allergies</label>
                    <textarea name="allergies" id="allergies" rows="3" 
                              class="form-input w-full" 
                              placeholder="List any known allergies..."><?php echo e(old('allergies', $patient->allergies)); ?></textarea>
                </div>
                
                <div class="md:col-span-2">
                    <label for="medical_history" class="block text-sm font-medium text-gray-700 mb-2">Medical History</label>
                    <textarea name="medical_history" id="medical_history" rows="4" 
                              class="form-input w-full" 
                              placeholder="Relevant medical history, surgeries, chronic conditions..."><?php echo e(old('medical_history', $patient->medical_history)); ?></textarea>
                </div>
                
                <div class="md:col-span-2">
                    <label for="current_medications" class="block text-sm font-medium text-gray-700 mb-2">Current Medications</label>
                    <textarea name="current_medications" id="current_medications" rows="3" 
                              class="form-input w-full" 
                              placeholder="List current medications and dosages..."><?php echo e(old('current_medications', $patient->current_medications)); ?></textarea>
                </div>
                
                <div class="md:col-span-2">
                    <label for="family_history" class="block text-sm font-medium text-gray-700 mb-2">Family History</label>
                    <textarea name="family_history" id="family_history" rows="3" 
                              class="form-input w-full" 
                              placeholder="Relevant family medical history..."><?php echo e(old('family_history', $patient->family_history)); ?></textarea>
                </div>
                
                <div>
                    <label for="emergency_contact" class="block text-sm font-medium text-gray-700 mb-2">Emergency Contact</label>
                    <input type="text" name="emergency_contact" id="emergency_contact" 
                           value="<?php echo e(old('emergency_contact', $patient->emergency_contact)); ?>" 
                           class="form-input w-full" placeholder="+63 923 456 7890">
                </div>
                
                <div>
                    <label for="emergency_contact_name" class="block text-sm font-medium text-gray-700 mb-2">Emergency Contact Name</label>
                    <input type="text" name="emergency_contact_name" id="emergency_contact_name" 
                           value="<?php echo e(old('emergency_contact_name', $patient->emergency_contact_name)); ?>" 
                           class="form-input w-full" placeholder="e.g., Spouse, Parent">
                </div>
            </div>
            
            <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-gray-200">
                <a href="<?php echo e(route('admin.patients.show', $patient)); ?>" class="btn btn-secondary">
                    <i class="fas fa-times mr-2"></i>Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>Update Patient
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\admin\patients\edit.blade.php ENDPATH**/ ?>