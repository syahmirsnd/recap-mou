<div>
    <!-- Comment Form -->
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
  <div class="mx-auto max-w-2xl">
    <div class="text-center">
      <h2 class="text-xl text-gray-800 font-bold sm:text-3xl dark:text-white">
        Tambah MoU Baru
      </h2>
    </div>

    <!-- Card -->
    <div class="mt-5 p-4 relative z-10 bg-white border border-gray-200 rounded-xl sm:mt-10 md:p-10 dark:bg-neutral-900 dark:border-neutral-700">
      <form wire:submit="save">
        <div class="mb-4 sm:mb-8">
          <label for="nomorsurat" class="block mb-2 text-sm font-medium dark:text-white">Nomor Surat</label>
          <input type="number" id="nomorsurat" wire:model="nomorsurat" class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Nomor Surat">
          @error ('nomorsurat')
                <span class="text-red-500">{{ $message }}</span>
          @enderror
        </div>

        <div class="mb-4 sm:mb-8">
          <label for="maindealer_id" class="block mb-2 text-sm font-medium dark:text-white">Main Dealer</label>
            <select id="maindealer_id" wire:model="maindealer_id"
                class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm 
                    focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 
                    disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 
                    dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                <option selected="">Pilih Main Dealer</option>
                @foreach ($maindealers as $dealer)
                    <option value="{{$dealer->id}}">{{ $dealer->md_name }} </option>
                @endforeach
            </select>  
            @error ('maindealer_id')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4 sm:mb-8">
          <label for="school_id" class="block mb-2 text-sm font-medium dark:text-white">SMK</label>
          <select id="school_id" wire:model="school_id"
                class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm 
                    focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 
                    disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 
                    dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                <option selected="">Pilih SMK</option>
                @foreach ($schools_id as $school)
                    <option value="{{$school->id}}">{{ $school->school_name }} </option>
                @endforeach
            </select> 
            @error ('school_id')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4 sm:mb-8">
          <label for="status_dokumen" class="block mb-2 text-sm font-medium dark:text-white">Status Dokumen</label>
            <select id="status_dokumen" wire:model="status_dokumen"
                class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm 
                    focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 
                    disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 
                    dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                <option selected="">Pilih Status Dokumen</option>
                <option value="Di Arsip">Di Arsip</option>
                <option value="Proses TTD (4)">Proses TTD (4)</option>
                <option value="Proses TTD (3)">Proses TTD (3)</option>
                <option value="Proses TTD (2)">Proses TTD (2)</option>
                <option value="Dikembalikan">Dikembalikan</option>
                <option value="Belum Diterima">Belum Diterima</option>
                <option value="SMK Terminasi">SMK Terminasi</option>
            </select> 
            @error ('status_dokumen')
                <span class="text-red-500">{{ $message }}</span>
            @enderror 
        </div>

        <div>
          <label for="keterangan" class="block mb-2 text-sm font-medium dark:text-white">Keterangan</label>
          <div class="mt-1">
            <textarea id="keterangan" wire:model="keterangan" name="hs-feedback-post-comment-textarea-1" rows="3" class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Berikan keterangan disini..."></textarea>
          </div>
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
