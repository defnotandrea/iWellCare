<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    /**
     * Display the invoice creation form
     */
    public function create(): View
    {
        return view('invoices.create');
    }

    /**
     * Store a new invoice
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'invoiceNumber' => 'required|string|max:50',
            'date' => 'required|date',
            'customerName' => 'required|string|max:255',
            'customerTin' => 'nullable|string|max:50',
            'customerAddress' => 'required|string|max:500',
            'customerId' => 'nullable|string|max:100',
            'customerSignature' => 'nullable|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.quantity' => 'required|numeric|min:0',
            'items.*.description' => 'required|string|max:255',
            'items.*.unitCost' => 'required|numeric|min:0',
            'items.*.amount' => 'required|numeric|min:0',
            'totalSales' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'totalDue' => 'required|numeric|min:0',
            'withholding' => 'nullable|numeric|min:0',
            'totalAmountDue' => 'required|numeric|min:0',
            'exemptSales' => 'nullable|numeric|min:0',
            'paymentMethod' => 'required|in:cash,check,credit',
            'checkNumber' => 'nullable|required_if:paymentMethod,check|string|max:100',
            'checkDate' => 'nullable|required_if:paymentMethod,check|date',
            'bank' => 'nullable|required_if:paymentMethod,check|string|max:100',
            'cashierName' => 'required|string|max:255',
        ]);

        // Here you would typically save to database
        // For now, we'll just return success

        return response()->json([
            'success' => true,
            'message' => 'Invoice created successfully',
            'invoice' => $validated,
        ]);
    }

    /**
     * Display the specified invoice
     */
    public function show(string $id): View
    {
        // Mock invoice data - in real app, fetch from database
        $invoice = [
            'id' => $id,
            'invoiceNumber' => '0001635',
            'date' => now()->format('M d, Y'),
            'customerName' => 'Sample Customer',
            'customerTin' => '123-456-789-000',
            'customerAddress' => 'Sample Address',
            'customerId' => 'ID-001',
            'customerSignature' => 'Sample Signature',
            'items' => [
                ['quantity' => 1, 'description' => 'Sample Service', 'unit_cost' => 100.00, 'amount' => 100.00],
            ],
            'totalSales' => 100.00,
            'discount' => 0.00,
            'totalDue' => 100.00,
            'withholding' => 0.00,
            'totalAmountDue' => 100.00,
            'exemptSales' => 0.00,
            'paymentMethod' => 'cash',
            'checkNumber' => '',
            'checkDate' => '',
            'bank' => '',
            'cashierName' => 'Sample Cashier',
        ];

        return view('invoices.show', compact('invoice'));
    }

    /**
     * Display the invoice edit form
     */
    public function edit(string $id): View
    {
        // Mock invoice data - in real app, fetch from database
        $invoice = [
            'id' => $id,
            'invoiceNumber' => '0001635',
            'date' => now()->format('M d, Y'),
            'customerName' => 'Sample Customer',
            'customerTin' => '123-456-789-000',
            'customerAddress' => 'Sample Address',
            'customerId' => 'ID-001',
            'customerSignature' => 'Sample Signature',
            'items' => [
                ['quantity' => 1, 'description' => 'Sample Service', 'unit_cost' => 100.00, 'amount' => 100.00],
            ],
            'totalSales' => 100.00,
            'discount' => 0.00,
            'totalDue' => 100.00,
            'withholding' => 0.00,
            'totalAmountDue' => 100.00,
            'exemptSales' => 0.00,
            'paymentMethod' => 'cash',
            'checkNumber' => '',
            'checkDate' => '',
            'bank' => '',
            'cashierName' => 'Sample Cashier',
        ];

        return view('invoices.edit', compact('invoice'));
    }

    /**
     * Update the specified invoice
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $validated = $request->validate([
            'invoiceNumber' => 'required|string|max:50',
            'date' => 'required|date',
            'customerName' => 'required|string|max:255',
            'customerTin' => 'nullable|string|max:50',
            'customerAddress' => 'required|string|max:500',
            'customerId' => 'nullable|string|max:100',
            'customerSignature' => 'nullable|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.quantity' => 'required|numeric|min:0',
            'items.*.description' => 'required|string|max:255',
            'items.*.unitCost' => 'required|numeric|min:0',
            'items.*.amount' => 'required|numeric|min:0',
            'totalSales' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'totalDue' => 'required|numeric|min:0',
            'withholding' => 'nullable|numeric|min:0',
            'totalAmountDue' => 'required|numeric|min:0',
            'exemptSales' => 'nullable|numeric|min:0',
            'paymentMethod' => 'required|in:cash,check,credit',
            'checkNumber' => 'nullable|required_if:paymentMethod,check|string|max:100',
            'checkDate' => 'nullable|required_if:paymentMethod,check|date',
            'bank' => 'nullable|required_if:payment_if:paymentMethod,check|string|max:100',
            'cashierName' => 'required|string|max:255',
        ]);

        // Here you would typically update in database
        // For now, we'll just return success

        return response()->json([
            'success' => true,
            'message' => 'Invoice updated successfully',
            'invoice' => $validated,
        ]);
    }

    /**
     * Remove the specified invoice
     */
    public function destroy(string $id): JsonResponse
    {
        // Here you would typically delete from database
        // For now, we'll just return success

        return response()->json([
            'success' => true,
            'message' => 'Invoice deleted successfully',
        ]);
    }

    /**
     * Generate PDF for the invoice
     */
    public function generatePdf(string $id): JsonResponse
    {
        // Here you would typically generate PDF
        // For now, we'll just return success

        return response()->json([
            'success' => true,
            'message' => 'PDF generated successfully',
            'downloadUrl' => '/invoices/'.$id.'/download-pdf',
        ]);
    }

    /**
     * Download the generated PDF
     */
    public function downloadPdf(string $id)
    {
        // Here you would typically return the PDF file
        // For now, we'll just return a response

        return response()->json([
            'success' => true,
            'message' => 'PDF download would be implemented here',
        ]);
    }
}
