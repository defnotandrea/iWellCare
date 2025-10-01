@extends('layouts.admin')

@section('title', 'Diagnosis - iWellCare')
@section('page-title', 'Diagnosis')
@section('page-subtitle', 'Record diagnosis and treatment plan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Diagnosis</h1>
        <a href="{{ route('admin.consultations.show', $consultation) }}" class="btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Back to Consultation
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <p class="text-gray-600">Diagnosis form for consultation #{{ $consultation->id }}</p>
        <!-- Placeholder content - implement diagnosis form here -->
    </div>
</div>
@endsection