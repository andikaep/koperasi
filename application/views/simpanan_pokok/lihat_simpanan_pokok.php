<!DOCTYPE html>
<html>
<?php $this->load->view("admin/_includes/head.php") ?>
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <?php $this->load->view("admin/_includes/header.php") ?>
    <?php $this->load->view("admin/_includes/sidebar.php") ?>
    <script src="<?php echo base_url('js/custom_table.js'); ?>"></script>
    <style>
      .btn.btn-carot {
    position: relative;
    margin-right: 10px; /* Memberikan jarak 10px antara tombol */
    overflow: hidden;
    transition: box-shadow 0.1s ease;
}

.btn.btn-carot:hover {
    box-shadow: 0 0 10px 3px rgba(255, 0, 0, 0.5); /* Efek bayangan merah yang lebih lembut saat dihover */
}

.btn.btn-ijo {
    position: relative;
    margin-right: 10px; /* Memberikan jarak 10px antara tombol */
    overflow: hidden;
    transition: box-shadow 0.0s ease;
}

.btn.btn-ijo:hover {
    box-shadow: 0 0 20px 6px rgba(0, 255, 0, 0.5); /* Efek bayangan hijau yang sama jelasnya dengan merah saat dihover */
}
      </style>

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
          <small>Data Simpanan Pokok</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-fw fa-child"></i> Anggota</a></li>
          <li><a href="#">Lihat Data Anggota</a></li>
        </ol>
      </section>


      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
             <div class="box-header">
                
                 <a href="<?php echo base_url("simpanan_pokok/export"); ?>?year=<?php echo $this->session->userdata('filter_year'); ?>&month=<?php echo $this->session->userdata('filter_month'); ?>&start_date=<?php echo $this->session->userdata('filter_start_date'); ?>&end_date=<?php echo $this->session->userdata('filter_end_date'); ?>" class="btn btn-carot"><i class="fa fa-fw fa-file-pdf-o"></i>Export Excel</a>
                 <a href="<?php echo base_url("simpanan_pokok/export_pdf"); ?>?year=<?php echo $this->session->userdata('filter_year'); ?>&month=<?php echo $this->session->userdata('filter_month'); ?>&start_date=<?php echo $this->session->userdata('filter_start_date'); ?>&end_date=<?php echo $this->session->userdata('filter_end_date'); ?>" class="btn btn-ijo"><i class="fa fa-fw fa-file-pdf-o"></i>Export PDF</a>
                </div>
              <!-- /.box-header -->
             
    <div class="col-md-6">
        <form method="post" action="<?php echo base_url("simpanan_pokok/filter"); ?>">
            <div class="form-group">
                <label for="year">Tahun:</label>
                <select class="form-control" id="year" name="year" required>
                    <option value="" <?php echo ($this->session->userdata('filter_year') == '') ? 'selected' : ''; ?> disabled>Pilih Tahun</option>
                    <?php for ($i = date('Y'); $i >= 2000; $i--) { ?>
                        <option value="<?php echo $i; ?>" <?php echo ($this->session->userdata('filter_year') == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
    <label for="month">Bulan:</label>
    <select class="form-control" id="month" name="month">
        <option value="" <?php echo ($this->session->userdata('filter_month') == '') ? 'selected' : ''; ?>>Semua Bulan</option>
        <?php 
        $bulan = array(
            1 => 'Januari', 
            2 => 'Februari', 
            3 => 'Maret', 
            4 => 'April', 
            5 => 'Mei', 
            6 => 'Juni', 
            7 => 'Juli', 
            8 => 'Agustus', 
            9 => 'September', 
            10 => 'Oktober', 
            11 => 'November', 
            12 => 'Desember'
        );
        ?>
        <?php for ($m = 1; $m <= 12; $m++) { ?>
            <option value="<?php echo $m; ?>" <?php echo ($this->session->userdata('filter_month') == $m) ? 'selected' : ''; ?>><?php echo $bulan[$m]; ?></option>
        <?php } ?>
    </select>
</div>

            <button type="submit" class="btn btn-primary">Filter</button>
        </form>
    </div>
    <div class="col-md-6">
        <form method="post" action="<?php echo base_url("simpanan_pokok/filter"); ?>">
            <div class="form-group" style="width: 150px;">
                <label for="start_date">Tanggal Mulai:</label>
                <input type="date" class="form-control" id="start_date" name="start_date" required value="<?php echo $this->session->userdata('filter_start_date'); ?>">
            </div>
            <div class="form-group">
                <label for="end_date">Tanggal Akhir:</label>
                <input type="date" class="form-control" id="end_date" name="end_date" required value="<?php echo $this->session->userdata('filter_end_date'); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>
    </div>
 <br>
              <div class="box-body table-responsive">
                <table id="customTable" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>NIK</th>
                      <th>Nama</th>
                      <th>Jenis Kelamin</th>
                      <th>Alamat</th>
                      <th>Simpanan</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
    <?php $no = 1;?>
    <?php foreach ($anggota as $key => $value): ?>
        <tr>
            <td><?php cetak($no++) ?></td>
            <td><?php cetak($value->nia)  ?></td>
            <td><?php cetak($value->nama ) ?></td>
            <td><?php cetak($value->jenis_kelamin)  ?></td>
            <td><?php cetak($value->alamat)  ?></td>
            
            <!-- Tambahkan kolom untuk menampilkan total simpanan pokok -->
            <td>
    <?php foreach ($total_anggota as $item): ?>
        <?php if ($item->id_anggota == $value->id_anggota): ?>
            <?php echo "Rp. " . number_format($item->total_simpanan_pokok, 0, ',', '.'); ?>
        <?php endif; ?>
    <?php endforeach; ?>
</td>

            
            <td>
                <a class="btn btn-primary" href="<?php echo site_url('simpanan_pokok/add/'.$value->id_anggota) ?>">
                    <i class="fa fa-fw fa-plus"></i>Simpanan Pokok
                </a>
                <a class="btn btn-success" href="<?php echo site_url('simpanan_pokok/detail/'.$value->id_anggota) ?>">
                    Detail Simpanan Pokok
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>



                 <!-- <tfoot>
                    <tr>
                      <th>No</th>
                      <th>NIK</th>
                      <th>Nama</th>
                      <th>Jenis Kelamin</th>
                      <th>Alamat</th>
                      <th>Aksi</th>
                    </tr>
                  </tfoot> -->
                </table>
               <!-- <h2 style="text-align: center; color: #336699; font-family: Arial, sans-serif; padding: 10px; background-color: #f0f0f0; border-radius: 5px;">Total Simpanan Pokok Seluruh Anggota: <?php echo "Rp " . number_format($total, 0, ',', '.'); ?></h2> -->
                <?php if (!empty($anggota)) : ?>
    <!-- Tampilkan total simpanan pokok hanya sekali -->
    <?php if (!$this->input->post('start_date') && !$this->input->post('end_date') && !$this->input->post('month') && !$this->input->post('year')) : ?>
        <h1 class="label label-success" style="font-size: 18px;"> Total Simpanan Pokok : <?php echo "Rp. " . (number_format($total, 0, ',', '.')) ?></h1>
    <?php else: ?>
        <h1 class="label label-success" style="font-size: 18px;"> Total Simpanan Pokok Hasil Filter : <?php echo "Rp. " . (number_format($total_anggota_, 0, ',', '.')) ?></h1>
    <?php endif; ?>
<?php endif; ?>


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
