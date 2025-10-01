<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Report</title>
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
            border-bottom: 2px solid #2563eb;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #2563eb;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .stats-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            border: 1px solid #ddd;
        }
        .stats-table th, .stats-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        .stats-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            font-size: 11px;
        }
        .stat-number {
            font-size: 18px;
            font-weight: bold;
            color: #2563eb;
        }
        .stat-label {
            font-size: 10px;
            color: #666;
            margin-top: 2px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border: 1px solid #ddd;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 10px;
            vertical-align: top;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            text-align: center;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tbody tr:hover {
            background-color: #f5f5f5;
        }
        .status-out {
            background-color: #fee2e2;
            color: #dc2626;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 9px;
        }
        .status-low {
            background-color: #fef3c7;
            color: #d97706;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 9px;
        }
        .status-in {
            background-color: #dcfce7;
            color: #16a34a;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 9px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Inventory Report</h1>
        <p>iWellCare Medical Clinic</p>
        <p>Generated on: {{ now()->format('F d, Y \a\t g:i A') }}</p>
    </div>

    <!-- Statistics Overview -->
    <table class="stats-table">
        <thead>
            <tr>
                <th>Total Items</th>
                <th>Low Stock</th>
                <th>Out of Stock</th>
                <th>Expiring Soon</th>
                <th>Total Value</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><div class="stat-number">{{ $inventoryStats['total'] }}</div></td>
                <td><div class="stat-number">{{ $inventoryStats['low_stock'] }}</div></td>
                <td><div class="stat-number">{{ $inventoryStats['out_of_stock'] }}</div></td>
                <td><div class="stat-number">{{ $inventoryStats['expiring_soon'] }}</div></td>
                <td><div class="stat-number">&#8369;{{ number_format($inventoryStats['total_value'], 2) }}</div></td>
            </tr>
        </tbody>
    </table>

    <!-- Inventory Table -->
    <h2 style="margin-top: 30px; margin-bottom: 15px; color: #2563eb; border-bottom: 1px solid #ddd; padding-bottom: 5px;">Inventory Items</h2>
    <table>
        <thead>
            <tr>
                <th style="width: 20%;">Item Name</th>
                <th style="width: 10%;">Category</th>
                <th style="width: 8%;">Quantity</th>
                <th style="width: 10%;">Unit Price</th>
                <th style="width: 12%;">Total Value</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 15%;">Supplier</th>
                <th style="width: 15%;">Last Updated</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventory as $item)
            <tr>
                <td>
                    <strong>{{ $item->name }}</strong><br>
                    <small>{{ Str::limit($item->description, 30) }}</small>
                </td>
                <td>{{ ucfirst($item->category) }}</td>
                <td>
                    {{ $item->quantity }} {{ $item->unit }}
                    @if($item->quantity <= $item->reorder_level)
                        <br><small style="color: #dc2626;">Reorder: {{ $item->reorder_level }}</small>
                    @endif
                </td>
                <td>&#8369;{{ number_format($item->unit_price, 2) }}</td>
                <td><strong>&#8369;{{ number_format($item->quantity * $item->unit_price, 2) }}</strong></td>
                <td>
                    @if($item->quantity <= 0)
                        <span class="status-out">Out of Stock</span>
                    @elseif($item->quantity <= $item->reorder_level)
                        <span class="status-low">Low Stock</span>
                    @else
                        <span class="status-in">In Stock</span>
                    @endif
                </td>
                <td>{{ $item->supplier ? $item->supplier : 'Not specified' }}</td>
                <td>
                    {{ $item->updated_at ? $item->updated_at->format('M d, Y') : 'Never' }}
                    @if($item->updatedBy)
                        <br><small>by {{ $item->updatedBy->name }}</small>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p><strong>Report Generated:</strong> {{ now()->format('F d, Y \a\t g:i A') }}</p>
        <p><strong>Generated by:</strong> iWellCare Medical Clinic Management System</p>
        <p style="margin-top: 10px; font-style: italic;">This is an official inventory report. For questions or concerns, please contact the clinic administration.</p>
    </div>
</body>
</html> 