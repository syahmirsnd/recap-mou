<x-layouts.app :title="__('CCO Recap MOU | Dashboard')">
    <!-- Hero -->
    <div class="relative overflow-hidden">
    <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-24">
        <div class="text-center">
        <h1 class="text-4xl sm:text-6xl font-bold text-gray-800 dark:text-neutral-200">
            Dashboard
        </h1>

        <p class="mt-3 text-gray-600 dark:text-neutral-400">
            Cari informasi MoU berdasarkan Main Dealer Anda!
        </p>

        <div class="mt-7 sm:mt-12 mx-auto max-w-xl relative">
            <!-- Form -->
            <form>
            <div class="relative z-10 flex gap-x-3 p-3 bg-white border border-gray-200 rounded-lg shadow-lg shadow-gray-100 dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-gray-900/20">
                <div class="w-full">
                <label for="hs-search-article-1" class="block text-sm text-gray-700 font-medium dark:text-white"><span class="sr-only">Cari Main Dealer</span></label>
                <input type="text" name="hs-search-article-1" id="hs-search-article-1" class="py-2.5 px-4 block w-full border-transparent rounded-lg focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-transparent dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Cari Main Dealer...">
                </div>
                <div>
                <a class="size-11 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" href="#">
                    <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                </a>
                </div>
            </div>
            </form>
            <!-- End Form -->
        </div>
    </div>
    </div>
    <!-- End Hero -->
</x-layouts.app>
