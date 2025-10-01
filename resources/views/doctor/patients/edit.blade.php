@extends('layouts.admin')

@section('title', 'Edit Patient - iWellCare')

@section('page-title', 'Edit Patient')
@section('page-subtitle', 'Update patient information')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="card">
        <div class="p-6">
            <form method="POST" action="{{ route('doctor.patients.update', $patient) }}" class="space-y-6">
                @csrf
                @method('PUT')
                
                <!-- Personal Information -->
                <div>
                    <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                    <input type="text" id="full_name" name="full_name"
                           value="{{ old('full_name', $patient->full_name) }}"
                           class="form-input w-full @error('full_name') border-red-500 @enderror" required>
                    @error('full_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" id="email" name="email" 
                               value="{{ old('email', $patient->email) }}" 
                               class="form-input w-full @error('email') border-red-500 @enderror" required>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                        <input type="text" id="phone" name="phone" 
                               value="{{ old('phone', $patient->contact) }}" 
                               class="form-input w-full @error('phone') border-red-500 @enderror" required>
                        @error('phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                        <input type="date" id="date_of_birth" name="date_of_birth" 
                               value="{{ old('date_of_birth', $patient->date_of_birth ? $patient->date_of_birth->format('Y-m-d') : '') }}" 
                               class="form-input w-full @error('date_of_birth') border-red-500 @enderror" required>
                        @error('date_of_birth')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                        <select id="gender" name="gender" class="form-input w-full @error('gender') border-red-500 @enderror" required>
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender', $patient->gender) === 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', $patient->gender) === 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender', $patient->gender) === 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                    <textarea id="address" name="address" rows="3" 
                              class="form-input w-full @error('address') border-red-500 @enderror" required>{{ old('address', $patient->address) }}</textarea>
                    @error('address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('doctor.patients.index') }}" class="btn-secondary">
                        <i class="fas fa-arrow-left mr-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save mr-2"></i>Update Patient
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 