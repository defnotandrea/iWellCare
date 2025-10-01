@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Edit Prescription</h2>
    <form action="{{ route('doctor.prescriptions.update', $prescription) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card mb-3">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="patient_id" class="form-label">Patient</label>
                        <select name="patient_id" id="patient_id" class="form-control" required>
                            <option value="">Select Patient</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" {{ old('patient_id', $prescription->patient_id) == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->user->first_name }} {{ $patient->user->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="doctor_id" class="form-label">Doctor</label>
                        <select name="doctor_id" id="doctor_id" class="form-control" required>
                            <option value="">Select Doctor</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}" {{ old('doctor_id', $prescription->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                    {{ $doctor->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div id="medications-section">
                    <label class="form-label">Medications</label>
                    @foreach($prescription->medications as $i => $med)
                    <div class="row mb-2 medication-row">
                        <div class="col-md-5">
                            <input type="text" name="medications[{{ $i }}][name]" class="form-control" placeholder="Medication Name" value="{{ $med->name }}" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="medications[{{ $i }}][dosage]" class="form-control" placeholder="Dosage" value="{{ $med->dosage }}" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="medications[{{ $i }}][instructions]" class="form-control" placeholder="Instructions" value="{{ $med->instructions }}">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger btn-remove-medication" {{ $i == 0 ? 'style=display:none;' : '' }}>&times;</button>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-secondary mb-3" id="add-medication">Add Medication</button>
                <div class="mb-3">
                    <label for="prescription_date" class="form-label">Date</label>
                    <input type="date" name="prescription_date" id="prescription_date" class="form-control" value="{{ old('prescription_date', $prescription->prescription_date->format('Y-m-d')) }}" required>
                </div>
                <div class="mb-3">
                    <label for="instructions" class="form-label">General Instructions</label>
                    <textarea name="instructions" id="instructions" class="form-control" rows="3">{{ old('instructions', $prescription->instructions) }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="active" {{ old('status', $prescription->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="completed" {{ old('status', $prescription->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ old('status', $prescription->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update Prescription</button>
                <a href="{{ route('doctor.prescriptions.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    let medIndex = {{ count($prescription->medications) }};
    document.getElementById('add-medication').addEventListener('click', function() {
        const section = document.getElementById('medications-section');
        const row = document.createElement('div');
        row.className = 'row mb-2 medication-row';
        row.innerHTML = `
            <div class="col-md-5">
                <input type="text" name="medications[${medIndex}][name]" class="form-control" placeholder="Medication Name" required>
            </div>
            <div class="col-md-3">
                <input type="text" name="medications[${medIndex}][dosage]" class="form-control" placeholder="Dosage" required>
            </div>
            <div class="col-md-3">
                <input type="text" name="medications[${medIndex}][instructions]" class="form-control" placeholder="Instructions">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger btn-remove-medication">&times;</button>
            </div>
        `;
        section.appendChild(row);
        medIndex++;
    });
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-remove-medication')) {
            e.target.closest('.medication-row').remove();
        }
    });
</script>
@endpush 