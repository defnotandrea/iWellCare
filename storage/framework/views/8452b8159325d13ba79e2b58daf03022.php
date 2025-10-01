<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo e($title); ?></title>
    <style>
        @page { margin: 24px 24px 60px 24px; }
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; line-height: 1.5; color: #111827; }
        .header { text-align: center; border-bottom: 2px solid #0891b2; padding-bottom: 10px; margin-bottom: 16px; }
        .header h1 { color: #0891b2; margin: 0; font-size: 22px; font-weight: 700; }
        .header p { margin: 4px 0; color: #6b7280; }
        .stats { display: flex; justify-content: space-between; gap: 8px; margin-bottom: 16px; flex-wrap: wrap; }
        .stat-box { border: 1px solid #e5e7eb; padding: 10px; text-align: center; flex: 1; background-color: #f8fafc; }
        .stat-box h3 { margin: 0; color: #0e7490; font-size: 16px; font-weight: 700; }
        .stat-box p { margin: 4px 0 0 0; font-size: 11px; color: #6b7280; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; table-layout: fixed; }
        th, td { border: 1px solid #e5e7eb; padding: 8px; text-align: left; font-size: 11px; word-wrap: break-word; }
        th { background-color: #0891b2; color: #ffffff; font-weight: 700; }
        tbody tr:nth-child(even) { background-color: #f9fafb; }
        .status-badge { padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: 700; }
        .status-active { background-color: #bbf7d0; color: #065f46; }
        .status-inactive { background-color: #cbd5e1; color: #334155; }
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
            <p>Total Patients</p>
        </div>
        <div class="stat-box">
            <h3><?php echo e($active); ?></h3>
            <p>Active</p>
        </div>
        <div class="stat-box">
            <h3><?php echo e($inactive); ?></h3>
            <p>Inactive</p>
        </div>
        <div class="stat-box">
            <h3><?php echo e($new_this_month); ?></h3>
            <p>New This Month</p>
        </div>
        <div class="stat-box">
            <h3><?php echo e($with_appointments); ?></h3>
            <p>With Appointments</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Patient</th>
                <th>Contact Info</th>
                <th>Demographics</th>
                <th>Activity</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td>
                    <strong><?php echo e($patient->first_name); ?> <?php echo e($patient->last_name); ?></strong><br>
                    <small>ID: <?php echo e($patient->id); ?></small>
                </td>
                <td>
                    <strong>Email:</strong> <?php echo e($patient->email ? $patient->email : 'N/A'); ?><br>
                    <strong>Phone:</strong> <?php echo e($patient->contact ? $patient->contact : 'N/A'); ?><br>
                    <?php if($patient->address): ?>
                        <strong>Address:</strong> <?php echo e(Str::limit($patient->address, 30)); ?>

                    <?php endif; ?>
                </td>
                <td>
                    <strong>Age:</strong> <?php echo e($patient->age ? $patient->age : 'N/A'); ?> years<br>
                    <strong>Gender:</strong> <?php echo e(ucfirst($patient->gender ? $patient->gender : 'N/A')); ?><br>
                    <?php if($patient->date_of_birth): ?>
                        <?php $dob = \Carbon\Carbon::parse($patient->date_of_birth); ?>
                        <strong>DOB:</strong> <?php echo e($dob->format('M d, Y')); ?>

                    <?php endif; ?>
                </td>
                <td>
                    <strong>Appointments:</strong> <?php echo e($patient->appointments->count()); ?><br>
                    <strong>Consultations:</strong> <?php echo e($patient->consultations->count()); ?><br>
                    <?php if($patient->appointments->count() > 0): ?>
                        <?php
                            $lastAppointment = $patient->appointments->sortByDesc('appointment_date')->first();
                            $lastVisit = $lastAppointment && $lastAppointment->appointment_date ? \Carbon\Carbon::parse($lastAppointment->appointment_date)->format('M d, Y') : null;
                        ?>
                        <?php if($lastVisit): ?>
                            <strong>Last Visit:</strong> <?php echo e($lastVisit); ?>

                        <?php endif; ?>
                    <?php endif; ?>
                </td>
                <td>
                    <span class="status-badge status-<?php echo e($patient->is_active ? 'active' : 'inactive'); ?>">
                        <?php echo e($patient->is_active ? 'Active' : 'Inactive'); ?>

                    </span>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="5" style="text-align: center;">No patients found.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        <p>This report was generated automatically by the iWellCare Healthcare System. Page <span class="pagenum"></span></p>
    </div>
</body>
</html> <?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\staff\reports\pdf\patients.blade.php ENDPATH**/ ?>