

<?php $__env->startSection('title', 'Inventory Management - iWellCare'); ?>
<?php $__env->startSection('page-title', 'Inventory Management'); ?>
<?php $__env->startSection('page-subtitle', 'Monitor and manage medical supplies and equipment'); ?>

<?php $__env->startSection('content'); ?>
<!-- Welcome Banner -->
<div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white mb-8">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold">Inventory Management</h1>
                <p class="mt-2 text-blue-100">Monitor and manage medical supplies and equipment</p>
            </div>
            <div class="text-right">
                <div class="text-2xl font-bold"><?php echo e(now()->format('l')); ?></div>
                <div class="text-blue-100"><?php echo e(now()->format('F j, Y')); ?></div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <!-- Inventory Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Items -->
        <div class="bg-white overflow-hidden shadow-lg rounded-xl">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center">
                            <i class="fas fa-boxes text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-medium text-gray-500">Total Items</p>
                        <p class="text-3xl font-bold text-gray-900"><?php echo e($inventory->total()); ?></p>
                        <p class="text-sm text-gray-600">In inventory</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Low Stock Items -->
        <div class="bg-white overflow-hidden shadow-lg rounded-xl">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-yellow-500 rounded-xl flex items-center justify-center">
                            <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-medium text-gray-500">Low Stock Items</p>
                        <p class="text-3xl font-bold text-gray-900"><?php echo e($inventory->filter(fn($i) => $i->isLowStock())->count()); ?></p>
                        <p class="text-sm text-gray-600">Need attention</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Out of Stock Items -->
        <div class="bg-white overflow-hidden shadow-lg rounded-xl">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center">
                            <i class="fas fa-times-circle text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-medium text-gray-500">Out of Stock</p>
                        <p class="text-3xl font-bold text-gray-900"><?php echo e($inventory->filter(fn($i) => $i->isOutOfStock())->count()); ?></p>
                        <p class="text-sm text-gray-600">Critical items</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Value -->
        <div class="bg-white overflow-hidden shadow-lg rounded-xl">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center">
                            <i class="fas fa-dollar-sign text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-medium text-gray-500">Total Value</p>
                        <p class="text-3xl font-bold text-gray-900">₱<?php echo e(number_format($inventory->sum(fn($i) => $i->quantity * $i->unit_price), 2)); ?></p>
                        <p class="text-sm text-gray-600">Inventory worth</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Search and Actions -->
    <form method="GET" action="" class="bg-white shadow-lg rounded-xl p-6 mb-8">
        <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-4">
            <div class="flex flex-col sm:flex-row gap-4 flex-1">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Item Name</label>
                    <input type="text" name="name" value="<?php echo e(request('name')); ?>" placeholder="Search by item name..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">All Categories</option>
                        <option value="medicine" <?php echo e(request('category') === 'medicine' ? 'selected' : ''); ?>>Medicine</option>
                        <option value="supplies" <?php echo e(request('category') === 'supplies' ? 'selected' : ''); ?>>Medical Supplies</option>
                        <option value="equipment" <?php echo e(request('category') === 'equipment' ? 'selected' : ''); ?>>Equipment</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                        <i class="fas fa-search mr-2"></i>Search
                    </button>
                </div>
            </div>
            <a href="<?php echo e(route('admin.inventory.create')); ?>" class="px-6 py-3 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors font-semibold">
                <i class="fas fa-plus mr-2"></i>Add New Item
            </a>
        </div>
    </form>

    <?php if(session('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            <i class="fas fa-check-circle mr-2"></i><?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <!-- Inventory Items Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <?php $__empty_1 = true; $__currentLoopData = $inventory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white shadow-lg rounded-xl overflow-hidden hover:shadow-xl transition-shadow">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                <span class="text-blue-600 font-bold text-lg"><?php echo e(strtoupper(substr($item->name, 0, 1))); ?></span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900"><?php echo e($item->name); ?></h3>
                                <p class="text-sm text-gray-500 capitalize"><?php echo e($item->category); ?></p>
                            </div>
                        </div>
                        <?php
                            $statusClass = $item->isOutOfStock() ? 'bg-red-100 text-red-800' : ($item->isLowStock() ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800');
                            $statusLabel = $item->isOutOfStock() ? 'Out of Stock' : ($item->isLowStock() ? 'Low Stock' : 'In Stock');
                            $statusIcon = $item->isOutOfStock() ? 'fas fa-times-circle' : ($item->isLowStock() ? 'fas fa-exclamation-triangle' : 'fas fa-check-circle');
                        ?>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full <?php echo e($statusClass); ?>">
                            <i class="<?php echo e($statusIcon); ?> mr-1"></i><?php echo e($statusLabel); ?>

                        </span>
                    </div>

                    <div class="space-y-3 mb-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Quantity:</span>
                            <span class="font-semibold text-gray-900"><?php echo e($item->quantity); ?></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Unit Price:</span>
                            <span class="font-semibold text-gray-900">₱<?php echo e(number_format($item->unit_price, 2)); ?></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Total Value:</span>
                            <span class="font-semibold text-gray-900">₱<?php echo e(number_format($item->quantity * $item->unit_price, 2)); ?></span>
                        </div>
                        <?php if($item->expiration_date): ?>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500">Expires:</span>
                                <span class="font-semibold <?php echo e($item->expiration_date->isPast() ? 'text-red-600' : 'text-gray-900'); ?>">
                                    <?php echo e($item->expiration_date->format('M d, Y')); ?>

                                </span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="flex gap-2">
                        <a href="<?php echo e(route('admin.inventory.show', $item->id)); ?>"
                           class="flex-1 px-3 py-2 bg-blue-600 text-white text-center rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors text-sm font-medium">
                            <i class="fas fa-eye mr-1"></i>View
                        </a>
                        <a href="<?php echo e(route('admin.inventory.edit', $item->id)); ?>"
                           class="flex-1 px-3 py-2 bg-gray-600 text-white text-center rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors text-sm font-medium">
                            <i class="fas fa-edit mr-1"></i>Edit
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full">
                <div class="bg-white shadow-lg rounded-xl p-12 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-boxes text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No Inventory Items Found</h3>
                    <p class="text-gray-500 mb-6">Get started by adding your first inventory item.</p>
                    <a href="<?php echo e(route('admin.inventory.create')); ?>" class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors font-semibold">
                        <i class="fas fa-plus mr-2"></i>Add First Item
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if($inventory->hasPages()): ?>
        <div class="bg-white shadow-lg rounded-xl p-6">
            <div class="flex justify-center">
                <?php echo e($inventory->links()); ?>

            </div>
        </div>
    <?php endif; ?>


<?php $__env->startPush('scripts'); ?>
<script>
// Reset search form
function resetSearchForm() {
    // Clear all form inputs
    const form = document.querySelector('form[method="GET"]');
    if (form) {
        form.reset();
        // Submit the form to clear search parameters
        form.submit();
    }
}
</script>
<?php $__env->stopPush(); ?>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\admin\inventory\index.blade.php ENDPATH**/ ?>