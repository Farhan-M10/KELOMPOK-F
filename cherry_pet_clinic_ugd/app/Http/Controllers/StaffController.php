<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Filter berdasarkan pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan role
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $staff = $query->latest()->paginate(10);

        return view('admin.daftar_staff.index', compact('staff'));
    }

    public function create()
    {
        return view('admin.daftar_staff.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,staff,veterinarian',
            'status' => 'required|in:active,inactive',
            'address' => 'nullable|string',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff berhasil ditambahkan!');
    }

    public function show(User $staff)
    {
        return view('admin.daftar_staff.show', compact('staff'));
    }

    public function edit(User $staff)
    {
        return view('admin.daftar_staff.edit', compact('staff'));
    }

    public function update(Request $request, User $staff)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($staff->id)],
            'password' => 'nullable|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,staff,veterinarian',
            'status' => 'required|in:active,inactive',
            'address' => 'nullable|string',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $staff->update($validated);

        return redirect()->route('admin.daftar_staff.index')
            ->with('success', 'Data staff berhasil diperbarui!');
    }

    public function destroy(User $staff)
    {
        // Cegah penghapusan user yang sedang login
        if ($staff->id === auth()->id()) {
            return redirect()->route('admin.daftar_staff.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        $staff->delete();

        return redirect()->route('admin.daftar_staff.index')
            ->with('success', 'Staff berhasil dihapus!');
    }
}
