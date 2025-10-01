@extends('layouts.patient')

@section('title', 'My Prescriptions - iWellCare')
@section('page-title', 'My Prescriptions')
@section('page-subtitle', 'View your medication prescriptions and treatment plans')

@section('content')
<div class="space-y-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="card p-6" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Prescriptions</p>
                    <p class="text-white text-3xl font-bold">{{ $prescriptions->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-pills text-white text-xl"></i>
                </div>
            </div>
        </div>

        <div class="card p-6" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Active Prescriptions</p>
                    <p class="text-white text-3xl font-bold">{{ $prescriptions->where('status', 'active')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-white text-xl"></i>
                </div>
            </div>
        </div>

        <div class="card p-6" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Completed</p>
                    <p class="text-white text-3xl font-bold">{{ $prescriptions->where('status', 'completed')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-calendar-check text-white text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Prescriptions List -->
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-xl font-bold text-gray-900">Prescription History</h3>
        </div>
        <div class="p-6">
            @if($prescriptions->count() > 0)
                <div class="space-y-4">
                    @foreach($prescriptions as $prescription)
                    <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-pills text-purple-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">{{ $prescription->medication_name }}</h4>
                                    <p class="text-sm text-gray-600">Prescribed by Dr. {{ $prescription->doctor->first_name }} {{ $prescription->doctor->last_name }}</p>
                                    <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($prescription->created_at)->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                    @if($prescription->status === 'active') bg-green-100 text-green-700
                                    @elseif($prescription->status === 'completed') bg-blue-100 text-blue-700
                                    @else bg-gray-100 text-gray-700 @endif">
                                    {{ ucfirst($prescription->status) }}
                                </span>
                                <a href="{{ route('patient.prescriptions.show', $prescription) }}" class="btn-primary text-sm">
                                    <i class="fas fa-eye mr-2"></i>View Details
                                </a>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div class="bg-gray-50 rounded-lg p-3">
                                <span class="text-sm text-gray-600">Dosage</span>
                                <p class="font-medium text-gray-900">{{ $prescription->dosage }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <span class="text-sm text-gray-600">Frequency</span>
                                <p class="font-medium text-gray-900">{{ $prescription->frequency }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <span class="text-sm text-gray-600">Duration</span>
                                <p class="font-medium text-gray-900">{{ $prescription->duration }}</p>
                            </div>
                        </div>
                        
                        @if($prescription->instructions)
                        <div class="bg-blue-50 rounded-lg p-4">
                            <h5 class="font-medium text-gray-900 mb-2">Instructions</h5>
                            <p class="text-gray-700 text-sm">{{ $prescription->instructions }}</p>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                @if($prescriptions->hasPages())
                <div class="mt-6">
                    {{ $prescriptions->links() }}
                </div>
                @endif
            @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-pills text-gray-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Prescriptions Found</h3>
                    <p class="text-gray-600 mb-6">You haven't been prescribed any medications yet.</p>
                    <a href="{{ route('patient.appointments.create') }}" class="btn-primary">
                        <i class="fas fa-plus mr-2"></i>Book Appointment
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 