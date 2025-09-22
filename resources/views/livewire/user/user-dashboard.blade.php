<div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@script
<script>
    let histogramChart = null;
    let statusDokumenChart = null;

    function initializeCharts() {
        if (typeof Chart === 'undefined') {
            setTimeout(initializeCharts, 100);
            return;
        }
        renderHistogramChart();
        renderStatusDokumenChart();
    }

    function renderHistogramChart() {
        const canvas = document.getElementById('histogramChart');
        if (!canvas) return;

        if (histogramChart) {
            histogramChart.destroy();
        }

        const ctx = canvas.getContext('2d');
        // Get fresh data from Livewire component
        const histogramData = @this.histogramData;
        
        console.log('Histogram data:', histogramData);
        
        histogramChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: histogramData.labels,
                datasets: [{
                    label: 'Jumlah Dokumen Di Arsip',
                    data: histogramData.data,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            color: '#6b7280'
                        },
                        grid: {
                            color: '#e5e7eb'
                        }
                    },
                    x: {
                        ticks: {
                            color: '#6b7280'
                        },
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Jumlah: ' + context.parsed.y;
                            }
                        }
                    }
                }
            }
        });
    }

    function renderStatusDokumenChart() {
        const canvas = document.getElementById('statusDokumenChart');
        if (!canvas) return;

        if (statusDokumenChart) {
            statusDokumenChart.destroy();
        }

        const ctx = canvas.getContext('2d');
        // Get fresh data from Livewire component
        const pieChartData = @this.pieChartData;
        
        console.log('Pie chart data:', pieChartData);
        
        statusDokumenChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: pieChartData.labels,
                datasets: [{
                    data: pieChartData.data,
                    backgroundColor: pieChartData.colors,
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = total > 0 ? ((context.parsed * 100) / total).toFixed(1) : 0;
                                return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });
    }

    // Initialize charts when component loads
    $nextTick(() => {
        setTimeout(initializeCharts, 100);
    });
    
    // Listen for chart updates and search completion
    Livewire.on('charts-updated', () => {
        console.log('Charts updated event received');
        setTimeout(initializeCharts, 100);
    });

    Livewire.on('search-completed', () => {
        console.log('Search completed, updating charts');
        setTimeout(initializeCharts, 200);
    });
</script>
@endscript
<!-- Hero -->
<div class="relative overflow-hidden">
  <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
    <div class="max-w-xl text-center mx-auto">
      <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-16">
        <div class="text-center mx-auto">
        <p class="text-2xl font-bold text-gray-800 dark:text-gray-400">
            Selamat datang di laman <span class="text-blue-600">Recap MoU</span>
        </p>
        <p class="mt-3 text-l text-gray-800 dark:text-gray-400">
            Ketik nama instansi pada kolom pencarian untuk melihat preview Recap MoU.
        </p>
        </div>
        <!-- Form -->
        <form wire:submit="search">
            <div class="mb-4 sm:mb-8"
                x-data="{ 
                    open: false, 
                    search: '', 
                    selectedName: 'Cari Main Dealer...',
                    selectedId: @entangle('maindealer_id')
                }"
                x-init="
                    // Reset when form is submitted
                    $wire.on('form-reset', () => {
                        search = '';
                        selectedName = 'Cari Main Dealer...';
                        selectedId = '';
                    });
                "
                @click.away="open = false">

                <!-- Search Bar Container -->
                <div class="mt-4 relative z-10 flex gap-x-3 p-3 bg-white border border-gray-200 rounded-lg shadow-lg shadow-gray-100 dark:bg-gray-900 dark:border-gray-700 dark:shadow-gray-900/20">
                    
                    <!-- Search Input Section -->
                    <div class="w-full relative">
                        <label for="maindealer-search" class="block text-sm text-gray-700 font-medium dark:text-white">
                            <span class="sr-only">Main Dealer</span>
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
                            class="py-2.5 px-4 block w-full border-transparent rounded-lg focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-transparent dark:text-gray-400 dark:placeholder-gray-500 dark:focus:ring-gray-600" 
                        >

                        <!-- Dropdown Menu -->
                        <div x-show="open && search.length > 0" 
                            x-transition
                            x-ref="dropdown"
                            class="absolute top-full left-0 mt-1 w-full bg-white shadow-lg rounded-lg border border-gray-200 dark:bg-gray-900 dark:border-gray-700 max-h-64 overflow-y-auto z-50">

                            <!-- Filtered Results -->
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

                            <!-- No Results -->
                            <div x-show="!@js($maindealers->pluck('md_name')->toArray()).some(name => name.toLowerCase().includes(search.toLowerCase()))" 
                                class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400 text-center">
                                Tidak ada main dealer yang ditemukan
                            </div>
                        </div>
                    </div>
                    
                    <!-- Search Button -->
                    <button 
                        type="submit"
                        x-ref="searchBtn"
                        class="w-20 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                        
                        <!-- Loading Spinner -->
                        <div wire:loading class="animate-spin w-5 h-5 border-2 border-current border-t-transparent rounded-full" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        
                        <!-- Search Icon -->
                        <svg wire:loading.remove class="flex-shrink-0 w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"/>
                            <path d="m21 21-4.3-4.3"/>
                        </svg>
                    </button>
                </div>

                @error('maindealer_id')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>
        </form>
        <!-- End Form -->
      </div>
    </div>
  </div>
