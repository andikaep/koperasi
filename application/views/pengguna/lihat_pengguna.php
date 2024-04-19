<!DOCTYPE html>
<html>
<?php $this->load->view("admin/_includes/head.php") ?>
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <?php $this->load->view("admin/_includes/header.php") ?>
    <?php $this->load->view("admin/_includes/sidebar.php") ?>
    <script src="<?php echo base_url('js/custom_table.js'); ?>"></script>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <?php
// list_data.php

// Cek apakah ada pesan yang harus ditampilkan
if (isset($_SESSION['success_message'])) {
    echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
    // Hapus pesan agar tidak ditampilkan lagi di reload halaman
    unset($_SESSION['success_message']);
}
?>

<!-- List data goes here -->

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


        <section class="content-header">
          <h1>
            Kelola Data Pengguna
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-fw fa-user-plus"></i> Pengguna</a></li>
            <li><a href="#">Lihat Data Pengguna</a></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <a href="<?php echo base_url('pengguna/add') ?>" class="btn btn-tosca"><i class="fa fa-fw fa-plus"></i>Tambah</a>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                  <table id="customTable" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Nama Lengkap</th>
                        <th>Level</th>
                        <th>Terakhir Login</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $no = 1;?>
                      <?php foreach ($pengguna as $value): ?>
                        <tr>
                          <td><?php echo $no++; ?></td>
                          <td><?php echo $value->username ?></td>
                          <td><?php echo $value->nama ?></td>
                          <td>
                    <?php 
                        // Tampilkan teks yang sesuai dengan nilai level
                        if ($value->level == 1) {
                            echo 'Super Admin';
                        } elseif ($value->level == 2) {
                            echo 'Admin';
                        } elseif ($value->level == 3) {
                            echo 'Pegawai';
                        } else {
                            echo 'Tidak Diketahui';
                        }
                    ?>
                </td>    <td>
    <?php 
    if ($value->last_login === '0000-00-00 00:00:00') {
        echo '<span style="color: red;">Belum ada data login</span>';
    } else {
        // Ubah warna tanggal menjadi biru
        echo '<span style="color: blue;">' . date('d-m-Y |', strtotime($value->last_login)) . '</span>';

        // Ubah warna waktu menjadi hijau
        echo '<span style="color: #2E8B57;">' . date(' H:i:s', strtotime($value->last_login)) . '</span>';
    }
    ?>
</td>



<!-- Tampilkan waktu terakhir login -->
                          <td>
                            <a class="btn btn-ref" href="<?php echo site_url('pengguna/edit/'.$value->id_user) ?>"><i class="fa fa-fw fa-edit"></i>Edit</a>
                            <a href="#!" onclick="deleteConfirm('<?php echo site_url('pengguna/delete/'.$value->id_user) ?>')" class="btn btn-mandarin"><i class="fa fa-fw fa-trash"></i>Hapus</a>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                      <!--  <tr>
                       <th>NIK</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>No Handphone</th>
                      </tr> -->
                    </tfoot>
                  </table>
                </div> 
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
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

 <!-- Logout Delete Confirmation-->
 <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Apakah anda yakin?</h4>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body"><h4> <p style="color: red;">Data yang dihapus tidak bisa dikembalikan</p></h4></div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
        <a id="btn-delete" class="btn btn-danger" href="#">Hapus</a>
      </div>
    </div>
  </div>
</div>
<!-- ./wrapper -->
<?php $this->load->view("admin/_includes/bottom_script_view.php") ?>
<!-- page script -->
<script>
  function deleteConfirm(url){
    $('#btn-delete').attr('href', url);
    $('#deleteModal').modal();
  }
</script>
</body>
</html>
