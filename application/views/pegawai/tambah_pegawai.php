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

      <section class="content-header">
        <h1>
          Kelola
          <small>Data Pegawai</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-fw fa-user-plus"></i> Pegawai</a></li>
          <li><a href="<?php echo base_url('pegawai/index') ?>">Lihat Data Pegawai</a></li>
          <li><a href="<?php echo base_url('pegawai/add') ?>">Tambah Data Pegawai</a></li>
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
              <form role="form" action="<?php echo base_url('pegawai/add') ?>" method="post">
                <div class="box-body">
                  <div class="form-group">
                    <label>NIK</label>
                    <input name="nik" id="nik" class="form-control <?php echo form_error('nik') ? 'is-invalid':'' ?>" placeholder="Masukkan NIK (16 digit)" type="text" maxlength="16"/>
                    <div class="invalid-feedback">
                      <?php echo form_error('nik') ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Nama</label>
                    <input name="nama" class="form-control <?php echo form_error('nama') ? 'is-invalid':'' ?>" placeholder="Masukan Nama" type="text">
                    <div class="invalid-feedback">
                      <?php echo form_error('nama') ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Alamat</label>
                    <input name="alamat" class="form-control <?php echo form_error('alamat') ? 'is-invalid':'' ?>" placeholder="Masukan Alamat" type="text"/>
                    <div class="invalid-feedback">
                      <?php echo form_error('alamat')?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>No Hp</label>
                    <input name="nohp" id="nohp" class="form-control <?php echo form_error('nohp') ? 'is-invalid':'' ?>" placeholder="Masukkan No HP" type="text" maxlength="16" onkeypress="return hanyaAngka(event)" onblur="preserveLeadingZero(this)"/>
                    <div class="invalid-feedback">
                      <?php echo form_error('nohp') ?>
                    </div>
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
        <h4 class="modal-title" id="confirmModalLabel">Konfirmasi Simpan Data</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4>Apakah Anda yakin ingin menambahkan pegawai baru?</h4>
      </div>
      <div class="modal-footer">
      <button type="submit" class="btn btn-success">Simpan</button>
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>
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
<script>
    // Membuat fungsi untuk membatasi input hanya menerima angka
    function hanyaAngka(e) {
        // Mendapatkan kode tombol yang ditekan
        var kode = (e.which) ? e.which : e.keyCode;

        // Mengizinkan tombol backspace, delete, panah kiri, dan panah kanan
        if (kode == 8 || kode == 46 || kode == 37 || kode == 39) {
            return true;
        }

        // Mengizinkan angka 0-9
        if (kode >= 48 && kode <= 57) {
            return true;
        }

        // Jika kode tombol tidak sesuai, memblokir input
        return false;
    }

    // Menambahkan event listener untuk memanggil fungsi hanyaAngka saat input diubah
    document.getElementById("nik").addEventListener("keypress", function (e) {
        if (!hanyaAngka(e)) {
            e.preventDefault();
        }
    });

    document.getElementById("nohp").addEventListener("keypress", function (e) {
        if (!hanyaAngka(e)) {
            e.preventDefault();
        }
    });

    // Function to preserve leading zero in phone number
    function preserveLeadingZero(inputElement) {
        var value = inputElement.value.trim();
        if (value.length > 0 && value.charAt(0) === '0') {
            inputElement.value = '0' + value.slice(1);
        }
    }
</script>

</body>
</html>
