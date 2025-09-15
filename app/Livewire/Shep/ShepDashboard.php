<?php

namespace App\Livewire\Shep;

use Livewire\Component;

class ShepDashboard extends Component
{
    public $countMainDealer;
    public $countSchool;
    public $countRecap;

    public function mount()
    {
    $this->countMainDealer = \App\Models\MainDealer::count();
    $this->countSchool = \App\Models\School::count();
    $this->countRecap = \App\Models\Recap::select('status_dokumen')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('status_dokumen')
            ->pluck('total', 'status_dokumen');
    }
    
    public function render()
    {
        return view('livewire.shep.shep-dashboard');
    }
}
