<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\MainDealer;
use App\Models\Recap;
use Masmerise\Toaster\Toaster;
use Livewire\Attributes\Title;

#[Title('CCO Recap MOU | Dashboard')]

class UserDashboard extends Component
{
    public $maindealers = [];
    public $maindealer_id = '';
    public $filteredRecaps = [];
    public $selectedDealerName = '';

    public function mount()
    {
        $this->maindealers = MainDealer::orderBy('md_name', 'asc')->get();
        $this->filteredRecaps = collect();
    }

    public function search()
    {
        $this->validate([
            'maindealer_id' => 'required|exists:main_dealers,id',
        ], [
            'maindealer_id.required' => 'Silakan pilih Main Dealer',
            'maindealer_id.exists' => 'Main Dealer yang dipilih tidak valid',
        ]);

        if (empty($this->maindealer_id)) {
            Toaster::error('Silakan pilih Main Dealer terlebih dahulu');
            return;
        }

        $selectedDealer = MainDealer::find($this->maindealer_id);
        
        if ($selectedDealer) {
            $this->filteredRecaps = Recap::where('main_dealer_id', $this->maindealer_id)
                ->with(['School', 'mainDealer'])
                ->orderBy('created_at', 'desc')
                ->get();
            
            $this->selectedDealerName = $selectedDealer->md_name;
            
            if ($this->filteredRecaps->count() > 0) {
                Toaster::success('Ditemukan ' . $this->filteredRecaps->count() . ' data MoU untuk: ' . $selectedDealer->md_name);
            } else {
                Toaster::info('Tidak ada data MoU ditemukan untuk: ' . $selectedDealer->md_name);
            }
        } else {
            Toaster::error('Main Dealer tidak ditemukan');
        }
    }

    public function resetSearch()
    {
        $this->maindealer_id = '';
        $this->filteredRecaps = collect();
        $this->selectedDealerName = '';
        $this->dispatch('form-reset');
        
        Toaster::info('Pencarian direset');
    }

    public function render()
    {
        return view('livewire.user.user-dashboard', [
            'recaps' => $this->filteredRecaps,
        ]);
    }
}