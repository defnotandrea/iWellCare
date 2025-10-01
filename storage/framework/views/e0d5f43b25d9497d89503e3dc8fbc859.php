<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Service Invoice</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 6px;
            line-height: 1.0;
            margin: 0;
            padding: 1px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2px;
        }
        .clinic-info {
            width: 70%;
        }
        .clinic-name {
            font-size: 8px;
            font-weight: bold;
            margin-bottom: 0px;
        }
        .clinic-address {
            margin-bottom: 0px;
        }
        .proprietor {
            margin-bottom: 0px;
        }
        .tin-info {
            margin-bottom: 0px;
        }
        .invoice-details {
            width: 25%;
            text-align: right;
        }
        .invoice-title {
            font-size: 8px;
            font-weight: bold;
            margin-bottom: 1px;
        }
        .invoice-number {
            font-size: 7px;
            font-weight: bold;
            color: #d32f2f;
            margin-bottom: 1px;
        }
        .field-row {
            display: flex;
            margin-bottom: 0px;
        }
        .field-label {
            width: 60px;
            font-weight: bold;
        }
        .field-value {
            flex: 1;
            border-bottom: 1px solid #000;
            min-height: 6px;
        }
        .customer-section {
            margin-bottom: 2px;
        }
        .customer-title {
            font-weight: bold;
            margin-bottom: 0px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2px;
        }
        .items-table th {
            border: 1px solid #000;
            padding: 0px;
            text-align: center;
            font-weight: bold;
            background-color: #f5f5f5;
        }
        .items-table td {
            border: 1px solid #000;
            padding: 0px;
            text-align: center;
            height: 8px;
        }
        .qty-col { width: 10%; }
        .articles-col { width: 50%; }
        .unit-col { width: 20%; }
        .amount-col { width: 20%; }
        .footer-section {
            display: flex;
            justify-content: space-between;
        }
        .payment-methods {
            width: 50%;
        }
        .payment-title {
            font-weight: bold;
            margin-bottom: 0px;
        }
        .checkbox-item {
            margin-bottom: 0px;
        }
        .checkbox-item input[type="checkbox"] {
            margin-right: 0px;
        }
        .check-details {
            margin-top: 1px;
        }
        .check-row {
            display: flex;
            margin-bottom: 0px;
        }
        .check-label {
            width: 60px;
        }
        .check-value {
            flex: 1;
            border-bottom: 1px solid #000;
            min-height: 4px;
        }
        .summary-section {
            width: 45%;
        }
        .summary-title {
            font-weight: bold;
            margin-bottom: 0px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0px;
        }
        .summary-label {
            font-weight: bold;
        }
        .summary-value {
            border-bottom: 1px solid #000;
            min-width: 60px;
            text-align: right;
        }
        .total-row {
            font-weight: bold;
            font-size: 8px;
        }
        .signature-section {
            margin-top: 1px;
            text-align: center;
        }
        .signature-line {
            border-bottom: 1px solid #000;
            width: 120px;
            margin: 0 auto 0px;
        }
        .tax-info {
            margin-top: 1px;
            text-align: center;
            font-size: 6px;
        }
        .printer-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1px;
            font-size: 4px;
        }
        .printer-table th,
        .printer-table td {
            border: 1px solid #000;
            padding: 0px;
            text-align: center;
        }
        .printer-table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        
        /* Page break control */
        .page-break {
            page-break-before: avoid;
            page-break-after: avoid;
        }
        
        /* Ensure content fits on one page */
        body {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <div class="header page-break">
        <div class="clinic-info">
            <div class="clinic-name">ADULT WELLNESS CLINIC & MEDICAL LABORATORY</div>
            <div class="clinic-address">40 Capitulacion St., Zone 2, Pob. (Consiliman), 2500 Bangued (Capital), Abra, Philippines</div>
            <div class="proprietor">AUGUSTUS CAESAR BUTCH B. BIGORNIA - Prop.</div>
            <div class="tin-info">Non-VAT Reg. TIN: 248-390-356-00000</div>
        </div>
        <div class="invoice-details">
            <div class="invoice-title">SERVICE INVOICE</div>
            <div class="invoice-number">No. <?php echo e($invoiceNumber); ?></div>
            <div class="field-row">
                <div class="field-label">DATE:</div>
                <div class="field-value"><?php echo e($date); ?></div>
            </div>
        </div>
    </div>

    <!-- Customer Information -->
    <div class="customer-section page-break">
        <div class="customer-title">SOLD TO:</div>
        <div class="field-row">
            <div class="field-label"></div>
            <div class="field-value"><?php echo e($billing->patient->first_name); ?> <?php echo e($billing->patient->last_name); ?></div>
        </div>
        <div class="customer-title">TIN:</div>
        <div class="field-row">
            <div class="field-label"></div>
            <div class="field-value"></div>
        </div>
        <div class="customer-title">ADDRESS:</div>
        <div class="field-row">
            <div class="field-label"></div>
            <div class="field-value"><?php echo e($billing->patient->address ?? 'N/A'); ?></div>
        </div>
        <div class="customer-title">SC/PWD/PNSTM/Solo Parent ID No.:</div>
        <div class="field-row">
            <div class="field-label"></div>
            <div class="field-value"></div>
        </div>
        <div class="customer-title">SIGNATURE:</div>
        <div class="field-row">
            <div class="field-label"></div>
            <div class="field-value"></div>
        </div>
    </div>

    <!-- Items Table -->
    <table class="items-table page-break">
        <thead>
            <tr>
                <th class="qty-col">QTY</th>
                <th class="articles-col">ARTICLES</th>
                <th class="unit-col">UNIT COST</th>
                <th class="amount-col">AMOUNT</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $totalAmount = 0;
                $items = [];
                
                // Add consultation fee if exists
                if ($billing->consultation_fee > 0) {
                    $items[] = [
                        'qty' => 1,
                        'description' => 'Medical Consultation',
                        'unit_cost' => $billing->consultation_fee,
                        'amount' => $billing->consultation_fee
                    ];
                    $totalAmount += $billing->consultation_fee;
                }
                
                // Add medication fee if exists
                if ($billing->medication_fee > 0) {
                    $items[] = [
                        'qty' => 1,
                        'description' => 'Medication',
                        'unit_cost' => $billing->medication_fee,
                        'amount' => $billing->medication_fee
                    ];
                    $totalAmount += $billing->medication_fee;
                }
                
                // Add laboratory fee if exists
                if ($billing->laboratory_fee > 0) {
                    $items[] = [
                        'qty' => 1,
                        'description' => 'Laboratory Test',
                        'unit_cost' => $billing->laboratory_fee,
                        'amount' => $billing->laboratory_fee
                    ];
                    $totalAmount += $billing->laboratory_fee;
                }
                
                // Add other fees if exists
                if ($billing->other_fees > 0) {
                    $items[] = [
                        'qty' => 1,
                        'description' => 'Other Services',
                        'unit_cost' => $billing->other_fees,
                        'amount' => $billing->other_fees
                    ];
                    $totalAmount += $billing->other_fees;
                }
                
                // If no specific fees, use the total amount
                if (empty($items)) {
                    $items[] = [
                        'qty' => 1,
                        'description' => 'Medical Service',
                        'unit_cost' => $billing->amount,
                        'amount' => $billing->amount
                    ];
                    $totalAmount = $billing->amount;
                }
            ?>
            
            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($item['qty']); ?></td>
                <td><?php echo e($item['description']); ?></td>
                <td>₱<?php echo e(number_format($item['unit_cost'], 2)); ?></td>
                <td>₱<?php echo e(number_format($item['amount'], 2)); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
            <?php for($i = count($items); $i < 15; $i++): ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?php endfor; ?>
        </tbody>
    </table>

    <!-- Footer Section -->
    <div class="footer-section page-break">
        <div class="payment-methods">
            <div class="payment-title">Payment Method:</div>
            <div class="checkbox-item">
                <input type="checkbox" <?php echo e($billing->status === 'paid' ? 'checked' : ''); ?>> Cash
            </div>
            <div class="checkbox-item">
                <input type="checkbox"> Check
            </div>
            <div class="checkbox-item">
                <input type="checkbox"> Credit
            </div>
            <div class="check-details">
                <div class="check-row">
                    <div class="check-label">Check No:</div>
                    <div class="check-value"></div>
                </div>
                <div class="check-row">
                    <div class="check-label">Date:</div>
                    <div class="check-value"></div>
                </div>
                <div class="check-row">
                    <div class="check-label">BANK:</div>
                    <div class="check-value"></div>
                </div>
            </div>
        </div>
        <div class="summary-section">
            <div class="summary-title">Summary of Charges:</div>
            <div class="summary-row">
                <div class="summary-label">TOTAL SALES:</div>
                <div class="summary-value">₱<?php echo e(number_format($totalAmount, 2)); ?></div>
            </div>
            <div class="summary-row">
                <div class="summary-label">LESS: SC/PWD/NAAC/SP DISC:</div>
                <div class="summary-value">₱0.00</div>
            </div>
            <div class="summary-row">
                <div class="summary-label">TOTAL DUE:</div>
                <div class="summary-value">₱<?php echo e(number_format($totalAmount, 2)); ?></div>
            </div>
            <div class="summary-row">
                <div class="summary-label">LESS: WITHHOLDING:</div>
                <div class="summary-value">₱0.00</div>
            </div>
            <div class="summary-row total-row">
                <div class="summary-label">TOTAL AMOUNT DUE:</div>
                <div class="summary-value">₱<?php echo e(number_format($totalAmount, 2)); ?></div>
            </div>
        </div>
    </div>

    <!-- Signature Section -->
    <div class="signature-section">
        <div class="signature-line"></div>
        <div>Cashier / Authorized Representative</div>
    </div>

    <!-- Tax Information -->
    <div class="tax-info">
        SALE/S SUBJ. TO PT. EXEMPT SALES
    </div>

    <!-- Printer Information Table -->
    <table class="printer-table">
        <thead>
            <tr>
                <th>PJ No.</th>
                <th>NO OF BOOKLETS</th>
                <th>NO OF SETS PER BOOKLETS</th>
                <th>NO OF COPIES PER SET</th>
                <th>SERIAL NO. FROM</th>
                <th>SERIAL NO. TO</th>
                <th>OCN</th>
                <th>DATE OF ATP</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td>40 Bkls</td>
                <td>50</td>
                <td>2x</td>
                <td>000501</td>
                <td>002500</td>
                <td>007AJ20240000001188</td>
                <td>MAY 14, 2024</td>
            </tr>
        </tbody>
    </table>
</body>
</html> <?php /**PATH C:\xampp\htdocs\iWellCare\resources\views\staff\invoice\invoice-pdf.blade.php ENDPATH**/ ?>