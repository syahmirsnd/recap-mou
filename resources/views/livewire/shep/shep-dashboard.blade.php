<div class="grid gap-6">
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
/**
 * ================================
 * GLOBAL CHART REGISTRY
 * ================================
 */
window.DashboardCharts = {
    pie: null,
    bar1: null,
    bar2: null,
};

/**
 * ================================
 * SAFE CANVAS GETTER
 * ================================
 */
function getCanvas(id) {
    const el = document.getElementById(id);
    return el ? el.getContext('2d') : null;
}

/**
 * ================================
 * RENDER FUNCTIONS
 * ================================
 */
function renderGlobalPie() {
    const ctx = getCanvas('chart-global-pie');
    if (!ctx) return false;

    if (DashboardCharts.pie) {
        DashboardCharts.pie.destroy();
    }

    DashboardCharts.pie = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: @json($countRecap->keys()),
            datasets: [{
                data: @json($countRecap->values()),
                backgroundColor: [
                    '#3b82f6','#f59e0b','#ef4444',
                    '#10b981','#8b5cf6','#ec4899'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });

    return true;
}

function renderGlobalBar1() {
    const ctx = getCanvas('chart-global-bar1');
    if (!ctx) return false;

    if (DashboardCharts.bar1) {
        DashboardCharts.bar1.destroy();
    }

    const isMobile = window.innerWidth < 640;

    DashboardCharts.bar1 = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($barChartData->keys()),
            datasets: [{
                data: @json($barChartData->values()),
                backgroundColor: '#3b82f6',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: {
                    ticks: { font: { size: isMobile ? 8 : 12 } },
                    grid: { display: false }
                },
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });

    return true;
}

function renderGlobalBar2() {
    const ctx = getCanvas('chart-global-bar2');
    if (!ctx) return false;

    if (DashboardCharts.bar2) {
        DashboardCharts.bar2.destroy();
    }

    const isMobile = window.innerWidth < 640;

    DashboardCharts.bar2 = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($barChartData2->keys()),
            datasets: [{
                data: @json($barChartData2->values()),
                backgroundColor: '#ef4444',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: {
                    ticks: { font: { size: isMobile ? 8 : 12 } },
                    grid: { display: false }
                },
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });

    return true;
}

/**
 * ================================
 * MASTER RENDER (MANUAL)
 * ================================
 */
function renderChartsManually(retry = 0) {
    if (typeof Chart === 'undefined') {
        return setTimeout(() => renderChartsManually(retry), 100);
    }

    const ok =
        renderGlobalPie() &&
        renderGlobalBar1() &&
        renderGlobalBar2();

    if (!ok && retry < 20) {
        // DOM belum siap → retry
        setTimeout(() => renderChartsManually(retry + 1), 100);
    }
}

// trigger pertama (awal load)
renderChartsManually();

// trigger setelah Livewire render ulang
document.addEventListener('livewire:navigated', () => {
    renderChartsManually();
});

// trigger resize (optional tapi recommended)
window.addEventListener('resize', () => {
    renderChartsManually();
});
</script>
@endpush


{{-- ================= GLOBAL SUMMARY SECTION ================= --}}
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Dashboard Overview</h2>
        <span class="text-sm text-gray-500 dark:text-gray-400">Global Statistics</span>
    </div>

    {{-- Summary Cards --}}
    <div class="grid md:grid-cols-3 gap-4">
        <div class="p-6 bg-white border border-gray-200 rounded-xl text-center shadow-sm hover:shadow-md transition-shadow">
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Total Main Dealer</p>
            <p class="text-5xl font-bold text-blue-600">{{ $countMainDealer }}</p>
        </div>

        <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow">
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3 text-center">Document Status Distribution</p>
            <div class="h-56" wire:ignore>
                <canvas id="chart-global-pie"></canvas>
            </div>
        </div>

        <div class="p-6 bg-white border border-gray-200 rounded-xl text-center shadow-sm hover:shadow-md transition-shadow">
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Total SMK</p>
            <p class="text-5xl font-bold text-green-600">{{ $countSchool }}</p>
        </div>
    </div>

    {{-- Bar Charts --}}
    <div class="grid lg:grid-cols-2 gap-6">
        <div class="bg-white border border-gray-200 p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-white mb-4">Top 5 Main Dealers by Schools</h3>
            <div class="h-80" wire:ignore>
                <canvas id="chart-global-bar1"></canvas>
            </div>
        </div>
        <div class="bg-white border border-gray-200 p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-white mb-4">Top 5 Main Dealers by Archived Documents</h3>
            <div class="h-80" wire:ignore>
                <canvas id="chart-global-bar2"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- ================= SEARCH SECTION ================= --}}
