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

      <section class="content-header">
        <h1>
          Kelola
          <small>Data Anggota Koperasi</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-fw fa-child"></i> Anggota</a></li>
          <li><a href="<?php echo base_url('anggota') ?>">Lihat Data Anggota</a></li>
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
                <h3 class="label label-primary" style="">--- Data Anggota ---</h3>
              </div>
                <table class="table table-bordered table-hover">
                <thead>
    <tr style="background-color: #e6e6e6;">
        <th>NIK</th>
        <th>Nama</th>
        <th>Jenis Kelamin</th>
        <th>Alamat</th>
    </tr>
</thead>
<tbody>
    <tr>
        <td style="background-color: #f2f2f2;"><?php cetak($anggota->nia) ?></td>
        <td style="background-color: #f2f2f2;"><?php cetak($anggota->nama) ?></td>
        <td style="background-color: #f2f2f2;"><?php cetak($anggota->jenis_kelamin) ?></td>
        <td style="background-color: #f2f2f2;"><?php cetak($anggota->alamat) ?></td>
    </tr>
</tbody>
                </table>
              </div>
           

              <div class="box-body table-responsive">
              <div class="box-header">
                <h3 class="label label-primary" style="font-size: 12px, margin-right: -20px !important;">--- Detail Pinjaman ---</h3>
              </div>
              <table id="pinjamanTable" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                      <th>No</th>
                      <th>Nama</th>
                      <th>No Pinjaman</th>
                      <th>Jumlah Pinjaman</th>
                
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no = 1;?>
                    <?php foreach ($pinjaman as $nilai): ?>
                      <tr>
                        <td><?php cetak($no++) ?></td>
                        <td><?php cetak($nilai->nama) ?></td>
                        <td><?php cetak($nilai->no_pinjaman)  ?></td>
                        
                        <td><?php echo "Rp. " . (number_format($nilai->jumlah_pinjaman,2,',','.')) ?></td>
                        <!-- <td>
                          <a class="btn btn-ref" href="<?php echo site_url('pinjaman/edit/'.$nilai->id_pinjaman) ?>"><i class="fa fa-fw fa-edit"></i></a>
                          <a href="#!" onclick="deleteConfirm('<?php echo site_url('pinjaman/delete/'.$nilai->id_pinjaman) ?>')" class="btn btn-mandarin"><i class="fa fa-fw fa-trash"></i></a>
                          
                        </td> -->
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                  
                </table>
              </div>

              
              <div class="box-body table-responsive">
              <div class="box-header">
                <h3 class="label label-primary" style="font-size: 12px, margin-right: -20px !important;">--- Detail Angsuran ---</h3>
              </div>
              <table id="angsuranTable" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                      <th>No</th>
                      <th>Nama</th>
                      <th>No Pinjaman</th>
                      <th>No Angsuran</th>
                      <th>Tanggal Angsuran</th>
                      <th>Jumlah Pinjaman</th>
                      <th>Bunga</th>
                      <th>Total Bayar</th>
                      <th>Jumlah Angsuran</th>
                      <th>Kurang Bayar</th>
                   
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no = 1;?>
                    <?php foreach ($angsuran as $nilai): ?>
                      <?php 
    // Hitung total angsuran yang telah dibayarkan untuk pinjaman ini
    $total_angsuran_dibayarkan = $this->db->query("SELECT SUM(jumlah_angsuran) AS total_angsuran FROM angsuran WHERE id_pinjaman = '{$nilai->id_pinjaman}'")->row()->total_angsuran;
    
    // Tentukan total yang seharusnya dibayarkan
    $total_yang_harus_dibayarkan = $nilai->jumlah_pinjaman + ($nilai->jumlah_pinjaman * $nilai->bunga / 100);
    
    // Hitung nilai kurang untuk angsuran ini
    $kurang = $total_yang_harus_dibayarkan - $total_angsuran_dibayarkan;

    $total_pinjaman_bunga = $nilai->jumlah_pinjaman + ($nilai->jumlah_pinjaman * $nilai->bunga / 100);

    ?>
                      <tr>
                        <td><?php cetak($no++) ?></td>
                        <td><?php cetak($nilai->nama) ?></td>
                        <td><?php cetak($nilai->no_pinjaman)  ?></td>
                        <td><?php cetak($nilai->no_angsuran)  ?></td>
                        <td><?php cetak($nilai->tanggal)  ?></td>
                        <td><?php echo "Rp. " . (number_format($nilai->jumlah_pinjaman,2,',','.')) ?></td>
                        <td><?php echo cetak($nilai->bunga) . '%' ?></td>
                        <td><?php echo "Rp. " . number_format($total_pinjaman_bunga, 2, ',', '.'); ?></td>
                        <td><?php echo "Rp. " . (number_format($nilai->jumlah_angsuran,2,',','.')) ?></td>
                        <td><strong><?php echo "Rp. " . number_format($kurang, 2, ',', '.'); ?></strong></td>
                        <!-- <td>
                          <a class="btn btn-ref" href="<?php echo site_url('angsuran/edit/'.$nilai->id_pinjaman) ?>"><i class="fa fa-fw fa-edit"></i></a>
                          <a href="#!" onclick="deleteConfirm('<?php echo site_url('angsuran/delete/'.$nilai->id_pinjaman) ?>')" class="btn btn-mandarin"><i class="fa fa-fw fa-trash"></i></a>
                          
                        </td> -->
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                  
                </table>
              </div>
              <!-- Tabel detail simpanan pokok -->
