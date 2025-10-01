@extends('layouts.patient')
@section('title', 'Book Appointment - iWellCare')
@section('page-title', 'Book New Appointment')
@section('page-subtitle', 'Schedule an appointment with a doctor')
@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Breadcrumb -->
    <div class="mb-6">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('patient.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        <i class="fas fa-home mr-2"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <a href="{{ route('patient.appointments.index') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">Appointments</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <span class="text-sm font-medium text-gray-500">Book Appointment</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-8">
        <!-- Header Section -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-3">Book Your Appointment</h2>
            <p class="text-gray-600 text-lg">Please fill in the details below to schedule your appointment.</p>
            
            <!-- Info Banner -->
            <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-600 mr-3 mt-1"></i>
                    <div>
                        <p class="text-blue-700 font-medium">Important Information</p>
                        <p class="text-blue-600 text-sm mt-1">
                            Doctors marked in red are currently unavailable and cannot be selected for appointments. 
                            Please choose an available doctor to proceed.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('patient.appointments.store') }}" method="POST">
            @csrf
            
            <div class="space-y-6">
                <!-- Doctor Selection -->
                <div class="bg-gray-50 rounded-xl p-6">
                    <label for="doctor_id" class="block text-xl font-semibold text-gray-900 mb-4">
                        <i class="fas fa-user-md mr-3 text-blue-600"></i>Select Doctor
                    </label>
                    
                    @if($defaultDoctor)
                        <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-star text-green-600 mr-2"></i>
                                <span class="text-green-700 text-sm font-medium">
                                    Dr. {{ $defaultDoctor->user->first_name }} {{ $defaultDoctor->user->last_name }} is pre-selected as your default doctor
                                </span>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Doctor Availability Status -->
                    <div class="mb-4">
                        <h4 class="text-sm font-semibold text-gray-700 mb-2">Doctor Availability Status:</h4>
                        <div class="space-y-2">
                            @forelse($doctors as $doctor)
                                <div class="flex items-center justify-between p-2 rounded-lg {{ $doctor->current_availability['is_available'] ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 rounded-full mr-3 {{ $doctor->current_availability['is_available'] ? 'bg-green-500' : 'bg-red-500' }}"></div>
                                        <span class="font-medium text-gray-900">
                                            Dr. {{ $doctor->user ? $doctor->user->first_name . ' ' . $doctor->user->last_name : 'Unknown Doctor' }}
                                        </span>
                                        <span class="text-sm text-gray-600 ml-2">({{ $doctor->specialization ?? 'General' }})</span>
                                    </div>
                                    <div class="text-sm font-medium {{ $doctor->current_availability['is_available'] ? 'text-green-700' : 'text-red-700' }}">
                                        @if($doctor->current_availability['is_available'])
                                            <i class="fas fa-check-circle mr-1"></i>Available
                                        @else
                                            <i class="fas fa-times-circle mr-1"></i>{{ $doctor->current_availability['message'] }}
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4 text-gray-500">
                                    <i class="fas fa-user-md text-2xl mb-2"></i>
                                    <p>No doctors available at the moment.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    
                    <select name="doctor_id" id="doctor_id" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-lg transition-colors" required>
                        <option value="">Choose a doctor...</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}"
                                {{ old('doctor_id', $defaultDoctor ? $defaultDoctor->id : '') == $doctor->id ? 'selected' : '' }}
                                class="@if(!$doctor->current_availability['is_available']) text-red-500 @else text-gray-900 @endif"
                            >
                                Dr. {{ $doctor->user->first_name }} {{ $doctor->user->last_name }} - {{ $doctor->specialization }}
                                @if($doctor->current_availability['is_available'])
                                    ✅ Available
                                @else
                                    ❌ {{ $doctor->current_availability['message'] }}
                                @endif
                                @if($defaultDoctor && $doctor->id == $defaultDoctor->id)
                                    (Default)
                                @endif
                            </option>
                        @endforeach
                    </select>
                    
                    <!-- Availability Legend -->
                    <div class="mt-4 flex flex-wrap items-center gap-4 text-sm">
                        <div class="flex items-center">
                            <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                            <span class="text-green-700 font-medium">Available</span>
                        </div>
                        <div class="flex items-center">
                            <span class="w-3 h-3 bg-red-500 rounded-full mr-2"></span>
                            <span class="text-red-700 font-medium">Unavailable</span>
                        </div>
                        <div class="flex items-center">
                            <span class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></span>
                            <span class="text-yellow-700 font-medium">Default Doctor</span>
                        </div>
                    </div>
                    
                    <!-- Real-time Availability Update -->
                    <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                            <span class="text-blue-700 text-sm">
                                <strong>Note:</strong> Availability status is updated in real-time. Unavailable doctors cannot be selected for appointments.
                            </span>
                        </div>
                    </div>
                    
                    @error('doctor_id')
                        <p class="text-red-600 text-sm mt-3 flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Appointment Details Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Appointment Type -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <label for="type" class="block text-xl font-semibold text-gray-900 mb-4">
                            <i class="fas fa-stethoscope mr-3 text-blue-600"></i>Appointment Type
                        </label>
                        <select name="type" id="type" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-lg transition-colors" required>
                            <option value="">Select appointment type...</option>
                            <option value="checkup" {{ old('type') == 'checkup' ? 'selected' : '' }}>Regular Checkup</option>
                            <option value="consultation" {{ old('type') == 'consultation' ? 'selected' : '' }}>Consultation</option>
                            <option value="emergency" {{ old('type') == 'emergency' ? 'selected' : '' }}>Emergency</option>
                            <option value="follow-up" {{ old('type') == 'follow-up' ? 'selected' : '' }}>Follow-up</option>
                        </select>
                        @error('type')
                            <p class="text-red-600 text-sm mt-3 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Appointment Date -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <label for="appointment_date" class="block text-xl font-semibold text-gray-900 mb-4">
                            <i class="fas fa-calendar mr-3 text-blue-600"></i>Appointment Date
                        </label>
                        <input type="date" name="appointment_date" id="appointment_date" 
                               value="{{ old('appointment_date') }}"
                               min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-lg transition-colors" required>
                        @error('appointment_date')
                            <p class="text-red-600 text-sm mt-3 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Time Selection -->
                <div class="bg-gray-50 rounded-xl p-6">
                    <label for="appointment_time" class="block text-xl font-semibold text-gray-900 mb-4">
                        <i class="fas fa-clock mr-3 text-blue-600"></i>Appointment Time
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                        <select name="appointment_time" id="appointment_time" class="col-span-2 md:col-span-3 lg:col-span-4 px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-lg transition-colors" required>
                            <option value="">Select time...</option>
                            <option value="09:00:00" {{ old('appointment_time') == '09:00:00' ? 'selected' : '' }}>9:00 AM</option>
                            <option value="09:30:00" {{ old('appointment_time') == '09:30:00' ? 'selected' : '' }}>9:30 AM</option>
                            <option value="10:00:00" {{ old('appointment_time') == '10:00:00' ? 'selected' : '' }}>10:00 AM</option>
                            <option value="10:30:00" {{ old('appointment_time') == '10:30:00' ? 'selected' : '' }}>10:30 AM</option>
                            <option value="11:00:00" {{ old('appointment_time') == '11:00:00' ? 'selected' : '' }}>11:00 AM</option>
                            <option value="11:30:00" {{ old('appointment_time') == '11:30:00' ? 'selected' : '' }}>11:30 AM</option>
                            <option value="14:00:00" {{ old('appointment_time') == '14:00:00' ? 'selected' : '' }}>2:00 PM</option>
                            <option value="14:30:00" {{ old('appointment_time') == '14:30:00' ? 'selected' : '' }}>2:30 PM</option>
                            <option value="15:00:00" {{ old('appointment_time') == '15:00:00' ? 'selected' : '' }}>3:00 PM</option>
                            <option value="15:30:00" {{ old('appointment_time') == '15:30:00' ? 'selected' : '' }}>3:30 PM</option>
                            <option value="16:00:00" {{ old('appointment_time') == '16:00:00' ? 'selected' : '' }}>4:00 PM</option>
                            <option value="16:30:00" {{ old('appointment_time') == '16:30:00' ? 'selected' : '' }}>4:30 PM</option>
                        </select>
                    </div>
                    <p class="text-gray-500 text-sm mt-2">Available time slots are based on clinic hours (9:00 AM - 5:00 PM)</p>
                    @error('appointment_time')
                        <p class="text-red-600 text-sm mt-3 flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Notes -->
                <div class="bg-gray-50 rounded-xl p-6">
                    <label for="notes" class="block text-xl font-semibold text-gray-900 mb-4">
                        <i class="fas fa-notes-medical mr-3 text-blue-600"></i>Additional Notes (Optional)
                    </label>
                    <textarea name="notes" id="notes" rows="6" 
                              placeholder="Please describe your symptoms, reason for the appointment, or any special requirements..."
                              class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-lg resize-none transition-colors">{{ old('notes') }}</textarea>
                    <p class="text-gray-500 text-sm mt-2">This information helps us prepare for your appointment</p>
                    @error('notes')
                        <p class="text-red-600 text-sm mt-3 flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                    <button type="submit" class="btn btn-primary flex-1 text-lg py-4 px-8 rounded-xl transition-all duration-200 hover:scale-105">
                        <i class="fas fa-calendar-plus mr-3"></i>
                        Book Appointment
                    </button>
                    <a href="{{ route('patient.appointments.index') }}" class="btn btn-secondary flex-1 text-lg py-4 px-8 rounded-xl transition-all duration-200">
                        <i class="fas fa-arrow-left mr-3"></i>
                        Back to Appointments
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

