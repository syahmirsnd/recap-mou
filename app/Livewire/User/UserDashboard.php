<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\MainDealer;
use App\Models\Recap;
use Masmerise\Toaster\Toaster;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

#[Title('CCO Recap MOU | Dashboard')]
class UserDashboard extends Component
{
    public $maindealers = [];
    public $maindealer_id = '';
    public $filteredRecaps = [];
    public $showResults = false;
    public $selectedDealerName = '';
    public $histogramData = [];
    public $pieChartData = [];
    public $userMainDealerId = null;
    public $autoLoaded = false;
    

    public function mount()
    {
        $this->maindealers = MainDealer::orderBy('md_name', 'asc')->get();
        $this->filteredRecaps = collect();

        // Get user's main_dealer_id
        $user = auth()->user();
        
        if ($user && $user->main_dealer_id) {
            $this->userMainDealerId = $user->main_dealer_id;
            $this->maindealer_id = $user->main_dealer_id;
            
            // Auto load data for user's main dealer
            $this->autoLoadData();
        } else {
            $this->setEmptyChartData();
        }
        
        \Log::info('Mount called, user main_dealer_id: ' . $this->userMainDealerId);
    }

    private function autoLoadData()
    {
        $selectedDealer = MainDealer::find($this->maindealer_id);

        if ($selectedDealer) {
            // Load data untuk tabel DAN chart
            $this->filteredRecaps = Recap::where('main_dealer_id', $this->maindealer_id)
                ->with(['School', 'mainDealer'])
                ->orderBy('created_at', 'desc')
                ->get();

            $this->selectedDealerName = $selectedDealer->md_name;
            $this->showResults = true;
            $this->autoLoaded = true;

            // Generate chart dari data yang sama dengan tabel
            $this->generateChartsFromFilteredRecaps();

            \Log::info('Auto-loaded data for main dealer: ' . $selectedDealer->md_name);
        } else {
            $this->setEmptyChartData();
        }
    }

    private function generateChartsFromFilteredRecaps()
    {
        \Log::info('generateChartsFromFilteredRecaps called with ' . $this->filteredRecaps->count() . ' records');

        if ($this->filteredRecaps->isEmpty()) {
            $this->setEmptyChartData();
            return;
        }

        // --- Pie Chart dari filteredRecaps ---
        $statusCounts = $this->filteredRecaps
            ->groupBy('status_dokumen')
            ->map->count();

        $colors = [
            '#3b82f6', '#f59e0b', '#ef4444', '#10b981', '#8b5cf6', '#fc65f7', '#84fffd'
        ];

        $this->pieChartData = [
            'labels' => $statusCounts->keys()->toArray(),
            'data' => $statusCounts->values()->toArray(),
            'colors' => array_slice($colors, 0, $statusCounts->count())
        ];

        // --- Histogram 6 bulan terakhir dari filteredRecaps ---
        $months = [];
        $labels = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthKey = $date->format('Y-m');
            $months[$monthKey] = 0;
            $labels[] = $date->format('M Y');
        }

        // Group data berdasarkan bulan
        $monthlyData = $this->filteredRecaps
            ->where('status_dokumen', 'Di Arsip')
            ->groupBy(function ($recap) {
                return Carbon::parse($recap->updated_at)->format('Y-m');
            })
            ->map->count();

        // Isi data bulanan
        foreach ($monthlyData as $monthKey => $count) {
            if (isset($months[$monthKey])) {
                $months[$monthKey] = $count;
            }
        }

        // Konversi ke akumulatif
        $cumulativeData = [];
        $runningTotal = 0;
        
        foreach ($months as $monthKey => $count) {
            $runningTotal += $count;
            $cumulativeData[] = $runningTotal;
        }

        $this->histogramData = [
            'labels' => $labels,
            'data' => $cumulativeData
        ];
        
        \Log::info('Charts generated - Pie labels: ' . json_encode($this->pieChartData['labels']));
        \Log::info('Charts generated - Histogram data: ' . json_encode($this->histogramData['data']));
        
        // Dispatch event untuk update chart di frontend
        $this->dispatch('charts-updated', [
            'pieChartData' => $this->pieChartData,
            'histogramData' => $this->histogramData
        ]);
    }
    
    private function setEmptyChartData()
    {
        $this->pieChartData = [
            'labels' => ['No Data'],
            'data' => [1],
            'colors' => ['#e5e7eb']
        ];
        $this->histogramData = [
            'labels' => ['No Data'],
            'data' => [0]
        ];
        
        \Log::info('Empty chart data set');
        
        $this->dispatch('charts-updated', [
            'pieChartData' => $this->pieChartData,
            'histogramData' => $this->histogramData
        ]);
    }

    public function search()
    {
        \Log::info('Search method called with maindealer_id: ' . $this->maindealer_id);

        // Validasi input
        if (empty($this->maindealer_id)) {
            Toaster::error('Silakan pilih Main Dealer terlebih dahulu');
            $this->setEmptyChartData();
            return;
        }

        $this->validate([
            'maindealer_id' => 'required|exists:main_dealers,id',
        ], [
            'maindealer_id.required' => 'Silakan pilih Main Dealer',
            'maindealer_id.exists' => 'Main Dealer yang dipilih tidak valid',
        ]);

        $selectedDealer = MainDealer::find($this->maindealer_id);

        if ($selectedDealer) {
            // Load data untuk tabel DAN chart dari sumber yang sama
            $this->filteredRecaps = Recap::where('main_dealer_id', $this->maindealer_id)
                ->with(['School', 'mainDealer'])
                ->orderBy('created_at', 'desc')
                ->get();

            $this->selectedDealerName = $selectedDealer->md_name;
            $this->showResults = true;

            // Generate chart dari data yang sama dengan tabel
            $this->generateChartsFromFilteredRecaps();

            if ($this->filteredRecaps->count() > 0) {
                Toaster::success('Ditemukan ' . $this->filteredRecaps->count() . ' data MoU untuk: ' . $selectedDealer->md_name);
            } else {
                Toaster::info('Tidak ada data MoU ditemukan untuk: ' . $selectedDealer->md_name);
            }
        } else {
            Toaster::error('Main Dealer tidak ditemukan');
            $this->setEmptyChartData();
        }
    }

    public function resetSearch()
    {
        \Log::info('Reset search called');
        
        // If user has main_dealer_id, reload their data
        if ($this->userMainDealerId) {
            $this->maindealer_id = $this->userMainDealerId;
            $this->autoLoadData();
            Toaster::info('Data direset ke Main Dealer Anda');
        } else {
            $this->maindealer_id = '';
            $this->filteredRecaps = collect();
            $this->showResults = false;
            $this->selectedDealerName = '';
            $this->setEmptyChartData();
            Toaster::info('Pencarian direset');
        }
        
        $this->dispatch('form-reset');
    }

    public function render()
    {
        return view('livewire.user.user-dashboard', [
            'recaps' => $this->filteredRecaps
        ]);
    }
}