<!-- Confirmation Modal -->
<div id="confirmationModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 transform transition-all">
        <div class="p-6">
            <div class="flex items-center mb-4">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-check text-green-600"></i>
                    </div>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-medium text-gray-900">Confirm Appointment</h3>
                </div>
            </div>
            <div class="mb-6">
                <p class="text-sm text-gray-600">
                    Are you sure you want to confirm the appointment for <span id="confirmPatientName" class="font-medium"></span> 
                    on <span id="confirmAppointmentDate" class="font-medium"></span>?
                </p>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeModal()" class="btn-secondary">
                    Cancel
                </button>
                <button type="button" id="confirmButton" class="btn-primary">
                    <i class="fas fa-check mr-2"></i>Confirm
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Cancellation Modal -->
<div id="cancellationModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 transform transition-all">
        <div class="p-6">
            <div class="flex items-center mb-4">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-times text-red-600"></i>
                    </div>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-medium text-gray-900">Cancel Appointment</h3>
                </div>
            </div>
            <div class="mb-6">
                <p class="text-sm text-gray-600">
                    Are you sure you want to cancel the appointment for <span id="cancelPatientName" class="font-medium"></span> 
                    on <span id="cancelAppointmentDate" class="font-medium"></span>?
                </p>
                <p class="text-xs text-red-600 mt-2">This action cannot be undone.</p>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeModal()" class="btn-secondary">
                    Keep Appointment
                </button>
                <button type="button" id="cancelButton" class="btn-danger">
                    <i class="fas fa-times mr-2"></i>Cancel Appointment
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Completion Modal -->
<div id="completionModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 transform transition-all">
        <div class="p-6">
            <div class="flex items-center mb-4">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-check-double text-purple-600"></i>
                    </div>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-medium text-gray-900">Mark as Completed</h3>
                </div>
            </div>
            <div class="mb-6">
                <p class="text-sm text-gray-600">
                    Are you sure you want to mark the appointment for <span id="completePatientName" class="font-medium"></span> 
                    on <span id="completeAppointmentDate" class="font-medium"></span> as completed?
                </p>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeModal()" class="btn-secondary">
                    Cancel
                </button>
                <button type="button" id="completeButton" class="btn-primary">
                    <i class="fas fa-check-double mr-2"></i>Mark Completed
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div id="loadingModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl p-8 transform transition-all">
        <div class="flex flex-col items-center">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mb-4"></div>
            <p class="text-gray-600">Processing...</p>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl p-8 transform transition-all">
        <div class="flex flex-col items-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-check text-green-600 text-2xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Success!</h3>
            <p id="successMessage" class="text-gray-600 text-center"></p>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div id="errorModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl p-8 transform transition-all">
        <div class="flex flex-col items-center">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Error</h3>
            <p id="errorMessage" class="text-gray-600 text-center"></p>
        </div>
    </div>
</div>

<script>
let currentAppointmentId = null;
let currentAction = null;

function showConfirmModal(appointmentId, patientName, appointmentDate) {
    currentAppointmentId = appointmentId;
    currentAction = 'confirm';
    document.getElementById('confirmPatientName').textContent = patientName;
    document.getElementById('confirmAppointmentDate').textContent = appointmentDate;
    document.getElementById('confirmationModal').classList.remove('hidden');
}

function showCancelModal(appointmentId, patientName, appointmentDate) {
    currentAppointmentId = appointmentId;
    currentAction = 'cancel';
    document.getElementById('cancelPatientName').textContent = patientName;
    document.getElementById('cancelAppointmentDate').textContent = appointmentDate;
    document.getElementById('cancellationModal').classList.remove('hidden');
}

function showCompleteModal(appointmentId, patientName, appointmentDate) {
    currentAppointmentId = appointmentId;
    currentAction = 'complete';
    document.getElementById('completePatientName').textContent = patientName;
    document.getElementById('completeAppointmentDate').textContent = appointmentDate;
    document.getElementById('completionModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('confirmationModal').classList.add('hidden');
    document.getElementById('cancellationModal').classList.add('hidden');
    document.getElementById('completionModal').classList.add('hidden');
    document.getElementById('loadingModal').classList.add('hidden');
    document.getElementById('successModal').classList.add('hidden');
    document.getElementById('errorModal').classList.add('hidden');
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
    if (!currentAppointmentId || !currentAction) return;
    
    closeModal();
    showLoadingModal();
    
    const url = `/staff/appointments/${currentAppointmentId}/${currentAction}`;
    
    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        hideLoadingModal();
        if (data.success) {
            showSuccessModal(data.message);
            setTimeout(() => {
                hideSuccessModal();
                window.location.reload();
            }, 2000);
        } else {
            showErrorModal(data.message || 'An error occurred. Please try again.');
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
    // Confirm button
    document.getElementById('confirmButton').addEventListener('click', executeAction);
    
    // Cancel button
    document.getElementById('cancelButton').addEventListener('click', executeAction);
    
    // Complete button
    document.getElementById('completeButton').addEventListener('click', executeAction);
    
    // Close modal when clicking outside
    document.querySelectorAll('#confirmationModal, #cancellationModal, #completionModal, #loadingModal, #successModal, #errorModal').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    });
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });
});
</script> 