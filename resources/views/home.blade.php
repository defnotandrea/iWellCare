@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50">
    <!-- Doctor Availability Notification - Centered Top -->
    <div id="availabilityModal" class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-gradient-to-r from-green-50 to-blue-50 border border-green-200 shadow-lg rounded-lg z-[9999] hidden max-w-sm mx-auto">
        <div class="p-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
                <div class="flex-1 text-center">
                    <h3 class="text-base font-bold text-green-700 mb-1">All Doctors Available</h3>
                    <p class="text-sm text-gray-600 mb-2">Great news! You can book appointments now</p>
                    <span class="inline-block text-sm font-medium text-green-600 bg-white px-3 py-1 rounded-full border border-green-200">
                        1 of 1 doctor available
                    </span>
                </div>
                <button onclick="closeAvailabilityModal()" class="text-gray-400 hover:text-gray-600 transition-colors flex-shrink-0 ml-2">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Registration/Login Choice Modal -->
    <div id="authChoiceModal" class="fixed inset-0 z-[9999] flex items-center justify-center" style="display: none;">
        <div class="absolute inset-0 bg-black bg-opacity-50 backdrop-blur-sm"></div>
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-80 transform transition-all duration-500 ease-out border border-gray-200 opacity-100 scale-100 translate-y-0 relative z-10">
            <div class="p-6">
                <!-- Header -->
                <div class="text-center mb-6">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3 transform transition-all duration-700 ease-out scale-100">
                        <i class="fas fa-user-plus text-blue-600 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2 transform transition-all duration-700 ease-out translate-y-0 opacity-100">Get Started</h3>
                    <p class="text-sm text-gray-600 transform transition-all duration-700 ease-out translate-y-0 opacity-100">Choose how you'd like to proceed</p>
                </div>
                
                <!-- Action Buttons -->
                <div class="space-y-3">
                    <button onclick="goToRegistration()" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-3 px-4 rounded-lg text-base shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 opacity-100 translate-y-0">
                        <i class="fas fa-user-plus mr-2"></i>
                        Create New Account
                    </button>
                    
                    <button onclick="goToLogin()" class="w-full bg-white border-2 border-blue-600 hover:bg-blue-50 text-blue-600 font-bold py-3 px-4 rounded-lg text-base shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 opacity-100 translate-y-0">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Sign In to Existing Account
                    </button>
                </div>
                
                <!-- Close Button -->
                <div class="text-center mt-4">
                    <button onclick="closeAuthChoiceModal()" class="text-gray-400 hover:text-gray-600 transition-colors text-xs transform transition-all duration-300 hover:scale-110 opacity-100">
                        <i class="fas fa-times mr-1"></i>
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Hero Section -->
    <div class="relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-700 opacity-95"></div>
        <div class="absolute inset-0 bg-pattern opacity-5"></div>
        
        <!-- Main Hero Content -->
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Left Side - Text Content -->
                <div class="text-white">
                    <div class="mb-8" data-aos="fade-right">
                        <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-tight">
                            Welcome to 
                            <span class="gradient-text bg-gradient-to-r from-yellow-300 to-orange-300 bg-clip-text text-transparent">
                                iWellCare
                            </span>
                        </h1>
                        <p class="text-xl md:text-2xl mb-8 leading-relaxed text-blue-100">
                            <strong>Your Health, Our Priority - Excellence in Healthcare, Compassion in Care.</strong> Discover comprehensive medical excellence with our advanced diagnostics, personalized treatment plans, and dedicated healthcare professionals. Experience the future of healthcare where cutting-edge technology meets compassionate patient care in our state-of-the-art facilities.
                        </p>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-6" data-aos="fade-up" data-aos-delay="200">
                        <button onclick="handleBookAppointment()"
                           class="group bg-gradient-to-r from-yellow-400 to-orange-400 hover:from-yellow-500 hover:to-orange-500 text-gray-900 font-bold py-4 px-8 rounded-xl text-lg shadow-xl hover:shadow-2xl">
                            <i class="fas fa-calendar-plus mr-2"></i>
                            Book Appointment
                        </button>
                    </div>
                </div>
                
                <!-- Right Side - Health Image -->
                <div class="flex justify-center lg:justify-end" data-aos="fade-left">
                    <img src="{{ asset('assets/img/health.png') }}" alt="Healthcare" class="w-full max-w-md lg:max-w-lg xl:max-w-xl h-auto rounded-2xl shadow-2xl">
                </div>
            </div>
        </div>
    </div>

    <!-- Clinic Hours Section - Positioned prominently after Hero -->
    <div class="py-12 bg-gradient-to-br from-blue-50 to-indigo-50 border-b border-blue-100">
        <div class="text-center mb-8" data-aos="fade-up">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Clinic Hours</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                We're here to serve you with flexible hours to accommodate your busy schedule.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 max-w-6xl mx-auto px-4">
            <!-- Monday - Friday -->
            <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105" data-aos="fade-up">
                <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-calendar-day text-white text-lg"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-3 text-center">Monday - Friday</h3>
                <div class="text-center">
                    <p class="text-2xl font-bold text-blue-600 mb-1">9:00 AM</p>
                    <p class="text-gray-600 text-sm">to</p>
                    <p class="text-2xl font-bold text-blue-600 mb-2">2:00 PM</p>
                    <p class="text-green-600 font-semibold text-sm">Open</p>
                </div>
            </div>
            
            <!-- Saturday -->
            <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105" data-aos="fade-up" data-aos-delay="100">
                <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-calendar-day text-white text-lg"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-3 text-center">Saturday</h3>
                <div class="text-center">
                    <p class="text-2xl font-bold text-green-600 mb-1">9:00 AM</p>
                    <p class="text-gray-600 text-sm">to</p>
                    <p class="text-2xl font-bold text-green-600 mb-2">2:00 PM</p>
                    <p class="text-green-600 font-semibold text-sm">Open</p>
                </div>
            </div>

            <!-- Sunday -->
            <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105" data-aos="fade-up" data-aos-delay="200">
                <div class="w-12 h-12 bg-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-calendar-day text-white text-lg"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-3 text-center">Sunday</h3>
                <div class="text-center">
                    <p class="text-2xl font-bold text-red-600 mb-2">Closed</p>
                    <p class="text-gray-600 text-sm">Emergency Only</p>
                    <p class="text-red-600 font-semibold text-sm">Closed</p>
                </div>
            </div>

            <!-- Emergency Services -->
            <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105" data-aos="fade-up" data-aos-delay="300">
                <div class="w-12 h-12 bg-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-phone-alt text-white text-lg"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-3 text-center">Emergency</h3>
                <div class="text-center">
                    <p class="text-2xl font-bold text-orange-600 mb-2">24/7</p>
                    <p class="text-gray-600 text-sm">Available</p>
                    <p class="text-orange-600 font-semibold text-sm">Call: 09352410173</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Services Section -->
    <div id="services" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl font-bold text-gray-900 mb-6">Our Services</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Comprehensive healthcare services tailored to meet your wellness needs. We provide a wide range of medical services to ensure your health and well-being.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- General Consultation -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-8 shadow-lg hover:shadow-xl" data-aos="fade-up">
                    <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-user-md text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4 text-center">General Consultation</h3>
                    <p class="text-gray-600 text-center mb-6">
                        Comprehensive health assessments and medical consultations with our experienced healthcare professionals.
                    </p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Health assessments
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Medical consultations
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Preventive care
                        </li>
                    </ul>
                </div>
                
                <!-- Laboratory Services -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-8 shadow-lg hover:shadow-xl" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-flask text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4 text-center">Laboratory Services</h3>
                    <p class="text-gray-600 text-center mb-6">
                        State-of-the-art laboratory testing and diagnostic services for accurate health assessments.
                    </p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Blood tests
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Urinalysis
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Diagnostic imaging
                        </li>
                    </ul>
                </div>
                
                <!-- Pharmacy Services -->
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl p-8 shadow-lg hover:shadow-xl" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-16 h-16 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-pills text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4 text-center">Pharmacy Services</h3>
                    <p class="text-gray-600 text-center mb-6">
                        Complete pharmacy services with prescription medications and over-the-counter products for your healthcare needs.
                    </p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Prescription medications
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Over-the-counter products
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Medication consultation
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div id="contact" class="py-20 bg-gradient-to-br from-white to-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl font-bold text-gray-900 mb-6">Contact Us</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Have questions? We're here to help. Get in touch with us today.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Phone -->
                <div class="text-center" data-aos="fade-up">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-phone text-white text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Phone</h3>
                    <p class="text-gray-600">09352410173</p>
                </div>
                
                <!-- Email -->
                <div class="text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-envelope text-white text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Email</h3>
                    <p class="text-gray-600">adultwellnessclinicandmedicall@gmail.com</p>
                </div>
                
                <!-- Address -->
                <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-map-marker-alt text-white text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Address</h3>
                    <p class="text-gray-600">Capitulacion Street, Zone 2, Bangued, Abra</p>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
