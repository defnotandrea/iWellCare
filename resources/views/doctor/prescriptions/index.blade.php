@extends('layouts.admin')

@section('content')
<style>
    .iwc-content-bg {
        background: #f7f9fb;
        min-height: 90vh;
        padding-top: 32px;
        padding-bottom: 32px;
    }
    .iwc-card-center {
        max-width: 1100px;
        margin: 0 auto;
    }
    .iwc-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 2rem 2rem 1rem 2rem;
        border-bottom: 1px solid #f0f0f0;
        background: #fff;
        border-radius: 1.5rem 1.5rem 0 0;
    }
    .iwc-card {
        background: #fff;
        border-radius: 1.5rem;
        box-shadow: 0 4px 24px 0 rgba(30,34,90,0.08);
        margin-bottom: 2rem;
    }
    .iwc-table th, .iwc-table td {
        padding: 1rem 1.25rem;
        vertical-align: middle;
    }
    .iwc-table th {
        background: #f8f9fa;
        font-weight: 600;
        color: #333;
        border-top: none;
    }
    .iwc-empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 3rem 0;
        color: #888;
    }
    .iwc-empty-state i {
        font-size: 2.5rem;
        color: #bdbdbd;
        margin-bottom: 1rem;
    }
</style>
<div class="iwc-content-bg">
    <div class="container iwc-card-center">
        <div class="iwc-card">
            <div class="iwc-card-header">
                <h2 class="mb-0" style="font-weight:700; font-size:1.5rem;">Prescriptions</h2>
                <a href="#" id="openPrescriptionModal" class="btn btn-primary shadow rounded-pill px-4 py-2" style="font-weight: 500; font-size: 1rem;">New Prescription</a>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table iwc-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Patient</th>
                                <th>Doctor</th>
                                <th>Medication(s)</th>
                                <th>Dosage</th>
                                <th>Instructions</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($prescriptions as $prescription)
                            <tr>
                                <td>{{ $prescription->patient->user->first_name }} {{ $prescription->patient->user->last_name }}</td>
                                <td>{{ $prescription->doctor->name ?? '-' }}</td>
                                <td>
                                    @foreach($prescription->medications as $med)
                                        <div>{{ $med->name }}</div>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($prescription->medications as $med)
                                        <div>{{ $med->dosage }}</div>
                                    @endforeach
                                </td>
                                <td>{{ $prescription->instructions }}</td>
                                <td>{{ $prescription->prescription_date->format('Y-m-d') }}</td>
                                <td>
                                    <span class="badge bg-{{ $prescription->status == 'active' ? 'primary' : ($prescription->status == 'completed' ? 'success' : 'secondary') }}">
                                        {{ ucfirst($prescription->status) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('doctor.prescriptions.show', $prescription) }}" class="btn btn-sm btn-outline-info rounded-pill me-1">View</a>
                                    <a href="{{ route('doctor.prescriptions.edit', $prescription) }}" class="btn btn-sm btn-outline-warning rounded-pill me-1">Edit</a>
                                    <form action="{{ route('doctor.prescriptions.destroy', $prescription) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    <div class="iwc-empty-state">
                                        <i class="fas fa-prescription-bottle-alt"></i>
                                        <div class="fw-bold mb-1">No prescriptions found</div>
                                        <div class="text-muted">Prescriptions you create will appear here.</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    {{ $prescriptions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- New Prescription Modal -->
<div id="prescriptionModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-2xl shadow-lg p-0 w-full max-w-xl relative overflow-y-auto" style="max-height:90vh;">
        <button id="closePrescriptionModal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 text-2xl font-bold bg-transparent border-0">&times;</button>
        <div class="p-6">
            <h2 class="text-2xl font-bold mb-6 text-center">New Prescription</h2>
            <form action="{{ route('doctor.prescriptions.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="modal_patient_id" class="form-label">Patient</label>
                    <select name="patient_id" id="modal_patient_id" class="form-control rounded" required>
                        <option value="">Select Patient</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}">{{ $patient->user->first_name }} {{ $patient->user->last_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="modal_doctor_id" class="form-label">Doctor</label>
                    <select name="doctor_id" id="modal_doctor_id" class="form-control rounded" required>
                        <option value="">Select Doctor</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="form-label">Medications</label>
                    <div id="modal-medications-section">
                        <div class="d-flex gap-2 mb-2 medication-row">
                            <input type="text" name="medications[0][name]" class="form-control rounded" placeholder="Medication Name" required>
                            <input type="text" name="medications[0][dosage]" class="form-control rounded" placeholder="Dosage" required>
                            <input type="text" name="medications[0][instructions]" class="form-control rounded" placeholder="Instructions">
                            <button type="button" class="btn btn-danger btn-remove-medication" style="display:none;">&times;</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-light mb-3" id="modal-add-medication">Add Medication</button>
                </div>
                <div class="mb-4">
                    <label for="modal_prescription_date" class="form-label">Date</label>
                    <input type="date" name="prescription_date" id="modal_prescription_date" class="form-control rounded" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="mb-4">
                    <label for="modal_status" class="form-label">Status</label>
                    <select name="status" id="modal_status" class="form-control rounded" required>
                        <option value="active">Active</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="modal_instructions" class="form-label">General Instructions</label>
                    <textarea name="instructions" id="modal_instructions" class="form-control rounded" rows="3"></textarea>
                </div>
                <div class="d-flex gap-3 justify-content-center mt-4">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 py-2">Save Prescription</button>
                    <button type="button" id="cancelPrescriptionModal" class="btn btn-secondary rounded-pill px-4 py-2">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
<script>
    // Modal open/close logic
    const modal = document.getElementById('prescriptionModal');
    document.getElementById('openPrescriptionModal').onclick = function(e) {
        e.preventDefault();
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    };
    document.getElementById('closePrescriptionModal').onclick = function() {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    };
    document.getElementById('cancelPrescriptionModal').onclick = function() {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    };
    // Add medication logic for modal
    let medIndex = 1;
    document.getElementById('modal-add-medication').addEventListener('click', function() {
        const section = document.getElementById('modal-medications-section');
        const row = document.createElement('div');
        row.className = 'd-flex gap-2 mb-2 medication-row';
        row.innerHTML = `
            <input type="text" name="medications[${medIndex}][name]" class="form-control rounded" placeholder="Medication Name" required>
            <input type="text" name="medications[${medIndex}][dosage]" class="form-control rounded" placeholder="Dosage" required>
            <input type="text" name="medications[${medIndex}][instructions]" class="form-control rounded" placeholder="Instructions">
            <button type="button" class="btn btn-danger btn-remove-medication">&times;</button>
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
@endsection 