@extends('layouts.patient')

@section('title', 'My Profile - iWellCare')
@section('page-title', 'My Profile')
@section('page-subtitle', 'Manage your personal information and account settings')

@section('content')
<div class="space-y-6">
    <!-- Profile Header -->
    <div class="card">
        <div class="p-6">
            <div class="flex items-center gap-6">
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-blue-600 text-2xl"></i>
                </div>
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-gray-900">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h2>
                    <p class="text-gray-600">{{ auth()->user()->email }}</p>
                    <p class="text-sm text-gray-500">Patient • Member since {{ \Carbon\Carbon::parse(auth()->user()->created_at)->format('M Y') }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('patient.profile.edit') }}" class="btn-primary">
                        <i class="fas fa-edit mr-2"></i>Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Personal Information -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="card">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-xl font-bold text-gray-900">Personal Information</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-600">First Name</label>
                        <p class="text-gray-900 font-medium">{{ auth()->user()->first_name }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600">Last Name</label>
                        <p class="text-gray-900 font-medium">{{ auth()->user()->last_name }}</p>
                    </div>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-600">Username</label>
                    <p class="text-gray-900 font-medium">{{ auth()->user()->username }}</p>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-600">Email</label>
                    <p class="text-gray-900 font-medium">{{ auth()->user()->email }}</p>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-600">Phone Number</label>
                    <p class="text-gray-900 font-medium">{{ auth()->user()->phone_number }}</p>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-600">Date of Birth</label>
                        <p class="text-gray-900 font-medium">{{ auth()->user()->date_of_birth ? \Carbon\Carbon::parse(auth()->user()->date_of_birth)->format('M d, Y') : 'Not provided' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600">Gender</label>
                        <p class="text-gray-900 font-medium capitalize">{{ auth()->user()->gender ?? 'Not specified' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-xl font-bold text-gray-900">Address Information</h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="text-sm font-medium text-gray-600">Street Address</label>
                    <p class="text-gray-900 font-medium">{{ auth()->user()->street_address }}</p>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-600">City</label>
                        <p class="text-gray-900 font-medium">{{ auth()->user()->city }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600">State/Province</label>
                        <p class="text-gray-900 font-medium">{{ auth()->user()->state_province }}</p>
                    </div>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-600">Postal Code</label>
                    <p class="text-gray-900 font-medium">{{ auth()->user()->postal_code ?? 'Not provided' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Account Actions -->
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-xl font-bold text-gray-900">Account Actions</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('patient.profile.edit') }}" class="group p-4 border border-gray-200 rounded-lg hover:border-blue-300 hover:bg-blue-50 transition-all duration-200">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                            <i class="fas fa-edit text-blue-600 text-lg"></i>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-800 group-hover:text-blue-700">Edit Profile</div>
                            <div class="text-sm text-gray-500">Update your personal information</div>
                        </div>
                    </div>
                </a>
                
                <a href="{{ route('patient.profile.edit') }}" class="group p-4 border border-gray-200 rounded-lg hover:border-yellow-300 hover:bg-yellow-50 transition-all duration-200">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center group-hover:bg-yellow-200 transition-colors">
                            <i class="fas fa-key text-yellow-600 text-lg"></i>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-800 group-hover:text-yellow-700">Change Password</div>
                            <div class="text-sm text-gray-500">Update your account password</div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Danger Zone -->
    <div class="card border-red-200">
        <div class="px-6 py-4 border-b border-red-200 bg-red-50">
            <h3 class="text-xl font-bold text-red-900">Danger Zone</h3>
        </div>
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="font-semibold text-red-900">Delete Account</h4>
                    <p class="text-red-700 text-sm">Permanently delete your account and all associated data</p>
                </div>
                <button onclick="showDeleteModal()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                    <i class="fas fa-trash mr-2"></i>Delete Account
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all">
        <div class="px-8 py-8">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mr-4 shadow-lg">
                        <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">Delete Account</h3>
                        <p class="text-gray-600 text-sm mt-1">This action cannot be undone</p>
                    </div>
                </div>
                <button onclick="closeDeleteModal()" class="text-gray-400 hover:text-gray-600 transition-colors p-2 rounded-full hover:bg-gray-100">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <!-- Content -->
            <div class="mb-6">
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-info-circle text-red-600 mr-3"></i>
                        <div>
                            <p class="font-semibold text-red-800">What will be deleted:</p>
                            <ul class="text-sm text-red-700 mt-2 space-y-1">
                                <li>• Your personal information</li>
                                <li>• All appointment history</li>
                                <li>• Medical records and prescriptions</li>
                                <li>• Account settings and preferences</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-yellow-600 mr-3"></i>
                        <div>
                            <p class="font-semibold text-yellow-800">Important Notice</p>
                            <p class="text-sm text-yellow-700">This action is permanent and irreversible. All your data will be permanently deleted from our system.</p>
                        </div>
                    </div>
                </div>
            </div>
            
                         <!-- Password Confirmation -->
             <div class="mb-6">
                 <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                     <div class="flex items-center">
                         <i class="fas fa-lock text-gray-600 mr-3"></i>
                         <div class="flex-1">
                             <p class="font-semibold text-gray-800 mb-2">Confirm Your Password</p>
                             <p class="text-sm text-gray-600 mb-3">Please enter your password to confirm account deletion</p>
                             <input type="password" id="deletePassword" name="password" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                    placeholder="Enter your password" required>
                             @error('password')
                                 <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                             @enderror
                             @error('error')
                                 <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                             @enderror
                         </div>
                     </div>
                 </div>
             </div>
             
             <!-- Action Buttons -->
             <div class="flex flex-col sm:flex-row gap-3">
                 <form action="{{ route('patient.profile.destroy') }}" method="POST" class="flex-1">
                     @csrf
                     @method('DELETE')
                     <input type="hidden" name="password" id="formPassword">
                     <button type="submit" onclick="return validatePassword()" class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                         <i class="fas fa-trash mr-2"></i>
                         Yes, Delete My Account
                     </button>
                 </form>
                 <button onclick="closeDeleteModal()" class="flex-1 inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                     <i class="fas fa-times mr-2"></i>
                     No, Keep My Account
                 </button>
             </div>
        </div>
    </div>
</div>

<script>
function showDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.classList.remove('hidden');
    
    // Add animation
    modal.querySelector('.bg-white').style.transform = 'scale(0.9)';
    setTimeout(() => {
        modal.querySelector('.bg-white').style.transform = 'scale(1)';
    }, 10);
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.querySelector('.bg-white').style.transform = 'scale(0.9)';
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 200);
}

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDeleteModal();
    }
});

function validatePassword() {
    const password = document.getElementById('deletePassword').value;
    const formPassword = document.getElementById('formPassword');
    
    if (!password) {
        alert('Please enter your password to confirm account deletion.');
        return false;
    }
    
    // Set the password in the hidden form field
    formPassword.value = password;
    return true;
}
</script>
</div>
@endsection 