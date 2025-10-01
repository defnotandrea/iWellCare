

<?php $__env->startSection('title', 'Inventory Item Details - iWellCare'); ?>
<?php $__env->startSection('page-title', 'Inventory Item Details'); ?>
<?php $__env->startSection('page-subtitle', 'View and manage inventory item information'); ?>

<?php $__env->startPush('scripts'); ?>
<script>
let currentItemId = null;
let currentActionButton = null;

function showEditModal() {
    document.getElementById('editItemModal').classList.remove('hidden');
}

function hideEditModal() {
    document.getElementById('editItemModal').classList.add('hidden');
}

// Handle form submission
document.getElementById('editInventoryForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    // Show loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Updating...';
    
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Item updated successfully!');
            window.location.reload();
        } else {
            alert('Error: ' + (data.message || 'Failed to update item'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating the item.');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<!-- Header Actions -->
<div class="flex justify-between items-center mb-8">
    <div>
        <h3 class="text-lg font-semibold text-gray-900"><?php echo e($inventory->name); ?></h3>
        <p class="text-gray-600">Inventory item details and management</p>
    </div>
    <div class="flex space-x-3">
        <button onclick="showEditModal()" class="btn-primary">
            <i class="fas fa-edit mr-2"></i>Edit Item
        </button>
        <a href="<?php echo e(route('doctor.inventory.index')); ?>" class="btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Back to Inventory
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-1 gap-8">
    <!-- Main Content -->
    <div class="space-y-8">
        <!-- Item Information -->
        <div class="card">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-xl font-bold text-gray-900">Item Information</h3>
                <p class="text-gray-600 text-sm">Basic item details and specifications</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Item Name</label>
                        <p class="text-lg font-semibold text-gray-900"><?php echo e($inventory->name); ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                            <?php echo e(ucfirst($inventory->category)); ?>

                        </span>
                    </div>
                </div>
                
                <?php if($inventory->description): ?>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <p class="text-gray-900"><?php echo e($inventory->description); ?></p>
                </div>
                <?php endif; ?>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Current Quantity</label>
                        <div class="flex items-center">
                            <span class="text-2xl font-bold text-gray-900"><?php echo e($inventory->quantity); ?></span>
                            <?php if($inventory->isLowStock()): ?>
                                <i class="fas fa-exclamation-triangle text-yellow-500 ml-2" title="Low Stock"></i>
                            <?php endif; ?>
                            <?php if($inventory->isOutOfStock()): ?>
                                <i class="fas fa-times-circle text-red-500 ml-2" title="Out of Stock"></i>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Unit Price</label>
                        <p class="text-lg font-semibold text-gray-900"><?php echo e($inventory->formatted_unit_price); ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Total Value</label>
                        <p class="text-lg font-semibold text-gray-900"><?php echo e($inventory->formatted_total_value); ?></p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Reorder Level</label>
                        <p class="text-lg font-semibold text-gray-900"><?php echo e($inventory->reorder_level); ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                            <?php echo e($inventory->isOutOfStock() ? 'bg-red-100 text-red-800' : ''); ?>

                            <?php echo e($inventory->isLowStock() ? 'bg-yellow-100 text-yellow-800' : ''); ?>

                            <?php echo e(!$inventory->isOutOfStock() && !$inventory->isLowStock() ? 'bg-green-100 text-green-800' : ''); ?>">
                            <?php echo e($inventory->isOutOfStock() ? 'Out of Stock' : ($inventory->isLowStock() ? 'Low Stock' : 'In Stock')); ?>

                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Active Status</label>
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                            <?php echo e($inventory->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'); ?>">
                            <?php echo e($inventory->is_active ? 'Active' : 'Inactive'); ?>

                        </span>
                    </div>
                </div>

                <?php if($inventory->supplier): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Supplier</label>
                        <p class="text-lg font-semibold text-gray-900"><?php echo e($inventory->supplier); ?></p>
                    </div>
                    <?php if($inventory->expiry_date): ?>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Expiration Date</label>
                        <div class="flex items-center">
                            <p class="text-lg font-semibold text-gray-900"><?php echo e($inventory->expiry_date->format('F d, Y')); ?></p>
                            <?php if($inventory->isExpiredOrExpiringSoon()): ?>
                                <i class="fas fa-exclamation-triangle text-yellow-500 ml-2" title="Expiring Soon"></i>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Stock History -->
        <div class="card">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-xl font-bold text-gray-900">Stock History</h3>
                <p class="text-gray-600 text-sm">Recent stock adjustments and changes</p>
            </div>
            <div class="p-6">
                <?php if($inventory->logs->count() > 0): ?>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Adjustment</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">By</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php $__currentLoopData = $inventory->logs->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        <?php echo e($log->adjusted_at->format('M d, Y g:i A')); ?>

                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                            <?php echo e($log->adjustment_quantity > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                            <?php echo e($log->formatted_adjustment); ?>

                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        <?php echo e($log->notes ?? 'No notes'); ?>

                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        <?php echo e($log->adjustedBy->full_name ?? 'Unknown'); ?>

                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if($inventory->logs->count() > 10): ?>
                        <div class="text-center mt-4">
                            <a href="#" class="btn-secondary">
                                View All History (<?php echo e($inventory->logs->count()); ?> records)
                            </a>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="text-center py-12">
                        <i class="fas fa-history text-4xl text-gray-300 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Stock History</h3>
                        <p class="text-gray-600">No stock history available for this item</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Item Details -->
        <div class="card">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-xl font-bold text-gray-900">Item Details</h3>
                <p class="text-gray-600 text-sm">Additional item information</p>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Created</label>
                        <p class="text-sm font-semibold text-gray-900">
                            <?php echo e($inventory->created_at ? $inventory->created_at->format('M d, Y g:i A') : 'N/A'); ?>

                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Last Updated</label>
                        <p class="text-sm font-semibold text-gray-900">
                            <?php echo e($inventory->updated_at ? $inventory->updated_at->format('M d, Y g:i A') : 'N/A'); ?>

                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Updated By</label>
                        <p class="text-sm font-semibold text-gray-900">
                            <?php echo e($inventory->updatedBy->full_name ?? 'Unknown'); ?>

                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Item ID</label>
                        <p class="text-sm font-semibold text-gray-900">#<?php echo e($inventory->id); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stock Alerts -->
        <?php if($inventory->isLowStock() || $inventory->isExpiredOrExpiringSoon()): ?>
        <div class="card border-yellow-200">
            <div class="px-6 py-4 border-b border-yellow-200 bg-yellow-50">
                <h3 class="text-xl font-bold text-yellow-800">Alerts</h3>
                <p class="text-yellow-600 text-sm">Important notifications for this item</p>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    <?php if($inventory->isLowStock()): ?>
                    <div class="flex items-start p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <i class="fas fa-exclamation-triangle text-yellow-600 mt-1 mr-3"></i>
                        <div>
                            <p class="text-sm font-semibold text-yellow-800">Low Stock</p>
                            <p class="text-sm text-yellow-700">Quantity (<?php echo e($inventory->quantity); ?>) is below reorder level (<?php echo e($inventory->reorder_level); ?>)</p>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if($inventory->isExpiredOrExpiringSoon()): ?>
                    <div class="flex items-start p-3 bg-red-50 border border-red-200 rounded-lg">
                        <i class="fas fa-calendar-times text-red-600 mt-1 mr-3"></i>
                        <div>
                            <p class="text-sm font-semibold text-red-800">Expiring Soon</p>
                            <p class="text-sm text-red-700">Expires on <?php echo e($inventory->expiry_date->format('M d, Y')); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Edit Item Modal -->
<div id="editItemModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center z-50">
    <div class="relative p-8 border w-2/3 max-w-4xl mx-auto rounded-lg shadow-lg bg-white">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-gray-900">Edit Item: <?php echo e($inventory->name); ?></h3>
            <button onclick="hideEditModal()" class="text-gray-400 hover:text-gray-700 text-2xl font-bold focus:outline-none">&times;</button>
        </div>
        <form id="editInventoryForm" method="POST" action="<?php echo e(route('doctor.inventory.update', $inventory)); ?>" class="space-y-6">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Item Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="editItemName" class="form-input w-full" value="<?php echo e($inventory->name); ?>" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category <span class="text-red-500">*</span></label>
                    <select name="category" id="editCategory" class="form-input w-full" required>
                        <option value="">Select Category</option>
                        <option value="medicine" <?php echo e($inventory->category == 'medicine' ? 'selected' : ''); ?>>Medicine</option>
                        <option value="equipment" <?php echo e($inventory->category == 'equipment' ? 'selected' : ''); ?>>Equipment</option>
                        <option value="supplies" <?php echo e($inventory->category == 'supplies' ? 'selected' : ''); ?>>Supplies</option>
                        <option value="other" <?php echo e($inventory->category == 'other' ? 'selected' : ''); ?>>Other</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" id="editDescription" class="form-input w-full" rows="3"><?php echo e($inventory->description); ?></textarea>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Quantity <span class="text-red-500">*</span></label>
                    <input type="number" name="quantity" id="editQuantity" class="form-input w-full" min="0" value="<?php echo e($inventory->quantity); ?>" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Unit Price <span class="text-red-500">*</span></label>
                    <div class="flex items-center">
                        <span class="inline-block px-3 py-2 bg-gray-100 border border-gray-200 rounded-l">₱</span>
                        <input type="number" name="unit_price" id="editUnitPrice" class="form-input w-full rounded-l-none" min="0.01" step="0.01" value="<?php echo e($inventory->unit_price); ?>" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Reorder Level <span class="text-red-500">*</span></label>
                    <input type="number" name="reorder_level" id="editReorderLevel" class="form-input w-full" min="0" value="<?php echo e($inventory->reorder_level); ?>" required>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Supplier</label>
                    <input type="text" name="supplier" id="editSupplier" class="form-input w-full" value="<?php echo e($inventory->supplier); ?>">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Expiration Date</label>
                    <input type="date" name="expiry_date" id="editExpirationDate" class="form-input w-full" value="<?php echo e($inventory->expiry_date ? $inventory->expiry_date->format('Y-m-d') : ''); ?>">
                </div>
            </div>
            <div>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_active" id="editIsActive" value="1" <?php echo e($inventory->is_active ? 'checked' : ''); ?> class="form-checkbox">
                    <span class="ml-2 text-gray-700">Active Item</span>
                </label>
                <p class="text-xs text-gray-500 mt-1">Uncheck to deactivate this item</p>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="hideEditModal()" class="btn-secondary">
                    <i class="fas fa-times mr-2"></i>Cancel
                </button>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save mr-2"></i>Update Item
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\doctor\inventory\show.blade.php ENDPATH**/ ?>