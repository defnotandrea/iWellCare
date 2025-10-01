@extends('layouts.admin')

@section('title', 'Physical Examination - iWellCare')
@section('page-title', 'Physical Examination')
@section('page-subtitle', 'Record physical examination details')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Physical Examination</h1>
        <a href="{{ route('admin.consultations.show', $consultation) }}" class="btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Back to Consultation
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <p class="text-gray-600">Physical examination form for consultation #{{ $consultation->id }}</p>
        <!-- Placeholder content - implement physical examination form here -->
    </div>
</div>
@endsection