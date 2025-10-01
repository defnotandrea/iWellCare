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
</script> <?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\doctor\appointments\partials\modals.blade.php ENDPATH**/ ?>