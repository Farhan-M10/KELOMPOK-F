<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileStaffController extends Controller
{
    /**
     * Display the staff's profile.
     */
    public function show()
    {
        /** @var User $user */
        $user = Auth::user();

        return view('staff.profile.show', compact('user'));
    }

    /**
     * Show the form for editing the staff's profile.
     */
    public function edit()
    {
        /** @var User $user */
        $user = Auth::user();

        return view('staff.profile.edit', compact('user'));
    }

    /**
     * Update the staff's profile information.
     */
    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        // Update menggunakan method update() untuk menghindari warning Intelephense
        $user->update($validated);

        return redirect()->route('staff.profile.edit')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Update the staff's password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.current_password' => 'Password saat ini tidak sesuai.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        /** @var User $user */
        $user = Auth::user();

        // Update password
        $user->update([
            'password' => Hash::make($validated['password'])
        ]);

        return redirect()->route('staff.profile.edit')
            ->with('success', 'Password berhasil diperbarui!');
    }

    /**
     * Handle staff logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')
            ->with('success', 'Anda berhasil logout!');
    }
}
