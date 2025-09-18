<div>
    <!-- Comment Form -->
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
  <div class="mx-auto max-w-2xl">
    <div class="text-center">
      <h2 class="text-xl text-gray-800 font-bold sm:text-3xl dark:text-white">
        Tambah SMK Baru
      </h2>
    </div>

    <!-- Card -->
    <div class="mt-5 p-4 relative z-10 bg-white border border-gray-200 rounded-xl sm:mt-10 md:p-10 dark:bg-neutral-900 dark:border-neutral-700">
      <form wire:submit="save">
        <div class="mb-4 sm:mb-8">
          <label for="npsn" class="block mb-2 text-sm font-medium dark:text-white">NPSN</label>
          <input type="number" id="npsn" wire:model="npsn" class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="1234567890">
          @error ('npsn')
                <span class="text-red-500">{{ $message }}</span>
          @enderror
        </div>
        <div class="mb-4 sm:mb-8">
          <label for="school_name" class="block mb-2 text-sm font-medium dark:text-white">Nama SMK</label>
          <input type="text" id="school_name" wire:model="school_name" class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="SMK Percontohan 1">
          @error ('school_name')
                <span class="text-red-500">{{ $message }}</span>
          @enderror
        </div>

        <div class="mb-4 sm:mb-8"
            x-data="{ 
                open: false, 
                search: '', 
                selectedName: 'Pilih Main Dealer',
                selectedId: @entangle('maindealer_id') 
            }"
            x-init="
                // Reset when form is submitted
                $wire.on('form-reset', () => {
                    search = '';
                    selectedName = 'Pilih Main Dealer';
                    selectedId = '';
                });
            "
            @click.away="open = false">

            <label for="maindealer_id" class="block mb-2 text-sm font-medium dark:text-white">Main Dealer</label>

            <!-- Trigger -->
            <button type="button"
                class="w-full py-2.5 sm:py-3 px-4 flex justify-between items-center border border-gray-200 rounded-lg sm:text-sm 
                      focus:border-blue-500 focus:ring focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                @click="open = !open">
                <span x-text="selectedName"></span>
                <svg class="w-2.5 h-2.5 ms-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="m1 1 4 4 4-4"/>
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="open" x-transition 
                class="mt-2 w-full bg-white shadow-md rounded-lg p-3 dark:bg-neutral-900 max-h-64 overflow-y-auto z-10">

                <!-- Search -->
                <div class="mb-3">
                    <input type="text" placeholder="Cari Main Dealer..."
                          class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring 
                                  focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-800 dark:border-neutral-600 dark:text-white"
                          x-model="search"
                          @click.stop>
                </div>

                <!-- List -->
                <ul class="space-y-2">
                    @foreach ($maindealers as $dealer)
                        <li x-show="{{ json_encode($dealer->md_name) }}.toLowerCase().includes(search.toLowerCase())">
                            <button type="button"
                                class="w-full text-left px-2 py-1.5 rounded hover:bg-gray-100 dark:hover:bg-neutral-700 text-sm"
                                @click="
                                    selectedName = '{{ $dealer->md_name }}'; 
                                    selectedId = {{ $dealer->id }};
                                    $wire.set('maindealer_id', {{ $dealer->id }});
                                    open = false;
                                ">
                                {{ $dealer->md_name }}
                            </button>
                        </li>
                    @endforeach
                </ul>
            </div>

            @error('maindealer_id')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="mt-6 grid">
          <button type="submit" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
          <div wire:loading class="animate-spin inline-block size-6 border-3 border-current border-t-transparent text-white-600 rounded-full dark:text-white-500" role="status" aria-label="loading">
            <span class="sr-only">Loading...</span>
          </div>  
          Submit</button>
        </div>
      </form>
    </div>
    <!-- End Card -->
  </div>
</div>
<!-- End Comment Form -->
</div>
