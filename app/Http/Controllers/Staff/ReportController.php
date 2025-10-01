<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Consultation;
use App\Models\Inventory;
use App\Models\MedicalRecord;
use App\Models\Patient;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $medicalRecords = MedicalRecord::with(['patient', 'doctor'])
            ->orderBy('record_date', 'desc')
            ->paginate(10);
        $consultations = Consultation::with(['patient', 'doctor'])
            ->orderBy('consultation_date', 'desc')
            ->paginate(10);

        return view('staff.reports.index', compact('medicalRecords', 'consultations'));
    }

    public function print($id)
    {
        // Logic to print report (PDF or view)
        return redirect()->route('staff.reports.index')->with('success', 'Report printed.');
    }

    public function exportPdf()
    {
        $medicalRecords = MedicalRecord::with(['patient', 'doctor'])
            ->orderBy('record_date', 'desc')
            ->get();
        $pdf = Pdf::loadView('staff.reports.export_pdf', compact('medicalRecords'));

        return $pdf->download('medical_records_report.pdf');
    }

    /**
     * Generate inventory report.
     */
    public function inventory(Request $request)
    {
        $inventory = Inventory::with('updatedBy')
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('name', 'like', '%'.$request->search.'%')
                        ->orWhere('description', 'like', '%'.$request->search.'%')
                        ->orWhere('supplier', 'like', '%'.$request->search.'%');
                });
            })
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->where('category', $request->category);
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                switch ($request->status) {
                    case 'low_stock':
                        $query->whereRaw('quantity <= reorder_level');
                        break;
                    case 'out_of_stock':
                        $query->where('quantity', '<=', 0);
                        break;
                    case 'expiring':
                        $query->where('expiration_date', '<=', now()->addDays(30))
                            ->where('expiration_date', '>', now());
                        break;
                }
            })
            ->orderBy('name')
            ->paginate(15);

        $inventoryStats = [
            'total' => Inventory::count(),
            'low_stock' => Inventory::whereRaw('quantity <= reorder_level')->count(),
            'out_of_stock' => Inventory::where('quantity', '<=', 0)->count(),
            'expiring_soon' => Inventory::where('expiration_date', '<=', now()->addDays(30))
                ->where('expiration_date', '>', now())->count(),
            'total_value' => Inventory::sum(DB::raw('quantity * unit_price')),
        ];

        $categories = Inventory::distinct()->pluck('category')->filter();

        return view('staff.reports.inventory-report', compact('inventory', 'inventoryStats', 'categories'));
    }

    /**
     * Export inventory report to PDF.
     */
    public function exportInventoryPdf(Request $request)
    {
        try {
            $inventory = Inventory::with('updatedBy')
                ->when($request->filled('search'), function ($query) use ($request) {
                    $query->where(function ($q) use ($request) {
                        $q->where('name', 'like', '%'.$request->search.'%')
                            ->orWhere('description', 'like', '%'.$request->search.'%')
                            ->orWhere('supplier', 'like', '%'.$request->search.'%');
                    });
                })
                ->when($request->filled('category'), function ($query) use ($request) {
                    $query->where('category', $request->category);
                })
                ->when($request->filled('status'), function ($query) use ($request) {
                    switch ($request->status) {
                        case 'low_stock':
                            $query->whereRaw('quantity <= reorder_level');
                            break;
                        case 'out_of_stock':
                            $query->where('quantity', '<=', 0);
                            break;
                        case 'expiring':
                            $query->where('expiration_date', '<=', now()->addDays(30))
                                ->where('expiration_date', '>', now());
                            break;
                    }
                })
                ->orderBy('name')
                ->get();

            $inventoryStats = [
                'total' => Inventory::count(),
                'low_stock' => Inventory::whereRaw('quantity <= reorder_level')->count(),
                'out_of_stock' => Inventory::where('quantity', '<=', 0)->count(),
                'expiring_soon' => Inventory::where('expiration_date', '<=', now()->addDays(30))
                    ->where('expiration_date', '>', now())->count(),
                'total_value' => Inventory::sum(DB::raw('quantity * unit_price')),
            ];

            $pdf = Pdf::loadView('staff.reports.pdf.inventory', compact('inventory', 'inventoryStats'));
            $pdf->setPaper('A4', 'portrait');

            return $pdf->download('inventory-report.pdf');

        } catch (\Exception $e) {
            return redirect()->route('staff.reports.index')->with('error', 'Error generating PDF: '.$e->getMessage());
        }
    }

    /**
     * Generate appointments report.
     */
    public function appointments()
    {
        $appointments = Appointment::with(['patient', 'doctor'])
            ->orderBy('appointment_date', 'desc')
            ->paginate(15);

        return view('staff.reports.appointments', compact('appointments'));
    }

    /**
     * Generate consultations report.
     */
    public function consultations()
    {
        $consultations = Consultation::with(['patient', 'doctor'])
            ->orderBy('consultation_date', 'desc')
            ->paginate(15);

        return view('staff.reports.consultations', compact('consultations'));
    }

    /**
     * Generate patients report.
     */
    public function patients()
    {
        $patients = Patient::with(['consultations', 'appointments'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $patientStats = [
            'total' => Patient::count(),
            'active' => Patient::where('is_active', true)->count(),
            'inactive' => Patient::where('is_active', false)->count(),
            'new_this_month' => Patient::whereMonth('created_at', now()->month)->count(),
        ];

        return view('staff.reports.patients', compact('patients', 'patientStats'));
    }
}
