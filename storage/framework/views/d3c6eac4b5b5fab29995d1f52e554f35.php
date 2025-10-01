

<?php $__env->startSection('title', 'Patients Report'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-users me-2"></i>Patients Report
                    </h1>
                    <p class="text-muted mb-0">View and analyze patient data</p>
                </div>
                <div>
                    <button type="button" class="btn btn-success me-2" onclick="exportReport()">
                        <i class="fas fa-file-pdf me-2"></i>Export PDF
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
            <form method="GET" action="<?php echo e(route('staff.reports.patients')); ?>" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="<?php echo e(request('search')); ?>" placeholder="Name or email">
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All Status</option>
                        <option value="active" <?php echo e(request('status') === 'active' ? 'selected' : ''); ?>>Active</option>
                        <option value="inactive" <?php echo e(request('status') === 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="period" class="form-label">Period</label>
                    <select class="form-select" id="period" name="period">
                        <option value="">All Time</option>
                        <option value="month" <?php echo e(request('period') === 'month' ? 'selected' : ''); ?>>This Month</option>
                        <option value="week" <?php echo e(request('period') === 'week' ? 'selected' : ''); ?>>This Week</option>
                        <option value="year" <?php echo e(request('period') === 'year' ? 'selected' : ''); ?>>This Year</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid gap-2 d-md-flex">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>Filter
                        </button>
                        <a href="<?php echo e(route('staff.reports.patients')); ?>" class="btn btn-outline-secondary">
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
                                Total Patients
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($patients->total()); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
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
                                Active Patients
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($patients->where('is_active', true)->count()); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-check fa-2x text-gray-300"></i>
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
                                New This Month
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($patients->where('created_at', '>=', now()->startOfMonth())->count()); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-plus fa-2x text-gray-300"></i>
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
                                With Appointments
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($patients->filter(function($patient) { return $patient->appointments->count() > 0; })->count()); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Patients Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Patients</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th>Contact Info</th>
                            <th>Demographics</th>
                            <th>Activity</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <?php if($patient->profile_photo): ?>
                                        <img src="<?php echo e(asset('storage/' . $patient->profile_photo)); ?>" 
                                             class="rounded-circle me-3" width="40" height="40" alt="Profile">
                                    <?php else: ?>
                                        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-3" 
                                             style="width: 40px; height: 40px;">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <strong><?php echo e($patient->first_name); ?> <?php echo e($patient->last_name); ?></strong>
                                        <br><small class="text-muted">ID: <?php echo e($patient->id); ?></small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <i class="fas fa-envelope text-muted me-1"></i>
                                    <small><?php echo e($patient->email); ?></small>
                                </div>
                                <div>
                                    <i class="fas fa-phone text-muted me-1"></i>
                                    <small><?php echo e($patient->contact ? $patient->contact : 'No phone'); ?></small>
                                </div>
                                <?php if($patient->address): ?>
                                    <div>
                                        <i class="fas fa-map-marker-alt text-muted me-1"></i>
                                        <small><?php echo e(Str::limit($patient->address, 30)); ?></small>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div>
                                    <strong><?php echo e($patient->age ? $patient->age : 'N/A'); ?> years old</strong>
                                </div>
                                <div>
                                    <span class="badge bg-secondary"><?php echo e(ucfirst($patient->gender ? $patient->gender : 'N/A')); ?></span>
                                </div>
                                <?php if($patient->date_of_birth): ?>
                                    <div>
                                        <small class="text-muted"><?php echo e($patient->date_of_birth->format('M d, Y')); ?></small>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div>
                                    <strong><?php echo e($patient->appointments->count()); ?> appointments</strong>
                                </div>
                                <div>
                                    <small class="text-muted"><?php echo e($patient->consultations->count()); ?> consultations</small>
                                </div>
                                <?php if($patient->appointments->count() > 0): ?>
                                    <?php
                                        $lastAppointment = $patient->appointments->sortByDesc('appointment_date')->first();
                                    ?>
                                    <div>
                                        <small class="text-info">Last: <?php echo e($lastAppointment->appointment_date->format('M d, Y')); ?></small>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($patient->is_active): ?>
                                    <span class="badge bg-success">Active</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?php echo e(route('staff.patients.show', $patient)); ?>" 
                                   class="btn btn-sm btn-outline-primary" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center">No patients found.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                <?php echo e($patients->links()); ?>

            </div>
        </div>
    </div>
</div>

<!-- Export Form (Hidden) -->
<form id="exportForm" method="POST" action="<?php echo e(route('staff.reports.export')); ?>" style="display: none;">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="type" value="patients">
    <input type="hidden" name="format" value="pdf">
    <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
    <input type="hidden" name="status" value="<?php echo e(request('status')); ?>">
    <input type="hidden" name="period" value="<?php echo e(request('period')); ?>">
</form>

<script>
function exportReport() {
    // Update form values with current filter values
    document.querySelector('#exportForm input[name="search"]').value = '<?php echo e(request('search')); ?>';
    document.querySelector('#exportForm input[name="status"]').value = '<?php echo e(request('status')); ?>';
    document.querySelector('#exportForm input[name="period"]').value = '<?php echo e(request('period')); ?>';
    
    // Submit the form
    document.getElementById('exportForm').submit();
}
</script>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\staff\reports\patients.blade.php ENDPATH**/ ?>