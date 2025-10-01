@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Prescription Details</h2>
        <a href="{{ route('doctor.prescriptions.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Patient:</strong> {{ $prescription->patient->user->first_name }} {{ $prescription->patient->user->last_name }}
                </div>
                <div class="col-md-6">
                    <strong>Doctor:</strong> {{ $prescription->doctor->name ?? '-' }}
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Date:</strong> {{ $prescription->prescription_date->format('Y-m-d') }}
                </div>
                <div class="col-md-6">
                    <strong>Status:</strong> {{ ucfirst($prescription->status) }}
                </div>
            </div>
            <div class="mb-3">
                <strong>General Instructions:</strong>
                <div>{{ $prescription->instructions }}</div>
            </div>
            <div class="mb-3">
                <strong>Medications:</strong>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Dosage</th>
                            <th>Instructions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prescription->medications as $med)
                        <tr>
                            <td>{{ $med->name }}</td>
                            <td>{{ $med->dosage }}</td>
                            <td>{{ $med->instructions }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 