.bg-pattern {
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

.gradient-text {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.card-hover {
    transition: all 0.3s ease;
}

.card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

/* Enhanced Modal Styling */
#authChoiceModal {
    backdrop-filter: blur(4px);
}

#authChoiceModal .bg-white {
    animation: modalSlideIn 0.5s ease-out;
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: scale(0.95) translateY(1rem);
    }
    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

/* Responsive modal sizing */
@media (max-width: 640px) {
    #authChoiceModal .bg-white {
        width: 90vw;
        max-width: 320px;
        margin: 0 1rem;
    }
}
</style>

<script>
function handleBookAppointment() {
    // Check if user is authenticated
    @auth
        // User is logged in, redirect to booking form
        window.location.href = "{{ route('book.appointment') }}";
    @else
        // User is not logged in, show registration/login modal
        const authChoiceModal = document.getElementById('authChoiceModal');
        if (authChoiceModal) {
            authChoiceModal.style.display = 'flex';
        }
    @endauth
}

function animateModalElements(modal) {
    // Animate header elements
    const icon = modal.querySelector('.w-12.h-12');
    const title = modal.querySelector('h3');
    const subtitle = modal.querySelector('p');
    
    if (icon) setTimeout(() => icon.classList.remove('scale-0'), 100);
    if (title) setTimeout(() => {
        title.classList.remove('opacity-0', 'translate-y-4');
        title.classList.add('opacity-100', 'translate-y-0');
    }, 300);
    if (subtitle) setTimeout(() => {
        subtitle.classList.remove('opacity-0', 'translate-y-4');
        subtitle.classList.add('opacity-100', 'translate-y-0');
    }, 400);
    
    // Animate buttons
    const buttons = modal.querySelectorAll('button:not([onclick*="closeAuthChoiceModal"])');
    buttons.forEach((button, index) => {
        setTimeout(() => {
            button.classList.remove('opacity-0', 'translate-y-4');
            button.classList.add('opacity-100', 'translate-y-0');
        }, 500 + (index * 100));
    });
    
    // Animate close button
    const closeButton = modal.querySelector('button[onclick*="closeAuthChoiceModal"]');
    if (closeButton) setTimeout(() => {
        closeButton.classList.remove('opacity-0');
        closeButton.classList.add('opacity-100');
    }, 800);
}

