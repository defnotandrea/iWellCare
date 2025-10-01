@extends('layouts.admin')

@section('title', 'Create New Appointment - iWellCare')
@section('page-title', 'Create New Appointment')
@section('page-subtitle', 'Schedule a new patient appointment')

@section('content')
<div class="appointments-content">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Create New Appointment</h1>
        <a href="{{ route('staff.appointments.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Back to Appointments
        </a>
    </div>

    <div class="card p-6">
        <form method="POST" action="{{ route('staff.appointments.store') }}" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="patient_id" class="block text-sm font-medium text-gray-700 mb-2">Patient</label>
                    <select id="patient_id" name="patient_id" class="form-input w-full @error('patient_id') border-red-500 @enderror" required>
                        <option value="">Select Patient</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                {{ $patient->first_name }} {{ $patient->last_name }} - {{ $patient->email }}
                            </option>
                        @endforeach
                    </select>
                    @error('patient_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="doctor_id" class="block text-sm font-medium text-gray-700 mb-2">Doctor</label>
                    
                    <!-- Doctor Availability Status -->
                    <div class="mb-3 p-3 bg-gray-50 border border-gray-200 rounded-lg">
                        <h4 class="text-sm font-semibold text-gray-700 mb-2">Doctor Availability Status:</h4>
                        <div class="space-y-1">
                            @foreach($doctors as $doctor)
                                @php
                                    $latestSetting = $doctor->availabilitySettings->first();
                                    $availability = $latestSetting ? $latestSetting->getCurrentStatus() : [
                                        'is_available' => true,
                                        'message' => 'Available',
                                        'status' => 'available'
                                    ];
                                @endphp
                                <div class="flex items-center justify-between p-2 rounded-lg {{ $availability['is_available'] ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 rounded-full mr-2 {{ $availability['is_available'] ? 'bg-green-500' : 'bg-red-500' }}"></div>
                                        <span class="font-medium text-gray-900">
                                            Dr. {{ $doctor->first_name }} {{ $doctor->last_name }}
                                        </span>
                                    </div>
                                    <div class="text-sm font-medium {{ $availability['is_available'] ? 'text-green-700' : 'text-red-700' }}">
                                        @if($availability['is_available'])
                                            <i class="fas fa-check-circle mr-1"></i>Available
                                        @else
                                            <i class="fas fa-times-circle mr-1"></i>{{ $availability['message'] }}
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <select id="doctor_id" name="doctor_id" class="form-input w-full @error('doctor_id') border-red-500 @enderror" required>
                        <option value="">Select Doctor</option>
                        @foreach($doctors as $doctor)
                            @php
                                $latestSetting = $doctor->availabilitySettings->first();
                                $availability = $latestSetting ? $latestSetting->getCurrentStatus() : [
                                    'is_available' => true,
                                    'message' => 'Available',
                                    'status' => 'available'
                                ];
                            @endphp
                            <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}
                                @if(!$availability['is_available']) disabled @endif
                                class="@if(!$availability['is_available']) text-red-500 @else text-gray-900 @endif"
                            >
                                Dr. {{ $doctor->first_name }} {{ $doctor->last_name }}
                                @if($availability['is_available'])
                                    ✅ Available
                                @else
                                    ❌ {{ $availability['message'] }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @error('doctor_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="appointment_date" class="block text-sm font-medium text-gray-700 mb-2">Appointment Date</label>
                    <input type="date" id="appointment_date" name="appointment_date" 
                           value="{{ old('appointment_date') }}" 
                           class="form-input w-full @error('appointment_date') border-red-500 @enderror" required>
                    @error('appointment_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="appointment_time" class="block text-sm font-medium text-gray-700 mb-2">Appointment Time</label>
                    <input type="time" id="appointment_time" name="appointment_time" 
                           value="{{ old('appointment_time') }}" 
                           class="form-input w-full @error('appointment_time') border-red-500 @enderror" required>
                    @error('appointment_time')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">Reason for Visit</label>
                <textarea id="reason" name="reason" rows="3" 
                          class="form-input w-full @error('reason') border-red-500 @enderror" required>{{ old('reason') }}</textarea>
                @error('reason')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select id="status" name="status" class="form-input w-full @error('status') border-red-500 @enderror" required>
                    <option value="scheduled" {{ old('status') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    <option value="confirmed" {{ old('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('staff.appointments.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times mr-2"></i>Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>Create Appointment
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 