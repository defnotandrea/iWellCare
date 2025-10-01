<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventory::query();
        if ($request->filled('name')) {
            $query->where('name', 'like', '%'.$request->name.'%');
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        $inventory = $query->orderBy('name')->paginate(10)->appends($request->all());

        return view('staff.inventory.index', compact('inventory'));
    }

    public function create()
    {
        return view('staff.inventory.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:medicine,supplies,equipment',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
            'reorder_level' => 'nullable|integer|min:0',
            'supplier' => 'nullable|string|max:255',
            'expiration_date' => 'nullable|date|after:today',
            'location' => 'nullable|string|max:255',
            'batch_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);

        $inventory = new Inventory;
        $inventory->name = $request->name;
        $inventory->category = $request->category;
        $inventory->description = $request->description;
        $inventory->quantity = $request->quantity;
        $inventory->unit_price = $request->unit_price;
        $inventory->reorder_level = $request->reorder_level ?? 10;
        $inventory->supplier = $request->supplier;
        $inventory->expiration_date = $request->expiration_date;
        $inventory->location = $request->location;
        $inventory->batch_number = $request->batch_number;
        $inventory->notes = $request->notes;
        $inventory->created_by = auth()->id();
        $inventory->save();

        return redirect()->route('staff.inventory.index')->with('success', 'Inventory item added successfully.');
    }

    public function edit($id)
    {
        $item = Inventory::findOrFail($id);

        return view('staff.inventory.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'unit_price' => 'nullable|numeric|min:0',
        ]);

        $item = Inventory::findOrFail($id);
        $item->name = $request->name;
        $item->quantity = $request->quantity;
        $item->reorder_level = $request->reorder_level;
        $item->description = $request->description;
        $item->category = $request->category;
        $item->unit_price = $request->unit_price;
        $item->last_updated = now();
        $item->updated_by = auth()->id();
        $item->save();

        return redirect()->route('staff.inventory.index')->with('success', 'Inventory item updated successfully.');
    }

    public function show($id)
    {
        $item = Inventory::findOrFail($id);

        return view('staff.inventory.show', compact('item'));
    }

    public function destroy($id)
    {
        $item = Inventory::findOrFail($id);
        $item->delete();

        return redirect()->route('staff.inventory.index')->with('success', 'Inventory item deleted successfully.');
    }
}
