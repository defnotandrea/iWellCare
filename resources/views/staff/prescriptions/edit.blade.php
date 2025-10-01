@extends('layouts.staff')

@section('title', 'Edit Prescription - Staff Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Edit Prescription</h1>
            <a href="{{ route('staff.prescriptions.show', $prescription->id ?? 1) }}" class="text-blue-600 hover:text-blue-800">
                <i class="fas fa-arrow-left mr-2"></i>Back to Prescription
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <form action="{{ route('staff.prescriptions.update', $prescription->id ?? 1) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Patient Selection -->
                    <div class="md:col-span-2">
                        <label for="patient_id" class="block text-sm font-medium text-gray-700 mb-2">Patient *</label>
                        <select name="patient_id" id="patient_id" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Select Patient</option>
                            @foreach($patients ?? [] as $patient)
                                <option value="{{ $patient->id }}" {{ (old('patient_id', $prescription->patient_id ?? '') == $patient->id) ? 'selected' : '' }}>
                                    {{ $patient->first_name }} {{ $patient->last_name }} ({{ $patient->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('patient_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Doctor Selection -->
                    <div class="md:col-span-2">
                        <label for="doctor_id" class="block text-sm font-medium text-gray-700 mb-2">Doctor *</label>
                        <select name="doctor_id" id="doctor_id" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Select Doctor</option>
                            @foreach($doctors ?? [] as $doctor)
                                <option value="{{ $doctor->id }}" {{ (old('doctor_id', $prescription->doctor_id ?? '') == $doctor->id) ? 'selected' : '' }}>
                                    {{ $doctor->user->first_name ?? '' }} {{ $doctor->user->last_name ?? '' }} ({{ $doctor->user->email ?? '' }})
                                </option>
                            @endforeach
                        </select>
                        @error('doctor_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Medications Section -->
                    <div class="md:col-span-2">
                        <div class="flex items-center justify-between mb-4">
                            <label class="block text-sm font-medium text-gray-700">Medications *</label>
                            <button type="button" id="add-medication" class="inline-flex items-center px-3 py-1 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors text-sm">
                                <i class="fas fa-plus mr-1"></i>Add Medication
                            </button>
                        </div>

                        <!-- Medications Container -->
                        <div id="medications-container" class="space-y-3">
                            @forelse($prescription->medications ?? [] as $index => $medication)
                            <div class="medication-entry bg-gray-50 rounded-lg p-3 border border-gray-200">
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="text-sm font-medium text-gray-700">Medication #{{ $index + 1 }}</h4>
                                    <button type="button" class="remove-medication text-red-600 hover:text-red-800 transition-colors" style="{{ count($prescription->medications ?? []) <= 1 ? 'display: none;' : '' }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Medication Name *</label>
                                        <input type="text" name="medications[{{ $index }}][medication_name]" value="{{ old('medications.' . $index . '.medication_name', $medication->medication_name) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-sm" placeholder="e.g., Amoxicillin">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Dosage *</label>
                                        <input type="text" name="medications[{{ $index }}][dosage]" value="{{ old('medications.' . $index . '.dosage', $medication->dosage) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-sm" placeholder="e.g., 500mg">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Frequency *</label>
                                        <input type="text" name="medications[{{ $index }}][frequency]" value="{{ old('medications.' . $index . '.frequency', $medication->frequency) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-sm" placeholder="e.g., Twice daily">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Duration</label>
                                        <input type="text" name="medications[{{ $index }}][duration]" value="{{ old('medications.' . $index . '.duration', $medication->duration) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-sm" placeholder="e.g., 7 days">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Quantity</label>
                                        <input type="number" name="medications[{{ $index }}][quantity]" value="{{ old('medications.' . $index . '.quantity', $medication->quantity) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-sm" placeholder="e.g., 30">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Instructions</label>
                                        <textarea name="medications[{{ $index }}][instructions]" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-sm" placeholder="Special instructions...">{{ old('medications.' . $index . '.instructions', $medication->instructions) }}</textarea>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="medication-entry bg-gray-50 rounded-lg p-3 border border-gray-200">
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="text-sm font-medium text-gray-700">Medication #1</h4>
                                    <button type="button" class="remove-medication text-red-600 hover:text-red-800 transition-colors" style="display: none;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Medication Name *</label>
                                        <input type="text" name="medications[0][medication_name]" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-sm" placeholder="e.g., Amoxicillin">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Dosage *</label>
                                        <input type="text" name="medications[0][dosage]" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-sm" placeholder="e.g., 500mg">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Frequency *</label>
                                        <input type="text" name="medications[0][frequency]" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-sm" placeholder="e.g., Twice daily">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Duration</label>
                                        <input type="text" name="medications[0][duration]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-sm" placeholder="e.g., 7 days">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Quantity</label>
                                        <input type="number" name="medications[0][quantity]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-sm" placeholder="e.g., 30">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Instructions</label>
                                        <textarea name="medications[0][instructions]" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-sm" placeholder="Special instructions..."></textarea>
                                    </div>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Prescribed Date -->
                    <div>
                        <label for="prescribed_date" class="block text-sm font-medium text-gray-700 mb-2">Prescribed Date *</label>
                        <input type="date" name="prescribed_date" id="prescribed_date" value="{{ old('prescribed_date', $prescription->prescription_date ?? date('Y-m-d')) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('prescribed_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="active" {{ (old('status', $prescription->status ?? '') == 'active') ? 'selected' : '' }}>Active</option>
                            <option value="completed" {{ (old('status', $prescription->status ?? '') == 'completed') ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ (old('status', $prescription->status ?? '') == 'cancelled') ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- General Instructions -->
                    <div class="md:col-span-2">
                        <label for="instructions" class="block text-sm font-medium text-gray-700 mb-2">General Instructions</label>
                        <textarea name="instructions" id="instructions" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="General instructions for the patient...">{{ old('instructions', $prescription->instructions ?? '') }}</textarea>
                        @error('instructions')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Notes -->
                    <div class="md:col-span-2">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                        <textarea name="notes" id="notes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Additional notes...">{{ old('notes', $prescription->notes ?? '') }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end space-x-4 mt-8">
                    <a href="{{ route('staff.prescriptions.show', $prescription->id ?? 1) }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        <i class="fas fa-save mr-2"></i>Update Prescription
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let medicationCount = {{ count($prescription->medications ?? []) }};
    const container = document.getElementById('medications-container');
    const addButton = document.getElementById('add-medication');

    // Add medication functionality
    addButton.addEventListener('click', function() {
        const newMedication = createMedicationEntry(medicationCount);
        container.appendChild(newMedication);
        medicationCount++;
        updateMedicationNumbers();
        updateRemoveButtons();
    });

    // Remove medication functionality
    container.addEventListener('click', function(e) {
        if (e.target.closest('.remove-medication')) {
            e.target.closest('.medication-entry').remove();
            updateMedicationNumbers();
            updateRemoveButtons();
        }
    });

    function createMedicationEntry(index) {
        const div = document.createElement('div');
        div.className = 'medication-entry bg-gray-50 rounded-lg p-3 border border-gray-200';
        div.innerHTML = `
            <div class="flex items-center justify-between mb-3">
                <h4 class="text-sm font-medium text-gray-700">Medication #${index + 1}</h4>
                <button type="button" class="remove-medication text-red-600 hover:text-red-800 transition-colors">
                    <i class="fas fa-trash"></i>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Medication Name *</label>
                    <input type="text" name="medications[${index}][medication_name]" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-sm" placeholder="e.g., Amoxicillin">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Dosage *</label>
                    <input type="text" name="medications[${index}][dosage]" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-sm" placeholder="e.g., 500mg">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Frequency *</label>
                    <input type="text" name="medications[${index}][frequency]" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-sm" placeholder="e.g., Twice daily">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Duration</label>
                    <input type="text" name="medications[${index}][duration]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-sm" placeholder="e.g., 7 days">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Quantity</label>
                    <input type="number" name="medications[${index}][quantity]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-sm" placeholder="e.g., 30">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Instructions</label>
                    <textarea name="medications[${index}][instructions]" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-sm" placeholder="Special instructions..."></textarea>
                </div>
            </div>
        `;
        return div;
    }

    function updateMedicationNumbers() {
        const entries = container.querySelectorAll('.medication-entry');
        entries.forEach((entry, index) => {
            const title = entry.querySelector('h4');
            title.textContent = `Medication #${index + 1}`;
        });
    }

    function updateRemoveButtons() {
        const entries = container.querySelectorAll('.medication-entry');
        entries.forEach((entry, index) => {
            const removeBtn = entry.querySelector('.remove-medication');
            if (entries.length === 1) {
                removeBtn.style.display = 'none';
            } else {
                removeBtn.style.display = 'block';
            }
        });
    }

    // Initialize
    updateRemoveButtons();
});
</script>
@endpush

@push('styles')
<style>
.medication-entry {
    animation: fadeInUp 0.3s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
@endpush
@endsection
