<!DOCTYPE html>
<html>
<?php $this->load->view("admin/_includes/head.php") ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Detail Angsuran</h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Data Anggota</h3>
                        </div>
                        <div class="box-body">
                            <p>NIA Anggota: <?php echo $anggota->nia; ?></p>
                            <p>Nama Anggota: <?php echo $anggota->nama; ?></p>
                            <!-- Tambahkan informasi lainnya tentang anggota -->
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Detail Angsuran</h3>
                        </div>
                        <div class="box-body">
                            <!-- Tampilkan informasi detail angsuran -->
                            <?php foreach ($angsuran as $item): ?>
                                <p>No Angsuran: <?php echo $item->no_angsuran; ?></p>
                                <p>Jumlah Angsuran: <?php echo $item->jumlah_angsuran; ?></p>
                                <!-- Tambahkan informasi lainnya tentang angsuran -->
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php $this->load->view("admin/_includes/footer.php") ?>
    <?php $this->load->view("admin/_includes/control_sidebar.php") ?>
    <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<?php $this->load->view("admin/_includes/bottom_script_view.php") ?>
</body>
</html>
