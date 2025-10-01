@extends('layouts.staff')
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
        <div class="text-3xl font-bold text-blue-700 mb-2">{{ $billings->total() }}</div>
        <div class="text-xs text-blue-600 bg-blue-100 px-2 py-1 rounded-full">All Time</div>
    </div>
    
                    <div class="card p-6 flex flex-col items-center bg-gradient-to-br from-green-100 to-green-50 shadow-md hover:shadow-lg">
        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-check-circle text-green-600 text-2xl"></i>
        </div>
        <div class="text-gray-500 text-sm font-medium mb-1">Paid Invoices</div>
        <div class="text-3xl font-bold text-green-700 mb-2">{{ $billings->filter(fn($b) => $b->status === 'paid')->count() }}</div>
        <div class="text-xs text-green-600 bg-green-100 px-2 py-1 rounded-full">Completed</div>
    </div>
    
                    <div class="card p-6 flex flex-col items-center bg-gradient-to-br from-yellow-100 to-yellow-50 shadow-md hover:shadow-lg">
        <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-exclamation-triangle text-yellow-600 text-2xl"></i>
        </div>
        <div class="text-gray-500 text-sm font-medium mb-1">Unpaid Invoices</div>
        <div class="text-3xl font-bold text-yellow-700 mb-2">{{ $billings->filter(fn($b) => $b->status === 'unpaid')->count() }}</div>
        <div class="text-xs text-yellow-600 bg-yellow-100 px-2 py-1 rounded-full">Pending</div>
    </div>
</div>

