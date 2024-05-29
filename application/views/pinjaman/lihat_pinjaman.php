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
        <small>Data Pinjaman</small>
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
              <a href="<?php echo base_url('pinjaman/list_anggota') ?>" class="btn btn-tosca"><i class="fa fa-fw fa-plus"></i>Tambah</a>
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
                      <th>Tanggal Peminjaman</th>
                      <th>Jumlah Pinjaman</th>
                      <th>Tenor</th>
                      <th>Bunga</th>
                      <th>Total Bayar</th>
                      <th>Total Angsuran</th>
                      <th>Status</th>
                      <th>Kurang</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no = 1;?>
                    <?php foreach ($pinjaman as $value): ?>
                      <?php 
        // Hitung total angsuran yang telah dibayarkan untuk pinjaman ini
        $total_angsuran_dibayarkan = $this->db->query("SELECT SUM(jumlah_angsuran) AS total_angsuran FROM angsuran WHERE id_pinjaman = '{$value->id_pinjaman}'")->row()->total_angsuran;
        
        // Tentukan total yang seharusnya dibayarkan
        $total_yang_harus_dibayarkan = $value->jumlah_pinjaman + ($value->jumlah_pinjaman / 100 * $value->bunga);
        
        // Tentukan status pinjaman
        $status_pinjaman = ($total_angsuran_dibayarkan >= $total_yang_harus_dibayarkan) ? 'Lunas' : 'Belum Lunas';

        $kurang = $total_yang_harus_dibayarkan - $total_angsuran_dibayarkan;
    ?>
                      <tr>
                        <td><?php cetak($no++) ?></td>
                         <td><?php cetak($value->nama)  ?></td>
                         
                        <td><?php cetak($value->no_pinjaman)  ?></td>
                        <td><?php cetak($value->tanggal_peminjaman)  ?></td>
                        <td><?php echo "Rp. " . (number_format($value->jumlah_pinjaman,0,',','.')) ?></td>
                        <td><?php cetak($value->lama)  ?></td>
                        <td><?php echo cetak($value->bunga) . '%' ?></td>
                        <td><strong><?php echo "Rp. " . number_format($total_yang_harus_dibayarkan, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo "Rp. " . number_format($total_angsuran_dibayarkan, 0, ',', '.'); ?></strong></td>
                        <td><strong><?php echo $status_pinjaman; ?></strong></td> <!-- Tampilkan status pinjaman -->
                        <td><strong><?php echo "Rp. " . number_format($kurang, 0, ',', '.'); ?></strong></td>
                        <td>
                          <a class="btn btn-ref" href="<?php echo site_url('pinjaman/edit/'.$value->id_pinjaman) ?>"><i class="fa fa-fw fa-edit"></i></a>
                          <a href="#!" onclick="deleteConfirm('<?php echo site_url('pinjaman/delete/'.$value->id_pinjaman) ?>')" class="btn btn-mandarin"><i class="fa fa-fw fa-trash"></i></a>
                          
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                <!--  <tfoot>
                    <tr>
                      <th>No</th>
                      <th>Nama Peminjam</th>
                      <th>No Pinjaman</th>
                      <th>Jumlah Pinjaman</th>
                      <th>Tanggal Peminjaman</th>
                      <th>Lama</th>
                      <th>Total Bunga</th>
                      <th>Aksi</th>
                    </tr>
                  </tfoot> -->
                </table>
              <!--   <div class="box-header">
                <?php if (!empty($total_pinjaman)): ?>
    <div class="box-header">
        <h2 class="label label-success"> Total Pinjaman : <?php echo "Rp. " . (number_format($total_pinjaman, 0, ',', '.')) ?></h2>
        <button class="btn btn-default pull-right" type="button" onclick="window.history.back();">
            <i class="fa fa-fw fa-arrow-left"></i>Kembali
        </button>
    </div>
<?php endif; ?>

<?php if (!empty($pinjaman)): ?>
    <?php
    // Inisialisasi variabel untuk menyimpan total bayar dari semua pinjaman
    $total_bayar_semua = 0;
    ?>
    <?php foreach ($pinjaman as $value): ?>
        <?php 
            // Hitung total yang harus dibayarkan
            $total_yang_harus_dibayarkan = $value->jumlah_pinjaman + ($value->jumlah_pinjaman / 100 * $value->bunga);
            
            // Akumulasikan total bayar dari semua pinjaman
            $total_bayar_semua += $total_yang_harus_dibayarkan;
        ?>
    <?php endforeach; ?>

    <div class="box-header">
        <h2 class="label label-success"> Total Bayar : <?php echo "Rp. " . (number_format($total_bayar_semua, 0, ',', '.')) ?></h2>
    </div>
<?php endif; ?> -->

<div class="box-header">
    <?php if (!empty($total_pinjaman)): ?>
        <div class="box-header">
            <h2 class="label label-success" style="font-size: 18px; margin-right: 10px;"> Total Pinjaman : <?php echo "Rp. " . (number_format($total_pinjaman, 0, ',', '.')) ?></h2>
            <h2 class="label label-success" style="font-size: 18px; margin-right: 10px;"> Total Bayar : <?php echo "Rp. " . (number_format($total_bayar_semua, 0, ',', '.')) ?></h2>
            <h2 class="label label-success" style="font-size: 18px; margin-right: 10px;"> Keuntungan : <?php echo "Rp. " . (number_format($total_bayar_semua - $total_pinjaman, 0, ',', '.')) ?></h2>
            <button class="btn btn-default pull-right" type="button" onclick="window.history.back();">
                <i class="fa fa-fw fa-arrow-left"></i>Kembali
            </button>
        </div>
    <?php endif; ?>
</div>




            </div>
            <!-- Tabel detail simpanan pokok -->

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
