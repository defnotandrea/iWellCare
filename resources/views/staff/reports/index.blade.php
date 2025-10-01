@extends('layouts.staff')
@section('title', 'Reports - iWellCare')
@section('page-title', 'Medical Reports')
@section('page-subtitle', 'Print lab results and medical records')
@section('content')

<!-- Quick Action Buttons -->
<div class="card p-6 mb-6">
    <div class="flex justify-between items-center mb-4">
        <div>
            <h3 class="font-semibold text-lg">Generate Reports</h3>
            <p class="text-gray-600">Access detailed analytics and export reports</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('staff.reports.inventory') }}" class="btn btn-primary">
                <i class="fas fa-boxes mr-2"></i>Inventory Report
            </a>
            <a href="{{ route('staff.reports.exportPdf') }}" class="btn btn-secondary" target="_blank">
                <i class="fas fa-file-pdf mr-1"></i>Export Medical Records
            </a>
        </div>
    </div>
</div>
<div class="card p-6 mb-6">
    <div class="flex justify-between items-center mb-4">
        <div class="font-semibold text-lg">Medical Records</div>
        <a href="{{ route('staff.reports.exportPdf') }}" class="btn btn-secondary" target="_blank"><i class="fas fa-file-pdf mr-1"></i>Export to PDF</a>
    </div>
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif
    <table class="min-w-full text-sm mb-6">
        <thead>
            <tr class="text-left text-gray-500">
                <th class="py-2 px-4">Patient</th>
                <th class="py-2 px-4">Type</th>
                <th class="py-2 px-4">Date</th>
                <th class="py-2 px-4">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($medicalRecords as $record)
                <tr>
                    <td class="py-2 px-4">{{ $record->patient->first_name ?? '-' }} {{ $record->patient->last_name ?? '' }}</td>
                    <td class="py-2 px-4">{{ ucfirst($record->record_type) }}</td>
                    <td class="py-2 px-4">{{ $record->record_date ? $record->record_date->format('Y-m-d') : '-' }}</td>
                    <td class="py-2 px-4">
                        <a href="#" class="btn btn-primary btn-sm">Print</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="py-4 text-center text-gray-400">No medical records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-4">{{ $medicalRecords->links() }}</div>
</div>
<div class="card p-6 mb-6">
    <div class="font-semibold text-lg mb-4">Consultations</div>
    <table class="min-w-full text-sm">
        <thead>
            <tr class="text-left text-gray-500">
                <th class="py-2 px-4">Patient</th>
                <th class="py-2 px-4">Doctor</th>
                <th class="py-2 px-4">Date</th>
                <th class="py-2 px-4">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($consultations as $consultation)
                <tr>
                    <td class="py-2 px-4">{{ $consultation->patient->first_name ?? '-' }} {{ $consultation->patient->last_name ?? '' }}</td>
                    <td class="py-2 px-4">{{ $consultation->doctor->first_name ?? '-' }} {{ $consultation->doctor->last_name ?? '' }}</td>
                    <td class="py-2 px-4">{{ $consultation->consultation_date ? $consultation->consultation_date->format('Y-m-d') : '-' }}</td>
                    <td class="py-2 px-4">
                        <a href="#" class="btn btn-primary btn-sm">Print</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="py-4 text-center text-gray-400">No consultations found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-4">{{ $consultations->links() }}</div>
</div>
@endsection 