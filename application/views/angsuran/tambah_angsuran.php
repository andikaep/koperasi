<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<!DOCTYPE html>
<html>
<?php $this->load->view("admin/_includes/head.php") ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php $this->load->view("admin/_includes/header.php") ?>
  <?php $this->load->view("admin/_includes/sidebar.php") ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Alert -->
      <?php if ($this->session->flashdata('success')): ?>
        <div class="box-body">
          <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-info"></i>Alert!</h4>
            <?php echo $this->session->flashdata('success'); ?><br>
            <a href="<?php echo base_url('anggota') ?>">Saya Mengerti</a>
          </div>
        </div>
      <?php endif; ?>
      <!-- Alert -->
      <script>
// Tampilkan alert jika pesan flashdata berhasil diset
<?php if ($this->session->set_flashdata('success')): ?>
  <div class="box-body">
          <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-info"></i>Alert!</h4>
    <?php echo $this->session->set_flashdata('success'); ?>
    </div>
        </div>
<?php endif; ?>
</script>

    <section class="content-header">
      <h1>
        Kelola
        <small>Data Angsuran</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('angsuran/') ?>"><i class="fa fa-fw fa-child"></i>Lihat Data Angsuran</a></li>
        <li><a href="#">Tambah Angsuran</a></li>
      </ol>
    </section>
    

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-8">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Pengisian Form</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="<?php echo base_url('angsuran/add/'.$angsuran->id_pinjaman) ?>" method="post">
              <input type="hidden" name="id_pinjaman" value="<?php echo $angsuran->id_pinjaman?>" />
              <?php
// Ambil id_pinjaman dari input form
$id_pinjaman = $angsuran->id_pinjaman;

// Ambil nama anggota dari tabel anggota
$nama_anggota = $this->db->query("SELECT nama FROM anggota WHERE id_anggota = '{$angsuran->id_anggota}'")->row()->nama;

// Ambil nomor angsuran terakhir dari database untuk id_pinjaman tertentu
$lastAngsuran = $this->db->query("SELECT MAX(CAST(SUBSTRING_INDEX(no_angsuran, '-', -1) AS UNSIGNED)) AS last_angsuran FROM angsuran WHERE id_pinjaman = '{$id_pinjaman}'")->row()->last_angsuran;

// Jika ada nomor angsuran terakhir, tambahkan 1 untuk mendapatkan nomor angsuran baru
if ($lastAngsuran !== null) {
    $nextAngsuran = $lastAngsuran + 1;    
} else {
    // Jika tidak ada nomor angsuran terakhir, nomor angsuran baru akan menjadi 1
    $nextAngsuran = 1;
}

// Potongan id_pinjaman, nama anggota, dan nomor urut angsuran
$id_pinjaman_short = substr($id_pinjaman, 0, 3);
$nama_anggota_short = substr($nama_anggota, 0, 3);
$no_angsuran = $id_pinjaman_short . $nama_anggota_short . '-' . $nextAngsuran;
?>


<div class="box-body">
    <div class="form-group">
        <label>No Angsuran</label>
        <input name="no_angsuran" class="form-control <?php echo form_error('no_angsuran') ? 'is-invalid':'' ?>" placeholder="Masukan No Angsuran" type="text" value="<?php echo $no_angsuran ?>" readonly />
        <div class="invalid-feedback">
            <?php echo form_error('no_angsuran') ?>
        </div>
    </div>



                <div class="form-group">
                  <label>Jumlah Angsuran</label>
                  <input name="jumlah_angsuran" id="jumlah_angsuran" class="form-control <?php echo form_error('jumlah_angsuran') ? 'is-invalid':'' ?>" placeholder="Masukan Jumlah Angsuran Tanpa (.)" type="text"/>
                  <div class="invalid-feedback">
                    <?php echo form_error('jumlah_angsuran') ?>
                  </div>
                </div>
                <label>Terbilang</label>
    <p id="terbilang" class="form-control-static"></p>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
              <button class="btn btn-success" name="submit" type="button" data-toggle="modal" data-target="#confirmModal"><i class="fa fa-fw fa-plus"></i>Simpan</button>