<div class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">
    <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Filter by Main Dealer</h2>
    
    <form wire:submit.prevent="search">
        <div class="mb-4 sm:mb-8"
            x-data="{ 
                open: false, 
                search: '', 
                selectedName: 'Cari Main Dealer...',
                selectedId: @entangle('maindealer_id')
            }"
            x-init="
                $wire.on('form-reset', () => {
                    search = '';
                    selectedName = 'Cari Main Dealer...';
                    selectedId = '';
                });
            "
            @click.away="open = false">

            <div class="relative z-10 flex gap-x-3 p-3 bg-white border border-gray-200 rounded-lg shadow-lg shadow-gray-100 dark:bg-gray-900 dark:border-gray-700 dark:shadow-gray-900/20">
                
                <div class="w-full relative">
                    <label for="maindealer-search" class="block text-sm text-gray-700 font-medium dark:text-white mb-2">
                        Select Main Dealer to Filter
                    </label>
                    <input 
                        type="text" 
                        name="maindealer-search" 
                        id="maindealer-search"
                        x-model="search"
                        @focus="open = true; if (search === 'Cari Main Dealer...') { search = '' }"
                        @input="open = true"
                        @keydown.escape="open = false"
                        @keydown.enter.prevent="$refs.searchBtn.click()"
                        @keydown.arrow-down.prevent="
                            if (open) {
                                let items = $refs.dropdown?.querySelectorAll('[data-dealer-item]');
                                if (items && items.length > 0) items[0].focus();
                            }
                        "
                        :placeholder="selectedId ? selectedName : 'Cari Main Dealer...'"
                        class="py-2.5 px-4 block w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-400 dark:placeholder-gray-500 dark:focus:ring-gray-600" 
                    >

                    <div x-show="open && search.length > 0" 
                        x-transition
                        x-ref="dropdown"
                        class="absolute top-full left-0 mt-1 w-full bg-white shadow-lg rounded-lg border border-gray-200 dark:bg-gray-900 dark:border-gray-700 max-h-64 overflow-y-auto z-50">

                        <ul class="py-1">
                            @foreach ($maindealers as $dealer)
                                <li x-show="{{ json_encode($dealer->md_name) }}.toLowerCase().includes(search.toLowerCase())"
                                    data-dealer-item
                                    tabindex="0"
                                    @click="
                                        selectedName = '{{ $dealer->md_name }}'; 
                                        selectedId = {{ $dealer->id }};
                                        search = '{{ $dealer->md_name }}';
                                        $wire.set('maindealer_id', {{ $dealer->id }});
                                        open = false;
                                    "
                                    @keydown.enter.prevent="
                                        selectedName = '{{ $dealer->md_name }}'; 
                                        selectedId = {{ $dealer->id }};
                                        search = '{{ $dealer->md_name }}';
                                        $wire.set('maindealer_id', {{ $dealer->id }});
                                        open = false;
                                    "
                                    @keydown.arrow-down.prevent="
                                        let next = $event.target.nextElementSibling;
                                        if (next) next.focus();
                                    "
                                    @keydown.arrow-up.prevent="
                                        let prev = $event.target.previousElementSibling;
                                        if (prev) prev.focus();
                                        else $refs.input?.focus();
                                    "
                                    class="px-4 py-2 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 focus:bg-gray-100 dark:focus:bg-gray-700 focus:outline-none text-sm text-gray-900 dark:text-white transition-colors">
                                    <div class="font-medium">{{ $dealer->md_name }}</div>
                                </li>
                            @endforeach
                        </ul>

                        <div x-show="!@js($maindealers->pluck('md_name')->toArray()).some(name => name.toLowerCase().includes(search.toLowerCase()))" 
                            class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400 text-center">
                            Tidak ada main dealer yang ditemukan
                        </div>
                    </div>
                </div>
                
                <div class="flex items-end">
                    <button 
                        type="submit"
                        x-ref="searchBtn"
                        class="h-11 w-20 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none transition-colors">
                        
                        <div wire:loading wire:target="search" class="animate-spin w-5 h-5 border-2 border-current border-t-transparent rounded-full" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        
                        <svg wire:loading.remove wire:target="search" class="flex-shrink-0 w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"/>
                            <path d="m21 21-4.3-4.3"/>
                        </svg>
                    </button>
                </div>
            </div>

            @error('maindealer_id')
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
            @enderror
        </div>
    </form>
</div>

