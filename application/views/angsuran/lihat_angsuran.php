<!DOCTYPE html>
<html>
<?php $this->load->view("admin/_includes/head.php") ?>
<body class="hold-transition skin-blue sidebar-mini">
<style>
    .last-row-before-next-loan {
    background-color: #f2dede; /* Ganti dengan warna latar belakang yang Anda inginkan */
    color: #a94442; /* Ganti dengan warna teks yang Anda inginkan */
    /* Anda juga dapat menambahkan properti CSS lainnya sesuai kebutuhan */
}

.btn-info {
    position: relative;
}

.btn-info:hover:after {
    content: "Lihat Kurang Bayar";
    position: absolute;
    top: -30px;
    left: 0;
    background-color: #333;
    color: #fff;
    padding: 5px;
    border-radius: 5px;
    display: inline-block;
}
.action-buttons {
    display: flex;
    align-items: center;
}

.action-buttons .edit-button,
.action-buttons .delete-button {
    margin-left: 5px;
}

.btn-info {
    position: relative;
}

.btn-info:hover:after {
    content: "Lihat Kurang Bayar";
    position: absolute;
    top: -30px;
    left: 0;
    background-color: #333;
    color: #fff;
    padding: 5px;
    border-radius: 5px;
    display: inline-block;
}

.edit-button:hover + .btn-info:after,
.delete-button:hover + .btn-info:after {
    display: none;
}

</style>
<div class="wrapper">

  <?php $this->load->view("admin/_includes/header.php") ?>
  <?php $this->load->view("admin/_includes/sidebar.php") ?>
  <script src="<?php echo base_url('js/custom_table.js'); ?>"></script>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

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
        Kelola
        <small>Data Angsuran</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-fw fa-user-plus"></i> Pinjaman</a></li>
        <li><a href="#">Lihat Data Pinjaman</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <a href="<?php echo base_url('angsuran/listPinjamanAnggota') ?>" class="btn btn-tosca"><i class="fa fa-fw fa-plus"></i>Tambah</a>
              <!-- <button class="btn btn-carot"><i class="fa fa-fw fa-download"></i>Export Data</button>
              <button class="btn btn-ijo"><i class="fa fa-fw fa-upload"></i>Import Data</button> -->
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="customTable" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Peminjam</th>
                      <th>No Pinjaman</th>
                      <th>No Angsuran</th>
                      <th>Tanggal Peminjaman</th>
                      <th>Jumlah Pinjaman</th>
                      <th>Bunga</th>
                      <th>Total Bayar</th>
                      <th>Angsuran</th>
                      
                    
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                  
                    <?php $no = 1;?>
                    <?php $totalRows = count($angsuran); ?>
                    <?php foreach ($angsuran as $key => $value): ?>
    <?php 
        // Hitung total angsuran yang telah dibayarkan untuk pinjaman ini
        $total_angsuran_dibayarkan = $this->db->query("SELECT SUM(jumlah_angsuran) AS total_angsuran FROM angsuran WHERE id_pinjaman = '{$value->id_pinjaman}'")->row()->total_angsuran;
        
        // Tentukan total yang seharusnya dibayarkan
        $total_yang_harus_dibayarkan = $value->jumlah_pinjaman + ($value->jumlah_pinjaman * $value->bunga / 100);
        
        // Hitung nilai kurang untuk angsuran ini
        $kurang = $total_yang_harus_dibayarkan - $total_angsuran_dibayarkan;
        $total_pinjaman_bunga = $value->jumlah_pinjaman + ($value->jumlah_pinjaman * $value->bunga / 100);
        // Tentukan nomor pinjaman saat ini dan nomor pinjaman berikutnya
        $currentNoPinjaman = $value->no_pinjaman;
        $nextNoPinjaman = ($key + 1 < count($angsuran)) ? $angsuran[$key + 1]->no_pinjaman : null;

        // Cek apakah ini baris terakhir untuk nomor pinjaman tertentu
        $isLastRow = ($nextNoPinjaman !== null && $currentNoPinjaman !== $nextNoPinjaman) || $nextNoPinjaman === null;
    ?>
    <tr <?php if ($isLastRow): ?>class="last-row-before-next-loan"<?php endif; ?>>
        <td><?php cetak($no++) ?></td>
        <td><?php cetak($value->nama)  ?></td>
        <td><?php cetak($value->no_pinjaman)  ?></td>
        <td><?php cetak($value->no_angsuran)  ?></td>
        <td><?php cetak($value->tanggal_peminjaman)  ?></td>
        <td><?php echo "Rp. " . (number_format($value->jumlah_pinjaman,2,',','.')) ?></td>
        <td><?php echo cetak($value->bunga) . '%' ?></td>
        <td><?php echo "Rp. " . number_format($total_pinjaman_bunga, 2, ',', '.'); ?></td>
        
          <td class="center-button"><?php echo "Rp. " . (number_format($value->jumlah_angsuran,2,',','.')) ?>
          <br>
          <?php if ($isLastRow): ?>
          
    <div class="action-buttons" style="display: flex; justify-content: center;">
        <?php $formattedKurang = number_format($kurang, 0, ',', '.'); ?>
        <button class="btn btn-info" onclick="showKurangBayar('<?php echo $formattedKurang; ?>')">
            <i class="fa fa-eye" aria-hidden="true"></i>
        </button>
    </div>
</td>

        <?php else: ?>
            
        <?php endif; ?>
        <td>
            <a class="btn btn-ref" href="<?php echo site_url('angsuran/edit/'.$value->id_angsuran) ?>"><i class="fa fa-fw fa-edit"></i></a><br><br>
            <a href="#!" onclick="deleteConfirm('<?php echo site_url('angsuran/delete/'.$value->id_angsuran) ?>')" class="btn btn-mandarin"><i class="fa fa-fw fa-trash"></i></a>
        </td>
    </tr>
<?php endforeach; ?>

                  </tbody>
                <!--  <tfoot>
                    <tr>
                      <th>No</th>
                      <th>Nama Peminjam</th>
                      <th>No Pinjaman</th>
                      <th>No Angsuran</th>
                      <th>Jumlah Pinjaman</th>
                      <th>Tanggal Peminjaman</th>
                      <th>Lama</th>
                      <th>Total Bunga</th>
                      <th>Jumlah Angsuran</th>
                      <th>Aksi</th>
                    </tr>
                  </tfoot> -->
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
  <script>
    function showKurangBayar(kurangBayarValue) {
        $('#kurangBayarValue').text("Kurang Bayar: Rp. " + kurangBayarValue);
        $('#kurangBayarModal').modal('show');
    }
</script>

  <!-- Modal Kurang Bayar -->
<div id="kurangBayarModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Kurang Bayar</h4>
      </div>
      <div class="modal-body">
        <p id="kurangBayarValue"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
      </div>
    </div>
  </div>
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
        <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">Data yang dihapus tidak akan bisa dikembalikan.</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <a id="btn-delete" class="btn btn-danger" href="#">Delete</a>
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
