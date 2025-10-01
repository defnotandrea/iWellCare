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
            width: 20%;
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
        .badge-danger {
            background-color: #dc3545;
            color: white;
        }
        .badge-secondary {
            background-color: #6c757d;
            color: white;
        }
        .badge-info {
            background-color: #17a2b8;
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
        <h1>Inventory Report</h1>
        <p><strong>Clinic:</strong> Adult Wellness Clinic and Medical Laboratory</p>
        <p><strong>Generated:</strong> {{ \Carbon\Carbon::now()->format('F d, Y \a\t g:i A') }}</p>
        <p><strong>iWellCare Healthcare System</strong></p>
    </div>

    <!-- Inventory Statistics -->
    <div class="section">
        <h2>Inventory Overview</h2>
        <div class="stats-grid">
            <div class="stats-row">
                <div class="stats-cell">
                    <h3>{{ $inventoryStats['total'] }}</h3>
                    <p>Total Items</p>
                </div>
                <div class="stats-cell">
                    <h3>{{ $inventoryStats['low_stock'] }}</h3>
                    <p>Low Stock</p>
                </div>
                <div class="stats-cell">
                    <h3>{{ $inventoryStats['out_of_stock'] }}</h3>
                    <p>Out of Stock</p>
                </div>
                <div class="stats-cell">
                    <h3>{{ $inventoryStats['expiring_soon'] }}</h3>
                    <p>Expiring Soon</p>
                </div>
                <div class="stats-cell">
                    <h3>₱{{ number_format($inventoryStats['total_value'], 2) }}</h3>
                    <p>Total Value</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Inventory List -->
    <div class="section">
        <h2>Inventory Items ({{ $inventory->count() }} total)</h2>
        @if($inventory->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total Value</th>
                        <th>Status</th>
                        <th>Expiry Date</th>
                        <th>Last Updated</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inventory as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->name }}</strong><br>
                            <small class="text-muted">{{ Str::limit($item->description, 50) }}</small>
                        </td>
                        <td>
                            <span class="badge badge-info">{{ ucfirst($item->category) }}</span>
                        </td>
                        <td class="text-center">
                            <strong>{{ number_format($item->quantity) }}</strong>
                        </td>
                        <td class="text-right">₱{{ number_format($item->unit_price, 2) }}</td>
                        <td class="text-right">₱{{ number_format($item->quantity * $item->unit_price, 2) }}</td>
                        <td>
                            @if($item->quantity <= 0)
                                <span class="badge badge-danger">Out of Stock</span>
                            @elseif($item->quantity <= $item->reorder_level)
                                <span class="badge badge-warning">Low Stock</span>
                            @else
                                <span class="badge badge-success">In Stock</span>
                            @endif
                        </td>
                        <td>
                            @if($item->expiration_date)
                                @if($item->expiration_date <= now()->addDays(30))
                                    <span class="badge badge-warning">{{ $item->expiration_date->format('M d, Y') }}</span>
                                @else
                                    <small class="text-muted">{{ $item->expiration_date->format('M d, Y') }}</small>
                                @endif
                            @else
                                <small class="text-muted">No expiry</small>
                            @endif
                        </td>
                        <td>
                            <small class="text-muted">
                                {{ $item->updated_at->format('M d, Y') }}<br>
                                {{ $item->updated_at->format('g:i A') }}
                            </small>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted">No inventory items found</p>
        @endif
    </div>

    <!-- Low Stock Alerts -->
    @php
        $lowStockItems = $inventory->filter(function($item) {
            return $item->quantity <= $item->reorder_level;
        });
    @endphp
    
    @if($lowStockItems->count() > 0)
    <div class="section">
        <h2>Low Stock Alerts ({{ $lowStockItems->count() }} items)</h2>
        <table>
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Category</th>
                    <th>Current Stock</th>
                    <th>Reorder Level</th>
                    <th>Unit Price</th>
                    <th>Supplier</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lowStockItems as $item)
                <tr>
                    <td><strong>{{ $item->name }}</strong></td>
                    <td><span class="badge badge-info">{{ ucfirst($item->category) }}</span></td>
                    <td class="text-center">
                        <span class="badge badge-warning">{{ $item->quantity }}</span>
                    </td>
                    <td class="text-center">{{ $item->reorder_level }}</td>
                    <td class="text-right">₱{{ number_format($item->unit_price, 2) }}</td>
                    <td>{{ $item->supplier ?? 'N/A' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Expiring Items -->
    @php
        $expiringItems = $inventory->filter(function($item) {
            return $item->expiration_date && $item->expiration_date <= now()->addDays(30) && $item->expiration_date > now();
        });
    @endphp
    
    @if($expiringItems->count() > 0)
    <div class="section">
        <h2>Expiring Soon ({{ $expiringItems->count() }} items)</h2>
        <table>
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>Expiry Date</th>
                    <th>Days Until Expiry</th>
                    <th>Unit Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expiringItems as $item)
                <tr>
                    <td><strong>{{ $item->name }}</strong></td>
                    <td><span class="badge badge-info">{{ ucfirst($item->category) }}</span></td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td>
                        <span class="badge badge-warning">{{ $item->expiration_date->format('M d, Y') }}</span>
                    </td>
                    <td class="text-center">
                        @php
                            $daysUntilExpiry = $item->expiration_date->diffInDays(now());
                        @endphp
                        <span class="badge badge-{{ $daysUntilExpiry <= 7 ? 'danger' : 'warning' }}">
                            {{ $daysUntilExpiry }} days
                        </span>
                    </td>
                    <td class="text-right">₱{{ number_format($item->unit_price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <div class="footer">
        <p>This report was generated automatically by the iWellCare Healthcare System.</p>
        <p>For questions or support, please contact your system administrator.</p>
    </div>
</body>
</html> 