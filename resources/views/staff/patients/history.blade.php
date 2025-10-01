@extends('layouts.staff')

@section('title', 'Patient History - iWellCare')

@section('content')
<div class="space-y-8">
    <!-- Patient Information Card -->
    <div class="card">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-user text-blue-600 text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">{{ $patient->first_name ?? 'N/A' }} {{ $patient->last_name ?? '' }}</h2>
                        <p class="text-gray-600">Patient ID: {{ $patient->id }}</p>
                        <p class="text-gray-600">{{ $patient->age ?? 'Unknown' }} years old • {{ ucfirst($patient->gender ?? 'Unknown') }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <a href="{{ route('staff.patients.edit', $patient) }}" class="btn-secondary">
                        <i class="fas fa-edit mr-2"></i>Edit Patient
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-envelope text-gray-400 mr-3"></i>
                        <div>
                            <p class="text-sm text-gray-600">Email</p>
                            <p class="font-medium">{{ $patient->user->email ?? 'Not provided' }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-phone text-gray-400 mr-3"></i>
                        <div>
                            <p class="text-sm text-gray-600">Phone</p>
                            <p class="font-medium">{{ $patient->user->phone_number ?? 'Not provided' }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt text-gray-400 mr-3"></i>
                        <div>
                            <p class="text-sm text-gray-600">Address</p>
                            <p class="font-medium">{{ Str::limit($patient->user->street_address ?? 'Not provided', 30) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Medical History Tabs -->
    <div class="card">
        <div class="p-6">
            <div class="border-b border-gray-200 mb-6">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <button onclick="showTab('appointments')" class="tab-button active border-blue-500 text-blue-600 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                        <i class="fas fa-calendar mr-2"></i>Appointments
                    </button>
                    <button onclick="showTab('consultations')" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                        <i class="fas fa-stethoscope mr-2"></i>Consultations
                    </button>
                    <button onclick="showTab('prescriptions')" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                        <i class="fas fa-pills mr-2"></i>Prescriptions
                    </button>
                    <button onclick="showTab('records')" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                        <i class="fas fa-file-medical mr-2"></i>Medical Records
                    </button>
                </nav>
            </div>

            <!-- Appointments Tab -->
            <div id="appointments" class="tab-content">
                <div class="space-y-4">
                    @forelse($patient->appointments as $appointment)
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors duration-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-calendar text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $appointment->appointment_date->format('M d, Y') }} at {{ $appointment->appointment_time }}</p>
                                    <p class="text-sm text-gray-600">Reason: {{ $appointment->reason ?? 'No reason provided' }}</p>
                                    <p class="text-sm text-gray-500">Doctor: {{ $appointment->doctor->first_name ?? 'Unknown' }} {{ $appointment->doctor->last_name ?? '' }}</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                @if($appointment->status === 'confirmed') bg-green-100 text-green-800
                                @elseif($appointment->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($appointment->status === 'cancelled') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-calendar-times text-gray-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-500 font-medium">No appointments found</p>
                        <p class="text-gray-400 text-sm mt-1">This patient has no appointment history</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Consultations Tab -->
            <div id="consultations" class="tab-content hidden">
                <div class="space-y-4">
                    @forelse($patient->consultations as $consultation)
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors duration-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-stethoscope text-green-600"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $consultation->consultation_date->format('M d, Y') }}</p>
                                    <p class="text-sm text-gray-600">Diagnosis: {{ $consultation->diagnosis ?? 'No diagnosis recorded' }}</p>
                                    <p class="text-sm text-gray-500">Doctor: {{ $consultation->doctor->first_name ?? 'Unknown' }} {{ $consultation->doctor->last_name ?? '' }}</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                @if($consultation->status === 'completed') bg-green-100 text-green-800
                                @elseif($consultation->status === 'in_progress') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst(str_replace('_', ' ', $consultation->status)) }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-stethoscope text-gray-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-500 font-medium">No consultations found</p>
                        <p class="text-gray-400 text-sm mt-1">This patient has no consultation history</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Prescriptions Tab -->
            <div id="prescriptions" class="tab-content hidden">
                <div class="space-y-4">
                    @forelse($patient->prescriptions as $prescription)
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors duration-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-pills text-purple-600"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $prescription->prescription_date->format('M d, Y') }}</p>
                                    <p class="text-sm text-gray-600">Medication: {{ $prescription->medication_name ?? 'No medication specified' }}</p>
                                    <p class="text-sm text-gray-500">Doctor: {{ $prescription->doctor->first_name ?? 'Unknown' }} {{ $prescription->doctor->last_name ?? '' }}</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                @if($prescription->status === 'active') bg-green-100 text-green-800
                                @elseif($prescription->status === 'completed') bg-blue-100 text-blue-800
                                @elseif($prescription->status === 'cancelled') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($prescription->status) }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-pills text-gray-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-500 font-medium">No prescriptions found</p>
                        <p class="text-gray-400 text-sm mt-1">This patient has no prescription history</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Medical Records Tab -->
            <div id="records" class="tab-content hidden">
                <div class="space-y-4">
                    @forelse($patient->medicalRecords as $record)
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors duration-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-file-medical text-orange-600"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $record->record_date->format('M d, Y') }}</p>
                                    <p class="text-sm text-gray-600">Type: {{ $record->record_type ?? 'General' }}</p>
                                    <p class="text-sm text-gray-500">Doctor: {{ $record->doctor->first_name ?? 'Unknown' }} {{ $record->doctor->last_name ?? '' }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-500">{{ $record->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-file-medical text-gray-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-500 font-medium">No medical records found</p>
                        <p class="text-gray-400 text-sm mt-1">This patient has no medical record history</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.tab-button.active {
    border-color: #3b82f6;
    color: #2563eb;
}

.tab-content {
    display: block;
}

.tab-content.hidden {
    display: none;
}
</style>

<script>
function showTab(tabName) {
    // Hide all tab contents
    const tabContents = document.querySelectorAll('.tab-content');
    tabContents.forEach(content => {
        content.classList.add('hidden');
    });

    // Remove active class from all tab buttons
    const tabButtons = document.querySelectorAll('.tab-button');
    tabButtons.forEach(button => {
        button.classList.remove('active', 'border-blue-500', 'text-blue-600');
        button.classList.add('border-transparent', 'text-gray-500');
    });

    // Show selected tab content
    document.getElementById(tabName).classList.remove('hidden');

    // Add active class to clicked button
    event.target.classList.add('active', 'border-blue-500', 'text-blue-600');
    event.target.classList.remove('border-transparent', 'text-gray-500');
}
</script>
@endsection