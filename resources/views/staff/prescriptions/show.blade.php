@extends('layouts.staff')

@section('title', 'Prescription Details - Staff Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Prescription Details</h1>
            <div class="flex space-x-3">
                <a href="{{ route('staff.prescriptions.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Back
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Prescription Details -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Prescription Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Medication Name</label>
                            <p class="text-lg font-medium text-gray-900">{{ $prescription->medications->first()->medication_name ?? 'N/A' }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Dosage</label>
                            <p class="text-lg font-medium text-gray-900">{{ $prescription->medications->first()->dosage ?? 'N/A' }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Frequency</label>
                            <p class="text-lg font-medium text-gray-900">{{ $prescription->medications->first()->frequency ?? 'N/A' }}</p>
                        </div>
                        
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Duration</label>
                            <p class="text-lg font-medium text-gray-900">{{ $prescription->medications->first()->duration ?? 'N/A' }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Quantity</label>
                            <p class="text-lg font-medium text-gray-900">{{ $prescription->medications->first()->quantity ?? 'N/A' }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Prescribed Date</label>
                            <p class="text-lg font-medium text-gray-900">
                                {{ $prescription->prescription_date ? \Carbon\Carbon::parse($prescription->prescription_date)->format('F d, Y') : 'N/A' }}
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                @if(($prescription->status ?? '') === 'active') bg-green-100 text-green-800
                                @elseif(($prescription->status ?? '') === 'completed') bg-blue-100 text-blue-800
                                @elseif(($prescription->status ?? '') === 'cancelled') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($prescription->status ?? 'Unknown') }}
                            </span>
                        </div>
                    </div>
                    
                    @if($prescription->medications->first()->instructions ?? false)
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-500 mb-2">Instructions</label>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-900 whitespace-pre-line">{{ $prescription->medications->first()->instructions }}</p>
                        </div>
                    </div>
                    @endif
                    
                    @if($prescription->notes)
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-500 mb-2">Notes</label>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-900 whitespace-pre-line">{{ $prescription->notes }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Patient Information -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Patient Information</h2>
                    
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 h-16 w-16">
                            <div class="h-16 w-16 rounded-full bg-blue-100 flex items-center justify-center">
                                <span class="text-xl font-medium text-blue-600">
                                    {{ substr($prescription->patient->first_name ?? 'N', 0, 1) }}{{ substr($prescription->patient->last_name ?? 'A', 0, 1) }}
                                </span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">
                                {{ $prescription->patient->first_name ?? 'N/A' }} {{ $prescription->patient->last_name ?? 'N/A' }}
                            </h3>
                            <p class="text-sm text-gray-500">Patient ID: {{ $prescription->patient->id ?? 'N/A' }}</p>
                        </div>
                    </div>
                    
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                            <p class="text-sm text-gray-900">{{ $prescription->patient->email ?? 'N/A' }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Phone</label>
                            <p class="text-sm text-gray-900">{{ $prescription->patient->phone ?? 'N/A' }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Date of Birth</label>
                            <p class="text-sm text-gray-900">
                                {{ $prescription->patient->date_of_birth ? \Carbon\Carbon::parse($prescription->patient->date_of_birth)->format('M d, Y') : 'N/A' }}
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Gender</label>
                            <p class="text-sm text-gray-900">{{ ucfirst($prescription->patient->gender ?? 'N/A') }}</p>
                        </div>
                    </div>
                    
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <a href="{{ route('staff.patients.show', $prescription->patient->id ?? 1) }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 text-center block">
                            <i class="fas fa-user mr-2"></i>View Patient Profile
                        </a>
                    </div>
                </div>
            </div>
            
        </div>

    </div>
</div>

@endsection
