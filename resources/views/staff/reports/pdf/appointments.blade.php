<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        @page {
            margin: 24px 24px 60px 24px;
        }
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #111827;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 10px;
            margin-bottom: 16px;
        }
        .header h1 {
            color: #2563eb;
            margin: 0;
            font-size: 22px;
            font-weight: 700;
        }
        .header p {
            margin: 4px 0;
            color: #6b7280;
        }
        .stats {
            display: flex;
            justify-content: space-between;
            gap: 8px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }
        .stat-box {
            border: 1px solid #e5e7eb;
            padding: 10px;
            text-align: center;
            flex: 1;
            background-color: #f8fafc;
        }
        .stat-box h3 {
            margin: 0;
            color: #1d4ed8;
            font-size: 16px;
            font-weight: 700;
        }
        .stat-box p {
            margin: 4px 0 0 0;
            font-size: 11px;
            color: #6b7280;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
            table-layout: fixed;
        }
        th, td {
            border: 1px solid #e5e7eb;
            padding: 8px;
            text-align: left;
            font-size: 11px;
            word-wrap: break-word;
        }
        th {
            background-color: #2563eb;
            color: #ffffff;
            font-weight: 700;
        }
        tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .status-badge {
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 700;
        }
        .status-pending { background-color: #fde68a; color: #92400e; }
        .status-confirmed { background-color: #bbf7d0; color: #065f46; }
        .status-completed { background-color: #bfdbfe; color: #1e3a8a; }
        .status-cancelled { background-color: #fecaca; color: #7f1d1d; }
        .footer {
            position: fixed;
            bottom: 0;
            left: 24px;
            right: 24px;
            height: 40px;
            text-align: center;
            font-size: 10px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            padding-top: 8px;
        }
        .pagenum:after { content: counter(page) " of " counter(pages); }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>Generated on: {{ $generated_at }}</p>
        <p>iWellCare Healthcare System</p>
    </div>

    <div class="stats">
        <div class="stat-box">
            <h3>{{ $total }}</h3>
            <p>Total Appointments</p>
        </div>
        <div class="stat-box">
            <h3>{{ $confirmed }}</h3>
            <p>Confirmed</p>
        </div>
        <div class="stat-box">
            <h3>{{ $pending }}</h3>
            <p>Pending</p>
        </div>
        <div class="stat-box">
            <h3>{{ $completed }}</h3>
            <p>Completed</p>
        </div>
        <div class="stat-box">
            <h3>{{ $cancelled }}</h3>
            <p>Cancelled</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Patient</th>
                <th>Doctor</th>
                <th>Date & Time</th>
                <th>Type</th>
                <th>Status</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            @forelse($appointments as $appointment)
            <tr>
                <td>
                    <strong>{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</strong><br>
                    <small>{{ $appointment->patient->email }}</small>
                </td>
                <td>
                    <strong>{{ $appointment->doctor->first_name }} {{ $appointment->doctor->last_name }}</strong><br>
                    @if($appointment->doctor->specialization)
                        <small>{{ $appointment->doctor->specialization }}</small>
                    @endif
                </td>
                <td>
                    <strong>{{ $appointment->appointment_date ? \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') : 'N/A' }}</strong><br>
                    <small>{{ $appointment->appointment_time ?? '' }}</small>
                </td>
                <td>{{ $appointment->appointment_type ? $appointment->appointment_type : 'General' }}</td>
                <td>
                    <span class="status-badge status-{{ $appointment->status }}">
                        {{ ucfirst($appointment->status) }}
                    </span>
                </td>
                <td>
                    @if($appointment->notes)
                        {{ Str::limit($appointment->notes, 50) }}
                    @else
                        <em>No notes</em>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">No appointments found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>This report was generated automatically by the iWellCare Healthcare System. Page <span class="pagenum"></span></p>
    </div>
</body>
</html> 