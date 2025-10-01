@extends('layouts.admin')

@section('title', 'Appointment Details')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Appointment Details</h1>
        <a href="{{ route('staff.appointments.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Back to Appointments
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-semibold text-gray-800">Appointment Information</h2>
                        <div class="flex items-center space-x-2">
                            @switch($appointment->status)
                                @case('scheduled')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        Scheduled
                                    </span>
                                    @break
                                @case('confirmed')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        Confirmed
                                    </span>
                                    @break
                                @case('cancelled')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                        Cancelled
                                    </span>
                                    @break
                                @case('completed')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                        Completed
                                    </span>
                                    @break
                                @default
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                            @endswitch
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Appointment Details</h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Date</dt>
                                    <dd class="text-sm text-gray-900">{{ $appointment->appointment_date->format('l, F d, Y') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Time</dt>
                                    <dd class="text-sm text-gray-900">{{ $appointment->appointment_time }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Reason</dt>
                                    <dd class="text-sm text-gray-900">{{ $appointment->reason }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Created</dt>
                                    <dd class="text-sm text-gray-900">{{ $appointment->created_at->format('M d, Y g:i A') }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Patient Information</h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Name</dt>
                                    <dd class="text-sm text-gray-900">{{ $appointment->patient ? $appointment->patient->full_name : 'Unknown Patient' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                                    <dd class="text-sm text-gray-900">{{ $appointment->patient ? $appointment->patient->email : 'No email' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Contact</dt>
                                    <dd class="text-sm text-gray-900">{{ $appointment->patient ? $appointment->patient->contact : 'No contact' }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Doctor Information</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Name</dt>
                                <dd class="text-sm text-gray-900">{{ $appointment->doctor ? $appointment->doctor->first_name . ' ' . $appointment->doctor->last_name : 'Unassigned' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="text-sm text-gray-900">{{ $appointment->doctor ? $appointment->doctor->email : 'No email' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Actions</h3>
                    <div class="space-y-3">
                        <a href="{{ route('staff.appointments.edit', $appointment) }}" class="btn-secondary w-full">
                            <i class="fas fa-edit mr-2"></i>Edit Appointment
                        </a>

                        @if($appointment->status === 'scheduled')
                            <button type="button" 
                                    class="btn-primary w-full"
                                    onclick="showConfirmModal({{ $appointment->id }}, '{{ $appointment->patient ? $appointment->patient->full_name : 'Unknown Patient' }}', '{{ $appointment->appointment_date->format('M d, Y') }}')">
                                <i class="fas fa-check mr-2"></i>Confirm Appointment
                            </button>
                        @endif

                        @if(in_array($appointment->status, ['scheduled', 'confirmed']))
                            <button type="button" 
                                    class="btn-danger w-full"
                                    onclick="showCancelModal({{ $appointment->id }}, '{{ $appointment->patient ? $appointment->patient->full_name : 'Unknown Patient' }}', '{{ $appointment->appointment_date->format('M d, Y') }}')">
                                <i class="fas fa-times mr-2"></i>Cancel Appointment
                            </button>
                        @endif

                        @if($appointment->status === 'confirmed')
                            <button type="button" 
                                    class="btn-primary w-full"
                                    onclick="showCompleteModal({{ $appointment->id }}, '{{ $appointment->patient ? $appointment->patient->full_name : 'Unknown Patient' }}', '{{ $appointment->appointment_date->format('M d, Y') }}')">
                                <i class="fas fa-check-double mr-2"></i>Mark as Completed
                            </button>
                        @endif

                        @if($appointment->patient)
                            <a href="{{ route('staff.patients.show', $appointment->patient) }}" class="btn-secondary w-full">
                                <i class="fas fa-user mr-2"></i>View Patient
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Modals -->
@include('staff.appointments.partials.modals')
@endsection 