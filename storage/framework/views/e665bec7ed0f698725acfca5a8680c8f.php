

<?php $__env->startSection('title', 'Patient Report - iWellCare'); ?>
<?php $__env->startSection('page-title', 'Patient Report'); ?>
<?php $__env->startSection('page-subtitle', 'Patient statistics and management overview'); ?>

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
    <h1>Patient Report</h1>
    <p><strong>Generated:</strong> <?php echo e(\Carbon\Carbon::now()->format('F d, Y \a\t g:i A')); ?></p>
    <p><strong>iWellCare Healthcare System</strong></p>
</div>
<?php else: ?>
<!-- Header Actions -->
<div class="flex justify-between items-center mb-8 no-print">
    <div>
        <h3 class="text-lg font-semibold text-gray-900">Patient Management Report</h3>
        <p class="text-gray-600">Comprehensive patient statistics and analysis</p>
    </div>
    <a href="<?php echo e(route('doctor.reports.index')); ?>" class="btn-secondary">
        <i class="fas fa-arrow-left mr-2"></i>Back to Reports
    </a>
</div>
<?php endif; ?>

<!-- Patient Statistics -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="card p-6" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Total Patients</p>
                <p class="text-white text-3xl font-bold"><?php echo e($patientStats['total']); ?></p>
                <p class="text-blue-100 text-xs">Registered</p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-users text-white text-xl"></i>
            </div>
        </div>
    </div>

    <div class="card p-6" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Active Patients</p>
                <p class="text-white text-3xl font-bold"><?php echo e($patientStats['active']); ?></p>
                <p class="text-blue-100 text-xs">Currently Active</p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-user-check text-white text-xl"></i>
            </div>
        </div>
    </div>

    <div class="card p-6" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Inactive Patients</p>
                <p class="text-white text-3xl font-bold"><?php echo e($patientStats['inactive']); ?></p>
                <p class="text-blue-100 text-xs">Not Active</p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-user-times text-white text-xl"></i>
            </div>
        </div>
    </div>

    <div class="card p-6" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">New This Month</p>
                <p class="text-white text-3xl font-bold"><?php echo e($patientStats['new_this_month']); ?></p>
                <p class="text-blue-100 text-xs">Recently Added</p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-user-plus text-white text-xl"></i>
            </div>
        </div>
    </div>
</div>