{{-- ================= FILTERED RESULTS SECTION ================= --}}
@if($showResults)
<div class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-6" 
     x-data
     x-init="$nextTick(() => $el.scrollIntoView({ behavior: 'smooth', block: 'start' }))">
    
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Filtered Results</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                Showing data for: <span class="font-semibold text-blue-600">{{ $selectedDealerName }}</span>
            </p>
        </div>
        <button 
            wire:click="resetFilter"
            type="button"
            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            Clear Filter
        </button>
    </div>

    {{-- Filtered Stats Summary --}}
    <div class="grid md:grid-cols-4 gap-4 mb-6">
        <div class="p-6 bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-xl text-center">
            <p class="text-sm text-blue-700 mb-2 font-medium">Total Records</p>
            <p class="text-4xl font-bold text-blue-600">{{ $filteredRecaps->count() }}</p>
        </div>
        <div class="p-6 bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-xl text-center">
            <p class="text-sm text-green-700 mb-2 font-medium">Di Arsip</p>
            <p class="text-4xl font-bold text-green-600">{{ $filteredRecaps->where('status_dokumen', 'Di Arsip')->count() }}</p>
        </div>
        <div class="p-6 bg-gradient-to-br from-amber-50 to-amber-100 border border-amber-200 rounded-xl text-center">
            <p class="text-sm text-amber-700 mb-2 font-medium">In Progress</p>
            <p class="text-4xl font-bold text-amber-600">{{ $filteredRecaps->whereNotIn('status_dokumen', ['Di Arsip', 'Rejected'])->count() }}</p>
        </div>
        <div class="p-6 bg-gradient-to-br from-red-50 to-red-100 border border-red-200 rounded-xl text-center">
            <p class="text-sm text-red-700 mb-2 font-medium">Rejected</p>
            <p class="text-4xl font-bold text-red-600">{{ $filteredRecaps->where('status_dokumen', 'Rejected')->count() }}</p>
        </div>
    </div>

    {{-- Status Breakdown --}}
    <div class="grid md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white border border-gray-200 p-6 rounded-xl shadow-sm">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-white mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Status Distribution
            </h3>
            <div class="space-y-3">
                @php
                    $statusGroups = $filteredRecaps->groupBy('status_dokumen');
                    $total = $filteredRecaps->count();
                @endphp
                
                @foreach($statusGroups as $status => $items)
                    @php
                        $count = $items->count();
                        $percentage = $total > 0 ? round(($count / $total) * 100, 1) : 0;
                        
                        // Color mapping
                        $colors = [
                            'Di Arsip' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'bar' => 'bg-green-500'],
                            'Rejected' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'bar' => 'bg-red-500'],
                        ];
                        
                        $color = $colors[$status] ?? ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'bar' => 'bg-blue-500'];
                    @endphp
                    
                    <div class="flex items-center justify-between p-3 {{ $color['bg'] }} rounded-lg">
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-1">
                                <span class="{{ $color['text'] }} font-semibold text-sm">{{ $status }}</span>
                                <span class="{{ $color['text'] }} font-bold">{{ $count }}</span>
                            </div>
                            <div class="w-full bg-white rounded-full h-2">
                                <div class="{{ $color['bar'] }} h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                            <span class="{{ $color['text'] }} text-xs mt-1 block">{{ $percentage }}%</span>
                        </div>
                    </div>
                @endforeach
                
                @if($statusGroups->isEmpty())
                    <p class="text-gray-500 text-center py-4">No data available</p>
                @endif
            </div>
        </div>

        <div class="bg-white border border-gray-200 p-6 rounded-xl shadow-sm">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-white mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Recent Activity
            </h3>
            <div class="space-y-2">
                @foreach($filteredRecaps->sortByDesc('updated_at')->take(5) as $recap)
                    <div class="flex items-start p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex-shrink-0 mr-3">
                            @if($recap->status_dokumen === 'Di Arsip')
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            @elseif($recap->status_dokumen === 'Rejected')
                                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            @else
                                <div class="w-8 h-8 bg-amber-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $recap->school->school_name ?? 'N/A' }}</p>
                            <p class="text-xs text-gray-500">{{ $recap->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @endforeach
                
                @if($filteredRecaps->isEmpty())
                    <p class="text-gray-500 text-center py-4">No recent activity</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Filtered Data Table --}}
    @if($filteredRecaps->isNotEmpty())
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-white flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                All Records
            </h3>
            <span class="text-sm text-gray-500">{{ $filteredRecaps->count() }} total</span>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">School Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Updated</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($filteredRecaps as $index => $recap)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $index + 1 }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <div class="font-medium">{{ $recap->school->school_name ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($recap->status_dokumen === 'Di Arsip') bg-green-100 text-green-800
                                @elseif($recap->status_dokumen === 'Rejected') bg-red-100 text-red-800
                                @else bg-amber-100 text-amber-800
                                @endif">
                                {{ $recap->status_dokumen }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div>{{ $recap->updated_at->format('d M Y') }}</div>
                            <div class="text-xs text-gray-400">{{ $recap->updated_at->format('H:i') }}</div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-12 text-center">
        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        <h3 class="text-lg font-semibold text-gray-700 mb-2">No Data Found</h3>
        <p class="text-gray-500">No records available for this Main Dealer</p>
    </div>
    @endif
</div>
@endif

</div>