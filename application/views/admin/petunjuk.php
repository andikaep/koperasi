<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<!DOCTYPE html>
<html>
  <style>
    .result-item {
  margin-bottom: 10px;
}

.result-label {
  font-weight: bold;
  margin-bottom: 5px;
}

.result-value {
  font-size: 18px;
  margin: 0;
}
</style>
<style>
  .toggle-answer {
    border: none;
    background: none;
    cursor: pointer;
    float: right;
    font-size: 1em;
    outline: none;
  }
  .toggle-answer:hover {
    color: blue; /* Warna ketika tombol dihover */
  }
  .question-answer {
    margin-top: 10px; /* Jarak antara pertanyaan dan jawaban */
    font-style: italic; /* Gaya teks jawaban */
    max-height: 200px; /* Set tinggi maksimum */
    overflow-y: auto; /* Tambahkan bilah geser vertikal jika konten melebihi tinggi maksimum */
  }
</style>

<!-- JavaScript code -->
<script>
  function toggleAnswer(id) {
    var answer = document.getElementById(id);
    var button = document.getElementById('toggleButton' + id.charAt(id.length-1));
    if (answer.style.display === 'none') {
      answer.style.display = 'block';
      button.textContent = '-';
    } else {
      answer.style.display = 'none';
      button.textContent = '+';
    }
  }
</script>
<?php $this->load->view("admin/_includes/head.php") ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php $this->load->view("admin/_includes/header.php") ?>
  <?php $this->load->view("admin/_includes/sidebar.php") ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <section class="content-header">
      <h1>
        Kelola
        <small>Data Pinjaman</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('pinjaman/list_anggota') ?>"><i class="fa fa-fw fa-child"></i>Lihat Data Anggota</a></li>
        <li><a href="#">Tambah Pinjaman</a></li>
      </ol>
    </section>

    <!-- Main content -->
        <section class="content">
        <div class="row">
            <!-- left column -->
           <!-- Form Pinjaman -->
<div class="col-md-12">
  <!-- Form box -->
  <div class="box box-primary">
    <!-- Box header -->
    <div class="box-header with-border">
      <h3 class="box-title">Pertanyaan</h3>
    </div>
    <!-- Box body -->
    <div class="box-body">
      <!-- Pertanyaan 1 -->
      <div class="question" onclick="toggleAnswer('answer1')">
        <div class="question-title">
          Apakah kamu jago?
          <button id="toggleButton1" class="toggle-answer">+</button>
        </div>
        <div id="answer1" class="question-answer" style="display: none;">Saya yang terbaik Saya yang terbaik Saya yang terbaik Saya yang terbaik Saya yang terbaik Saya yang terbaik Saya yang terbaik Saya yang terbaik Saya yang terbaik Saya yang terbaik Saya yang terbaik Saya yang terbaik Saya yang terbaik Saya yang terbaik Saya yang terbaik Saya yang terbaik Saya yang terbaik Saya yang terbaik Saya yang terbaik Saya yang terbaik Saya yang terbaik Saya yang terbaik Saya yang terbaik Saya yang terbaik Saya yang terbaik Saya yang terbaik Saya yang terbaik Saya yang terbaik Saya yang terbaik Saya yang terbaik Saya yang terbaik Saya yang terbaik </div>
      </div>
      <hr> <!-- Garis pemisah -->
      <!-- Pertanyaan 2 -->
      <div class="question" onclick="toggleAnswer('answer2')">
        <div class="question-title">
          Apakah Anda yakin sejago itu?
          <button id="toggleButton2" class="toggle-answer">+</button>
        </div>
        <div id="answer2" class="question-answer" style="display: none;">Saya tak tertandingi</div>
      </div>
      <hr> <!-- Garis pemisah -->
      <!-- Pertanyaan 3 -->
      <div class="question" onclick="toggleAnswer('answer3')">
        <div class="question-title">
          Puput cantiks ?
          <button id="toggleButton3" class="toggle-answer">+</button>
        </div>
        <div id="answer3" class="question-answer" style="display: none;">Cantiks sekalii</div>
      </div>
      <hr> <!-- Garis pemisah -->
      <!-- Pertanyaan 4 -->
      <div class="question" onclick="toggleAnswer('answer4')">
        <div class="question-title">
          Kenapa hidupmu seperti ini?
          <button id="toggleButton4" class="toggle-answer">+</button>
        </div>
        <div id="answer4" class="question-answer" style="display: none;">Ada suatu masalah</div>
      </div>
      <hr>
      <div class="question" onclick="toggleAnswer('answer5')">
        <div class="question-title">
          Apakah akan membaik?
          <button id="toggleButton5" class="toggle-answer">+</button>
        </div>
        <div id="answer5" class="question-answer" style="display: none;">Semoga saja</div>
      </div>
      <hr> <!-- Garis pemisah -->
     
    </div>
  </div>
