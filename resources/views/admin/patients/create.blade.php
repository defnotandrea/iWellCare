@extends('layouts.admin')

@section('title', 'Create Patient - iWellCare')
@section('page-title', 'Create New Patient')
@section('page-subtitle', 'Add a new patient to the system')

@section('content')
<div class="patients-content">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Create New Patient</h2>
            <p class="text-gray-600">Add a new patient with complete information</p>
        </div>
        <a href="{{ route('admin.patients.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Back to Patients
        </a>
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

        <form action="{{ route('admin.patients.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Basic Information</h3>
                </div>
                
                <div class="md:col-span-2">
                    <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                    <input type="text" name="full_name" id="full_name"
                           value="{{ old('full_name') }}"
                           class="form-input w-full" required placeholder="Enter full name">
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                    <input type="email" name="email" id="email" 
                           value="{{ old('email') }}" 
                           class="form-input w-full" required>
                </div>
                
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username *</label>
                    <input type="text" name="username" id="username" 
                           value="{{ old('username') }}" 
                           class="form-input w-full" required>
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password *</label>
                    <input type="password" name="password" id="password" 
                           class="form-input w-full" required minlength="8">
                </div>
                
                <div>
                    <label for="contact" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                    <input type="text" name="contact" id="contact" 
                           value="{{ old('contact') }}" 
                           class="form-input w-full" placeholder="+63 912 345 6789">
                </div>
                
                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                    <input type="date" name="date_of_birth" id="date_of_birth" 
                           value="{{ old('date_of_birth') }}" 
                           class="form-input w-full">
                </div>
                
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                    <select name="gender" id="gender" class="form-input w-full">
                        <option value="">Select Gender</option>
                        <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('gender') === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                
                <div>
                    <label for="blood_type" class="block text-sm font-medium text-gray-700 mb-2">Blood Type</label>
                    <select name="blood_type" id="blood_type" class="form-input w-full">
                        <option value="">Select Blood Type</option>
                        <option value="A+" {{ old('blood_type') === 'A+' ? 'selected' : '' }}>A+</option>
                        <option value="A-" {{ old('blood_type') === 'A-' ? 'selected' : '' }}>A-</option>
                        <option value="B+" {{ old('blood_type') === 'B+' ? 'selected' : '' }}>B+</option>
                        <option value="B-" {{ old('blood_type') === 'B-' ? 'selected' : '' }}>B-</option>
                        <option value="AB+" {{ old('blood_type') === 'AB+' ? 'selected' : '' }}>AB+</option>
                        <option value="AB-" {{ old('blood_type') === 'AB-' ? 'selected' : '' }}>AB-</option>
                        <option value="O+" {{ old('blood_type') === 'O+' ? 'selected' : '' }}>O+</option>
                        <option value="O-" {{ old('blood_type') === 'O-' ? 'selected' : '' }}>O-</option>
                    </select>
                </div>
                
                <!-- Address Information -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 mt-6">Address Information</h3>
                </div>
                
                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                    <textarea name="address" id="address" rows="3" 
                              class="form-input w-full" 
                              placeholder="Enter complete address...">{{ old('address') }}</textarea>
                </div>
                
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700 mb-2">City</label>
                    <input type="text" name="city" id="city" 
                           value="{{ old('city') }}" 
                           class="form-input w-full" placeholder="e.g., Manila">
                </div>
                
                <div>
                    <label for="state" class="block text-sm font-medium text-gray-700 mb-2">State/Province</label>
                    <input type="text" name="state" id="state" 
                           value="{{ old('state') }}" 
                           class="form-input w-full" placeholder="e.g., Metro Manila">
                </div>
                
                <div>
                    <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">Postal Code</label>
                    <input type="text" name="postal_code" id="postal_code" 
                           value="{{ old('postal_code') }}" 
                           class="form-input w-full" placeholder="e.g., 1000">
                </div>
                
                <div>
                    <label for="country" class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                    <input type="text" name="country" id="country" 
                           value="{{ old('country', 'Philippines') }}" 
                           class="form-input w-full">
                </div>
                
                <!-- Medical Information -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 mt-6">Medical Information</h3>
                </div>
                
                <div class="md:col-span-2">
                    <label for="allergies" class="block text-sm font-medium text-gray-700 mb-2">Allergies</label>
                    <textarea name="allergies" id="allergies" rows="3" 
                              class="form-input w-full" 
                              placeholder="List any known allergies...">{{ old('allergies') }}</textarea>
                </div>
                
                <div class="md:col-span-2">
                    <label for="medical_history" class="block text-sm font-medium text-gray-700 mb-2">Medical History</label>
                    <textarea name="medical_history" id="medical_history" rows="4" 
                              class="form-input w-full" 
                              placeholder="Relevant medical history, surgeries, chronic conditions...">{{ old('medical_history') }}</textarea>
                </div>
                
                <div class="md:col-span-2">
                    <label for="current_medications" class="block text-sm font-medium text-gray-700 mb-2">Current Medications</label>
                    <textarea name="current_medications" id="current_medications" rows="3" 
                              class="form-input w-full" 
                              placeholder="List current medications and dosages...">{{ old('current_medications') }}</textarea>
                </div>
                
                <div class="md:col-span-2">
                    <label for="family_history" class="block text-sm font-medium text-gray-700 mb-2">Family History</label>
                    <textarea name="family_history" id="family_history" rows="3" 
                              class="form-input w-full" 
                              placeholder="Relevant family medical history...">{{ old('family_history') }}</textarea>
                </div>
                
                <div>
                    <label for="emergency_contact" class="block text-sm font-medium text-gray-700 mb-2">Emergency Contact</label>
                    <input type="text" name="emergency_contact" id="emergency_contact" 
                           value="{{ old('emergency_contact') }}" 
                           class="form-input w-full" placeholder="+63 923 456 7890">
                </div>
                
                <div>
                    <label for="emergency_contact_name" class="block text-sm font-medium text-gray-700 mb-2">Emergency Contact Name</label>
                    <input type="text" name="emergency_contact_name" id="emergency_contact_name" 
                           value="{{ old('emergency_contact_name') }}" 
                           class="form-input w-full" placeholder="e.g., Spouse, Parent">
                </div>
            </div>
            
            <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.patients.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times mr-2"></i>Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>Create Patient
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
