@extends('layouts.patient')

@section('title', 'Medical Record Details - iWellCare')
@section('page-title', 'Medical Record Details')
@section('page-subtitle', 'View detailed medical record information')

@section('content')
<div class="space-y-6">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('patient.medical-records.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Back to Medical Records
        </a>
    </div>

    <!-- Medical Record Details Card -->
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-xl font-bold text-gray-900">Medical Record Information</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Record Information -->
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-file-medical text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900">{{ $record->title }}</h4>
                            <p class="text-gray-600">{{ ucfirst($record->type) }}</p>
                        </div>
                    </div>
                    
                    <div class="bg-green-50 rounded-lg p-4">
                        <h5 class="font-medium text-gray-900 mb-2">Record Details</h5>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Type:</span>
                                <span class="font-medium">{{ ucfirst($record->type) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Recorded Date:</span>
                                <span class="font-medium">{{ \Carbon\Carbon::parse($record->created_at)->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Recorded By:</span>
                                <span class="font-medium">Dr. {{ $record->doctor->first_name }} {{ $record->doctor->last_name }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Patient Information -->
                <div class="space-y-4">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h5 class="font-medium text-gray-900 mb-2">Patient Information</h5>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Name:</span>
                                <span class="font-medium">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Age:</span>
                                <span class="font-medium">{{ auth()->user()->date_of_birth ? \Carbon\Carbon::parse(auth()->user()->date_of_birth)->age . ' years' : 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Gender:</span>
                                <span class="font-medium capitalize">{{ auth()->user()->gender ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Description -->
    @if($record->description)
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-xl font-bold text-gray-900">Record Description</h3>
        </div>
        <div class="p-6">
            <div class="bg-blue-50 rounded-lg p-4">
                <p class="text-gray-700">{{ $record->description }}</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Lab Results (if applicable) -->
    @if($record->type === 'lab_result' && $record->lab_results)
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-xl font-bold text-gray-900">Lab Results</h3>
        </div>
        <div class="p-6">
            <div class="bg-yellow-50 rounded-lg p-4">
                <pre class="text-gray-700 whitespace-pre-wrap">{{ $record->lab_results }}</pre>
            </div>
        </div>
    </div>
    @endif

    <!-- Actions -->
    <div class="flex justify-end space-x-4">
        <a href="{{ route('patient.consultations.index') }}" class="btn-secondary">
            <i class="fas fa-stethoscope mr-2"></i>View Consultations
        </a>
        <a href="{{ route('patient.appointments.create') }}" class="btn-primary">
            <i class="fas fa-plus mr-2"></i>Book Appointment
        </a>
    </div>
</div>
@endsection 