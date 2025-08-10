<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DoctorType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminPatientController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $patients = User::where('role', 'patient')->orderByDesc('created_at')->paginate(15);
        return view('admin.patients.index', compact('patients'));
    }

    public function show(User $user)
    {
        if ($user->role !== 'patient') {
            abort(404);
        }

        $user->load(['patientProfile.treatments', 'patientProfile.functionalAppliances', 'patientProfile.tads', 'doctors']);
        $doctorTypes = DoctorType::active()->get();
        return view('admin.patients.show', compact('user', 'doctorTypes'));
    }

    public function update(User $user, Request $request)
    {
        if ($user->role !== 'patient') {
            abort(404);
        }

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'patient_profile.age' => ['required', 'integer', 'min:0'],
            'patient_profile.radius_willing_to_drive' => ['required', 'integer', 'min:0'],
            'patient_profile.moving_temporarily' => ['required', 'boolean'],
            'patient_profile.current_orthodontist_name' => ['required', 'string', 'max:255'],
            'patient_profile.orthodontist_address' => ['required', 'string'],
            'patient_profile.original_treatment_length_months' => ['required', 'integer', 'min:0'],
            'patient_profile.remaining_financial_amount' => ['required', 'numeric', 'min:0'],
            'patient_profile.doctor_type_id' => ['nullable', 'exists:doctor_types,id'],
        ]);

        $user->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
        ]);

        $user->patientProfile()->updateOrCreate(
            ['user_id' => $user->id],
            $validated['patient_profile']
        );

        return redirect()->route('admin.patients.show', $user)->with('success', 'Patient updated successfully.');
    }
}

