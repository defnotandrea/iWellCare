@extends('layouts.app')

@section('title', 'Patient Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center">
                    <h1 class="h3 mb-0 me-3">{{ $patient->full_name }}</h1>
                </div>
                <a href="{{ route('doctor.patients.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Patients
                </a>
            </div>

            <!-- Patient Information -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Personal Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Full Name:</strong></div>
                                <div class="col-sm-8">{{ $patient->full_name }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Contact:</strong></div>
                                <div class="col-sm-8">{{ $patient->contact ?? 'Not provided' }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Email:</strong></div>
                                <div class="col-sm-8">{{ $patient->email ?? 'Not provided' }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Address:</strong></div>
                                <div class="col-sm-8">{{ $patient->address ?? 'Not provided' }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Date of Birth:</strong></div>
                                <div class="col-sm-8">{{ $patient->date_of_birth ? $patient->date_of_birth->format('M d, Y') : 'Not provided' }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Age:</strong></div>
                                <div class="col-sm-8">{{ $patient->age ?? 'Not provided' }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Gender:</strong></div>
                                <div class="col-sm-8">{{ ucfirst($patient->gender ?? 'Not provided') }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Blood Type:</strong></div>
                                <div class="col-sm-8">{{ $patient->blood_type ?? 'Not provided' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Medical Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Emergency Contact:</strong></div>
                                <div class="col-sm-8">{{ $patient->emergency_contact ?? 'Not provided' }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Emergency Phone:</strong></div>
                                <div class="col-sm-8">{{ $patient->emergency_contact_phone ?? 'Not provided' }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Insurance:</strong></div>
                                <div class="col-sm-8">{{ $patient->insurance_provider ?? 'Not provided' }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Insurance #:</strong></div>
                                <div class="col-sm-8">{{ $patient->insurance_number ?? 'Not provided' }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Allergies:</strong></div>
                                <div class="col-sm-8">{{ $patient->allergies ?? 'None known' }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Current Medications:</strong></div>
                                <div class="col-sm-8">{{ $patient->current_medications ?? 'None' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Consultations -->
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Consultations</h5>
                </div>
                <div class="card-body">
                    @if($patient->consultations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Chief Complaint</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($patient->consultations->take(5) as $consultation)
                                    <tr>
                                        <td>{{ $consultation->consultation_date->format('M d, Y') }}</td>
                                        <td>{{ Str::limit($consultation->chief_complaint, 50) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $consultation->status === 'completed' ? 'success' : 'warning' }}">
                                                {{ ucfirst($consultation->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-muted">View by Staff</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No consultations found for this patient.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 