<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DoctorPatientDocument;
use App\Models\Treatment;
use App\Models\FunctionalAppliance;
use App\Models\Tad;
use App\Models\DoctorType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DoctorPatientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function ensureDoctor(): void
    {
        if (!auth()->user()->isDoctor()) {
            abort(403, 'Access denied. Doctors only.');
        }
    }

    private function ensurePatient(): void
    {
        if (!auth()->user()->isPatient()) {
            abort(403, 'Access denied. Patients only.');
        }
    }

    // Doctor: list patients
    public function index()
    {
        $this->ensureDoctor();
        $user = auth()->user();
        // Only accepted connections shown as patients list
        $patients = $user->patients()
            ->wherePivot('status', 'accepted')
            ->with('patientProfile')
            ->orderBy('users.last_name')
            ->get();

        // Pending links to already-registered patients
        $pendingLinks = DB::table('doctor_patient')
            ->join('users as patients', 'patients.id', '=', 'doctor_patient.patient_user_id')
            ->where('doctor_patient.doctor_user_id', $user->id)
            ->where('doctor_patient.status', 'pending')
            ->select('doctor_patient.*', 'patients.first_name', 'patients.last_name', 'patients.email')
            ->orderByDesc('doctor_patient.created_at')
            ->get();

        // Email invites for unregistered patients
        $emailInvites = DB::table('doctor_patient_invites')
            ->where('doctor_user_id', $user->id)
            ->where('status', 'sent')
            ->orderByDesc('created_at')
            ->get();

        return view('user.patients.index', compact('user', 'patients', 'pendingLinks', 'emailInvites'));
    }

    // Doctor: add patient by email (creates link and sends email)
    public function store(Request $request)
    {
        $this->ensureDoctor();
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $doctor = auth()->user();
        $email = strtolower($request->email);

        $patient = User::whereRaw('LOWER(email) = ?', [$email])->first();

        // Do not allow inviting non-patient users (e.g. doctor/admin)
        if ($patient && !$patient->isPatient()) {
            return redirect()->back()->with('error', 'You can only invite patient accounts.');
        }

        // Prevent duplicates and only send email when creating a new link/invite
        if ($patient) {
            $existingLink = DB::table('doctor_patient')
                ->where('doctor_user_id', $doctor->id)
                ->where('patient_user_id', $patient->id)
                ->first();

            if ($existingLink) {
                $status = $existingLink->status ?? 'pending';
                if ($status === 'accepted') {
                    return redirect()->back()->with('error', 'You are already connected with this patient.');
                }
                if ($status === 'pending') {
                    return redirect()->back()->with('error', 'Invitation already sent and pending.');
                }
                if ($status === 'rejected') {
                    return redirect()->back()->with('error', 'This patient has rejected your invitation.');
                }
            }

            DB::transaction(function () use ($doctor, $patient, $email) {
                DB::table('doctor_patient')->insert([
                    'doctor_user_id' => $doctor->id,
                    'patient_user_id' => $patient->id,
                    'status' => 'pending',
                    'accepted_at' => null,
                    'rejected_at' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                try {
                    Mail::to($email)->send(new \App\Mail\DoctorAddedYouMail($doctor));
                } catch (\Throwable $e) {
                    // ignore mail failures
                }
            });

            return redirect()->back()->with('success', 'Patient added. Invitation sent.');
        } else {
            $existingInvite = DB::table('doctor_patient_invites')
                ->where('doctor_user_id', $doctor->id)
                ->whereRaw('LOWER(invite_email) = ?', [$email])
                ->first();

            if ($existingInvite && $existingInvite->status === 'sent') {
                return redirect()->back()->with('error', 'Invitation already sent to this email.');
            }

            DB::transaction(function () use ($doctor, $email, $existingInvite) {
                DB::table('doctor_patient_invites')->updateOrInsert(
                    [
                        'doctor_user_id' => $doctor->id,
                        'invite_email' => $email,
                    ],
                    [
                        'status' => 'sent',
                        'created_at' => $existingInvite?->created_at ?? now(),
                        'updated_at' => now(),
                    ]
                );

                try {
                    Mail::to($email)->send(new \App\Mail\DoctorAddedYouMail($doctor));
                } catch (\Throwable $e) {
                }
            });

            return redirect()->back()->with('success', 'Invitation sent.');
        }
    }

    // Doctor: show patient's documents and upload form
    public function show($patientId)
    {
        $this->ensureDoctor();
        $doctor = auth()->user();
        $patient = User::where('id', $patientId)->where('role', 'patient')->firstOrFail();

        // Authorization: ensure linked (any status allows viewing/uploading)
        $link = DB::table('doctor_patient')
            ->where('doctor_user_id', $doctor->id)
            ->where('patient_user_id', $patient->id)
            ->first();
        if (!$link) abort(403);

        // Load patient profile and option lists for display (and edit when accepted)
        $profile = $patient->patientProfile()->with([
            'treatments', 'functionalAppliances', 'tads', 'doctorType'
        ])->first();
        $treatments = Treatment::active()->orderBy('name')->get();
        $functionalAppliances = FunctionalAppliance::active()->orderBy('name')->get();
        $tads = Tad::active()->orderBy('name')->get();
        $doctorTypes = DoctorType::active()->orderBy('name')->get();

        $documents = DoctorPatientDocument::where('doctor_user_id', $doctor->id)
            ->where('patient_user_id', $patient->id)
            ->latest()->get();

        return view('user.patients.show', [
            'user' => $doctor,
            'doctor' => $doctor,
            'patient' => $patient,
            'profile' => $profile,
            'treatments' => $treatments,
            'functionalAppliances' => $functionalAppliances,
            'tads' => $tads,
            'doctorTypes' => $doctorTypes,
            'documents' => $documents,
            'link' => $link,
        ]);
    }

    // Doctor: upload documents for patient
    public function upload(Request $request, $patientId)
    {
        $this->ensureDoctor();
        $doctor = auth()->user();
        $patient = User::where('id', $patientId)->where('role', 'patient')->firstOrFail();

        // Authorization: allow upload for any linked status (pending or accepted)
        $link = DB::table('doctor_patient')
            ->where('doctor_user_id', $doctor->id)
            ->where('patient_user_id', $patient->id)
            ->first();
        if (!$link) abort(403);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'comments' => ['nullable', 'string', 'max:2000'],
            'files.*' => ['required', 'file', 'max:10240'], // 10MB each
        ]);

        foreach ((array) $request->file('files', []) as $file) {
            $storedPath = $file->store('doctor_documents/'.date('Y/m/d'), 'public');
            DoctorPatientDocument::create([
                'doctor_user_id' => $doctor->id,
                'patient_user_id' => $patient->id,
                'title' => $request->title,
                'comments' => $request->comments,
                'file_path' => $storedPath,
                'file_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getClientMimeType(),
                'file_size' => $file->getSize(),
            ]);
        }

        try {
            Mail::to($patient->email)->queue(new \App\Mail\NewDocumentsUploadedMail($doctor));
        } catch (\Throwable $e) {
        }

        return redirect()->back()->with('success', 'Documents uploaded successfully.');
    }

    // Patient: list doctors
    public function myDoctors()
    {
        $this->ensurePatient();
        $user = auth()->user();
        $doctors = $user->doctors()->orderBy('users.last_name')->get();
        $links = DB::table('doctor_patient')
            ->where('patient_user_id', $user->id)
            ->get()
            ->keyBy('doctor_user_id');

        // Only show accepted doctor profiles; include pending in the table with status but hide view actions
        return view('user.doctors.index', compact('user', 'doctors', 'links'));
    }

    // Patient: view doctor details (only when accepted)
    public function myDoctorDetail($doctorId)
    {
        $this->ensurePatient();
        $patient = auth()->user();
        $doctor = User::where('id', $doctorId)->where('role', 'doctor')->firstOrFail();

        $link = \DB::table('doctor_patient')
            ->where('doctor_user_id', $doctor->id)
            ->where('patient_user_id', $patient->id)
            ->first();
        if (!$link || $link->status !== 'accepted') abort(403);

        $profile = $doctor->doctorProfile()->with(['transferTypes', 'insuranceProviders'])->first();
        $address = $doctor->currentAddress()->first();
        $documents = DoctorPatientDocument::where('doctor_user_id', $doctor->id)
            ->where('patient_user_id', $patient->id)
            ->latest()->get();

        return view('user.doctors.show', [
            'user' => $patient,
            'patient' => $patient,
            'doctor' => $doctor,
            'profile' => $profile,
            'address' => $address,
            'link' => $link,
            'documents' => $documents,
        ]);
    }

    // Doctor: edit patient's ortho details (only when accepted)
    public function editOrtho($patientId)
    {
        $this->ensureDoctor();
        $doctor = auth()->user();
        $patient = User::where('id', $patientId)->where('role', 'patient')->firstOrFail();

        $link = \DB::table('doctor_patient')
            ->where('doctor_user_id', $doctor->id)
            ->where('patient_user_id', $patient->id)
            ->first();
        if (!$link || $link->status !== 'accepted') abort(403);

        $profile = $patient->patientProfile()->with([
            'treatments', 'functionalAppliances', 'tads', 'doctorType'
        ])->first();

        $treatments = Treatment::active()->orderBy('name')->get();
        $functionalAppliances = FunctionalAppliance::active()->orderBy('name')->get();
        $tads = Tad::active()->orderBy('name')->get();
        $doctorTypes = DoctorType::active()->orderBy('name')->get();

        return view('user.patients.ortho-detail', [
            'user' => $doctor,
            'doctor' => $doctor,
            'patient' => $patient,
            'profile' => $profile,
            'treatments' => $treatments,
            'functionalAppliances' => $functionalAppliances,
            'tads' => $tads,
            'doctorTypes' => $doctorTypes,
            'link' => $link,
        ]);
    }

    // Doctor: update patient's ortho details (only when accepted)
    public function updateOrtho(Request $request, $patientId)
    {
        $this->ensureDoctor();
        $doctor = auth()->user();
        $patient = User::where('id', $patientId)->where('role', 'patient')->firstOrFail();

        $link = \DB::table('doctor_patient')
            ->where('doctor_user_id', $doctor->id)
            ->where('patient_user_id', $patient->id)
            ->first();
        if (!$link || $link->status !== 'accepted') abort(403);

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

        \DB::transaction(function () use ($request, $patient) {
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

            $profile = $patient->patientProfile()->updateOrCreate(
                ['user_id' => $patient->id],
                $profileData
            );

            $profile->treatments()->sync($request->treatments ?? []);
            $profile->functionalAppliances()->sync($request->functional_appliances ?? []);
            $profile->tads()->sync($request->tads ?? []);
        });

        return redirect()->route('dashboard.patients.show', $patient->id)
            ->with('success', 'Patient ortho details updated successfully.');
    }
    // Patient: view all documents from a doctor
    public function myDoctorDocuments($doctorId)
    {
        $this->ensurePatient();
        $patient = auth()->user();
        $doctor = User::where('id', $doctorId)->where('role', 'doctor')->firstOrFail();

        $link = DB::table('doctor_patient')
            ->where('doctor_user_id', $doctor->id)
            ->where('patient_user_id', $patient->id)
            ->first();
        if (!$link || $link->status !== 'accepted') abort(403);

        $documents = DoctorPatientDocument::where('doctor_user_id', $doctor->id)
            ->where('patient_user_id', $patient->id)
            ->latest()->get();

        return view('user.doctors.documents', [
            'user' => $patient,
            'patient' => $patient,
            'doctor' => $doctor,
            'documents' => $documents,
            'link' => $link,
        ]);
    }

    // Patient: accept or reject doctor
    public function respondToDoctor(Request $request, $doctorId)
    {
        $this->ensurePatient();
        $patient = auth()->user();
        $request->validate([
            'action' => ['required', Rule::in(['accept', 'reject'])],
        ]);

        $link = DB::table('doctor_patient')
            ->where('doctor_user_id', $doctorId)
            ->where('patient_user_id', $patient->id)
            ->first();

        if (!$link) abort(404);

        $update = [
            'updated_at' => now(),
        ];
        if ($request->action === 'accept') {
            $update['status'] = 'accepted';
            $update['accepted_at'] = now();
            $update['rejected_at'] = null;
        } else {
            $update['status'] = 'rejected';
            $update['rejected_at'] = now();
            $update['accepted_at'] = null;
        }

        DB::table('doctor_patient')
            ->where('doctor_user_id', $doctorId)
            ->where('patient_user_id', $patient->id)
            ->update($update);

        return redirect()->back()->with('success', 'Response saved.');
    }
}

