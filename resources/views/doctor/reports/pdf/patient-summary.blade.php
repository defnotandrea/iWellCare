<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Summary Report</title>
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
        .chart-container {
            margin: 20px 0;
            text-align: center;
        }
        .chart-bar {
            display: inline-block;
            width: 60px;
            margin: 0 5px;
            text-align: center;
        }
        .chart-bar-fill {
            background-color: #007bff;
            height: 100px;
            margin-bottom: 5px;
            position: relative;
        }
        .chart-bar-label {
            font-size: 10px;
            color: #666;
        }
        .chart-bar-value {
            font-size: 11px;
            font-weight: bold;
            color: #007bff;
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
        <h1>Patient Summary Report</h1>
        <p><strong>Generated:</strong> {{ \Carbon\Carbon::now()->format('F d, Y \a\t g:i A') }}</p>
        <p><strong>iWellCare Healthcare System</strong></p>
    </div>

    <!-- Patient Statistics -->
    <div class="section">
        <h2>Patient Overview</h2>
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

    <!-- Patient Distribution Chart -->
    <div class="section">
        <h2>Patient Distribution</h2>
        <div class="chart-container">
            @php
                $total = $patientStats['total'];
                $active = $patientStats['active'];
                $inactive = $patientStats['inactive'];
                $new = $patientStats['new_this_month'];
                
                $activeHeight = $total > 0 ? ($active / $total) * 100 : 0;
                $inactiveHeight = $total > 0 ? ($inactive / $total) * 100 : 0;
                $newHeight = $total > 0 ? ($new / $total) * 100 : 0;
            @endphp
            
            <div class="chart-bar">
                <div class="chart-bar-fill" style="height: {{ $activeHeight }}px; background-color: #28a745;"></div>
                <div class="chart-bar-value">{{ $active }}</div>
                <div class="chart-bar-label">Active</div>
            </div>
            <div class="chart-bar">
                <div class="chart-bar-fill" style="height: {{ $inactiveHeight }}px; background-color: #6c757d;"></div>
                <div class="chart-bar-value">{{ $inactive }}</div>
                <div class="chart-bar-label">Inactive</div>
            </div>
            <div class="chart-bar">
                <div class="chart-bar-fill" style="height: {{ $newHeight }}px; background-color: #ffc107;"></div>
                <div class="chart-bar-value">{{ $new }}</div>
                <div class="chart-bar-label">New</div>
            </div>
        </div>
    </div>

    <!-- Top Patients by Consultations -->
    <div class="section">
        <h2>Top Patients by Consultations</h2>
        @php
            $topPatients = $patients->sortByDesc(function($patient) {
                return $patient->consultations->count();
            })->take(10);
        @endphp
        
        @if($topPatients->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Patient Name</th>
                        <th>Consultations</th>
                        <th>Appointments</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topPatients as $index => $patient)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td><strong>{{ $patient->first_name }} {{ $patient->last_name }}</strong></td>
                        <td class="text-center">{{ $patient->consultations->count() }}</td>
                        <td class="text-center">{{ $patient->appointments->count() }}</td>
                        <td>
                            <span class="badge badge-{{ $patient->is_active ? 'success' : 'secondary' }}">
                                {{ $patient->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted">No patient data available</p>
        @endif
    </div>

    <div class="footer">
        <p>This report was generated automatically by the iWellCare Healthcare System.</p>
        <p>For questions or support, please contact your system administrator.</p>
    </div>
</body>
</html> 