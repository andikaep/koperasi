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
        <?php if ($this->session->flashdata('success')): ?>
          <div class="box-body">
            <div class="alert alert-info alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4><i class="icon fa fa-info"></i>Alert!</h4>
              <?php echo $this->session->flashdata('success'); ?>
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
          <li><a href="<?php echo base_url('simpanan_pokok') ?>">Lihat Data Anggota</a></li>
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
                <h3 class="label label-primary" style="font-size: 12px, margin-right: -20px !important;">--- Detail Simpanan Pokok ---</h3>
              </div>
              <div class="box-header">
                 <a href="<?php echo base_url("simpanan_pokok/export_detail/$id_anggota"); ?>" class="btn btn-carot"><i class="fa fa-fw fa-file-excel-o"></i>Export Excel</a>
                 <a href="<?php echo base_url("simpanan_pokok/export_detail_pdf/$id_anggota"); ?>" class="btn btn-ijo"><i class="fa fa-fw fa-file-pdf-o"></i>Export PDF</a>

              </div>
           <?php if (!empty($simpanan_pokok)) : ?>
    <?php $nama = $simpanan_pokok[0]->nama; ?>
    <?php $nia = $simpanan_pokok[0]->nia; ?>
    <div style="position: relative; margin-top: 20px; text-align: center;">
        <h4 style="font-family: 'Montserrat', sans-serif; font-size: 28px; color: #2c3e50; letter-spacing: 1px; position: absolute; width: 100%; top: -90px; text-shadow: 1px 1px 2px rgba(0,0,0,0.2);">
            Nama: <?php echo $nama; ?>
        </h4>
        <h4 style="font-family: 'Montserrat', sans-serif; font-size: 22px; color: #2c3e50; letter-spacing: 1px; position: absolute; width: 100%; top: -50px; text-shadow: 1px 1px 2px rgba(0,0,0,0.2);">
            NIA: <?php echo $nia; ?>
        </h4>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-md-6">
        <form method="post" action="<?php echo base_url("simpanan_pokok/filterByDate/$id_anggota"); ?>">
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
                    <?php for ($m = 1; $m <= 12; $m++) { ?>
                        <option value="<?php echo $m; ?>" <?php echo ($this->session->userdata('filter_month') == $m) ? 'selected' : ''; ?>><?php echo date('F', mktime(0, 0, 0, $m, 1)); ?></option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>
    </div>
    <div class="col-md-6">
        <form method="post" action="<?php echo base_url("simpanan_pokok/filterByDate/$id_anggota"); ?>">
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
                    <?php foreach ($simpanan_pokok as $nilai): ?>
                      <tr>
                        <td><?php cetak($no++) ?></td>
                        <td><?php cetak($nilai->tanggal_dibayar ) ?></td>
                        <td>Rp <?php echo number_format($nilai->jumlah, 0, ',', '.') ?></td>
                        <td>
                          <a class="btn btn-ref" href="<?php echo site_url('simpanan_pokok/edit/'.$nilai->id_simpanan_pokok) ?>"><i class="fa fa-fw fa-edit"></i>Edit</a>
                         <a href="#!" onclick="deleteConfirm('<?php echo site_url('simpanan_pokok/delete/'.$nilai->id_simpanan_pokok) ?>')" class="btn btn-mandarin"><i class="fa fa-fw fa-trash"></i>Hapus</a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
                <div class="box-header">
                <?php if (!$this->input->post('start_date') && !$this->input->post('end_date') && !$this->input->post('month') && !$this->input->post('year')) : ?>
    <?php foreach ($tot as $nilai): ?>
        <h1 class="label label-success" style="font-size: 18px;"> Total Simpanan Pokok : <?php echo "Rp. " . (number_format($nilai->jumlah,0,',','.')) ?></h1>
    <?php endforeach; ?>
<?php endif; ?>

                  <?php if (!empty($total_simpanan_pokok)) : ?>
    <h1 class="label label-success" style="font-size: 18px;"> Total Simpanan Pokok : <?php echo "Rp. " . (number_format($total_simpanan_pokok, 0, ',', '.')) ?></h1>
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
<!-- <script>
$(document).ready(function(){
    $('#filterForm').submit(function(event){
        event.preventDefault(); // Mencegah form dari pengiriman default
        
        var formData = $(this).serialize(); // Ambil data form
        
        // Kirim permintaan AJAX
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url("simpanan_pokok/filterByDate/$id_anggota"); ?>',
            data: formData,
            success: function(response){
                // Perbarui bagian tabel dengan data yang diterima
                $('#customTable tbody').html(response);
            }
        });
    });
});
</script> -->

<script>
  function deleteConfirm(url){
    $('#btn-delete').attr('href', url);
    $('#deleteModal').modal();
  }
</script>
</body>
</html>
