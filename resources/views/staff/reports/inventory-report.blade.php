@extends('layouts.staff')

@section('title', 'Inventory Report - iWellCare')
@section('page-title', 'Inventory Report')
@section('page-subtitle', 'Comprehensive inventory analysis and reporting')

@push('styles')
<style>
@media print {
    /* Hide layout elements */
    nav, .navbar, .sidebar, .fixed, .z-50, .z-40 {
        display: none !important;
    }

    /* Hide modal and overlay */
    .fixed.inset-0.bg-black, #alertModal {
        display: none !important;
    }

    /* Hide no-print elements */
    .no-print {
        display: none !important;
    }

    /* Show print-only elements */
    .print-only {
        display: block !important;
    }

    /* Reset layout */
    body {
        font-size: 12px !important;
        line-height: 1.4 !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .flex, .flex-1, .ml-64, .min-h-screen {
        display: block !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        min-height: auto !important;
    }

    /* Card styling */
    .card {
        border: 1px solid #ddd !important;
        box-shadow: none !important;
        break-inside: avoid;
        margin-bottom: 20px !important;
        background: white !important;
    }

    /* Statistics cards - remove gradients for print */
    .bg-gradient-to-br {
        background: white !important;
        border: 2px solid #ddd !important;
        color: black !important;
    }

    .bg-gradient-to-br .text-blue-100,
    .bg-gradient-to-br .text-pink-100,
    .bg-gradient-to-br .text-cyan-100,
    .bg-gradient-to-br .text-green-100,
    .bg-gradient-to-br .text-orange-100 {
        color: #666 !important;
    }

    .bg-gradient-to-br .text-white {
        color: black !important;
    }

    .bg-gradient-to-br .bg-white\/20 {
        background: #f0f0f0 !important;
    }

    /* Hide icons in stats cards for print */
    .bg-gradient-to-br .fas {
        display: none !important;
    }

    /* Tailwind grid fixes */
    .grid {
        display: block !important;
    }

    .grid-cols-1, .md\\:grid-cols-2, .lg\\:grid-cols-5, .md\\:grid-cols-5 {
        display: block !important;
    }

    .gap-6 > * {
        margin-bottom: 20px !important;
    }

    /* Table styling */
    table {
        font-size: 10px !important;
        width: 100% !important;
        margin-bottom: 20px !important;
        border-collapse: collapse !important;
    }

    th, td {
        padding: 4px !important;
        border: 1px solid #ddd !important;
        word-wrap: break-word !important;
    }

    th {
        background: #f5f5f5 !important;
        font-weight: bold !important;
    }

    /* Hide icons in table for cleaner print */
    .fas.fa-box, .fas.fa-exclamation-triangle {
        display: none !important;
    }

    /* Page breaks */
    .page-break {
        page-break-before: always;
    }

    /* Ensure table rows don't break awkwardly */
    tbody tr {
        page-break-inside: avoid;
    }

    /* Print header */
    .print-header {
        text-align: center;
        border-bottom: 2px solid #000;
        padding-bottom: 20px;
        margin-bottom: 30px;
        page-break-after: avoid;
    }

    .print-header h1 {
        color: #000;
        margin: 0;
        font-size: 24px;
        font-weight: bold;
    }

    .print-header p {
        margin: 5px 0;
        color: #333;
    }

    /* Hide pagination links */
    .pagination, .mt-6 {
        display: none !important;
    }

    /* Hide search and filters in print */
    .card.mb-6 {
        display: none !important;
    }

    /* Adjust table header for print */
    .flex.justify-between.items-center.mb-6 {
        display: none !important;
    }
}
</style>
@endpush

@section('content')
<div class="print-header print-only">
    <h1>Inventory Report</h1>
    <p><strong>Generated:</strong> {{ \Carbon\Carbon::now()->format('F d, Y \a\t g:i A') }}</p>
    <p><strong>iWellCare Healthcare System</strong></p>
