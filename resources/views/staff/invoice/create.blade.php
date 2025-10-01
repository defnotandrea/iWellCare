@extends('layouts.staff')
@section('title', 'Create Invoice - iWellCare')
@section('page-title', 'Create Invoice')
@section('page-subtitle', 'Generate a new patient invoice')
@section('content')

<div class="billing-content">
    <div class="card p-3 md:p-4 max-w-3xl mx-auto bg-gradient-to-br from-white to-green-50/30 border border-green-100/50 shadow-lg hover:shadow-xl transition-all duration-300">
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-800 p-3 rounded-lg mb-4 shadow-sm">
                <div class="flex items-center gap-2 mb-2">
                    <i class="fas fa-exclamation-triangle text-red-500"></i>
                    <span class="font-semibold">Please fix the following errors:</span>
                </div>
                <ul class="list-disc list-inside ml-6">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-file-invoice-dollar text-green-600 text-lg"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Invoice Details</h3>
                <p class="text-sm text-gray-500">Fill in the patient and payment information</p>
            </div>
        </div>
        
        <form action="{{ route('staff.invoice.store') }}" method="POST">
            @csrf
            
            <!-- Patient Information Section -->
            <div class="bg-green-50/50 rounded-lg p-3 md:p-4 mb-4 border border-green-100">
                <h4 class="text-base font-semibold text-green-800 mb-3 flex items-center gap-2">
                    <i class="fas fa-user text-green-600"></i>
                    Patient Information
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6">
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-semibold text-sm mb-2">Patient</label>
                    <div class="relative">
                        <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <select name="patient_id" class="form-input w-full pl-10 @error('patient_id') border-red-500 @enderror" required>
                            <option value="">Select Patient</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->first_name }} {{ $patient->last_name }} ({{ $patient->email ?? 'No email' }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('patient_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-semibold text-sm mb-2">Appointment (Optional)</label>
                    <div class="relative">
                        <i class="fas fa-calendar absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <select name="appointment_id" class="form-input w-full pl-10 @error('appointment_id') border-red-500 @enderror">
                            <option value="">No appointment linked</option>
                            @foreach($appointments as $appointment)
                                <option value="{{ $appointment->id }}" {{ old('appointment_id') == $appointment->id ? 'selected' : '' }}>
                                    {{ $appointment->appointment_date->format('M d, Y h:i A') }} - {{ $appointment->patient->first_name ?? '' }} {{ $appointment->patient->last_name ?? '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('appointment_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
               </div>
           </div>

           <!-- Billing Details Section -->
           <div class="bg-blue-50/50 rounded-lg p-3 md:p-4 mb-4 border border-blue-100">
               <h4 class="text-base font-semibold text-blue-800 mb-3 flex items-center gap-2">
                   <i class="fas fa-calculator text-blue-600"></i>
                   Billing Details
               </h4>
               <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6">
                <div>
                    <label class="block text-gray-700 font-semibold text-sm mb-2">Consultation Fee (₱)</label>
                    <div class="relative">
                        <i class="fas fa-stethoscope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="number" name="consultation_fee" class="form-input w-full pl-10 @error('consultation_fee') border-red-500 @enderror" 
                               min="0" step="0.01" value="{{ old('consultation_fee') }}" placeholder="0.00" required>
                    </div>
                    @error('consultation_fee')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold text-sm mb-2">Medication Fee (₱)</label>
                    <div class="relative">
                        <i class="fas fa-pills absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="number" name="medication_fee" class="form-input w-full pl-10 @error('medication_fee') border-red-500 @enderror" 
                               min="0" step="0.01" value="{{ old('medication_fee', 0) }}" placeholder="0.00">
                    </div>
                    @error('medication_fee')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold text-sm mb-2">Laboratory Fee (₱)</label>
                    <div class="relative">
                        <i class="fas fa-flask absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="number" name="laboratory_fee" class="form-input w-full pl-10 @error('laboratory_fee') border-red-500 @enderror" 
                               min="0" step="0.01" value="{{ old('laboratory_fee', 0) }}" placeholder="0.00">
                    </div>
                    @error('laboratory_fee')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold text-sm mb-2">Other Fees (₱)</label>
                    <div class="relative">
                        <i class="fas fa-plus-circle absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="number" name="other_fees" class="form-input w-full pl-10 @error('other_fees') border-red-500 @enderror" 
                               min="0" step="0.01" value="{{ old('other_fees', 0) }}" placeholder="0.00">
                    </div>
                    @error('other_fees')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold text-sm mb-2">Payment Status</label>
                    <div class="relative">
                        <i class="fas fa-check-circle absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <select name="status" class="form-input w-full pl-10 @error('status') border-red-500 @enderror" required>
                            <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="unpaid" {{ old('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                        </select>
                    </div>
                    @error('status')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-semibold text-sm mb-2">Payment Date</label>
                    <div class="relative">
                        <i class="fas fa-calendar-day absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="date" name="payment_date" class="form-input w-full pl-10 @error('payment_date') border-red-500 @enderror" 
                               value="{{ old('payment_date', date('Y-m-d')) }}" required>
                    </div>
                    @error('payment_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
               </div>
           </div>

           <!-- Payment Information Section -->
           <div class="bg-purple-50/50 rounded-lg p-3 md:p-4 mb-4 border border-purple-100">
               <h4 class="text-base font-semibold text-purple-800 mb-3 flex items-center gap-2">
                   <i class="fas fa-credit-card text-purple-600"></i>
                   Payment Information
               </h4>
               <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6">
                   <div>
                       <label class="block text-gray-700 font-semibold text-sm mb-2">Payment Status</label>
                       <div class="relative">
                           <i class="fas fa-check-circle absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                           <select name="status" class="form-input w-full pl-10 @error('status') border-red-500 @enderror" required>
                               <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                               <option value="unpaid" {{ old('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                           </select>
                       </div>
                       @error('status')
                           <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                       @enderror
                   </div>

                   <div>
                       <label class="block text-gray-700 font-semibold text-sm mb-2">Payment Date</label>
                       <div class="relative">
                           <i class="fas fa-calendar-day absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                           <input type="date" name="payment_date" class="form-input w-full pl-10 @error('payment_date') border-red-500 @enderror"
                                  value="{{ old('payment_date', date('Y-m-d')) }}" required>
                       </div>
                       @error('payment_date')
                           <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                       @enderror
                   </div>
               </div>
           </div>
            
            <div class="flex flex-col sm:flex-row justify-end gap-4 mt-6 pt-4 border-t border-gray-100">
                <a href="{{ route('staff.invoice.index') }}" class="btn btn-secondary hover:bg-gray-100 hover:border-gray-300 transition-all duration-200 order-2 sm:order-1">
                    <i class="fas fa-times mr-2"></i>Cancel
                </a>
                <button type="submit" class="btn btn-primary bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 order-1 sm:order-2">
                    <i class="fas fa-save mr-2"></i>Create Invoice
                </button>
            </div>
        </form>
    </div>
</div>

@endsection 