<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Treatment;
use App\Models\FunctionalAppliance;
use App\Models\Tad;
use App\Models\DoctorType;
use App\Models\TransferType;
use App\Models\InsuranceProvider;

class AdminOptionsController extends Controller
{
    /**
     * Configuration for each option type
     */
    private $optionTypes = [
        'treatments' => [
            'model' => Treatment::class,
            'title' => 'Treatments',
            'singular' => 'Treatment',
            'description' => 'Manage available orthodontic treatments'
        ],
        'functional-appliances' => [
            'model' => FunctionalAppliance::class,
            'title' => 'Functional Appliances',
            'singular' => 'Functional Appliance',
            'description' => 'Manage orthodontic functional appliances'
        ],
        'tads' => [
            'model' => Tad::class,
            'title' => 'TADs (Temporary Anchorage Devices)',
            'singular' => 'TAD',
            'description' => 'Manage temporary anchorage devices'
        ],
        'doctor-types' => [
            'model' => DoctorType::class,
            'title' => 'Doctor Types',
            'singular' => 'Doctor Type',
            'description' => 'Manage types of orthodontic practitioners'
        ],
        'transfer-types' => [
            'model' => TransferType::class,
            'title' => 'Transfer Types',
            'singular' => 'Transfer Type',
            'description' => 'Manage types of treatment transfers'
        ],
        'insurance-providers' => [
            'model' => InsuranceProvider::class,
            'title' => 'Insurance Providers',
            'singular' => 'Insurance Provider',
            'description' => 'Manage accepted insurance providers'
        ]
    ];

    /**
     * Constructor to ensure admin authentication
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of the specified option type
     */
    public function index($type)
    {
        if (!isset($this->optionTypes[$type])) {
            return redirect()->route('admin.dashboard')->with('error', 'Invalid option type.');
        }

        $config = $this->optionTypes[$type];
        $modelClass = $config['model'];
        
        $options = $modelClass::orderBy('name')->paginate(20);
        
        return view('admin.options.index', compact('options', 'type', 'config'));
    }

    /**
     * Show the form for creating a new option
     */
    public function create($type)
    {
        if (!isset($this->optionTypes[$type])) {
            return redirect()->route('admin.dashboard')->with('error', 'Invalid option type.');
        }

        $config = $this->optionTypes[$type];
        $modelClass = $config['model'];
        $option = new $modelClass();
        
        return view('admin.options.form', compact('option', 'type', 'config'));
    }

    /**
     * Store a newly created option
     */
    public function store(Request $request, $type)
    {
        if (!isset($this->optionTypes[$type])) {
            return redirect()->route('admin.dashboard')->with('error', 'Invalid option type.');
        }

        $config = $this->optionTypes[$type];
        $modelClass = $config['model'];

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['boolean']
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $modelClass::create([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active', true)
        ]);

        return redirect()->route('admin.options.index', $type)
                        ->with('success', $config['singular'] . ' created successfully.');
    }

    /**
     * Show the form for editing the specified option
     */
    public function edit($type, $id)
    {
        if (!isset($this->optionTypes[$type])) {
            return redirect()->route('admin.dashboard')->with('error', 'Invalid option type.');
        }

        $config = $this->optionTypes[$type];
        $modelClass = $config['model'];
        
        $option = $modelClass::findOrFail($id);
        
        return view('admin.options.form', compact('option', 'type', 'config'));
    }

    /**
     * Update the specified option
     */
    public function update(Request $request, $type, $id)
    {
        if (!isset($this->optionTypes[$type])) {
            return redirect()->route('admin.dashboard')->with('error', 'Invalid option type.');
        }

        $config = $this->optionTypes[$type];
        $modelClass = $config['model'];
        
        $option = $modelClass::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['boolean']
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $option->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active', true)
        ]);

        return redirect()->route('admin.options.index', $type)
                        ->with('success', $config['singular'] . ' updated successfully.');
    }

    /**
     * Remove the specified option
     */
    public function destroy($type, $id)
    {
        if (!isset($this->optionTypes[$type])) {
            return redirect()->route('admin.dashboard')->with('error', 'Invalid option type.');
        }

        $config = $this->optionTypes[$type];
        $modelClass = $config['model'];
        
        $option = $modelClass::findOrFail($id);
        $option->delete();

        return redirect()->route('admin.options.index', $type)
                        ->with('success', $config['singular'] . ' deleted successfully.');
    }
} 