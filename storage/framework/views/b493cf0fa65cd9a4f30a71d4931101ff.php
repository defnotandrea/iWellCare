

<?php $__env->startSection('title', 'Appointments - iWellCare'); ?>

<?php $__env->startSection('page-title', 'Appointments'); ?>
<?php $__env->startSection('page-subtitle', 'Manage patient appointments and schedules'); ?>

<?php $__env->startSection('content'); ?>


<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="card p-6" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Total Appointments</p>
                <p class="text-white text-3xl font-bold"><?php echo e($stats['total'] ?? 0); ?></p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-calendar text-white text-xl"></i>
            </div>
        </div>
    </div>

    <div class="card p-6" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Pending</p>
                <p class="text-white text-3xl font-bold"><?php echo e($stats['pending'] ?? 0); ?></p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-clock text-white text-xl"></i>
            </div>
        </div>
    </div>

    <div class="card p-6" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Confirmed</p>
                <p class="text-white text-3xl font-bold"><?php echo e($stats['confirmed'] ?? 0); ?></p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-check-circle text-white text-xl"></i>
            </div>
        </div>
    </div>

    <div class="card p-6" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Today's Appointments</p>
                <p class="text-white text-3xl font-bold"><?php echo e($stats['today'] ?? 0); ?></p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-calendar-day text-white text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Appointments Table -->
<div class="table-container">
    <div class="table-header">
        <div class="flex items-center justify-between">
            <h3 class="text-xl font-bold">All Appointments</h3>
            <div class="text-white/80 text-sm">
                <i class="fas fa-info-circle mr-2"></i>Appointments are booked by patients
            </div>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Patient</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Date & Time</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Reason</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-user text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900"><?php echo e($appointment->patient->full_name ?? 'Unknown Patient'); ?></div>
                                <div class="text-sm text-gray-500"><?php echo e($appointment->patient->contact ?? 'No contact'); ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900 font-medium"><?php echo e($appointment->appointment_date->format('M d, Y')); ?></div>
                        <div class="text-sm text-gray-500"><?php echo e($appointment->appointment_time); ?></div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-700"><?php echo e($appointment->reason ?? 'No reason provided'); ?></td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                            <?php if($appointment->status === 'confirmed'): ?> bg-green-100 text-green-800
                            <?php elseif($appointment->status === 'pending'): ?> bg-yellow-100 text-yellow-800
                            <?php elseif($appointment->status === 'cancelled'): ?> bg-red-100 text-red-800
                            <?php else: ?> bg-gray-100 text-gray-800 <?php endif; ?>">
                            <?php echo e(ucfirst($appointment->status)); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-2">
                            <a href="<?php echo e(route('doctor.appointments.show', $appointment)); ?>" 
                               class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-50 transition-all duration-200" 
                               title="View Appointment Details">
                                <i class="fas fa-eye"></i>
                            </a>
                            <?php if($appointment->status === 'pending'): ?>
                            <button type="button" 
                                    class="text-green-600 hover:text-green-800 p-2 rounded-lg hover:bg-green-50 transition-all duration-200" 
                                    title="Confirm Appointment"
                                    onclick="showConfirmModal(<?php echo e($appointment->id); ?>, '<?php echo e($appointment->patient->full_name ?? 'Unknown Patient'); ?>', '<?php echo e($appointment->appointment_date->format('M d, Y')); ?>')">
                                <i class="fas fa-check"></i>
                            </button>
                            <?php endif; ?>
                            <?php if($appointment->status !== 'cancelled'): ?>
                            <button type="button" 
                                    class="text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50 transition-all duration-200" 
                                    title="Cancel Appointment"
                                    onclick="showCancelModal(<?php echo e($appointment->id); ?>, '<?php echo e($appointment->patient->full_name ?? 'Unknown Patient'); ?>', '<?php echo e($appointment->appointment_date->format('M d, Y')); ?>')">
                                <i class="fas fa-times"></i>
                            </button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-calendar-times text-gray-400 text-2xl"></i>
                            </div>
                            <p class="text-gray-500 font-medium">No appointments found</p>
                            <p class="text-gray-400 text-sm mt-1">Appointments will appear here once booked by patients</p>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <?php if($appointments->hasPages()): ?>
    <div class="px-6 py-4 border-t border-gray-200">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
                Showing <?php echo e($appointments->firstItem()); ?> to <?php echo e($appointments->lastItem()); ?> of <?php echo e($appointments->total()); ?> results
            </div>
            <div class="flex space-x-2">
                <?php if($appointments->onFirstPage()): ?>
                    <span class="px-3 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">Previous</span>
                <?php else: ?>
                    <a href="<?php echo e($appointments->previousPageUrl()); ?>" class="px-3 py-2 text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors duration-200">Previous</a>
                <?php endif; ?>
                
                <?php if($appointments->hasMorePages()): ?>
                    <a href="<?php echo e($appointments->nextPageUrl()); ?>" class="px-3 py-2 text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors duration-200">Next</a>
                <?php else: ?>
                    <span class="px-3 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">Next</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Confirmation Modal -->
