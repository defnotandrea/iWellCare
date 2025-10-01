

<?php $__env->startSection('title', 'Create Invoice'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto py-8">
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Create New Invoice</h1>
        <p class="text-gray-600">Fill out the form below to create a new invoice</p>
    </div>

    <form id="invoice-form" class="max-w-4xl mx-auto">
        <?php echo csrf_field(); ?>
        
        <!-- Basic Invoice Information -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Invoice Information</h2>
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Invoice Number:</label>
                    <input type="text" name="invoiceNumber" value="0001635" class="w-full p-3 border border-gray-300 rounded-lg" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Date:</label>
                    <input type="date" name="date" value="<?php echo e(date('Y-m-d')); ?>" class="w-full p-3 border border-gray-300 rounded-lg" required>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Customer Information</h2>
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Customer Name:</label>
                    <input type="text" name="customerName" class="w-full p-3 border border-gray-300 rounded-lg" placeholder="Enter customer name" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">TIN:</label>
                    <input type="text" name="customerTin" class="w-full p-3 border border-gray-300 rounded-lg" placeholder="Tax Identification Number">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Address:</label>
                    <input type="text" name="customerAddress" class="w-full p-3 border border-gray-300 rounded-lg" placeholder="Enter customer address" required>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">SC/PWD/PNSTM/Solo Parent ID:</label>
                    <input type="text" name="customerId" class="w-full p-3 border border-gray-300 rounded-lg" placeholder="ID Number">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Signature:</label>
                    <input type="text" name="customerSignature" class="w-full p-3 border border-gray-300 rounded-lg" placeholder="Customer signature or name">
                </div>
            </div>
        </div>

        <!-- Services/Items -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Services/Items</h2>
            <div id="items-container">
                <div class="item-row grid grid-cols-4 gap-4 mb-4 p-4 border border-gray-200 rounded-lg">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Quantity:</label>
                        <input type="number" name="items[0][quantity]" min="0" step="1" class="w-full p-3 border border-gray-300 rounded-lg" value="1" required>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Description:</label>
                        <input type="text" name="items[0][description]" class="w-full p-3 border border-gray-300 rounded-lg" placeholder="Service description" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Unit Cost:</label>
                        <input type="number" name="items[0][unitCost]" min="0" step="0.01" class="w-full p-3 border border-gray-300 rounded-lg" placeholder="0.00" required>
                    </div>
                </div>
            </div>
            <button type="button" onclick="addItem()" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
                + Add Item
            </button>
        </div>

        <!-- Payment Information -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Payment Information</h2>
            <div class="grid grid-cols-2 gap-8">
                <div>
                    <h3 class="font-semibold text-gray-800 mb-3">Payment Method:</h3>
                    <div class="space-y-3">
                        <label class="flex items-center">
                            <input type="radio" name="paymentMethod" value="cash" checked class="mr-3">
                            <span>Cash</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="paymentMethod" value="check" class="mr-3">
                            <span>Check</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="paymentMethod" value="credit" class="mr-3">
                            <span>Credit</span>
                        </label>
                    </div>

                    <div id="check-details" class="mt-4 space-y-3 hidden">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Check Number:</label>
                            <input type="text" name="checkNumber" class="w-full p-3 border border-gray-300 rounded-lg" placeholder="Check Number">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Check Date:</label>
                            <input type="date" name="checkDate" class="w-full p-3 border border-gray-300 rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Bank:</label>
                            <input type="text" name="bank" class="w-full p-3 border border-gray-300 rounded-lg" placeholder="Bank Name">
                        </div>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="font-semibold text-gray-700">TOTAL SALES:</span>
                        <input type="number" name="totalSales" min="0" step="0.01" class="w-32 p-3 border border-gray-300 rounded-lg text-right" placeholder="0.00" readonly>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="font-semibold text-gray-700">LESS: SC/PWD/NAAC/SP DISC.:</span>
                        <input type="number" name="discount" min="0" step="0.01" class="w-32 p-3 border border-gray-300 rounded-lg text-right" placeholder="0.00">
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="font-semibold text-gray-700">TOTAL DUE:</span>
                        <input type="number" name="totalDue" min="0" step="0.01" class="w-32 p-3 border border-gray-300 rounded-lg text-right" placeholder="0.00" readonly>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="font-semibold text-gray-700">LESS: WITHHOLDING:</span>
                        <input type="number" name="withholding" min="0" step="0.01" class="w-32 p-3 border border-gray-300 rounded-lg text-right" placeholder="0.00">
                    </div>
                    <div class="flex justify-between items-center border-t-2 border-gray-300 pt-3">
                        <span class="font-bold text-lg text-gray-800">TOTAL AMOUNT DUE:</span>
                        <div class="flex items-center">
                            <span class="text-lg font-bold mr-2">₱</span>
                            <input type="number" name="totalAmountDue" min="0" step="0.01" class="w-32 p-3 border border-gray-300 rounded-lg text-right font-bold" placeholder="0.00" readonly>
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="font-semibold text-gray-700">SALE/S SUBJ. TO PT. EXEMPT SALES:</span>
                        <input type="number" name="exemptSales" min="0" step="0.01" class="w-32 p-3 border border-gray-300 rounded-lg text-right" placeholder="0.00">
                    </div>
                </div>
            </div>
        </div>

        <!-- Cashier Information -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Authorization</h2>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Cashier / Authorized Representative:</label>
                <input type="text" name="cashierName" class="w-full p-3 border border-gray-300 rounded-lg" placeholder="Enter cashier name" required>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="text-center space-x-4">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-8 rounded-lg transition duration-200">
                💾 Save Invoice
            </button>
            <button type="button" onclick="previewInvoice()" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg transition duration-200">
                👁️ Preview
            </button>
            <button type="button" onclick="resetForm()" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-8 rounded-lg transition duration-200">
                🔄 Reset
            </button>
        </div>
    </form>
</div>

<script>
let itemCount = 1;

// Show/hide check details based on payment method
document.querySelectorAll('input[name="paymentMethod"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const checkDetails = document.getElementById('check-details');
        if (this.value === 'check') {
            checkDetails.classList.remove('hidden');
        } else {
            checkDetails.classList.add('hidden');
        }
    });
});

