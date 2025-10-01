@extends('layouts.staff')

@section('title', 'Doctor Availability Management - iWellCare')
@section('page-title', 'Doctor Availability Management')
@section('page-subtitle', 'Manage doctor availability status')

@section('content')
<div class="doctor-availability-content">
    <!-- Header Actions -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Doctor Availability</h2>
            <p class="text-gray-600">Manage doctor availability for appointments and consultations</p>
        </div>
        <a href="{{ route('staff.doctor-availability.create') }}" class="btn btn-primary">
            <i class="fas fa-plus mr-2"></i>Set Availability
        </a>
    </div>

    <!-- Doctor Status Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($doctors as $doctor)
        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-md text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Dr. {{ $doctor->user->first_name ?? '' }} {{ $doctor->user->last_name ?? '' }}</h3>
                        <p class="text-sm text-gray-500">{{ $doctor->specialization }}</p>
                    </div>
                </div>
                @php
                    $latestSetting = $doctor->availabilitySettings->first();
                    $status = $latestSetting ? $latestSetting->getCurrentStatus() : ['is_available' => true, 'status' => 'available', 'message' => 'Available'];
                @endphp
                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $status['is_available'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ ucfirst($status['status']) }}
                </span>
            </div>

            <div class="space-y-3">
                <div class="text-sm">
                    <span class="font-medium text-gray-700">Status:</span>
                    <span class="ml-2 {{ $status['is_available'] ? 'text-green-600' : 'text-red-600' }}">
                        {{ $status['message'] }}
                    </span>
                </div>

                @if($latestSetting && !$status['is_available'])
                    @if($latestSetting->unavailable_until)
                    <div class="text-sm">
                        <span class="font-medium text-gray-700">Until:</span>
                        <span class="ml-2 text-gray-600">{{ $latestSetting->unavailable_until->format('M d, Y H:i') }}</span>
                    </div>
                    @endif
                    @if($latestSetting->notes)
                    <div class="text-sm">
                        <span class="font-medium text-gray-700">Notes:</span>
                        <span class="ml-2 text-gray-600">{{ $latestSetting->notes }}</span>
                    </div>
                    @endif
                @endif

                @if($latestSetting)
                <div class="text-xs text-gray-500">
                    <span class="font-medium">Set by:</span> {{ $latestSetting->setBy->first_name ?? '' }} {{ $latestSetting->setBy->last_name ?? 'System' }}<br>
                    <span class="font-medium">Updated:</span> {{ $latestSetting->updated_at->format('M d, Y H:i') }}
                </div>
                @endif
            </div>

            <div class="mt-6 flex space-x-2">
                <button onclick="setAvailable({{ $doctor->id }})" class="flex-1 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-check mr-1"></i>Available
                </button>
                <button onclick="setUnavailable({{ $doctor->id }})" class="flex-1 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-times mr-1"></i>Unavailable
                </button>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Recent Activity -->
    @if($availabilitySettings->count() > 0)
    <div class="card p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Availability Changes</h3>
        <div class="space-y-4">
            @foreach($availabilitySettings->take(10) as $setting)
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-md text-blue-600 text-sm"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Dr. {{ $setting->doctor->user->first_name ?? '' }} {{ $setting->doctor->user->last_name ?? '' }}</p>
                        <p class="text-sm text-gray-500">
                            Set to <span class="font-medium {{ $setting->is_available ? 'text-green-600' : 'text-red-600' }}">{{ $setting->is_available ? 'Available' : 'Unavailable' }}</span>
                            by {{ $setting->setBy->first_name ?? '' }} {{ $setting->setBy->last_name ?? 'System' }}
                        </p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">{{ $setting->created_at->format('M d, Y H:i') }}</p>
                    @if($setting->status !== 'available')
                    <p class="text-xs text-gray-400">{{ ucfirst($setting->status) }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<!-- Set Unavailable Modal -->
<div id="setUnavailableModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Set Doctor as Unavailable</h3>
                <form id="setUnavailableForm" class="space-y-4">
                    <input type="hidden" name="doctor_id" id="doctorId">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="unavailable">Unavailable</option>
                            <option value="on_leave">On Leave</option>
                            <option value="emergency">Emergency</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Message (Optional)</label>
                        <textarea name="message" rows="3" placeholder="Enter reason for unavailability (optional)..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Until (Optional)</label>
                        <input type="datetime-local" name="until" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Notes (Optional)</label>
                        <textarea name="notes" rows="2" placeholder="Additional notes..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>

                    <div class="flex space-x-3 pt-4">
                        <button type="submit" class="flex-1 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-medium">
                            Set Unavailable
                        </button>
                        <button type="button" onclick="closeModal()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg font-medium">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="successModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-sm w-full">
            <div class="p-6 text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-check text-green-600 text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Success!</h3>
                <p class="text-gray-600 mb-6" id="successMessage">Doctor availability updated successfully.</p>
                <button onclick="closeSuccessModal()" class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-medium">
                    OK
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div id="errorModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-sm w-full">
            <div class="p-6 text-center">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Error</h3>
                <p class="text-gray-600 mb-6" id="errorMessage">An error occurred while updating doctor availability.</p>
                <button onclick="closeErrorModal()" class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-medium">
                    OK
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirmationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-sm w-full">
            <div class="p-6 text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-question text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Confirm Action</h3>
                <p class="text-gray-600 mb-6" id="confirmationMessage">Are you sure you want to perform this action?</p>
                <div class="flex space-x-3">
                    <button onclick="confirmAction()" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-medium">
                        OK
                    </button>
                    <button onclick="closeConfirmationModal()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg font-medium">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let currentAction = '';

function setAvailable(doctorId) {
    currentAction = 'set-available';
    document.getElementById('confirmationMessage').textContent = 'Are you sure you want to set this doctor as available?';
    document.getElementById('confirmationModal').classList.remove('hidden');
    document.getElementById('doctorId').value = doctorId;
}

function setUnavailable(doctorId) {
    document.getElementById('doctorId').value = doctorId;
    document.getElementById('setUnavailableModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('setUnavailableModal').classList.add('hidden');
    // Reset form
    document.getElementById('setUnavailableForm').reset();
}

function showSuccessModal(message) {
    document.getElementById('successMessage').textContent = message;
    document.getElementById('successModal').classList.remove('hidden');
}

function showErrorModal(message) {
    document.getElementById('errorMessage').textContent = message;
    document.getElementById('errorModal').classList.remove('hidden');
}

function closeSuccessModal() {
    document.getElementById('successModal').classList.add('hidden');
    location.reload();
}

function closeErrorModal() {
    document.getElementById('errorModal').classList.add('hidden');
}

function confirmAction() {
    const doctorId = document.getElementById('doctorId').value;
    
    fetch(`/staff/doctor-availability/${doctorId}/${currentAction}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            closeConfirmationModal();
            if (currentAction === 'set-available') {
                showSuccessModal('Doctor is now available');
            } else {
                showSuccessModal('Doctor availability updated successfully');
            }
        } else {
            showErrorModal(data.message || 'Error updating doctor availability');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showErrorModal('Error updating doctor availability. Please try again.');
    });
}

function closeConfirmationModal() {
    document.getElementById('confirmationModal').classList.add('hidden');
}

// Handle set unavailable form submission
document.getElementById('setUnavailableForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const doctorId = formData.get('doctor_id');
    
    // Message is now optional, so no validation needed
    
    fetch(`/staff/doctor-availability/${doctorId}/set-unavailable`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            status: formData.get('status'),
            message: formData.get('message'),
            until: formData.get('until'),
            notes: formData.get('notes')
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            closeModal();
            showSuccessModal('Doctor availability updated successfully');
        } else {
            showErrorModal(data.message || 'Error updating doctor availability');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showErrorModal('Error updating doctor availability. Please try again.');
    });
});

// Close modals when clicking outside
document.getElementById('setUnavailableModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

document.getElementById('successModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeSuccessModal();
    }
});

document.getElementById('errorModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeErrorModal();
    }
});

document.getElementById('confirmationModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeConfirmationModal();
    }
});
</script>
@endsection 