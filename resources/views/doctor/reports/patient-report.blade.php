@extends('layouts.admin')

@section('title', 'Patient Report - iWellCare')
@section('page-title', 'Patient Report')
@section('page-subtitle', 'Patient statistics and management overview')

@push('styles')
<style>
@media print {
    .no-print {
        display: none !important;
    }
    .card {
        border: 1px solid #ddd !important;
        box-shadow: none !important;
        break-inside: avoid;
    }
    body {
        font-size: 12px !important;
        line-height: 1.4 !important;
    }
    .grid {
        display: block !important;
    }
    .grid-cols-1, .md\\:grid-cols-2, .lg\\:grid-cols-4 {
        display: block !important;
    }
    .gap-6 > * {
        margin-bottom: 20px !important;
    }
    table {
        font-size: 11px !important;
        width: 100% !important;
    }
    th, td {
        padding: 6px !important;
        border: 1px solid #ddd !important;
    }
    .page-break {
        page-break-before: always;
    }
    .print-header {
        text-align: center;
        border-bottom: 2px solid #007bff;
        padding-bottom: 20px;
        margin-bottom: 30px;
    }
    .print-header h1 {
        color: #007bff;
        margin: 0;
        font-size: 24px;
    }
}
</style>
@endpush

@section('content')
@if(request('print'))
<div class="print-header">
    <h1>Patient Report</h1>
    <p><strong>Generated:</strong> {{ \Carbon\Carbon::now()->format('F d, Y \a\t g:i A') }}</p>
    <p><strong>iWellCare Healthcare System</strong></p>
</div>
@else
<!-- Header Actions -->
<div class="flex justify-between items-center mb-8 no-print">
    <div>
        <h3 class="text-lg font-semibold text-gray-900">Patient Management Report</h3>
        <p class="text-gray-600">Comprehensive patient statistics and analysis</p>
    </div>
    <a href="{{ route('doctor.reports.index') }}" class="btn-secondary">
        <i class="fas fa-arrow-left mr-2"></i>Back to Reports
    </a>
</div>
@endif

<!-- Patient Statistics -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="card p-6" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Total Patients</p>
                <p class="text-white text-3xl font-bold">{{ $patientStats['total'] }}</p>
                <p class="text-blue-100 text-xs">Registered</p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-users text-white text-xl"></i>
            </div>
        </div>
    </div>

    <div class="card p-6" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Active Patients</p>
                <p class="text-white text-3xl font-bold">{{ $patientStats['active'] }}</p>
                <p class="text-blue-100 text-xs">Currently Active</p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-user-check text-white text-xl"></i>
            </div>
        </div>
    </div>

    <div class="card p-6" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Inactive Patients</p>
                <p class="text-white text-3xl font-bold">{{ $patientStats['inactive'] }}</p>
                <p class="text-blue-100 text-xs">Not Active</p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-user-times text-white text-xl"></i>
            </div>
        </div>
    </div>

    <div class="card p-6" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">New This Month</p>
                <p class="text-white text-3xl font-bold">{{ $patientStats['new_this_month'] }}</p>
                <p class="text-blue-100 text-xs">Recently Added</p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-user-plus text-white text-xl"></i>
            </div>
        </div>
    </div>
</div>

@if(!request('print'))
<!-- Search and Filters -->
<div class="card mb-8 no-print">
    <div class="px-6 py-4 border-b border-gray-100">
        <h3 class="text-xl font-bold text-gray-900">Search & Filter</h3>
        <p class="text-gray-600 text-sm">Find specific patients or filter by status</p>
    </div>
    <div class="p-6">
        <form method="GET" action="{{ route('doctor.reports.patient-report') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Patients</label>
                <input type="text"
                       class="form-input w-full"
                       id="search"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Search by name or contact number">
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select class="form-input w-full" id="status" name="status">
                    <option value="">All Patients</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="btn-primary w-full">
                    <i class="fas fa-search mr-2"></i>Search
                </button>
            </div>
            <div class="flex items-end">
                <a href="{{ route('doctor.reports.patient-report') }}" class="btn-secondary w-full">
                    <i class="fas fa-refresh mr-2"></i>Reset
                </a>
            </div>
        </form>
    </div>
</div>
@endif

