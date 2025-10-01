<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo e($title); ?></title>
    <style>
        @page { margin: 24px 24px 60px 24px; }
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; line-height: 1.5; color: #111827; }
        .header { text-align: center; border-bottom: 2px solid #16a34a; padding-bottom: 10px; margin-bottom: 16px; }
        .header h1 { color: #16a34a; margin: 0; font-size: 22px; font-weight: 700; }
        .header p { margin: 4px 0; color: #6b7280; }
        .stats { display: flex; justify-content: space-between; gap: 8px; margin-bottom: 16px; flex-wrap: wrap; }
        .stat-box { border: 1px solid #e5e7eb; padding: 10px; text-align: center; flex: 1; background-color: #f8fafc; }
        .stat-box h3 { margin: 0; color: #15803d; font-size: 16px; font-weight: 700; }
        .stat-box p { margin: 4px 0 0 0; font-size: 11px; color: #6b7280; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; table-layout: fixed; }
        th, td { border: 1px solid #e5e7eb; padding: 8px; text-align: left; font-size: 11px; word-wrap: break-word; }
        th { background-color: #16a34a; color: #ffffff; font-weight: 700; }
        tbody tr:nth-child(even) { background-color: #f9fafb; }
        .status-badge { padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: 700; }
        .status-pending { background-color: #fde68a; color: #92400e; }
        .status-in_progress { background-color: #bae6fd; color: #0c4a6e; }
        .status-completed { background-color: #bbf7d0; color: #065f46; }
        .status-cancelled { background-color: #fecaca; color: #7f1d1d; }
        .footer { position: fixed; bottom: 0; left: 24px; right: 24px; height: 40px; text-align: center; font-size: 10px; color: #6b7280; border-top: 1px solid #e5e7eb; padding-top: 8px; }
        .pagenum:after { content: counter(page) " of " counter(pages); }
    </style>
</head>
<body>
    <div class="header">
        <h1><?php echo e($title); ?></h1>
        <p>Generated on: <?php echo e($generated_at); ?></p>
        <p>iWellCare Healthcare System</p>
    </div>

    <div class="stats">
        <div class="stat-box">
            <h3><?php echo e($total); ?></h3>
            <p>Total Consultations</p>
        </div>
        <div class="stat-box">
            <h3><?php echo e($completed); ?></h3>
            <p>Completed</p>
        </div>
        <div class="stat-box">
            <h3><?php echo e($in_progress); ?></h3>
            <p>In Progress</p>
        </div>
        <div class="stat-box">
            <h3><?php echo e($pending); ?></h3>
            <p>Pending</p>
        </div>
        <div class="stat-box">
            <h3><?php echo e($cancelled); ?></h3>
            <p>Cancelled</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Patient</th>
                <th>Doctor</th>
                <th>Date</th>
                <th>Type</th>
                <th>Status</th>
                <th>Diagnosis</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $consultations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $consultation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td>
                    <strong><?php echo e($consultation->patient->first_name); ?> <?php echo e($consultation->patient->last_name); ?></strong><br>
                    <small><?php echo e($consultation->patient->email); ?></small>
                </td>
                <td>
                    <strong><?php echo e($consultation->doctor->first_name); ?> <?php echo e($consultation->doctor->last_name); ?></strong><br>
                    <?php if($consultation->doctor->specialization): ?>
                        <small><?php echo e($consultation->doctor->specialization); ?></small>
                    <?php endif; ?>
                </td>
                <td>
                    <?php
                        $created = $consultation->created_at ?? null;
                        $dateStr = $created ? \Carbon\Carbon::parse($created)->format('M d, Y') : 'N/A';
                        $timeStr = $created ? \Carbon\Carbon::parse($created)->format('H:i') : '';
                    ?>
                    <strong><?php echo e($dateStr); ?></strong><br>
                    <small><?php echo e($timeStr); ?></small>
                </td>
                <td><?php echo e($consultation->consultation_type ? $consultation->consultation_type : 'General'); ?></td>
                <td>
                    <span class="status-badge status-<?php echo e($consultation->status); ?>">
                        <?php echo e(ucfirst(str_replace('_', ' ', $consultation->status))); ?>

                    </span>
                </td>
                <td>
                    <?php if($consultation->diagnosis): ?>
                        <?php echo e(Str::limit($consultation->diagnosis, 50)); ?>

                    <?php else: ?>
                        <em>No diagnosis</em>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="6" style="text-align: center;">No consultations found.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        <p>This report was generated automatically by the iWellCare Healthcare System. Page <span class="pagenum"></span></p>
    </div>
</body>
</html> <?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\staff\reports\pdf\consultations.blade.php ENDPATH**/ ?>