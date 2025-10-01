@extends('layouts.admin')

@section('title', 'Consultation Report - iWellCare')
@section('page-title', 'Consultation Report')
@section('page-subtitle', 'Consultation statistics and analysis')

@push('styles')
<style>
@media print {
    /* Hide layout elements */
    nav, .navbar, .sidebar, .fixed, .z-50, .z-40 {
        display: none !important;
    }

    /* Hide modal and overlay */
    .fixed.inset-0.bg-black, #alertModal {
        display: none !important;
    }

    /* Hide no-print elements */
    .no-print {
        display: none !important;
    }

    /* Reset layout */
    body {
        font-size: 12px !important;
        line-height: 1.4 !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .flex, .flex-1, .ml-64, .min-h-screen {
        display: block !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        min-height: auto !important;
    }

    /* Card styling */
    .card {
        border: 1px solid #ddd !important;
        box-shadow: none !important;
        break-inside: avoid;
        margin-bottom: 20px !important;
    }

    /* Tailwind grid fixes */
    .grid {
        display: block !important;
    }

    .grid-cols-1, .md\\:grid-cols-2, .lg\\:grid-cols-4 {
        display: block !important;
    }

    .gap-6 > *, .gap-8 > * {
        margin-bottom: 20px !important;
    }

    /* Table styling */
    table {
        font-size: 11px !important;
        width: 100% !important;
        margin-bottom: 20px !important;
    }

    th, td {
        padding: 6px !important;
        border: 1px solid #ddd !important;
    }

    /* Page breaks */
    .page-break {
        page-break-before: always;
    }

    /* Print header */
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

    /* Hide pagination links */
    .pagination, .px-6.py-4.border-t.border-gray-200 {
        display: none !important;
    }
}
</style>
@endpush

