<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\DoctorProfile;
use App\Models\UserAddress;
use App\Models\TransferType;
use App\Models\InsuranceProvider;

class DoctorPracticeController extends Controller
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

    public function index()
    {
        $this->ensureDoctor();
        $user = auth()->user();

        $profile = $user->doctorProfile()->with(['transferTypes', 'insuranceProviders'])->first();

        // De-duplicate by name in case of seed reruns creating doubles
        $transferTypes = TransferType::active()->orderBy('name')->get()->unique('name')->values();
        $insuranceProviders = InsuranceProvider::active()->orderBy('name')->get()->unique('name')->values();

        return view('user.practice', compact('user', 'profile', 'transferTypes', 'insuranceProviders'));
    }

    public function update(Request $request)
    {
        $this->ensureDoctor();
        $user = auth()->user();

        $request->validate([
            'title' => 'nullable|string|max:100',
            'phone_number' => 'nullable|string|max:50',
            'website' => 'nullable|url|max:255',
            'bio' => 'nullable|string|max:2000',
            'minimum_monthly_payment' => 'nullable|numeric|min:0|max:999999.99',

            // Multi-selects
            'transfer_types' => 'array',
            'transfer_types.*' => 'exists:transfer_types,id',
            'insurance_providers' => 'array',
            'insurance_providers.*' => 'exists:insurance_providers,id',
        ]);

        DB::transaction(function () use ($request, $user) {
            // Upsert doctor profile
            $profileData = [
                'title' => $request->title,
                'phone_number' => $request->phone_number,
                'website' => $request->website,
                'bio' => $request->bio,
                'minimum_monthly_payment' => $request->minimum_monthly_payment,
            ];

            /** @var DoctorProfile $profile */
            $profile = $user->doctorProfile()->updateOrCreate(
                ['user_id' => $user->id],
                $profileData
            );

            // Sync many-to-many selections
            $profile->transferTypes()->sync($request->transfer_types ?? []);
            $profile->insuranceProviders()->sync($request->insurance_providers ?? []);
        });

        return redirect()->route('dashboard.practice')->with('success', 'Practice settings updated successfully.');
    }

    public function address()
    {
        $this->ensureDoctor();
        $user = auth()->user();
        $address = $user->currentAddress()->first() ?? new UserAddress();

        return view('user.practice-address', compact('user', 'address'));
    }

    public function updateAddress(Request $request)
    {
        $this->ensureDoctor();
        $user = auth()->user();

        $request->validate([
            'label' => 'nullable|string|max:100',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        DB::transaction(function () use ($request, $user) {
            $addressData = [
                'label' => $request->label ?: 'Practice',
                'address_line_1' => $request->address_line_1,
                'address_line_2' => $request->address_line_2,
                'city' => $request->city,
                'state' => $request->state,
                'postal_code' => $request->postal_code,
                'country' => $request->country,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'is_current' => true,
            ];

            // Ensure only one current address
            $user->addresses()->update(['is_current' => false]);

            $current = $user->currentAddress()->first();
            if ($current) {
                $current->update($addressData);
            } else {
                $user->addresses()->create($addressData);
            }
        });

        return redirect()->route('dashboard.practice.address')->with('success', 'Practice address updated successfully.');
    }
}