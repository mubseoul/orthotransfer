<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /**
     * Show the patient registration form.
     */
    public function showPatientForm()
    {
        return view('auth.register-patient');
    }

    /**
     * Show the doctor registration form.
     */
    public function showDoctorForm()
    {
        return view('auth.register-doctor');
    }

    /**
     * Handle patient registration.
     */
    public function registerPatient(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        // Create user
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'patient',
            'is_approved' => true,
            'approved_at' => now(),
        ]);

        // Log the user in
        auth()->login($user);

        // Convert any pending invites for this email into doctor links
        DB::transaction(function () use ($user) {
            $invites = DB::table('doctor_patient_invites')
                ->whereRaw('LOWER(invite_email) = ?', [strtolower($user->email)])
                ->get();
            foreach ($invites as $invite) {
                DB::table('doctor_patient')->updateOrInsert(
                    [
                        'doctor_user_id' => $invite->doctor_user_id,
                        'patient_user_id' => $user->id,
                    ],
                    [
                        'status' => 'pending',
                        'accepted_at' => null,
                        'rejected_at' => null,
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }
            DB::table('doctor_patient_invites')
                ->whereRaw('LOWER(invite_email) = ?', [strtolower($user->email)])
                ->update(['status' => 'converted', 'updated_at' => now()]);
        });

        return redirect()->route('home')->with('success', 'Registration successful! Welcome to OrthoTransfer.');
    }

    /**
     * Handle doctor registration.
     */
    public function registerDoctor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        // Create user (doctors require approval)
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'doctor',
            'is_approved' => false, // Doctors require approval
            'approved_at' => null,
            'approved_by' => null,
        ]);

        return redirect()->route('home')->with('success', 'Registration submitted! Your account is pending approval. You will receive an email once approved.');
    }
} 