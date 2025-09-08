<div>
    <!-- Table Section -->
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
  <!-- Card -->
<div class="flex flex-col">
  <div class="min-w-full inline-block align-middle">
    <div class="bg-white border border-gray-200 rounded-xl shadow-2xs overflow-hidden dark:bg-neutral-900 dark:border-neutral-700">
      
      <!-- Header -->
      <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-neutral-700">
        <div>
          <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
            Memorandum of Understanding (MoU)
          </h2>
          <p class="text-sm text-gray-600 dark:text-neutral-400">
            Daftar kelengkapan MoU tiap SMK.
          </p>
        </div>

        <div>
          <div class="inline-flex gap-x-2">
          </div>
        </div>
      </div>
      <!-- End Header -->

      <!-- Table Scroll Wrapper -->
      <div class="overflow-x-auto">
         <table id="recapTable" class="display w-full">
          <thead>
            <tr>
          <th scope="col" class="px-6 py-3 text-start border-s border-gray-200 dark:border-neutral-700">
                            <span class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                              Nomor Surat
                            </span>
                          </th>
                          
                          <th scope="col" class="px-6 py-3 text-start border-s border-gray-200 dark:border-neutral-700">
                            <span class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                              Kode MD
                            </span>
                          </th>

                          <th scope="col" class="px-6 py-3 text-start">
                            <span class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                              Nama MD
                            </span>
                          </th>

                          <th scope="col" class="px-6 py-3 text-start">
                            <span class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                              NPSN
                            </span>
                          </th>

                          <th scope="col" class="px-6 py-3 text-start">
                            <span class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                              Nama SMK
                            </span>
                          </th>

                          <th scope="col" class="px-6 py-3 text-start">
                            <span class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                              Status Dokumen
                            </span>
                          </th>

                          <th scope="col" class="px-6 py-3 text-start">
                            <span class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                              Keterangan
                            </span>
                          </th>

                          <th scope="col" class="px-6 py-3 text-start">
                            <span class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                              Waktu Pengisian
                            </span>
                          </th>
                @if(auth()->user()->role == 'shep')
                  <th scope="col" class="px-6 py-3 text-start" colspan="2">
                            <span class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                              Aksi
                            </span>
                          </th>
                @endif
              </tr>
            </thead>
            <tbody>
              @foreach($recaps as $recap)
                <tr>
                  <td class="h-px w-auto whitespace-nowrap">
                            <div class="px-6 py-2">
                              <span class="text-sm text-gray-800 dark:text-neutral-200">{{  $recap->nomor_surat }}</span>
                            </div>
                          </td>
                          <td class="h-px w-auto whitespace-nowrap">
                            <div class="px-6 py-2">
                              <span class="text-sm text-gray-800 dark:text-neutral-200">{{  $recap->mainDealer->md_code }}</span>
                            </div>
                          </td>
                          <td class="h-px w-auto whitespace-nowrap">
                            <div class="px-6 py-2">
                              <span class="text-sm text-gray-800 dark:text-neutral-200">{{  $recap->mainDealer->md_name }}</span>
                            </div>
                          </td>
                          <td class="h-px w-auto whitespace-nowrap">
                            <div class="px-6 py-2">
                              <span class="text-sm text-gray-800 dark:text-neutral-200">{{  $recap->School->npsn }}</span>
                            </div>
                          </td>
                          <td class="h-px w-auto whitespace-nowrap">
                            <div class="px-6 py-2">
                              <span class="text-sm text-gray-800 dark:text-neutral-200">{{  $recap->School->school_name }}</span>
                            </div>
                          </td>
                          <td class="h-px w-auto whitespace-nowrap">
                            <div class="px-6 py-2">
                              <span class="text-sm text-gray-800 dark:text-neutral-200">{{  $recap->status_dokumen}}</span>
                            </div>
                          </td>
                          <td class="h-px w-auto whitespace-nowrap">
                            <div class="px-6 py-2">
                              <span class="text-sm text-gray-800 dark:text-neutral-200">{{  $recap->keterangan }}</span>
                            </div>
                          </td>
                          <td class="h-px w-auto whitespace-nowrap">
                            <div class="px-6 py-2">
                              <span class="text-sm text-gray-800 dark:text-neutral-200">{{  $recap->updated_at }}</span>
                            </div>
                          </td>
                  @if(auth()->user()->role == 'shep')
                                    <td class="h-px w-auto whitespace-nowrap px-2 py-2">
                            <a href="/edit/mou/{{ $recap->id }}"
                              class="py-2 px-3 flex justify-center items-center size-11 text-sm font-medium 
                                      rounded-lg border border-transparent 
                                      bg-yellow-500 text-white 
                                      hover:bg-yellow-600 focus:outline-hidden focus:bg-yellow-600 
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
                                      hover:bg-red-600 focus:outline-hidden focus:bg-red-600 
                                      disabled:opacity-50 disabled:pointer-events-none">
                              
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24 " stroke-width="2" stroke="currentColor" class="size-4">
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
      <!-- End Table Scroll Wrapper -->

    </div>
  </div>
</div>
<!-- End Card -->
</div>
<!-- End Table Section -->
</div>
