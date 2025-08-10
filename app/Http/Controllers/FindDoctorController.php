<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class FindDoctorController extends Controller
{
    /**
     * Show the Find a Doctor page and results.
     */
    public function index(Request $request)
    {
        $zip = trim((string) $request->input('zip', ''));
        $age = $request->input('age', '20_plus'); // under_20 | 20_plus
        $sort = $request->input('sort', 'name_asc'); // name_asc | name_desc

        // Base query for approved doctors with a current address
        $query = User::query()
            ->where('role', 'doctor')
            ->where('is_approved', true)
            ->with(['doctorProfile', 'currentAddress']);

        // Basic location filter: match zip/city/state when provided
        if ($zip !== '') {
            $query->whereHas('currentAddress', function ($q) use ($zip) {
                $q->where('postal_code', 'like', $zip . '%')
                  ->orWhere('city', 'like', $zip . '%')
                  ->orWhere('state', 'like', $zip . '%');
            });
        }

        // NOTE: Age filter is a UI preference for now; no data dimension to filter by currently

        $doctors = null;
        if ($zip !== '') {
            if ($sort === 'name_desc') {
                $query->orderByDesc('last_name')->orderByDesc('first_name');
            } else {
                $query->orderBy('last_name')->orderBy('first_name');
            }

            $doctors = $query->paginate(12)->withQueryString();
        }

        return view('find-a-doctor', [
            'zip' => $zip,
            'age' => $age,
            'sort' => $sort,
            'doctors' => $doctors,
        ]);
    }
}

