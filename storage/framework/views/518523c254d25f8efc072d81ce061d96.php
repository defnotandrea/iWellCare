<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #<?php echo e($invoice->id); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 20px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 10px;
        }
        .invoice-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .patient-info, .invoice-info {
            flex: 1;
        }
        .patient-info h3, .invoice-info h3 {
            color: #2563eb;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .total-row {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">iWellCare</div>
        <div>Healthcare Management System</div>
    </div>

    <div class="invoice-details">
        <div class="patient-info">
            <h3>Patient Information</h3>
            <p><strong>Name:</strong> <?php echo e($invoice->patient->first_name); ?> <?php echo e($invoice->patient->last_name); ?></p>
            <p><strong>Email:</strong> <?php echo e($invoice->patient->email); ?></p>
            <p><strong>Phone:</strong> <?php echo e($invoice->patient->phone); ?></p>
            <p><strong>Address:</strong> <?php echo e($invoice->patient->address); ?></p>
        </div>
        <div class="invoice-info">
            <h3>Invoice Information</h3>
            <p><strong>Invoice #:</strong> <?php echo e($invoice->id); ?></p>
            <p><strong>Date:</strong> <?php echo e($invoice->created_at->format('F j, Y')); ?></p>
            <p><strong>Due Date:</strong> <?php echo e($invoice->created_at->addDays(30)->format('F j, Y')); ?></p>
            <p><strong>Status:</strong> <?php echo e(ucfirst($invoice->status)); ?></p>
        </div>
    </div>

    <?php if($invoice->appointment): ?>
    <div class="appointment-details">
        <h3>Appointment Details</h3>
        <p><strong>Doctor:</strong> Dr. <?php echo e($invoice->appointment->doctor->first_name); ?> <?php echo e($invoice->appointment->doctor->last_name); ?></p>
        <p><strong>Date:</strong> <?php echo e($invoice->appointment->appointment_date->format('F j, Y')); ?></p>
        <p><strong>Time:</strong> <?php echo e($invoice->appointment->appointment_time); ?></p>
        <p><strong>Type:</strong> <?php echo e($invoice->appointment->appointment_type); ?></p>
    </div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Consultation Fee</td>
                <td>₱<?php echo e(number_format($invoice->consultation_fee ?? 0, 2)); ?></td>
            </tr>
            <?php if(($invoice->medication_fee ?? 0) > 0): ?>
            <tr>
                <td>Medication Fee</td>
                <td>₱<?php echo e(number_format($invoice->medication_fee ?? 0, 2)); ?></td>
            </tr>
            <?php endif; ?>
            <?php if(($invoice->laboratory_fee ?? 0) > 0): ?>
            <tr>
                <td>Laboratory Fee</td>
                <td>₱<?php echo e(number_format($invoice->laboratory_fee ?? 0, 2)); ?></td>
            </tr>
            <?php endif; ?>
            <?php if(($invoice->other_fees ?? 0) > 0): ?>
            <tr>
                <td>Other Fees</td>
                <td>₱<?php echo e(number_format($invoice->other_fees ?? 0, 2)); ?></td>
            </tr>
            <?php endif; ?>
            <tr class="total-row">
                <td><strong>Total Amount</strong></td>
                <td><strong>₱<?php echo e(number_format($invoice->total_amount ?? $invoice->amount, 2)); ?></strong></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Thank you for choosing iWellCare for your healthcare needs.</p>
        <p>For any questions, please contact us at support@iwellcare.com</p>
        <p>Generated on <?php echo e(now()->format('F j, Y \a\t g:i A')); ?></p>
    </div>
</body>
</html> <?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\patient\invoice\pdf.blade.php ENDPATH**/ ?>