@extends('layouts.staff')

@section('title', 'Patient Details - iWellCare')
@section('page-title', 'Patient Details')
@section('page-subtitle', 'View complete patient information')

@section('content')
<div class="patients-content">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Patient Information</h2>
            <p class="text-gray-600">Complete patient details and medical history</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('staff.patients.edit', $patient) }}" class="btn btn-secondary">
                <i class="fas fa-edit mr-2"></i>Edit Patient
            </a>
            <a href="{{ route('staff.consultations.create', ['patient_id' => $patient->id]) }}" class="btn btn-primary">
                <i class="fas fa-plus mr-2"></i>New Consultation
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column - Patient Info -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Basic Information Card -->
            <div class="card p-6">
                <div class="flex items-center gap-4 mb-6">
                    @if($patient->profile_photo)
                        <img src="{{ asset('storage/' . $patient->profile_photo) }}" 
                             class="w-20 h-20 rounded-full object-cover" alt="Profile">
                    @else
                        <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-blue-600 font-bold text-2xl">
                                {{ strtoupper(substr($patient->first_name ?? 'U', 0, 1)) }}
                            </span>
                        </div>
                    @endif
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">{{ $patient->first_name ?? 'N/A' }} {{ $patient->last_name ?? '' }}</h3>
                        <p class="text-gray-500">Patient ID: {{ $patient->id }}</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $patient->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $patient->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600 font-medium">Email</span>
                        <span class="text-gray-800">{{ $patient->email ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600 font-medium">Phone</span>
                        <span class="text-gray-800">{{ $patient->contact ?? 'No phone' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600 font-medium">Date of Birth</span>
                        <span class="text-gray-800">{{ $patient->date_of_birth ? $patient->date_of_birth->format('M d, Y') : 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600 font-medium">Age</span>
                        <span class="text-gray-800">{{ $patient->age ?? 'N/A' }} years old</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600 font-medium">Gender</span>
                        <span class="text-gray-800">{{ ucfirst($patient->gender ?? 'N/A') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600 font-medium">Blood Type</span>
                        <span class="text-gray-800">{{ $patient->blood_type ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>

            <!-- Contact Information Card -->
            <div class="card p-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">Contact Information</h4>
                <div class="space-y-3">
                    @if($patient->address)
                    <div class="flex items-start gap-3">
                        <i class="fas fa-map-marker-alt text-gray-400 mt-1"></i>
                        <div>
                            <p class="text-gray-800 font-medium">Address</p>
                            <p class="text-gray-600 text-sm">{{ $patient->address }}</p>
                        </div>
                    </div>
                    @endif
                    @if($patient->emergency_contact)
                    <div class="flex items-start gap-3">
                        <i class="fas fa-phone text-gray-400 mt-1"></i>
                        <div>
                            <p class="text-gray-800 font-medium">Emergency Contact</p>
                            <p class="text-gray-600 text-sm">{{ $patient->emergency_contact }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column - Medical Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Medical History Card -->
            <div class="card p-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">Medical Information</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($patient->allergies)
                    <div class="p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fas fa-exclamation-triangle text-red-600"></i>
                            <span class="font-semibold text-red-800">Allergies</span>
                        </div>
                        <p class="text-red-700 text-sm">{{ $patient->allergies }}</p>
                    </div>
                    @endif

                    @if($patient->medical_history)
                    <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fas fa-stethoscope text-blue-600"></i>
                            <span class="font-semibold text-blue-800">Medical History</span>
                        </div>
                        <p class="text-blue-700 text-sm">{{ $patient->medical_history }}</p>
                    </div>
                    @endif

                    @if($patient->current_medications)
                    <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fas fa-pills text-green-600"></i>
                            <span class="font-semibold text-green-800">Current Medications</span>
                        </div>
                        <p class="text-green-700 text-sm">{{ $patient->current_medications }}</p>
                    </div>
                    @endif

                    @if($patient->family_history)
                    <div class="p-4 bg-purple-50 border border-purple-200 rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fas fa-users text-purple-600"></i>
                            <span class="font-semibold text-purple-800">Family History</span>
                        </div>
                        <p class="text-purple-700 text-sm">{{ $patient->family_history }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Recent Appointments Card -->
            <div class="card p-6">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-lg font-semibold text-gray-800">Recent Appointments</h4>
                    <a href="{{ route('staff.appointments.create', ['patient_id' => $patient->id]) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        Schedule New
                    </a>
                </div>
                
                @if($patient->appointments && $patient->appointments->count() > 0)
                    <div class="space-y-3">
                        @foreach($patient->appointments->take(5) as $appointment)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-calendar-check text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $appointment->appointment_date->format('M d, Y') }}</p>
                                    <p class="text-sm text-gray-500">{{ $appointment->appointment_time->format('h:i A') }}</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                @if($appointment->status === 'completed') bg-green-100 text-green-800
                                @elseif($appointment->status === 'confirmed') bg-blue-100 text-blue-800
                                @elseif($appointment->status === 'pending') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-calendar-times text-gray-300 text-4xl mb-4"></i>
                        <p class="text-gray-500">No appointments found</p>
                        <p class="text-gray-400 text-sm">This patient hasn't had any appointments yet</p>
                    </div>
                @endif
            </div>

            <!-- Recent Consultations Card -->
            <div class="card p-6">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-lg font-semibold text-gray-800">Recent Consultations</h4>
                    <a href="{{ route('staff.consultations.create', ['patient_id' => $patient->id]) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        New Consultation
                    </a>
                </div>
                
                @if($patient->consultations && $patient->consultations->count() > 0)
                    <div class="space-y-3">
                        @foreach($patient->consultations->take(5) as $consultation)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-stethoscope text-green-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $consultation->consultation_date->format('M d, Y') }}</p>
                                    <p class="text-sm text-gray-500">{{ Str::limit($consultation->chief_complaint, 50) }}</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                @if($consultation->status === 'completed') bg-green-100 text-green-800
                                @elseif($consultation->status === 'in_progress') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst(str_replace('_', ' ', $consultation->status)) }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-stethoscope text-gray-300 text-4xl mb-4"></i>
                        <p class="text-gray-500">No consultations found</p>
                        <p class="text-gray-400 text-sm">This patient hasn't had any consultations yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
