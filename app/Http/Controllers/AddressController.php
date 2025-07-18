<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\UserAddress;

class AddressController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the user's addresses.
     */
    public function index()
    {
        $user = auth()->user();
        $addresses = $user->addresses()->orderBy('is_current', 'desc')->orderBy('created_at', 'desc')->get();
        
        return view('dashboard.addresses.index', compact('addresses'));
    }

    /**
     * Show the form for creating a new address.
     */
    public function create()
    {
        return view('dashboard.addresses.create');
    }

    /**
     * Store a newly created address in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'address_type' => 'required|in:current,previous,other',
        ]);

        $user = auth()->user();

        DB::transaction(function () use ($request, $user) {
            // Handle current/previous address logic
            if ($request->address_type === 'current') {
                // Only one current address allowed - update existing current to be non-current
                $user->addresses()->where('is_current', true)->update(['is_current' => false]);
                $is_current = true;
            } else {
                $is_current = false;
            }

            // Create the new address
            $user->addresses()->create([
                'label' => $request->label,
                'address_line_1' => $request->address_line_1,
                'address_line_2' => $request->address_line_2,
                'city' => $request->city,
                'state' => $request->state,
                'postal_code' => $request->postal_code,
                'country' => $request->country,
                'is_current' => $is_current,
                // Note: latitude and longitude would be set via geocoding service if implemented
            ]);
        });

        return redirect()->route('dashboard.addresses')
                         ->with('success', 'Address added successfully!');
    }

    /**
     * Show the form for editing the specified address.
     */
    public function edit(UserAddress $address)
    {
        // Ensure the address belongs to the authenticated user
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        return view('dashboard.addresses.edit', compact('address'));
    }

    /**
     * Update the specified address in storage.
     */
    public function update(Request $request, UserAddress $address)
    {
        // Ensure the address belongs to the authenticated user
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'label' => 'required|string|max:255',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'address_type' => 'required|in:current,previous,other',
        ]);

        $user = auth()->user();

        DB::transaction(function () use ($request, $address, $user) {
            // Handle current/previous address logic
            if ($request->address_type === 'current' && !$address->is_current) {
                // Making this address current - update existing current to be non-current
                $user->addresses()->where('is_current', true)->where('id', '!=', $address->id)->update(['is_current' => false]);
                $is_current = true;
            } elseif ($request->address_type !== 'current' && $address->is_current) {
                // Removing current status
                $is_current = false;
            } else {
                // Keep existing current status
                $is_current = $address->is_current;
            }

            // Update the address
            $address->update([
                'label' => $request->label,
                'address_line_1' => $request->address_line_1,
                'address_line_2' => $request->address_line_2,
                'city' => $request->city,
                'state' => $request->state,
                'postal_code' => $request->postal_code,
                'country' => $request->country,
                'is_current' => $is_current,
            ]);
        });

        return redirect()->route('dashboard.addresses')
                         ->with('success', 'Address updated successfully!');
    }

    /**
     * Set an address as current.
     */
    public function setCurrent(UserAddress $address)
    {
        // Ensure the address belongs to the authenticated user
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        $user = auth()->user();

        DB::transaction(function () use ($address, $user) {
            // Update existing current to be non-current
            $user->addresses()->where('is_current', true)->update(['is_current' => false]);
            
            // Set this address as current
            $address->update(['is_current' => true]);
        });

        return redirect()->route('dashboard.addresses')
                         ->with('success', 'Address set as current successfully!');
    }

    /**
     * Remove the specified address from storage.
     */
    public function destroy(UserAddress $address)
    {
        // Ensure the address belongs to the authenticated user
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        $address->delete();

        return redirect()->route('dashboard.addresses')
                         ->with('success', 'Address deleted successfully!');
    }
} 