// Add new item row
function addItem() {
    const container = document.getElementById('items-container');
    const newRow = document.createElement('div');
    newRow.className = 'item-row grid grid-cols-4 gap-4 mb-4 p-4 border border-gray-200 rounded-lg';
    newRow.innerHTML = `
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Quantity:</label>
            <input type="number" name="items[${itemCount}][quantity]" min="0" step="1" class="w-full p-3 border border-gray-300 rounded-lg" value="1" required>
        </div>
        <div class="col-span-2">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Description:</label>
            <input type="text" name="items[${itemCount}][description]" class="w-full p-3 border border-gray-300 rounded-lg" placeholder="Service description" required>
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Unit Cost:</label>
            <input type="number" name="items[${itemCount}][unitCost]" min="0" step="0.01" class="w-full p-3 border border-gray-300 rounded-lg" placeholder="0.00" required>
        </div>
        <div class="col-span-4 text-right">
            <button type="button" onclick="removeItem(this)" class="text-red-600 hover:text-red-800 font-semibold">Remove Item</button>
        </div>
    `;
    container.appendChild(newRow);
    itemCount++;
}

// Remove item row
function removeItem(button) {
    button.closest('.item-row').remove();
}

// Calculate totals
function calculateTotals() {
    let totalSales = 0;
    const itemRows = document.querySelectorAll('.item-row');
    
    itemRows.forEach(row => {
        const quantity = parseFloat(row.querySelector('input[name*="[quantity]"]').value) || 0;
        const unitCost = parseFloat(row.querySelector('input[name*="[unitCost]"]').value) || 0;
        totalSales += quantity * unitCost;
    });
    
    document.querySelector('input[name="totalSales"]').value = totalSales.toFixed(2);
    
    const discount = parseFloat(document.querySelector('input[name="discount"]').value) || 0;
    const withholding = parseFloat(document.querySelector('input[name="withholding"]').value) || 0;
    
    const totalDue = totalSales - discount;
    const totalAmountDue = totalDue - withholding;
    
    document.querySelector('input[name="totalDue"]').value = totalDue.toFixed(2);
    document.querySelector('input[name="totalAmountDue"]').value = totalAmountDue.toFixed(2);
}

// Add event listeners for calculations
document.addEventListener('input', function(e) {
    if (e.target.name.includes('quantity') || e.target.name.includes('unitCost') || 
        e.target.name === 'discount' || e.target.name === 'withholding') {
        calculateTotals();
    }
});

// Form submission
document.getElementById('invoice-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Collect form data
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
    // Convert items to proper format
    const items = [];
    const itemRows = document.querySelectorAll('.item-row');
    itemRows.forEach((row, index) => {
        const quantity = row.querySelector('input[name*="[quantity]"]').value;
        const description = row.querySelector('input[name*="[description]"]').value;
        const unitCost = row.querySelector('input[name*="[unitCost]"]').value;
        
        if (quantity && description && unitCost) {
            items.push({
                quantity: parseFloat(quantity),
                description: description,
                unitCost: parseFloat(unitCost),
                amount: parseFloat(quantity) * parseFloat(unitCost)
            });
        }
    });
    
    data.items = items;
    
    // Submit to server
    fetch('/invoices', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Invoice created successfully!');
            // Redirect to invoice view or list
            window.location.href = '/invoices/' + data.invoice.id;
        } else {
            alert('Error creating invoice: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error creating invoice. Please try again.');
    });
});

// Preview invoice
function previewInvoice() {
    // Collect form data and show preview
    const formData = new FormData(document.getElementById('invoice-form'));
    const data = Object.fromEntries(formData);
    
    // Open preview in new window
    const previewWindow = window.open('/invoice-demo', '_blank');
    // You could pass the data to the preview window or store it temporarily
}

// Reset form
function resetForm() {
    if (confirm('Are you sure you want to reset the form? All data will be lost.')) {
        document.getElementById('invoice-form').reset();
        // Remove all extra item rows
        const itemRows = document.querySelectorAll('.item-row');
        itemRows.forEach((row, index) => {
            if (index > 0) row.remove();
        });
        itemCount = 1;
        calculateTotals();
    }
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\invoices\create.blade.php ENDPATH**/ ?>