@section('content')
@if(request('print'))
<div class="print-header">
    <h1>Consultation Report</h1>
    <p><strong>Period:</strong> {{ \Carbon\Carbon::parse($startDate)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}</p>
    <p><strong>Generated:</strong> {{ \Carbon\Carbon::now()->format('F d, Y \a\t g:i A') }}</p>
    <p><strong>iWellCare Healthcare System</strong></p>
</div>
@else
<!-- Header Actions -->
<div class="flex justify-between items-center mb-8 no-print">
                <div>
        <h3 class="text-lg font-semibold text-gray-900">Consultation Analysis Report</h3>
        <p class="text-gray-600">Comprehensive consultation statistics and insights</p>
                </div>
    <a href="{{ route('doctor.reports.index') }}" class="btn-secondary">
        <i class="fas fa-arrow-left mr-2"></i>Back to Reports
                    </a>
            </div>
@endif

@if(!request('print'))
            <!-- Date Range Selector -->
<div class="card mb-8 no-print">
    <div class="px-6 py-4 border-b border-gray-100">
        <h3 class="text-xl font-bold text-gray-900">Select Date Range</h3>
        <p class="text-gray-600 text-sm">Choose the date range for your consultation analysis</p>
    </div>
    <div class="p-6">
        <form method="GET" action="{{ route('doctor.reports.consultation-report') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                <input type="date"
                       class="form-input w-full"
                       id="start_date"
                       name="start_date"
                                   value="{{ $startDate }}">
                        </div>
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                <input type="date"
                       class="form-input w-full"
                       id="end_date"
                       name="end_date"
                                   value="{{ $endDate }}">
                        </div>
            <div class="flex items-end">
                <button type="submit" class="btn-primary w-full">
                    <i class="fas fa-search mr-2"></i>Generate Report
                                </button>
                            </div>
            <div class="flex items-end">
                <a href="{{ route('doctor.reports.consultation-report') }}" class="btn-secondary w-full">
                    <i class="fas fa-refresh mr-2"></i>Reset
                </a>
                        </div>
                    </form>
                </div>
            </div>
@endif

            <!-- Consultation Statistics -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="card p-6" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
        <div class="flex items-center justify-between">
                                <div>
                <p class="text-blue-100 text-sm font-medium">Total Consultations</p>
                <p class="text-white text-3xl font-bold">{{ $consultationStats['total'] }}</p>
                <p class="text-blue-100 text-xs">In Date Range</p>
                                </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-stethoscope text-white text-xl"></i>
                                </div>
                            </div>
                        </div>

    <div class="card p-6" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
        <div class="flex items-center justify-between">
                                <div>
                <p class="text-blue-100 text-sm font-medium">Completed</p>
                <p class="text-white text-3xl font-bold">{{ $consultationStats['completed'] }}</p>
                <p class="text-blue-100 text-xs">Successfully Done</p>
                                </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-check-circle text-white text-xl"></i>
                                </div>
                            </div>
                        </div>

    <div class="card p-6" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
        <div class="flex items-center justify-between">
                                <div>
                <p class="text-blue-100 text-sm font-medium">In Progress</p>
                <p class="text-white text-3xl font-bold">{{ $consultationStats['in_progress'] }}</p>
                <p class="text-blue-100 text-xs">Currently Active</p>
                                </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-clock text-white text-xl"></i>
                                </div>
                            </div>
                        </div>

    <div class="card p-6" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white;">
        <div class="flex items-center justify-between">
                                <div>
                <p class="text-blue-100 text-sm font-medium">Avg Duration</p>
                <p class="text-white text-3xl font-bold">{{ $consultationStats['average_duration'] }}</p>
                <p class="text-blue-100 text-xs">Per Consultation</p>
                                </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-hourglass-half text-white text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

<!-- Completion Rate and Date Range Summary -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Completion Rate -->
                    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-xl font-bold text-gray-900">Completion Rate</h3>
            <p class="text-gray-600 text-sm">Consultation completion statistics</p>
                        </div>
        <div class="p-6">
                            @php
                                $completionRate = $consultationStats['total'] > 0 
                                    ? round(($consultationStats['completed'] / $consultationStats['total']) * 100, 1) 
                                    : 0;
                                $inProgressRate = $consultationStats['total'] > 0 
                                    ? round(($consultationStats['in_progress'] / $consultationStats['total']) * 100, 1) 
                                    : 0;
                            @endphp
            <div class="grid grid-cols-2 gap-6 text-center mb-6">
                <div>
                    <div class="text-4xl font-bold text-green-600">{{ $completionRate }}%</div>
                    <div class="text-sm text-gray-600">Completed</div>
                                    </div>
                <div>
                    <div class="text-4xl font-bold text-yellow-600">{{ $inProgressRate }}%</div>
                    <div class="text-sm text-gray-600">In Progress</div>
                                    </div>
                                </div>
            <div class="w-full bg-gray-200 rounded-full h-3 mb-3">
                <div class="bg-green-500 h-3 rounded-full" style="width: {{ $completionRate }}%"></div>
                <div class="bg-yellow-500 h-3 rounded-full -mt-3" style="width: {{ $inProgressRate }}%"></div>
                            </div>
            <div class="text-sm text-gray-600 text-center">
                                {{ $consultationStats['completed'] }} completed, {{ $consultationStats['in_progress'] }} in progress
                        </div>
                    </div>
                </div>

    <!-- Date Range Summary -->
                    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-xl font-bold text-gray-900">Date Range Summary</h3>
            <p class="text-gray-600 text-sm">Analysis period overview</p>
                        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <div class="text-sm text-gray-600 mb-1">Start Date</div>
                    <div class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($startDate)->format('M d, Y') }}</div>
                                    </div>
                <div>
                    <div class="text-sm text-gray-600 mb-1">End Date</div>
                    <div class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}</div>
                                </div>
                <div>
                    <div class="text-sm text-gray-600 mb-1">Total Days</div>
                    <div class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($startDate)->diffInDays(\Carbon\Carbon::parse($endDate)) + 1 }} days</div>
                                    </div>
                <div>
                    <div class="text-sm text-gray-600 mb-1">Avg per Day</div>
                    <div class="font-semibold text-gray-900">{{ $consultationStats['total'] > 0 ? round($consultationStats['total'] / (\Carbon\Carbon::parse($startDate)->diffInDays(\Carbon\Carbon::parse($endDate)) + 1), 1) : 0 }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Consultations Table -->
            <div class="card">
    <div class="px-6 py-4 border-b border-gray-100">
        <h3 class="text-xl font-bold text-gray-900">Consultations List ({{ $consultations->total() }} total)</h3>
        <p class="text-gray-600 text-sm">Detailed consultation information and records</p>
                </div>
    <div class="p-6">
        @if($consultations->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Doctor</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diagnosis</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($consultations as $consultation)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4">
                                        <div>
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $consultation->consultation_date->format('M d, Y') }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $consultation->consultation_date->format('g:i A') }}
                                    </div>
                                        </div>
                                    </td>
                            <td class="px-6 py-4">
                                        <div>
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $consultation->patient->first_name }} {{ $consultation->patient->last_name }}
                                    </div>
                                    <div class="text-sm text-gray-500">ID: #{{ $consultation->patient->id }}</div>
                                        </div>
                                    </td>
                            <td class="px-6 py-4">
                                        <div>
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $consultation->doctor->first_name ?? 'N/A' }}
                                    </div>
                                    <div class="text-sm text-gray-500">{{ $consultation->doctor->role ?? 'N/A' }}</div>
                                        </div>
                                    </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $consultation->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $consultation->status === 'in_progress' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $consultation->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ ucfirst(str_replace('_', ' ', $consultation->status)) }}
                                        </span>
                                    </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $consultationStats['average_duration'] }}
                                    </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                            @if($consultation->diagnosis)
                                        {{ Str::limit($consultation->diagnosis, 50) }}
                                            @else
                                        <span class="text-gray-500">No diagnosis</span>
                                            @endif
                                        </div>
                                    </td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    <a href="{{ route('doctor.consultations.show', $consultation) }}" 
                                       class="text-blue-600 hover:text-blue-900 transition-colors duration-200"
                                       title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                    <a href="{{ route('doctor.consultations.edit', $consultation) }}" 
                                       class="text-gray-600 hover:text-gray-900 transition-colors duration-200"
                                       title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if($consultation->status !== 'completed')
                                    <button type="button" 
                                            class="text-green-600 hover:text-green-900 transition-colors duration-200"
                                            onclick="completeConsultation({{ $consultation->id }}, '{{ $consultation->patient->first_name }} {{ $consultation->patient->last_name }}')" 
                                            title="Mark Complete">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                        @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($consultations->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Showing {{ $consultations->firstItem() ?? 0 }} to {{ $consultations->lastItem() ?? 0 }} of {{ $consultations->total() }} results
                        </div>
                        <div class="flex space-x-2">
                            {{ $consultations->links() }}
                        </div>
                    </div>
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <i class="fas fa-stethoscope text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Consultations Found</h3>
                <p class="text-gray-600">No consultations found for the selected date range</p>
            </div>
        @endif
    </div>
</div>

@if(!request('print'))
<!-- Export Options -->
<div class="card mt-8 no-print">
    <div class="px-6 py-4 border-b border-gray-100">
        <h3 class="text-xl font-bold text-gray-900">Export Options</h3>
        <p class="text-gray-600 text-sm">Download or share your consultation report</p>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <button type="button"
                    class="flex flex-col items-center p-4 border-2 border-blue-200 rounded-lg hover:border-blue-300 hover:bg-blue-50 transition-all duration-200"
                    onclick="exportReport('consultation')">
                <i class="fas fa-file-pdf text-2xl text-blue-600 mb-2"></i>
                <span class="font-semibold text-gray-900">Export PDF</span>
                <span class="text-sm text-gray-600">Complete Report</span>
            </button>

            <button type="button"
                    class="flex flex-col items-center p-4 border-2 border-green-200 rounded-lg hover:border-green-300 hover:bg-green-50 transition-all duration-200"
                    onclick="exportReport('consultation_excel')">
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
                    onclick="exportReport('consultation_summary')">
                <i class="fas fa-chart-bar text-2xl text-orange-600 mb-2"></i>
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

function completeConsultation(consultationId, patientName) {
    alert('Consultation completion functionality will be implemented in the next update.');
}

function exportReport(type) {
    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Get current date parameters
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;

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

    // Add date parameters
    const startDateInput = document.createElement('input');
    startDateInput.type = 'hidden';
    startDateInput.name = 'start_date';
    startDateInput.value = startDate;
    form.appendChild(startDateInput);

    const endDateInput = document.createElement('input');
    endDateInput.type = 'hidden';
    endDateInput.name = 'end_date';
    endDateInput.value = endDate;
    form.appendChild(endDateInput);

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