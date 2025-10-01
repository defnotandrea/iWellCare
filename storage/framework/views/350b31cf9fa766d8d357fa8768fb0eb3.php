

<?php $__env->startSection('title', 'Add Inventory Item - iWellCare'); ?>
<?php $__env->startSection('page-title', 'Add Inventory Item'); ?>
<?php $__env->startSection('page-subtitle', 'Add a new item to the medical inventory'); ?>

<?php $__env->startSection('content'); ?>
<!-- Back Button -->
<div class="mb-6">
    <a href="<?php echo e(route('doctor.inventory.index')); ?>" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 transition-colors">
        <i class="fas fa-arrow-left"></i>Back to Inventory
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Form -->
    <div class="lg:col-span-2">
        <div class="card">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-xl font-bold text-gray-900">Item Information</h3>
                <p class="text-gray-600 text-sm">Fill in the details for the new inventory item</p>
            </div>
            <div class="p-6">
                <form method="POST" action="<?php echo e(route('doctor.inventory.store')); ?>" id="inventoryForm">
                    <?php echo csrf_field(); ?>
                    
                    <!-- Basic Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Item Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   class="form-input w-full <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="name" 
                                   name="name" 
                                   value="<?php echo e(old('name')); ?>" 
                                   placeholder="Enter item name"
                                   required>
                            <?php $__errorArgs = ['name'];
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
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                                Category <span class="text-red-500">*</span>
                            </label>
                            <select class="form-input w-full <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="category" 
                                    name="category" 
                                    required>
                                <option value="">Select Category</option>
                                <option value="medicine" <?php echo e(old('category') === 'medicine' ? 'selected' : ''); ?>>Medicine</option>
                                <option value="supplies" <?php echo e(old('category') === 'supplies' ? 'selected' : ''); ?>>Supplies</option>
                                <option value="equipment" <?php echo e(old('category') === 'equipment' ? 'selected' : ''); ?>>Equipment</option>
                            </select>
                            <?php $__errorArgs = ['category'];
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

                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Description
                        </label>
                        <textarea class="form-input w-full <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                  id="description" 
                                  name="description" 
                                  rows="3" 
                                  placeholder="Enter item description..."><?php echo e(old('description')); ?></textarea>
                        <?php $__errorArgs = ['description'];
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

                    <!-- Quantity and Pricing -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div>
                            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
                                Initial Quantity <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   class="form-input w-full <?php $__errorArgs = ['quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="quantity" 
                                   name="quantity" 
                                   value="<?php echo e(old('quantity', 0)); ?>" 
                                   min="0" 
                                   placeholder="0"
                                   required>
                            <?php $__errorArgs = ['quantity'];
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
                            <label for="unit_price" class="block text-sm font-medium text-gray-700 mb-2">
                                Unit Price <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">₱</span>
                                </div>
                                <input type="number" 
                                       class="form-input w-full pl-8 <?php $__errorArgs = ['unit_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="unit_price" 
                                       name="unit_price" 
                                       value="<?php echo e(old('unit_price')); ?>" 
                                       step="0.01" 
                                       min="0" 
                                       placeholder="0.00"
                                       required>
                            </div>
                            <?php $__errorArgs = ['unit_price'];
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
                            <label for="reorder_level" class="block text-sm font-medium text-gray-700 mb-2">
                                Reorder Level <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   class="form-input w-full <?php $__errorArgs = ['reorder_level'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="reorder_level" 
                                   name="reorder_level" 
                                   value="<?php echo e(old('reorder_level', 10)); ?>" 
                                   min="0" 
                                   placeholder="10"
                                   required>
                            <?php $__errorArgs = ['reorder_level'];
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

                    <!-- Supplier and Expiration -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label for="supplier" class="block text-sm font-medium text-gray-700 mb-2">
                                Supplier
                            </label>
                            <input type="text" 
                                   class="form-input w-full <?php $__errorArgs = ['supplier'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="supplier" 
                                   name="supplier" 
                                   value="<?php echo e(old('supplier')); ?>" 
                                   placeholder="Enter supplier name">
                            <?php $__errorArgs = ['supplier'];
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
                            <label for="expiration_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Expiration Date
                            </label>
                            <input type="date" 
                                   class="form-input w-full <?php $__errorArgs = ['expiration_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="expiration_date" 
                                   name="expiration_date" 
                                   value="<?php echo e(old('expiration_date')); ?>">
                            <?php $__errorArgs = ['expiration_date'];
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

                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                        <a href="<?php echo e(route('doctor.inventory.index')); ?>" class="btn-secondary">
                            <i class="fas fa-times mr-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-save mr-2"></i>Save Item
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Quick Tips -->
        <div class="card">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-900">Quick Tips</h3>
                <p class="text-gray-600 text-sm">Helpful guidelines for adding inventory items</p>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-600 text-sm"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-sm">Item Name</h4>
                            <p class="text-gray-600 text-sm">Use descriptive names for easy identification</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-tags text-yellow-600 text-sm"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-sm">Category</h4>
                            <p class="text-gray-600 text-sm">Choose the most appropriate category for better organization</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-red-600 text-sm"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-sm">Reorder Level</h4>
                            <p class="text-gray-600 text-sm">Set a minimum quantity to trigger low stock alerts</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-calendar text-green-600 text-sm"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-sm">Expiration Date</h4>
                            <p class="text-gray-600 text-sm">Important for medicines and perishable supplies</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-peso-sign text-purple-600 text-sm"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-sm">Unit Price</h4>
                            <p class="text-gray-600 text-sm">Used for cost tracking and financial reports (Philippine Peso)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category Guidelines -->
        <div class="card">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-900">Category Guidelines</h3>
                <p class="text-gray-600 text-sm">Understanding inventory categories</p>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="p-3 bg-blue-50 rounded-lg">
                        <div class="flex items-center space-x-2 mb-2">
                            <i class="fas fa-pills text-blue-600"></i>
                            <h4 class="font-semibold text-blue-900">Medicine</h4>
                        </div>
                        <p class="text-blue-700 text-sm">Prescription drugs, over-the-counter medications, vaccines</p>
                    </div>
                    
                    <div class="p-3 bg-yellow-50 rounded-lg">
                        <div class="flex items-center space-x-2 mb-2">
                            <i class="fas fa-boxes text-yellow-600"></i>
                            <h4 class="font-semibold text-yellow-900">Supplies</h4>
                        </div>
                        <p class="text-yellow-700 text-sm">Bandages, syringes, gloves, masks, cleaning supplies</p>
                    </div>
                    
                    <div class="p-3 bg-green-50 rounded-lg">
                        <div class="flex items-center space-x-2 mb-2">
                            <i class="fas fa-tools text-green-600"></i>
                            <h4 class="font-semibold text-green-900">Equipment</h4>
                        </div>
                        <p class="text-green-700 text-sm">Medical devices, diagnostic tools, office equipment</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('inventoryForm');
    
    // Client-side validation
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        // Reset previous validation states
        form.querySelectorAll('.border-red-500').forEach(element => {
            element.classList.remove('border-red-500');
        });
        
        // Validate required fields
        const requiredFields = ['name', 'category', 'quantity', 'unit_price', 'reorder_level'];
        requiredFields.forEach(fieldName => {
            const field = document.getElementById(fieldName);
            if (!field.value.trim()) {
                field.classList.add('border-red-500');
                isValid = false;
            }
        });
        
        // Validate numeric fields
        const numericFields = ['quantity', 'unit_price', 'reorder_level'];
        numericFields.forEach(fieldName => {
            const field = document.getElementById(fieldName);
            if (field.value && (isNaN(field.value) || parseFloat(field.value) < 0)) {
                field.classList.add('border-red-500');
                isValid = false;
            }
        });
        
        // Validate expiration date
        const expirationDate = document.getElementById('expiration_date');
        if (expirationDate.value) {
            const selectedDate = new Date(expirationDate.value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            if (selectedDate <= today) {
                expirationDate.classList.add('border-red-500');
                isValid = false;
            }
        }
        
        if (!isValid) {
            e.preventDefault();
            // Show error message
            const errorDiv = document.createElement('div');
            errorDiv.className = 'bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mt-4';
            errorDiv.innerHTML = '<i class="fas fa-exclamation-triangle mr-2"></i>Please correct the errors above before submitting.';
            
            const existingError = form.querySelector('.bg-red-50');
            if (existingError) {
                existingError.remove();
            }
            
            form.appendChild(errorDiv);
        }
    });
    
    // Real-time validation feedback
    form.querySelectorAll('input, select, textarea').forEach(field => {
        field.addEventListener('blur', function() {
            validateField(this);
        });
    });
    
    function validateField(field) {
        const value = field.value.trim();
        
        // Remove previous validation state
        field.classList.remove('border-red-500', 'border-green-500');
        
        // Skip validation for empty optional fields
        if (!field.hasAttribute('required') && !value) {
            return;
        }
        
        // Required field validation
        if (field.hasAttribute('required') && !value) {
            field.classList.add('border-red-500');
            return;
        }
        
        // Numeric field validation
        if (field.type === 'number' && value) {
            if (isNaN(value) || parseFloat(value) < 0) {
                field.classList.add('border-red-500');
                return;
            }
        }
        
        // Date validation
        if (field.type === 'date' && value) {
            const selectedDate = new Date(value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            if (selectedDate <= today) {
                field.classList.add('border-red-500');
                return;
            }
        }
        
        // If we get here, the field is valid
        if (value) {
            field.classList.add('border-green-500');
        }
    }
});
</script>
<?php $__env->stopPush(); ?> 
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\doctor\inventory\create.blade.php ENDPATH**/ ?>