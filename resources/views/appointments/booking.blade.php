@extends('layouts.app')

@section('title', 'Book Appointment - iWellCare')
@section('content')

<div class="max-w-4xl mx-auto py-8">
    <!-- Header -->
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Book Your Appointment</h1>
        <p class="text-xl text-gray-600">Schedule an appointment with our healthcare professionals</p>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-8">
        <!-- Info Banner -->
        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
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

        <form action="{{ route('book.appointment.store') }}" method="POST">
            @csrf

            <div class="space-y-6">
                <!-- Doctor Selection -->
                <div class="bg-gray-50 rounded-xl p-6">
                    <label for="doctor_id" class="block text-xl font-semibold text-gray-900 mb-4">
                        <i class="fas fa-user-md mr-3 text-blue-600"></i>Select Doctor
                    </label>

                    <!-- Doctor Availability Status -->
                    <div class="mb-4">
                        <h4 class="text-sm font-semibold text-gray-700 mb-2">Doctor Availability Status:</h4>
                        <div class="space-y-2">
                            @foreach($doctors as $doctor)
                                <div class="flex items-center justify-between p-2 rounded-lg {{ $doctor->current_availability['is_available'] ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 rounded-full mr-3 {{ $doctor->current_availability['is_available'] ? 'bg-green-500' : 'bg-red-500' }}"></div>
                                        <span class="font-medium text-gray-900">
                                            Dr. {{ $doctor->user->first_name }} {{ $doctor->user->last_name }}
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
                            @endforeach
                        </div>
                    </div>

                    <select name="doctor_id" id="doctor_id" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-lg transition-colors" required>
                        <option value="">Choose a doctor...</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}"
                                @if(!$doctor->current_availability['is_available']) disabled @endif
                                class="@if(!$doctor->current_availability['is_available']) text-red-500 @else text-gray-900 @endif"
                            >
                                Dr. {{ $doctor->user->first_name }} {{ $doctor->user->last_name }} - {{ $doctor->specialization ?? 'General' }}
                                @if($doctor->current_availability['is_available'])
                                    ✅ Available
                                @else
                                    ❌ {{ $doctor->current_availability['message'] }}
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

                    <!-- Appointment Time -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <label for="appointment_time" class="block text-xl font-semibold text-gray-900 mb-4">
                            <i class="fas fa-clock mr-3 text-blue-600"></i>Appointment Time
                        </label>
                        <select name="appointment_time" id="appointment_time" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-lg transition-colors" required>
                            <option value="">Select time...</option>
                            <option value="09:00" {{ old('appointment_time') == '09:00' ? 'selected' : '' }}>9:00 AM</option>
                            <option value="09:30" {{ old('appointment_time') == '09:30' ? 'selected' : '' }}>9:30 AM</option>
                            <option value="10:00" {{ old('appointment_time') == '10:00' ? 'selected' : '' }}>10:00 AM</option>
                            <option value="10:30" {{ old('appointment_time') == '10:30' ? 'selected' : '' }}>10:30 AM</option>
                            <option value="11:00" {{ old('appointment_time') == '11:00' ? 'selected' : '' }}>11:00 AM</option>
                            <option value="11:30" {{ old('appointment_time') == '11:30' ? 'selected' : '' }}>11:30 AM</option>
                            <option value="14:00" {{ old('appointment_time') == '14:00' ? 'selected' : '' }}>2:00 PM</option>
                            <option value="14:30" {{ old('appointment_time') == '14:30' ? 'selected' : '' }}>2:30 PM</option>
                            <option value="15:00" {{ old('appointment_time') == '15:00' ? 'selected' : '' }}>3:00 PM</option>
                            <option value="15:30" {{ old('appointment_time') == '15:30' ? 'selected' : '' }}>3:30 PM</option>
                            <option value="16:00" {{ old('appointment_time') == '16:00' ? 'selected' : '' }}>4:00 PM</option>
                            <option value="16:30" {{ old('appointment_time') == '16:30' ? 'selected' : '' }}>4:30 PM</option>
                        </select>
                        <p class="text-gray-500 text-sm mt-2">Available time slots are based on clinic hours (9:00 AM - 5:00 PM)</p>
                        @error('appointment_time')
                            <p class="text-red-600 text-sm mt-3 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Appointment Type -->
                <div class="bg-gray-50 rounded-xl p-6">
                    <label for="appointment_type" class="block text-xl font-semibold text-gray-900 mb-4">
                        <i class="fas fa-stethoscope mr-3 text-blue-600"></i>Appointment Type
                    </label>
                    <select name="appointment_type" id="appointment_type" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-lg transition-colors" required>
                        <option value="">Select appointment type...</option>
                        <option value="Regular Checkup" {{ old('appointment_type') == 'Regular Checkup' ? 'selected' : '' }}>Regular Checkup</option>
                        <option value="Consultation" {{ old('appointment_type') == 'Consultation' ? 'selected' : '' }}>Consultation</option>
                        <option value="Emergency" {{ old('appointment_type') == 'Emergency' ? 'selected' : '' }}>Emergency</option>
                        <option value="Follow-up" {{ old('appointment_type') == 'Follow-up' ? 'selected' : '' }}>Follow-up</option>
                    </select>
                    @error('appointment_type')
                        <p class="text-red-600 text-sm mt-3 flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Symptoms -->
                <div class="bg-gray-50 rounded-xl p-6">
                    <label for="symptoms" class="block text-xl font-semibold text-gray-900 mb-4">
                        <i class="fas fa-notes-medical mr-3 text-blue-600"></i>Symptoms (Optional)
                    </label>
                    <textarea name="symptoms" id="symptoms" rows="4"
                              placeholder="Please describe your symptoms or reason for the appointment..."
                              class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-lg resize-none transition-colors">{{ old('symptoms') }}</textarea>
                    <p class="text-gray-500 text-sm mt-2">This information helps us prepare for your appointment</p>
                    @error('symptoms')
                        <p class="text-red-600 text-sm mt-3 flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Notes -->
                <div class="bg-gray-50 rounded-xl p-6">
                    <label for="notes" class="block text-xl font-semibold text-gray-900 mb-4">
                        <i class="fas fa-sticky-note mr-3 text-blue-600"></i>Additional Notes (Optional)
                    </label>
                    <textarea name="notes" id="notes" rows="3"
                              placeholder="Any special requirements or additional information..."
                              class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-lg resize-none transition-colors">{{ old('notes') }}</textarea>
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
                    <a href="{{ route('home') }}" class="btn btn-secondary flex-1 text-lg py-4 px-8 rounded-xl transition-all duration-200">
                        <i class="fas fa-arrow-left mr-3"></i>
                        Back to Home
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

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

@endsection