function checkDoctorAvailability() {
    // Fetch doctor availability from API
    fetch('/api/doctors/available')
        .then(response => response.json())
        .then(data => {
            const modal = document.getElementById('availabilityModal');
            if (modal) {
                const title = modal.querySelector('h3');
                const subtitle = modal.querySelector('p');
                const badge = modal.querySelector('.inline-block');
                const icon = modal.querySelector('.w-8.h-8');
                const iconContainer = modal.querySelector('.w-8.h-8').parentElement;

                if (data.available === data.total && data.total > 0) {
                    // All doctors available
                    title.textContent = 'All Doctors Available';
                    subtitle.textContent = 'Great news! You can book appointments now';
                    badge.textContent = `${data.available} of ${data.total} doctors available`;
                    badge.className = 'inline-block text-xs font-medium text-green-600 bg-white px-2 py-1 rounded-full border border-green-200';
                    iconContainer.className = 'w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0';
                    icon.className = 'fas fa-check-circle text-green-600 text-sm';
                } else if (data.available > 0) {
                    // Some doctors available
                    title.textContent = 'Doctors Available';
                    subtitle.textContent = 'Some doctors are available for appointments';
                    badge.textContent = `${data.available} of ${data.total} doctors available`;
                    badge.className = 'inline-block text-xs font-medium text-blue-600 bg-white px-2 py-1 rounded-full border border-blue-200';
                    iconContainer.className = 'w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0';
                    icon.className = 'fas fa-info-circle text-blue-600 text-sm';
                } else {
                    // No doctors available
                    title.textContent = 'No Doctors Available';
                    subtitle.textContent = 'Please check back later or contact us';
                    badge.textContent = `${data.available} of ${data.total} doctors available`;
                    badge.className = 'inline-block text-xs font-medium text-red-600 bg-white px-2 py-1 rounded-full border border-red-200';
                    iconContainer.className = 'w-8 h-8 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0';
                    icon.className = 'fas fa-exclamation-triangle text-red-600 text-sm';
                }

                modal.classList.remove('hidden');
            }
        })
        .catch(error => {
            console.error('Error fetching doctor availability:', error);
            // Fallback to show modal with default message
            const modal = document.getElementById('availabilityModal');
            if (modal) {
                modal.classList.remove('hidden');
            }
        });
}

