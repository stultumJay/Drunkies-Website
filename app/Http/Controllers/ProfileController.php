<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function settings()
    {
        return view('profile.settings', [
            'user' => auth()->user()
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string|max:20',
            'birthdate' => 'required|date|before:today'
        ]);

        auth()->user()->update($validated);

        return back()->with('success', 'Profile updated successfully!');
    }

    public function updatePreferences(Request $request)
    {
        $validated = $request->validate([
            'notifications' => 'nullable|array',
            'notifications.*' => 'string|in:order_updates,promotions,newsletter',
            'categories' => 'nullable|array',
            'categories.*' => 'string|in:lagers,ales,craft'
        ]);

        auth()->user()->update([
            'notification_preferences' => $validated['notifications'] ?? [],
            'preferred_categories' => $validated['categories'] ?? []
        ]);

        return back()->with('success', 'Preferences updated successfully!');
    }

    public function storeAddress(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20'
        ]);

        auth()->user()->addresses()->create($validated);

        return back()->with('success', 'Address added successfully!');
    }
} 