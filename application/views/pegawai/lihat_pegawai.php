<!DOCTYPE html>
<html>
<?php $this->load->view("admin/_includes/head.php") ?>
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <?php $this->load->view("admin/_includes/header.php") ?>
    <?php $this->load->view("admin/_includes/sidebar.php") ?>

<!-- Panggil file JavaScript -->
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
            Kelola Data Pegawai
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-fw fa-user-plus"></i> Pegawai</a></li>
            <li><a href="#">Lihat Data Pegawai</a></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <a href="<?php echo base_url('pegawai/add') ?>" class="btn btn-tosca"><i class="fa fa-fw fa-plus"></i>Tambah</a>
                  <a href="<?php echo base_url("pegawai/export"); ?>" class="btn btn-carot"><i class="fa fa-fw fa-file-excel-o"></i>Export Excel</a>
                  <a href="<?php echo base_url("pegawai/export_pdf"); ?>" class="btn btn-ijo"><i class="fa fa-fw fa-file-pdf-o"></i>Export PDF</a>
                  <a class="btn btn-ijo" href="<?php echo base_url("pegawai/form"); ?>"><i class="fa fa-fw fa-upload"></i>Import Data</a>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                  <!-- <table id="example1" class="table table-bordered table-hover"> -->
                      <table id="customTable" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Jabatan</th>
                        <th>No HP</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $no = 1;?>
                      <?php foreach ($pegawai as $value): ?>
                        <tr>
                          <td><?php echo $no++; ?></td>
                          <td><?php echo $value->nik ?></td>
                          <td><?php echo $value->nama ?></td>
                          <td><?php echo $value->alamat ?></td>
                          <td><?php echo $value->jabatan ?></td>
                          <td>
  <?php 
  // Tambahkan angka 0 di depan nomor handphone jika diperlukan
  $no_hp = $value->nohp;
  if (substr($no_hp, 0, 1) !== '0') {
      $no_hp = '0' . $no_hp;
  }
  echo $no_hp;
  ?>
</td>
                          <td>
                            <a class="btn btn-ref" href="<?php echo site_url('pegawai/edit/'.$value->id_pegawai) ?>"><i class="fa fa-fw fa-edit"></i>Edit</a>
                            <a href="#!" onclick="deleteConfirm('<?php echo site_url('pegawai/delete/'.$value->id_pegawai) ?>')" class="btn btn-mandarin"><i class="fa fa-fw fa-trash"></i>Hapus</a>
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
<script>
    $(document).ready(function() {
        $('#pegawaiTable').DataTable({
            // Aktifkan fitur pencarian, penyaringan, dan paginasi
            searching: true,
            ordering: true,
            paging: true,
            // Opsi tambahan sesuai kebutuhan
            // Misalnya, jika Anda ingin menyesuaikan jumlah entri yang ditampilkan per halaman:
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            // Atur bahasa DataTables sesuai preferensi Anda
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ entri per halaman",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
                infoFiltered: "(disaring dari _MAX_ total entri)",
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
                zeroRecords: "Tidak ada hasil yang ditemukan" // Pesan yang akan ditampilkan saat tabel kosong
            }
        });
    });
</script>
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
