import 'preline'
import '../../vendor/masmerise/livewire-toaster/resources/js'
import 'datatables.net-dt/css/dataTables.dataTables.css';
import DataTable from 'datatables.net-dt';

document.addEventListener("livewire:navigated", function () {
  let recapTable = document.querySelector('#recapTable');

  if (recapTable) {
    new DataTable(recapTable, {
      responsive: true,
      pageLength: 10,
      columnDefs: recapTable.querySelector('th:last-child')?.textContent.trim() === 'Aksi'
        ? [{ orderable: false, targets: -1 }]
        : [],
      language: {
        search: "Cari:",
        lengthMenu: "Tampilkan _MENU_ data",
        info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
        paginate: { previous: "Prev", next: "Next" }
      }
    });
  }
});