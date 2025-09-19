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

    public function mount()
    {
        $this->maindealers = MainDealer::orderBy('md_name', 'asc')->get();
        $this->filteredRecaps = collect();
        
        // Initialize charts with all data
        $this->loadAllChartsData();
    }

    public function loadAllChartsData()
    {
        // Get histogram data for ALL dealers - last 6 months "Di Arsip"
        $endDate = \Carbon\Carbon::now()->endOfMonth();
        $startDate = \Carbon\Carbon::now()->subMonths(5)->startOfMonth();
        
        $data = Recap::select(
            DB::raw("strftime('%Y', updated_at) as year"),
            DB::raw("strftime('%m', updated_at) as month"),
            DB::raw('COUNT(*) as count')
        )
        ->where('status_dokumen', 'Di Arsip')
        ->whereBetween('updated_at', [$startDate, $endDate])
        ->groupBy('year', 'month')
        ->orderBy('year')
        ->orderBy('month')
        ->get();

        // Create array for all 6 months with 0 counts
        $months = [];
        $labels = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = \Carbon\Carbon::now()->subMonths($i);
            $monthKey = $date->year . '-' . intval($date->month);
            $months[$monthKey] = 0;
            $labels[] = $date->format('M Y');
        }

        // Fill in actual data
        foreach ($data as $item) {
            $key = $item->year . '-' . intval($item->month);
            if (isset($months[$key])) {
                $months[$key] = $item->count;
            }
        }

        $this->histogramData = [
            'labels' => $labels,
            'data' => array_values($months)
        ];

        // Get pie chart data for ALL dealers
        $statusData = Recap::select('status_dokumen', DB::raw('COUNT(*) as count'))
            ->groupBy('status_dokumen')
            ->get();

        $colors = [
            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', 
            '#9966FF', '#FF9F40', '#FF6384', '#C9CBCF'
        ];

        $this->pieChartData = [
            'labels' => $statusData->pluck('status_dokumen')->toArray(),
            'data' => $statusData->pluck('count')->toArray(),
            'colors' => array_slice($colors, 0, $statusData->count())
        ];
    }

    public function updateChartsFromRecaps()
    {
        // Safety check for empty collection
        if ($this->filteredRecaps->isEmpty()) {
            $this->pieChartData = [
                'labels' => ['No Data'],
                'data' => [1],
                'colors' => ['#e5e7eb']
            ];
            $this->histogramData = [
                'labels' => ['No Data'],
                'data' => [0]
            ];
            return;
        }
        
        // --- Pie Chart from filtered table data ---    
        $statusCounts = $this->filteredRecaps
            ->groupBy('status_dokumen')
            ->map->count();

        $colors = [
            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', 
            '#9966FF', '#FF9F40', '#FF6384', '#C9CBCF'
        ];

        $this->pieChartData = [
            'labels' => $statusCounts->keys()->toArray(),
            'data' => $statusCounts->values()->toArray(),
            'colors' => array_slice($colors, 0, $statusCounts->count())
        ];

        // --- Histogram from filtered table data (6 months) ---
        $endDate = Carbon::now()->endOfMonth();
        $startDate = Carbon::now()->subMonths(5)->startOfMonth();

        // Create array for all 6 months with 0 counts
        $months = [];
        $labels = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthKey = $date->format('Y-m');
            $months[$monthKey] = 0;
            $labels[] = $date->format('M Y');
        }

        // Count "Di Arsip" documents by month from filtered data
        $monthlyData = $this->filteredRecaps
            ->where('status_dokumen', 'Di Arsip')
            ->groupBy(function ($recap) {
                return $recap->updated_at->format('Y-m');
            })
            ->map->count();

        // Fill in actual data
        foreach ($monthlyData as $monthKey => $count) {
            if (isset($months[$monthKey])) {
                $months[$monthKey] = $count;
            }
        }

        $counts = array_values($months);

        $this->histogramData = [
            'labels' => $labels,
            'data' => $counts
        ];

        $this->dispatch('charts-updated');
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

            // Don't update charts - keep showing all data
            // Remove the updateChartsFromRecaps() call

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
        $this->filteredRecaps = collect(); // Clear to empty, not all data
        $this->showResults = false;
        $this->selectedDealerName = '';

        // Keep charts showing all data (don't reset to empty)
        // Charts will continue showing all data

        $this->dispatch('form-reset');

        Toaster::info('Pencarian direset');
    }

    public function render()
    {
        return view('livewire.user.user-dashboard');
    }
}