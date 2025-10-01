@extends('layouts.staff')

@section('title', 'Edit Consultation - iWellCare')
@section('page-title', 'Edit Consultation')
@section('page-subtitle', 'Update consultation details')

@section('content')
<div class="consultation-content">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Edit Consultation</h2>
            <p class="text-gray-600">Update consultation information and details</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('staff.consultations.show', $consultation) }}" class="btn btn-secondary">
                <i class="fas fa-eye mr-2"></i>View Consultation
            </a>
            <a href="{{ route('staff.consultations.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left mr-2"></i>Back to Consultations
            </a>
        </div>
    </div>

    <div class="card p-6 max-w-4xl mx-auto">
        @if($errors->any())
            <div class="bg-red-100 text-red-800 p-4 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('staff.consultations.update', $consultation) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Consultation Information</h3>
                </div>

                <div>
                    <label for="patient_id" class="block text-sm font-medium text-gray-700 mb-2">Patient *</label>
                    <select name="patient_id" id="patient_id" class="form-input w-full" required>
                        <option value="">Select Patient</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ old('patient_id', $consultation->patient_id) == $patient->id ? 'selected' : '' }}>
                                {{ $patient->user->first_name ?? 'N/A' }} {{ $patient->user->last_name ?? '' }} ({{ $patient->user->email ?? 'No email' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="doctor_id" class="block text-sm font-medium text-gray-700 mb-2">Doctor *</label>
                    <select name="doctor_id" id="doctor_id" class="form-input w-full" required>
                        <option value="">Select Doctor</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->user->id }}" {{ old('doctor_id', $consultation->doctor_id) == $doctor->user->id ? 'selected' : '' }}>
                                Dr. {{ $doctor->user->first_name ?? 'N/A' }} {{ $doctor->user->last_name ?? '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="consultation_date" class="block text-sm font-medium text-gray-700 mb-2">Consultation Date *</label>
                    <input type="date" name="consultation_date" id="consultation_date"
                           value="{{ old('consultation_date', $consultation->consultation_date ? $consultation->consultation_date->format('Y-m-d') : '') }}"
                           class="form-input w-full" required>
                </div>

                <div>
                    <label for="consultation_time" class="block text-sm font-medium text-gray-700 mb-2">Consultation Time</label>
                    <input type="time" name="consultation_time" id="consultation_time"
                           value="{{ old('consultation_time', $consultation->consultation_time ? $consultation->consultation_time->format('H:i') : '') }}"
                           class="form-input w-full">
                </div>

                <!-- Medical Information -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 mt-6">Medical Information</h3>
                </div>

                <div class="md:col-span-2">
                    <label for="chief_complaint" class="block text-sm font-medium text-gray-700 mb-2">Chief Complaint *</label>
                    <textarea name="chief_complaint" id="chief_complaint" rows="3"
                              class="form-input w-full" required
                              placeholder="Patient's main complaint or reason for visit">{{ old('chief_complaint', $consultation->chief_complaint) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label for="present_illness" class="block text-sm font-medium text-gray-700 mb-2">Present Illness</label>
                    <textarea name="present_illness" id="present_illness" rows="4"
                              class="form-input w-full"
                              placeholder="Detailed description of current illness">{{ old('present_illness', $consultation->present_illness) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label for="past_medical_history" class="block text-sm font-medium text-gray-700 mb-2">Past Medical History</label>
                    <textarea name="past_medical_history" id="past_medical_history" rows="3"
                              class="form-input w-full"
                              placeholder="Previous medical conditions, surgeries, etc.">{{ old('past_medical_history', $consultation->past_medical_history) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label for="medications" class="block text-sm font-medium text-gray-700 mb-2">Current Medications</label>
                    <textarea name="medications" id="medications" rows="3"
                              class="form-input w-full"
                              placeholder="List current medications and dosages">{{ old('medications', $consultation->medications) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label for="allergies" class="block text-sm font-medium text-gray-700 mb-2">Allergies</label>
                    <textarea name="allergies" id="allergies" rows="2"
                              class="form-input w-full"
                              placeholder="Known allergies">{{ old('allergies', $consultation->allergies) }}</textarea>
                </div>

                <!-- Vital Signs -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 mt-6">Initial Vital Signs</h3>
                </div>

                <div>
                    <label for="blood_pressure" class="block text-sm font-medium text-gray-700 mb-2">Blood Pressure</label>
                    <input type="text" name="blood_pressure" id="blood_pressure"
                           value="{{ old('blood_pressure', $consultation->clinical_measurements ? json_decode($consultation->clinical_measurements, true)['blood_pressure'] ?? '' : '') }}"
                           class="form-input w-full" placeholder="e.g., 120/80 mmHg">
                </div>

                <div>
                    <label for="heart_rate" class="block text-sm font-medium text-gray-700 mb-2">Heart Rate</label>
                    <input type="text" name="heart_rate" id="heart_rate"
                           value="{{ old('heart_rate', $consultation->clinical_measurements ? json_decode($consultation->clinical_measurements, true)['heart_rate'] ?? '' : '') }}"
                           class="form-input w-full" placeholder="e.g., 72 bpm">
                </div>

                <div>
                    <label for="temperature" class="block text-sm font-medium text-gray-700 mb-2">Temperature</label>
                    <input type="text" name="temperature" id="temperature"
                           value="{{ old('temperature', $consultation->clinical_measurements ? json_decode($consultation->clinical_measurements, true)['temperature'] ?? '' : '') }}"
                           class="form-input w-full" placeholder="e.g., 36.5°C">
                </div>

                <div>
                    <label for="respiratory_rate" class="block text-sm font-medium text-gray-700 mb-2">Respiratory Rate</label>
                    <input type="text" name="respiratory_rate" id="respiratory_rate"
                           value="{{ old('respiratory_rate', $consultation->clinical_measurements ? json_decode($consultation->clinical_measurements, true)['respiratory_rate'] ?? '' : '') }}"
                           class="form-input w-full" placeholder="e.g., 16 breaths/min">
                </div>

                <div>
                    <label for="height" class="block text-sm font-medium text-gray-700 mb-2">Height</label>
                    <input type="text" name="height" id="height"
                           value="{{ old('height', $consultation->clinical_measurements ? json_decode($consultation->clinical_measurements, true)['height'] ?? '' : '') }}"
                           class="form-input w-full" placeholder="e.g., 170 cm">
                </div>

                <div>
                    <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">Weight</label>
                    <input type="text" name="weight" id="weight"
                           value="{{ old('weight', $consultation->clinical_measurements ? json_decode($consultation->clinical_measurements, true)['weight'] ?? '' : '') }}"
                           class="form-input w-full" placeholder="e.g., 70 kg">
                </div>

                <div>
                    <label for="bmi" class="block text-sm font-medium text-gray-700 mb-2">BMI</label>
                    <input type="text" name="bmi" id="bmi"
                           value="{{ old('bmi', $consultation->clinical_measurements ? json_decode($consultation->clinical_measurements, true)['bmi'] ?? '' : '') }}"
                           class="form-input w-full" placeholder="e.g., 24.2">
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" id="status" class="form-input w-full">
                        <option value="in_progress" {{ old('status', $consultation->status) === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ old('status', $consultation->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ old('status', $consultation->status) === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('staff.consultations.show', $consultation) }}" class="btn btn-secondary">
                    <i class="fas fa-times mr-2"></i>Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>Update Consultation
                </button>
            </div>
        </form>
    </div>
</div>
@endsection