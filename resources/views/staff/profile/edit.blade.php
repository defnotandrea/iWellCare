@extends('layouts.staff')
@section('title', 'Edit Profile - iWellCare')
@section('page-title', 'Edit Profile')
@section('page-subtitle', 'Update your staff information')
@section('content')
<div class="profile-content">
    <div class="card p-6 max-w-xl mx-auto">
        @if($errors->any())
            <div class="bg-red-100 text-red-800 p-2 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('staff.profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">First Name</label>
                <input type="text" name="first_name" class="form-input w-full" value="{{ old('first_name', $user->first_name) }}" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Last Name</label>
                <input type="text" name="last_name" class="form-input w-full" value="{{ old('last_name', $user->last_name) }}" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Email</label>
                <input type="email" name="email" class="form-input w-full" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Username</label>
                <input type="text" name="username" class="form-input w-full" value="{{ old('username', $user->username) }}" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Password</label>
                <input type="password" name="password" class="form-input w-full" placeholder="Leave blank to keep current password">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('staff.profile.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection 