@extends('layouts.admin')
@section('title', 'Invoice - iWellCare')
@section('page-title', 'Invoice & Payments')
@section('page-subtitle', 'Manage patient invoices and payment records')
@section('content')

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="card p-6 flex flex-col items-center bg-gradient-to-br from-blue-100 to-blue-50 shadow-md hover:shadow-lg">
        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-file-invoice-dollar text-blue-600 text-2xl"></i>
        </div>
        <div class="text-gray-500 text-sm font-medium mb-1">Total Invoices</div>
        <div class="text-3xl font-bold text-blue-700 mb-2">{{ $invoices->total() }}</div>
        <div class="text-xs text-blue-600 bg-blue-100 px-2 py-1 rounded-full">All Time</div>
    </div>

                    <div class="card p-6 flex flex-col items-center bg-gradient-to-br from-green-100 to-green-50 shadow-md hover:shadow-lg">
        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-check-circle text-green-600 text-2xl"></i>
        </div>
        <div class="text-gray-500 text-sm font-medium mb-1">Paid Invoices</div>
        <div class="text-3xl font-bold text-green-700 mb-2">{{ $invoices->filter(fn($b) => $b->status === 'paid')->count() }}</div>
        <div class="text-xs text-green-600 bg-green-100 px-2 py-1 rounded-full">Completed</div>
    </div>

                    <div class="card p-6 flex flex-col items-center bg-gradient-to-br from-yellow-100 to-yellow-50 shadow-md hover:shadow-lg">
        <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-exclamation-triangle text-yellow-600 text-2xl"></i>
        </div>
        <div class="text-gray-500 text-sm font-medium mb-1">Unpaid Invoices</div>
        <div class="text-3xl font-bold text-yellow-700 mb-2">{{ $invoices->filter(fn($b) => $b->status === 'unpaid')->count() }}</div>
        <div class="text-xs text-yellow-600 bg-yellow-100 px-2 py-1 rounded-full">Pending</div>
    </div>
</div>

<!-- Action Button -->
<div class="flex justify-end mb-6">
    <a href="{{ route('admin.invoice.create') }}" class="btn btn-primary flex items-center gap-2">
        <i class="fas fa-plus"></i> Create Invoice
    </a>
</div>

<!-- Success Message -->
@if(session('success'))
    <div class="bg-green-100 text-green-800 p-4 rounded mb-6 flex items-center gap-2">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

<!-- Invoice List -->
<div class="card p-6">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-file-invoice-dollar text-blue-600 text-lg"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Invoice List</h3>
                <p class="text-sm text-gray-500">All patient invoices and payments</p>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm rounded-lg shadow-lg border border-gray-200">
            <thead>
                <tr class="text-left text-gray-600 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">Invoice #</th>
                    <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">Patient</th>
                    <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">Appointment</th>
                    <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">Total</th>
                    <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">Status</th>
                    <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">Payment Date</th>
                    <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($invoices as $invoice)
                    <tr class="hover:bg-blue-50 transition-colors duration-200">
                        <td class="py-4 px-6">
                            <div class="font-medium text-blue-600">{{ $invoice->invoice_no ?? 'INV-' . str_pad($invoice->id, 6, '0', STR_PAD_LEFT) }}</div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full text-blue-600 font-bold text-lg">
                                    {{ strtoupper(substr($invoice->patient->first_name ?? '-', 0, 1)) }}
                                </span>
                                <div class="min-w-0 flex-1">
                                    <div class="font-medium text-gray-900">{{ $invoice->patient->first_name ?? '-' }} {{ $invoice->patient->last_name ?? '' }}</div>
                                    <div class="text-xs text-gray-500">{{ $invoice->patient->email ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="font-medium text-gray-900">{{ $invoice->appointment ? $invoice->appointment->appointment_date->format('M d, Y') : '-' }}</div>
                            <div class="text-xs text-gray-500">{{ $invoice->appointment ? $invoice->appointment->appointment_time->format('h:i A') : '' }}</div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="font-bold text-lg text-gray-900">₱{{ number_format($invoice->grand_total ?? $invoice->amount, 2) }}</div>
                        </td>
                        <td class="py-4 px-6">
                            @if($invoice->status === 'paid')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1 text-[8px]"></i> Paid
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1 text-[8px]"></i> Unpaid
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <div class="font-medium text-gray-900">{{ $invoice->payment_date ? \Carbon\Carbon::parse($invoice->payment_date)->format('M d, Y') : '-' }}</div>
                            <div class="text-xs text-gray-500">{{ $invoice->payment_date ? \Carbon\Carbon::parse($invoice->payment_date)->format('h:i A') : '' }}</div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex flex-wrap gap-2">
                                @if($invoice->status === 'unpaid')
                                    <a href="{{ route('admin.invoice.mark-as-paid', $invoice->id) }}"
                                       class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md text-white bg-green-600 hover:bg-green-700 transition-colors duration-200"
                                       onclick="return confirm('Mark this invoice as paid?')">
                                        <i class="fas fa-check mr-1.5"></i> Mark Paid
                                    </a>
                                @endif
                                <a href="{{ route('admin.invoice.generate-pdf', $invoice->id) }}"
                                   class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200">
                                    <i class="fas fa-file-pdf mr-1.5"></i> Download PDF
                                </a>
                                <a href="{{ route('admin.invoice.generate-pdf', [$invoice->id, 'print' => 1]) }}" target="_blank"
                                   class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md text-gray-600 bg-gray-100 hover:bg-gray-200 transition-colors duration-200">
                                    <i class="fas fa-print mr-1.5"></i> Print
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-gray-400">
                            <div class="flex flex-col items-center gap-2">
                                <i class="fas fa-file-invoice text-4xl text-gray-300"></i>
                                <div class="text-lg font-medium">No invoices found</div>
                                <div class="text-sm">Create your first invoice to get started</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $invoices->links() }}
    </div>
</div>



@endsection