@extends('layouts.admin')

@section('title', 'Reports Dashboard - iWellCare')
@section('page-title', 'Reports Dashboard')
@section('page-subtitle', 'Analytics and insights for your clinic')

@section('content')
<!-- Quick Action Buttons -->
<div class="flex justify-between items-center mb-8">
    <div>
        <h3 class="text-lg font-semibold text-gray-900">Generate Reports</h3>
        <p class="text-gray-600">Access detailed analytics and export reports</p>
    </div>
    <div class="flex space-x-3">
        <a href="{{ route('doctor.reports.monthly-sales') }}" class="btn-primary">
            <i class="fas fa-chart-line mr-2"></i>Monthly Sales
        </a>
        <a href="{{ route('doctor.reports.patient-report') }}" class="btn-secondary">
            <i class="fas fa-users mr-2"></i>Patient Report
        </a>
        <a href="{{ route('doctor.reports.consultation-report') }}" class="btn-secondary">
            <i class="fas fa-stethoscope mr-2"></i>Consultation Report
        </a>
        <a href="{{ route('doctor.reports.inventory-report') }}" class="btn-secondary">
            <i class="fas fa-boxes mr-2"></i>Inventory Report
        </a>
    </div>
</div>

<!-- Statistics Overview -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="card p-6" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Current Month</p>
                <p class="text-white text-3xl font-bold">{{ $monthlyStats['current']['appointments'] }}</p>
                <p class="text-blue-100 text-xs">Appointments</p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-calendar text-white text-xl"></i>
            </div>
        </div>
    </div>

    <div class="card p-6" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Consultations</p>
                <p class="text-white text-3xl font-bold">{{ $monthlyStats['current']['consultations'] }}</p>
                <p class="text-blue-100 text-xs">This Month</p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-stethoscope text-white text-xl"></i>
            </div>
        </div>
    </div>

    <div class="card p-6" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">New Patients</p>
                <p class="text-white text-3xl font-bold">{{ $monthlyStats['current']['new_patients'] }}</p>
                <p class="text-blue-100 text-xs">This Month</p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-user-plus text-white text-xl"></i>
            </div>
        </div>
    </div>

    <div class="card p-6" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Revenue</p>
                <p class="text-white text-3xl font-bold">₱{{ number_format($monthlyStats['current']['revenue'], 0) }}</p>
                <p class="text-blue-100 text-xs">This Month</p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-peso-sign text-white text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Monthly Comparison -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Current vs Last Month -->
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-xl font-bold text-gray-900">Monthly Comparison</h3>
            <p class="text-gray-600 text-sm">Current month vs last month performance</p>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <h4 class="text-lg font-semibold text-blue-600 mb-4">Current Month</h4>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Appointments</span>
                            <span class="font-bold text-gray-900">{{ $monthlyStats['current']['appointments'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Consultations</span>
                            <span class="font-bold text-gray-900">{{ $monthlyStats['current']['consultations'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">New Patients</span>
                            <span class="font-bold text-gray-900">{{ $monthlyStats['current']['new_patients'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Revenue</span>
                            <span class="font-bold text-gray-900">₱{{ number_format($monthlyStats['current']['revenue'], 2) }}</span>
                        </div>
                    </div>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-gray-600 mb-4">Last Month</h4>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Appointments</span>
                            <span class="font-bold text-gray-900">{{ $monthlyStats['last']['appointments'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Consultations</span>
                            <span class="font-bold text-gray-900">{{ $monthlyStats['last']['consultations'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">New Patients</span>
                            <span class="font-bold text-gray-900">{{ $monthlyStats['last']['new_patients'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Revenue</span>
                            <span class="font-bold text-gray-900">₱{{ number_format($monthlyStats['last']['revenue'], 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Growth Indicators -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <h5 class="font-semibold text-gray-900 mb-3">Growth Indicators</h5>
                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Appointments</span>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                            {{ $monthlyStats['current']['appointments'] > $monthlyStats['last']['appointments'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $monthlyStats['current']['appointments'] > $monthlyStats['last']['appointments'] ? '+' : '' }}{{ $monthlyStats['current']['appointments'] - $monthlyStats['last']['appointments'] }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Consultations</span>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                            {{ $monthlyStats['current']['consultations'] > $monthlyStats['last']['consultations'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $monthlyStats['current']['consultations'] > $monthlyStats['last']['consultations'] ? '+' : '' }}{{ $monthlyStats['current']['consultations'] - $monthlyStats['last']['consultations'] }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">New Patients</span>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                            {{ $monthlyStats['current']['new_patients'] > $monthlyStats['last']['new_patients'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $monthlyStats['current']['new_patients'] > $monthlyStats['last']['new_patients'] ? '+' : '' }}{{ $monthlyStats['current']['new_patients'] - $monthlyStats['last']['new_patients'] }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Key Performance Indicators -->
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-xl font-bold text-gray-900">Key Performance Indicators</h3>
            <p class="text-gray-600 text-sm">Important metrics and completion rates</p>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div class="text-center">
                    <div class="text-4xl font-bold text-green-600 mb-2">{{ $topMetrics['consultation_completion_rate'] }}%</div>
                    <p class="text-gray-600 text-sm">Completion Rate</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-blue-600 mb-2">{{ $monthlyStats['current']['consultations'] }}</div>
                    <p class="text-gray-600 text-sm">Consultations This Month</p>
                </div>
            </div>
            
            <!-- Performance Chart Placeholder -->
            <div class="bg-gray-50 rounded-lg p-4 text-center">
                <i class="fas fa-chart-pie text-3xl text-gray-400 mb-2"></i>
                <p class="text-gray-600 text-sm">Performance analytics chart will be displayed here</p>
            </div>
        </div>
    </div>
</div>

<!-- Detailed Reports -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Most Consulted Patients -->
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-xl font-bold text-gray-900">Most Consulted Patients</h3>
            <p class="text-gray-600 text-sm">Top patients by consultation count</p>
        </div>
        <div class="p-6">
            @if($topMetrics['most_consulted_patients']->count() > 0)
                <div class="space-y-4">
                    @foreach($topMetrics['most_consulted_patients']->take(5) as $patient)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <div class="font-semibold text-gray-900">{{ $patient->first_name }} {{ $patient->last_name }}</div>
                                <div class="text-sm text-gray-600">{{ $patient->contact }}</div>
                            </div>
                            <div class="text-right">
                                <div class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $patient->consultations_count }} consultations
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $patient->consultations->first() ? $patient->consultations->first()->consultation_date->format('M d, Y') : 'N/A' }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-users text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-600">No consultation data available</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Appointment Trends -->
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-xl font-bold text-gray-900">Appointment Trends</h3>
            <p class="text-gray-600 text-sm">Last 30 days appointment activity</p>
        </div>
        <div class="p-6">
            @if($topMetrics['appointment_trends']->count() > 0)
                <div class="space-y-3">
                    @foreach($topMetrics['appointment_trends']->take(7) as $trend)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="font-medium text-gray-900">
                                {{ \Carbon\Carbon::parse($trend->date)->format('M d, Y') }}
                            </div>
                            <div class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $trend->count }} appointments
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($topMetrics['appointment_trends']->count() > 7)
                    <div class="text-center mt-4">
                        <p class="text-sm text-gray-500">Showing last 7 days of {{ $topMetrics['appointment_trends']->count() }} total</p>
                    </div>
                @endif
            @else
                <div class="text-center py-8">
                    <i class="fas fa-chart-line text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-600">No appointment trends available</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Export Reports Section -->
<div class="card">
    <div class="px-6 py-4 border-b border-gray-100">
        <h3 class="text-xl font-bold text-gray-900">Export Reports</h3>
        <p class="text-gray-600 text-sm">Generate and download detailed reports in PDF format</p>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Monthly Sales -->
            <div class="flex flex-col items-center p-4 border-2 border-blue-200 rounded-lg hover:border-blue-300 hover:bg-blue-50 transition-all duration-200">
                <i class="fas fa-file-pdf text-2xl text-blue-600 mb-2"></i>
                <span class="font-semibold text-gray-900">Monthly Sales</span>
                <span class="text-sm text-gray-600 mb-2">PDF Report</span>
                <div class="flex flex-row flex-wrap justify-center gap-2 mt-2 w-full">
                    <button type="button" class="btn-primary btn-xs" onclick="printReport('monthly_sales')"><i class="fas fa-print mr-1"></i>Print</button>
                </div>
            </div>
            <!-- Patient Report -->
            <div class="flex flex-col items-center p-4 border-2 border-green-200 rounded-lg hover:border-green-300 hover:bg-green-50 transition-all duration-200">
                <i class="fas fa-file-pdf text-2xl text-green-600 mb-2"></i>
                <span class="font-semibold text-gray-900">Patient Report</span>
                <span class="text-sm text-gray-600 mb-2">PDF Report</span>
                <div class="flex flex-row flex-wrap justify-center gap-2 mt-2 w-full">
                    <button type="button" class="btn-primary btn-xs" onclick="printReport('patient')"><i class="fas fa-print mr-1"></i>Print</button>
                </div>
            </div>
            <!-- Consultation Report -->
            <div class="flex flex-col items-center p-4 border-2 border-purple-200 rounded-lg hover:border-purple-300 hover:bg-purple-50 transition-all duration-200">
                <i class="fas fa-file-pdf text-2xl text-purple-600 mb-2"></i>
                <span class="font-semibold text-gray-900">Consultation Report</span>
                <span class="text-sm text-gray-600 mb-2">PDF Report</span>
                <div class="flex flex-row flex-wrap justify-center gap-2 mt-2 w-full">
                    <button type="button" class="btn-primary btn-xs" onclick="printReport('consultation')"><i class="fas fa-print mr-1"></i>Print</button>
                </div>
            </div>
            <!-- Inventory Report -->
            <div class="flex flex-col items-center p-4 border-2 border-orange-200 rounded-lg hover:border-orange-300 hover:bg-orange-50 transition-all duration-200">
                <i class="fas fa-file-pdf text-2xl text-orange-600 mb-2"></i>
                <span class="font-semibold text-gray-900">Inventory Report</span>
                <span class="text-sm text-gray-600 mb-2">PDF Report</span>
                <div class="flex flex-row flex-wrap justify-center gap-2 mt-2 w-full">
                    <button type="button" class="btn-primary btn-xs" onclick="printReport('inventory')"><i class="fas fa-print mr-1"></i>Print</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/modal-utils.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    window.exportReport = function(type, format = 'pdf') {
        console.log('Export clicked:', type, format);
        ModalUtils.showLoading('Generating report...');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = format === 'csv' ? '/doctor/reports/export-excel' : '/doctor/reports/export-pdf';
        form.target = '_blank';
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        form.appendChild(csrfInput);
        const typeInput = document.createElement('input');
        typeInput.type = 'hidden';
        typeInput.name = 'type';
        typeInput.value = type;
        form.appendChild(typeInput);
        document.body.appendChild(form);
        // Try to submit and catch errors
        try {
            form.submit();
            setTimeout(() => {
                ModalUtils.hideLoading();
                ModalUtils.showSuccess(
                    'Report Generated',
                    'Your ' + (format === 'csv' ? 'CSV' : 'PDF') + ' report is being downloaded. Please check your downloads folder.',
                    () => {}
                );
            }, 2000);
        } catch (e) {
            ModalUtils.hideLoading();
            ModalUtils.showError('Export Failed', 'Could not generate the report. Please try again or contact support.');
            // Fallback: show a download link
            const fallbackUrl = form.action + '?type=' + encodeURIComponent(type);
            ModalUtils.showInfo('Download Link', '<a href="' + fallbackUrl + '" target="_blank" class="text-blue-600 underline">Click here to download manually</a>');
        }
        document.body.removeChild(form);
    }
    window.printReport = function(type) {
        console.log('Print clicked:', type);
        try {
            let url = '';
            switch(type) {
                case 'monthly_sales':
                    url = '/doctor/reports/monthly-sales?print=1';
                    break;
                case 'patient':
                    url = '/doctor/reports/patient-report?print=1';
                    break;
                case 'consultation':
                    url = '/doctor/reports/consultation-report?print=1';
                    break;
                case 'inventory':
                    url = '/doctor/reports/inventory-report?print=1';
                    break;
                default:
                    ModalUtils.showError('Print Error', 'Unknown report type.');
                    return;
            }

            // Open report page in new window for printing
            var printWindow = window.open(url, '_blank', 'width=1200,height=800');
            if (!printWindow) {
                ModalUtils.showError('Print Error', 'Popup blocked. Please allow popups and try again.');
                return;
            }

            // Wait for the page to load, then trigger print
            printWindow.onload = function() {
                setTimeout(function() {
                    printWindow.print();
                }, 1000);
            };

        } catch (e) {
            ModalUtils.showError('Print Failed', 'Could not open the print dialog. Please try again.');
        }
    }
    window.shareReport = function(type) {
        console.log('Share clicked:', type);
        ModalUtils.showConfirmation(
            'Share Report',
            'This feature will allow you to share the report via email or generate a shareable link.',
            'info',
            () => {
                ModalUtils.showInfo(
                    'Share Feature',
                    'Share functionality will be implemented in the next update.'
                );
            },
            () => {}
        );
    }
});
</script>
@endpush 