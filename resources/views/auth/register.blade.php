@extends('layouts.app')

@section('title', 'Register')

@section('content')
<style>
    footer { display: none !important; }

    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        margin: 0;
        padding: 0;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .register-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }

    @media (min-width: 768px) {
        .register-wrapper {
            min-height: auto;
            padding: 2rem 1rem;
            align-items: flex-start;
            padding-top: 4rem;
        }
    }

    .register-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        width: 100%;
        max-width: 500px;
    }

    .register-header {
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .register-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    .register-subtitle {
        color: #6b7280;
        font-size: 0.875rem;
    }

    .section-divider {
        border-top: 1px solid #e5e7eb;
        margin: 1.5rem 0;
        position: relative;
        text-align: center;
    }

    .section-title {
        background: white;
        padding: 0 1rem;
        font-size: 0.875rem;
        font-weight: 600;
        color: #6b7280;
        position: relative;
        top: -0.75rem;
        display: inline-block;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    @media (min-width: 480px) {
        .form-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: #374151;
        margin-bottom: 0.5rem;
    }

    .form-input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 0.875rem;
        transition: all 0.2s ease;
        background: white;
        box-sizing: border-box;
    }

    .form-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-input::placeholder {
        color: #9ca3af;
    }

    .form-select {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 0.875rem;
        background: white;
        transition: all 0.2s ease;
    }

    .form-select:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .password-input {
        position: relative;
    }

    .password-toggle {
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #9ca3af;
        cursor: pointer;
        padding: 0.25rem;
        border-radius: 4px;
        transition: color 0.2s ease;
    }

    .password-toggle:hover {
        color: #6b7280;
    }

    .form-input.password {
        padding-right: 3rem;
    }

    .checkbox-container {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        margin: 1rem 0;
    }

    .checkbox-input {
        width: 1rem;
        height: 1rem;
        accent-color: #3b82f6;
        margin-top: 0.125rem;
    }

    .checkbox-label {
        font-size: 0.875rem;
        color: #6b7280;
        line-height: 1.4;
    }

    .checkbox-label a {
        color: #3b82f6;
        text-decoration: none;
        font-weight: 500;
    }

    .checkbox-label a:hover {
        text-decoration: underline;
    }

    .btn-submit {
        width: 100%;
        background: #3b82f6;
        color: white;
        border: none;
        padding: 0.875rem 1rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-submit:hover {
        background: #2563eb;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    }

    .links-section {
        text-align: center;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e5e7eb;
    }

    .link-text {
        font-size: 0.875rem;
        color: #6b7280;
    }

    .link-text a {
        color: #3b82f6;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s ease;
    }

    .link-text a:hover {
        color: #1d4ed8;
    }

    .error-text {
        color: #dc2626;
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }

    @media (max-width: 640px) {
        .register-card {
            padding: 1rem;
            margin: 0.5rem;
        }

        .register-title {
            font-size: 1.25rem;
        }

        .form-grid {
            gap: 0.75rem;
        }

        .form-input,
        .form-select {
            padding: 0.625rem;
            font-size: 16px; /* Prevents zoom on iOS */
        }
    }

    @media (max-width: 480px) {
        .register-wrapper {
            padding: 0.5rem;
        }

        .register-card {
            padding: 1rem;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="register-wrapper">
    <div class="register-card">
        <div class="register-header">
            <h1 class="register-title">Create Account</h1>
            <p class="register-subtitle">Join our healthcare community</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Basic Information -->
            <div>
                <div class="section-divider">
                    <span class="section-title">Basic Information</span>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="first_name" class="form-label">First Name *</label>
                        <input type="text" class="form-input @error('first_name') border-red-500 @enderror"
                               id="first_name" name="first_name" value="{{ old('first_name') }}" placeholder="First name" required>
                        @error('first_name')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="last_name" class="form-label">Last Name *</label>
                        <input type="text" class="form-input @error('last_name') border-red-500 @enderror"
                               id="last_name" name="last_name" value="{{ old('last_name') }}" placeholder="Last name" required>
                        @error('last_name')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="username" class="form-label">Username *</label>
                        <input type="text" class="form-input @error('username') border-red-500 @enderror"
                               id="username" name="username" value="{{ old('username') }}" placeholder="Choose username" required>
                        @error('username')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" class="form-input @error('email') border-red-500 @enderror"
                               id="email" name="email" value="{{ old('email') }}" placeholder="Email address" required>
                        @error('email')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone_number" class="form-label">Phone Number *</label>
                        <input type="text" class="form-input @error('phone_number') border-red-500 @enderror"
                               id="phone_number" name="phone_number" value="{{ old('phone_number') }}" placeholder="Phone number" required>
                        @error('phone_number')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="date_of_birth" class="form-label">Date of Birth *</label>
                        <input type="date" class="form-input @error('date_of_birth') border-red-500 @enderror"
                               id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" max="{{ date('Y-m-d', strtotime('-1 day')) }}" required>
                        @error('date_of_birth')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="gender" class="form-label">Gender *</label>
                        <select class="form-select @error('gender') border-red-500 @enderror"
                                id="gender" name="gender" required>
                            <option value="">Select gender</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="blood_type" class="form-label">Blood Type</label>
                        <select class="form-select @error('blood_type') border-red-500 @enderror"
                                id="blood_type" name="blood_type">
                            <option value="">Select blood type</option>
                            <option value="A+" {{ old('blood_type') == 'A+' ? 'selected' : '' }}>A+</option>
                            <option value="A-" {{ old('blood_type') == 'A-' ? 'selected' : '' }}>A-</option>
                            <option value="B+" {{ old('blood_type') == 'B+' ? 'selected' : '' }}>B+</option>
                            <option value="B-" {{ old('blood_type') == 'B-' ? 'selected' : '' }}>B-</option>
                            <option value="AB+" {{ old('blood_type') == 'AB+' ? 'selected' : '' }}>AB+</option>
                            <option value="AB-" {{ old('blood_type') == 'AB-' ? 'selected' : '' }}>AB-</option>
                            <option value="O+" {{ old('blood_type') == 'O+' ? 'selected' : '' }}>O+</option>
                            <option value="O-" {{ old('blood_type') == 'O-' ? 'selected' : '' }}>O-</option>
                        </select>
                        @error('blood_type')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Address Information -->
            <div>
                <div class="section-divider">
                    <span class="section-title">Address Information</span>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="street_address" class="form-label">Street Address *</label>
                        <input type="text" class="form-input @error('street_address') border-red-500 @enderror"
                               id="street_address" name="street_address" value="{{ old('street_address') }}" placeholder="Street address" required>
                        @error('street_address')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="city" class="form-label">City *</label>
                        <input type="text" class="form-input @error('city') border-red-500 @enderror"
                               id="city" name="city" value="{{ old('city') }}" placeholder="City" required>
                        @error('city')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="state_province" class="form-label">State/Province *</label>
                        <input type="text" class="form-input @error('state_province') border-red-500 @enderror"
                               id="state_province" name="state_province" value="{{ old('state_province') }}" placeholder="State/Province" required>
                        @error('state_province')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="postal_code" class="form-label">Postal Code</label>
                        <input type="text" class="form-input @error('postal_code') border-red-500 @enderror"
                               id="postal_code" name="postal_code" value="{{ old('postal_code') }}" placeholder="Postal code">
                        @error('postal_code')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Security -->
            <div>
                <div class="section-divider">
                    <span class="section-title">Security</span>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="password" class="form-label">Password *</label>
                        <div class="password-input">
                            <input type="password" class="form-input password @error('password') border-red-500 @enderror"
                                   id="password" name="password" placeholder="Create password" required>
                            <button type="button" id="toggle-password" class="password-toggle">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Confirm Password *</label>
                        <div class="password-input">
                            <input type="password" class="form-input password"
                                   id="password_confirmation" name="password_confirmation" placeholder="Confirm password" required>
                            <button type="button" id="toggle-password-confirmation" class="password-toggle">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="checkbox-container">
                    <input class="checkbox-input" type="checkbox" name="terms" id="terms" required>
                    <label class="checkbox-label" for="terms">
                        I agree to the <a href="#" id="terms-link">Terms and Conditions</a>
                    </label>
                </div>

                <!-- Terms Modal -->
                <div id="terms-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
                    <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] overflow-hidden">
                        <div class="flex items-center justify-between p-6 border-b">
                            <h2 class="text-2xl font-bold text-gray-900">Terms and Conditions</h2>
                            <button id="close-terms-modal" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="p-6 overflow-y-auto max-h-[calc(90vh-120px)]">
                            <div class="space-y-6">
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900 mb-3">1. Acceptance of Terms</h3>
                                    <p class="text-gray-700">By accessing and using the iWellCare website and services, you accept and agree to be bound by the terms and provision of this agreement.</p>
                                </div>

                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900 mb-3">2. Description of Service</h3>
                                    <p class="text-gray-700">iWellCare provides healthcare services including medical consultations, laboratory services, pharmacy services, and emergency care.</p>
                                </div>

                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900 mb-3">3. Medical Disclaimer</h3>
                                    <p class="text-gray-700">The information provided on this website is for general informational purposes only and should not be considered as medical advice.</p>
                                </div>

                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900 mb-3">4. User Responsibilities</h3>
                                    <p class="text-gray-700">As a user of our services, you are responsible for providing accurate information, arriving on time for appointments, following medical advice, and respecting clinic policies.</p>
                                </div>

                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900 mb-3">5. Appointment Cancellation Policy</h3>
                                    <p class="text-gray-700">We require at least 24 hours notice for appointment cancellations. Late cancellations or no-shows may result in a cancellation fee.</p>
                                </div>

                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900 mb-3">6. Payment Terms</h3>
                                    <p class="text-gray-700">Payment is due at the time of service unless other arrangements have been made. We accept cash, credit cards, insurance, and other arrangements.</p>
                                </div>

                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900 mb-3">7. Privacy & Confidentiality</h3>
                                    <p class="text-gray-700">We are committed to protecting your privacy and maintaining the confidentiality of your medical information.</p>
                                </div>

                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900 mb-3">8. Limitation of Liability</h3>
                                    <p class="text-gray-700">iWellCare shall not be liable for indirect, incidental, special, consequential, or punitive damages.</p>
                                </div>

                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900 mb-3">9. Changes to Terms</h3>
                                    <p class="text-gray-700">We reserve the right to modify these terms. Continued use constitutes acceptance of changes.</p>
                                </div>

                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900 mb-3">10. Governing Law</h3>
                                    <p class="text-gray-700">These terms are governed by the laws of the Philippines and applicable healthcare regulations.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    Create Account
                </button>
            </div>

            <div class="links-section">
                <p class="link-text">
                    Already have an account? <a href="{{ route('login') }}">Sign in here</a>
                </p>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Password toggle functionality
    const togglePassword = document.getElementById('toggle-password');
    const togglePasswordConfirmation = document.getElementById('toggle-password-confirmation');
    const passwordInput = document.getElementById('password');
    const passwordConfirmationInput = document.getElementById('password_confirmation');

    if (togglePassword) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            const icon = this.querySelector('i');
            icon.className = type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
        });
    }

    if (togglePasswordConfirmation) {
        togglePasswordConfirmation.addEventListener('click', function() {
            const type = passwordConfirmationInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmationInput.setAttribute('type', type);

            const icon = this.querySelector('i');
            icon.className = type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
        });
    }

    // Password confirmation matching
    function checkPasswordMatch() {
        const password = passwordInput.value;
        const confirmation = passwordConfirmationInput.value;
        const matchElement = document.getElementById('password-match');

        if (confirmation && matchElement) {
            matchElement.classList.remove('hidden');
            const indicator = document.getElementById('password-match-indicator');
            const icon = indicator.querySelector('i');
            const text = indicator.querySelector('span');

            if (password === confirmation && password.length > 0) {
                icon.className = 'fas fa-check-circle text-green-500';
                text.className = 'text-green-600';
                text.textContent = 'Passwords match';
            } else {
                icon.className = 'fas fa-times-circle text-red-500';
                text.className = 'text-red-600';
                text.textContent = 'Passwords do not match';
            }
        } else if (matchElement) {
            matchElement.classList.add('hidden');
        }
    }

    if (passwordConfirmationInput) {
        passwordConfirmationInput.addEventListener('input', checkPasswordMatch);
    }
    if (passwordInput) {
        passwordInput.addEventListener('input', checkPasswordMatch);
    }

    // Modal functionality
    const termsLink = document.getElementById('terms-link');
    const termsModal = document.getElementById('terms-modal');
    const closeTermsModal = document.getElementById('close-terms-modal');

    if (termsLink && termsModal) {
        termsLink.addEventListener('click', function(e) {
            e.preventDefault();
            termsModal.classList.remove('hidden');
        });
    }

    if (closeTermsModal && termsModal) {
        closeTermsModal.addEventListener('click', function() {
            termsModal.classList.add('hidden');
        });
    }

    // Close modal when clicking outside
    if (termsModal) {
        termsModal.addEventListener('click', function(e) {
            if (e.target === termsModal) {
                termsModal.classList.add('hidden');
            }
        });
    }

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && termsModal && !termsModal.classList.contains('hidden')) {
            termsModal.classList.add('hidden');
        }
    });
});
</script>
@endpush
@endsection 