<!-- Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h4 class="modal-title" id="confirmModalLabel">Konfirmasi Simpan Data</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <h4>Anda akan menambahkan <strong> Angsuran Sebesar <span id="modalNewJumlah"></span></h4>
        <h4 class="text-muted">Apakah Anda yakin?</h4>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" id="confirmBtn">Ya, Simpan</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>

<!-- Tambahkan script JavaScript di bagian bawah -->
<script>
    // Tambahkan kode ini ke dalam satu blok skrip JavaScript
    document.addEventListener("DOMContentLoaded", function() {
        // Tangkap elemen input jumlah
        var inputJumlah = document.querySelector('input[name="jumlah_angsuran"]');
        // Tangkap elemen teks modal
        var modalJumlah = document.getElementById('modalJumlah');
        var modalNewJumlah = document.getElementById('modalNewJumlah');

        // Tambahkan event listener untuk setiap kali nilai diubah di input
        inputJumlah.addEventListener('input', function() {
            // Perbarui nilai input dengan format rupiah saat pengguna mengisi formulir
            inputJumlah.value = formatRupiah(inputJumlah.value);
            // Perbarui teks modal dengan nilai dari input jumlah
            modalNewJumlah.textContent = inputJumlah.value;
        });

        // Perbarui nilai input dengan format rupiah saat halaman dimuat
        if (inputJumlah) {
            inputJumlah.value = formatRupiah(inputJumlah.value);
        }

        // Format angka di modal dengan format rupiah saat halaman dimuat
        if (modalJumlah) {
            modalJumlah.textContent = formatRupiah(modalJumlah.textContent);
        }

        // Tambahkan event listener untuk tombol konfirmasi
        document.getElementById('confirmBtn').addEventListener('click', function() {
            // Jalankan tindakan yang sesuai saat tombol diklik
            // Misalnya, simpan data atau lakukan aksi lainnya
            // Perbarui teks modal dengan format rupiah saat formulir disubmit
            modalNewJumlah.textContent = formatRupiah(inputJumlah.value);
        });

        // Fungsi untuk mengubah nilai menjadi format rupiah
        // Fungsi untuk mengubah nilai menjadi format rupiah
function formatRupiah(angka) {
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0][0] === '0' ? 0 : split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
    return 'Rp ' + rupiah;
}

    });

    // Hapus "Rp" saat form disubmit agar hanya angka yang disimpan ke database
    document.querySelector('form').addEventListener('submit', function() {
        var jumlah_angsuran = document.getElementById('jumlah_angsuran');
        jumlah_angsuran.value = jumlah_angsuran.value.replace('Rp ', '').replace(/\./g, '').replace(/,/g, '.');
    });
   

