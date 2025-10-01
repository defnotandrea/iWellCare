@extends('layouts.admin')

@section('title', 'Staff Member Details')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Staff Member Details</h1>
        <a href="{{ route('doctor.staff.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Back to Staff
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-semibold text-gray-800">Staff Information</h2>
                        <div class="flex items-center space-x-2">
                            @if($staff->is_active)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-1"></i>Inactive
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                                    <dd class="text-sm text-gray-900">{{ $staff->full_name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Username</dt>
                                    <dd class="text-sm text-gray-900">{{ $staff->username }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                                    <dd class="text-sm text-gray-900">{{ $staff->email ?: 'Not provided' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Phone Number</dt>
                                    <dd class="text-sm text-gray-900">{{ $staff->phone_number ?: 'Not provided' }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Account Information</h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Role</dt>
                                    <dd class="text-sm text-gray-900">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ ucfirst($staff->role) }}
                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Account Status</dt>
                                    <dd class="text-sm text-gray-900">
                                        @if($staff->is_active)
                                            <span class="text-green-600">Active</span>
                                        @else
                                            <span class="text-red-600">Inactive</span>
                                        @endif
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Member Since</dt>
                                    <dd class="text-sm text-gray-900">{{ $staff->created_at->format('M d, Y') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                    <dd class="text-sm text-gray-900">{{ $staff->updated_at->format('M d, Y g:i A') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    @if($staff->street_address || $staff->city || $staff->state_province || $staff->postal_code || $staff->country)
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Address Information</h3>
                            <dl class="space-y-3">
                                @if($staff->street_address)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Street Address</dt>
                                        <dd class="text-sm text-gray-900">{{ $staff->street_address }}</dd>
                                    </div>
                                @endif
                                
                                @if($staff->city || $staff->state_province || $staff->postal_code || $staff->country)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Location</dt>
                                        <dd class="text-sm text-gray-900">
                                            {{ collect([$staff->city, $staff->state_province, $staff->postal_code, $staff->country])->filter()->join(', ') ?: 'Not provided' }}
                                        </dd>
                                    </div>
                                @endif
                            </dl>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Actions</h3>
                    <div class="space-y-3">
                        <a href="{{ route('doctor.staff.edit', $staff) }}" class="btn-secondary w-full">
                            <i class="fas fa-edit mr-2"></i>Edit Staff Member
                        </a>

                        @if($staff->id !== auth()->id())
                            <form method="POST" action="{{ route('doctor.staff.destroy', $staff) }}" 
                                  class="inline w-full" 
                                  onsubmit="return confirm('Are you sure you want to delete this staff member? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger w-full">
                                    <i class="fas fa-trash mr-2"></i>Delete Staff Member
                                </button>
                            </form>
                        @else
                            <button disabled class="btn-secondary w-full opacity-50 cursor-not-allowed">
                                <i class="fas fa-trash mr-2"></i>Cannot Delete Own Account
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-white rounded-lg shadow-md mt-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Info</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Account Type</span>
                            <span class="text-sm font-medium text-gray-900">Staff Member</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Login Enabled</span>
                            <span class="text-sm font-medium {{ $staff->is_active ? 'text-green-600' : 'text-red-600' }}">
                                {{ $staff->is_active ? 'Yes' : 'No' }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Days Active</span>
                            <span class="text-sm font-medium text-gray-900">{{ $staff->created_at->diffInDays(now()) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 