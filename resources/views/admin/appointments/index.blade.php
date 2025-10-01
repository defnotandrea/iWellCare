@extends('layouts.admin')

@section('page-title', 'Appointments')
@section('page-subtitle', 'Manage patient bookings')

@section('content')
<style>
.card-hover {
    transition: all 0.3s ease;
}

.card-hover:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 5px 10px -5px rgba(0, 0, 0, 0.04);
}
</style>

<div class="space-y-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white overflow-hidden shadow-lg rounded-xl card-hover">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center">
                            <i class="fas fa-calendar-check text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-medium text-gray-500">Total Appointments</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $appointments->total() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-lg rounded-xl card-hover">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-yellow-500 rounded-xl flex items-center justify-center">
                            <i class="fas fa-clock text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-medium text-gray-500">Pending</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $appointments->where('status', 'pending')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-lg rounded-xl card-hover">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center">
                            <i class="fas fa-check-circle text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-medium text-gray-500">Confirmed</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $appointments->where('status', 'confirmed')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-lg rounded-xl card-hover">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-gray-500 rounded-xl flex items-center justify-center">
                            <i class="fas fa-check-double text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-medium text-gray-500">Completed</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $appointments->where('status', 'completed')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filter Section -->
    <div class="bg-white shadow-lg rounded-xl p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
            <i class="fas fa-search text-blue-500"></i> Search & Filter Appointments
        </h3>

        <form method="GET" action="" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Patient Name</label>
                <div class="relative">
                    <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="patient" class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="{{ request('patient') }}" placeholder="Search patient...">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Doctor Name</label>
                <div class="relative">
                    <i class="fas fa-user-md absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="doctor" class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="{{ request('doctor') }}" placeholder="Search doctor...">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Appointment Date</label>
                <div class="relative">
                    <i class="fas fa-calendar absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="date" name="date" class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="{{ request('date') }}">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <div class="relative">
                    <i class="fas fa-filter absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <select name="status" class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors flex items-center justify-center gap-2">
                    <i class="fas fa-search"></i> Search
                </button>
                <a href="{{ route('admin.appointments.index') }}" class="flex-1 bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors flex items-center justify-center gap-2">
                    <i class="fas fa-undo"></i> Reset
                </a>
            </div>
        </form>
    </div>

@if(session('success'))
    <div class="bg-green-100 text-green-800 p-4 rounded mb-6 flex items-center gap-2">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        @if(str_contains(session('success'), 'approved'))
            <div class="ml-2 text-sm text-green-600">
                📧 Email confirmation sent to patient automatically!
            </div>
        @endif
        @if(str_contains(session('success'), 'background'))
            <div class="ml-2 text-sm text-blue-600">
                ⚡ Action completed instantly! Emails are being sent in the background.
            </div>
        @endif
    </div>
@endif

@if(session('warning'))
    <div class="bg-yellow-100 text-yellow-800 p-4 rounded mb-6 flex items-center gap-2">
        <i class="fas fa-exclamation-triangle"></i> {{ session('warning') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 text-red-800 p-4 rounded mb-6 flex items-center gap-2">
        <i class="fas fa-times-circle"></i> {{ session('error') }}
    </div>
@endif

    <!-- Appointments Table -->
    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-calendar-check text-blue-500"></i> Appointment List
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Doctor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @forelse($appointments as $appointment)
                    <tr class="hover:bg-blue-50 transition-colors duration-200">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full text-blue-600 font-bold text-lg flex-shrink-0">
                                    {{ strtoupper(substr($appointment->patient->first_name ?? '-', 0, 1)) }}
                                </span>
                                <div class="min-w-0 flex-1">
                                    <div class="font-medium truncate">{{ $appointment->patient->first_name ?? '-' }} {{ $appointment->patient->last_name ?? '' }}</div>
                                    <div class="text-xs text-gray-500 truncate">{{ $appointment->patient->email ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex items-center justify-center w-10 h-10 bg-green-100 rounded-full text-green-600 font-bold text-lg flex-shrink-0">
                                    {{ strtoupper(substr($appointment->doctor->first_name ?? '-', 0, 1)) }}
                                </span>
                                <div class="min-w-0 flex-1">
                                    <div class="font-medium truncate">Dr. {{ $appointment->doctor->first_name ?? '-' }} {{ $appointment->doctor->last_name ?? '' }}</div>
                                    <div class="text-xs text-gray-500 truncate">{{ $appointment->doctor->specialization ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex flex-col">
                                <div class="font-medium">{{ $appointment->appointment_date ? $appointment->appointment_date->format('M d, Y') : '-' }}</div>
                                <div class="text-xs text-gray-500">{{ $appointment->appointment_date ? $appointment->appointment_date->format('l') : '' }}</div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex flex-col">
                                <div class="font-medium">{{ $appointment->appointment_time ? $appointment->appointment_time->format('h:i A') : '-' }}</div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center">
                                @php
                                    $badge = match($appointment->status) {
                                        'pending' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                        'confirmed' => 'bg-green-100 text-green-700 border-green-200',
                                        'completed' => 'bg-gray-100 text-gray-700 border-gray-200',
                                        'cancelled' => 'bg-red-100 text-red-700 border-red-200',
                                        default => 'bg-gray-100 text-gray-700 border-gray-200',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium border-2 {{ $badge }} shadow-sm">
                                    <i class="fas fa-circle mr-2 text-[6px]"></i> {{ ucfirst($appointment->status) }}
                                </span>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex flex-wrap gap-2">
                                @if($appointment->status === 'pending')
                                    <form method="POST" action="/admin/appointments/{{ $appointment->id }}/confirm" class="inline-block">
                                        @csrf
                                        <button type="submit"
                                                class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200">
                                        <i class="fas fa-check mr-1.5"></i> Approve
                                    </button>
                                    </form>
                                    <form method="POST" action="/admin/appointments/{{ $appointment->id }}/decline" class="inline-block">
                                        @csrf
                                        <button type="submit"
                                                class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200">
                                        <i class="fas fa-times mr-1.5"></i> Decline
                                    </button>
                                    </form>
                                @elseif($appointment->status === 'confirmed')
                                    <form method="POST" action="/admin/appointments/{{ $appointment->id }}/complete" class="inline-block">
                                        @csrf
                                        <button type="submit"
                                                class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                        <i class="fas fa-check-double mr-1.5"></i> Complete
                                    </button>
                                    </form>
                                @endif
                                <form method="POST" action="/admin/appointments/{{ $appointment->id }}" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200"
                                            onclick="return confirm('Are you sure you want to delete this appointment? This action cannot be undone.');">
                                    <i class="fas fa-trash mr-1.5"></i> Delete
                                </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-gray-400">
                            <div class="flex flex-col items-center gap-2">
                                <i class="fas fa-calendar-times text-4xl text-gray-300"></i>
                                <div class="text-lg font-medium">No appointments found</div>
                                <div class="text-sm">Try adjusting your search criteria</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $appointments->links() }}
        </div>
    </div>
</div>










</div>
@endsection 