

<?php $__env->startSection('title', 'Appointments Report'); ?>

<?php $__env->startPush('styles'); ?>
<style>
@media print {
    /* Hide layout elements */
    nav, .navbar, .sidebar, .fixed, .z-50, .z-40 {
        display: none !important;
    }

    /* Hide modal and overlay */
    .fixed.inset-0.bg-black, #alertModal {
        display: none !important;
    }

    /* Hide no-print elements */
    .no-print {
        display: none !important;
    }

    /* Reset layout */
    body {
        font-size: 12px !important;
        line-height: 1.4 !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .flex, .flex-1, .ml-64, .min-h-screen {
        display: block !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        min-height: auto !important;
    }

    /* Card styling */
    .card {
        border: 1px solid #ddd !important;
        box-shadow: none !important;
        break-inside: avoid;
        margin-bottom: 20px !important;
    }

    /* Bootstrap layout fixes */
    .container-fluid, .row, .col-12, .col-xl-3, .col-md-6, .col-lg-3 {
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        float: none !important;
        display: block !important;
    }

    /* Table styling */
    table {
        font-size: 11px !important;
        width: 100% !important;
        margin-bottom: 20px !important;
    }

    th, td {
        padding: 6px !important;
        border: 1px solid #ddd !important;
    }

    /* Page breaks */
    .page-break {
        page-break-before: always;
    }

    /* Print header */
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

    /* Hide pagination links */
    .pagination, .d-flex.justify-content-center {
        display: none !important;
    }
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php if(request('print')): ?>
<div class="print-header">
    <h1>Appointments Report</h1>
    <p><strong>Generated:</strong> <?php echo e(\Carbon\Carbon::now()->format('F d, Y \a\t g:i A')); ?></p>
    <p><strong>iWellCare Healthcare System</strong></p>
</div>
<?php endif; ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-calendar-check me-2"></i>Appointments Report
                    </h1>
                    <p class="text-muted mb-0">View and analyze appointment data</p>
                </div>
                <div>
                    <button type="button" class="btn btn-success me-2" onclick="exportReport()">
                        <i class="fas fa-file-pdf me-2"></i>Export PDF
                    </button>
                    <button type="button" class="btn btn-info me-2 no-print" onclick="printReport()">
                        <i class="fas fa-print me-2"></i>Print Report
                    </button>
                    <a href="<?php echo e(route('staff.reports.index')); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Reports
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Filter Options</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('staff.reports.appointments')); ?>" class="row g-3">
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All Status</option>
                        <option value="pending" <?php echo e(request('status') === 'pending' ? 'selected' : ''); ?>>Pending</option>
                        <option value="confirmed" <?php echo e(request('status') === 'confirmed' ? 'selected' : ''); ?>>Confirmed</option>
                        <option value="completed" <?php echo e(request('status') === 'completed' ? 'selected' : ''); ?>>Completed</option>
                        <option value="cancelled" <?php echo e(request('status') === 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="date_from" class="form-label">Date From</label>
                    <input type="date" class="form-control" id="date_from" name="date_from" value="<?php echo e(request('date_from')); ?>">
                </div>
                <div class="col-md-3">
                    <label for="date_to" class="form-label">Date To</label>
                    <input type="date" class="form-control" id="date_to" name="date_to" value="<?php echo e(request('date_to')); ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid gap-2 d-md-flex">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>Filter
                        </button>
                        <a href="<?php echo e(route('staff.reports.appointments')); ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Appointments
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($appointments->total()); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Confirmed
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($appointments->where('status', 'confirmed')->count()); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pending
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($appointments->where('status', 'pending')->count()); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Completed
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($appointments->where('status', 'completed')->count()); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-double fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Appointments Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Appointments</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Date & Time</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Notes</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <strong><?php echo e($appointment->patient->first_name); ?> <?php echo e($appointment->patient->last_name); ?></strong>
                                <br><small class="text-muted"><?php echo e($appointment->patient->email); ?></small>
                            </td>
                            <td>
                                <strong><?php echo e($appointment->doctor->first_name); ?> <?php echo e($appointment->doctor->last_name); ?></strong>
                                <?php if($appointment->doctor->specialization): ?>
                                    <br><small class="text-muted"><?php echo e($appointment->doctor->specialization); ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?php echo e($appointment->appointment_date->format('M d, Y')); ?></strong>
                                <br><small class="text-muted"><?php echo e($appointment->appointment_time); ?></small>
                            </td>
                            <td>
                                <span class="badge bg-secondary"><?php echo e($appointment->appointment_type ? $appointment->appointment_type : 'General'); ?></span>
                            </td>
                            <td>
                                <?php switch($appointment->status):
                                    case ('pending'): ?>
                                        <span class="badge bg-warning">Pending</span>
                                        <?php break; ?>
                                    <?php case ('confirmed'): ?>
                                        <span class="badge bg-success">Confirmed</span>
                                        <?php break; ?>
                                    <?php case ('completed'): ?>
                                        <span class="badge bg-info">Completed</span>
                                        <?php break; ?>
                                    <?php case ('cancelled'): ?>
                                        <span class="badge bg-danger">Cancelled</span>
                                        <?php break; ?>
                                    <?php default: ?>
                                        <span class="badge bg-secondary"><?php echo e(ucfirst($appointment->status)); ?></span>
                                <?php endswitch; ?>
                            </td>
                            <td>
                                <?php if($appointment->notes): ?>
                                    <small class="text-muted"><?php echo e(Str::limit($appointment->notes, 50)); ?></small>
                                <?php else: ?>
                                    <small class="text-muted">No notes</small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?php echo e(route('staff.appointments.show', $appointment)); ?>" 
                                   class="btn btn-sm btn-outline-primary" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center">No appointments found.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                <?php echo e($appointments->links()); ?>

            </div>
        </div>
    </div>
</div>

<!-- Export Form (Hidden) -->
<form id="exportForm" method="POST" action="<?php echo e(route('staff.reports.export')); ?>" style="display: none;">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="type" value="appointments">
    <input type="hidden" name="format" value="pdf">
    <input type="hidden" name="status" value="<?php echo e(request('status')); ?>">
    <input type="hidden" name="date_from" value="<?php echo e(request('date_from')); ?>">
    <input type="hidden" name="date_to" value="<?php echo e(request('date_to')); ?>">
</form>

<script>
function exportReport() {
    // Update form values with current filter values
    document.querySelector('#exportForm input[name="status"]').value = '<?php echo e(request('status')); ?>';
    document.querySelector('#exportForm input[name="date_from"]').value = '<?php echo e(request('date_from')); ?>';
    document.querySelector('#exportForm input[name="date_to"]').value = '<?php echo e(request('date_to')); ?>';

    // Submit the form
    document.getElementById('exportForm').submit();
}

function printReport() {
    window.print();
}
</script>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\staff\reports\appointments.blade.php ENDPATH**/ ?>