<!-- Action Button -->
<div class="flex justify-end mb-6">
    <a href="{{ route('staff.invoice.create') }}" class="btn btn-primary flex items-center gap-2">
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
        <table class="min-w-full text-sm rounded shadow">
            <thead>
                <tr class="text-left text-gray-500 bg-gray-50">
                    <th class="py-3 px-4 font-semibold">Patient</th>
                    <th class="py-3 px-4 font-semibold">Appointment</th>
                    <th class="py-3 px-4 font-semibold">Consultation</th>
                    <th class="py-3 px-4 font-semibold">Medication</th>
                    <th class="py-3 px-4 font-semibold">Laboratory</th>
                    <th class="py-3 px-4 font-semibold">Other</th>
                    <th class="py-3 px-4 font-semibold">Total</th>
                    <th class="py-3 px-4 font-semibold">Status</th>
                    <th class="py-3 px-4 font-semibold">Payment Date</th>
                    <th class="py-3 px-4 font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($billings as $billing)
                    <tr class="hover:bg-blue-50 transition">
                        <td class="py-3 px-4 flex items-center gap-3">
                            <span class="inline-flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full text-blue-600 font-bold text-lg">
                                {{ strtoupper(substr($billing->patient->first_name ?? '-', 0, 1)) }}
                            </span>
                            <div>
                                <div class="font-medium">{{ $billing->patient->first_name ?? '-' }} {{ $billing->patient->last_name ?? '' }}</div>
                                <div class="text-xs text-gray-500">{{ $billing->patient->email ?? '' }}</div>
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            <div class="font-medium">{{ $billing->appointment ? $billing->appointment->appointment_date->format('M d, Y') : '-' }}</div>
                            <div class="text-xs text-gray-500">{{ $billing->appointment ? $billing->appointment->appointment_time->format('h:i A') : '' }}</div>
                        </td>
                        <td class="py-3 px-4">
                            <div class="font-medium">₱{{ number_format($billing->consultation_fee ?? 0, 2) }}</div>
                        </td>
                        <td class="py-3 px-4">
                            <div class="font-medium">₱{{ number_format($billing->medication_fee ?? 0, 2) }}</div>
                        </td>
                        <td class="py-3 px-4">
                            <div class="font-medium">₱{{ number_format($billing->laboratory_fee ?? 0, 2) }}</div>
                        </td>
                        <td class="py-3 px-4">
                            <div class="font-medium">₱{{ number_format($billing->other_fees ?? 0, 2) }}</div>
                        </td>
                        <td class="py-3 px-4">
                            <div class="font-bold text-lg">₱{{ number_format($billing->total_amount ?? $billing->amount, 2) }}</div>
                        </td>
                        <td class="py-3 px-4">
                            @php
                                $badge = $billing->status === 'paid' 
                                    ? 'bg-green-100 text-green-700 border-green-200' 
                                    : 'bg-yellow-100 text-yellow-700 border-yellow-200';
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border {{ $badge }}">
                                <i class="fas fa-circle mr-2 text-[6px]"></i> {{ ucfirst($billing->status) }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <div class="font-medium">{{ $billing->payment_date ? \Carbon\Carbon::parse($billing->payment_date)->format('M d, Y') : '-' }}</div>
                            <div class="text-xs text-gray-500">{{ $billing->payment_date ? \Carbon\Carbon::parse($billing->payment_date)->format('h:i A') : '' }}</div>
                        </td>
                        <td class="py-3 px-4">
                            <div class="flex gap-2">
                                @if($billing->status === 'unpaid')
                                    <a href="{{ route('staff.invoice.mark-as-paid', $billing->id) }}"
                                       class="btn btn-success btn-sm flex items-center gap-1 !w-24 justify-center"
                                       onclick="return confirm('Mark this invoice as paid?')">
                                        <i class="fas fa-check"></i> Mark Paid
                                    </a>
                                @endif
                                <a href="{{ route('staff.invoice.generate-pdf', $billing->id) }}"
                                   class="btn btn-primary btn-sm flex items-center gap-1 !w-24 justify-center">
                                    <i class="fas fa-file-pdf"></i> Download PDF
                                </a>
                                <a href="{{ route('staff.invoice.generate-pdf', [$billing->id, 'print' => 1]) }}" target="_blank"
                                   class="btn btn-secondary btn-sm flex items-center gap-1 !w-24 justify-center">
                                    <i class="fas fa-print"></i> Print
                                </a>
                                <form action="{{ route('staff.invoice.destroy', $billing->id) }}" method="POST" class="inline delete-invoice-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-invoice-btn btn btn-secondary btn-sm flex items-center gap-1 !w-24 justify-center !text-orange-700 !bg-orange-50 !border-orange-200 hover:!bg-orange-600 hover:!text-white"
                                            data-patient="{{ $billing->patient->first_name ?? '' }} {{ $billing->patient->last_name ?? '' }}"
                                            data-amount="{{ number_format($billing->total_amount ?? $billing->amount, 2) }}"
                                            onclick="return false;">
                                        <i class="fas fa-archive"></i>
                                        <span>Archive</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="py-8 text-center text-gray-400">
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
        {{ $billings->links() }}
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalId = 'invoice-delete-modal';
    let modal = document.getElementById(modalId);
    if (!modal) {
        modal = document.createElement('div');
        modal.id = modalId;
        modal.className = 'fixed inset-0 hidden items-center justify-center bg-black/50 z-50';
        modal.innerHTML = `
            <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-archive"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Archive Invoice</h3>
                </div>
                <p class="text-sm text-gray-600 mb-4">Are you sure you want to archive this invoice? You can restore it later if needed.</p>
                <div class="bg-gray-50 rounded-lg p-3 mb-4 text-sm text-gray-700" id="invoice-delete-summary"></div>
                <div class="flex justify-end gap-3">
                    <button type="button" id="cancel-invoice-delete" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">Cancel</button>
                    <button type="button" id="confirm-invoice-delete" class="px-4 py-2 rounded-lg bg-orange-600 text-white hover:bg-orange-700">Archive</button>
                </div>
            </div>`;
        document.body.appendChild(modal);
    }

    const summary = document.getElementById('invoice-delete-summary');
    const cancelBtn = document.getElementById('cancel-invoice-delete');
    const confirmBtn = document.getElementById('confirm-invoice-delete');
    let targetForm = null;

    document.querySelectorAll('.delete-invoice-form .delete-invoice-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            targetForm = this.closest('form');
            const name = this.getAttribute('data-patient') || 'Unknown';
            const amount = this.getAttribute('data-amount') || '0.00';
            summary.innerHTML = `<strong>Patient:</strong> ${name}<br><strong>Amount:</strong> ₱${amount}`;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });
    });

    cancelBtn.addEventListener('click', function () {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        targetForm = null;
    });

    confirmBtn.addEventListener('click', function () {
        if (!targetForm) return;
        targetForm.submit();
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        targetForm = null;
    });
});
</script>
@endpush


@endsection 