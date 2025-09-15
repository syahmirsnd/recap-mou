<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@push('scripts')
<script>
        function renderChart() {
            const canvas = document.getElementById('statusDokumenChart');
            if (!canvas) return;
            
            const ctx = canvas.getContext('2d');

            window.statusDokumenChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: @json($countRecap->keys()),
                    datasets: [{
                        data: @json($countRecap->values()),
                        backgroundColor: ['#3b82f6', '#f59e0b', '#ef4444', '#10b981', '#8b5cf6'],
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

        renderChart();

        function renderMainDealerBarChart() {
        const canvas = document.getElementById('mainDealerBarChart');
        if (!canvas) return;

        const ctx = canvas.getContext('2d');

        window.mainDealerBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($barChartData->keys()),    // nama MD
                datasets: [{
                    label: 'Jumlah SMK',
                    data: @json($barChartData->values()), // jumlah SMK per MD
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
                    x: {
                        ticks: { color: '#6b7280', font: { size: 12 } },
                        grid: { display: false }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { color: '#6b7280', stepSize: 1 },
                        grid: { color: '#e5e7eb' }
                    }
                }
            }
        });
    }

    renderMainDealerBarChart();
        
</script>
@endpush


<div class="flex h-full w-full min-h-screen flex-1 flex-col gap-4 rounded-xl">
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
                <div class="flex-1 flex items-center justify-center">
                    <span class="font-bold text-gray-900 dark:text-white text-6xl">
                        {{ $countSchool }}
                    </span>
                </div>
            </div>
        </div>
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <a href="/shep/mou-list" class="block">
                <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 flex items-center justify-center p-4">
                <span class="font-medium text-gray-900 dark:text-white justify-center text-2xl">
                    Ingin Lihat Lebih Banyak MoU?
                </span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                </svg>
                </div>
            </a>
            <a href="/shep/maindealer-list" class="block">
                <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 flex items-center justify-center p-4">
                <span class="font-medium text-gray-900 dark:text-white justify-center text-2xl">
                    Ingin Lihat Lebih Banyak Main Dealer?
                </span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                </svg>
                </div>
            </a>
            <a href="/shep/school-list" class="block">
                <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 flex items-center justify-center p-4">
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

