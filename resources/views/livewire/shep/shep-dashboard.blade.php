<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("livewire:load", () => {
        const ctx = document.getElementById('statusDokumenChart').getContext('2d');

        new Chart(ctx, {
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
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    });
</script>

<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 flex flex-col text-center p-4">
                <span class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">
                    Jumlah Main Dealer Terdaftar
                </span>
                <span class="font-bold text-gray-900 dark:text-white items-center justify-center" style="font-size: 90px">
                    {{ $countMainDealer }}
                </span>
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 flex flex-col text-center p-4">
                <span class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">
                    Distribusi Dokumen
                </span>
                <div class="flex-1 flex items-center justify-center">
                    <canvas id="statusDokumenChart"></canvas>
                </div>
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 flex flex-col text-center p-4">
                <span class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">
                    Jumlah SMK Terdaftar
                </span>
                <span class="font-bold text-gray-900 dark:text-white items-center justify-center" style="font-size: 90px">
                    {{ $countSchool }}
                </span>
            </div>
        </div>
        <div class="grid gap-4 md:grid-cols-2">
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 flex flex-col text-center p-4 h-48">
                <span class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">
                    Main Dealer dengan SMK Terbanyak
                </span>
                <span class="font-bold text-gray-900 dark:text-white flex-1 flex items-center justify-center" style="font-size: 90px">
                    {{ $countMainDealer }}
                </span>
            </div>
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 flex flex-col text-center p-4 h-48">
                <span class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">
                    Main Dealer dengan MoU di Arsip Terbanyak
                </span>
                <span class="font-bold text-gray-900 dark:text-white flex-1 flex items-center justify-center" style="font-size: 90px">
                    {{ $countSchool }}
                </span>
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

