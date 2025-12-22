<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class StaffController extends Controller
{
    /**
     * Display a listing of staff.
     */
    public function index()
    {
        $staff = User::where('role', '!=', 'admin')
            ->latest()
            ->paginate(10);

        return view('admin.daftar_staff.index', compact('staff'));
    }

    /**
     * Show the form for creating a new staff.
     */
    public function create()
    {
        return view('admin.staff.create');
    }

    /**
     * Store a newly created staff in database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'role' => ['required', 'in:staff,kasir,dokter'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.daftar_staff.index')
            ->with('success', 'Staff berhasil ditambahkan!');
    }

    /**
     * Display the specified staff.
     */
    public function show(User $staff)
    {
        return view('admin.staff.show', compact('staff'));
    }

    /**
     * Show the form for editing the specified staff.
     */
    public function edit(User $staff)
    {
        return view('admin.staff.edit', compact('staff'));
    }

    /**
     * Update the specified staff in database.
     */
    public function update(Request $request, User $staff)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $staff->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'role' => ['required', 'in:staff,kasir,dokter'],
        ]);

        $staff->update($validated);

        return redirect()->route('admin.staff.index')
            ->with('success', 'Data staff berhasil diperbarui!');
    }

    /**
     * Update staff password.
     */
    public function updatePassword(Request $request, User $staff)
    {
        $validated = $request->validate([
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $staff->update([
            'password' => Hash::make($validated['password'])
        ]);

        return back()->with('success', 'Password staff berhasil diperbarui!');
    }

    /**
     * Remove the specified staff from database.
     */
    public function destroy(User $staff)
    {
        // Prevent deleting admin
        if ($staff->role === 'admin') {
            return back()->with('error', 'Admin tidak dapat dihapus!');
        }

        $staff->delete();

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff berhasil dihapus!');
    }

    /**
     * Toggle staff status (active/inactive).
     */
    public function toggleStatus(User $staff)
    {
        $staff->update([
            'is_active' => !$staff->is_active
        ]);

        $status = $staff->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Staff berhasil {$status}!");
    }
}