</div>
<!-- End Hero -->
 <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <div class="relative xl:w-10/12 xl:mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
                <div class="relative h-80">
                   <div class="p-4 relative z-10 bg-white border border-gray-200 rounded-xl md:p-10 dark:bg-gray-900 dark:border-gray-700">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                            Akumulasi MoU Di Arsip - {{ $selectedDealerName }}
                        </h3>
                        <div >
                            <canvas id="histogramChart" class="w-full h-full" wire:ignore></canvas>
                        </div>
                    </div> 
                </div>

                <div class="relative h-80">
                    <div class="p-4 relative z-10 bg-white border border-gray-200 rounded-xl md:p-10 dark:bg-gray-900 dark:border-gray-700">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                            Status Distribution - {{ $selectedDealerName }}
                        </h3>
                        <div >
                            <canvas id="statusDokumenChart" class="w-full h-full" wire:ignore></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Content -->
@if($filteredRecaps->count() > 0)
    <!-- Search Results Header -->
    <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 pb-4">
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 dark:bg-blue-900/20 dark:border-blue-800">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-blue-800 dark:text-blue-200">
                        <span class="font-medium">Hasil Pencarian:</span> {{ $selectedDealerName }}
                        @if($filteredRecaps->count() > 0)
                            ({{ $filteredRecaps->count() }} data ditemukan)
                        @else
                            (Tidak ada data)
                        @endif
                    </p>
                </div>
                <div class="flex gap-2">
                    <button wire:click="resetSearch" 
                            class="text-gray-600 hover:text-gray-800 text-sm font-medium dark:text-gray-400">
                        Reset Pencarian
                    </button>
                </div>
            </div>
        </div>
    </div>
         <!-- Features -->
    
    <!-- End Features -->
    <!-- Table Section -->
    <div class="max-w-[85rem] px-4 pb-10 sm:px-6 lg:px-8 mx-auto">
        <!-- Card -->
        <div class="flex flex-col">
            <div class="min-w-full inline-block align-middle">
                <div class="bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden dark:bg-gray-900 dark:border-gray-700">
                        <!-- Table Scroll Wrapper -->
                        <div class="overflow-x-auto">
                            <table id="recapTable" class="display w-full">
                                <thead>
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-start border-s border-gray-200 dark:border-gray-700">
                                            <span class="text-xs font-semibold uppercase text-gray-800 dark:text-gray-200">Nomor Surat</span>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-start border-s border-gray-200 dark:border-gray-700">
                                            <span class="text-xs font-semibold uppercase text-gray-800 dark:text-gray-200">NPSN</span>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-start">
                                            <span class="text-xs font-semibold uppercase text-gray-800 dark:text-gray-200">Nama SMK</span>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-start">
                                            <span class="text-xs font-semibold uppercase text-gray-800 dark:text-gray-200">Kode MD</span>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-start">
                                            <span class="text-xs font-semibold uppercase text-gray-800 dark:text-gray-200">Nama MD</span>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-start">
                                            <span class="text-xs font-semibold uppercase text-gray-800 dark:text-gray-200">Status Dokumen</span>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-start">
                                            <span class="text-xs font-semibold uppercase text-gray-800 dark:text-gray-200">Keterangan</span>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-start">
                                            <span class="text-xs font-semibold uppercase text-gray-800 dark:text-gray-200">Waktu Pengisian</span>
                                        </th>
                                        @if(auth()->user()->role == 'shep')
                                            <th scope="col" class="px-6 py-3 text-start" colspan="2">
                                                <span class="text-xs font-semibold uppercase text-gray-800 dark:text-gray-200">Aksi</span>
                                            </th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($filteredRecaps as $recap)
                                        <tr>
                                            <td class="h-px w-auto whitespace-nowrap">
                                                <div class="px-6 py-2">
                                                    <span class="text-sm text-gray-800 dark:text-gray-200">{{ $recap->nomor_surat }}</span>
                                                </div>
                                            </td>
                                            <td class="h-px w-auto whitespace-nowrap">
                                                <div class="px-6 py-2">
                                                    <span class="text-sm text-gray-800 dark:text-gray-200">{{ $recap->School->npsn }}</span>
                                                </div>
                                            </td>
                                            <td class="h-px w-auto whitespace-nowrap">
                                                <div class="px-6 py-2">
                                                    <span class="text-sm text-gray-800 dark:text-gray-200">{{ $recap->School->school_name }}</span>
                                                </div>
                                            </td>
                                            <td class="h-px w-auto whitespace-nowrap">
                                                <div class="px-6 py-2">
                                                    <span class="text-sm text-gray-800 dark:text-gray-200">{{ $recap->mainDealer->md_code }}</span>
                                                </div>
                                            </td>
                                            <td class="h-px w-auto whitespace-nowrap">
                                                <div class="px-6 py-2">
                                                    <span class="text-sm text-gray-800 dark:text-gray-200">{{ $recap->mainDealer->md_name }}</span>
                                                </div>
                                            </td>
                                            <td class="h-px w-auto whitespace-nowrap">
                                                <div class="px-6 py-2">
                                                    <span class="text-sm text-gray-800 dark:text-gray-200">{{ $recap->status_dokumen }}</span>
                                                </div>
                                            </td>
                                            <td class="h-px w-auto whitespace-nowrap">
                                                <div class="px-6 py-2">
                                                    <span class="text-sm text-gray-800 dark:text-gray-200">{{ $recap->keterangan }}</span>
                                                </div>
                                            </td>
                                            <td class="h-px w-auto whitespace-nowrap">
                                                <div class="px-6 py-2">
                                                    <span class="text-sm text-gray-800 dark:text-gray-200">{{ $recap->updated_at }}</span>
                                                </div>
                                            </td>
                                            @if(auth()->user()->role == 'shep')
                                                <td class="h-px w-auto whitespace-nowrap px-2 py-2">
                                                    <a href="/edit/mou/{{ $recap->id }}"
                                                        class="py-2 px-3 flex justify-center items-center size-11 text-sm font-medium 
                                                                rounded-lg border border-transparent 
                                                                bg-yellow-500 text-white 
                                                                hover:bg-yellow-600 focus:outline-none focus:bg-yellow-600 
                                                                disabled:opacity-50 disabled:pointer-events-none">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                                                            stroke-width="2" stroke="currentColor" class="shrink-0 size-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round" 
                                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1-1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                                        </svg>
                                                    </a>
                                                </td>
                                                <td class="h-px w-auto whitespace-nowrap px-2 py-2">
                                                    <button type="button" wire:click="delete({{ $recap->id }})"
                                                        class="py-2 px-3 flex justify-center items-center size-11 text-sm font-medium 
                                                                rounded-lg border border-transparent 
                                                                bg-red-500 text-white 
                                                                hover:bg-red-600 focus:outline-none focus:bg-red-600 
                                                                disabled:opacity-50 disabled:pointer-events-none">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                        </svg>
                                                    </button>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Table Section -->
@endif
<!-- End Content -->
</div>