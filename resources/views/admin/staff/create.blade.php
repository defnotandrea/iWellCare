@extends('layouts.admin')

@section('title', 'Create New Staff Member')

@section('page-title', 'Create New Staff Member')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Add New Staff Member</h1>
        <a href="{{ route('admin.staff.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Back to Staff
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6">
            <form method="POST" action="{{ route('admin.staff.store') }}" class="space-y-6">
                @csrf

                <!-- Personal Information -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                            <input type="text" id="first_name" name="first_name"
                                   value="{{ old('first_name') }}"
                                   class="form-input w-full @error('first_name') border-red-500 @enderror" required>
                            @error('first_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                            <input type="text" id="last_name" name="last_name"
                                   value="{{ old('last_name') }}"
                                   class="form-input w-full @error('last_name') border-red-500 @enderror" required>
                            @error('last_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Account Information -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Account Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                            <input type="text" id="username" name="username"
                                   value="{{ old('username') }}"
                                   class="form-input w-full @error('username') border-red-500 @enderror" required>
                            @error('username')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" id="email" name="email"
                                   value="{{ old('email') }}"
                                   class="form-input w-full @error('email') border-red-500 @enderror" required>
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                            <input type="password" id="password" name="password"
                                   class="form-input w-full @error('password') border-red-500 @enderror" required>
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   class="form-input w-full" required>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Contact Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                            <input type="text" id="phone_number" name="phone_number"
                                   value="{{ old('phone_number') }}"
                                   class="form-input w-full @error('phone_number') border-red-500 @enderror" required>
                            @error('phone_number')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Address Information -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Address Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="street_address" class="block text-sm font-medium text-gray-700 mb-2">Street Address</label>
                            <input type="text" id="street_address" name="street_address"
                                   value="{{ old('street_address') }}"
                                   class="form-input w-full @error('street_address') border-red-500 @enderror" required>
                            @error('street_address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-2">City</label>
                            <input type="text" id="city" name="city"
                                   value="{{ old('city') }}"
                                   class="form-input w-full @error('city') border-red-500 @enderror" required>
                            @error('city')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="state_province" class="block text-sm font-medium text-gray-700 mb-2">State/Province</label>
                            <input type="text" id="state_province" name="state_province"
                                   value="{{ old('state_province') }}"
                                   class="form-input w-full @error('state_province') border-red-500 @enderror" required>
                            @error('state_province')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">Postal Code</label>
                            <input type="text" id="postal_code" name="postal_code"
                                   value="{{ old('postal_code') }}"
                                   class="form-input w-full @error('postal_code') border-red-500 @enderror" required>
                            @error('postal_code')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Account Status -->
                <div class="pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Account Status</h3>
                    <div class="flex items-center">
                        <input type="checkbox" id="is_active" name="is_active" value="1"
                               {{ old('is_active', true) ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-900">
                            Active Account
                        </label>
                    </div>
                    <p class="text-sm text-gray-500 mt-1">Inactive accounts cannot log in to the system.</p>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.staff.index') }}" class="btn-secondary">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save mr-2"></i>Create Staff Member
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