<div class="box-body table-responsive">
    <div class="box-header">
        <h3 class="label label-primary" style="font-size: 12px, margin-right: -20px !important;">--- Detail Simpanan Pokok ---</h3>
    </div>
    <table id="simpananPokokTable" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jumlah</th>
                <th>Tanggal Dibayarkan</th>
           
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($simpanan_pokok as $nilai): ?>
                <tr>
                    <td><?php cetak($no++) ?></td>
                    <td><?php cetak($nilai->nama) ?></td>
                    <td><?php echo "Rp. " . (number_format($nilai->jumlah, 2, ',', '.')) ?></td>
                    <td><?php cetak($nilai->tanggal_dibayar) ?></td>
                   <!--  <td>
                        <a class="btn btn-ref" href="<?php echo site_url('simpanan_pokok/edit/' . $nilai->id_simpanan_pokok) ?>"><i class="fa fa-fw fa-edit"></i></a>
                        <a href="#!" onclick="deleteConfirm('<?php echo site_url('simpanan_pokok/delete/' . $nilai->id_simpanan_pokok) ?>')" class="btn btn-mandarin"><i class="fa fa-fw fa-trash"></i></a>
                    </td> -->
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="box-header">
                  <?php foreach ($tot_simpanan_pokok as $nilai): ?>
                    <h1 class="label label-success" style="font-size: 18px;"> Total Simpanan Pokok : <?php echo "Rp. " . (number_format($nilai->jumlah,0,',','.')) ?></h1>
                  <?php endforeach; ?>
                  
                </div>
</div>

<!-- Script JavaScript untuk inisialisasi DataTables -->
<script>
    $(document).ready(function() {
        $('#simpananPokokTable, #pinjamanTable, #angsuranTable').DataTable({
            // Aktifkan fitur pencarian, penyaringan, dan paginasi
            searching: true,
        ordering: true,
        paging: true,
        // Additional options as needed
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        // Set DataTables language according to your preferences
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
            infoFiltered: "(disaring dari _MAX_ total data)",
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
            zeroRecords: "Tidak ada hasil yang ditemukan.<br>Mohon periksa kembali kata kunci pencarian." // Custom message when no matching records are found
        }
    });
});
</script>


              
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
