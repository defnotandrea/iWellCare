

<?php $__env->startSection('title', 'Inventory Management - iWellCare'); ?>
<?php $__env->startSection('page-title', 'Inventory Management'); ?>
<?php $__env->startSection('page-subtitle', 'Manage your clinic inventory and supplies'); ?>

<?php $__env->startSection('content'); ?>
<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="card p-6" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Total Items</p>
                <p class="text-white text-3xl font-bold"><?php echo e($inventory->total()); ?></p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-boxes text-white text-xl"></i>
            </div>
        </div>
    </div>

    <div class="card p-6" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Low Stock</p>
                <p class="text-white text-3xl font-bold"><?php echo e($inventory->where('quantity', '<=', 'reorder_level')->count()); ?></p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-exclamation-triangle text-white text-xl"></i>
            </div>
        </div>
    </div>

    <div class="card p-6" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Out of Stock</p>
                <p class="text-white text-3xl font-bold"><?php echo e($inventory->where('quantity', '<=', 0)->count()); ?></p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-times-circle text-white text-xl"></i>
            </div>
        </div>
    </div>

    <div class="card p-6" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Categories</p>
                <p class="text-white text-3xl font-bold"><?php echo e($inventory->pluck('category')->unique()->count()); ?></p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-tags text-white text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filter Section -->
<div class="card mb-6">
    <div class="p-6">
        <form method="GET" action="<?php echo e(route('doctor.inventory.index')); ?>" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Items</label>
                    <input type="text" 
                           class="form-input w-full" 
                           id="search" 
                           name="search" 
                           value="<?php echo e(request('search')); ?>" 
                           placeholder="Search by name, description, or supplier">
                </div>
                
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select class="form-input w-full" id="category" name="category">
                        <option value="">All Categories</option>
                        <option value="medicine" <?php echo e(request('category') === 'medicine' ? 'selected' : ''); ?>>Medicine</option>
                        <option value="supplies" <?php echo e(request('category') === 'supplies' ? 'selected' : ''); ?>>Supplies</option>
                        <option value="equipment" <?php echo e(request('category') === 'equipment' ? 'selected' : ''); ?>>Equipment</option>
                    </select>
                </div>
                
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Stock Status</label>
                    <select class="form-input w-full" id="status" name="status">
                        <option value="">All Items</option>
                        <option value="low_stock" <?php echo e(request('status') === 'low_stock' ? 'selected' : ''); ?>>Low Stock</option>
                        <option value="out_of_stock" <?php echo e(request('status') === 'out_of_stock' ? 'selected' : ''); ?>>Out of Stock</option>
                        <option value="expiring" <?php echo e(request('status') === 'expiring' ? 'selected' : ''); ?>>Expiring Soon</option>
                    </select>
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="btn-primary w-full">
                        <i class="fas fa-search mr-2"></i>Search
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Inventory Table -->
<div class="card">
    <div class="px-6 py-4 border-b border-gray-100">
        <div class="flex justify-between items-center">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Inventory Items</h3>
                <p class="text-gray-600 text-sm">Manage your clinic inventory and supplies</p>
            </div>
            <a href="<?php echo e(route('doctor.inventory.create')); ?>" class="btn-primary">
                <i class="fas fa-plus mr-2"></i>Add New Item
            </a>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Price</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Value</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Updated</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $inventory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4">
                            <div>
                                <div class="text-sm font-medium text-gray-900"><?php echo e($item->name); ?></div>
                                <?php if($item->description): ?>
                                    <div class="text-sm text-gray-500"><?php echo e(Str::limit($item->description, 50)); ?></div>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                <?php echo e(ucfirst($item->category)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <span class="text-sm font-medium text-gray-900"><?php echo e($item->quantity); ?></span>
                                <?php if($item->isLowStock()): ?>
                                    <i class="fas fa-exclamation-triangle text-yellow-500 ml-2" title="Low Stock"></i>
                                <?php endif; ?>
                                <?php if($item->isOutOfStock()): ?>
                                    <i class="fas fa-times-circle text-red-500 ml-2" title="Out of Stock"></i>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900"><?php echo e($item->formatted_unit_price); ?></td>
                        <td class="px-6 py-4 text-sm text-gray-900"><?php echo e($item->formatted_total_value); ?></td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col space-y-1">
                                <?php if($item->isOutOfStock()): ?>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        Out of Stock
                                    </span>
                                <?php elseif($item->isLowStock()): ?>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Low Stock
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        In Stock
                                    </span>
                                <?php endif; ?>
                                <?php if($item->isExpiredOrExpiringSoon()): ?>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">
                                        Expiring Soon
                                    </span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            <?php
                                $lastUpdated = $item->last_updated ?? null;
                                $lastUpdatedStr = $lastUpdated ? \Carbon\Carbon::parse($lastUpdated)->format('M d, Y g:i A') : null;
                            ?>
                            <?php echo e($lastUpdatedStr ?? 'N/A'); ?>

                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <a href="<?php echo e(route('doctor.inventory.show', $item)); ?>" 
                                   class="text-blue-600 hover:text-blue-900 transition-colors duration-200"
                                   title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo e(route('doctor.inventory.edit', $item)); ?>"
                                   class="text-gray-600 hover:text-gray-900 transition-colors duration-200"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="px-6 py-12">
                            <div class="text-center">
                                <i class="fas fa-boxes text-4xl text-gray-300 mb-4"></i>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No inventory items found</h3>
                                <p class="text-gray-500 mb-4">Add your first inventory item to get started.</p>
                                <a href="<?php echo e(route('doctor.inventory.create')); ?>" class="btn-primary">
                                    <i class="fas fa-plus mr-2"></i>Add First Item
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <?php if($inventory->hasPages()): ?>
        <div class="px-6 py-4 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Showing <?php echo e($inventory->firstItem() ?? 0); ?> to <?php echo e($inventory->lastItem() ?? 0); ?> of <?php echo e($inventory->total()); ?> results
                </div>
                <div class="flex space-x-2">
                    <?php echo e($inventory->links()); ?>

                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('assets/js/modal-utils.js')); ?>"></script>
