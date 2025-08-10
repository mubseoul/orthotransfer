<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminDoctorController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $status = $request->query('status');

        $query = User::where('role', 'doctor');

        if ($status === 'approved') {
            $query->where('is_approved', true);
        } elseif ($status === 'pending') {
            $query->where('is_approved', false);
        }

        $doctors = $query->orderByDesc('created_at')->paginate(15)->withQueryString();

        return view('admin.doctors.index', compact('doctors', 'status'));
    }

    public function approve(User $user)
    {
        if ($user->role !== 'doctor') {
            return back()->with('error', 'Invalid user type.');
        }

        $user->is_approved = true;
        $user->approved_at = now();
        // Note: approved_by references users table; our admins are separate, so we leave it null.
        $user->approved_by = null;
        $user->save();

        return back()->with('success', 'Doctor approved successfully.');
    }

    public function unapprove(User $user)
    {
        if ($user->role !== 'doctor') {
            return back()->with('error', 'Invalid user type.');
        }

        $user->is_approved = false;
        $user->approved_at = null;
        $user->approved_by = null;
        $user->save();

        return back()->with('success', 'Doctor unapproved successfully.');
    }

    public function show(User $user)
    {
        if ($user->role !== 'doctor') {
            abort(404);
        }

        $user->load(['doctorProfile', 'patients']);
        return view('admin.doctors.show', compact('user'));
    }

    public function update(User $user, Request $request)
    {
        if ($user->role !== 'doctor') {
            abort(404);
        }

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'doctor_profile.title' => ['nullable', 'string', 'max:255'],
            'doctor_profile.phone_number' => ['required', 'string', 'max:255'],
            'doctor_profile.website' => ['nullable', 'url'],
            'doctor_profile.bio' => ['nullable', 'string'],
            'doctor_profile.minimum_monthly_payment' => ['required', 'numeric', 'min:0'],
        ]);

        $user->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
        ]);

        $profileData = $validated['doctor_profile'];
        $user->doctorProfile()->updateOrCreate(
            ['user_id' => $user->id],
            $profileData
        );

        return redirect()->route('admin.doctors.show', $user)->with('success', 'Doctor updated successfully.');
    }

    public function attachPatient(User $user, Request $request)
    {
        if ($user->role !== 'doctor') {
            abort(404);
        }

        $data = $request->validate([
            'patient_user_id' => ['required', 'exists:users,id']
        ]);

        $patient = User::findOrFail($data['patient_user_id']);
        if (!$patient->isPatient()) {
            return back()->with('error', 'Selected user is not a patient.');
        }

        $user->patients()->syncWithoutDetaching([$patient->id]);

        return back()->with('success', 'Patient linked to doctor.');
    }

    public function detachPatient(User $user, User $patient)
    {
        if ($user->role !== 'doctor' || !$patient->isPatient()) {
            abort(404);
        }

        $user->patients()->detach($patient->id);
        return back()->with('success', 'Patient unlinked from doctor.');
    }
}

