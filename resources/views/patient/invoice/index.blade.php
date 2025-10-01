@extends('layouts.patient')

@section('title', 'My Invoices - iWellCare')
@section('page-title', 'My Invoices')
@section('page-subtitle', 'View your billing history and payment status')

@section('content')
<div class="space-y-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="card p-6" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Invoices</p>
                    <p class="text-white text-3xl font-bold">{{ $invoices->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-receipt text-white text-xl"></i>
                </div>
            </div>
        </div>

        <div class="card p-6" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Unpaid</p>
                    <p class="text-white text-3xl font-bold">{{ $invoices->where('status', 'unpaid')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-exclamation-circle text-white text-xl"></i>
                </div>
            </div>
        </div>

        <div class="card p-6" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Amount</p>
                    <p class="text-white text-3xl font-bold">₱{{ number_format($invoices->sum('amount'), 2) }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-white text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Invoices List -->
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-xl font-bold text-gray-900">Invoice History</h3>
        </div>
        <div class="p-6">
            @if($invoices->count() > 0)
                <div class="space-y-4">
                    @foreach($invoices as $invoice)
                    <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-receipt text-orange-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">Invoice #{{ $invoice->invoice_number }}</h4>
                                    <p class="text-sm text-gray-600">{{ $invoice->description }}</p>
                                    <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($invoice->created_at)->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-gray-900">₱{{ number_format($invoice->amount, 2) }}</p>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                        @if($invoice->status === 'paid') bg-green-100 text-green-700
                                        @elseif($invoice->status === 'unpaid') bg-red-100 text-red-700
                                        @else bg-yellow-100 text-yellow-700 @endif">
                                        {{ ucfirst($invoice->status) }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('patient.invoice.show', $invoice) }}" class="btn-primary text-sm">
                                        <i class="fas fa-eye mr-2"></i>View Details
                                    </a>
                                    @if($invoice->status === 'unpaid')
                                    <a href="{{ route('patient.invoice.download', $invoice) }}" class="btn-secondary text-sm">
                                        <i class="fas fa-download mr-2"></i>Download
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        @if($invoice->appointment)
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h5 class="font-medium text-gray-900 mb-2">Related Appointment</h5>
                            <p class="text-gray-700">Dr. {{ $invoice->appointment->doctor->first_name }} {{ $invoice->appointment->doctor->last_name }} - {{ \Carbon\Carbon::parse($invoice->appointment->appointment_date)->format('M d, Y') }}</p>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                @if($invoices->hasPages())
                <div class="mt-6">
                    {{ $invoices->links() }}
                </div>
                @endif
            @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-receipt text-gray-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Invoices Found</h3>
                    <p class="text-gray-600 mb-6">Your invoices will appear here after consultations and services.</p>
                    <a href="{{ route('patient.appointments.create') }}" class="btn-primary">
                        <i class="fas fa-plus mr-2"></i>Book Appointment
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 