<?php if(!request('print')): ?>
<!-- Search and Filters -->
<div class="card mb-8 no-print">
    <div class="px-6 py-4 border-b border-gray-100">
        <h3 class="text-xl font-bold text-gray-900">Search & Filter</h3>
        <p class="text-gray-600 text-sm">Find specific patients or filter by status</p>
    </div>
    <div class="p-6">
        <form method="GET" action="<?php echo e(route('doctor.reports.patient-report')); ?>" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Patients</label>
                <input type="text"
                       class="form-input w-full"
                       id="search"
                       name="search"
                       value="<?php echo e(request('search')); ?>"
                       placeholder="Search by name or contact number">
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select class="form-input w-full" id="status" name="status">
                    <option value="">All Patients</option>
                    <option value="active" <?php echo e(request('status') === 'active' ? 'selected' : ''); ?>>Active</option>
                    <option value="inactive" <?php echo e(request('status') === 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="btn-primary w-full">
                    <i class="fas fa-search mr-2"></i>Search
                </button>
            </div>
            <div class="flex items-end">
                <a href="<?php echo e(route('doctor.reports.patient-report')); ?>" class="btn-secondary w-full">
                    <i class="fas fa-refresh mr-2"></i>Reset
                </a>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<!-- Patients Table -->
<div class="card">
    <div class="px-6 py-4 border-b border-gray-100">
        <h3 class="text-xl font-bold text-gray-900">Patient List (<?php echo e($patients->total()); ?> total)</h3>
        <p class="text-gray-600 text-sm">Detailed patient information and statistics</p>
    </div>
    <div class="p-6">
        <?php if($patients->count() > 0): ?>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient Name</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Age/Gender</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activity</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Visit</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">
                                        <?php echo e($patient->first_name); ?> <?php echo e($patient->last_name); ?>

                                    </div>
                                    <div class="text-sm text-gray-500">ID: #<?php echo e($patient->id); ?></div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <div class="text-sm font-medium text-gray-900"><?php echo e($patient->contact); ?></div>
                                    <div class="text-sm text-gray-500"><?php echo e($patient->email ?? 'No email'); ?></div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <div class="text-sm font-medium text-gray-900"><?php echo e($patient->age ?? 'N/A'); ?> years</div>
                                    <div class="text-sm text-gray-500"><?php echo e(ucfirst($patient->gender ?? 'N/A')); ?></div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    <?php echo e($patient->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'); ?>">
                                    <?php echo e($patient->is_active ? 'Active' : 'Inactive'); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        <?php echo e($patient->consultations->count()); ?> consultations
                                    </span>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                        <?php echo e($patient->appointments->count()); ?> appointments
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                <?php
                                    $lastConsultation = $patient->consultations->sortByDesc('consultation_date')->first();
                                    $lastAppointment = $patient->appointments->sortByDesc('appointment_date')->first();
                                    
                                    $lastVisit = null;
                                    if ($lastConsultation && $lastAppointment) {
                                        $lastVisit = $lastConsultation->consultation_date > $lastAppointment->appointment_date 
                                            ? $lastConsultation->consultation_date 
                                            : $lastAppointment->appointment_date;
                                    } elseif ($lastConsultation) {
                                        $lastVisit = $lastConsultation->consultation_date;
                                    } elseif ($lastAppointment) {
                                        $lastVisit = $lastAppointment->appointment_date;
                                    }
                                ?>
                                <?php echo e($lastVisit ? $lastVisit->format('M d, Y') : 'No visits'); ?>

                            </td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    <a href="<?php echo e(route('doctor.patients.edit', $patient)); ?>" 
                                       class="text-gray-600 hover:text-gray-900 transition-colors duration-200"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="text-blue-600 hover:text-blue-900 transition-colors duration-200"
                                            onclick="viewHistory(<?php echo e($patient->id); ?>, '<?php echo e($patient->first_name); ?> <?php echo e($patient->last_name); ?>')" 
                                            title="View History">
                                        <i class="fas fa-history"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <?php if($patients->hasPages()): ?>
                <div class="px-6 py-4 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Showing <?php echo e($patients->firstItem() ?? 0); ?> to <?php echo e($patients->lastItem() ?? 0); ?> of <?php echo e($patients->total()); ?> results
                        </div>
                        <div class="flex space-x-2">
                            <?php echo e($patients->links()); ?>

                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="text-center py-12">
                <i class="fas fa-users text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Patients Found</h3>
                <p class="text-gray-600">No patients match your search criteria</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php if(!request('print')): ?>
<!-- Export Options -->
<div class="card mt-8 no-print">
    <div class="px-6 py-4 border-b border-gray-100">
        <h3 class="text-xl font-bold text-gray-900">Export Options</h3>
        <p class="text-gray-600 text-sm">Download or share your patient report</p>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <button type="button"
                    class="flex flex-col items-center p-4 border-2 border-blue-200 rounded-lg hover:border-blue-300 hover:bg-blue-50 transition-all duration-200"
                    onclick="exportReport('patient')">
                <i class="fas fa-file-pdf text-2xl text-blue-600 mb-2"></i>
                <span class="font-semibold text-gray-900">Export PDF</span>
                <span class="text-sm text-gray-600">Complete Report</span>
            </button>

            <button type="button"
                    class="flex flex-col items-center p-4 border-2 border-green-200 rounded-lg hover:border-green-300 hover:bg-green-50 transition-all duration-200"
                    onclick="exportReport('patient_excel')">
                <i class="fas fa-file-excel text-2xl text-green-600 mb-2"></i>
                <span class="font-semibold text-gray-900">Export Excel</span>
                <span class="text-sm text-gray-600">Spreadsheet Format</span>
            </button>

            <button type="button"
                    class="flex flex-col items-center p-4 border-2 border-purple-200 rounded-lg hover:border-purple-300 hover:bg-purple-50 transition-all duration-200"
                    onclick="printReport()">
                <i class="fas fa-print text-2xl text-purple-600 mb-2"></i>
                <span class="font-semibold text-gray-900">Print Report</span>
                <span class="text-sm text-gray-600">Print to Paper</span>
            </button>

            <button type="button"
                    class="flex flex-col items-center p-4 border-2 border-orange-200 rounded-lg hover:border-orange-300 hover:bg-orange-50 transition-all duration-200"
                    onclick="exportReport('patient_summary')">
                <i class="fas fa-chart-pie text-2xl text-orange-600 mb-2"></i>
                <span class="font-semibold text-gray-900">Summary Report</span>
                <span class="text-sm text-gray-600">Analytics Only</span>
            </button>
        </div>
    </div>
</div>
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

function viewHistory(patientId, patientName) {
    if (confirm(`View complete medical history for ${patientName}?`)) {
        // Redirect to patient history page
        window.location.href = `/doctor/patients/${patientId}/history`;
    }
}

function exportReport(type) {
    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Get current search parameters
    const searchParams = new URLSearchParams(window.location.search);
    const search = searchParams.get('search') || '';
    const status = searchParams.get('status') || '';

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

    // Add search parameters
    if (search) {
        const searchInput = document.createElement('input');
        searchInput.type = 'hidden';
        searchInput.name = 'search';
        searchInput.value = search;
        form.appendChild(searchInput);
    }

    if (status) {
        const statusInput = document.createElement('input');
        statusInput.type = 'hidden';
        statusInput.name = 'status';
        statusInput.value = status;
        form.appendChild(statusInput);
    }

    // Add form to page and submit
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}

function printReport() {
    window.print();
}
</script>
<?php $__env->stopPush(); ?> 
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\doctor\reports\patient-report.blade.php ENDPATH**/ ?>