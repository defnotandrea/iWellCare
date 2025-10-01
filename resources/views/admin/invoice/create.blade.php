@extends('layouts.admin')
@section('title', 'Create Invoice - iWellCare')
@section('page-title', 'Create Invoice')
@section('page-subtitle', 'Generate a new patient invoice')
@section('content')

<div class="billing-content">
    <div class="card p-6 max-w-2xl mx-auto">
        @if($errors->any())
            <div class="bg-red-100 text-red-800 p-4 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-file-invoice-dollar text-blue-600 text-lg"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Invoice Details</h3>
                <p class="text-sm text-gray-500">Fill in the patient and payment information</p>
            </div>
        </div>

        <form action="{{ route('admin.invoice.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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

                <!-- Detailed Billing Fields -->
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

            <div class="flex justify-end gap-4 mt-8">
                <a href="{{ route('admin.invoice.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times mr-2"></i>Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>Create Invoice
                </button>
            </div>
        </form>
    </div>
</div>

@endsection