<!-- Patients Table -->
<div class="card">
    <div class="px-6 py-4 border-b border-gray-100">
        <h3 class="text-xl font-bold text-gray-900">Patient List ({{ $patients->total() }} total)</h3>
        <p class="text-gray-600 text-sm">Detailed patient information and statistics</p>
    </div>
    <div class="p-6">
        @if($patients->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient Name</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Age/Gender</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activity</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Visit</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($patients as $patient)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $patient->first_name }} {{ $patient->last_name }}
                                    </div>
                                    <div class="text-sm text-gray-500">ID: #{{ $patient->id }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $patient->contact }}</div>
                                    <div class="text-sm text-gray-500">{{ $patient->email ?? 'No email' }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $patient->age ?? 'N/A' }} years</div>
                                    <div class="text-sm text-gray-500">{{ ucfirst($patient->gender ?? 'N/A') }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $patient->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $patient->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $patient->consultations->count() }} consultations
                                    </span>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                        {{ $patient->appointments->count() }} appointments
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                @php
                                    $lastConsultation = $patient->consultations->sortByDesc('consultation_date')->first();
                                    $lastAppointment = $patient->appointments->sortByDesc('appointment_date')->first();
                                    
                                    $lastVisit = null;
                                    if ($lastConsultation && $lastAppointment) {
                                        $lastVisit = $lastConsultation->consultation_date > $lastAppointment->appointment_date 
                                            ? $lastConsultation->consultation_date 
                                            : $lastAppointment->appointment_date;
                                    } elseif ($lastConsultation) {
                                        $lastVisit = $lastConsultation->consultation_date;
                                    } elseif ($lastAppointment) {
                                        $lastVisit = $lastAppointment->appointment_date;
                                    }
                                @endphp
                                {{ $lastVisit ? $lastVisit->format('M d, Y') : 'No visits' }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    <a href="{{ route('doctor.patients.edit', $patient) }}" 
                                       class="text-gray-600 hover:text-gray-900 transition-colors duration-200"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="text-blue-600 hover:text-blue-900 transition-colors duration-200"
                                            onclick="viewHistory({{ $patient->id }}, '{{ $patient->first_name }} {{ $patient->last_name }}')" 
                                            title="View History">
                                        <i class="fas fa-history"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($patients->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Showing {{ $patients->firstItem() ?? 0 }} to {{ $patients->lastItem() ?? 0 }} of {{ $patients->total() }} results
                        </div>
                        <div class="flex space-x-2">
                            {{ $patients->links() }}
                        </div>
                    </div>
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <i class="fas fa-users text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Patients Found</h3>
                <p class="text-gray-600">No patients match your search criteria</p>
            </div>
        @endif
    </div>
</div>

@if(!request('print'))
<!-- Export Options -->
<div class="card mt-8 no-print">
    <div class="px-6 py-4 border-b border-gray-100">
        <h3 class="text-xl font-bold text-gray-900">Export Options</h3>
        <p class="text-gray-600 text-sm">Download or share your patient report</p>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <button type="button"
                    class="flex flex-col items-center p-4 border-2 border-blue-200 rounded-lg hover:border-blue-300 hover:bg-blue-50 transition-all duration-200"
                    onclick="exportReport('patient')">
                <i class="fas fa-file-pdf text-2xl text-blue-600 mb-2"></i>
                <span class="font-semibold text-gray-900">Export PDF</span>
                <span class="text-sm text-gray-600">Complete Report</span>
            </button>

            <button type="button"
                    class="flex flex-col items-center p-4 border-2 border-green-200 rounded-lg hover:border-green-300 hover:bg-green-50 transition-all duration-200"
                    onclick="exportReport('patient_excel')">
                <i class="fas fa-file-excel text-2xl text-green-600 mb-2"></i>
                <span class="font-semibold text-gray-900">Export Excel</span>
                <span class="text-sm text-gray-600">Spreadsheet Format</span>
            </button>

            <button type="button"
                    class="flex flex-col items-center p-4 border-2 border-purple-200 rounded-lg hover:border-purple-300 hover:bg-purple-50 transition-all duration-200"
                    onclick="printReport()">
                <i class="fas fa-print text-2xl text-purple-600 mb-2"></i>
                <span class="font-semibold text-gray-900">Print Report</span>
                <span class="text-sm text-gray-600">Print to Paper</span>
            </button>

            <button type="button"
                    class="flex flex-col items-center p-4 border-2 border-orange-200 rounded-lg hover:border-orange-300 hover:bg-orange-50 transition-all duration-200"
                    onclick="exportReport('patient_summary')">
                <i class="fas fa-chart-pie text-2xl text-orange-600 mb-2"></i>
                <span class="font-semibold text-gray-900">Summary Report</span>
                <span class="text-sm text-gray-600">Analytics Only</span>
            </button>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script src="{{ asset('assets/js/modal-utils.js') }}"></script>
<script>
// Auto-print if print parameter is present
@if(request('print'))
window.addEventListener('load', function() {
    setTimeout(function() {
        window.print();
    }, 500);
});
@endif

function viewHistory(patientId, patientName) {
    if (confirm(`View complete medical history for ${patientName}?`)) {
        // Redirect to patient history page
        window.location.href = `/doctor/patients/${patientId}/history`;
    }
}

function exportReport(type) {
    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Get current search parameters
    const searchParams = new URLSearchParams(window.location.search);
    const search = searchParams.get('search') || '';
    const status = searchParams.get('status') || '';

    // Create form data for file download
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/doctor/reports/export-pdf';
    form.target = '_blank';

    // Add CSRF token
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = csrfToken;
    form.appendChild(csrfInput);

    // Add report type
    const typeInput = document.createElement('input');
    typeInput.type = 'hidden';
    typeInput.name = 'type';
    typeInput.value = type;
    form.appendChild(typeInput);

    // Add search parameters
    if (search) {
        const searchInput = document.createElement('input');
        searchInput.type = 'hidden';
        searchInput.name = 'search';
        searchInput.value = search;
        form.appendChild(searchInput);
    }

    if (status) {
        const statusInput = document.createElement('input');
        statusInput.type = 'hidden';
        statusInput.name = 'status';
        statusInput.value = status;
        form.appendChild(statusInput);
    }

    // Add form to page and submit
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}

function printReport() {
    window.print();
}
</script>
@endpush 