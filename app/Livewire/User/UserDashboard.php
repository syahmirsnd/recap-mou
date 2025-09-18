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
    public $showResults = false;
    public $selectedDealerName = '';
    public $histogramData = [];
    public $countRecap;

    public function mount()
    {
        $this->maindealers = MainDealer::orderBy('md_name', 'asc')->get();
        $this->filteredRecaps = Recap::with(['School', 'mainDealer'])->get();
        $this->updateChartsFromRecaps();
    }

    private function updateChartsFromRecaps()
    {
        
        $this->countRecap = $this->filteredRecaps
            ->groupBy('status_dokumen')
            ->map->count();

        $start = now()->subMonths(5)->startOfMonth();
        $end = now()->endOfMonth();

        $perBulan = $this->filteredRecaps
            ->where('status_dokumen', 'Di Arsip')
            ->filter(function ($recap) use ($start, $end) {
                return $recap->updated_at >= $start && $recap->updated_at <= $end;
            })
            ->groupBy(function ($recap) {
                return $recap->updated_at->format('Y-m');
            })
            ->map->count();

        $histogramData = [];
        $runningTotal = 0;

        $period = new \DatePeriod($start, new \DateInterval('P1M'), $end->copy()->addMonth());
        foreach ($period as $month) {
            $key = $month->format('Y-m');
            $displayKey = $month->format('M Y');

            $monthlyCount = $perBulan[$key] ?? 0;
            $runningTotal += $monthlyCount;

            $histogramData[$displayKey] = $runningTotal;
        }

        if (empty($histogramData)) {
            $histogramData = ['No Data' => 0];
        }

        $this->histogramData = $histogramData;
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

            $this->updateChartsFromRecaps();

            $this->selectedDealerName = $selectedDealer->md_name;
            $this->showResults = true;

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
        $this->filteredRecaps = Recap::with(['School', 'mainDealer'])->get();
        $this->showResults = false;
        $this->selectedDealerName = '';

        $this->updateChartsFromRecaps();

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
