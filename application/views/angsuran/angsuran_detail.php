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
          <small>Data Anggota Koperasi</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-fw fa-child"></i> Anggota</a></li>
          <li><a href="<?php echo base_url('angsuran') ?>">Lihat Data Anggota</a></li>
        </ol>
      </section>


      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <!-- /.box-header -->
            <div class="box-body table-responsive">
              <div class="box-header">
              <h3 class="label label-primary" style="font-size: 12px; margin-right: -20px !important;">Detail Angsuran</h3>
    <!-- Tampilkan nama peminjam -->
    <?php if (!empty($angsuran_detail)): ?>
    <h4><strong><span style="color: blue;"><?php echo $angsuran_detail[0]->nama; ?></span></strong></h4>
    <h4>No Pinjaman: <strong><?php echo $angsuran_detail[0]->no_pinjaman; ?></strong></h4>
    <?php else: ?>
    <h4>Data tidak ditemukan</h4>
<?php endif; ?>
              </div>
                 <table id="example2" class="table table-bordered table-hover">
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
                      <th>Jumlah Angsuran</th>
                      <th>Kurang Bayar</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php $no = 1;?>
                    <?php foreach ($angsuran_detail as $value): ?>
                      <?php 
    // Hitung total angsuran yang telah dibayarkan untuk pinjaman ini
    $total_angsuran_dibayarkan = $this->db->query("SELECT SUM(jumlah_angsuran) AS total_angsuran FROM angsuran WHERE id_pinjaman = '{$value->id_pinjaman}'")->row()->total_angsuran;
    
    // Tentukan total yang seharusnya dibayarkan
    $total_yang_harus_dibayarkan = $value->jumlah_pinjaman + ($value->jumlah_pinjaman * $value->bunga / 100);
    
    // Hitung nilai kurang untuk angsuran ini
    $kurang = $total_yang_harus_dibayarkan - $total_angsuran_dibayarkan;

    $total_pinjaman_bunga = $value->jumlah_pinjaman + ($value->jumlah_pinjaman * $value->bunga / 100);

    ?>
    
                      
    <tr>
                        <td><?php cetak($no++) ?></td>
                         <td><?php cetak($value->nama)  ?></td>
                        <td><?php cetak($value->no_pinjaman)  ?></td>
                        <td><?php cetak($value->no_angsuran)  ?></td>
                        <td><?php cetak($value->tanggal_peminjaman)  ?></td>
                        <td><?php echo "Rp. " . (number_format($value->jumlah_pinjaman,2,',','.')) ?></td>
                        <td><?php echo cetak($value->bunga) . '%' ?></td>
                        <td><?php echo "Rp. " . number_format($total_pinjaman_bunga, 2, ',', '.'); ?></td>
                        <td><?php echo "Rp. " . (number_format($value->jumlah_angsuran,2,',','.')) ?></td>
                        <td><strong><?php echo "Rp. " . number_format($kurang, 2, ',', '.'); ?></strong></td>
                        <td>
                          <a class="btn btn-ref" href="<?php echo site_url('angsuran/edit/'.$value->id_angsuran) ?>"><i class="fa fa-fw fa-edit"></i></a><br><br>
                          <a href="#!" onclick="deleteConfirm('<?php echo site_url('angsuran/delete/'.$value->id_angsuran) ?>')" class="btn btn-mandarin"><i class="fa fa-fw fa-trash"></i></a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
                <div class="box-header">
                  <?php foreach ($tot as $value): ?>
                  <h3 class="label label-success"> Total Angsuran : <?php echo "Rp. " . (number_format($value->jumlah_angsuran,2,',','.')) ?></h3>
                  <?php endforeach; ?>
                  <button class="btn btn-default pull-right" type="button" onclick="window.history.back();">
  <i class="fa fa-fw fa-arrow-left"></i>Kembali
</button>

                </div>
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