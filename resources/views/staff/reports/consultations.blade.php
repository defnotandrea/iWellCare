@extends('layouts.app')

@section('title', 'Consultations Report')

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
    }

    /* Bootstrap layout fixes */
    .container-fluid, .row, .col-12, .col-xl-3, .col-md-6, .col-lg-3 {
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        float: none !important;
        display: block !important;
    }

    /* Table styling */
    table {
        font-size: 11px !important;
        width: 100% !important;
        margin-bottom: 20px !important;
    }

    th, td {
        padding: 6px !important;
        border: 1px solid #ddd !important;
    }

    /* Page breaks */
    .page-break {
        page-break-before: always;
    }

    /* Print header */
    .print-header {
        text-align: center;
        border-bottom: 2px solid #007bff;
        padding-bottom: 20px;
        margin-bottom: 30px;
    }

    .print-header h1 {
        color: #007bff;
        margin: 0;
        font-size: 24px;
    }

    /* Hide pagination links */
    .pagination, .d-flex.justify-content-center {
        display: none !important;
    }
}
</style>
@endpush

@section('content')
@if(request('print'))
<div class="print-header">
    <h1>Consultations Report</h1>
    <p><strong>Generated:</strong> {{ \Carbon\Carbon::now()->format('F d, Y \a\t g:i A') }}</p>
    <p><strong>iWellCare Healthcare System</strong></p>
</div>
@endif
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-stethoscope me-2"></i>Consultations Report
                    </h1>
                    <p class="text-muted mb-0">View and analyze consultation data</p>
                </div>
                <div>
                    <button type="button" class="btn btn-success me-2" onclick="exportReport()">
                        <i class="fas fa-file-pdf me-2"></i>Export PDF
                    </button>
                    <button type="button" class="btn btn-info me-2 no-print" onclick="printReport()">
                        <i class="fas fa-print me-2"></i>Print Report
                    </button>
                    <a href="{{ route('staff.reports.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Reports
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Filter Options</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('staff.reports.consultations') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="date_from" class="form-label">Date From</label>
                    <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-3">
                    <label for="date_to" class="form-label">Date To</label>
                    <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid gap-2 d-md-flex">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>Filter
                        </button>
                        <a href="{{ route('staff.reports.consultations') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Consultations
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $consultations->total() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-stethoscope fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Completed
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $consultations->where('status', 'completed')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                In Progress
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $consultations->where('status', 'in_progress')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Pending
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $consultations->where('status', 'pending')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Consultations Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Consultations</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Diagnosis</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($consultations as $consultation)
                        <tr>
                            <td>
                                <strong>{{ $consultation->patient->first_name }} {{ $consultation->patient->last_name }}</strong>
                                <br><small class="text-muted">{{ $consultation->patient->email }}</small>
                            </td>
                            <td>
                                <strong>{{ $consultation->doctor->first_name }} {{ $consultation->doctor->last_name }}</strong>
                                @if($consultation->doctor->specialization)
                                    <br><small class="text-muted">{{ $consultation->doctor->specialization }}</small>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $consultation->created_at->format('M d, Y') }}</strong>
                                <br><small class="text-muted">{{ $consultation->created_at->format('H:i') }}</small>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $consultation->consultation_type ? $consultation->consultation_type : 'General' }}</span>
                            </td>
                            <td>
                                @switch($consultation->status)
                                    @case('pending')
                                        <span class="badge bg-warning">Pending</span>
                                        @break
                                    @case('in_progress')
                                        <span class="badge bg-info">In Progress</span>
                                        @break
                                    @case('completed')
                                        <span class="badge bg-success">Completed</span>
                                        @break
                                    @case('cancelled')
                                        <span class="badge bg-danger">Cancelled</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">{{ ucfirst($consultation->status) }}</span>
                                @endswitch
                            </td>
                            <td>
                                @if($consultation->diagnosis)
                                    <small class="text-muted">{{ Str::limit($consultation->diagnosis, 50) }}</small>
                                @else
                                    <small class="text-muted">No diagnosis</small>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('staff.consultations.show', $consultation) }}" 
                                   class="btn btn-sm btn-outline-primary" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No consultations found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $consultations->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Export Form (Hidden) -->
<form id="exportForm" method="POST" action="{{ route('staff.reports.export') }}" style="display: none;">
    @csrf
    <input type="hidden" name="type" value="consultations">
    <input type="hidden" name="format" value="pdf">
    <input type="hidden" name="status" value="{{ request('status') }}">
    <input type="hidden" name="date_from" value="{{ request('date_from') }}">
    <input type="hidden" name="date_to" value="{{ request('date_to') }}">
</form>

<script>
function exportReport() {
    // Update form values with current filter values
    document.querySelector('#exportForm input[name="status"]').value = '{{ request('status') }}';
    document.querySelector('#exportForm input[name="date_from"]').value = '{{ request('date_from') }}';
    document.querySelector('#exportForm input[name="date_to"]').value = '{{ request('date_to') }}';

    // Submit the form
    document.getElementById('exportForm').submit();
}

function printReport() {
    window.print();
}
</script>
@endsection 