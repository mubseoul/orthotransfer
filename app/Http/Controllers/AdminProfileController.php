<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function edit()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.profile', compact('admin'));
    }

    public function update(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $rules = [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:admins,email,'.$admin->id],
            'password' => ['nullable', 'confirmed', 'min:8'],
        ];

        $validated = $request->validate($rules);

        $admin->first_name = $validated['first_name'];
        $admin->last_name = $validated['last_name'];
        $admin->email = $validated['email'];

        if (!empty($validated['password'])) {
            $admin->password = Hash::make($validated['password']);
        }

        $admin->save();

        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully.');
    }

    public function verifyEmail()
    {
        $admin = Auth::guard('admin')->user();
        $admin->email_verified_at = now();
        $admin->save();

        return redirect()->route('admin.profile')->with('success', 'Email marked as verified.');
    }

    public function unverifyEmail()
    {
        $admin = Auth::guard('admin')->user();
        $admin->email_verified_at = null;
        $admin->save();

        return redirect()->route('admin.profile')->with('success', 'Email verification removed.');
    }
}

