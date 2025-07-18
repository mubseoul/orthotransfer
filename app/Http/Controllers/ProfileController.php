<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\Treatment;
use App\Models\FunctionalAppliance;
use App\Models\Tad;
use App\Models\DoctorType;

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

    /**
     * Show the ortho detail management form (Patient only).
     */
    public function orthoDetail()
    {
        $user = auth()->user();
        
        // Only allow patients to access this page
        if (!$user->isPatient()) {
            abort(403, 'Access denied. This page is for patients only.');
        }
        
        // Load patient profile with relationships
        $profile = $user->patientProfile()->with([
            'treatments',
            'functionalAppliances', 
            'tads',
            'doctorType'
        ])->first();
        
        // Load all admin-managed options
        $treatments = Treatment::active()->orderBy('name')->get();
        $functionalAppliances = FunctionalAppliance::active()->orderBy('name')->get();
        $tads = Tad::active()->orderBy('name')->get();
        $doctorTypes = DoctorType::active()->orderBy('name')->get();
        
        return view('user.ortho-detail', compact(
            'user', 
            'profile', 
            'treatments', 
            'functionalAppliances', 
            'tads', 
            'doctorTypes'
        ));
    }

    /**
     * Update the patient's ortho detail information.
     */
    public function updateOrthoDetail(Request $request)
    {
        $user = auth()->user();
        
        // Only allow patients to update ortho details
        if (!$user->isPatient()) {
            abort(403, 'Access denied. This page is for patients only.');
        }
        
        // Validate ortho detail fields
        $request->validate([
            'age' => 'required|integer|min:1|max:120',
            'radius_willing_to_drive' => 'required|integer|min:1|max:500',
            'moving_temporarily' => 'boolean',
            'current_orthodontist_name' => 'nullable|string|max:255',
            'orthodontist_address' => 'nullable|string|max:500',
            'original_treatment_length_months' => 'required|integer|min:1|max:120',
            'remaining_financial_amount' => 'required|numeric|min:0|max:99999.99',
            'doctor_type_id' => 'required|exists:doctor_types,id',
            'treatments' => 'array',
            'treatments.*' => 'exists:treatments,id',
            'functional_appliances' => 'array',
            'functional_appliances.*' => 'exists:functional_appliances,id',
            'tads' => 'array',
            'tads.*' => 'exists:tads,id',
        ]);
        
        DB::transaction(function () use ($request, $user) {
            // Update or create patient profile
            $profileData = [
                'age' => $request->age,
                'radius_willing_to_drive' => $request->radius_willing_to_drive,
                'moving_temporarily' => $request->boolean('moving_temporarily'),
                'current_orthodontist_name' => $request->current_orthodontist_name,
                'orthodontist_address' => $request->orthodontist_address,
                'original_treatment_length_months' => $request->original_treatment_length_months,
                'remaining_financial_amount' => $request->remaining_financial_amount,
                'doctor_type_id' => $request->doctor_type_id,
            ];
            
            $profile = $user->patientProfile()->updateOrCreate(
                ['user_id' => $user->id],
                $profileData
            );
            
            // Sync many-to-many relationships
            $profile->treatments()->sync($request->treatments ?? []);
            $profile->functionalAppliances()->sync($request->functional_appliances ?? []);
            $profile->tads()->sync($request->tads ?? []);
        });
        
        return redirect()->route('dashboard.ortho-detail')
                         ->with('success', 'Ortho details updated successfully!');
    }
} 