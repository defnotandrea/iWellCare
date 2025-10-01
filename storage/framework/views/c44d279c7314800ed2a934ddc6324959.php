<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Sales Report - <?php echo e(\Carbon\Carbon::parse($month)->format('F Y')); ?></title>
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
            width: 25%;
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
            background-color: #f8f9fa;
            vertical-align: middle;
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
        .badge-secondary {
            background-color: #6c757d;
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
        <h1>Monthly Sales Report</h1>
        <p><strong>Clinic:</strong> Adult Wellness Clinic and Medical Laboratory</p>
        <p><strong>Period:</strong> <?php echo e(\Carbon\Carbon::parse($month)->format('F Y')); ?></p>
        <p><strong>Generated:</strong> <?php echo e(\Carbon\Carbon::now()->format('F d, Y \a\t g:i A')); ?></p>
        <p><strong>iWellCare Healthcare System</strong></p>
    </div>

    <!-- Sales Summary -->
    <div class="section">
        <h2>Sales Summary</h2>
        <div class="stats-grid">
            <div class="stats-row">
                <div class="stats-cell">
                    <h3>₱<?php echo e(number_format($salesData['total_revenue'], 2)); ?></h3>
                    <p>Total Revenue</p>
                </div>
                <div class="stats-cell">
                    <h3><?php echo e($salesData['total_consultations']); ?></h3>
                    <p>Consultations</p>
                </div>
                <div class="stats-cell">
                    <h3><?php echo e($salesData['total_appointments']); ?></h3>
                    <p>Appointments</p>
                </div>
                <div class="stats-cell">
                    <h3><?php echo e($salesData['new_patients']); ?></h3>
                    <p>New Patients</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Daily Revenue Breakdown -->
    <div class="section">
        <h2>Daily Revenue Breakdown</h2>
        <?php if($salesData['daily_revenue']->count() > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Consultations</th>
                        <th>Revenue</th>
                        <th>Average per Consultation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $salesData['daily_revenue']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $daily): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e(\Carbon\Carbon::parse($daily['date'])->format('M d, Y (D)')); ?></td>
                        <td class="text-center"><?php echo e($daily['revenue'] / 500); ?></td>
                        <td class="text-right"><strong>₱<?php echo e(number_format($daily['revenue'], 2)); ?></strong></td>
                        <td class="text-right">₱500.00</td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-muted">No revenue data available for this month</p>
        <?php endif; ?>
    </div>

    <div class="page-break"></div>

    <!-- Appointments -->
    <div class="section">
        <h2>Appointments (<?php echo e($appointments->count()); ?>)</h2>
        <?php if($appointments->count() > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Patient Name</th>
                        <th>Contact</th>
                        <th>Status</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($appointment->appointment_date->format('M d, Y')); ?></td>
                        <td><strong><?php echo e($appointment->patient->first_name); ?> <?php echo e($appointment->patient->last_name); ?></strong></td>
                        <td><?php echo e($appointment->patient->contact); ?></td>
                        <td>
                            <span class="badge badge-<?php echo e($appointment->status === 'confirmed' ? 'success' : ($appointment->status === 'pending' ? 'warning' : 'secondary')); ?>">
                                <?php echo e(ucfirst($appointment->status)); ?>

                            </span>
                        </td>
                        <td><?php echo e($appointment->appointment_time ?? 'N/A'); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-muted">No appointments for this month</p>
        <?php endif; ?>
    </div>

    <!-- Consultations -->
    <div class="section">
        <h2>Consultations (<?php echo e($consultations->count()); ?>)</h2>
        <?php if($consultations->count() > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Patient Name</th>
                        <th>Doctor</th>
                        <th>Status</th>
                        <th>Diagnosis</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $consultations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $consultation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($consultation->consultation_date->format('M d, Y')); ?></td>
                        <td><strong><?php echo e($consultation->patient->first_name); ?> <?php echo e($consultation->patient->last_name); ?></strong></td>
                        <td><?php echo e($consultation->doctor->first_name ?? 'N/A'); ?></td>
                        <td>
                            <span class="badge badge-<?php echo e($consultation->status === 'completed' ? 'success' : ($consultation->status === 'in_progress' ? 'warning' : 'secondary')); ?>">
                                <?php echo e(ucfirst($consultation->status)); ?>

                            </span>
                        </td>
                        <td><?php echo e(Str::limit($consultation->diagnosis ?? 'No diagnosis', 50)); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-muted">No consultations for this month</p>
        <?php endif; ?>
    </div>

    <div class="footer">
        <p>This report was generated automatically by the iWellCare Healthcare System.</p>
        <p>For questions or support, please contact your system administrator.</p>
    </div>
</body>
</html> <?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\doctor\reports\pdf\monthly-sales.blade.php ENDPATH**/ ?>