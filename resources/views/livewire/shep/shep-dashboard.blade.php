<div class="grid gap-4">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@push('scripts')
<script>
    (function() {
        let statusDokumenChart = null;
        let mainDealerBarChart = null;
        let mainDealerBarChart2 = null;

        function initializeCharts() {
            if (typeof Chart === 'undefined') {
                setTimeout(initializeCharts, 100);
                return;
            }

            renderStatusDokumenChart();
            renderMainDealerBarChart();
            renderMainDealerBarChart2();
        }

        function renderStatusDokumenChart() {
            const canvas = document.getElementById('statusDokumenChart');
            if (!canvas) return;

            if (statusDokumenChart) {
                statusDokumenChart.destroy();
            }

            const ctx = canvas.getContext('2d');
            
            statusDokumenChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: @json($countRecap->keys()),
                    datasets: [{
                        data: @json($countRecap->values()),
                        backgroundColor: ['#3b82f6', '#f59e0b', '#ef4444', '#10b981', '#8b5cf6', '#fc65f7', '#84fffd'],
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });
        }

        function renderMainDealerBarChart() {
            const canvas = document.getElementById('mainDealerBarChart');
            if (!canvas) return;

            if (mainDealerBarChart) {
                mainDealerBarChart.destroy();
            }

            const ctx = canvas.getContext('2d');
            const isMobile = window.innerWidth < 640;

            mainDealerBarChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($barChartData->keys()),
                    datasets: [{
                        label: 'Jumlah SMK',
                        data: @json($barChartData->values()),
                        backgroundColor: '#3b82f6',
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        x: { ticks: { color: '#6b7280', font: { size: isMobile ? 7 : 12 }}, grid: { display: false } },
                        y: { beginAtZero: true, ticks: { color: '#6b7280', stepSize: 1 }, grid: { color: '#e5e7eb' } }
                    }
                }
            });
        }

        function renderMainDealerBarChart2() {
            const canvas = document.getElementById('mainDealerBarChart2');
            if (!canvas) return;

            if (mainDealerBarChart2) {
                mainDealerBarChart2.destroy();
            }

            const ctx = canvas.getContext('2d');
            const isMobile = window.innerWidth < 640;

            mainDealerBarChart2 = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($barChartData2->keys()),
                    datasets: [{
                        label: 'MoU di Arsip',
                        data: @json($barChartData2->values()),
                        backgroundColor: '#e20820',
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        x: { ticks: { color: '#6b7280', font: { size: isMobile ? 7 : 12 }}, grid: { display: false } },
                        y: { beginAtZero: true, ticks: { color: '#6b7280', stepSize: 1 }, grid: { color: '#e5e7eb' } }
                    }
                }
            });
        }

        function handleResize() {
            clearTimeout(window.resizeTimeout);
            window.resizeTimeout = setTimeout(() => {
                renderMainDealerBarChart();
                renderMainDealerBarChart2();
            }, 250);
        }

        function initialize() {
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initializeCharts);
            } else {
                setTimeout(initializeCharts, 100);
            }
            
            window.addEventListener('resize', handleResize);
        }

        initialize();
    })();
</script>
@endpush
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative h-100 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 flex flex-col text-center p-4">
                <span class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">
                    Jumlah Main Dealer Terdaftar
                </span>
                <div class="flex-1 flex items-center justify-center">
                    <span class="font-bold text-gray-900 dark:text-white items-center justify-center" style="font-size: 90px">
                        {{ $countMainDealer }}
                    </span>
                </div>
            </div>
            <div class="relative h-100 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 flex flex-col text-center p-4">
                <span class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">
                    Distribusi Dokumen
                </span>
                <div class="flex-1 flex items-center justify-center">
                    <div class="w-full h-full max-h-60"> 
                        <canvas id="statusDokumenChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="relative h-100 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 flex flex-col text-center p-4">
                <span class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">
                    Jumlah SMK Terdaftar
                </span>
                <div class="flex-1 flex items-center justify-center">
                    <span class="font-bold text-gray-900 dark:text-white items-center justify-center" style="font-size: 90px">
                        {{ $countSchool }}
                    </span>
                </div>
            </div>
        </div>
        <div class="grid gap-4 md:grid-cols-2">
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 flex flex-col text-center p-4 h-[450px]">
                <span class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">
                    Main Dealer dengan SMK Terbanyak
                </span>
                <div class="flex-1 flex items-center justify-center w-full">
                    <canvas id="mainDealerBarChart" class="w-full h-full"></canvas>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 flex flex-col text-center p-4 h-96">
                <span class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">
                    Main Dealer dengan MoU di Arsip Terbanyak
                </span>
                <div class="flex-1 flex items-center justify-center w-full">
                    <canvas id="mainDealerBarChart2" class="w-full h-full"></canvas>
                </div>
            </div>
        </div>
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <a href="/shep/mou-list" class="block">
                <div class="relative h-40 sm:h-48 md:h-52 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 flex items-center justify-center p-4">
                <span class="font-medium text-gray-900 dark:text-white justify-center text-2xl">
                    Ingin Lihat Lebih Banyak MoU?
                </span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                </svg>
                </div>
            </a>
            <a href="/shep/maindealer-list" class="block">
                <div class="relative h-40 sm:h-48 md:h-52 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 flex items-center justify-center p-4">
                <span class="font-medium text-gray-900 dark:text-white justify-center text-2xl">
                    Ingin Lihat Lebih Banyak Main Dealer?
                </span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                </svg>
                </div>
            </a>
            <a href="/shep/school-list" class="block">
                <div class="relative h-40 sm:h-48 md:h-52 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 flex items-center justify-center p-4">
                <span class="font-medium text-gray-900 dark:text-white justify-center text-2xl">
                    Ingin Lihat Lebih Banyak SMK?
                </span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                </svg>
                </div>
            </a>
        </div>
        
        
</div>

