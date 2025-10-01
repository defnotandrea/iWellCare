<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Report</title>
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
        <h1>Patient Report</h1>
        <p><strong>Clinic:</strong> Adult Wellness Clinic and Medical Laboratory</p>
        <p><strong>Generated:</strong> {{ \Carbon\Carbon::now()->format('F d, Y \a\t g:i A') }}</p>
        <p><strong>iWellCare Healthcare System</strong></p>
    </div>

    <!-- Patient Statistics -->
    <div class="section">
        <h2>Patient Statistics</h2>
        <div class="stats-grid">
            <div class="stats-row">
                <div class="stats-cell">
                    <h3>{{ $patientStats['total'] }}</h3>
                    <p>Total Patients</p>
                </div>
                <div class="stats-cell">
                    <h3>{{ $patientStats['active'] }}</h3>
                    <p>Active Patients</p>
                </div>
                <div class="stats-cell">
                    <h3>{{ $patientStats['inactive'] }}</h3>
                    <p>Inactive Patients</p>
                </div>
                <div class="stats-cell">
                    <h3>{{ $patientStats['new_this_month'] }}</h3>
                    <p>New This Month</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Patients List -->
    <div class="section">
        <h2>Patient List ({{ $patients->count() }} total)</h2>
        @if($patients->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Patient Name</th>
                        <th>Contact</th>
                        <th>Age/Gender</th>
                        <th>Status</th>
                        <th>Consultations</th>
                        <th>Appointments</th>
                        <th>Last Visit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($patients as $patient)
                    <tr>
                        <td>
                            <strong>{{ $patient->first_name }} {{ $patient->last_name }}</strong><br>
                            <small class="text-muted">ID: #{{ $patient->id }}</small>
                        </td>
                        <td>
                            <strong>{{ $patient->contact }}</strong><br>
                            <small class="text-muted">{{ $patient->email ?? 'No email' }}</small>
                        </td>
                        <td class="text-center">
                            @if($patient->age)
                                <strong>{{ $patient->age }} years</strong><br>
                                <small class="text-muted">{{ ucfirst($patient->gender ?? 'N/A') }}</small>
                            @else
                                <small class="text-muted">Not specified</small>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-{{ $patient->is_active ? 'success' : 'secondary' }}">
                                {{ $patient->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="text-center">{{ $patient->consultations->count() }}</td>
                        <td class="text-center">{{ $patient->appointments->count() }}</td>
                        <td>
                            @php
                                $lastConsultation = $patient->consultations->sortByDesc('consultation_date')->first();
                                $lastAppointment = $patient->appointments->sortByDesc('appointment_date')->first();
                                
                                $lastVisit = null;
                                if ($lastConsultation && $lastAppointment) {
                                    $lastVisit = $lastConsultation->consultation_date > $lastAppointment->appointment_date 
                                        ? $lastConsultation->consultation_date 
                                        : $lastAppointment->appointment_date;
                                } elseif ($lastConsultation) {
                                    $lastVisit = $lastConsultation->consultation_date;
                                } elseif ($lastAppointment) {
                                    $lastVisit = $lastAppointment->appointment_date;
                                }
                            @endphp
                            <small class="text-muted">
                                {{ $lastVisit ? $lastVisit->format('M d, Y') : 'No visits' }}
                            </small>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted">No patients found</p>
        @endif
    </div>

    <div class="footer">
        <p>This report was generated automatically by the iWellCare Healthcare System.</p>
        <p>For questions or support, please contact your system administrator.</p>
    </div>
</body>
</html> 