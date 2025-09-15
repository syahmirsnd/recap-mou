<div>
  @push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  function confirmDelete(id) {
    Swal.fire({
      title: 'Yakin hapus data?',
      text: "Data yang dihapus tidak bisa dikembalikan!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
      if (result.isConfirmed) {
        Livewire.dispatch('deleteMD', { id: id });
      }
    });
  }
</script>
@endpush

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
            Daftar Main Dealer
          </h2>
          <p class="text-sm text-gray-600 dark:text-neutral-400">
            Daftar Main Dealer yang Terdaftar Dalam Sistem
          </p>
        </div>

        <div>
          <div class="inline-flex gap-x-2">
            <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" href="/create/maindealer" wire:navigate>
              <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M5 12h14M12 5v14"/>
              </svg>
              Create
            </a>
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
                              Kode MD
                            </span>
                          </th>
                          
                          <th scope="col" class="px-6 py-3 text-start border-s border-gray-200 dark:border-neutral-700">
                            <span class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                              Nama Main Dealer
                            </span>
                          </th>

                          <th scope="col" class="px-6 py-3 text-start">
                            <span class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                              Jumlah SMK
                            </span>
                          </th>

                          <th scope="col" class="px-6 py-3 text-start">
                            <span class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                              Diarsipkan
                            </span>
                          </th>

                          <th scope="col" class="px-6 py-3 text-start">
                            <span class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                              Kurangnya
                            </span>
                          </th>

                          <th scope="col" class="px-6 py-3 text-start">
                            <span class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                              Persentase
                            </span>
                          </th>

                          <th scope="col" class="px-6 py-3 text-start">
                            <span class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                              Kelengkapan
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
              @foreach($mds as $md)
                <tr>
                  <td class="h-px w-auto whitespace-nowrap">
                            <div class="px-6 py-2">
                              <span class="text-sm text-gray-800 dark:text-neutral-200">{{  $md->md_code }}</span>
                            </div>
                          </td>
                          <td class="h-px w-auto whitespace-nowrap">
                            <div class="px-6 py-2">
                              <span class="text-sm text-gray-800 dark:text-neutral-200">{{  $md->md_name }}</span>
                            </div>
                          </td>
                          <td class="h-px w-auto whitespace-nowrap">
                            <div class="px-6 py-2">
                              <span class="text-sm text-gray-800 dark:text-neutral-200">{{  $md->jumlah_smk }}</span>
                            </div>
                          </td>
                          <td class="h-px w-auto whitespace-nowrap">
                            <div class="px-6 py-2">
                              <span class="text-sm text-gray-800 dark:text-neutral-200">{{  $md->diarsipkan }}</span>
                            </div>
                          </td>
                          <td class="h-px w-auto whitespace-nowrap">
                            <div class="px-6 py-2">
                              <span class="text-sm text-gray-800 dark:text-neutral-200">{{  $md->kurang }}</span>
                            </div>
                          </td>
                          <td class="h-px w-auto whitespace-nowrap">
                            <div class="px-6 py-2">
                              <span class="text-sm text-gray-800 dark:text-neutral-200">{{  $md->persen }}%</span>
                            </div>
                          </td>
                          <td class="h-px w-auto whitespace-nowrap">
                            <div class="px-6 py-2">
                              @if($md->stat === 'Lengkap')
                                <span class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-teal-100 text-teal-800 rounded-full dark:bg-teal-500/10 dark:text-teal-500">
                                  <svg class="size-2.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                  </svg>
                                  Lengkap
                                </span>
                              @else
                                <span class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-red-100 text-red-800 rounded-full dark:bg-red-500/10 dark:text-red-500">
                                  <svg class="size-2.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                                  </svg>
                                  Tidak Lengkap
                                </span>
                              @endif
                            </div>
                          </td>


                  @if(auth()->user()->role == 'shep')
                                    <td class="h-px w-auto whitespace-nowrap px-2 py-2">
                            <a href="/edit/maindealer/{{ $md->id }}"
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
                            <button type="button" onclick="confirmDelete({{ $md->id }})"
                            class="py-2 px-3 flex justify-center items-center size-11 text-sm font-medium 
                                    rounded-lg border border-transparent 
                                    bg-red-500 text-white hover:bg-red-600 focus:outline-hidden 
                                    focus:bg-red-600 disabled:opacity-50 disabled:pointer-events-none">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
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
