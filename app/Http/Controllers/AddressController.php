<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function ensurePatient(): void
    {
        if (!auth()->user()->isPatient()) {
            abort(403, 'Access denied. Patients only.');
        }
    }

    public function index()
    {
        $this->ensurePatient();
        $user = auth()->user();
        $addresses = $user->addresses()
            ->orderByDesc('is_current')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.addresses.index', compact('user', 'addresses'));
    }

    public function create()
    {
        $this->ensurePatient();
        $user = auth()->user();
        $address = new UserAddress();

        return view('user.addresses.form', compact('user', 'address'));
    }

    public function store(Request $request)
    {
        $this->ensurePatient();
        $user = auth()->user();
        $data = $this->validateAddress($request);

        DB::transaction(function () use ($user, &$data) {
            // If this is the user's first address, force it to be current
            $isFirstAddress = $user->addresses()->count() === 0;
            if ($isFirstAddress) {
                $data['is_current'] = true;
            }

            $isCurrent = $data['is_current'] ?? false;
            if ($isCurrent) {
                $user->addresses()->update(['is_current' => false]);
            }

            $user->addresses()->create($data);
        });

        return redirect()->route('dashboard.addresses.index')
            ->with('success', 'Address added successfully.');
    }

    public function edit($id)
    {
        $this->ensurePatient();
        $user = auth()->user();
        $address = $user->addresses()->findOrFail($id);

        return view('user.addresses.form', compact('user', 'address'));
    }

    public function update(Request $request, $id)
    {
        $this->ensurePatient();
        $user = auth()->user();
        $address = $user->addresses()->findOrFail($id);
        $data = $this->validateAddress($request);

        DB::transaction(function () use ($user, $address, $data) {
            $isCurrent = $data['is_current'] ?? false;
            if ($isCurrent) {
                $user->addresses()->where('id', '!=', $address->id)->update(['is_current' => false]);
            }

            $address->update($data);
        });

        return redirect()->route('dashboard.addresses.index')
            ->with('success', 'Address updated successfully.');
    }

    public function destroy($id)
    {
        $this->ensurePatient();
        $user = auth()->user();
        $address = $user->addresses()->findOrFail($id);
        $wasCurrent = $address->is_current;
        $address->delete();

        if ($wasCurrent) {
            $newCurrent = $user->addresses()->latest()->first();
            if ($newCurrent) {
                $newCurrent->update(['is_current' => true]);
            }
        }

        return redirect()->route('dashboard.addresses.index')
            ->with('success', 'Address deleted successfully.');
    }

    public function setCurrent($id)
    {
        $this->ensurePatient();
        $user = auth()->user();
        $address = $user->addresses()->findOrFail($id);

        DB::transaction(function () use ($user, $address) {
            $user->addresses()->update(['is_current' => false]);
            $address->update(['is_current' => true]);
        });

        return redirect()->route('dashboard.addresses.index')
            ->with('success', 'Current address updated.');
    }

    private function validateAddress(Request $request): array
    {
        return $request->validate([
            'label' => 'nullable|string|max:100',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'is_current' => 'boolean',
        ]);
    }
}