<div id="confirmationModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 transform transition-all">
        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900" id="modalTitle">Confirm Action</h3>
                <button type="button" class="text-gray-400 hover:text-gray-600" onclick="closeModal()">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        
        <!-- Modal Body -->
        <div class="px-6 py-4">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 rounded-full flex items-center justify-center mr-4" id="modalIcon">
                    <i class="fas fa-question text-white text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-700" id="modalMessage">Are you sure you want to perform this action?</p>
                    <p class="text-sm text-gray-500 mt-1" id="modalDetails"></p>
                </div>
            </div>
        </div>
        
        <!-- Modal Footer -->
        <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
            <button type="button" 
                    class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors duration-200"
                    onclick="closeModal()">
                Cancel
            </button>
            <button type="button" 
                    class="px-4 py-2 text-white rounded-lg transition-colors duration-200"
                    id="confirmButton">
                Confirm
            </button>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div id="loadingModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl max-w-sm w-full mx-4 p-6">
        <div class="flex items-center justify-center">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500 mr-4"></div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Processing...</h3>
                <p class="text-gray-500">Please wait while we process your request.</p>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 transform transition-all">
        <div class="px-6 py-4">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-check text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Success!</h3>
                    <p class="text-gray-700" id="successMessage">Action completed successfully.</p>
                </div>
            </div>
            <div class="flex justify-end">
                <button type="button" 
                        class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors duration-200"
                        onclick="hideSuccessModal()">
                    OK
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div id="errorModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 transform transition-all">
        <div class="px-6 py-4">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-red-500 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Error</h3>
                    <p class="text-gray-700" id="errorMessage">An error occurred. Please try again.</p>
                </div>
            </div>
            <div class="flex justify-end">
                <button type="button" 
                        class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors duration-200"
                        onclick="hideErrorModal()">
                    OK
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Script -->
<script>
let currentAction = null;
let currentAppointmentId = null;

function showCancelModal(appointmentId, patientName, appointmentDate) {
    currentAction = 'cancel';
    currentAppointmentId = appointmentId;
    
    document.getElementById('modalTitle').textContent = 'Cancel Appointment';
    document.getElementById('modalMessage').textContent = 'Are you sure you want to cancel this appointment?';
    document.getElementById('modalDetails').textContent = `Patient: ${patientName} | Date: ${appointmentDate}`;
    
    const modalIcon = document.getElementById('modalIcon');
    modalIcon.className = 'w-12 h-12 rounded-full flex items-center justify-center mr-4 bg-red-500';
    modalIcon.innerHTML = '<i class="fas fa-times text-white text-xl"></i>';
    
    const confirmButton = document.getElementById('confirmButton');
    confirmButton.className = 'px-4 py-2 text-white rounded-lg transition-colors duration-200 bg-red-500 hover:bg-red-600';
    confirmButton.textContent = 'Cancel Appointment';
    
    document.getElementById('confirmationModal').classList.remove('hidden');
}

function showConfirmModal(appointmentId, patientName, appointmentDate) {
    currentAction = 'confirm';
    currentAppointmentId = appointmentId;
    
    document.getElementById('modalTitle').textContent = 'Confirm Appointment';
    document.getElementById('modalMessage').textContent = 'Are you sure you want to confirm this appointment?';
    document.getElementById('modalDetails').textContent = `Patient: ${patientName} | Date: ${appointmentDate}`;
    
    const modalIcon = document.getElementById('modalIcon');
    modalIcon.className = 'w-12 h-12 rounded-full flex items-center justify-center mr-4 bg-green-500';
    modalIcon.innerHTML = '<i class="fas fa-check text-white text-xl"></i>';
    
    const confirmButton = document.getElementById('confirmButton');
    confirmButton.className = 'px-4 py-2 text-white rounded-lg transition-colors duration-200 bg-green-500 hover:bg-green-600';
    confirmButton.textContent = 'Confirm Appointment';
    
    document.getElementById('confirmationModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('confirmationModal').classList.add('hidden');
    currentAction = null;
    currentAppointmentId = null;
}

function showLoadingModal() {
    document.getElementById('loadingModal').classList.remove('hidden');
}

function hideLoadingModal() {
    document.getElementById('loadingModal').classList.add('hidden');
}

function showSuccessModal(message) {
    document.getElementById('successMessage').textContent = message;
    document.getElementById('successModal').classList.remove('hidden');
}

function hideSuccessModal() {
    document.getElementById('successModal').classList.add('hidden');
}

function showErrorModal(message) {
    document.getElementById('errorMessage').textContent = message;
    document.getElementById('errorModal').classList.remove('hidden');
}

function hideErrorModal() {
    document.getElementById('errorModal').classList.add('hidden');
}

function executeAction() {
    if (!currentAction || !currentAppointmentId) return;
    
    // Close the confirmation modal
    closeModal();
    
    // Show loading state
    showLoadingModal();
    
    // Make AJAX request
    fetch(`/doctor/appointments/${currentAppointmentId}/${currentAction}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        hideLoadingModal();
        if (data.success) {
            showSuccessModal(data.message);
            // Refresh the page after a short delay to update the UI
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        } else {
            showErrorModal('An error occurred. Please try again.');
        }
    })
    .catch(error => {
        hideLoadingModal();
        showErrorModal('An error occurred. Please try again.');
        console.error('Error:', error);
    });
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('confirmButton').addEventListener('click', executeAction);
    
    // Close modal when clicking outside
    document.getElementById('confirmationModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });
});
</script>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\doctor\appointments\index.blade.php ENDPATH**/ ?>