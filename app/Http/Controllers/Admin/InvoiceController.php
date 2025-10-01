<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\Patient;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['patient', 'appointment'])->paginate(10);

        return view('admin.invoice.index', compact('invoices'));
    }

    public function create()
    {
        $patients = Patient::all();
        $appointments = Appointment::with('patient')->get();

        return view('admin.invoice.create', compact('patients', 'appointments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'consultation_fee' => 'required|numeric|min:0',
            'medication_fee' => 'nullable|numeric|min:0',
            'laboratory_fee' => 'nullable|numeric|min:0',
            'other_fees' => 'nullable|numeric|min:0',
            'status' => 'required|in:paid,unpaid',
            'payment_date' => 'required|date',
        ]);

        // Calculate total amount
        $total_amount = $request->consultation_fee +
                       ($request->medication_fee ?? 0) +
                       ($request->laboratory_fee ?? 0) +
                       ($request->other_fees ?? 0);

        // Generate invoice number
        $year = date('Y');
        $lastInvoice = Invoice::where('invoice_no', 'like', "INV-{$year}-%")
            ->orderBy('id', 'desc')
            ->first();

        if ($lastInvoice) {
            $lastNumber = intval(substr($lastInvoice->invoice_no, -4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        $invoiceNo = sprintf('INV-%s-%04d', $year, $newNumber);

        Invoice::create([
            'patient_id' => $request->patient_id,
            'appointment_id' => $request->appointment_id,
            'invoice_no' => $invoiceNo,
            'date_issued' => now()->toDateString(),
            'invoice_type' => 'medical_service',
            'article' => 'Medical Services',
            'unit_cost' => $total_amount,
            'quantity' => 1,
            'amount' => $total_amount,
            'consultation_fee' => $request->consultation_fee,
            'medication_fee' => $request->medication_fee ?? 0,
            'laboratory_fee' => $request->laboratory_fee ?? 0,
            'other_fees' => $request->other_fees ?? 0,
            'total_sales' => $total_amount,
            'less_sc' => 0,
            'net_of_sc' => $total_amount,
            'withholding' => 0,
            'grand_total' => $total_amount,
            'status' => $request->status,
            'payment_date' => $request->payment_date,
        ]);

        return redirect()->route('admin.invoice.index')->with('success', 'Invoice created successfully.');
    }

    public function generatePdf(Request $request, $id)
    {
        $invoice = Invoice::with(['patient', 'appointment'])->findOrFail($id);

        // Use the stored invoice number
        $invoiceNumber = $invoice->invoice_no ?? 'INV-'.str_pad($invoice->id, 6, '0', STR_PAD_LEFT);

        $pdf = Pdf::loadView('admin.invoice.invoice-pdf', [
            'invoice' => $invoice,
            'invoiceNumber' => $invoiceNumber,
            'date' => now()->format('M d, Y'),
        ]);

        // Set page size for half letter bond paper (8.5" x 6.5")
        $pdf->setPaper([0, 0, 612, 468], 'portrait'); // 612 x 468 points = 8.5" x 6.5"

        // Set PDF options for better character encoding
        $pdf->getDomPDF()->set_option('isHtml5ParserEnabled', true);
        $pdf->getDomPDF()->set_option('isPhpEnabled', true);

        // If called with stream/print/preview flag, open in browser for printing
        if ($request->has('stream') || $request->has('print') || $request->has('preview')) {
            return $pdf->stream('invoice-'.$invoiceNumber.'.pdf');
        }

        return $pdf->download('invoice-'.$invoiceNumber.'.pdf');
    }

    public function markAsPaid($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->update([
            'status' => 'paid',
            'payment_date' => now(),
        ]);

        return redirect()->route('admin.invoice.index')->with('success', 'Invoice marked as paid successfully.');
    }

    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();

        return redirect()->route('admin.invoice.index')->with('success', 'Invoice deleted successfully.');
    }
}
