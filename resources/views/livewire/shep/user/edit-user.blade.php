<div>
    <!-- Comment Form -->
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
  <div class="mx-auto max-w-2xl">
    <div class="text-center">
      <h2 class="text-xl text-gray-800 font-bold sm:text-3xl dark:text-white">
        Edit Pengguna
      </h2>
    </div>

    <!-- Card -->
    <div class="mt-5 p-4 relative z-10 bg-white border border-gray-200 rounded-xl sm:mt-10 md:p-10 dark:bg-neutral-900 dark:border-neutral-700">
      <form wire:submit="update">
        <div class="mb-4 sm:mb-8">
          <label for="name" class="block mb-2 text-sm font-medium dark:text-white">Nama Lengkap - Asal Instansi</label>
          <input type="text" id="name" wire:model="name" class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Rudiansyah - SMK / Main Dealer">
            @error ('name')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4 sm:mb-8">
          <label for="email" class="block mb-2 text-sm font-medium dark:text-white">Alamat Email</label>
          <input type="email" id="email" wire:model="email" class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="email@example.com">
            @error ('email')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4 sm:mb-8">
          <label for="role" class="block mb-2 text-sm font-medium dark:text-white">Role</label>
            <select id="role" wire:model="role"
                class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm 
                    focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 
                    disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 
                    dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                <option selected="">Pilih Role</option>
                <option value="shep">Shep</option>
                <option value="user">User</option>
            </select>  
            @error ('role')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4 sm:mb-8">
          <label for="shep_verified" class="block mb-2 text-sm font-medium dark:text-white">Verifikasi</label>
            <select id="shep_verified" wire:model="shep_verified"
                class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm 
                    focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 
                    disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 
                    dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>  
            @error ('shep_verified')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="mt-6 grid">
          <button type="submit" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
          <div wire:loading class="animate-spin inline-block size-6 border-3 border-current border-t-transparent text-white-600 rounded-full dark:text-white-500" role="status" aria-label="loading">
            <span class="sr-only">Loading...</span>
          </div>  
          Update</button>
        </div>
      </form>
    </div>
    <!-- End Card -->
  </div>
</div>
<!-- End Comment Form -->
</div>