function terbilang(angka) {
    var bilangan = ['Nol', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan'];
    var belasan = ['Sepuluh', 'Sebelas', 'Dua belas', 'Tiga belas', 'Empat belas', 'Lima belas', 'Enam belas', 'Tujuh belas', 'Delapan belas', 'Sembilan belas'];

    // Menangani angka 0 hingga 9
    if (angka < 10) {
        return '<strong>' + bilangan[angka] + '</strong>';
    }

    // Menangani angka 11 hingga 19
    if (angka < 20) {
        return '<strong>' + belasan[angka - 10] + '</strong>';
    }

    // Menangani angka 20 hingga 99
    if (angka < 100) {
        var puluhan = Math.floor(angka / 10);
        var sisa = angka % 10;
        var hasil = (puluhan === 1 ? 'Sepuluh' : bilangan[puluhan] + ' puluh');
        if (sisa > 0) {
            hasil += ' ' + bilangan[sisa];
        }
        return '<strong>' + hasil + '</strong>';
    }

    // Menangani angka 100 hingga 999
    if (angka < 1000) {
        var ratusan = Math.floor(angka / 100);
        var sisa = angka % 100;
        var hasil = (ratusan === 1 ? 'Seratus' : bilangan[ratusan] + ' ratus');
        if (sisa > 0) {
            hasil += ' ' + terbilang(sisa);
        }
        return '<strong>' + hasil + '</strong>';
    }

    // Menangani angka 1000 hingga 999999
    if (angka < 1000000) {
        var ribuan = Math.floor(angka / 1000);
        var sisa = angka % 1000;
        var hasil = (ribuan === 1 ? 'Seribu' : terbilang(ribuan) + ' ribu');
        if (sisa > 0) {
            hasil += ' ' + terbilang(sisa);
        }
        return '<strong>' + hasil + '</strong>';
    }

    // Menangani angka 1000000 hingga 999999999
    if (angka < 1000000000) {
        var jutaan = Math.floor(angka / 1000000);
        var sisa = angka % 1000000;
        var hasil = (jutaan === 1 ? 'Satu juta' : terbilang(jutaan) + ' juta');
        if (sisa > 0) {
            hasil += ' ' + terbilang(sisa);
        }
        return '<strong>' + hasil + '</strong>';
    }

    // Menangani angka 1000000000 hingga 999999999999
    if (angka < 1000000000000) {
        var milyaran = Math.floor(angka / 1000000000);
        var sisa = angka % 1000000000;
        var hasil = (milyaran === 1 ? 'Satu milyar' : terbilang(milyaran) + ' milyar');
        if (sisa > 0) {
            hasil += ' ' + terbilang(sisa);
        }
        return '<strong>' + hasil + '</strong>';
    }

    // Menangani angka 1000000000000 hingga 999999999999999
    if (angka < 1000000000000000) {
        var trilyunan = Math.floor(angka / 1000000000000);
        var sisa = angka % 1000000000000;
        var hasil = (trilyunan === 1 ? 'Satu trilyun' : terbilang(trilyunan) + ' trilyun');
        if (sisa > 0) {
            hasil += ' ' + terbilang(sisa);
        }
        return '<strong>' + hasil + '</strong>';
    }

    // Menangani angka di atas 999999999999999 (kuadriliunan, kuintiliunan, dst.)
    var satuan = ['', 'Kuadriliun', 'Kuintiliun', 'Sekstiliun', 'Septiliun', 'Oktiliun', 'Noniliun', 'Desiliun'];
    for (var i = 2; i <= satuan.length; i++) {
        if (angka < Math.pow(1000, i)) {
            var pembagi = Math.pow(1000, i - 1);
            var jumlah_angsuran = Math.floor(angka / pembagi);
            var sisa = angka % pembagi;
            var hasil = terbilang(jumlah_angsuran) + ' ' + satuan[i - 1];
            if (sisa > 0) {
                hasil += ' ' + terbilang(sisa);
            }
            return '<strong>' + hasil + '</strong>';
        }
    }

    return 'undefined'; // Menangani angka yang tidak dapat diproses
}

// Tambahkan event listener untuk setiap kali nilai diubah di input
document.addEventListener("DOMContentLoaded", function() {
    var inputJumlah = document.getElementById('jumlah_angsuran');
    var terbilangElem = document.getElementById('terbilang');

    inputJumlah.addEventListener('input', function() {
        // Hapus karakter selain angka
        var jumlah_angsuran = inputJumlah.value.replace(/[^\d]/g, '');
        // Perbarui nilai terbilang setiap kali nilai input berubah
        if (!jumlah_angsuran) {
            terbilangElem.innerHTML = '<strong>Masukkan angka yang benar</strong>';
        } else {
            terbilangElem.innerHTML = terbilang(parseInt(jumlah_angsuran)) + ' rupiah';
        }
    });
});

</script>
                <button class="btn btn-danger" type="button" onclick="window.history.back();"><i style="margin-left: -3px;" class="fa fa-fw fa-times"></i>Batal</button>
                <button class="btn btn-warning" type="reset"><i style="margin-left: -3px;" class="fa fa-fw fa-undo"></i>Clear Data</button>
              </div>
            </form>
          </div>
          <!-- /.box -->

        </div>
        <!--/.col (left) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php $this->load->view("admin/_includes/footer.php") ?>
  <?php $this->load->view("admin/_includes/control_sidebar.php") ?>

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<?php $this->load->view("admin/_includes/bottom_script_view.php") ?>
<!-- page script -->
</body>
</html>
  