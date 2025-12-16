<?php

namespace App\Livewire\Shep;

use Livewire\Component;
use Livewire\Attributes\Locked;
use App\Models\MainDealer;
use App\Models\Recap;
use App\Models\School;

class ShepDashboard extends Component
{
    /** ================= GLOBAL SUMMARY (LOCKED - NEVER CHANGES) ================= */
    public $countMainDealer;
    public $countSchool;
    public $countRecap;
    public $barChartData;
    public $barChartData2;

    /** ================= FILTER ================= */
    public $maindealers;
    public $maindealer_id = '';

    /** ================= RESULT ================= */
    public $filteredRecaps;
    public bool $showResults = false;
    public string $selectedDealerName = '';

    public function mount(): void
    {
        // Load global data ONCE
        $this->loadGlobalData();
        
        // Load dropdown data
        $this->maindealers = MainDealer::orderBy('md_name')->get();
        
        // Initialize empty collection
        $this->filteredRecaps = collect();
    }

    private function loadGlobalData(): void
    {
        $this->countMainDealer = MainDealer::count();
        $this->countSchool = School::count();

        // PIE GLOBAL - Document status distribution
        $this->countRecap = Recap::select('status_dokumen')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('status_dokumen')
            ->pluck('total', 'status_dokumen');

        // BAR GLOBAL 1 - Top 5 dealers by school count
        $this->barChartData = MainDealer::withCount('schools')
            ->orderByDesc('schools_count')
            ->take(5)
            ->pluck('schools_count', 'md_name');

        // BAR GLOBAL 2 - Top 5 dealers by archived documents
        $this->barChartData2 = MainDealer::withCount([
            'recaps as arsip_count' => fn ($q) =>
                $q->where('status_dokumen', 'Di Arsip')
        ])
        ->orderByDesc('arsip_count')
        ->take(5)
        ->pluck('arsip_count', 'md_name');
    }

    public function search(): void
    {
        // Validate input
        $this->validate([
            'maindealer_id' => 'required|exists:main_dealers,id'
        ], [
            'maindealer_id.required' => 'Silakan pilih Main Dealer',
            'maindealer_id.exists' => 'Main Dealer yang dipilih tidak ditemukan'
        ]);

        // Find dealer
        $dealer = MainDealer::find($this->maindealer_id);
        
        if (!$dealer) {
            $this->showResults = false;
            $this->addError('maindealer_id', 'Main Dealer tidak ditemukan');
            return;
        }

        // Load filtered data with relationships
        $this->filteredRecaps = Recap::with(['school', 'mainDealer'])
            ->where('main_dealer_id', $this->maindealer_id)
            ->orderByDesc('updated_at')
            ->get();

        $this->selectedDealerName = $dealer->md_name;
        $this->showResults = true;
    }

    /**
     * Reset filter and clear results
     */
    public function resetFilter(): void
    {
        $this->maindealer_id = '';
        $this->selectedDealerName = '';
        $this->showResults = false;
        $this->filteredRecaps = collect();
        
        // Dispatch event to reset form
        $this->dispatch('form-reset');
    }

    public function render()
    {
        return view('livewire.shep.shep-dashboard');
    }
}