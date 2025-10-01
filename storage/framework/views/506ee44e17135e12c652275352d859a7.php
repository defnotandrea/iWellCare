<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #888; padding: 6px; text-align: left; }
        th { background: #f0f0f0; }
    </style>
</head>
<body>
    <h2>Medical Records Report</h2>
    <table>
        <thead>
            <tr>
                <th>Patient</th>
                <th>Type</th>
                <th>Date</th>
                <th>Doctor</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $medicalRecords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($record->patient->first_name ?? '-'); ?> <?php echo e($record->patient->last_name ?? ''); ?></td>
                    <td><?php echo e(ucfirst($record->record_type)); ?></td>
                    <td><?php echo e($record->record_date ? $record->record_date->format('Y-m-d') : '-'); ?></td>
                    <td><?php echo e($record->doctor->first_name ?? '-'); ?> <?php echo e($record->doctor->last_name ?? ''); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</body>
</html> <?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\staff\reports\export_pdf.blade.php ENDPATH**/ ?>