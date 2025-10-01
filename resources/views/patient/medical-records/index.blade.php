@extends('layouts.patient')

@section('title', 'Medical Records - iWellCare')
@section('page-title', 'Medical Records')
@section('page-subtitle', 'View your lab results and medical history')

@section('content')
<div class="space-y-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="card p-6" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Records</p>
                    <p class="text-white text-3xl font-bold">{{ $medicalRecords->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-file-medical text-white text-xl"></i>
                </div>
            </div>
        </div>

        <div class="card p-6" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Lab Results</p>
                    <p class="text-white text-3xl font-bold">{{ $medicalRecords->where('type', 'lab_result')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-flask text-white text-xl"></i>
                </div>
            </div>
        </div>

        <div class="card p-6" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">This Year</p>
                    <p class="text-white text-3xl font-bold">{{ $medicalRecords->where('created_at', '>=', now()->startOfYear())->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-calendar text-white text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Medical Records List -->
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-xl font-bold text-gray-900">Medical Records</h3>
        </div>
        <div class="p-6">
            @if($medicalRecords->count() > 0)
                <div class="space-y-4">
                    @foreach($medicalRecords as $record)
                    <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-file-medical text-green-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">{{ $record->title }}</h4>
                                    <p class="text-sm text-gray-600">{{ ucfirst($record->type) }} • {{ \Carbon\Carbon::parse($record->created_at)->format('M d, Y') }}</p>
                                    <p class="text-sm text-gray-600">Recorded by Dr. {{ $record->doctor->first_name }} {{ $record->doctor->last_name }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('patient.medical-records.show', $record) }}" class="btn-primary text-sm">
                                    <i class="fas fa-eye mr-2"></i>View Details
                                </a>
                            </div>
                        </div>
                        
                        @if($record->description)
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-700">{{ Str::limit($record->description, 200) }}</p>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                @if($medicalRecords->hasPages())
                <div class="mt-6">
                    {{ $medicalRecords->links() }}
                </div>
                @endif
            @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-file-medical text-gray-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Medical Records Found</h3>
                    <p class="text-gray-600 mb-6">Your medical records will appear here after consultations and lab tests.</p>
                    <a href="{{ route('patient.appointments.create') }}" class="btn-primary">
                        <i class="fas fa-plus mr-2"></i>Book Appointment
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 