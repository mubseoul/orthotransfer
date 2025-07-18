<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DashboardSidebar extends Component
{
    public $user;
    public $profile;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->user = auth()->user();
        
        // Load profile data based on user role
        if ($this->user->isPatient()) {
            $this->profile = $this->user->patientProfile;
        } elseif ($this->user->isDoctor()) {
            $this->profile = $this->user->doctorProfile;
        } else {
            $this->profile = null;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard-sidebar');
    }
}
