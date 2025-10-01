@extends('layouts.patient')

@section('title', 'Invoice Details - iWellCare')
@section('page-title', 'Invoice Details')
@section('page-subtitle', 'View detailed invoice information')

@section('content')
<div class="space-y-6">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('patient.invoice.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Back to Invoices
        </a>
    </div>

    <!-- Invoice Details Card -->
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-xl font-bold text-gray-900">Invoice Information</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Invoice Information -->
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-receipt text-orange-600 text-xl"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900">Invoice #{{ $invoice->invoice_number }}</h4>
                            <p class="text-gray-600">{{ $invoice->description }}</p>
                        </div>
                    </div>
                    
                    <div class="bg-orange-50 rounded-lg p-4">
                        <h5 class="font-medium text-gray-900 mb-2">Invoice Details</h5>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Amount:</span>
                                <span class="font-medium text-lg">₱{{ number_format($invoice->amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status:</span>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    @if($invoice->status === 'paid') bg-green-100 text-green-700
                                    @elseif($invoice->status === 'unpaid') bg-red-100 text-red-700
                                    @else bg-yellow-100 text-yellow-700 @endif">
                                    {{ ucfirst($invoice->status) }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Created Date:</span>
                                <span class="font-medium">{{ \Carbon\Carbon::parse($invoice->created_at)->format('M d, Y') }}</span>
                            </div>
                            @if($invoice->paid_at)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Paid Date:</span>
                                <span class="font-medium">{{ \Carbon\Carbon::parse($invoice->paid_at)->format('M d, Y') }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Patient Information -->
                <div class="space-y-4">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h5 class="font-medium text-gray-900 mb-2">Patient Information</h5>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Name:</span>
                                <span class="font-medium">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Email:</span>
                                <span class="font-medium">{{ auth()->user()->email }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Phone:</span>
                                <span class="font-medium">{{ auth()->user()->phone_number }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Appointment -->
    @if($invoice->appointment)
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-xl font-bold text-gray-900">Related Appointment</h3>
        </div>
        <div class="p-6">
            <div class="bg-blue-50 rounded-lg p-4">
                <h5 class="font-medium text-gray-900 mb-2">Appointment Details</h5>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Doctor:</span>
                        <span class="font-medium">Dr. {{ $invoice->appointment->doctor->first_name }} {{ $invoice->appointment->doctor->last_name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Date:</span>
                        <span class="font-medium">{{ \Carbon\Carbon::parse($invoice->appointment->appointment_date)->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Time:</span>
                        <span class="font-medium">{{ \Carbon\Carbon::parse($invoice->appointment->appointment_time)->format('g:i A') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Status:</span>
                        <span class="font-medium capitalize">{{ $invoice->appointment->status }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Payment Information -->
    @if($invoice->status === 'paid')
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-xl font-bold text-gray-900">Payment Information</h3>
        </div>
        <div class="p-6">
            <div class="bg-green-50 rounded-lg p-4">
                <h5 class="font-medium text-gray-900 mb-2">Payment Details</h5>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Payment Method:</span>
                        <span class="font-medium">{{ $invoice->payment_method ?? 'Not specified' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Transaction ID:</span>
                        <span class="font-medium">{{ $invoice->transaction_id ?? 'Not provided' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Paid Amount:</span>
                        <span class="font-medium">₱{{ number_format($invoice->amount, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Actions -->
    <div class="flex justify-end space-x-4">
        @if($invoice->status === 'unpaid')
        <a href="{{ route('patient.invoice.download', $invoice) }}" class="btn-secondary">
            <i class="fas fa-download mr-2"></i>Download Invoice
        </a>
        <button class="btn-primary">
            <i class="fas fa-credit-card mr-2"></i>Pay Now
        </button>
        @else
        <a href="{{ route('patient.invoice.download', $invoice) }}" class="btn-secondary">
            <i class="fas fa-download mr-2"></i>Download Receipt
        </a>
        @endif
        <a href="{{ route('patient.appointments.create') }}" class="btn-primary">
            <i class="fas fa-plus mr-2"></i>Book Appointment
        </a>
    </div>
</div>
@endsection 