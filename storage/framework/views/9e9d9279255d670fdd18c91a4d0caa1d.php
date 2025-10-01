

<?php $__env->startSection('title', 'Monthly Sales Report - iWellCare'); ?>
<?php $__env->startSection('page-title', 'Monthly Sales Report'); ?>
<?php $__env->startSection('page-subtitle'); ?>
    Sales and revenue analysis for <?php echo e(\Carbon\Carbon::parse($month)->format('F Y')); ?>

<?php $__env->stopSection(); ?>

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
    .grid-cols-1, .md\\:grid-cols-2, .lg\\:grid-cols-4 {
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
    <h1>Monthly Sales Report</h1>
    <p><strong>Period:</strong> <?php echo e(\Carbon\Carbon::parse($month)->format('F Y')); ?></p>
    <p><strong>Generated:</strong> <?php echo e(\Carbon\Carbon::now()->format('F d, Y \a\t g:i A')); ?></p>
    <p><strong>iWellCare Healthcare System</strong></p>
</div>
<?php else: ?>
<!-- Header Actions -->
<div class="flex justify-between items-center mb-8 no-print">
    <div>
        <h3 class="text-lg font-semibold text-gray-900">Monthly Sales Analysis</h3>
        <p class="text-gray-600">Comprehensive sales and revenue breakdown</p>
    </div>
    <a href="<?php echo e(route('doctor.reports.index')); ?>" class="btn-secondary">
        <i class="fas fa-arrow-left mr-2"></i>Back to Reports
    </a>
</div>

<!-- Month Selector -->
<div class="card mb-8 no-print">
    <div class="px-6 py-4 border-b border-gray-100">
        <h3 class="text-xl font-bold text-gray-900">Select Month</h3>
        <p class="text-gray-600 text-sm">Choose the month for your sales analysis</p>
    </div>
    <div class="p-6">
        <form method="GET" action="<?php echo e(route('doctor.reports.monthly-sales')); ?>" class="flex items-end space-x-4">
            <div class="flex-1">
                <label for="month" class="block text-sm font-medium text-gray-700 mb-2">Select Month</label>
                <input type="month" 
                       class="form-input w-full" 
                       id="month" 
                       name="month" 
                       value="<?php echo e($month); ?>" 
                       onchange="this.form.submit()">
            </div>
            <button type="submit" class="btn-primary">
                <i class="fas fa-search mr-2"></i>Generate Report
            </button>
        </form>
    </div>
</div>

<!-- Sales Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="card p-6" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Total Revenue</p>
                <p class="text-white text-3xl font-bold">₱<?php echo e(number_format($salesData['total_revenue'], 0)); ?></p>
                <p class="text-blue-100 text-xs">This Month</p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-peso-sign text-white text-xl"></i>
            </div>
        </div>
    </div>

    <div class="card p-6" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Consultations</p>
                <p class="text-white text-3xl font-bold"><?php echo e($salesData['total_consultations']); ?></p>
                <p class="text-blue-100 text-xs">Completed</p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-stethoscope text-white text-xl"></i>
            </div>
        </div>
    </div>

    <div class="card p-6" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Appointments</p>
                <p class="text-white text-3xl font-bold"><?php echo e($salesData['total_appointments']); ?></p>
                <p class="text-blue-100 text-xs">Scheduled</p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-calendar-check text-white text-xl"></i>
            </div>
        </div>
    </div>

    <div class="card p-6" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">New Patients</p>
                <p class="text-white text-3xl font-bold"><?php echo e($salesData['new_patients']); ?></p>
                <p class="text-blue-100 text-xs">This Month</p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-user-plus text-white text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Daily Revenue Breakdown -->
<div class="card mb-8">
    <div class="px-6 py-4 border-b border-gray-100">
        <h3 class="text-xl font-bold text-gray-900">Daily Revenue Breakdown</h3>
        <p class="text-gray-600 text-sm">Daily revenue analysis for <?php echo e(\Carbon\Carbon::parse($month)->format('F Y')); ?></p>
    </div>
    <div class="p-6">
        <?php if($salesData['daily_revenue']->count() > 0): ?>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Consultations</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoices</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Average per Consultation</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__currentLoopData = $salesData['daily_revenue']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $daily): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                <?php echo e(\Carbon\Carbon::parse($daily['date'])->format('M d, Y (D)')); ?>

                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    <?php echo e($daily['consultations']); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    <?php echo e($daily['invoices']); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                ₱<?php echo e(number_format($daily['revenue'], 2)); ?>

                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <?php if($daily['consultations'] > 0): ?>
                                    ₱<?php echo e(number_format($daily['revenue'] / $daily['consultations'], 2)); ?>

                                <?php else: ?>
                                    ₱0.00
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <i class="fas fa-chart-line text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Revenue Data</h3>
                <p class="text-gray-600">No revenue data available for this month</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Appointments and Consultations -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Appointments -->
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-xl font-bold text-gray-900">Appointments (<?php echo e($appointments->count()); ?>)</h3>
            <p class="text-gray-600 text-sm">Scheduled appointments for this month</p>
        </div>
        <div class="p-6">
            <?php if($appointments->count() > 0): ?>
                <div class="space-y-3">
                    <?php $__currentLoopData = $appointments->take(8); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <div class="font-semibold text-gray-900">
                                    <?php echo e($appointment->patient->first_name); ?> <?php echo e($appointment->patient->last_name); ?>

                                </div>
                                <div class="text-sm text-gray-600">
                                    <?php echo e($appointment->appointment_date->format('M d, Y')); ?> at <?php echo e($appointment->appointment_time ?? 'N/A'); ?>

                                </div>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    <?php echo e($appointment->status === 'confirmed' ? 'bg-green-100 text-green-800' : ''); ?>

                                    <?php echo e($appointment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ''); ?>

                                    <?php echo e($appointment->status === 'cancelled' ? 'bg-red-100 text-red-800' : ''); ?>">
                                    <?php echo e(ucfirst($appointment->status)); ?>

                                </span>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php if($appointments->count() > 8): ?>
                    <div class="text-center mt-4">
                        <p class="text-sm text-gray-500">Showing first 8 of <?php echo e($appointments->count()); ?> appointments</p>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="text-center py-8">
                    <i class="fas fa-calendar-check text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Appointments</h3>
                    <p class="text-gray-600">No appointments for this month</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Consultations -->
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-xl font-bold text-gray-900">Consultations (<?php echo e($consultations->count()); ?>)</h3>
            <p class="text-gray-600 text-sm">Completed consultations for this month</p>
        </div>
        <div class="p-6">
            <?php if($consultations->count() > 0): ?>
                <div class="space-y-3">
                    <?php $__currentLoopData = $consultations->take(8); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $consultation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <div class="font-semibold text-gray-900">
                                    <?php echo e($consultation->patient->first_name); ?> <?php echo e($consultation->patient->last_name); ?>

                                </div>
                                <div class="text-sm text-gray-600">
                                    <?php echo e($consultation->consultation_date->format('M d, Y')); ?> - Dr. <?php echo e($consultation->doctor->first_name ?? 'N/A'); ?>

                                </div>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    <?php echo e($consultation->status === 'completed' ? 'bg-green-100 text-green-800' : ''); ?>

                                    <?php echo e($consultation->status === 'in_progress' ? 'bg-yellow-100 text-yellow-800' : ''); ?>

                                    <?php echo e($consultation->status === 'cancelled' ? 'bg-red-100 text-red-800' : ''); ?>">
                                    <?php echo e(ucfirst($consultation->status)); ?>

                                </span>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php if($consultations->count() > 8): ?>
                    <div class="text-center mt-4">
                        <p class="text-sm text-gray-500">Showing first 8 of <?php echo e($consultations->count()); ?> consultations</p>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="text-center py-8">
                    <i class="fas fa-stethoscope text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Consultations</h3>
                    <p class="text-gray-600">No consultations for this month</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php if(!request('print')): ?>
