<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\Patient;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $patient = $user->patient;

        $invoices = Billing::where('patient_id', $patient->id)
            ->with(['appointment', 'patient'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('patient.invoice.index', compact('invoices'));
    }

    public function show(Billing $invoice)
    {
        $user = auth()->user();
        $patient = $user->patient;

        // Ensure the invoice belongs to the authenticated patient
        if ($invoice->patient_id !== $patient->id) {
            abort(403, 'Unauthorized access.');
        }

        return view('patient.invoice.show', compact('invoice'));
    }

    public function download(Billing $invoice)
    {
        $user = auth()->user();
        $patient = $user->patient;

        // Ensure the invoice belongs to the authenticated patient
        if ($invoice->patient_id !== $patient->id) {
            abort(403, 'Unauthorized access.');
        }

        // Prepare clinic details (to mirror printed invoice format)
        $invoiceNumber = 'INV-'.str_pad($invoice->id, 6, '0', STR_PAD_LEFT);
        $viewData = [
            'billing' => $invoice->load(['patient', 'appointment']),
            'invoiceNumber' => $invoiceNumber,
            'clinicName' => 'ADULT WELLNESS CLINIC & MEDICAL LABORATORY',
            'clinicAddress' => '40 Capitulacion St., Zone 2, Pab. (Consiliman), 2800 Bangued (Capital), Abra, Philippines',
            'proprietor' => 'AUGUSTUS CAESAR BUTCH B. BIGORNIA - Prop.',
            'tin' => '248-390-356-00000',
            'date' => now()->format('M d, Y'),
        ];

        // Generate PDF using the same layout as staff invoice
        $pdf = Pdf::loadView('staff.invoice.invoice-pdf', $viewData);

        // Download the PDF with a filename
        return $pdf->download('invoice-'.$invoiceNumber.'.pdf');
    }
}
