@extends('layouts.staff')

@section('title', 'Edit Doctor Availability - iWellCare')
@section('page-title', 'Edit Doctor Availability')
@section('page-subtitle', 'Modify doctor availability settings')

@section('content')
<div class="doctor-availability-content">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Edit Doctor Availability</h2>
            <p class="text-gray-600">Modify the doctor's availability settings</p>
        </div>
        <a href="{{ route('staff.doctor-availability.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Back to Availability
        </a>
    </div>

    <div class="card p-6 max-w-2xl mx-auto">
        @if($errors->any())
            <div class="bg-red-100 text-red-800 p-4 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('staff.doctor-availability.update', $availability->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Doctor Selection -->
                <div>
                    <label for="doctor_id" class="block text-sm font-medium text-gray-700 mb-2">Select Doctor *</label>
                    <select name="doctor_id" id="doctor_id" class="form-input w-full" required>
                        <option value="">Choose a doctor...</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}" {{ old('doctor_id', $availability->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                Dr. {{ $doctor->user->first_name ?? 'N/A' }} {{ $doctor->user->last_name ?? '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Date Selection -->
                <div>
                    <label for="availability_date" class="block text-sm font-medium text-gray-700 mb-2">Availability Date *</label>
                    <input type="date" name="availability_date" id="availability_date"
                           value="{{ old('availability_date', $availability->availability_date) }}"
                           class="form-input w-full" required>
                    <p class="text-sm text-gray-500 mt-1">Select the date when the doctor will be available</p>
                </div>

                <!-- Time Range -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">Start Time *</label>
                        <input type="time" name="start_time" id="start_time"
                               value="{{ old('start_time', $availability->start_time) }}"
                               class="form-input w-full" required>
                    </div>
                    <div>
                        <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">End Time *</label>
                        <input type="time" name="end_time" id="end_time"
                               value="{{ old('end_time', $availability->end_time) }}"
                               class="form-input w-full" required>
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Availability Status *</label>
                    <select name="status" id="status" class="form-input w-full" required>
                        <option value="available" {{ old('status', $availability->status) === 'available' ? 'selected' : '' }}>Available</option>
                        <option value="unavailable" {{ old('status', $availability->status) === 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                        <option value="on_leave" {{ old('status', $availability->status) === 'on_leave' ? 'selected' : '' }}>On Leave</option>
                    </select>
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                    <textarea name="notes" id="notes" rows="3"
                              class="form-input w-full"
                              placeholder="Any additional notes about availability...">{{ old('notes', $availability->notes) }}</textarea>
                </div>
            </div>

            <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('staff.doctor-availability.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times mr-2"></i>Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>Update Availability
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validate time inputs
    const startTime = document.getElementById('start_time');
    const endTime = document.getElementById('end_time');

    function validateTime() {
        if (startTime.value && endTime.value) {
            if (startTime.value >= endTime.value) {
                endTime.setCustomValidity('End time must be after start time');
            } else {
                endTime.setCustomValidity('');
            }
        }
    }

    startTime.addEventListener('change', validateTime);
    endTime.addEventListener('change', validateTime);
});
</script>
@endpush
@endsection