<!-- Export Options -->
<div class="card no-print">
    <div class="px-6 py-4 border-b border-gray-100">
        <h3 class="text-xl font-bold text-gray-900">Export Options</h3>
        <p class="text-gray-600 text-sm">Download or share your monthly sales report</p>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-md mx-auto">
            <button type="button"
                    class="flex flex-col items-center p-4 border-2 border-blue-200 rounded-lg hover:border-blue-300 hover:bg-blue-50 transition-all duration-200"
                    onclick="exportReport('monthly_sales', '<?php echo e($month); ?>')">
                <i class="fas fa-file-pdf text-2xl text-blue-600 mb-2"></i>
                <span class="font-semibold text-gray-900">Export PDF</span>
                <span class="text-sm text-gray-600">Download Report</span>
            </button>

            <button type="button"
                    class="flex flex-col items-center p-4 border-2 border-green-200 rounded-lg hover:border-green-300 hover:bg-green-50 transition-all duration-200"
                    onclick="exportReport('monthly_sales_excel', '<?php echo e($month); ?>')">
                <i class="fas fa-file-excel text-2xl text-green-600 mb-2"></i>
                <span class="font-semibold text-gray-900">Export Excel</span>
                <span class="text-sm text-gray-600">Spreadsheet Format</span>
            </button>


        </div>
    </div>
</div>
<?php endif; ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('assets/js/modal-utils.js')); ?>"></script>
<script>
// Auto-print if print parameter is present
<?php if(request('print')): ?>
window.addEventListener('load', function() {
    setTimeout(function() {
        window.print();
    }, 500);
});
<?php endif; ?>

function exportReport(type, month) {
    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Create form data for file download
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/doctor/reports/export-pdf';
    form.target = '_blank';

    // Add CSRF token
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = csrfToken;
    form.appendChild(csrfInput);

    // Add report type
    const typeInput = document.createElement('input');
    typeInput.type = 'hidden';
    typeInput.name = 'type';
    typeInput.value = type;
    form.appendChild(typeInput);

    // Add month parameter
    const monthInput = document.createElement('input');
    monthInput.type = 'hidden';
    monthInput.name = 'month';
    monthInput.value = month;
    form.appendChild(monthInput);

    // Add form to page and submit
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}

function printReport() {
    window.print();
}

function shareReport() {
    alert('Share functionality will be implemented in the next update.');
}
</script>
<?php $__env->stopPush(); ?> 
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\doctor\reports\monthly-sales.blade.php ENDPATH**/ ?>