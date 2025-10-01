@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-pink-50 py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header with enhanced design -->
        <div class="text-center mb-16">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-purple-100 rounded-full mb-6">
                <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h1 class="text-5xl font-bold text-gray-900 mb-4 bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                Contact Us
            </h1>
            <p class="text-xl text-gray-600">We're here to help and answer any questions you might have</p>
            <div class="w-24 h-1 bg-gradient-to-r from-purple-500 to-pink-500 mx-auto mt-6 rounded-full"></div>
        </div>

        <div class="grid lg:grid-cols-2 gap-12">
            <!-- Contact Information -->
            <div class="bg-white rounded-3xl shadow-2xl p-8 border border-gray-100">
                <h2 class="text-3xl font-bold text-gray-900 mb-8">Get in Touch</h2>
                
                <!-- Contact Cards -->
                <div class="space-y-6">
                    <!-- Phone -->
                    <div class="flex items-start space-x-4 p-6 bg-gradient-to-r from-blue-50 to-blue-100 rounded-2xl border border-blue-200">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Phone</h3>
                            <p class="text-blue-600 font-medium text-lg">09352410173</p>
                            <p class="text-gray-600 text-sm mt-1">Available 24/7 for emergencies</p>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="flex items-start space-x-4 p-6 bg-gradient-to-r from-green-50 to-green-100 rounded-2xl border border-green-200">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Email</h3>
                            <p class="text-green-600 font-medium break-all text-sm leading-relaxed">
                                adultwellnessclinicandm@gmail.com
                            </p>
                            <p class="text-gray-600 text-sm mt-1">We'll respond within 24 hours</p>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="flex items-start space-x-4 p-6 bg-gradient-to-r from-purple-50 to-purple-100 rounded-2xl border border-purple-200">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Address</h3>
                            <p class="text-purple-600 font-medium text-sm leading-relaxed">
                                Capitulacion Street, Zone 2<br>
                                Bangued, Abra
                            </p>
                            <p class="text-gray-600 text-sm mt-1">Easy to find location in the city center</p>
                        </div>
                    </div>

                    <!-- Business Hours -->
                    <div class="flex items-start space-x-4 p-6 bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-2xl border border-yellow-200">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-yellow-500 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Business Hours</h3>
                            <div class="text-yellow-600 font-medium text-sm space-y-1">
                                <p>Monday - Friday: 8:00 AM - 6:00 PM</p>
                                <p>Saturday: 8:00 AM - 4:00 PM</p>
                                <p>Sunday: Emergency services only</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="bg-white rounded-3xl shadow-2xl p-8 border border-gray-100">
                <h2 class="text-3xl font-bold text-gray-900 mb-8">Send us a Message</h2>
                
                <form class="space-y-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="firstName" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                            <input type="text" id="firstName" name="firstName" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" placeholder="Your first name">
                        </div>
                        <div>
                            <label for="lastName" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                            <input type="text" id="lastName" name="lastName" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" placeholder="Your last name">
                        </div>
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <input type="email" id="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" placeholder="your.email@example.com">
                    </div>
                    
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                        <input type="tel" id="phone" name="phone" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" placeholder="Your phone number">
                    </div>
                    
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                        <select id="subject" name="subject" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
                            <option value="">Select a subject</option>
                            <option value="appointment">Appointment Booking</option>
                            <option value="general">General Inquiry</option>
                            <option value="emergency">Emergency</option>
                            <option value="billing">Billing Question</option>
                            <option value="feedback">Feedback</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                        <textarea id="message" name="message" rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 resize-none" placeholder="Tell us how we can help you..."></textarea>
                    </div>
                    
                    <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white font-semibold py-4 px-6 rounded-xl hover:from-purple-700 hover:to-pink-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        Send Message
                    </button>
                </form>
            </div>
        </div>

        <!-- Map Section -->
        <div class="mt-16 bg-white rounded-3xl shadow-2xl p-8 border border-gray-100">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Find Us</h2>
            <div class="bg-gray-200 rounded-2xl h-64 flex items-center justify-center">
                <div class="text-center">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <p class="text-gray-600 font-medium">Interactive Map Coming Soon</p>
                    <p class="text-gray-500 text-sm mt-2">Capitulacion Street, Zone 2, Bangued, Abra</p>
                </div>
            </div>
        </div>

        <!-- Enhanced Back to Home Button -->
        <div class="text-center mt-12">
            <a href="{{ route('home') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-semibold rounded-2xl hover:from-purple-700 hover:to-pink-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Back to Home
            </a>
        </div>
    </div>
</div>
@endsection
