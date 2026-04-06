<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        $user->load(['vehicles', 'purchases.product', 'purchases.vehicle']);

        // Get vehicle block status
        $vehicles = $user->vehicles->map(function ($vehicle) {
            $vehicle->currently_blocked = $vehicle->isCurrentlyBlocked();
            return $vehicle;
        });

        // Purchase stats
        $totalPurchases = $user->purchases->count();
        $totalSpent = $user->purchases->sum('amount_paid');
        $totalLiters = $user->purchases->sum('liters');

        return view('profile.show', compact('user', 'vehicles', 'totalPurchases', 'totalSpent', 'totalLiters'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:20|unique:users,mobile_number,' . $user->id,
        ]);

        $user->update($validated);

        return back()->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password updated successfully!');
    }
}
