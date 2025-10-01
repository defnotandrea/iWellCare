@extends('layouts.staff')

@section('title', 'Prescriptions - Staff Dashboard')

@section('content')
<div class="min-h-screen bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl p-6 mb-8 shadow-lg">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-pills text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">Prescriptions</h1>
                        <p class="text-blue-100">Manage patient prescriptions and medications</p>
                    </div>
                </div>
                <a href="{{ route('staff.prescriptions.create') }}" class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg transition-colors flex items-center gap-2">
                    <i class="fas fa-plus"></i>New Prescription
                </a>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-search text-blue-600"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800">Search & Filter</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user text-gray-400 mr-2"></i>Search Patient
                    </label>
                    <input type="text" id="search" placeholder="Search by patient name..." class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-filter text-gray-400 mr-2"></i>Status
                    </label>
                    <select id="status-filter" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        <option value="">All Statuses</option>
                        <option value="active">Active</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar text-gray-400 mr-2"></i>Date Range
                    </label>
                    <input type="date" id="date-filter" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                </div>
            </div>
        </div>

        <!-- Prescriptions Table -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-list text-indigo-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Prescriptions</h3>
                        <p class="text-gray-600 text-sm">Manage patient prescriptions and medications</p>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Medication</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dosage</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prescribed Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($prescriptions ?? [] as $prescription)
                        <tr class="hover:bg-blue-50/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                            <span class="text-sm font-medium text-blue-600">
                                                {{ substr($prescription->patient->first_name ?? 'N', 0, 1) }}{{ substr($prescription->patient->last_name ?? 'A', 0, 1) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $prescription->patient->first_name ?? 'N/A' }} {{ $prescription->patient->last_name ?? 'N/A' }}
                                        </div>
                                        <div class="text-sm text-gray-500">{{ $prescription->patient->email ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $prescription->medications->first()->medication_name ?? 'N/A' }}</div>
                            <div class="text-sm text-gray-500">{{ $prescription->medications->first()->dosage ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $prescription->medications->first()->dosage ?? 'N/A' }}</div>
                            <div class="text-sm text-gray-500">{{ $prescription->medications->first()->frequency ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if(($prescription->status ?? '') === 'active')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Active
                                </span>
                            @elseif(($prescription->status ?? '') === 'completed')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Completed
                                </span>
                            @elseif(($prescription->status ?? '') === 'cancelled')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Cancelled
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $prescription->status ?? 'Unknown' }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $prescription->prescription_date ? \Carbon\Carbon::parse($prescription->prescription_date)->format('M d, Y') : 'N/A' }}
                        </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('staff.prescriptions.show', $prescription->id ?? 1) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                                        <i class="fas fa-eye mr-1"></i>View
                                    </a>
                                    <button onclick="deletePrescription({{ $prescription->id ?? 1 }})" class="inline-flex items-center px-3 py-2 text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                                        <i class="fas fa-trash mr-1"></i>Delete
                                    </button>
                                </div>
                            </td>
                    </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-pills text-2xl text-gray-400"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No prescriptions found</h3>
                                    <p class="text-gray-500 mb-4">Get started by creating a new prescription for a patient.</p>
                                    <a href="{{ route('staff.prescriptions.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                                        <i class="fas fa-plus mr-2"></i>Create First Prescription
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                </tbody>
            </table>
        </div>
    </div>

        <!-- Pagination -->
        @if(isset($prescriptions) && $prescriptions->hasPages())
        <div class="mt-6 flex justify-center">
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-4">
                {{ $prescriptions->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

<script>
function deletePrescription(id) {
    if (confirm('Are you sure you want to delete this prescription?')) {
        fetch(`/staff/prescriptions/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error deleting prescription');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting prescription');
        });
    }
}

// Search functionality
document.getElementById('search').addEventListener('input', function() {
    // Implement search logic here
});

document.getElementById('status-filter').addEventListener('change', function() {
    // Implement status filter logic here
});

document.getElementById('date-filter').addEventListener('change', function() {
    // Implement date filter logic here
});
</script>
@endsection
