

<?php $__env->startSection('title', 'Create Prescription - iWellCare'); ?>
<?php $__env->startSection('page-title', 'Create New Prescription'); ?>
<?php $__env->startSection('page-subtitle', 'Generate a new prescription for a patient'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="<?php echo e(route('staff.prescriptions.index')); ?>" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 transition-colors">
                <i class="fas fa-arrow-left"></i>Back to Prescriptions
            </a>
        </div>

        <!-- Main Content Container -->
        <div class="space-y-6">
            <?php if($errors->any()): ?>
                <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-xl flex items-start gap-3">
                    <i class="fas fa-exclamation-triangle text-red-500 mt-1"></i>
                    <div>
                        <h4 class="font-semibold mb-2">Please fix the following errors:</h4>
                        <ul class="list-disc list-inside space-y-1">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="text-sm"><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('staff.prescriptions.store')); ?>" method="POST" class="space-y-6">
                <?php echo csrf_field(); ?>
                
                <!-- Patient and Doctor Information -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user text-blue-600"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Patient & Doctor Information</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Patient Selection -->
                        <div class="md:col-span-2">
                            <label for="patient_id" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-user text-gray-400 mr-2"></i>Patient *
                            </label>
                            <select name="patient_id" id="patient_id" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <option value="">Select Patient</option>
                                <?php $__currentLoopData = $patients ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($patient->id); ?>" <?php echo e(old('patient_id') == $patient->id ? 'selected' : ''); ?>>
                                        <?php echo e($patient->first_name); ?> <?php echo e($patient->last_name); ?> (<?php echo e($patient->email); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['patient_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Doctor Selection -->
                        <div class="md:col-span-2">
                            <label for="doctor_id" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-user-md text-gray-400 mr-2"></i>Doctor *
                            </label>
                            <select name="doctor_id" id="doctor_id" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <option value="">Select Doctor</option>
                                <?php $__currentLoopData = $doctors ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($doctor->id); ?>" <?php echo e(old('doctor_id') == $doctor->id ? 'selected' : ''); ?>>
                                        Dr. <?php echo e($doctor->user->first_name ?? ''); ?> <?php echo e($doctor->user->last_name ?? ''); ?> (<?php echo e($doctor->user->email ?? ''); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['doctor_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <!-- Medications Section -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-pills text-indigo-600"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Medications</h3>
                        </div>
                        <button type="button" id="add-medication" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors">
                            <i class="fas fa-plus mr-2"></i>Add Medication
                        </button>
                    </div>

                    <!-- Medications Container -->
                    <div id="medications-container" class="space-y-4">
                        <!-- Default medication entry -->
                        <div class="medication-entry bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-sm font-medium text-gray-700">Medication #1</h4>
                                <button type="button" class="remove-medication text-red-600 hover:text-red-800 transition-colors" style="display: none;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-pills text-gray-400 mr-2"></i>Medication Name *
                                    </label>
                                    <input type="text" name="medications[0][medication_name]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" placeholder="e.g., Amoxicillin">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-weight text-gray-400 mr-2"></i>Dosage *
                                    </label>
                                    <input type="text" name="medications[0][dosage]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" placeholder="e.g., 500mg">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-clock text-gray-400 mr-2"></i>Frequency *
                                    </label>
                                    <input type="text" name="medications[0][frequency]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" placeholder="e.g., Twice daily">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-calendar text-gray-400 mr-2"></i>Duration
                                    </label>
                                    <input type="text" name="medications[0][duration]" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" placeholder="e.g., 7 days">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-cubes text-gray-400 mr-2"></i>Quantity
                                    </label>
                                    <input type="number" name="medications[0][quantity]" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" placeholder="e.g., 30">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-sticky-note text-gray-400 mr-2"></i>Instructions
                                    </label>
                                    <textarea name="medications[0][instructions]" rows="2" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" placeholder="Special instructions for this medication..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Prescription Details -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clipboard-list text-green-600"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Prescription Details</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="prescribed_date" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-calendar text-gray-400 mr-2"></i>Prescribed Date *
                            </label>
                            <input type="date" name="prescribed_date" id="prescribed_date" value="<?php echo e(old('prescribed_date', date('Y-m-d'))); ?>" required readonly class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-500 cursor-not-allowed">
                            <?php $__errorArgs = ['prescribed_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-info-circle text-gray-400 mr-2"></i>Status
                            </label>
                            <select name="status" id="status" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                                <option value="active" <?php echo e(old('status') == 'active' ? 'selected' : ''); ?>>Active</option>
                                <option value="completed" <?php echo e(old('status') == 'completed' ? 'selected' : ''); ?>>Completed</option>
                                <option value="cancelled" <?php echo e(old('status') == 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                            </select>
                            <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- General Instructions -->
                        <div class="md:col-span-2">
                            <label for="instructions" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-sticky-note text-gray-400 mr-2"></i>General Instructions
                            </label>
                            <textarea name="instructions" id="instructions" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors" placeholder="General instructions for the patient..."><?php echo e(old('instructions')); ?></textarea>
                            <?php $__errorArgs = ['instructions'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Notes -->
                        <div class="md:col-span-2">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-comment text-gray-400 mr-2"></i>Notes
                            </label>
                            <textarea name="notes" id="notes" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors" placeholder="Additional notes..."><?php echo e(old('notes')); ?></textarea>
                            <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-4">
                    <a href="<?php echo e(route('staff.prescriptions.index')); ?>" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition-colors flex items-center gap-2">
                        <i class="fas fa-times"></i>Cancel
                    </a>
                    <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors flex items-center gap-2 shadow-lg">
                        <i class="fas fa-save"></i>Create Prescription
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let medicationCount = 1;
    const container = document.getElementById('medications-container');
    const addButton = document.getElementById('add-medication');

    // Add medication functionality
    addButton.addEventListener('click', function() {
        const newMedication = createMedicationEntry(medicationCount);
        container.appendChild(newMedication);
        medicationCount++;
        updateMedicationNumbers();
        updateRemoveButtons();
    });

    // Remove medication functionality
    container.addEventListener('click', function(e) {
        if (e.target.closest('.remove-medication')) {
            e.target.closest('.medication-entry').remove();
            updateMedicationNumbers();
            updateRemoveButtons();
        }
    });

    function createMedicationEntry(index) {
        const div = document.createElement('div');
        div.className = 'medication-entry bg-gray-50 rounded-lg p-4 border border-gray-200';
        div.innerHTML = `
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-sm font-medium text-gray-700">Medication #${index + 1}</h4>
                <button type="button" class="remove-medication text-red-600 hover:text-red-800 transition-colors">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-pills text-gray-400 mr-2"></i>Medication Name *
                    </label>
                    <input type="text" name="medications[${index}][medication_name]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" placeholder="e.g., Amoxicillin">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-weight text-gray-400 mr-2"></i>Dosage *
                    </label>
                    <input type="text" name="medications[${index}][dosage]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" placeholder="e.g., 500mg">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-clock text-gray-400 mr-2"></i>Frequency *
                    </label>
                    <input type="text" name="medications[${index}][frequency]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" placeholder="e.g., Twice daily">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar text-gray-400 mr-2"></i>Duration
                    </label>
                    <input type="text" name="medications[${index}][duration]" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" placeholder="e.g., 7 days">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-cubes text-gray-400 mr-2"></i>Quantity
                    </label>
                    <input type="number" name="medications[${index}][quantity]" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" placeholder="e.g., 30">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-sticky-note text-gray-400 mr-2"></i>Instructions
                    </label>
                    <textarea name="medications[${index}][instructions]" rows="2" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" placeholder="Special instructions for this medication..."></textarea>
                </div>
            </div>
        `;
        return div;
    }

    function updateMedicationNumbers() {
        const entries = container.querySelectorAll('.medication-entry');
        entries.forEach((entry, index) => {
            const title = entry.querySelector('h4');
            title.textContent = `Medication #${index + 1}`;
        });
    }

    function updateRemoveButtons() {
        const entries = container.querySelectorAll('.medication-entry');
        entries.forEach((entry, index) => {
            const removeBtn = entry.querySelector('.remove-medication');
            if (entries.length === 1) {
                removeBtn.style.display = 'none';
            } else {
                removeBtn.style.display = 'block';
            }
        });
    }

    // Initialize
    updateRemoveButtons();
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.medication-entry {
    animation: fadeInUp 0.3s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.staff', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\staff\prescriptions\create.blade.php ENDPATH**/ ?>