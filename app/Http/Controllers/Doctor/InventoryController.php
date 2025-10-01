<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of inventory items.
     */
    public function index(Request $request)
    {
        $query = Inventory::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('supplier', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Status filter
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'low_stock':
                    $query->whereRaw('quantity <= reorder_level');
                    break;
                case 'out_of_stock':
                    $query->where('quantity', '<=', 0);
                    break;
                case 'expiring':
                    $query->where('expiration_date', '<=', now()->addDays(30))
                        ->where('expiration_date', '>', now());
                    break;
            }
        }

        $inventory = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('doctor.inventory.index', compact('inventory'));
    }

    /**
     * Show the form for creating a new inventory item.
     */
    public function create()
    {
        return view('doctor.inventory.create');
    }

    /**
     * Store a newly created inventory item in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'category' => 'required|in:medicine,supplies,equipment',
            'quantity' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
            'supplier' => 'nullable|string|max:255',
            'expiration_date' => 'nullable|date|after:today',
            'reorder_level' => 'required|integer|min:0',
        ]);

        $data = $request->all();
        $data['updated_by'] = auth()->id();
        $data['is_active'] = true;

        Inventory::create($data);

        return redirect()->route('doctor.inventory.index')
            ->with('success', 'Inventory item created successfully.');
    }

    /**
     * Display the specified inventory item.
     */
    public function show(Inventory $inventory)
    {
        return view('doctor.inventory.show', compact('inventory'));
    }

    /**
     * Show the form for editing the specified inventory item.
     */
    public function edit(Inventory $inventory)
    {
        return view('doctor.inventory.edit', compact('inventory'));
    }

    /**
     * Update the specified inventory item in storage.
     */
    public function update(Request $request, Inventory $inventory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'category' => 'required|in:medicine,supplies,equipment',
            'quantity' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
            'supplier' => 'nullable|string|max:255',
            'expiration_date' => 'nullable|date|after:today',
            'reorder_level' => 'required|integer|min:0',
        ]);

        $data = $request->all();
        $data['updated_by'] = auth()->id();

        $inventory->update($data);

        return redirect()->route('doctor.inventory.index')
            ->with('success', 'Inventory item updated successfully.');
    }

    /**
     * Archive the specified inventory item.
     */
    public function destroy(Request $request, Inventory $inventory)
    {
        try {
            $inventory->is_archived = true;
            $inventory->updated_by = auth()->id();
            $inventory->save();

            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Inventory item archived successfully.']);
            }

            return redirect()->route('doctor.inventory.index')
                ->with('success', 'Inventory item archived successfully.');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Error archiving inventory item: '.$e->getMessage()], 500);
            }

            return redirect()->route('doctor.inventory.index')
                ->with('error', 'Error archiving inventory item: '.$e->getMessage());
        }
    }

    /**
     * Adjust stock quantity.
     */
    public function adjustStock(Request $request, Inventory $inventory)
    {
        $request->validate([
            'quantity' => 'required|integer',
            'reason' => 'required|string|max:255',
        ]);

        $quantity = $request->quantity;

        // Ensure quantity doesn't go below 0
        if ($quantity < 0 && abs($quantity) > $inventory->quantity) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Cannot remove more items than available in stock.'], 400);
            }

            return redirect()->back()->with('error', 'Cannot remove more items than available in stock.');
        }

        $inventory->quantity += $quantity;
        $inventory->updated_by = auth()->id();
        $inventory->save();

        // Log the adjustment if InventoryLog model exists
        if (class_exists('App\Models\InventoryLog')) {
            \App\Models\InventoryLog::create([
                'inventory_id' => $inventory->id,
                'adjustment_quantity' => $quantity,
                'notes' => $request->reason,
                'adjusted_by' => auth()->id(),
                'adjusted_at' => now(),
            ]);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Stock adjusted successfully.',
                'new_quantity' => $inventory->quantity,
            ]);
        }

        return redirect()->route('doctor.inventory.index')
            ->with('success', 'Stock adjusted successfully.');
    }

    /**
     * Toggle inventory item status (active/inactive).
     */
    public function toggleStatus(Request $request, Inventory $inventory)
    {
        $inventory->is_active = ! $inventory->is_active;
        $inventory->updated_by = auth()->id();
        $inventory->save();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.',
                'is_active' => $inventory->is_active,
            ]);
        }

        return redirect()->route('doctor.inventory.index')
            ->with('success', 'Status updated successfully.');
    }

    /**
     * Archive an inventory item (AJAX).
     */
    public function archive(Request $request, Inventory $inventory)
    {
        $inventory->archived = true;
        $inventory->updated_by = auth()->id();
        $inventory->save();

        return response()->json(['success' => true, 'message' => 'Item archived successfully.']);
    }
}
