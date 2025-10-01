<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation Report</title>
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
        <h1>Consultation Report</h1>
        <p><strong>Clinic:</strong> Adult Wellness Clinic and Medical Laboratory</p>
        <p><strong>Period:</strong> {{ \Carbon\Carbon::parse($startDate)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}</p>
        <p><strong>Generated:</strong> {{ \Carbon\Carbon::now()->format('F d, Y \a\t g:i A') }}</p>
        <p><strong>iWellCare Healthcare System</strong></p>
    </div>

    <!-- Consultation Statistics -->
    <div class="section">
        <h2>Consultation Statistics</h2>
        <div class="stats-grid">
            <div class="stats-row">
                <div class="stats-cell">
                    <h3>{{ $consultationStats['total'] }}</h3>
                    <p>Total Consultations</p>
                </div>
                <div class="stats-cell">
                    <h3>{{ $consultationStats['completed'] }}</h3>
                    <p>Completed</p>
                </div>
                <div class="stats-cell">
                    <h3>{{ $consultationStats['in_progress'] }}</h3>
                    <p>In Progress</p>
                </div>
                <div class="stats-cell">
                    <h3>{{ $consultationStats['average_duration'] }}</h3>
                    <p>Avg Duration</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Completion Rate -->
    <div class="section">
        <h2>Completion Rate Analysis</h2>
        @php
            $total = $consultationStats['total'];
            $completed = $consultationStats['completed'];
            $inProgress = $consultationStats['in_progress'];
            
            $completionRate = $total > 0 ? round(($completed / $total) * 100, 1) : 0;
            $inProgressRate = $total > 0 ? round(($inProgress / $total) * 100, 1) : 0;
        @endphp
        
        <div style="margin: 20px 0;">
            <div style="margin-bottom: 10px;">
                <strong>Completion Rate:</strong> {{ $completionRate }}% ({{ $completed }} of {{ $total }})
            </div>
            <div style="margin-bottom: 10px;">
                <strong>In Progress Rate:</strong> {{ $inProgressRate }}% ({{ $inProgress }} of {{ $total }})
            </div>
        </div>
    </div>

    <!-- Consultations List -->
    <div class="section">
        <h2>Consultations List ({{ $consultations->count() }} total)</h2>
        @if($consultations->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Patient Name</th>
                        <th>Doctor</th>
                        <th>Status</th>
                        <th>Duration</th>
                        <th>Diagnosis</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($consultations as $consultation)
                    <tr>
                        <td>
                            <strong>{{ $consultation->consultation_date->format('M d, Y') }}</strong><br>
                            <small class="text-muted">{{ $consultation->consultation_date->format('g:i A') }}</small>
                        </td>
                        <td>
                            <strong>{{ $consultation->patient->first_name }} {{ $consultation->patient->last_name }}</strong><br>
                            <small class="text-muted">ID: #{{ $consultation->patient->id }}</small>
                        </td>
                        <td>
                            <strong>{{ $consultation->doctor->first_name ?? 'N/A' }}</strong><br>
                            <small class="text-muted">{{ $consultation->doctor->role ?? 'N/A' }}</small>
                        </td>
                        <td>
                            <span class="badge badge-{{ $consultation->status === 'completed' ? 'success' : ($consultation->status === 'in_progress' ? 'warning' : 'secondary') }}">
                                {{ ucfirst(str_replace('_', ' ', $consultation->status)) }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if($consultationStats['average_duration'])
                                {{ $consultationStats['average_duration'] }}
                            @else
                                <small class="text-muted">N/A</small>
                            @endif
                        </td>
                        <td>{{ Str::limit($consultation->diagnosis ?? 'No diagnosis', 50) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted">No consultations found for the selected date range</p>
        @endif
    </div>

    <div class="footer">
        <p>This report was generated automatically by the iWellCare Healthcare System.</p>
        <p>For questions or support, please contact your system administrator.</p>
    </div>
</body>
</html> 