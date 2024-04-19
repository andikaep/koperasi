<!DOCTYPE html>
<html>
<?php $this->load->view("admin/_includes/head.php") ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<?php $this->load->view("admin/_includes/header.php") ?>
<?php $this->load->view("admin/_includes/sidebar.php") ?>

<style>
  .small-box {
    width: 250px; /* Atur lebar card */
    height: 150px; /* Atur tinggi card */
    border-radius: 15px; /* Membuat card round */
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease-in-out;
  }

  .small-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 20px rgba(0, 0, 255, 0.8); /* Shadow biru yang sangat jelas */
    background-color: #4d4dff; /* Warna biru pada hover */
}


  .inner {
    padding: 20px;
  }

  .small-box h4 {
    font-size: 24px;
    font-weight: bold;
    margin: 0;
  }

  .small-box p {
    font-size: 16px;
    margin: 10px 0;
    color: #555;
  }

  .small-box-footer {
    background-color: #007bff;
    color: #fff;
    padding: 10px;
    text-align: center;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 0 0 10px 10px; /* Membuat sudut bawah card round */
  }
</style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
	  <!-- Alert -->
	  <!-- Alert -->
    <?php if ($this->session->flashdata('success')): ?>
        <div class="box-body">
          <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-info"></i>Alert!</h4>
            <?php echo $this->session->flashdata('success'); ?>
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
	  <!-- Alert -->
    <!-- Content Header (Page header) -->
    <section class="content-header">

		<h2>
			Selamat Datang, 	
			<?php echo $this->session->userdata('nama'); ?>
      </h2>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
      <?php if ($this->session->userdata('level') == 1): ?>
      <div class="col-lg-3 col-xs-6">
  <!-- small box -->
  <a href="pegawai" style="color: inherit; text-decoration: none; position: relative;">
    <div class="small-box bg-aqua">
      <div class="inner">
        <h4><?php echo $jumlah_pegawai; ?> Pegawai</h4>
        <p>Koperasi Desa Beji</p>
        <!-- Menampilkan jumlah pegawai -->
      </div>
      <div class="icon">
        <i class="fa fa-blind"></i>
      </div>
      <div class="small-box-footer" style="position: absolute; bottom: 0; left: 0; width: 100%; background-color: #0bc6f4; color: #fff; padding: 10px; text-align: center;">Lihat <i class="fa fa-arrow-circle-right"></i></div>
    </div>
  </a>
</div>



        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
  <!-- small box -->
  <a href="anggota" style="color: inherit; text-decoration: none; position: relative;">
    <div class="small-box bg-red">
      <div class="inner">
      <h4><?php echo $jumlah_anggota; ?> Anggota</h4>
        <p>Koperasi Desa Beji</p>
      </div>
      <div class="icon">
      <i class="fa fa-child"></i>
      </div>
      <div class="small-box-footer" style="position: absolute; bottom: 0; left: 0; width: 100%; background-color: #ed5744; color: #fff; padding: 10px; text-align: center;">Lihat <i class="fa fa-arrow-circle-right"></i></div>
    </div>
  </a>
</div> <?php endif; ?>
<?php if ($this->session->userdata('level') == 1 || $this->session->userdata('level') == 2) : ?>
    <div class="col-lg-3 col-xs-6">
  <!-- small box -->
  <a href="pinjaman" style="color: inherit; text-decoration: none; position: relative;">
    <div class="small-box bg-green">
      <div class="inner">
      <h4>Rp <?php echo number_format($jumlah_pinjaman, 0, ',', '.'); ?> </h4><h5><strong>Jumlah Pinjaman</strong></h5>
        <p>Koperasi Desa Beji</p>
      </div>
      <div class="icon">
      <i class="fa fa-credit-card"></i>
      </div>
      <div class="small-box-footer" style="position: absolute; bottom: 0; left: 0; width: 100%; background-color: #04b765; color: #fff; padding: 10px; text-align: center;">Lihat <i class="fa fa-arrow-circle-right"></i></div>
    </div>
  </a>
</div>
<div class="col-lg-3 col-xs-6">
  <!-- small box -->
  <a href="angsuran" style="color: inherit; text-decoration: none; position: relative;">
    <div class="small-box bg-yellow">
      <div class="inner">
      <h4><?php echo $jumlah_angsuran; ?> Angsuran</h4>
        <p>Koperasi Desa Beji</p>
      </div>
      <div class="icon">
      <i class='fa fa-google-wallet'></i>
      </div>
      <div class="small-box-footer" style="position: absolute; bottom: 0; left: 0; width: 100%; background-color: #f8a41e; color: #fff; padding: 10px; text-align: center;">Lihat <i class="fa fa-arrow-circle-right"></i></div>
    </div>
  </a>
