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
        <div class="col-md-8">
          <!-- general form elements -->
          <div class="box box-primary">
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" id="pinjamanForm" method="post">
              <div class="box-body">
                <div class="form-group">
                  <label>Jumlah Pinjaman</label>
                  <div class="input-group">
                    <input name="jumlah_pinjaman" id="jumlah_pinjaman" class="form-control <?php echo form_error('jumlah_pinjaman') ? 'is-invalid':'' ?>" placeholder="Masukan Jumlah Peminjaman Tanpa (.)" type="text"/>
                  </div>
                  <div class="invalid-feedback">
                    <?php echo form_error('jumlah_pinjaman') ?>
                  </div>
                </div>

                <div class="form-group">
                  <label>Tenor (Berapa Kali Angsuran)</label>
                  <input name="lama" id="lama" class="form-control <?php echo form_error('lama') ? 'is-invalid':'' ?>" placeholder="Masukan Lama Peminjaman" type="text"/>
                  <div class="invalid-feedback">
                    <?php echo form_error('lama') ?>
                  </div>
                </div>

                <div class="form-group">
                  <label>Bunga (%)</label>
                  <div class="input-group">
                    <input name="bunga" id="bunga" class="form-control <?php echo form_error('bunga') ? 'is-invalid':'' ?>" placeholder="Masukan Jumlah Bunga" type="text" />
                    <span class="input-group-addon">%</span>
                  </div>
                  <div class="invalid-feedback">
                    <?php echo form_error('bunga') ?>
                  </div>
                </div>

                <div class="box-footer">
                  <button id="simulasiBtn" class="btn btn-info" type="button"><i class="fa fa-fw fa-calculator"></i>Simulasi</button>
                  <button class="btn btn-danger" type="button" onclick="window.history.back();"><i class="fa fa-fw fa-times"></i>Batal</button>
                  <button class="btn btn-warning" type="reset"><i class="fa fa-fw fa-undo"></i>Clear Data</button>
                </div>
              </div>
              <!-- /.box-body -->
            </form>
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (left) -->

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