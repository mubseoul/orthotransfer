<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the user profile form.
     */
    public function index()
    {
        $user = auth()->user();
        return view('user.profile', compact('user'));
    }

    /**
     * Update the user profile.
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        
        // Validate basic user fields only
        $userRules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
        
        $request->validate($userRules);
        
        DB::transaction(function () use ($request, $user) {
            // Prepare user data
            $userData = [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
            ];

            // Handle profile picture upload
            if ($request->hasFile('profile_picture')) {
                // Delete old profile picture if exists
                if ($user->profile_picture) {
                    Storage::disk('public')->delete($user->profile_picture);
                }
                
                // Store new profile picture
                $userData['profile_picture'] = $request->file('profile_picture')
                    ->store('profile-pictures', 'public');
            }
            
            // Update user basic information
            $user->update($userData);
        });
        
        return redirect()->route('dashboard.profile')
                         ->with('success', 'Profile updated successfully!');
    }
} 