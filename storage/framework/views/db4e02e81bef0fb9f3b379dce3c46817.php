

<?php $__env->startSection('title', 'Inventory Report - iWellCare'); ?>
<?php $__env->startSection('page-title', 'Inventory Report'); ?>
<?php $__env->startSection('page-subtitle', 'Comprehensive inventory analysis and reporting'); ?>

<?php $__env->startPush('styles'); ?>
<style>
@media print {
    .no-print {
        display: none !important;
    }
    .card {
        border: 1px solid #ddd !important;
        box-shadow: none !important;
        break-inside: avoid;
    }
    body {
        font-size: 12px !important;
        line-height: 1.4 !important;
    }
    .grid {
        display: block !important;
    }
    .grid-cols-1, .md\\:grid-cols-2, .lg\\:grid-cols-5 {
        display: block !important;
    }
    .gap-6 > * {
        margin-bottom: 20px !important;
    }
    table {
        font-size: 11px !important;
        width: 100% !important;
    }
    th, td {
        padding: 6px !important;
        border: 1px solid #ddd !important;
    }
    .page-break {
        page-break-before: always;
    }
    .print-header {
        text-align: center;
        border-bottom: 2px solid #007bff;
        padding-bottom: 20px;
        margin-bottom: 30px;
    }
    .print-header h1 {
        color: #007bff;
        margin: 0;
        font-size: 24px;
    }
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php if(request('print')): ?>
<div class="print-header">
    <h1>Inventory Report</h1>
    <p><strong>Generated:</strong> <?php echo e(\Carbon\Carbon::now()->format('F d, Y \a\t g:i A')); ?></p>
    <p><strong>iWellCare Healthcare System</strong></p>
</div>
<?php else: ?>
<!-- Search and Filters -->
<div class="card mb-6 no-print">
    <div class="p-6">
        <form method="GET" action="<?php echo e(route('doctor.reports.inventory-report')); ?>" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div class="md:col-span-2">
                <input type="text" class="form-input w-full" name="search" 
                       placeholder="Search by name, description, or supplier" 
                       value="<?php echo e(request('search')); ?>">
            </div>
            <div>
                <select class="form-input w-full" name="category">
                    <option value="">All Categories</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category); ?>" <?php echo e(request('category') === $category ? 'selected' : ''); ?>>
                            <?php echo e(ucfirst($category)); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>
                <select class="form-input w-full" name="status">
                    <option value="">All Status</option>
                    <option value="low_stock" <?php echo e(request('status') === 'low_stock' ? 'selected' : ''); ?>>Low Stock</option>
                    <option value="out_of_stock" <?php echo e(request('status') === 'out_of_stock' ? 'selected' : ''); ?>>Out of Stock</option>
                    <option value="expiring" <?php echo e(request('status') === 'expiring' ? 'selected' : ''); ?>>Expiring Soon</option>
                </select>
            </div>
            <div class="flex space-x-2">
                <button type="submit" class="btn-primary">Search</button>
                <a href="<?php echo e(route('doctor.reports.inventory-report')); ?>" class="btn-secondary">Clear</a>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<!-- Statistics Overview -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
    <div class="card p-6" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Total Items</p>
                <p class="text-white text-3xl font-bold"><?php echo e($inventoryStats['total']); ?></p>
                <p class="text-blue-100 text-xs">Inventory Items</p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-boxes text-white text-xl"></i>
            </div>
        </div>
    </div>

    <div class="card p-6" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-pink-100 text-sm font-medium">Low Stock</p>
                <p class="text-white text-3xl font-bold"><?php echo e($inventoryStats['low_stock']); ?></p>
                <p class="text-pink-100 text-xs">Below Reorder Level</p>
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
                <p class="text-white text-3xl font-bold"><?php echo e($inventoryStats['out_of_stock']); ?></p>
                <p class="text-blue-100 text-xs">Zero Quantity</p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-times-circle text-white text-xl"></i>
            </div>
        </div>
    </div>

    <div class="card p-6" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm font-medium">Expiring Soon</p>
                <p class="text-white text-3xl font-bold"><?php echo e($inventoryStats['expiring_soon']); ?></p>
                <p class="text-green-100 text-xs">Next 30 Days</p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-clock text-white text-xl"></i>
            </div>
        </div>
    </div>

    <div class="card p-6" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-yellow-100 text-sm font-medium">Total Value</p>
                <p class="text-white text-3xl font-bold">₱<?php echo e(number_format($inventoryStats['total_value'], 2)); ?></p>
                <p class="text-yellow-100 text-xs">Inventory Worth</p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-dollar-sign text-white text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Inventory Table -->
