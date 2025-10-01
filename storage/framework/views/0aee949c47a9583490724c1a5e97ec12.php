<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'invoiceNumber' => '',
    'date' => '',
    'customerName' => '',
    'customerTin' => '',
    'customerAddress' => '',
    'customerId' => '',
    'customerSignature' => '',
    'items' => [],
    'totalSales' => '',
    'discount' => '',
    'totalDue' => '',
    'withholding' => '',
    'totalAmountDue' => '',
    'exemptSales' => '',
    'paymentMethod' => 'cash',
    'checkNumber' => '',
    'checkDate' => '',
    'bank' => '',
    'cashierName' => ''
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'invoiceNumber' => '',
    'date' => '',
    'customerName' => '',
    'customerTin' => '',
    'customerAddress' => '',
    'customerId' => '',
    'customerSignature' => '',
    'items' => [],
    'totalSales' => '',
    'discount' => '',
    'totalDue' => '',
    'withholding' => '',
    'totalAmountDue' => '',
    'exemptSales' => '',
    'paymentMethod' => 'cash',
    'checkNumber' => '',
    'checkDate' => '',
    'bank' => '',
    'cashierName' => ''
]); ?>
<?php foreach (array_filter(([
    'invoiceNumber' => '',
    'date' => '',
    'customerName' => '',
    'customerTin' => '',
    'customerAddress' => '',
    'customerId' => '',
    'customerSignature' => '',
    'items' => [],
    'totalSales' => '',
    'discount' => '',
    'totalDue' => '',
    'withholding' => '',
    'totalAmountDue' => '',
    'exemptSales' => '',
    'paymentMethod' => 'cash',
    'checkNumber' => '',
    'checkDate' => '',
    'bank' => '',
    'cashierName' => ''
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div class="invoice-container bg-white shadow-lg border border-gray-200 max-w-4xl mx-auto p-6 font-sans">
    <!-- Carbon Copy Overlay (Top Left) -->
    <div class="carbon-copy-overlay absolute top-0 left-0 w-32 h-32 bg-yellow-200 opacity-80 transform -rotate-12 z-10 flex items-center justify-center">
        <div class="text-center text-xs font-bold">
            <div class="text-lg font-black text-gray-800">000183</div>
            <div class="text-xs text-gray-600">COPY</div>
        </div>
    </div>

    <!-- Main Invoice Content -->
    <div class="relative z-20">
        <!-- Clinic Header -->
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">ADULT WELLNESS CLINIC & MEDICAL LABORATORY</h1>
            <p class="text-sm text-gray-600 mb-1">40 Capitulacion St., Zone 2, Pob. (Consiliman), 2800 Bangued (Capital), Abra, Philippines</p>
            <p class="text-sm text-gray-600 mb-1">AUGUSTUS CAESAR BUTCH B. BIGORNIA - Prop.</p>
            <p class="text-sm text-gray-600 mb-3">Non-VAT Reg. TIN: 248-390-356-00000</p>
            
            <div class="border-t-2 border-gray-300 pt-3">
                <h2 class="text-xl font-bold text-gray-800 mb-2">SERVICE INVOICE</h2>
                <div class="flex justify-center items-center gap-8">
                    <div class="text-left">
                        <span class="font-semibold">No.</span>
                        <span class="text-red-600 font-bold text-lg ml-2"><?php echo e($invoiceNumber ?: '0001635'); ?></span>
                    </div>
                    <div class="text-left">
                        <span class="font-semibold">DATE:</span>
                        <span class="ml-2"><?php echo e($date ?: date('M d, Y')); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">SOLD TO:</label>
                <input type="text" value="<?php echo e($customerName); ?>" class="w-full p-2 border border-gray-300 rounded bg-gray-50" placeholder="Customer Name">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">TIN:</label>
                <input type="text" value="<?php echo e($customerTin); ?>" class="w-full p-2 border border-gray-300 rounded bg-gray-50" placeholder="Tax Identification Number">
            </div>
            <div class="col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1">ADDRESS:</label>
                <input type="text" value="<?php echo e($customerAddress); ?>" class="w-full p-2 border border-gray-300 rounded bg-gray-50" placeholder="Customer Address">
            </div>
            <div class="col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1">SC/PWD/PNSTM/Solo Parent ID No.:</label>
                <input type="text" value="<?php echo e($customerId); ?>" class="w-full p-2 border border-gray-300 rounded bg-gray-50" placeholder="ID Number">
            </div>
            <div class="col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1">SIGNATURE:</label>
                <input type="text" value="<?php echo e($customerSignature); ?>" class="w-full p-2 border border-gray-300 rounded bg-gray-50" placeholder="Customer Signature">
            </div>
        </div>

        <!-- Services Table -->
        <div class="mb-6">
            <table class="w-full border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-gray-300 p-2 text-sm font-semibold text-center w-16">QTY.</th>
                        <th class="border border-gray-300 p-2 text-sm font-semibold text-center">ARTICLES</th>
                        <th class="border border-gray-300 p-2 text-sm font-semibold text-center w-24">UNIT COST</th>
                        <th class="border border-gray-300 p-2 text-sm font-semibold text-center w-24">AMOUNT</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for($i = 0; $i < 20; $i++): ?>
                        <tr>
                            <td class="border border-gray-300 p-2">
                                <input type="number" min="0" step="1" class="w-full p-1 border-0 text-center" placeholder="0">
                            </td>
                            <td class="border border-gray-300 p-2">
                                <input type="text" class="w-full p-1 border-0" placeholder="Service description">
                            </td>
                            <td class="border border-gray-300 p-2">
                                <input type="number" min="0" step="0.01" class="w-full p-1 border-0 text-right" placeholder="0.00">
                            </td>
                            <td class="border border-gray-300 p-2">
                                <input type="number" min="0" step="0.01" class="w-full p-1 border-0 text-right" placeholder="0.00" readonly>
                            </td>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </div>

        <!-- Payment Method and Financial Summary -->
        <div class="grid grid-cols-2 gap-8 mb-6">
            <!-- Payment Method -->
            <div>
                <h3 class="font-semibold text-gray-800 mb-3">Payment Method:</h3>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="radio" name="payment_method" value="cash" <?php echo e($paymentMethod === 'cash' ? 'checked' : ''); ?> class="mr-2">
                        <span>Cash</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="payment_method" value="check" <?php echo e($paymentMethod === 'check' ? 'checked' : ''); ?> class="mr-2">
                        <span>Check</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="payment_method" value="credit" <?php echo e($paymentMethod === 'credit' ? 'checked' : ''); ?> class="mr-2">
                        <span>Credit</span>
                    </label>
                </div>

                <!-- Check Details (shown when check is selected) -->
                <div id="check-details" class="mt-4 space-y-2 <?php echo e($paymentMethod === 'check' ? '' : 'hidden'); ?>">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Check No.:</label>
                        <input type="text" value="<?php echo e($checkNumber); ?>" class="w-full p-2 border border-gray-300 rounded" placeholder="Check Number">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Date:</label>
                        <input type="date" value="<?php echo e($checkDate); ?>" class="w-full p-2 border border-gray-300 rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">BANK:</label>
                        <input type="text" value="<?php echo e($bank); ?>" class="w-full p-2 border border-gray-300 rounded" placeholder="Bank Name">
                    </div>
                </div>
            </div>

            <!-- Financial Summary -->
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="font-semibold text-gray-700">TOTAL SALES:</span>
                    <input type="number" value="<?php echo e($totalSales); ?>" class="w-32 p-2 border border-gray-300 rounded text-right" placeholder="0.00">
                </div>
                <div class="flex justify-between items-center">
                    <span class="font-semibold text-gray-700">LESS: SC/PWD/NAAC/SP DISC.:</span>
                    <input type="number" value="<?php echo e($discount); ?>" class="w-32 p-2 border border-gray-300 rounded text-right" placeholder="0.00">
                </div>
                <div class="flex justify-between items-center">
                    <span class="font-semibold text-gray-700">TOTAL DUE:</span>
                    <input type="number" value="<?php echo e($totalDue); ?>" class="w-32 p-2 border border-gray-300 rounded text-right" placeholder="0.00">
                </div>
                <div class="flex justify-between items-center">
                    <span class="font-semibold text-gray-700">LESS: WITHHOLDING:</span>
                    <input type="number" value="<?php echo e($withholding); ?>" class="w-32 p-2 border border-gray-300 rounded text-right" placeholder="0.00">
                </div>
                <div class="flex justify-between items-center border-t-2 border-gray-300 pt-2">
                    <span class="font-bold text-lg text-gray-800">TOTAL AMOUNT DUE:</span>
                    <div class="flex items-center">
                        <span class="text-lg font-bold mr-1">₱</span>
                        <input type="number" value="<?php echo e($totalAmountDue); ?>" class="w-32 p-2 border border-gray-300 rounded text-right font-bold" placeholder="0.00">
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <span class="font-semibold text-gray-700">SALE/S SUBJ. TO PT. EXEMPT SALES:</span>
                    <input type="number" value="<?php echo e($exemptSales); ?>" class="w-32 p-2 border border-gray-300 rounded text-right" placeholder="0.00">
                </div>
            </div>
        </div>

        <!-- Authorization -->
        <div class="mb-6">
            <div class="text-center">
                <p class="font-semibold text-gray-800 mb-2">Cashier / Authorized Representative</p>
                <div class="w-64 mx-auto border-b-2 border-gray-400 h-12 flex items-end justify-center">
                    <input type="text" value="<?php echo e($cashierName); ?>" class="w-full text-center border-0 bg-transparent" placeholder="Signature/Name">
                </div>
            </div>
        </div>

        <!-- PTU Details -->
        <div class="border-t-2 border-gray-300 pt-4 text-xs text-gray-600">
            <div class="grid grid-cols-4 gap-4 text-center">
                <div>
                    <span class="font-semibold">PTU No. [FOR LOOSELEAF]</span>
                </div>
                <div>
                    <span class="font-semibold">NO. OF BOXES/BOOKLETS:</span><br>
                    <span>40 Bkits.</span>
                </div>
                <div>
                    <span class="font-semibold">NO. OF SETS PER BOX/BKLTS.:</span><br>
                    <span>50</span>
                </div>
                <div>
                    <span class="font-semibold">NO. OF COPIES PER SET:</span><br>
                    <span>2x</span>
                </div>
            </div>
            <div class="grid grid-cols-4 gap-4 text-center mt-2">
                <div>
                    <span class="font-semibold">SERIAL NO. FROM:</span><br>
                    <span>000501</span>
                </div>
                <div>
                    <span class="font-semibold">TO:</span><br>
                    <span>002500</span>
                </div>
                <div>
                    <span class="font-semibold">OCN:</span><br>
                    <span>007AU20240000001188</span>
                </div>
                <div>
                    <span class="font-semibold">DATE OF ATP:</span><br>
                    <span>MAY 14, 2024</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show/hide check details based on payment method
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    const checkDetails = document.getElementById('check-details');
    
    paymentMethods.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'check') {
                checkDetails.classList.remove('hidden');
            } else {
                checkDetails.classList.add('hidden');
            }
        });
    });

    // Calculate row totals
    const table = document.querySelector('table');
    table.addEventListener('input', function(e) {
        if (e.target.type === 'number') {
            const row = e.target.closest('tr');
            if (row) {
                const qtyInput = row.querySelector('td:nth-child(1) input');
                const unitCostInput = row.querySelector('td:nth-child(3) input');
                const amountInput = row.querySelector('td:nth-child(4) input');
                
                if (qtyInput && unitCostInput && amountInput) {
                    const qty = parseFloat(qtyInput.value) || 0;
                    const unitCost = parseFloat(unitCostInput.value) || 0;
                    const amount = qty * unitCost;
                    amountInput.value = amount.toFixed(2);
                }
            }
        }
    });

    // Calculate totals
    function calculateTotals() {
        let totalSales = 0;
        const amountInputs = document.querySelectorAll('tbody td:nth-child(4) input');
        
        amountInputs.forEach(input => {
            totalSales += parseFloat(input.value) || 0;
        });
        
        const totalSalesInput = document.querySelector('input[placeholder="0.00"]');
        if (totalSalesInput) {
            totalSalesInput.value = totalSales.toFixed(2);
        }
    }

    // Recalculate totals when any amount changes
    table.addEventListener('input', calculateTotals);
});
</script>

<style>
.invoice-container {
    position: relative;
    font-family: 'Arial', sans-serif;
}

.carbon-copy-overlay {
    position: absolute;
    top: -20px;
    left: -20px;
    width: 120px;
    height: 120px;
    background: linear-gradient(45deg, #fef3c7, #fde68a);
    border: 2px solid #f59e0b;
    border-radius: 8px;
    box-shadow: 2px 2px 8px rgba(0,0,0,0.1);
}

@media print {
    .invoice-container {
        box-shadow: none;
        border: none;
    }
    
    .carbon-copy-overlay {
        display: none;
    }
}
</style>
<?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\components\invoice-layout.blade.php ENDPATH**/ ?>