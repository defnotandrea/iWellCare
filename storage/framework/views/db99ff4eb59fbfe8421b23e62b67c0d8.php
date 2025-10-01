

<?php $__env->startSection('title', 'Edit Inventory Item - iWellCare'); ?>
<?php $__env->startSection('page-title', 'Edit Inventory Item'); ?>
<?php $__env->startSection('page-subtitle', 'Update inventory item information'); ?>

<?php $__env->startSection('content'); ?>
<div class="inventory-content">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Edit Inventory Item</h2>
            <p class="text-gray-600">Update information for <?php echo e($item->name); ?></p>
        </div>
        <a href="<?php echo e(route('staff.inventory.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Back to Inventory
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

        <form action="<?php echo e(route('staff.inventory.update', $item->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Basic Information</h3>
                </div>
                
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Item Name *</label>
                    <input type="text" name="name" id="name" 
                           value="<?php echo e(old('name', $item->name)); ?>" 
                           class="form-input w-full" required>
                </div>
                
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select name="category" id="category" class="form-input w-full">
                        <option value="">Select Category</option>
                        <option value="medicine" <?php echo e(old('category', $item->category) === 'medicine' ? 'selected' : ''); ?>>Medicine</option>
                        <option value="supplies" <?php echo e(old('category', $item->category) === 'supplies' ? 'selected' : ''); ?>>Medical Supplies</option>
                        <option value="equipment" <?php echo e(old('category', $item->category) === 'equipment' ? 'selected' : ''); ?>>Medical Equipment</option>
                    </select>
                </div>
                
                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Quantity *</label>
                    <input type="number" name="quantity" id="quantity" 
                           value="<?php echo e(old('quantity', $item->quantity)); ?>" 
                           class="form-input w-full" required min="0">
                </div>
                
                <div>
                    <label for="unit_price" class="block text-sm font-medium text-gray-700 mb-2">Unit Price (₱)</label>
                    <input type="number" name="unit_price" id="unit_price" 
                           value="<?php echo e(old('unit_price', $item->unit_price)); ?>" 
                           class="form-input w-full" min="0" step="0.01">
                </div>
                
                <div>
                    <label for="reorder_level" class="block text-sm font-medium text-gray-700 mb-2">Reorder Level *</label>
                    <input type="number" name="reorder_level" id="reorder_level" 
                           value="<?php echo e(old('reorder_level', $item->reorder_level)); ?>" 
                           class="form-input w-full" required min="0">
                    <p class="text-sm text-gray-500 mt-1">Alert when stock reaches this level</p>
                </div>
                
                <!-- Additional Information -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 mt-6">Additional Information</h3>
                </div>
                
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" id="description" rows="3" 
                              class="form-input w-full" 
                              placeholder="Detailed description of the item..."><?php echo e(old('description', $item->description)); ?></textarea>
                </div>
            </div>
            
            <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-gray-200">
                <a href="<?php echo e(route('staff.inventory.index')); ?>" class="btn btn-secondary">
                    <i class="fas fa-times mr-2"></i>Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>Update Item
                </button>
            </div>
        </form>
    </div>

    <!-- Current Item Information -->
    <div class="card p-6 max-w-4xl mx-auto mt-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Current Item Information</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Current Quantity</label>
                <p class="text-lg font-semibold <?php echo e($item->quantity <= $item->reorder_level ? 'text-red-600' : 'text-green-600'); ?>">
                    <?php echo e($item->quantity); ?>

                    <?php if($item->quantity <= $item->reorder_level): ?>
                        <span class="text-sm text-red-500">(Low Stock)</span>
                    <?php endif; ?>
                </p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Total Value</label>
                <p class="text-lg font-semibold text-blue-600">₱<?php echo e(number_format($item->quantity * $item->unit_price, 2)); ?></p>
            </div>
            
            <?php if($item->supplier): ?>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Supplier</label>
                <p class="text-gray-800"><?php echo e($item->supplier); ?></p>
            </div>
            <?php endif; ?>
            
            <?php if($item->location): ?>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Storage Location</label>
                <p class="text-gray-800"><?php echo e($item->location); ?></p>
            </div>
            <?php endif; ?>
            
            <?php if($item->batch_number): ?>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Batch Number</label>
                <p class="text-gray-800"><?php echo e($item->batch_number); ?></p>
            </div>
            <?php endif; ?>
            
            <?php if($item->expiration_date): ?>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Expiration Date</label>
                <p class="text-gray-800 <?php echo e($item->expiration_date->isPast() ? 'text-red-600 font-semibold' : ''); ?>">
                    <?php echo e($item->expiration_date->format('M d, Y')); ?>

                    <?php if($item->expiration_date->isPast()): ?>
                        <span class="text-sm text-red-500">(Expired)</span>
                    <?php elseif($item->expiration_date->diffInDays(now()) <= 30): ?>
                        <span class="text-sm text-yellow-500">(Expiring Soon)</span>
                    <?php endif; ?>
                </p>
            </div>
            <?php endif; ?>
            
            <?php if($item->notes): ?>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                <p class="text-gray-800"><?php echo e($item->notes); ?></p>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="mt-6 pt-4 border-t border-gray-200">
            <div class="flex items-center justify-between text-sm text-gray-500">
                <span>Last updated: <?php echo e($item->updated_at ? $item->updated_at->format('M d, Y g:i A') : 'Never'); ?></span>
                <?php if($item->updated_by): ?>
                <span>Updated by: <?php echo e($item->updatedBy->name ?? 'Unknown'); ?></span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-calculate total value
    const quantityInput = document.getElementById('quantity');
    const unitPriceInput = document.getElementById('unit_price');
    
    function calculateTotal() {
        const quantity = parseFloat(quantityInput.value) || 0;
        const unitPrice = parseFloat(unitPriceInput.value) || 0;
        const total = quantity * unitPrice;
        
        // You can add a display element for total if needed
        console.log('Total Value: ₱' + total.toFixed(2));
    }
    
    quantityInput.addEventListener('input', calculateTotal);
    unitPriceInput.addEventListener('input', calculateTotal);
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\admin\inventory\edit.blade.php ENDPATH**/ ?>