</div>
<!-- /.col (left) -->

        <!-- Show Simulation Card -->
<div class="col-md-4" id="simulationCard" style="display: none;">
  <div class="box box-success">
    <div class="box-header with-border" style="background-color: #28a745; color: #fff;">
      <h3 class="box-title">Simulasi Pinjaman</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="result-item">
        <p class="result-label">Total Bunga:</p>
        <p id="totalBunga" class="result-value"></p>
      </div>

      <div class="result-item">
        <p class="result-label">Total Pinjaman:</p>
        <p id="totalPinjaman" class="result-value"></p>
      </div>

      <div class="result-item">
        <p class="result-label">Angsuran per Bulan:</p>
        <p id="angsuranPerBulan" class="result-value"></p>
      </div>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
</div>
<!-- /.col (right) -->

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

<script>
  // Function to format number to Indonesian Rupiah
  function formatRupiah(angka) {
    var number_string = angka.toString().replace(/[^,\d]/g, ''),
      split = number_string.split(','),
      sisa = split[0][0] === '0' ? 0 : split[0].length % 3,
      rupiah = split[0].substr(0, sisa),
      ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
      separator = sisa ? '.' : '';
      rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
    return rupiah;
  }

  // Add event listener to the simulation button
  document.getElementById('simulasiBtn').addEventListener('click', function() {
    // Get values from form
    var jumlahPinjaman = parseFloat(document.getElementById('jumlah_pinjaman').value.replace('Rp', '').replace(/\./g, '').replace(',', '.'));
    var lamaPeminjaman = parseFloat(document.getElementById('lama').value);
    var bunga = parseFloat(document.getElementById('bunga').value.replace('%', ''));

    // Calculate simulation
    var totalBunga = formatRupiah((jumlahPinjaman / 100 * bunga).toFixed(0).toString());
    var totalPinjaman = formatRupiah((jumlahPinjaman + (jumlahPinjaman / 100 * bunga)).toFixed(0).toString());
    var angsuranPerBulan = formatRupiah(((jumlahPinjaman + (jumlahPinjaman / 100 * bunga)) / lamaPeminjaman).toFixed(0).toString());

    // Show simulation results in card
    document.getElementById('totalBunga').textContent = 'Rp ' + totalBunga;
    document.getElementById('totalPinjaman').textContent = 'Rp ' + totalPinjaman;
    document.getElementById('angsuranPerBulan').textContent = 'Rp ' + angsuranPerBulan;

    // Show simulation card
    document.getElementById('simulationCard').style.display = 'block';
  });

  // Add event listener to format number as Indonesian Rupiah while typing
  document.getElementById('jumlah_pinjaman').addEventListener('input', function() {
    var jumlahPinjaman = document.getElementById('jumlah_pinjaman');
    var formattedValue = formatRupiah(jumlahPinjaman.value);
    jumlahPinjaman.value = formattedValue !== 'Rp' ? 'Rp ' + formattedValue : '';
  });
</script>

</body>
</html>