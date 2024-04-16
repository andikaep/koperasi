<?php $this->load->view("admin/_includes/head.php") ?>


<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<?php $this->load->view("admin/_includes/header.php") ?>
<?php $this->load->view("admin/_includes/sidebar.php") ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
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
      <div class="col-lg-3 col-xs-6">
  <!-- small box -->
  <a href="pegawai" style="color: inherit; text-decoration: none;">
    <div class="small-box bg-aqua">
      <div class="inner">
        <h4>Pegawai</h4>
        <p>Koperasi Desa Beji</p>
      </div>
      <div class="icon">
        <i class="fa fa-blind"></i>
      </div>
      <div class="small-box-footer">Lihat <i class="fa fa-arrow-circle-right"></i></div>
    </div>
  </a>
</div>

        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
  <!-- small box -->
  <a href="anggota" style="color: inherit; text-decoration: none;">
    <div class="small-box bg-red">
      <div class="inner">
        <h4>Anggota</h4>
        <p>Koperasi Desa Beji</p>
      </div>
      <div class="icon">
      <i class="fa fa-child"></i>
      </div>
      <div class="small-box-footer">Lihat <i class="fa fa-arrow-circle-right"></i></div>
    </div>
  </a>
</div>
    <div class="col-lg-3 col-xs-6">
  <!-- small box -->
  <a href="pinjaman" style="color: inherit; text-decoration: none;">
    <div class="small-box bg-green">
      <div class="inner">
        <h4>Data Pinjaman</h4>
        <p>Koperasi Desa Beji</p>
      </div>
      <div class="icon">
      <i class="fa fa-users"></i>
      </div>
      <div class="small-box-footer">Lihat <i class="fa fa-arrow-circle-right"></i></div>
    </div>
  </a>
</div>
<div class="col-lg-3 col-xs-6">
  <!-- small box -->
  <a href="angsuran" style="color: inherit; text-decoration: none;">
    <div class="small-box bg-yellow">
      <div class="inner">
        <h4>Data Angsuran</h4>
        <p>Koperasi Desa Beji</p>
      </div>
      <div class="icon">
      <i class="ion ion-pie-graph"></i>
      </div>
      <div class="small-box-footer">Lihat <i class="fa fa-arrow-circle-right"></i></div>
    </div>
  </a>
</div>
<div class="col-lg-3 col-xs-6">
  <!-- small box -->
  <a href="simpanan_pokok" style="color: inherit; text-decoration: none;">
    <div class="small-box bg-orange">
      <div class="inner">
        <h4>Data Simpanan Pokok</h4>
        <p>Koperasi Desa Beji</p>
      </div>
      <div class="icon">
      <i class="fa fa-database"></i>
      </div>
      <div class="small-box-footer">Lihat <i class="fa fa-arrow-circle-right"></i></div>
    </div>
  </a>
</div>
<div class="col-lg-3 col-xs-6">
  <!-- small box -->
  <a href="simpanan_wajib" style="color: inherit; text-decoration: none;">
    <div class="small-box bg-teal">
      <div class="inner">
        <h4>Data Simpanan Wajib</h4>
        <p>Koperasi Desa Beji</p>
      </div>
      <div class="icon">
      <i class="ion ion-pie-graph"></i>
      </div>
      <div class="small-box-footer">Lihat <i class="fa fa-arrow-circle-right"></i></div>
    </div>
  </a>
</div>
<div class="col-lg-3 col-xs-6">
  <!-- small box -->
  <a href="simpanan_sukarela" style="color: inherit; text-decoration: none;">
    <div class="small-box bg-maroon">
      <div class="inner">
        <h4>Data Simpanan Sukarela</h4>
        <p>Koperasi Desa Beji</p>
      </div>
      <div class="icon">
      <i class="fa fa-cube"></i>
      </div>
      <div class="small-box-footer">Lihat <i class="fa fa-arrow-circle-right"></i></div>
    </div>
  </a>
</div>
<div class="col-lg-3 col-xs-6">
  <!-- small box -->
  <a href="angsuran/listPinjamanAnggota" style="color: inherit; text-decoration: none;">
    <div class="small-box bg-olive">
      <div class="inner">
        <h4>Tambah Angsuran</h4>
        <p>Koperasi Desa Beji</p>
      </div>
      <div class="icon">
      <i class="fa fa-money"></i>
      </div>
      <div class="small-box-footer">Lihat <i class="fa fa-arrow-circle-right"></i></div>
    </div>
  </a>
</div>
<div class="col-lg-3 col-xs-6">
  <!-- small box -->
  <a href="pinjaman/simulasi" style="color: inherit; text-decoration: none;">
    <div class="small-box bg-green">
      <div class="inner">
        <h4>Simulasi</h4>
        <p>Koperasi Desa Beji</p>
      </div>
      <div class="icon">
      <i class="fa fa-calculator"></i>
      </div>
      <div class="small-box-footer">Lihat <i class="fa fa-arrow-circle-right"></i></div>
    </div>
  </a>
</div>
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
