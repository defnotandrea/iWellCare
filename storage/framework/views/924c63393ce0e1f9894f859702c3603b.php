

<?php $__env->startSection('title', 'Patients - iWellCare'); ?>

<?php $__env->startSection('page-title', 'Patients'); ?>
<?php $__env->startSection('page-subtitle', 'Manage patient information and records'); ?>

<?php $__env->startSection('content'); ?>
<!-- Search and Filters -->
<div class="card mb-6">
    <div class="p-6">
        <form method="GET" action="<?php echo e(route('doctor.patients.index')); ?>" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="md:col-span-2">
                <input type="text" class="form-input w-full" name="search" 
                       placeholder="Search by name, contact, or email" 
                       value="<?php echo e(request('search')); ?>">
            </div>
            <div>
                <select class="form-input w-full" name="status">
                    <option value="">All Status</option>
                    <option value="active" <?php echo e(request('status') === 'active' ? 'selected' : ''); ?>>Active</option>
                    <option value="inactive" <?php echo e(request('status') === 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                </select>
            </div>
            <div class="flex space-x-2">
                <button type="submit" class="btn-primary">Search</button>
                <a href="<?php echo e(route('doctor.patients.index')); ?>" class="btn-secondary">Clear</a>
            </div>
        </form>
    </div>
</div>

<!-- Patients Table -->
<div class="table-container">
    <div class="table-header">
        <div class="flex items-center justify-between">
            <h3 class="text-xl font-bold">All Patients</h3>
            <div class="text-white/80 text-sm">
                <i class="fas fa-info-circle mr-2"></i>Patients are managed by staff
            </div>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Name</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Contact</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Email</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Age</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Gender</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-blue-600"></i>
                                </div>
                                <div class="flex items-center">
                                    <div class="mr-3">
                                        <div class="font-semibold text-gray-900"><?php echo e($patient->full_name); ?></div>
                                        <div class="text-sm text-gray-500">ID: <?php echo e($patient->id); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-700"><?php echo e($patient->contact ?? 'Not provided'); ?></td>
                    <td class="px-6 py-4 text-sm text-gray-700"><?php echo e($patient->email ?? 'Not provided'); ?></td>
                    <td class="px-6 py-4 text-sm text-gray-700"><?php echo e($patient->age ?? 'Not provided'); ?></td>
                    <td class="px-6 py-4 text-sm text-gray-700"><?php echo e(ucfirst($patient->gender ?? 'Not provided')); ?></td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                            <?php echo e($patient->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                            <?php echo e($patient->is_active ? 'Active' : 'Inactive'); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-2">
                            <a href="<?php echo e(route('doctor.patients.edit', $patient)); ?>" 
                               class="text-gray-600 hover:text-gray-800 p-2 rounded-lg hover:bg-gray-50 transition-all duration-200" 
                               title="Edit Patient Information">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="<?php echo e(route('doctor.patients.history', $patient)); ?>" 
                               class="text-purple-600 hover:text-purple-800 p-2 rounded-lg hover:bg-purple-50 transition-all duration-200" 
                               title="View Medical History">
                                <i class="fas fa-history"></i>
                            </a>
                            <a href="<?php echo e(route('doctor.appointments.index', ['patient_id' => $patient->id])); ?>" 
                               class="text-orange-600 hover:text-orange-800 p-2 rounded-lg hover:bg-orange-50 transition-all duration-200" 
                               title="View Appointments">
                                <i class="fas fa-calendar"></i>
                            </a>
                            <form action="<?php echo e(route('doctor.patients.destroy', $patient)); ?>" method="POST" style="display:inline-block;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="button" class="btn-delete-patient text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50 transition-all duration-200" title="Delete Patient">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-users text-gray-400 text-2xl"></i>
                            </div>
                            <p class="text-gray-500 font-medium">No patients found</p>
                            <p class="text-gray-400 text-sm mt-1">Patients will appear here once registered by staff</p>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <?php if($patients->hasPages()): ?>
    <div class="px-6 py-4 border-t border-gray-200">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
                Showing <?php echo e($patients->firstItem()); ?> to <?php echo e($patients->lastItem()); ?> of <?php echo e($patients->total()); ?> results
            </div>
            <div class="flex space-x-2">
                <?php if($patients->onFirstPage()): ?>
                    <span class="px-3 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">Previous</span>
                <?php else: ?>
                    <a href="<?php echo e($patients->previousPageUrl()); ?>" class="px-3 py-2 text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors duration-200">Previous</a>
                <?php endif; ?>
                
                <?php if($patients->hasMorePages()): ?>
                    <a href="<?php echo e($patients->nextPageUrl()); ?>" class="px-3 py-2 text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors duration-200">Next</a>
                <?php else: ?>
                    <span class="px-3 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">Next</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Delete Confirmation Modal -->
<div id="deletePatientModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-2xl shadow-lg p-8 w-full max-w-md text-center">
        <h3 class="text-xl font-bold mb-4 text-gray-800">Delete Patient</h3>
        <p class="mb-6 text-gray-600">Are you sure you want to delete this patient? This action cannot be undone.</p>
        <div class="flex justify-center gap-4">
            <button id="cancelDeletePatient" class="px-6 py-2 rounded-lg bg-gray-200 text-gray-700 font-semibold hover:bg-gray-300 transition">Cancel</button>
            <button id="confirmDeletePatient" class="px-6 py-2 rounded-lg bg-red-600 text-white font-semibold hover:bg-red-700 transition">Delete</button>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    let formToDelete = null;
    document.querySelectorAll('.btn-delete-patient').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            formToDelete = this.closest('form');
            document.getElementById('deletePatientModal').classList.remove('hidden');
        });
    });
    document.getElementById('cancelDeletePatient').onclick = function() {
        document.getElementById('deletePatientModal').classList.add('hidden');
        formToDelete = null;
    };
    document.getElementById('confirmDeletePatient').onclick = function() {
        if (formToDelete) formToDelete.submit();
    };
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\doctor\patients\index.blade.php ENDPATH**/ ?>