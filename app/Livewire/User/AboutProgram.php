<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Recap;
use App\Models\MainDealer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AboutProgram extends Component
{
    public $selectedMainDealer = 'all';
    public $mainDealers = [];

    public function mount()
    {
        $this->mainDealers = MainDealer::select('id', 'md_name as name')->get()->toArray();
        \Log::info('Main dealers loaded:', $this->mainDealers);
    }

    public function updatedSelectedMainDealer($value)
    {
        // Debug logging
        \Log::info('Selected main dealer updated to: ' . $value);
        
        // Force a re-render and dispatch an event to update charts
        $this->dispatch('chartDataUpdated');
    }
    public function getHistogramData()
    {
        // Get data for last 6 months (current month + 5 months before)
        $endDate = Carbon::now()->endOfMonth();
        $startDate = Carbon::now()->subMonths(5)->startOfMonth();
        
        $query = Recap::select(
            DB::raw("strftime('%Y', updated_at) as year"),
            DB::raw("strftime('%m', updated_at) as month"),
            DB::raw('COUNT(*) as count')
        )
        ->where('status_dokumen', 'Di Arsip')
        ->whereBetween('updated_at', [$startDate, $endDate]);

        // Add main dealer filter if selected
        if ($this->selectedMainDealer !== 'all' && !empty($this->selectedMainDealer)) {
            $query->where('main_dealer_id', (int)$this->selectedMainDealer);
        }

        $data = $query->groupBy('year', 'month')
        ->orderBy('year')
        ->orderBy('month')
        ->get();

        // Create array for all 6 months with 0 counts
        $months = [];
        $labels = [];
        $counts = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthKey = $date->year . '-' . $date->month;
            $months[$monthKey] = 0;
            $labels[] = $date->format('M Y');
        }

        // Fill in actual data
        foreach ($data as $item) {
            $key = $item->year . '-' . intval($item->month); // Convert month to int to remove leading zero
            if (isset($months[$key])) {
                $months[$key] = $item->count;
            }
        }

        $counts = array_values($months);

        return [
            'labels' => $labels,
            'data' => $counts
        ];
    }

    public function getPieChartData()
    {
        $query = Recap::select('status_dokumen', DB::raw('COUNT(*) as count'));

        // Add main dealer filter if selected
        if ($this->selectedMainDealer !== 'all' && !empty($this->selectedMainDealer)) {
            $query->where('main_dealer_id', (int)$this->selectedMainDealer);
        }

        $data = $query->groupBy('status_dokumen')->get();

        $labels = [];
        $counts = [];
        $colors = [
            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', 
            '#9966FF', '#FF9F40', '#FF6384', '#C9CBCF'
        ];

        foreach ($data as $index => $item) {
            $labels[] = $item->status_dokumen;
            $counts[] = $item->count;
        }

        return [
            'labels' => $labels,
            'data' => $counts,
            'colors' => array_slice($colors, 0, count($labels))
        ];
    }

    public function render()
    {
        $histogramData = $this->getHistogramData();
        $pieChartData = $this->getPieChartData();

        return view('livewire.user.about-program', [
            'histogramData' => $histogramData,
            'pieChartData' => $pieChartData,
        ]);
    }
}