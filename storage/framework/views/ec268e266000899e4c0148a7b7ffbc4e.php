<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation Summary Report</title>
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
        .chart-container {
            margin: 20px 0;
            text-align: center;
        }
        .chart-bar {
            display: inline-block;
            width: 80px;
            margin: 0 10px;
            text-align: center;
        }
        .chart-bar-fill {
            background-color: #007bff;
            height: 120px;
            margin-bottom: 5px;
            position: relative;
        }
        .chart-bar-label {
            font-size: 10px;
            color: #666;
        }
        .chart-bar-value {
            font-size: 11px;
            font-weight: bold;
            color: #007bff;
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
        <h1>Consultation Summary Report</h1>
        <p><strong>Period:</strong> <?php echo e(\Carbon\Carbon::parse($startDate)->format('M d, Y')); ?> - <?php echo e(\Carbon\Carbon::parse($endDate)->format('M d, Y')); ?></p>
        <p><strong>Generated:</strong> <?php echo e(\Carbon\Carbon::now()->format('F d, Y \a\t g:i A')); ?></p>
        <p><strong>iWellCare Healthcare System</strong></p>
    </div>

    <!-- Consultation Statistics -->
    <div class="section">
        <h2>Consultation Overview</h2>
        <div class="stats-grid">
            <div class="stats-row">
                <div class="stats-cell">
                    <h3><?php echo e($consultationStats['total']); ?></h3>
                    <p>Total Consultations</p>
                </div>
                <div class="stats-cell">
                    <h3><?php echo e($consultationStats['completed']); ?></h3>
                    <p>Completed</p>
                </div>
                <div class="stats-cell">
                    <h3><?php echo e($consultationStats['in_progress']); ?></h3>
                    <p>In Progress</p>
                </div>
                <div class="stats-cell">
                    <h3><?php echo e($consultationStats['average_duration']); ?></h3>
                    <p>Avg Duration</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Distribution Chart -->
    <div class="section">
        <h2>Consultation Status Distribution</h2>
        <div class="chart-container">
            <?php
                $total = $consultationStats['total'];
                $completed = $consultationStats['completed'];
                $inProgress = $consultationStats['in_progress'];
                
                $completedHeight = $total > 0 ? ($completed / $total) * 120 : 0;
                $inProgressHeight = $total > 0 ? ($inProgress / $total) * 120 : 0;
                $pendingHeight = $total > 0 ? (($total - $completed - $inProgress) / $total) * 120 : 0;
            ?>
            
            <div class="chart-bar">
                <div class="chart-bar-fill" style="height: <?php echo e($completedHeight); ?>px; background-color: #28a745;"></div>
                <div class="chart-bar-value"><?php echo e($completed); ?></div>
                <div class="chart-bar-label">Completed</div>
            </div>
            <div class="chart-bar">
                <div class="chart-bar-fill" style="height: <?php echo e($inProgressHeight); ?>px; background-color: #ffc107;"></div>
                <div class="chart-bar-value"><?php echo e($inProgress); ?></div>
                <div class="chart-bar-label">In Progress</div>
            </div>
            <div class="chart-bar">
                <div class="chart-bar-fill" style="height: <?php echo e($pendingHeight); ?>px; background-color: #6c757d;"></div>
                <div class="chart-bar-value"><?php echo e($total - $completed - $inProgress); ?></div>
                <div class="chart-bar-label">Pending</div>
            </div>
        </div>
    </div>

    <!-- Performance Metrics -->
    <div class="section">
        <h2>Performance Metrics</h2>
        <?php
            $completionRate = $total > 0 ? round(($completed / $total) * 100, 1) : 0;
            $inProgressRate = $total > 0 ? round(($inProgress / $total) * 100, 1) : 0;
            $pendingRate = $total > 0 ? round((($total - $completed - $inProgress) / $total) * 100, 1) : 0;
        ?>
        
        <div style="margin: 20px 0;">
            <div style="margin-bottom: 15px;">
                <strong>Completion Rate:</strong> <?php echo e($completionRate); ?>% (<?php echo e($completed); ?> of <?php echo e($total); ?> consultations)
            </div>
            <div style="margin-bottom: 15px;">
                <strong>In Progress Rate:</strong> <?php echo e($inProgressRate); ?>% (<?php echo e($inProgress); ?> of <?php echo e($total); ?> consultations)
            </div>
            <div style="margin-bottom: 15px;">
                <strong>Pending Rate:</strong> <?php echo e($pendingRate); ?>% (<?php echo e($total - $completed - $inProgress); ?> of <?php echo e($total); ?> consultations)
            </div>
            <div style="margin-bottom: 15px;">
                <strong>Average Duration:</strong> <?php echo e($consultationStats['average_duration']); ?>

            </div>
        </div>
    </div>

    <!-- Top Doctors by Consultations -->
    <div class="section">
        <h2>Top Doctors by Consultations</h2>
        <?php
            $topDoctors = $consultations->groupBy('doctor_id')
                ->map(function ($consultations, $doctorId) {
                    $doctor = $consultations->first()->doctor;
                    return [
                        'doctor' => $doctor,
                        'count' => $consultations->count(),
                        'completed' => $consultations->where('status', 'completed')->count(),
                        'in_progress' => $consultations->where('status', 'in_progress')->count()
                    ];
                })
                ->sortByDesc('count')
                ->take(5);
        ?>
        
        <?php if($topDoctors->count() > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Doctor Name</th>
                        <th>Total Consultations</th>
                        <th>Completed</th>
                        <th>In Progress</th>
                        <th>Completion Rate</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $topDoctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $doctorData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="text-center"><?php echo e($index + 1); ?></td>
                        <td><strong><?php echo e($doctorData['doctor']->first_name ?? 'N/A'); ?></strong></td>
                        <td class="text-center"><?php echo e($doctorData['count']); ?></td>
                        <td class="text-center"><?php echo e($doctorData['completed']); ?></td>
                        <td class="text-center"><?php echo e($doctorData['in_progress']); ?></td>
                        <td class="text-center">
                            <?php echo e($doctorData['count'] > 0 ? round(($doctorData['completed'] / $doctorData['count']) * 100, 1) : 0); ?>%
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-muted">No doctor data available</p>
        <?php endif; ?>
    </div>

    <div class="footer">
        <p>This report was generated automatically by the iWellCare Healthcare System.</p>
        <p>For questions or support, please contact your system administrator.</p>
    </div>
</body>
</html> <?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\doctor\reports\pdf\consultation-summary.blade.php ENDPATH**/ ?>