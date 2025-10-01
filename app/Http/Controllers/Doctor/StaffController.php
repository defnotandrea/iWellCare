<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\StrongPassword;
use App\Rules\ValidUsername;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StaffController extends Controller
{
    /**
     * Display a listing of staff members.
     */
    public function index()
    {
        try {
            $staff = User::where('role', 'staff')
                ->orderBy('created_at', 'desc')
                ->paginate(15);

            return view('doctor.staff.index', compact('staff'));
        } catch (\Exception $e) {
            return 'Error: '.$e->getMessage();
        }
    }

    /**
     * Show the form for creating a new staff member.
     */
    public function create()
    {
        return view('doctor.staff.create');
    }

    /**
     * Store a newly created staff member in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users',
            'username' => [
                'required',
                'string',
                'unique:users',
                new ValidUsername,
            ],
            'password' => [
                'required',
                'string',
                'confirmed',
                new StrongPassword,
            ],
            'phone_number' => 'nullable|string|max:20',
            'street_address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:255',
            'state_province' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ], [
            'username.required' => 'Username is required.',
            'username.unique' => 'This username is already taken.',
            'username.regex' => 'Username can only contain letters, numbers, and underscores.',
            'username.min' => 'Username must be at least 4 characters long.',
            'username.max' => 'Username cannot exceed 20 characters.',
            'username.not_regex' => 'This username is not allowed for security reasons.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 10 characters long.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character (@$!%*?&).',
            'password.not_regex' => 'Password cannot contain common patterns or more than 2 consecutive identical characters.',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email ?: null,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'staff',
            'phone_number' => $request->phone_number,
            'street_address' => $request->street_address,
            'city' => $request->city,
            'state_province' => $request->state_province,
            'postal_code' => $request->postal_code,
            'country' => $request->country,
            'is_active' => $request->boolean('is_active', true),
        ]);

        $emailInfo = $user->email ? "Email: {$user->email}" : 'Email: Not provided';

        return redirect()->route('doctor.staff.index')
            ->with('success', "Staff member account created successfully. Login credentials: Username: {$user->username}, {$emailInfo}");
    }

    /**
     * Display the specified staff member.
     */
    public function show($id)
    {
        $staff = User::where('role', 'staff')->findOrFail($id);

        return view('doctor.staff.show', compact('staff'));
    }

    /**
     * Show the form for editing the specified staff member.
     */
    public function edit($id)
    {
        $staff = User::where('role', 'staff')->findOrFail($id);

        return view('doctor.staff.edit', compact('staff'));
    }

    /**
     * Update the specified staff member in storage.
     */
    public function update(Request $request, $id)
    {
        $staff = User::where('role', 'staff')->findOrFail($id);

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => ['nullable', 'string', 'email', 'max:255', Rule::unique('users')->ignore($staff->id)],
            'phone_number' => 'nullable|string|max:20',
            'street_address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:255',
            'state_province' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $staff->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email ?: null,
            'phone_number' => $request->phone_number,
            'street_address' => $request->street_address,
            'city' => $request->city,
            'state_province' => $request->state_province,
            'postal_code' => $request->postal_code,
            'country' => $request->country,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('doctor.staff.index')
            ->with('success', 'Staff member updated successfully.');
    }

    /**
     * Remove the specified staff member from storage.
     */
    public function destroy($id)
    {
        $staff = User::where('role', 'staff')->findOrFail($id);

        // Prevent deletion of the current user
        if ($staff->id === auth()->id()) {
            return redirect()->route('doctor.staff.index')
                ->with('error', 'You cannot delete your own account.');
        }

        try {
            $staff->delete();

            return redirect()->route('doctor.staff.index')
                ->with('success', 'Staff member deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('doctor.staff.index')
                ->with('error', 'Cannot delete staff member. They may have associated records.');
        }
    }

    /**
     * Toggle the active status of a staff member.
     */
    public function toggleStatus($id)
    {
        $staff = User::where('role', 'staff')->findOrFail($id);

        // Prevent self-deactivation
        if ($staff->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot deactivate your own account.');
        }

        $staff->update(['is_active' => ! $staff->is_active]);

        $status = $staff->is_active ? 'activated' : 'deactivated';

        return redirect()->route('doctor.staff.index')
            ->with('success', "Staff member {$status} successfully.");
    }
}
