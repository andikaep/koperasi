<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<?php $this->load->view("admin/_includes/head.php") ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php $this->load->view("admin/_includes/header.php") ?>
  <?php $this->load->view("admin/_includes/sidebar.php") ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    
    <?php if ($this->session->flashdata('success')): ?>
      <div class="alert alert-success" role="alert">
        <?php echo $this->session->flashdata('success'); ?>
        <a href="<?php echo base_url('pengguna/index') ?>">Ok</a>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
      </div>
    <?php endif; ?>

    <section class="content-header">
      <h1>
        Kelola
        <small>Data Pengguna</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-fw fa-user-plus"></i> Pengguna</a></li>
        <li><a href="<?php echo base_url('pengguna/index') ?>">Lihat Data Pengguna</a></li>
        <li><a href="<?php echo base_url('pengguna/add') ?>">Tambah Data Pengguna</a></li>
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
            <form role="form" action="<?php echo base_url('pengguna/edit_password/'.$pengguna->id_user) ?>" method="post">
              <input type="hidden" name="id_user" value="<?php echo $pengguna->id_user?>" />
              <div class="box-body">
              <div class="form-group">
              <label><i class="fas fa-key"></i> Ubah Password</label>
                    <input name="password" class="form-control <?php echo form_error('password') ? 'is-invalid':'' ?>" placeholder="Masukkan Password"type="text">
                    <div class="invalid-feedback">
                      <?php echo form_error('password') ?>
                    </div>
                    <small id="passwordHelp" class="form-text text-muted">
    <span style="color: #28a745;">✓</span> Password harus terdiri dari minimal 8 karakter <br>
    <span style="color: #28a745;">✓</span> Setidaknya satu huruf besar, satu huruf kecil, satu angka, dan satu karakter spesial.
</small>
                  </div>
               

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
              <button class="btn btn-success" name="submit" type="button" data-toggle="modal" data-target="#confirmModal"><i class="fa fa-fw fa-plus"></i>Simpan</button>

<!-- Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="confirmModalLabel">Konfirmasi Update Data</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4>Apakah Anda yakin ingin menyimpan data baru?</h4>
      </div>
      <div class="modal-footer">
      <button type="submit" class="btn btn-success">Simpan</button>
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>

    <button class="btn btn-danger" type="button" onclick="window.history.back();"><i style="margin-left: -3px;" class="fa fa-fw fa-times"></i>Batal</button>
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
