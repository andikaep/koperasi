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

.member-info {
        background-color: #e5e5e5;
        border-radius: 8px;
        padding: 10px;
        margin-bottom: 20px;
        text-align: center;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s ease;
    }

    .member-info h4 {
        margin-bottom: 5px;
    }

    .member-info h4 span {
    display: inline-block; /* Change to inline-block */
    font-weight: bold;
    color: #333;
    transition: transform 0.3s ease;
}

.member-info:hover h4 span {
    transform: translateX(10px);
}
    .member-info:hover {
    background-color: #d8d8d8;
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
          <small>Detail Simpanan Sukarela</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-fw fa-child"></i> Anggota</a></li>
          <li><a href="<?php echo base_url('simpanan_sukarela') ?>">Lihat Data Anggota</a></li>
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
                <h3 class="label label-primary" style="font-size: 12px, margin-right: -20px !important;">--- Detail Simpanan Sukarela ---</h3>
              </div>
              <?php if (!empty($simpanan_sukarela)) : ?>
    <div class="member-info">
        <h4>Nama: <span><?php echo $simpanan_sukarela[0]->nama; ?></span></h4>
        <h4>NIA: <span><?php echo $simpanan_sukarela[0]->nia; ?></span></h4>
    </div>
<?php endif; ?>
<div class="box-header"  style="margin-bottom: 10px;">
<a href="<?php echo base_url("simpanan_sukarela/export_detail/$id_anggota"); ?>?year=<?php echo $this->session->userdata('filter_year'); ?>&month=<?php echo $this->session->userdata('filter_month'); ?>&start_date=<?php echo $this->session->userdata('filter_start_date'); ?>&end_date=<?php echo $this->session->userdata('filter_end_date'); ?>" class="btn btn-carot"><i class="fa fa-fw fa-file-excel-o"></i>Export Excel</a>
                 <a href="<?php echo base_url("simpanan_sukarela/export_detail_pdf/$id_anggota"); ?>?year=<?php echo $this->session->userdata('filter_year'); ?>&month=<?php echo $this->session->userdata('filter_month'); ?>&start_date=<?php echo $this->session->userdata('filter_start_date'); ?>&end_date=<?php echo $this->session->userdata('filter_end_date'); ?>" class="btn btn-ijo"><i class="fa fa-fw fa-file-pdf-o"></i>Export PDF</a>

              </div>

              <div class="row">
    <div class="col-md-6">
        <form method="post" action="<?php echo base_url("simpanan_sukarela/filter_detail/$id_anggota"); ?>">
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
        <form method="post" action="<?php echo base_url("simpanan_sukarela/filter_detail/$id_anggota"); ?>">
            <div class="form-group">
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
</div> <br>
                 <table id="customTable" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Tanggal Dibayarkan</th>
                      <th>Jumlah</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no = 1;?>
                    <?php foreach ($simpanan_sukarela as $nilai): ?>
                      <tr>
                        <td><?php cetak($no++) ?></td>
                        <td><?php cetak($nilai->tanggal_dibayar ) ?></td>
                        <td>Rp <?php echo number_format($nilai->jumlah, 0, ',', '.') ?></td>
                        <td>
                          <a class="btn btn-ref" href="<?php echo site_url('simpanan_sukarela/edit/'.$nilai->id_simpanan_sukarela) ?>"><i class="fa fa-fw fa-edit"></i>Edit</a>
                         <a href="#!" onclick="deleteConfirm('<?php echo site_url('simpanan_sukarela/delete/'.$nilai->id_simpanan_sukarela) ?>')" class="btn btn-mandarin"><i class="fa fa-fw fa-trash"></i>Hapus</a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
                <div class="box-header">
                <?php if (!$this->input->post('start_date') && !$this->input->post('end_date') && !$this->input->post('month') && !$this->input->post('year')) : ?>
    <?php foreach ($tot as $nilai): ?>
        <h1 class="label label-success" style="font-size: 18px;"> Total Simpanan Sukarela : <?php echo "Rp. " . (number_format($nilai->jumlah,0,',','.')) ?></h1>
    <?php endforeach; ?>
<?php endif; ?>

                  <?php if (!empty($total_simpanan_sukarela)) : ?>
    <h1 class="label label-success" style="font-size: 18px;"> Total Simpanan Sukarela : <?php echo "Rp. " . (number_format($total_simpanan_sukarela, 0, ',', '.')) ?></h1>
<?php endif; ?>
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
