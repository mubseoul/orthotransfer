<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\DoctorType;
use App\Models\Treatment;
use App\Models\FunctionalAppliance;
use App\Models\Tad;
use App\Models\TransferType;
use App\Models\InsuranceProvider;

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
        
        // Load the profile data based on user role
        if ($user->isPatient()) {
            $profile = $user->patientProfile()->with(['doctorType', 'treatments', 'functionalAppliances', 'tads'])->first();
            $doctorTypes = DoctorType::where('is_active', true)->get();
            $treatments = Treatment::where('is_active', true)->get();
            $functionalAppliances = FunctionalAppliance::where('is_active', true)->get();
            $tads = Tad::where('is_active', true)->get();
            
            return view('dashboard.profile', compact('user', 'profile', 'doctorTypes', 'treatments', 'functionalAppliances', 'tads'));
        } elseif ($user->isDoctor()) {
            $profile = $user->doctorProfile()->with(['transferTypes', 'insuranceProviders'])->first();
            $transferTypes = TransferType::where('is_active', true)->get();
            $insuranceProviders = InsuranceProvider::where('is_active', true)->get();
            
            return view('dashboard.profile', compact('user', 'profile', 'transferTypes', 'insuranceProviders'));
        }
        
        return view('dashboard.profile', compact('user'));
    }

    /**
     * Update the user profile.
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        
        // Validate basic user fields
        $userRules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ];
        
        // Add role-specific validation rules
        if ($user->isPatient()) {
            $profileRules = [
                'age' => 'required|integer|min:1|max:120',
                'radius_willing_to_drive' => 'required|integer|min:1|max:500',
                'moving_temporarily' => 'boolean',
                'current_orthodontist_name' => 'required|string|max:255',
                'orthodontist_address' => 'required|string',
                'original_treatment_length_months' => 'required|integer|min:1|max:120',
                'remaining_financial_amount' => 'required|numeric|min:0|max:999999.99',
                'doctor_type_id' => 'nullable|exists:doctor_types,id',
                'treatments' => 'array',
                'treatments.*' => 'exists:treatments,id',
                'functional_appliances' => 'array',
                'functional_appliances.*' => 'exists:functional_appliances,id',
                'tads' => 'array',
                'tads.*' => 'exists:tads,id',
            ];
        } elseif ($user->isDoctor()) {
            $profileRules = [
                'title' => 'nullable|string|max:255',
                'phone_number' => 'required|string|max:255',
                'website' => 'nullable|url|max:255',
                'bio' => 'nullable|string|max:1000',
                'minimum_monthly_payment' => 'required|numeric|min:0|max:999999.99',
                'transfer_types' => 'array',
                'transfer_types.*' => 'exists:transfer_types,id',
                'insurance_providers' => 'array',
                'insurance_providers.*' => 'exists:insurance_providers,id',
            ];
        } else {
            $profileRules = [];
        }
        
        $request->validate(array_merge($userRules, $profileRules));
        
        DB::transaction(function () use ($request, $user) {
            // Update user basic information
            $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
            ]);
            
            // Update role-specific profile
            if ($user->isPatient()) {
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
                
                // Update many-to-many relationships
                if ($request->has('treatments')) {
                    $profile->treatments()->sync($request->treatments);
                }
                if ($request->has('functional_appliances')) {
                    $profile->functionalAppliances()->sync($request->functional_appliances);
                }
                if ($request->has('tads')) {
                    $profile->tads()->sync($request->tads);
                }
                
            } elseif ($user->isDoctor()) {
                $profileData = [
                    'title' => $request->title,
                    'phone_number' => $request->phone_number,
                    'website' => $request->website,
                    'bio' => $request->bio,
                    'minimum_monthly_payment' => $request->minimum_monthly_payment,
                ];
                
                $profile = $user->doctorProfile()->updateOrCreate(
                    ['user_id' => $user->id],
                    $profileData
                );
                
                // Update many-to-many relationships
                if ($request->has('transfer_types')) {
                    $profile->transferTypes()->sync($request->transfer_types);
                }
                if ($request->has('insurance_providers')) {
                    $profile->insuranceProviders()->sync($request->insurance_providers);
                }
            }
        });
        
        return redirect()->route('dashboard.profile')
                         ->with('success', 'Profile updated successfully!');
    }
} 