function closeAvailabilityModal() {
    const modal = document.getElementById('availabilityModal');
    if (modal) {
        modal.classList.add('hidden');
    }
}

function goToRegistration() {
    window.location.href = "{{ route('register') }}";
}

function goToLogin() {
    window.location.href = "{{ route('login') }}";
}

function closeAuthChoiceModal() {
    const authChoiceModal = document.getElementById('authChoiceModal');
    if (authChoiceModal) {
        // Hide modal by changing display style
        authChoiceModal.style.display = 'none';
    }
}

function resetModalState(modal) {
    // Reset all elements to initial state for next opening
    const icon = modal.querySelector('.w-12.h-12');
    const title = modal.querySelector('h3');
    const subtitle = modal.querySelector('p');
    const buttons = modal.querySelectorAll('button:not([onclick*="closeAuthChoiceModal"])');
    const closeButton = modal.querySelector('button[onclick*="closeAuthChoiceModal"]');
    
    // Reset to initial animation state
    if (icon) icon.classList.add('scale-0');
    if (title) {
        title.classList.add('opacity-0', 'translate-y-4');
        title.classList.remove('opacity-100', 'translate-y-0');
    }
    if (subtitle) {
        subtitle.classList.add('opacity-0', 'translate-y-4');
        subtitle.classList.remove('opacity-100', 'translate-y-0');
    }
    
    buttons.forEach(button => {
        button.classList.add('opacity-0', 'translate-y-4');
        button.classList.remove('opacity-100', 'translate-y-0');
    });
    
    if (closeButton) {
        closeButton.classList.add('opacity-0');
        closeButton.classList.remove('opacity-100');
    }
}

function scrollToServices() {
    const servicesSection = document.getElementById('services'); // Services section
    if (servicesSection) {
        servicesSection.scrollIntoView({ behavior: 'smooth' });
    }
}

// Show the modal automatically on page load
document.addEventListener('DOMContentLoaded', function() {
    // Hide the modal initially
    const modal = document.getElementById('availabilityModal');
    if (modal) {
        modal.classList.add('hidden');
    }

    const authChoiceModal = document.getElementById('authChoiceModal');
    if (authChoiceModal) {
        authChoiceModal.classList.add('hidden');
    }
    
    // Show the availability modal after a short delay for better UX
    setTimeout(() => {
        if (modal) {
            modal.classList.remove('hidden');
        }
        
        // Automatically close the modal after 10 seconds
        setTimeout(() => {
            if (modal) {
                modal.classList.add('hidden');
            }
        }, 10000); // 10 seconds
    }, 1000); // 1 second delay
    
    // Add click outside to close functionality
    document.addEventListener('click', function(event) {
        if (authChoiceModal && !authChoiceModal.classList.contains('hidden')) {
            const modalContent = authChoiceModal.querySelector('.bg-white');
            if (!modalContent.contains(event.target)) {
                closeAuthChoiceModal();
            }
        }
    });
    
    // Add ESC key to close
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            if (authChoiceModal && !authChoiceModal.classList.contains('hidden')) {
                closeAuthChoiceModal();
            }
        }
    });
});
</script>
@endsection 