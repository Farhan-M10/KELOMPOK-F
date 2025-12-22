<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show()
    {
        /** @var User $user */
        $user = Auth::user();

        return view('admin.profile.show', compact('user'));
    }

    /**
     * Show the form for editing the user's profile.
     */
    public function edit()
    {
        /** @var User $user */
        $user = Auth::user();

        return view('admin.profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        // Update menggunakan method update() untuk menghindari warning Intelephense
        $user->update($validated);

        return redirect()->route('profile.edit')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        /** @var User $user */
        $user = Auth::user();

        // Update password
        $user->update([
            'password' => Hash::make($validated['password'])
        ]);

        return redirect()->route('profile.edit')
            ->with('success', 'Password berhasil diperbarui!');
    }

    /**
     * Handle user logout.
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
