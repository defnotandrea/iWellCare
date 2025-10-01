<?php

namespace Database\Seeders;

use App\Models\Inventory;
use App\Models\User;
use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get a user to use as updated_by
        $user = User::first();

        if (! $user) {
            $this->command->error('No users found. Please create a user first.');

            return;
        }

        $inventoryItems = [
            [
                'name' => 'Paracetamol 500mg',
                'description' => 'Pain relief medication, 500mg tablets',
                'category' => 'medicine',
                'quantity' => 150,
                'reorder_level' => 20,
                'unit_price' => 25.00,
                'supplier' => 'PharmaCorp Inc.',
                'expiration_date' => now()->addMonths(12),
                'updated_by' => $user->id,
                'is_active' => true,
            ],
            [
                'name' => 'Surgical Masks',
                'description' => 'Disposable 3-ply surgical masks, box of 50',
                'category' => 'supplies',
                'quantity' => 25,
                'reorder_level' => 10,
                'unit_price' => 750.00,
                'supplier' => 'MedSupply Co.',
                'expiration_date' => now()->addYears(2),
                'updated_by' => $user->id,
                'is_active' => true,
            ],
            [
                'name' => 'Digital Thermometer',
                'description' => 'Infrared digital thermometer for accurate temperature readings',
                'category' => 'equipment',
                'quantity' => 8,
                'reorder_level' => 3,
                'unit_price' => 2250.00,
                'supplier' => 'Medical Devices Ltd.',
                'expiration_date' => null,
                'updated_by' => $user->id,
                'is_active' => true,
            ],
            [
                'name' => 'Bandages (Assorted)',
                'description' => 'Assorted sizes of adhesive bandages',
                'category' => 'supplies',
                'quantity' => 5,
                'reorder_level' => 15,
                'unit_price' => 425.00,
                'supplier' => 'First Aid Supplies',
                'expiration_date' => now()->addMonths(18),
                'updated_by' => $user->id,
                'is_active' => true,
            ],
            [
                'name' => 'Amoxicillin 250mg',
                'description' => 'Antibiotic capsules, 250mg',
                'category' => 'medicine',
                'quantity' => 0,
                'reorder_level' => 30,
                'unit_price' => 112.50,
                'supplier' => 'PharmaCorp Inc.',
                'expiration_date' => now()->addMonths(6),
                'updated_by' => $user->id,
                'is_active' => true,
            ],
            [
                'name' => 'Blood Pressure Monitor',
                'description' => 'Digital automatic blood pressure monitor',
                'category' => 'equipment',
                'quantity' => 2,
                'reorder_level' => 1,
                'unit_price' => 6000.00,
                'supplier' => 'Medical Devices Ltd.',
                'expiration_date' => null,
                'updated_by' => $user->id,
                'is_active' => true,
            ],
            [
                'name' => 'Disposable Gloves (Large)',
                'description' => 'Latex-free disposable gloves, large size, box of 100',
                'category' => 'supplies',
                'quantity' => 12,
                'reorder_level' => 5,
                'unit_price' => 600.00,
                'supplier' => 'MedSupply Co.',
                'expiration_date' => now()->addMonths(24),
                'updated_by' => $user->id,
                'is_active' => true,
            ],
            [
                'name' => 'Ibuprofen 400mg',
                'description' => 'Anti-inflammatory medication, 400mg tablets',
                'category' => 'medicine',
                'quantity' => 80,
                'reorder_level' => 25,
                'unit_price' => 37.50,
                'supplier' => 'PharmaCorp Inc.',
                'expiration_date' => now()->addMonths(15),
                'updated_by' => $user->id,
                'is_active' => true,
            ],
        ];

        foreach ($inventoryItems as $item) {
            Inventory::create($item);
        }

        $this->command->info('Sample inventory data created successfully!');
    }
}