</div>
<!-- Search and Filters -->
<div class="card mb-6">
    <div class="p-6">
        <form method="GET" action="{{ route('staff.reports.inventory') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div class="md:col-span-2">
                <input type="text" class="form-input w-full" name="search" 
                       placeholder="Search by name, description, or supplier" 
                       value="{{ request('search') }}">
            </div>
            <div>
                <select class="form-input w-full" name="category">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>
                            {{ ucfirst($category) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <select class="form-input w-full" name="status">
                    <option value="">All Status</option>
                    <option value="low_stock" {{ request('status') === 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                    <option value="out_of_stock" {{ request('status') === 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                    <option value="expiring" {{ request('status') === 'expiring' ? 'selected' : '' }}>Expiring Soon</option>
                </select>
            </div>
            <div class="flex space-x-2">
                <button type="submit" class="btn btn-primary">Search</button>
                <a href="{{ route('staff.reports.inventory') }}" class="btn btn-secondary">Clear</a>
            </div>
        </form>
    </div>
</div>

<!-- Statistics Overview -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 lg:gap-6 mb-8">
    <div class="card p-4 lg:p-6 bg-gradient-to-br from-blue-500 to-purple-600 text-white">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-blue-100 text-xs lg:text-sm font-medium">Total Items</p>
                <p class="text-white text-2xl lg:text-3xl font-bold">{{ $inventoryStats['total'] }}</p>
                <p class="text-blue-100 text-xs">Inventory Items</p>
            </div>
            <div class="w-10 h-10 lg:w-12 lg:h-12 bg-white/20 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-boxes text-white text-lg lg:text-xl"></i>
            </div>
        </div>
    </div>

    <div class="card p-4 lg:p-6 bg-gradient-to-br from-pink-500 to-red-500 text-white">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-pink-100 text-xs lg:text-sm font-medium">Low Stock</p>
                <p class="text-white text-2xl lg:text-3xl font-bold">{{ $inventoryStats['low_stock'] }}</p>
                <p class="text-pink-100 text-xs">Below Reorder Level</p>
            </div>
            <div class="w-10 h-10 lg:w-12 lg:h-12 bg-white/20 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-white text-lg lg:text-xl"></i>
            </div>
        </div>
    </div>

    <div class="card p-4 lg:p-6 bg-gradient-to-br from-cyan-500 to-blue-500 text-white">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-cyan-100 text-xs lg:text-sm font-medium">Out of Stock</p>
                <p class="text-white text-2xl lg:text-3xl font-bold">{{ $inventoryStats['out_of_stock'] }}</p>
                <p class="text-cyan-100 text-xs">Zero Quantity</p>
            </div>
            <div class="w-10 h-10 lg:w-12 lg:h-12 bg-white/20 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-times-circle text-white text-lg lg:text-xl"></i>
            </div>
        </div>
    </div>

    <div class="card p-4 lg:p-6 bg-gradient-to-br from-green-500 to-teal-500 text-white">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-green-100 text-xs lg:text-sm font-medium">Expiring Soon</p>
                <p class="text-white text-2xl lg:text-3xl font-bold">{{ $inventoryStats['expiring_soon'] }}</p>
                <p class="text-green-100 text-xs">Next 30 Days</p>
            </div>
            <div class="w-10 h-10 lg:w-12 lg:h-12 bg-white/20 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-clock text-white text-lg lg:text-xl"></i>
            </div>
        </div>
    </div>

    <div class="card p-4 lg:p-6 bg-gradient-to-br from-orange-500 to-yellow-500 text-white">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-orange-100 text-xs lg:text-sm font-medium">Total Value</p>
                <p class="text-white text-2xl lg:text-3xl font-bold">&#8369;{{ number_format($inventoryStats['total_value'], 2) }}</p>
                <p class="text-orange-100 text-xs">Inventory Worth</p>
            </div>
            <div class="w-10 h-10 lg:w-12 lg:h-12 bg-white/20 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-dollar-sign text-white text-lg lg:text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Inventory Table -->
<div class="card p-6">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-bold">Inventory Items</h3>
        <div class="flex space-x-3">
            <a href="{{ route('staff.reports.exportInventoryPdf') }}"
               class="btn btn-primary" target="_blank">
                <i class="fas fa-file-pdf mr-2"></i>Export PDF
            </a>
            <button type="button" class="btn btn-info no-print" onclick="window.open('{{ route('staff.reports.exportInventoryPdf') }}', '_blank')">
                <i class="fas fa-print mr-2"></i>Print Report
            </button>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="text-left text-gray-500 border-b">
                    <th class="py-3 px-4">Item</th>
                    <th class="py-3 px-4">Category</th>
                    <th class="py-3 px-4">Quantity</th>
                    <th class="py-3 px-4">Unit Price</th>
                    <th class="py-3 px-4">Total Value</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4">Supplier</th>
                    <th class="py-3 px-4">Last Updated</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inventory as $item)
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-3 px-4">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-box text-blue-600 text-sm"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900">{{ $item->name }}</div>
                                <div class="text-xs text-gray-500">{{ Str::limit($item->description, 40) }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-3 px-4">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ ucfirst($item->category) }}
                        </span>
                    </td>
                    <td class="py-3 px-4">
                        <div class="flex items-center">
                            <span class="font-semibold">{{ $item->quantity }}</span>
                            <span class="text-gray-500 ml-1">{{ $item->unit }}</span>
                        </div>
                        @if($item->quantity <= $item->reorder_level)
                            <div class="text-xs text-red-600 mt-1">
                                <i class="fas fa-exclamation-triangle mr-1"></i>Reorder: {{ $item->reorder_level }}
                            </div>
                        @endif
                    </td>
                    <td class="py-3 px-4">&#8369;{{ number_format($item->unit_price, 2) }}</td>
                    <td class="py-3 px-4 font-semibold">
                        &#8369;{{ number_format($item->quantity * $item->unit_price, 2) }}
                    </td>
                    <td class="py-3 px-4">
                        @if($item->quantity <= 0)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Out of Stock
                            </span>
                        @elseif($item->quantity <= $item->reorder_level)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Low Stock
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                In Stock
                            </span>
                        @endif
                    </td>
                    <td class="py-3 px-4 text-gray-700">{{ $item->supplier ?? 'Not specified' }}</td>
                    <td class="py-3 px-4 text-gray-700">
                        {{ $item->updated_at ? $item->updated_at->format('M d, Y') : 'Never' }}
                        @if($item->updatedBy)
                            <div class="text-xs text-gray-500">by {{ $item->updatedBy->name }}</div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="py-8 text-center text-gray-400">
                        <div class="flex flex-col items-center">
                            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                <i class="fas fa-boxes text-gray-300"></i>
                            </div>
                            <p class="font-medium">No inventory items found</p>
                            <p class="text-sm">Try adjusting your search criteria</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($inventory->hasPages())
    <div class="mt-6">
        {{ $inventory->links() }}
    </div>
    @endif
</div>

<script>
function printReport() {
    window.print();
}
</script>
@endsection