<script>
window.deleteItem = function(itemId, itemName) {
    console.log('deleteItem called', itemId, itemName);
    window.currentItemId = itemId;
    window.currentActionButton = event.target;
    const message = 'Are you sure you want to delete <strong>' + itemName + '</strong>?<br><br>This will permanently remove the item from inventory.<br><strong>This action cannot be undone!</strong>';
    ModalUtils.showConfirmation(
        'Delete Inventory Item',
        message,
        'danger',
        function() { window.performDelete(); },
        function() { window.currentActionButton = null; window.currentItemId = null; }
    );
}
window.performDelete = function() {
    if (!window.currentItemId || !window.currentActionButton) return;
    console.log('performDelete called for', window.currentItemId);
    const originalText = window.currentActionButton.innerHTML;
    window.currentActionButton.innerHTML = '<i class="fas fa-hourglass-half"></i>';
    window.currentActionButton.disabled = true;
    ModalUtils.showLoading('Deleting inventory item...');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    fetch('/doctor/inventory/' + window.currentItemId, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        credentials: 'same-origin'
    })
    .then(response => {
        console.log('Delete AJAX response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Delete AJAX response data:', data);
        ModalUtils.hideLoading();
        if (data.success) {
            ModalUtils.showSuccess(
                'Item Deleted Successfully',
                'The inventory item has been deleted successfully.',
                function() { location.reload(); }
            );
        } else {
            ModalUtils.showError(
                'Delete Failed',
                data.message || 'Unknown error occurred while deleting the item.'
            );
            window.currentActionButton.innerHTML = originalText;
            window.currentActionButton.disabled = false;
        }
    })
    .catch(error => {
        console.error('Delete AJAX error:', error);
        ModalUtils.hideLoading();
        ModalUtils.showError(
            'Network Error',
            'An error occurred while deleting the item. Please try again.'
        );
        window.currentActionButton.innerHTML = originalText;
        window.currentActionButton.disabled = false;
    });
};
window.showStockAdjustmentModal = function(itemId, itemName, action) {
    // Create modal content using Bootstrap-compatible HTML
    const modalHtml = '<div class="p-4">' +
        '<h3 class="h5 mb-3">Adjust Stock</h3>' +
        '<form id="stockAdjustmentForm">' +
            '<div class="mb-3">' +
                '<label class="form-label">Quantity Adjustment</label>' +
                '<div class="d-flex align-items-center gap-2">' +
                    '<button type="button" onclick="window.decrementQuantity()" class="btn btn-outline-secondary btn-sm">' +
                        '<i class="fas fa-minus"></i>' +
                    '</button>' +
                    '<input type="number" id="adjustmentQuantity" class="form-control text-center" value="0" min="-999" max="999" required>' +
                    '<button type="button" onclick="window.incrementQuantity()" class="btn btn-outline-secondary btn-sm">' +
                        '<i class="fas fa-plus"></i>' +
                    '</button>' +
                '</div>' +
                '<small class="text-muted">Use positive numbers to add stock, negative to remove</small>' +
            '</div>' +
            '<div class="mb-3">' +
                '<label class="form-label">Reason</label>' +
                '<textarea id="adjustmentReason" class="form-control" rows="3" placeholder="Enter reason for adjustment..." required></textarea>' +
            '</div>' +
            '<div class="d-flex justify-content-end gap-2">' +
                '<button type="button" onclick="ModalUtils.hideModal()" class="btn btn-secondary">Cancel</button>' +
                '<button type="submit" class="btn btn-primary">Confirm Adjustment</button>' +
            '</div>' +
        '</form>' +
    '</div>';
    
    ModalUtils.showModal(modalHtml);
    
    // Handle form submission
    document.getElementById('stockAdjustmentForm').addEventListener('submit', function(e) {
        e.preventDefault();
        performStockAdjustment(itemId, action);
    });
}
window.incrementQuantity = function() {
    const input = document.getElementById('adjustmentQuantity');
    input.value = parseInt(input.value || 0) + 1;
};
window.decrementQuantity = function() {
    const input = document.getElementById('adjustmentQuantity');
    input.value = parseInt(input.value || 0) - 1;
};

