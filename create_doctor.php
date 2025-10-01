<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Hash;
use App\Models\User;

try {
    // Create basic users for testing login - using only valid roles
    $users = [
        [
            'first_name' => 'Augustus Caesar Butch B.',
            'last_name' => 'Bigornia',
            'email' => 'dr.bigornia@iwellcare.com',
            'username' => 'dr.bigornia',
            'password' => Hash::make('awcmladmin_2014'),
            'role' => 'staff', // Using staff role since doctor/admin are not allowed
            'phone_number' => '+63 912 345 6789',
            'is_active' => true,
        ],
        [
            'first_name' => 'Sarah',
            'last_name' => 'Johnson',
            'email' => 'staff@iwellcare.com',
            'username' => 'staff',
            'password' => Hash::make('password123'),
            'role' => 'staff',
            'is_active' => true,
        ],
    ];

    foreach ($users as $userData) {
        $existingUser = User::where('username', $userData['username'])->first();
        if ($existingUser) {
            echo "User {$userData['username']} already exists\n";
        } else {
            $user = User::create($userData);
            echo "Created user: {$userData['username']} with ID: {$user->id}\n";
        }
    }

    echo "\nLogin Credentials:\n";
    echo "Admin: admin / awcmladmin_2014\n";
    echo "Doctor: dr.bigornia / awcmladmin_2014\n";
    echo "Staff: staff / password123\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}