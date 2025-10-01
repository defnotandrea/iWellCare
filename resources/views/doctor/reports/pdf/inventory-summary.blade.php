<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Summary Report</title>
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
        .chart-container {
            margin: 20px 0;
            text-align: center;
        }
        .chart-bar {
            display: inline-block;
            width: 80px;
            margin: 0 10px;
            text-align: center;
        }
        .chart-bar-fill {
            background-color: #007bff;
            height: 120px;
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
        <h1>Inventory Summary Report</h1>
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

    <!-- Stock Status Distribution Chart -->
    <div class="section">
        <h2>Stock Status Distribution</h2>
        <div class="chart-container">
            @php
                $total = $inventoryStats['total'];
                $inStock = $total - $inventoryStats['low_stock'] - $inventoryStats['out_of_stock'];
                $lowStock = $inventoryStats['low_stock'];
                $outOfStock = $inventoryStats['out_of_stock'];
                
                $inStockHeight = $total > 0 ? ($inStock / $total) * 120 : 0;
                $lowStockHeight = $total > 0 ? ($lowStock / $total) * 120 : 0;
                $outOfStockHeight = $total > 0 ? ($outOfStock / $total) * 120 : 0;
            @endphp
            
            <div class="chart-bar">
                <div class="chart-bar-fill" style="height: {{ $inStockHeight }}px; background-color: #28a745;"></div>
                <div class="chart-bar-value">{{ $inStock }}</div>
                <div class="chart-bar-label">In Stock</div>
            </div>
            <div class="chart-bar">
                <div class="chart-bar-fill" style="height: {{ $lowStockHeight }}px; background-color: #ffc107;"></div>
                <div class="chart-bar-value">{{ $lowStock }}</div>
                <div class="chart-bar-label">Low Stock</div>
            </div>
            <div class="chart-bar">
                <div class="chart-bar-fill" style="height: {{ $outOfStockHeight }}px; background-color: #dc3545;"></div>
                <div class="chart-bar-value">{{ $outOfStock }}</div>
                <div class="chart-bar-label">Out of Stock</div>
            </div>
        </div>
    </div>

    <!-- Category Distribution -->
    <div class="section">
        <h2>Inventory by Category</h2>
        @php
            $categoryStats = $inventory->groupBy('category')
                ->map(function ($items, $category) {
                    return [
                        'category' => $category,
                        'count' => $items->count(),
                        'total_value' => $items->sum('total_value'),
                        'low_stock' => $items->filter(function($item) {
                            return $item->isLowStock();
                        })->count(),
                        'out_of_stock' => $items->filter(function($item) {
                            return $item->isOutOfStock();
                        })->count()
                    ];
                })
                ->sortByDesc('count');
        @endphp
        
        @if($categoryStats->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Items</th>
                        <th>Total Value</th>
                        <th>Low Stock</th>
                        <th>Out of Stock</th>
                        <th>% of Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categoryStats as $categoryData)
                    <tr>
                        <td><strong>{{ ucfirst($categoryData['category']) }}</strong></td>
                        <td class="text-center">{{ $categoryData['count'] }}</td>
                        <td class="text-right">₱{{ number_format($categoryData['total_value'], 2) }}</td>
                        <td class="text-center">{{ $categoryData['low_stock'] }}</td>
                        <td class="text-center">{{ $categoryData['out_of_stock'] }}</td>
                        <td class="text-center">
                            {{ $total > 0 ? round(($categoryData['count'] / $total) * 100, 1) : 0 }}%
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted">No category data available</p>
        @endif
    </div>

    <!-- Top Items by Value -->
    <div class="section">
        <h2>Top Items by Total Value</h2>
        @php
            $topValueItems = $inventory->sortByDesc('total_value')->take(10);
        @endphp
        
        @if($topValueItems->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total Value</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topValueItems as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td><strong>{{ $item->name }}</strong></td>
                        <td>{{ ucfirst($item->category) }}</td>
                        <td class="text-center">{{ number_format($item->quantity) }}</td>
                        <td class="text-right">{{ $item->formatted_unit_price }}</td>
                        <td class="text-right"><strong>{{ $item->formatted_total_value }}</strong></td>
                        <td>
                            @if($item->isOutOfStock())
                                <span class="badge badge-danger">Out of Stock</span>
                            @elseif($item->isLowStock())
                                <span class="badge badge-warning">Low Stock</span>
                            @else
                                <span class="badge badge-success">In Stock</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted">No inventory data available</p>
        @endif
    </div>

    <div class="footer">
        <p>This report was generated automatically by the iWellCare Healthcare System.</p>
        <p>For questions or support, please contact your system administrator.</p>
    </div>
</body>
</html> 