<style>
/* Custom styles for doctor availability in dropdown */
select option:disabled {
    color: #ef4444 !important;
    font-style: italic;
    background-color: #fef2f2;
}

select option[class*="text-red-500"] {
    color: #ef4444 !important;
}

/* Warning message animation */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

#doctor-warning {
    animation: fadeIn 0.3s ease-in-out;
}

/* Disabled submit button styles */
button[type="submit"]:disabled {
    background-color: #9ca3af !important;
    cursor: not-allowed !important;
    transform: none !important;
}

/* Form field focus effects */
.form-field:focus {
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Card hover effects */
.card-hover {
    transition: all 0.3s ease;
}

.card-hover:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

/* Button hover effects */
.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
}

.btn-secondary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(107, 114, 128, 0.4);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const doctorSelect = document.getElementById('doctor_id');
    const submitButton = document.querySelector('button[type="submit"]');
    const form = document.querySelector('form');
    
    // Function to check if selected doctor is available
    function checkDoctorAvailability() {
        const selectedOption = doctorSelect.options[doctorSelect.selectedIndex];
        const isAvailable = !selectedOption.disabled;
        
        if (selectedOption.value && !isAvailable) {
            // Show warning
            showWarning('The selected doctor is currently unavailable. Please choose another doctor.');
            submitButton.disabled = true;
            submitButton.classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            // Hide warning and enable submit
            hideWarning();
            submitButton.disabled = false;
            submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }
    
    // Function to show warning message
    function showWarning(message) {
        let warningDiv = document.getElementById('doctor-warning');
        if (!warningDiv) {
            warningDiv = document.createElement('div');
            warningDiv.id = 'doctor-warning';
            warningDiv.className = 'mt-3 p-4 bg-red-50 border border-red-200 rounded-lg';
            doctorSelect.parentNode.appendChild(warningDiv);
        }
        warningDiv.innerHTML = `
            <div class="flex items-start">
                <i class="fas fa-exclamation-triangle text-red-600 mr-3 mt-1"></i>
                <div>
                    <p class="text-red-700 font-medium">Doctor Unavailable</p>
                    <p class="text-red-600 text-sm mt-1">${message}</p>
                </div>
            </div>
        `;
    }
    
    // Function to hide warning message
    function hideWarning() {
        const warningDiv = document.getElementById('doctor-warning');
        if (warningDiv) {
            warningDiv.remove();
        }
    }
    
    // Add event listener to doctor select
    doctorSelect.addEventListener('change', checkDoctorAvailability);
    
    // Check on page load
    checkDoctorAvailability();
    
    // Form validation
    form.addEventListener('submit', function(e) {
        const doctorSelect = document.getElementById('doctor_id');
        const selectedOption = doctorSelect.options[doctorSelect.selectedIndex];
        
        if (selectedOption.disabled) {
            e.preventDefault();
            showWarning('Please select an available doctor to proceed.');
            return false;
        }
    });
    
    // Add smooth scrolling to form sections
    const formSections = document.querySelectorAll('.bg-gray-50');
    formSections.forEach(section => {
        section.classList.add('card-hover');
    });
    
    // Add focus effects to form fields
    const formFields = document.querySelectorAll('input, select, textarea');
    formFields.forEach(field => {
        field.classList.add('form-field');
    });
});
</script> 