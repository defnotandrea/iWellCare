

<?php $__env->startSection('title', 'Edit Inventory Item - iWellCare'); ?>
<?php $__env->startSection('page-title', 'Edit Inventory Item'); ?>
<?php $__env->startSection('page-subtitle', 'Update inventory item information'); ?>

<?php $__env->startSection('content'); ?>
<!-- Modal Overlay -->
<div id="editModalOverlay" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <!-- Modal Dialog -->
    <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl mx-auto relative animate-fade-in">
        <!-- Close Button -->
        <button onclick="window.location='<?php echo e(route('doctor.inventory.show', $inventory)); ?>'" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 text-2xl font-bold focus:outline-none" aria-label="Close">&times;</button>
        <div class="px-8 py-6 border-b border-gray-100">
            <h3 class="text-xl font-bold text-gray-900">Edit Item: <?php echo e($inventory->name); ?></h3>
            <p class="text-gray-600 text-sm">Update inventory item information</p>
        </div>
        <div class="p-8">
            <form method="POST" action="<?php echo e(route('doctor.inventory.update', $inventory)); ?>" id="inventoryForm">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Item Name <span class="text-red-500">*</span></label>
                        <input type="text" class="form-input w-full" id="name" name="name" value="<?php echo e(old('name', $inventory->name)); ?>" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Category <span class="text-red-500">*</span></label>
                        <select class="form-input w-full" id="category" name="category" required>
                            <option value="">Select Category</option>
                            <option value="medicine" <?php echo e(old('category', $inventory->category) === 'medicine' ? 'selected' : ''); ?>>Medicine</option>
                            <option value="supplies" <?php echo e(old('category', $inventory->category) === 'supplies' ? 'selected' : ''); ?>>Supplies</option>
                            <option value="equipment" <?php echo e(old('category', $inventory->category) === 'equipment' ? 'selected' : ''); ?>>Equipment</option>
                        </select>
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea class="form-input w-full" id="description" name="description" rows="3" placeholder="Enter item description..."><?php echo e(old('description', $inventory->description)); ?></textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Current Quantity <span class="text-red-500">*</span></label>
                        <input type="number" class="form-input w-full" id="quantity" name="quantity" value="<?php echo e(old('quantity', $inventory->quantity)); ?>" min="0" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Unit Price <span class="text-red-500">*</span></label>
                        <div class="flex items-center">
                            <span class="inline-block px-3 py-2 bg-gray-100 border border-gray-200 rounded-l">₱</span>
                            <input type="number" class="form-input w-full rounded-l-none" id="unit_price" name="unit_price" value="<?php echo e(old('unit_price', $inventory->unit_price)); ?>" step="0.01" min="0" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Reorder Level <span class="text-red-500">*</span></label>
                        <input type="number" class="form-input w-full" id="reorder_level" name="reorder_level" value="<?php echo e(old('reorder_level', $inventory->reorder_level)); ?>" min="0" required>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Supplier</label>
                        <input type="text" class="form-input w-full" id="supplier" name="supplier" value="<?php echo e(old('supplier', $inventory->supplier)); ?>" placeholder="Enter supplier name">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Expiration Date</label>
                        <input type="date" class="form-input w-full" id="expiry_date" name="expiry_date" value="<?php echo e(old('expiry_date', $inventory->expiry_date ? $inventory->expiry_date->format('Y-m-d') : '')); ?>">
                    </div>
                </div>
                <div class="mb-6">
                    <label class="inline-flex items-center">
                        <input class="form-checkbox" type="checkbox" id="is_active" name="is_active" value="1" <?php echo e(old('is_active', $inventory->is_active) ? 'checked' : ''); ?>>
                        <span class="ml-2 text-gray-700">Active Item</span>
                    </label>
                    <p class="text-xs text-gray-500 mt-1">Uncheck to deactivate this item</p>
                </div>
                <div class="flex justify-end space-x-3">
                    <a href="<?php echo e(route('doctor.inventory.show', $inventory)); ?>" class="btn-secondary">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save mr-2"></i>Update Item
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<style>

</style>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\doctor\inventory\edit.blade.php ENDPATH**/ ?>