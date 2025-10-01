<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #888; padding: 6px; text-align: left; }
        th { background: #f0f0f0; }
    </style>
</head>
<body>
    <h2>Medical Records Report</h2>
    <table>
        <thead>
            <tr>
                <th>Patient</th>
                <th>Type</th>
                <th>Date</th>
                <th>Doctor</th>
            </tr>
        </thead>
        <tbody>
            @foreach($medicalRecords as $record)
                <tr>
                    <td>{{ $record->patient->first_name ?? '-' }} {{ $record->patient->last_name ?? '' }}</td>
                    <td>{{ ucfirst($record->record_type) }}</td>
                    <td>{{ $record->record_date ? $record->record_date->format('Y-m-d') : '-' }}</td>
                    <td>{{ $record->doctor->first_name ?? '-' }} {{ $record->doctor->last_name ?? '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html> 