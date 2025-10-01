@extends('layouts.admin')

@section('title', 'Patient Management')
@section('page-title', 'Patient Management')
@section('page-subtitle', 'Manage patient records and information')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <i class="fas fa-users text-blue-600"></i>
                Patient Management
            </h1>
            <p class="text-gray-600 mt-1">Manage patient records and information</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="card p-6 flex flex-col items-center bg-gradient-to-br from-blue-100 to-blue-50 shadow-md">
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-users text-blue-600 text-2xl"></i>
            </div>
            <div class="text-gray-500 text-sm font-medium mb-1">Total Patients</div>
            <div class="text-3xl font-bold text-blue-700 mb-2">{{ $patients->total() }}</div>
            <div class="text-xs text-blue-600 bg-blue-100 px-2 py-1 rounded-full">All Time</div>
        </div>

        <div class="card p-6 flex flex-col items-center bg-gradient-to-br from-green-100 to-green-50 shadow-md">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-user-check text-green-600 text-2xl"></i>
            </div>
            <div class="text-gray-500 text-sm font-medium mb-1">Active Patients</div>
            <div class="text-3xl font-bold text-green-700 mb-2">{{ $activeCount ?? 0 }}</div>
            <div class="text-xs text-green-600 bg-green-100 px-2 py-1 rounded-full">Active</div>
        </div>

        <div class="card p-6 flex flex-col items-center bg-gradient-to-br from-cyan-100 to-cyan-50 shadow-md">
            <div class="w-16 h-16 bg-cyan-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-user-plus text-cyan-600 text-2xl"></i>
            </div>
            <div class="text-gray-500 text-sm font-medium mb-1">New This Month</div>
            <div class="text-3xl font-bold text-cyan-700 mb-2">{{ $newThisMonth ?? 0 }}</div>
            <div class="text-xs text-cyan-600 bg-cyan-100 px-2 py-1 rounded-full">This Month</div>
        </div>

        <div class="card p-6 flex flex-col items-center bg-gradient-to-br from-yellow-100 to-yellow-50 shadow-md">
            <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-calendar-alt text-yellow-600 text-2xl"></i>
            </div>
            <div class="text-gray-500 text-sm font-medium mb-1">Recent Appointments</div>
            <div class="text-3xl font-bold text-yellow-700 mb-2">{{ $recentAppointments ?? 0 }}</div>
            <div class="text-xs text-yellow-600 bg-yellow-100 px-2 py-1 rounded-full">Recent</div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="card p-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-search text-blue-600 text-lg"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Search & Filter</h3>
                <p class="text-sm text-gray-500">Find specific patients</p>
            </div>
        </div>
        
        <form method="GET" action="{{ route('admin.patients.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
            <div>
                <label class="block text-gray-700 font-semibold text-sm mb-2">Search</label>
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="search" class="form-input w-full pl-10" 
                           value="{{ request('search') }}" placeholder="Name, email, or phone">
                </div>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold text-sm mb-2">Status</label>
                <select name="status" class="form-input w-full">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold text-sm mb-2">Gender</label>
                <select name="gender" class="form-input w-full">
                    <option value="">All Genders</option>
                    <option value="male" {{ request('gender') === 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ request('gender') === 'female' ? 'selected' : '' }}>Female</option>
                    <option value="other" {{ request('gender') === 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold text-sm mb-2">Age Group</label>
                <select name="age_group" class="form-input w-full">
                    <option value="">All Ages</option>
                    <option value="child" {{ request('age_group') === 'child' ? 'selected' : '' }}>Child (0-12)</option>
                    <option value="teen" {{ request('age_group') === 'teen' ? 'selected' : '' }}>Teen (13-19)</option>
                    <option value="adult" {{ request('age_group') === 'adult' ? 'selected' : '' }}>Adult (20-64)</option>
                    <option value="senior" {{ request('age_group') === 'senior' ? 'selected' : '' }}>Senior (65+)</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="btn btn-primary flex items-center gap-2">
                    <i class="fas fa-search"></i> Search
                </button>
                <a href="{{ route('admin.patients.index') }}" class="btn btn-secondary flex items-center gap-2">
                    <i class="fas fa-undo"></i> Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Patients Table -->
    <div class="card p-6">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-users text-blue-600 text-lg"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Patients List</h3>
                <p class="text-sm text-gray-500">All registered patients</p>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm rounded-lg shadow-lg border border-gray-200">
                <thead>
                    <tr class="text-left text-gray-600 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">Patient</th>
                        <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">Contact Info</th>
                        <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">Demographics</th>
                        <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">Medical Info</th>
                        <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">Last Visit</th>
                        <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">Status</th>
                        <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($patients as $patient)
                    <tr class="hover:bg-blue-50 transition-colors duration-200">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                @if($patient->profile_photo)
                                    <img src="{{ asset('storage/' . $patient->profile_photo) }}" 
                                         class="w-10 h-10 rounded-full object-cover" alt="Profile">
                                @else
                                    <span class="inline-flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full text-blue-600 font-bold text-lg">
                                        {{ strtoupper(substr($patient->first_name ?? 'U', 0, 1)) }}
                                    </span>
                                @endif
                                <div class="min-w-0 flex-1">
                                    <div class="font-medium text-gray-900 truncate">{{ $patient->first_name ?? 'N/A' }} {{ $patient->last_name ?? '' }}</div>
                                    <div class="text-xs text-gray-500 truncate">ID: {{ $patient->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-envelope text-gray-400 text-xs"></i>
                                    <span class="text-sm text-gray-900">{{ $patient->email ?? 'N/A' }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-phone text-gray-400 text-xs"></i>
                                    <span class="text-sm text-gray-900">{{ $patient->contact ?? 'No phone' }}</span>
                                </div>
                                @if($patient->address)
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-map-marker-alt text-gray-400 text-xs"></i>
                                    <span class="text-sm text-gray-900">{{ Str::limit($patient->address, 30) }}</span>
                                </div>
                                @endif
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="space-y-1">
                                <div class="text-sm font-medium text-gray-900">{{ $patient->age ?? 'N/A' }} years old</div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ ucfirst($patient->gender ?? 'N/A') }}
                                </span>
                                @if($patient->date_of_birth)
                                <div class="text-xs text-gray-500">{{ $patient->date_of_birth->format('M d, Y') }}</div>
                                @endif
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="space-y-1">
                                @if($patient->blood_type)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    {{ $patient->blood_type }}
                                </span>
                                @endif
                                @if($patient->allergies)
                                <div class="text-xs text-yellow-600 flex items-center gap-1">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    {{ Str::limit($patient->allergies, 20) }}
                                </div>
                                @endif
                                @if($patient->medical_history)
                                <div class="text-xs text-blue-600 flex items-center gap-1">
                                    <i class="fas fa-stethoscope"></i>
                                    {{ Str::limit($patient->medical_history, 20) }}
                                </div>
                                @endif
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            @if($patient->appointments->count() > 0)
                                @php
                                    $lastAppointment = $patient->appointments->sortByDesc('appointment_date')->first();
                                @endphp
                                <div class="text-sm font-medium text-gray-900">{{ $lastAppointment->appointment_date->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $lastAppointment->appointment_date->diffForHumans() }}</div>
                            @else
                                <span class="text-xs text-gray-400">No visits yet</span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            @if($patient->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1 text-[8px]"></i> Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <i class="fas fa-times-circle mr-1 text-[8px]"></i> Inactive
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('admin.patients.show', $patient) }}"
                                   class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md text-blue-600 bg-blue-100 hover:bg-blue-200 transition-colors duration-200">
                                    <i class="fas fa-eye mr-1.5"></i> View
                                </a>
                                <a href="{{ route('admin.patients.edit', $patient) }}"
                                   class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md text-gray-600 bg-gray-100 hover:bg-gray-200 transition-colors duration-200">
                                    <i class="fas fa-edit mr-1.5"></i> Edit
                                </a>
                                <a href="{{ route('admin.consultations.create', ['patient_id' => $patient->id]) }}"
                                   class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200">
                                    <i class="fas fa-plus mr-1.5"></i> Consultation
                                </a>
                                {{-- History functionality not yet implemented for admin --}}
                                {{-- <button type="button" class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md text-cyan-600 bg-cyan-100 hover:bg-cyan-200 transition-colors duration-200"
                                        onclick="viewHistory({{ $patient->id }})">
                                    <i class="fas fa-history mr-1.5"></i> History
                                </button> --}}
                                <button type="button" class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md text-red-600 bg-red-100 hover:bg-red-200 transition-colors duration-200"
                                        onclick="deletePatient({{ $patient->id }})">
                                    <i class="fas fa-trash mr-1.5"></i> Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-gray-400">
                            <div class="flex flex-col items-center gap-2">
                                <i class="fas fa-users text-4xl text-gray-300"></i>
                                <div class="text-lg font-medium">No patients found</div>
                                <div class="text-sm">Try adjusting your search criteria</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">
            {{ $patients->links() }}
        </div>
    </div>
</div>

<!-- Patient History Modal -->
<div id="patientHistoryModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full mx-4 transform transition-all">
        <div class="px-8 py-8">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mr-4 shadow-lg">
                        <i class="fas fa-history text-blue-600 text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">Patient History</h3>
                        <p class="text-gray-600 text-sm mt-1">View complete medical history</p>
                    </div>
                </div>
                <button onclick="closeHistoryModal()" class="text-gray-400 hover:text-gray-600 transition-colors p-2 rounded-full hover:bg-gray-100">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <!-- Content -->
            <div id="patientHistoryContent" class="min-h-[400px]">
                <div class="flex items-center justify-center h-64">
                    <div class="text-center">
                        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
                        <p class="text-gray-500">Loading patient history...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function viewHistory(patientId) {
    const modal = document.getElementById('patientHistoryModal');
    const content = document.getElementById('patientHistoryContent');
    
    // Show modal
    modal.classList.remove('hidden');
    modal.querySelector('.bg-white').style.transform = 'scale(0.9)';
    setTimeout(() => {
        modal.querySelector('.bg-white').style.transform = 'scale(1)';
    }, 10);
    
    // Load patient history via AJAX
    fetch(`/admin/patients/${patientId}/history`)
        .then(response => response.text())
        .then(html => {
            content.innerHTML = html;
        })
        .catch(error => {
            console.error('Error:', error);
            content.innerHTML = `
                <div class="text-center py-8">
                    <i class="fas fa-exclamation-triangle text-red-500 text-4xl mb-4"></i>
                    <p class="text-red-600 font-medium">Error loading patient history.</p>
                    <p class="text-gray-500 text-sm">Please try again later.</p>
                </div>
            `;
        });
}

function closeHistoryModal() {
    const modal = document.getElementById('patientHistoryModal');
    modal.querySelector('.bg-white').style.transform = 'scale(0.9)';
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 200);
}

function deletePatient(patientId) {
    if (confirm('Are you sure you want to delete this patient? This action cannot be undone.')) {
        // Implement delete functionality
        console.log('Deleting patient:', patientId);
    }
}

// Close modal when clicking outside
document.addEventListener('click', function(e) {
    if (e.target.id === 'patientHistoryModal') {
        closeHistoryModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeHistoryModal();
    }
});
</script>
@endsection 