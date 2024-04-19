 <header class="main-header">
    <!-- Logo -->

    <a href="<?php echo base_url('') ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>K</b>M</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Koperasi</b> Desa Beji</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo base_url('assetAdmin/dist/img/user2-160x160.jpg'); ?>" class="user-image" alt="User Image">
              <span class="hidden-xs">Admin Ganteng</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo base_url('assetAdmin/dist/img/user2-160x160.jpg')?>" class="img-circle" alt="User sipo">

                <p>
                <?php echo $this->session->userdata('nama'); ?>
                  <small>Admin sejak 2024</small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
    <div class="pull-left">
        <!-- Tautan untuk mengubah password -->
        <a href="<?php echo base_url('pengguna/edit_password/'.$this->session->userdata('id_user')) ?>" class="btn btn-default btn-flat">
            <i class="fa fa-lock"></i> Ubah Password
        </a>
    </div>
    <div class="pull-right">
        <!-- Tautan untuk keluar -->
        <a href="<?php echo base_url('Auth/logout') ?>" class="btn btn-default btn-flat">
            <i class="fa fa-sign-out"></i> Keluar
        </a>
    </div>
</li>



            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
        <!--  <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li> -->
        </ul>
      </div>
    </nav>
  </header>