function performStockAdjustment(itemId, action) {
    const quantity = document.getElementById('adjustmentQuantity').value;
    const reason = document.getElementById('adjustmentReason').value;
    
    if (!quantity || !reason) {
        ModalUtils.showError('Validation Error', 'Please fill in all required fields.');
        return;
    }
    
    if (parseInt(quantity) === 0) {
        ModalUtils.showError('Invalid Quantity', 'Quantity adjustment cannot be zero.');
        return;
    }
    
    // Show loading state
    ModalUtils.showLoading('Processing stock adjustment...');
    
    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Send adjustment request
    fetch('/doctor/inventory/' + itemId + '/adjust-stock', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: JSON.stringify({
            quantity: parseInt(quantity),
            reason: reason,
            action: action // Pass the action (add or subtract)
        })
    })
    .then(response => response.json())
    .then(data => {
        ModalUtils.hideLoading();
        
        if (data.success) {
            ModalUtils.showSuccess(
                'Stock Adjusted Successfully',
                'Stock has been adjusted successfully.',
                () => {
                    // Reload the page to show updated quantity
                    window.location.reload();
                }
            );
        } else {
            ModalUtils.showError('Adjustment Failed', data.message || 'Failed to adjust stock.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        ModalUtils.hideLoading();
        ModalUtils.showError('Network Error', 'An error occurred while adjusting stock.');
    });
}
</script>
<?php $__env->stopPush(); ?> 
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\doctor\inventory\index.blade.php ENDPATH**/ ?>