<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Sales Report - {{ \Carbon\Carbon::parse($month)->format('F Y') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #007bff;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        .stats-row {
            display: table-row;
        }
        .stats-cell {
            display: table-cell;
            width: 25%;
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
            background-color: #f8f9fa;
            vertical-align: middle;
        }
        .stats-cell h3 {
            margin: 0;
            font-size: 18px;
            color: #007bff;
        }
        .stats-cell p {
            margin: 5px 0;
            font-size: 11px;
            color: #666;
        }
        .section {
            margin-bottom: 30px;
        }
        .section h2 {
            color: #007bff;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .text-muted {
            color: #666;
        }
        .badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-success {
            background-color: #28a745;
            color: white;
        }
        .badge-warning {
            background-color: #ffc107;
            color: #212529;
        }
        .badge-secondary {
            background-color: #6c757d;
            color: white;
        }
        .page-break {
            page-break-before: always;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Monthly Sales Report</h1>
        <p><strong>Clinic:</strong> Adult Wellness Clinic and Medical Laboratory</p>
        <p><strong>Period:</strong> {{ \Carbon\Carbon::parse($month)->format('F Y') }}</p>
        <p><strong>Generated:</strong> {{ \Carbon\Carbon::now()->format('F d, Y \a\t g:i A') }}</p>
        <p><strong>iWellCare Healthcare System</strong></p>
    </div>

    <!-- Sales Summary -->
    <div class="section">
        <h2>Sales Summary</h2>
        <div class="stats-grid">
            <div class="stats-row">
                <div class="stats-cell">
                    <h3>₱{{ number_format($salesData['total_revenue'], 2) }}</h3>
                    <p>Total Revenue</p>
                </div>
                <div class="stats-cell">
                    <h3>{{ $salesData['total_consultations'] }}</h3>
                    <p>Consultations</p>
                </div>
                <div class="stats-cell">
                    <h3>{{ $salesData['total_appointments'] }}</h3>
                    <p>Appointments</p>
                </div>
                <div class="stats-cell">
                    <h3>{{ $salesData['new_patients'] }}</h3>
                    <p>New Patients</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Daily Revenue Breakdown -->
    <div class="section">
        <h2>Daily Revenue Breakdown</h2>
        @if($salesData['daily_revenue']->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Consultations</th>
                        <th>Revenue</th>
                        <th>Average per Consultation</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($salesData['daily_revenue'] as $daily)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($daily['date'])->format('M d, Y (D)') }}</td>
                        <td class="text-center">{{ $daily['revenue'] / 500 }}</td>
                        <td class="text-right"><strong>₱{{ number_format($daily['revenue'], 2) }}</strong></td>
                        <td class="text-right">₱500.00</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted">No revenue data available for this month</p>
        @endif
    </div>

    <div class="page-break"></div>

    <!-- Appointments -->
    <div class="section">
        <h2>Appointments ({{ $appointments->count() }})</h2>
        @if($appointments->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Patient Name</th>
                        <th>Contact</th>
                        <th>Status</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->appointment_date->format('M d, Y') }}</td>
                        <td><strong>{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</strong></td>
                        <td>{{ $appointment->patient->contact }}</td>
                        <td>
                            <span class="badge badge-{{ $appointment->status === 'confirmed' ? 'success' : ($appointment->status === 'pending' ? 'warning' : 'secondary') }}">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </td>
                        <td>{{ $appointment->appointment_time ?? 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted">No appointments for this month</p>
        @endif
    </div>

    <!-- Consultations -->
    <div class="section">
        <h2>Consultations ({{ $consultations->count() }})</h2>
        @if($consultations->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Patient Name</th>
                        <th>Doctor</th>
                        <th>Status</th>
                        <th>Diagnosis</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($consultations as $consultation)
                    <tr>
                        <td>{{ $consultation->consultation_date->format('M d, Y') }}</td>
                        <td><strong>{{ $consultation->patient->first_name }} {{ $consultation->patient->last_name }}</strong></td>
                        <td>{{ $consultation->doctor->first_name ?? 'N/A' }}</td>
                        <td>
                            <span class="badge badge-{{ $consultation->status === 'completed' ? 'success' : ($consultation->status === 'in_progress' ? 'warning' : 'secondary') }}">
                                {{ ucfirst($consultation->status) }}
                            </span>
                        </td>
                        <td>{{ Str::limit($consultation->diagnosis ?? 'No diagnosis', 50) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted">No consultations for this month</p>
        @endif
    </div>

    <div class="footer">
        <p>This report was generated automatically by the iWellCare Healthcare System.</p>
        <p>For questions or support, please contact your system administrator.</p>
    </div>
</body>
</html> 