

<?php $__env->startSection('title', 'Inventory Item Details - iWellCare'); ?>
<?php $__env->startSection('page-title', 'Inventory Item Details'); ?>
<?php $__env->startSection('page-subtitle', 'View complete information about this item'); ?>

<?php $__env->startSection('content'); ?>
<div class="inventory-content">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Inventory Item Details</h2>
            <p class="text-gray-600">Complete information about <?php echo e($item->name); ?></p>
        </div>
        <div class="flex gap-3">
            <a href="<?php echo e(route('staff.inventory.edit', $item->id)); ?>" class="btn btn-secondary">
                <i class="fas fa-edit mr-2"></i>Edit Item
            </a>
            <a href="<?php echo e(route('staff.inventory.index')); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left mr-2"></i>Back to Inventory
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column - Basic Info -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Basic Information Card -->
            <div class="card p-6">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center">
                        <?php if($item->category === 'medicine'): ?>
                            <i class="fas fa-pills text-blue-600 text-2xl"></i>
                        <?php elseif($item->category === 'supplies'): ?>
                            <i class="fas fa-first-aid text-green-600 text-2xl"></i>
                        <?php else: ?>
                            <i class="fas fa-stethoscope text-purple-600 text-2xl"></i>
                        <?php endif; ?>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900"><?php echo e($item->name); ?></h3>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            <?php if($item->category === 'medicine'): ?> bg-blue-100 text-blue-800
                            <?php elseif($item->category === 'supplies'): ?> bg-green-100 text-green-800
                            <?php else: ?> bg-purple-100 text-purple-800 <?php endif; ?>">
                            <?php echo e(ucfirst($item->category)); ?>

                        </span>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600 font-medium">Item ID</span>
                        <span class="text-gray-800 font-mono"><?php echo e($item->id); ?></span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600 font-medium">Quantity</span>
                        <span class="text-lg font-semibold <?php echo e($item->quantity <= $item->reorder_level ? 'text-red-600' : 'text-green-600'); ?>">
                            <?php echo e($item->quantity); ?>

                            <?php if($item->quantity <= $item->reorder_level): ?>
                                <span class="text-sm text-red-500">(Low Stock)</span>
                            <?php endif; ?>
                        </span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600 font-medium">Unit Price</span>
                        <span class="text-gray-800 font-semibold">₱<?php echo e(number_format($item->unit_price, 2)); ?></span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600 font-medium">Total Value</span>
                        <span class="text-lg font-bold text-blue-600">₱<?php echo e(number_format($item->quantity * $item->unit_price, 2)); ?></span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600 font-medium">Reorder Level</span>
                        <span class="text-gray-800"><?php echo e($item->reorder_level); ?></span>
                    </div>
                </div>
            </div>

            <!-- Stock Status Card -->
            <div class="card p-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">Stock Status</h4>
                
                <?php if($item->quantity <= 0): ?>
                    <div class="p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fas fa-exclamation-triangle text-red-600"></i>
                            <span class="font-semibold text-red-800">Out of Stock</span>
                        </div>
                        <p class="text-red-700 text-sm">This item needs immediate restocking</p>
                    </div>
                <?php elseif($item->quantity <= $item->reorder_level): ?>
                    <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                            <span class="font-semibold text-yellow-800">Low Stock</span>
                        </div>
                        <p class="text-yellow-700 text-sm">Stock is below reorder level</p>
                    </div>
                <?php else: ?>
                    <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fas fa-check-circle text-green-600"></i>
                            <span class="font-semibold text-green-800">In Stock</span>
                        </div>
                        <p class="text-green-700 text-sm">Stock level is adequate</p>
                    </div>
                <?php endif; ?>

                <?php if($item->expiration_date): ?>
                    <div class="mt-4 p-4 <?php echo e($item->expiration_date->isPast() ? 'bg-red-50 border-red-200' : ($item->expiration_date->diffInDays(now()) <= 30 ? 'bg-yellow-50 border-yellow-200' : 'bg-blue-50 border-blue-200')); ?> border rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fas fa-calendar-alt <?php echo e($item->expiration_date->isPast() ? 'text-red-600' : ($item->expiration_date->diffInDays(now()) <= 30 ? 'text-yellow-600' : 'text-blue-600')); ?>"></i>
                            <span class="font-semibold <?php echo e($item->expiration_date->isPast() ? 'text-red-800' : ($item->expiration_date->diffInDays(now()) <= 30 ? 'text-yellow-800' : 'text-blue-800')); ?>">
                                <?php if($item->expiration_date->isPast()): ?>
                                    Expired
                                <?php elseif($item->expiration_date->diffInDays(now()) <= 30): ?>
                                    Expiring Soon
                                <?php else: ?>
                                    Expiration Date
                                <?php endif; ?>
                            </span>
                        </div>
                        <p class="text-sm <?php echo e($item->expiration_date->isPast() ? 'text-red-700' : ($item->expiration_date->diffInDays(now()) <= 30 ? 'text-yellow-700' : 'text-blue-700')); ?>">
                            <?php echo e($item->expiration_date->format('M d, Y')); ?>

                            <?php if($item->expiration_date->isPast()): ?>
                                <span class="font-semibold">(<?php echo e($item->expiration_date->diffInDays(now())); ?> days ago)</span>
                            <?php elseif($item->expiration_date->diffInDays(now()) <= 30): ?>
                                <span class="font-semibold">(in <?php echo e($item->expiration_date->diffInDays(now())); ?> days)</span>
                            <?php else: ?>
                                <span class="font-semibold">(in <?php echo e($item->expiration_date->diffInDays(now())); ?> days)</span>
                            <?php endif; ?>
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Right Column - Detailed Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Detailed Information Card -->
            <div class="card p-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">Detailed Information</h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php if($item->description): ?>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <p class="text-gray-800"><?php echo e($item->description); ?></p>
                    </div>
                    <?php endif; ?>

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
                        <p class="text-gray-800 font-mono"><?php echo e($item->batch_number); ?></p>
                    </div>
                    <?php endif; ?>

                    <?php if($item->notes): ?>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                        <p class="text-gray-800"><?php echo e($item->notes); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- History Card -->
            <div class="card p-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">Item History</h4>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between py-3 border-b border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-plus text-blue-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Item Created</p>
                                <p class="text-sm text-gray-500"><?php echo e($item->created_at->format('M d, Y g:i A')); ?></p>
                            </div>
                        </div>
                    </div>

                    <?php if($item->updated_at && $item->updated_at != $item->created_at): ?>
                    <div class="flex items-center justify-between py-3 border-b border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-edit text-green-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Last Updated</p>
                                <p class="text-sm text-gray-500"><?php echo e($item->updated_at->format('M d, Y g:i A')); ?></p>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if($item->updated_by): ?>
                    <div class="flex items-center justify-between py-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-purple-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Updated By</p>
                                <p class="text-sm text-gray-500"><?php echo e($item->updatedBy->name ?? 'Unknown User'); ?></p>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="card p-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h4>
                
                <div class="flex flex-wrap gap-3">
                    <a href="<?php echo e(route('staff.inventory.edit', $item->id)); ?>" class="btn btn-primary">
                        <i class="fas fa-edit mr-2"></i>Edit Item
                    </a>
                    
                    <?php if($item->quantity <= $item->reorder_level): ?>
                    <button class="btn btn-warning" onclick="alert('Low stock alert sent to procurement team')">
                        <i class="fas fa-bell mr-2"></i>Request Restock
                    </button>
                    <?php endif; ?>
                    
                    <?php if($item->expiration_date && $item->expiration_date->diffInDays(now()) <= 30): ?>
                    <button class="btn btn-warning" onclick="alert('Expiration alert sent to staff')">
                        <i class="fas fa-exclamation-triangle mr-2"></i>Expiration Alert
                    </button>
                    <?php endif; ?>
                    
                    <form action="<?php echo e(route('staff.inventory.destroy', $item->id)); ?>" method="POST" class="inline" 
                          onsubmit="return confirm('Are you sure you want to delete this item? This action cannot be undone.')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash mr-2"></i>Delete Item
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.staff', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\staff\inventory\show.blade.php ENDPATH**/ ?>