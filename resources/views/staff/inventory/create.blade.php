@extends('layouts.staff')

@section('title', 'Add Inventory Item - iWellCare')
@section('page-title', 'Add Inventory Item')
@section('page-subtitle', 'Add a new item to the medical inventory')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('staff.inventory.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 transition-colors">
                <i class="fas fa-arrow-left"></i>Back to Inventory
            </a>
        </div>

        <!-- Main Content Container -->
        <div class="space-y-6">
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-xl flex items-start gap-3">
                    <i class="fas fa-exclamation-triangle text-red-500 mt-1"></i>
                    <div>
                        <h4 class="font-semibold mb-2">Please fix the following errors:</h4>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li class="text-sm">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('staff.inventory.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Basic Information Section -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-info-circle text-blue-600"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Basic Information</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-tag text-gray-400 mr-2"></i>Item Name *
                        </label>
                        <input type="text" name="name" id="name" 
                               value="{{ old('name') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                               required 
                               placeholder="e.g., Paracetamol 500mg, Surgical Gloves, Stethoscope">
                    </div>
                    
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-list text-gray-400 mr-2"></i>Category *
                        </label>
                        <select name="category" id="category" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                required>
                            <option value="">Select Category</option>
                            <option value="medicine" {{ old('category') === 'medicine' ? 'selected' : '' }}>Medicine</option>
                            <option value="supplies" {{ old('category') === 'supplies' ? 'selected' : '' }}>Medical Supplies</option>
                            <option value="equipment" {{ old('category') === 'equipment' ? 'selected' : '' }}>Medical Equipment</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-hashtag text-gray-400 mr-2"></i>Quantity *
                        </label>
                        <input type="number" name="quantity" id="quantity" 
                               value="{{ old('quantity') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                               required min="0" 
                               placeholder="e.g., 100">
                    </div>
                    
                    <div>
                        <label for="unit_price" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-dollar-sign text-gray-400 mr-2"></i>Unit Price (₱) *
                        </label>
                        <input type="number" name="unit_price" id="unit_price" 
                               value="{{ old('unit_price') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                               required min="0" step="0.01" 
                               placeholder="e.g., 5.50">
                    </div>
                    
                    <div>
                        <label for="reorder_level" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-exclamation-triangle text-gray-400 mr-2"></i>Reorder Level
                        </label>
                        <input type="number" name="reorder_level" id="reorder_level" 
                               value="{{ old('reorder_level', 10) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                               min="0" 
                               placeholder="e.g., 10">
                        <p class="text-sm text-gray-500 mt-2 flex items-center gap-1">
                            <i class="fas fa-info-circle"></i>Alert when stock reaches this level
                        </p>
                    </div>
                    
                    <div>
                        <label for="supplier" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-truck text-gray-400 mr-2"></i>Supplier
                        </label>
                        <input type="text" name="supplier" id="supplier" 
                               value="{{ old('supplier') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                               placeholder="e.g., ABC Pharmaceuticals">
                    </div>
                </div>
            </div>
            
            <!-- Additional Information Section -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-plus-circle text-indigo-600"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Additional Information</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-align-left text-gray-400 mr-2"></i>Description
                        </label>
                        <textarea name="description" id="description" rows="3" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none" 
                                  placeholder="Detailed description of the item...">{{ old('description') }}</textarea>
                    </div>
                    
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-map-marker-alt text-gray-400 mr-2"></i>Storage Location
                        </label>
                        <input type="text" name="location" id="location" 
                               value="{{ old('location') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                               placeholder="e.g., Cabinet A, Shelf 2, Refrigerator">
                    </div>
                    
                    <div>
                        <label for="batch_number" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-barcode text-gray-400 mr-2"></i>Batch Number
                        </label>
                        <input type="text" name="batch_number" id="batch_number" 
                               value="{{ old('batch_number') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                               placeholder="e.g., BATCH-2024-001">
                    </div>
                    
                    <div>
                        <label for="expiration_date" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-calendar-alt text-gray-400 mr-2"></i>Expiration Date
                        </label>
                        <input type="date" name="expiration_date" id="expiration_date" 
                               value="{{ old('expiration_date') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                               min="{{ date('Y-m-d') }}">
                        <p class="text-sm text-gray-500 mt-2 flex items-center gap-1">
                            <i class="fas fa-info-circle"></i>Leave blank if not applicable
                        </p>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-sticky-note text-gray-400 mr-2"></i>Notes
                        </label>
                        <textarea name="notes" id="notes" rows="3" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none" 
                                  placeholder="Any additional notes or special instructions...">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="bg-gray-50 rounded-xl p-6 flex justify-end gap-4">
                <a href="{{ route('staff.inventory.index') }}" 
                   class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors flex items-center gap-2 font-medium">
                    <i class="fas fa-times"></i>Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors flex items-center gap-2 font-medium shadow-lg">
                    <i class="fas fa-save"></i>Add Item
                </button>
            </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
/* Enhanced form styling */
.min-h-screen {
    background: #f9fafb;
}

/* Form section animations */
.bg-white.rounded-xl {
    animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Enhanced input focus states */
input:focus, select:focus, textarea:focus {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px -2px rgba(59, 130, 246, 0.15);
}

/* Button hover effects */
button:hover, a:hover {
    transform: translateY(-1px);
    transition: all 0.2s ease-in-out;
}

/* Section header icons */
.w-10.h-10 {
    transition: all 0.3s ease-in-out;
}

.bg-blue-100:hover, .bg-purple-100:hover {
    transform: scale(1.05);
}

/* Form field icons */
.fas {
    transition: color 0.2s ease-in-out;
}

/* Enhanced error styling */
.bg-red-50 {
    animation: shake 0.5s ease-in-out;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-calculate total value
    const quantityInput = document.getElementById('quantity');
    const unitPriceInput = document.getElementById('unit_price');
    
    function calculateTotal() {
        const quantity = parseFloat(quantityInput.value) || 0;
        const unitPrice = parseFloat(unitPriceInput.value) || 0;
        const total = quantity * unitPrice;
        
        // You can add a display element for total if needed
        console.log('Total Value: ₱' + total.toFixed(2));
    }
    
    quantityInput.addEventListener('input', calculateTotal);
    unitPriceInput.addEventListener('input', calculateTotal);
    
    // Set minimum date for expiration date
    const expirationDateInput = document.getElementById('expiration_date');
    const today = new Date().toISOString().split('T')[0];
    expirationDateInput.setAttribute('min', today);
    
    // Enhanced form validation
    const form = document.querySelector('form');
    const submitBtn = form.querySelector('button[type="submit"]');
    
    form.addEventListener('submit', function(e) {
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Adding Item...';
        submitBtn.disabled = true;
        
        // Re-enable after 3 seconds as fallback
        setTimeout(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 3000);
    });
});
</script>
@endpush
@endsection 