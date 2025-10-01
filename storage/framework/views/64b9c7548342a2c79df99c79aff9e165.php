<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #007bff;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        .stats-row {
            display: table-row;
        }
        .stats-cell {
            display: table-cell;
            width: 20%;
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
            background-color: #f8f9fa;
        }
        .stats-cell h3 {
            margin: 0;
            font-size: 18px;
            color: #007bff;
        }
        .stats-cell p {
            margin: 5px 0;
            font-size: 11px;
            color: #666;
        }
        .section {
            margin-bottom: 30px;
        }
        .section h2 {
            color: #007bff;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .text-muted {
            color: #666;
        }
        .badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-success {
            background-color: #28a745;
            color: white;
        }
        .badge-warning {
            background-color: #ffc107;
            color: #212529;
        }
        .badge-danger {
            background-color: #dc3545;
            color: white;
        }
        .badge-secondary {
            background-color: #6c757d;
            color: white;
        }
        .badge-info {
            background-color: #17a2b8;
            color: white;
        }
        .page-break {
            page-break-before: always;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Inventory Report</h1>
        <p><strong>Clinic:</strong> Adult Wellness Clinic and Medical Laboratory</p>
        <p><strong>Generated:</strong> <?php echo e(\Carbon\Carbon::now()->format('F d, Y \a\t g:i A')); ?></p>
        <p><strong>iWellCare Healthcare System</strong></p>
    </div>

    <!-- Inventory Statistics -->
    <div class="section">
        <h2>Inventory Overview</h2>
        <div class="stats-grid">
            <div class="stats-row">
                <div class="stats-cell">
                    <h3><?php echo e($inventoryStats['total']); ?></h3>
                    <p>Total Items</p>
                </div>
                <div class="stats-cell">
                    <h3><?php echo e($inventoryStats['low_stock']); ?></h3>
                    <p>Low Stock</p>
                </div>
                <div class="stats-cell">
                    <h3><?php echo e($inventoryStats['out_of_stock']); ?></h3>
                    <p>Out of Stock</p>
                </div>
                <div class="stats-cell">
                    <h3><?php echo e($inventoryStats['expiring_soon']); ?></h3>
                    <p>Expiring Soon</p>
                </div>
                <div class="stats-cell">
                    <h3>₱<?php echo e(number_format($inventoryStats['total_value'], 2)); ?></h3>
                    <p>Total Value</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Inventory List -->
    <div class="section">
        <h2>Inventory Items (<?php echo e($inventory->count()); ?> total)</h2>
        <?php if($inventory->count() > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total Value</th>
                        <th>Status</th>
                        <th>Expiry Date</th>
                        <th>Last Updated</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $inventory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <strong><?php echo e($item->name); ?></strong><br>
                            <small class="text-muted"><?php echo e(Str::limit($item->description, 50)); ?></small>
                        </td>
                        <td>
                            <span class="badge badge-info"><?php echo e(ucfirst($item->category)); ?></span>
                        </td>
                        <td class="text-center">
                            <strong><?php echo e(number_format($item->quantity)); ?></strong>
                        </td>
                        <td class="text-right">₱<?php echo e(number_format($item->unit_price, 2)); ?></td>
                        <td class="text-right">₱<?php echo e(number_format($item->quantity * $item->unit_price, 2)); ?></td>
                        <td>
                            <?php if($item->quantity <= 0): ?>
                                <span class="badge badge-danger">Out of Stock</span>
                            <?php elseif($item->quantity <= $item->reorder_level): ?>
                                <span class="badge badge-warning">Low Stock</span>
                            <?php else: ?>
                                <span class="badge badge-success">In Stock</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($item->expiration_date): ?>
                                <?php if($item->expiration_date <= now()->addDays(30)): ?>
                                    <span class="badge badge-warning"><?php echo e($item->expiration_date->format('M d, Y')); ?></span>
                                <?php else: ?>
                                    <small class="text-muted"><?php echo e($item->expiration_date->format('M d, Y')); ?></small>
                                <?php endif; ?>
                            <?php else: ?>
                                <small class="text-muted">No expiry</small>
                            <?php endif; ?>
                        </td>
                        <td>
                            <small class="text-muted">
                                <?php echo e($item->updated_at->format('M d, Y')); ?><br>
                                <?php echo e($item->updated_at->format('g:i A')); ?>

                            </small>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-muted">No inventory items found</p>
        <?php endif; ?>
    </div>

    <!-- Low Stock Alerts -->
    <?php
        $lowStockItems = $inventory->filter(function($item) {
            return $item->quantity <= $item->reorder_level;
        });
    ?>
    
    <?php if($lowStockItems->count() > 0): ?>
    <div class="section">
        <h2>Low Stock Alerts (<?php echo e($lowStockItems->count()); ?> items)</h2>
        <table>
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Category</th>
                    <th>Current Stock</th>
                    <th>Reorder Level</th>
                    <th>Unit Price</th>
                    <th>Supplier</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $lowStockItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><strong><?php echo e($item->name); ?></strong></td>
                    <td><span class="badge badge-info"><?php echo e(ucfirst($item->category)); ?></span></td>
                    <td class="text-center">
                        <span class="badge badge-warning"><?php echo e($item->quantity); ?></span>
                    </td>
                    <td class="text-center"><?php echo e($item->reorder_level); ?></td>
                    <td class="text-right">₱<?php echo e(number_format($item->unit_price, 2)); ?></td>
                    <td><?php echo e($item->supplier ?? 'N/A'); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <!-- Expiring Items -->
    <?php
        $expiringItems = $inventory->filter(function($item) {
            return $item->expiration_date && $item->expiration_date <= now()->addDays(30) && $item->expiration_date > now();
        });
    ?>
    
    <?php if($expiringItems->count() > 0): ?>
    <div class="section">
        <h2>Expiring Soon (<?php echo e($expiringItems->count()); ?> items)</h2>
        <table>
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>Expiry Date</th>
                    <th>Days Until Expiry</th>
                    <th>Unit Price</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $expiringItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><strong><?php echo e($item->name); ?></strong></td>
                    <td><span class="badge badge-info"><?php echo e(ucfirst($item->category)); ?></span></td>
                    <td class="text-center"><?php echo e($item->quantity); ?></td>
                    <td>
                        <span class="badge badge-warning"><?php echo e($item->expiration_date->format('M d, Y')); ?></span>
                    </td>
                    <td class="text-center">
                        <?php
                            $daysUntilExpiry = $item->expiration_date->diffInDays(now());
                        ?>
                        <span class="badge badge-<?php echo e($daysUntilExpiry <= 7 ? 'danger' : 'warning'); ?>">
                            <?php echo e($daysUntilExpiry); ?> days
                        </span>
                    </td>
                    <td class="text-right">₱<?php echo e(number_format($item->unit_price, 2)); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <div class="footer">
        <p>This report was generated automatically by the iWellCare Healthcare System.</p>
        <p>For questions or support, please contact your system administrator.</p>
    </div>
</body>
</html> <?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\doctor\reports\pdf\inventory.blade.php ENDPATH**/ ?>