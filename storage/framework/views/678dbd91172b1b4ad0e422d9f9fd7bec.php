<?php $__env->startSection('title', 'Consultations - iWellCare'); ?>
<?php $__env->startSection('page-title', 'Consultations'); ?>
<?php $__env->startSection('page-subtitle', 'Manage patient consultations and medical records'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header with Actions -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Consultations</h2>
            <p class="text-gray-600">Manage patient consultations and medical records</p>
        </div>
        <div class="flex gap-3">
            <a href="<?php echo e(route('staff.consultations.create')); ?>" class="btn btn-primary flex items-center gap-2">
                <i class="fas fa-plus"></i>
                <span>New Consultation</span>
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="card p-6 flex flex-col items-center bg-gradient-to-br from-blue-100 to-blue-50 shadow-md hover:shadow-lg">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-stethoscope text-blue-600 text-2xl"></i>
                    </div>
                    <div class="text-gray-500 text-sm font-medium mb-1">Total Consultations</div>
                    <div class="text-3xl font-bold text-blue-700 mb-2"><?php echo e($consultations->total()); ?></div>
                    <div class="text-xs text-blue-600 bg-blue-100 px-2 py-1 rounded-full">Active</div>
                </div>
                
                <div class="card p-6 flex flex-col items-center bg-gradient-to-br from-green-100 to-green-50 shadow-md hover:shadow-lg">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                    </div>
                    <div class="text-gray-500 text-sm font-medium mb-1">Completed</div>
                    <div class="text-3xl font-bold text-green-700 mb-2"><?php echo e($consultations->where('status', 'completed')->count()); ?></div>
                    <div class="text-xs text-green-600 bg-green-100 px-2 py-1 rounded-full">Done</div>
                </div>
                
                <div class="card p-6 flex flex-col items-center bg-gradient-to-br from-yellow-100 to-yellow-50 shadow-md hover:shadow-lg">
                    <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-clock text-yellow-600 text-2xl"></i>
                    </div>
                    <div class="text-gray-500 text-sm font-medium mb-1">In Progress</div>
                    <div class="text-3xl font-bold text-yellow-700 mb-2"><?php echo e($consultations->where('status', 'in_progress')->count()); ?></div>
                    <div class="text-xs text-yellow-600 bg-yellow-100 px-2 py-1 rounded-full">Pending</div>
                </div>
                
                <div class="card p-6 flex flex-col items-center bg-gradient-to-br from-purple-100 to-purple-50 shadow-md hover:shadow-lg">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-calendar text-purple-600 text-2xl"></i>
                    </div>
                    <div class="text-gray-500 text-sm font-medium mb-1">Today</div>
                    <div class="text-3xl font-bold text-purple-700 mb-2"><?php echo e($consultations->where('consultation_date', today())->count()); ?></div>
                    <div class="text-xs text-purple-600 bg-purple-100 px-2 py-1 rounded-full">Today</div>
                </div>
            </div>
        
            <!-- Consultations Table -->
            <div class="card">
                <div class="card-header bg-white border-b border-gray-200 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">All Consultations</h3>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" id="searchInput" placeholder="Search consultations...">
                        </div>
                    </div>
                </div>
                <div class="overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Chief Complaint</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php $__empty_1 = true; $__currentLoopData = $consultations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $consultation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                    <i class="fas fa-user text-blue-600"></i>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="flex items-center space-x-3">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        <?php echo e($consultation->patient->name ?? ($consultation->patient->user ? $consultation->patient->user->full_name : 'Unknown Patient')); ?>

                                                    </div>
                                                    <a href="<?php echo e(route('staff.consultations.create', ['patient_id' => $consultation->patient->id])); ?>"
                                                       class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 hover:bg-blue-200 transition-colors duration-200"
                                                       title="Add New Consultation for this patient">
                                                        <i class="fas fa-plus mr-1"></i>Add Consultation
                                                    </a>
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    <?php echo e($consultation->patient->user ? $consultation->patient->user->email : 'No Email'); ?>

                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900"><?php echo e($consultation->consultation_date->format('M d, Y')); ?></div>
                                        <div class="text-sm text-gray-500"><?php echo e($consultation->created_at->format('g:i A')); ?></div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900"><?php echo e(Str::limit($consultation->chief_complaint, 50)); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($consultation->status === 'completed' ? 'bg-green-100 text-green-800' : ($consultation->status === 'in_progress' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')); ?>">
                                            <?php echo e(ucfirst(str_replace('_', ' ', $consultation->status))); ?>

                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="<?php echo e(route('staff.consultations.show', $consultation)); ?>"
                                               class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-3 py-1 rounded-md text-xs font-medium transition-colors duration-200">
                                                <i class="fas fa-eye mr-1"></i>View
                                            </a>
                                            <a href="<?php echo e(route('staff.consultations.edit', $consultation)); ?>"
                                               class="text-gray-600 hover:text-gray-900 bg-gray-50 hover:bg-gray-100 px-3 py-1 rounded-md text-xs font-medium transition-colors duration-200">
                                                <i class="fas fa-edit mr-1"></i>Edit
                                            </a>
                                            <?php if($consultation->status !== 'completed'): ?>
                                            <a href="<?php echo e(route('staff.consultations.physical-exam', $consultation)); ?>"
                                               class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1 rounded-md text-xs font-medium transition-colors duration-200">
                                                <i class="fas fa-heartbeat mr-1"></i>Measurements
                                            </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="text-gray-500">
                                            <i class="fas fa-stethoscope text-4xl mb-4 text-gray-300"></i>
                                            <p class="text-lg font-medium text-gray-900 mb-2">No consultations found</p>
                                            <p class="text-gray-500 mb-4">Get started by creating your first consultation</p>
                                            <a href="<?php echo e(route('staff.consultations.create')); ?>" class="btn btn-primary inline-flex items-center">
                                                <i class="fas fa-plus mr-2"></i>Create First Consultation
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if($consultations->hasPages()): ?>
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    <div class="flex justify-center">
                        <?php echo e($consultations->links()); ?>

                    </div>
                </div>
                <?php endif; ?>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('tbody tr');
        
        tableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.staff', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\staff\consultations\index.blade.php ENDPATH**/ ?>