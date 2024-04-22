$(document).ready(function() {
    $('#customTable').DataTable({
        // Enable search, ordering, and paging features
        searching: true,
        ordering: true,
        paging: true,
        // Additional options as needed
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        // Set DataTables language according to your preferences
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
            infoFiltered: "(disaring dari _MAX_ total data)",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Selanjutnya",
                previous: "Sebelumnya"
            },
            aria: {
                sortAscending: ": aktifkan untuk mengurutkan kolom secara ascending",
                sortDescending: ": aktifkan untuk mengurutkan kolom secara descending"
            },
            zeroRecords: "Tidak ada hasil yang ditemukan." // Custom message when no matching records are found
        }
    });
});