<div class="table-container">
    <div class="table-header">
        <div class="flex items-center justify-between">
            <h3 class="text-xl font-bold">Inventory Items</h3>
            <?php if(!request('print')): ?>
            <div class="flex space-x-3">
                <button type="button" onclick="exportToPdf()" class="btn-primary">
                    <i class="fas fa-file-pdf mr-2"></i>Export PDF
                </button>
                <button type="button" onclick="exportToExcel()" class="btn-secondary">
                    <i class="fas fa-file-excel mr-2"></i>Export Excel
                </button>
                <button type="button" onclick="printReport()" class="btn-secondary">
                    <i class="fas fa-print mr-2"></i>Print
                </button>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Item</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Category</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Quantity</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Unit Price</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Total Value</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Supplier</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Last Updated</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $inventory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-box text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900"><?php echo e($item->name); ?></div>
                                <div class="text-sm text-gray-500"><?php echo e(Str::limit($item->description, 50)); ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-700">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            <?php echo e(ucfirst($item->category)); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-700">
                        <div class="flex items-center">
                            <span class="font-semibold"><?php echo e($item->quantity); ?></span>
                            <span class="text-gray-500 ml-1"><?php echo e($item->unit); ?></span>
                        </div>
                        <?php if($item->quantity <= $item->reorder_level): ?>
                            <div class="text-xs text-red-600 mt-1">
                                <i class="fas fa-exclamation-triangle mr-1"></i>Reorder Level: <?php echo e($item->reorder_level); ?>

                            </div>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-700">₱<?php echo e(number_format($item->unit_price, 2)); ?></td>
                    <td class="px-6 py-4 text-sm text-gray-700 font-semibold">
                        ₱<?php echo e(number_format($item->quantity * $item->unit_price, 2)); ?>

                    </td>
                    <td class="px-6 py-4">
                        <?php if($item->quantity <= 0): ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                Out of Stock
                            </span>
                        <?php elseif($item->quantity <= $item->reorder_level): ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                Low Stock
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                In Stock
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-700"><?php echo e($item->supplier ?? 'Not specified'); ?></td>
                    <td class="px-6 py-4 text-sm text-gray-700">
                        <?php echo e($item->updated_at ? $item->updated_at->format('M d, Y') : 'Never'); ?>

                        <?php if($item->updatedBy): ?>
                            <div class="text-xs text-gray-500">by <?php echo e($item->updatedBy->name); ?></div>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-boxes text-gray-400 text-2xl"></i>
                            </div>
                            <p class="text-gray-500 font-medium">No inventory items found</p>
                            <p class="text-gray-400 text-sm mt-1">Try adjusting your search criteria</p>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <?php if($inventory->hasPages()): ?>
    <div class="px-6 py-4 border-t border-gray-200">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
                Showing <?php echo e($inventory->firstItem()); ?> to <?php echo e($inventory->lastItem()); ?> of <?php echo e($inventory->total()); ?> results
            </div>
            <div class="flex space-x-2">
                <?php echo e($inventory->links()); ?>

            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Export Forms -->
<form id="pdfExportForm" action="<?php echo e(route('doctor.reports.export-pdf')); ?>" method="POST" style="display: none;">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="type" value="inventory">
    <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
    <input type="hidden" name="category" value="<?php echo e(request('category')); ?>">
    <input type="hidden" name="status" value="<?php echo e(request('status')); ?>">
</form>

<form id="excelExportForm" action="<?php echo e(route('doctor.reports.export-excel')); ?>" method="POST" style="display: none;">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="type" value="inventory">
    <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
    <input type="hidden" name="category" value="<?php echo e(request('category')); ?>">
    <input type="hidden" name="status" value="<?php echo e(request('status')); ?>">
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Auto-print if print parameter is present
<?php if(request('print')): ?>
window.addEventListener('load', function() {
    setTimeout(function() {
        window.print();
    }, 500);
});
<?php endif; ?>

function exportToPdf() {
    document.getElementById('pdfExportForm').submit();
}

function exportToExcel() {
    document.getElementById('excelExportForm').submit();
}

function printReport() {
    window.print();
}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\doctor\reports\inventory-report.blade.php ENDPATH**/ ?>