</div>
<div class="col-lg-3 col-xs-6">
  <!-- small box -->
  <a href="simpanan_pokok" style="color: inherit; text-decoration: none; position: relative;">
    <div class="small-box bg-orange">
      <div class="inner">
      <h4>Rp <?php echo number_format($jumlah_simpanan_pokok, 0, ',', '.'); ?></h4><h5><strong>Jumlah Simpanan Pokok</strong></h5>
        <!-- <p>Koperasi Desa Beji</p> -->
      </div>
      <div class="icon">
      <i class="fa fa-database"></i>
      </div>
      <div class="small-box-footer" style="position: absolute; bottom: 0; left: 0; width: 100%; background-color: #f88928; color: #fff; padding: 10px; text-align: center;">Lihat <i class="fa fa-arrow-circle-right"></i></div>
    </div>
  </a>
</div>
<div class="col-lg-3 col-xs-6">
  <!-- small box -->
  <a href="simpanan_wajib" style="color: inherit; text-decoration: none; position: relative;">
    <div class="small-box bg-teal">
      <div class="inner">
      <h4>Rp <?php echo number_format($jumlah_simpanan_wajib, 0, ',', '.'); ?></h4><h5><strong>Jumlah Simpanan Wajib</strong></h5>
        <p>Koperasi Desa Beji</p>
      </div>
      <div class="icon">
      <i class="ion ion-pie-graph"></i>
      </div>
      <div class="small-box-footer" style="position: absolute; bottom: 0; left: 0; width: 100%; background-color: #3ecdcd; color: #fff; padding: 10px; text-align: center;">Lihat <i class="fa fa-arrow-circle-right"></i></div>
    </div>
  </a>
</div>
<div class="col-lg-3 col-xs-6">
  <!-- small box -->
  <a href="simpanan_sukarela" style="color: inherit; text-decoration: none; position: relative;">
    <div class="small-box bg-maroon">
      <div class="inner">
      <h4>Rp <?php echo number_format($jumlah_simpanan_sukarela, 0, ',', '.'); ?> </h4><h5><strong> Jumlah Simpanan Sukarela </strong> </h5>
        <p>Koperasi Desa Beji</p>
      </div>
      <div class="icon">
      <i class="fa fa-cube"></i>
      </div>
      <div class="small-box-footer" style="position: absolute; bottom: 0; left: 0; width: 100%; background-color: #e5266c; color: #fff; padding: 10px; text-align: center;">Lihat <i class="fa fa-arrow-circle-right"></i></div>
    </div>
  </a>
</div>
<div class="col-lg-3 col-xs-6">
  <!-- small box -->
  <a href="angsuran/listPinjamanAnggota" style="color: inherit; text-decoration: none; position: relative;">
    <div class="small-box bg-olive">
      <div class="inner">
        <h4>Tambah Angsuran</h4>
        <p>Koperasi Desa Beji</p>
      </div>
      <div class="icon">
      <i class="fa fa-money"></i>
      </div>
      <div class="small-box-footer" style="position: absolute; bottom: 0; left: 0; width: 100%; background-color: #3fa678; color: #fff; padding: 10px; text-align: center;">Lihat <i class="fa fa-arrow-circle-right"></i></div>
    </div>
  </a>
</div>
<?php endif; ?>
<div class="col-lg-3 col-xs-6">
  <!-- small box -->
  <a href="pinjaman/simulasi" style="color: inherit; text-decoration: none; position: relative;">
    <div class="small-box bg-green">
      <div class="inner">
        <h4>Simulasi</h4>
        <p>Koperasi Desa Beji</p>
      </div>
      <div class="icon">
      <i class="fa fa-calculator"></i>
      </div>
      <div class="small-box-footer" style="position: absolute; bottom: 0; left: 0; width: 100%; background-color: #07b666; color: #fff; padding: 10px; text-align: center;">Lihat <i class="fa fa-arrow-circle-right"></i></div>
    </div>
  </a>
</div>
<?php if ($this->session->userdata('level') == 1): ?>
<div class="col-lg-3 col-xs-6">
  <!-- small box -->
  <a href="pengguna" style="color: inherit; text-decoration: none; position: relative;">
  <div class="small-box" style="background-color: #b4a7d6;">
      <div class="inner">
      <h4><?php echo $jumlah_pengguna; ?> Pengguna Aplikasi</h4>
        <p>Koperasi Desa Beji</p>
      </div>
      <div class="icon">
      <i class="fa fa-users"></i>
      </div>
      <div class="small-box-footer" style="position: absolute; bottom: 0; left: 0; width: 100%; background-color: #bcade2; color: #fff; padding: 10px; text-align: center;">Lihat <i class="fa fa-arrow-circle-right"></i></div>
    </div>
  </a>
</div> <?php endif; ?>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      
          <!-- /.box -->

        <!-- right col -->
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 
<?php $this->load->view("admin/_includes/footer.php") ?>
<?php $this->load->view("admin/_includes/control_sidebar.php") ?>
<?php $this->load->view("admin/_includes/bottom_script.php") ?>
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->


</body>
</html>
