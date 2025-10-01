<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Appointment Approved</title>
    <style>
        body { font-family: Arial, sans-serif; color: #111827; }
        .card { max-width: 560px; margin: 0 auto; padding: 16px; border: 1px solid #e5e7eb; border-radius: 8px; }
        .title { color: #16a34a; }
        .muted { color: #6b7280; font-size: 12px; }
    </style>
    </head>
<body>
    <div class="card">
        <h2 class="title">Your appointment is approved</h2>
        <p>Hi <?php echo e($user->first_name); ?>,</p>
        <p>Your appointment has been approved.</p>
        <ul>
            <li><strong>Date:</strong> <?php echo e(\Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y')); ?></li>
            <li><strong>Time:</strong> <?php echo e(substr($appointment->appointment_time,0,5)); ?></li>
            <li><strong>Status:</strong> Approved</li>
        </ul>
        <p class="muted">This is an automated message from iWellCare.</p>
    </div>
</body>
</html>

<?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\emails\appointment-approved.blade.php ENDPATH**/ ?>