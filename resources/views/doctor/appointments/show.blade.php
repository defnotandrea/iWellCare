@extends('layouts.admin')

@section('title', 'Appointment Details - iWellCare')

@section('page-title', 'Appointment Details')
@section('page-subtitle', 'View appointment information and patient details')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('doctor.appointments.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Appointments
        </a>
    </div>

    <!-- Appointment Details Card -->
    <div class="card mb-6">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">Appointment Information</h3>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                    @if($appointment->status === 'confirmed') bg-green-100 text-green-800
                    @elseif($appointment->status === 'pending') bg-yellow-100 text-yellow-800
                    @elseif($appointment->status === 'cancelled') bg-red-100 text-red-800
                    @elseif($appointment->status === 'completed') bg-blue-100 text-blue-800
                    @else bg-gray-100 text-gray-800 @endif">
                    {{ ucfirst($appointment->status) }}
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Date & Time -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-calendar text-blue-600"></i>
                        </div>
                        <h4 class="font-semibold text-gray-900">Date & Time</h4>
                    </div>
                    <p class="text-lg font-medium text-gray-900">{{ $appointment->appointment_date->format('l, F j, Y') }}</p>
                    <p class="text-gray-600">{{ $appointment->appointment_time }}</p>
                </div>

                <!-- Patient Information -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user text-green-600"></i>
                        </div>
                        <h4 class="font-semibold text-gray-900">Patient</h4>
                    </div>
                    <p class="text-lg font-medium text-gray-900">{{ $appointment->patient ? $appointment->patient->full_name : 'Unknown Patient' }}</p>
                    <p class="text-gray-600">{{ $appointment->patient ? $appointment->patient->contact : 'No contact' }}</p>
                </div>
            </div>

            <!-- Reason -->
            @if($appointment->reason)
            <div class="mt-6">
                <h4 class="font-semibold text-gray-900 mb-2">Reason for Visit</h4>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-700">{{ $appointment->reason }}</p>
                </div>
            </div>
            @endif

            <!-- Notes -->
            @if($appointment->notes)
            <div class="mt-6">
                <h4 class="font-semibold text-gray-900 mb-2">Notes</h4>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-700">{{ $appointment->notes }}</p>
                </div>
            </div>
            @endif

            <!-- Cancellation Details -->
            @if($appointment->status === 'cancelled')
            <div class="mt-6">
                <h4 class="font-semibold text-gray-900 mb-2">Cancellation Details</h4>
                <div class="bg-red-50 rounded-lg p-4">
                    <p class="text-red-700">
                        <strong>Cancelled on:</strong> {{ $appointment->updated_at->format('M d, Y \a\t g:i A') }}
                    </p>
                    <p class="text-red-600 mt-1">
                        <strong>Status:</strong> Cancelled
                    </p>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Patient Details Card -->
    <div class="card mb-6">
        <div class="p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-6">Patient Information</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="font-semibold text-gray-900 mb-3">Personal Information</h4>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Full Name:</span>
                            <span class="font-medium">{{ $appointment->patient->full_name ?? 'Not provided' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Email:</span>
                            <span class="font-medium">{{ $appointment->patient->email ?? 'Not provided' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Contact:</span>
                            <span class="font-medium">{{ $appointment->patient->contact ?? 'Not provided' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Age:</span>
                            <span class="font-medium">{{ $appointment->patient->age ?? 'Not provided' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Gender:</span>
                            <span class="font-medium">{{ ucfirst($appointment->patient->gender ?? 'Not provided') }}</span>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h4 class="font-semibold text-gray-900 mb-3">Medical Information</h4>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Blood Type:</span>
                            <span class="font-medium">{{ $appointment->patient->blood_type ?? 'Not provided' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Allergies:</span>
                            <span class="font-medium">{{ $appointment->patient->allergies ?? 'None' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Medical History:</span>
                            <span class="font-medium">{{ $appointment->patient->medical_history ?? 'None' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Address -->
            @if($appointment->patient->address)
            <div class="mt-6">
                <h4 class="font-semibold text-gray-900 mb-2">Address</h4>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-700">{{ $appointment->patient->address }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="card">
        <div class="p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-6">Actions</h3>
            
            <div class="flex flex-wrap gap-4">
                <!-- View Patient History -->
                @if($appointment->patient)
                <a href="{{ route('doctor.patients.history', $appointment->patient) }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors duration-200">
                    <i class="fas fa-history mr-2"></i>
                    View Patient History
                </a>

                <!-- Edit Patient -->
                <a href="{{ route('doctor.patients.edit', $appointment->patient) }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors duration-200">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Patient
                </a>
                @endif

                <!-- Confirm Appointment (if pending) -->
                @if($appointment->status === 'pending')
                <button type="button" 
                        class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors duration-200"
                        onclick="showConfirmModal({{ $appointment->id }}, '{{ $appointment->patient ? $appointment->patient->full_name : 'Unknown Patient' }}', '{{ $appointment->appointment_date->format('M d, Y') }}')">
                    <i class="fas fa-check mr-2"></i>
                    Confirm Appointment
                </button>
                @endif

                <!-- Cancel Appointment (if not cancelled) -->
                @if($appointment->status !== 'cancelled')
                <button type="button" 
                        class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors duration-200"
                        onclick="showCancelModal({{ $appointment->id }}, '{{ $appointment->patient ? $appointment->patient->full_name : 'Unknown Patient' }}', '{{ $appointment->appointment_date->format('M d, Y') }}')">
                    <i class="fas fa-times mr-2"></i>
                    Cancel Appointment
                </button>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Include the same modals from the index page -->
@include('doctor.appointments.partials.modals')
@endsection 