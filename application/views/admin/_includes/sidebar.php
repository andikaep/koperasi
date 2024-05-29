<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?php echo base_url('assetAdmin/dist/img/popr.jpg')?> " class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>Mr. Admin</p>
         <small><?php echo $this->session->userdata('nama'); ?></small><br>
        <!-- <a href="#"><i class="fa fa-circle text-success"></i> Siap</a> -->
      </div>
    </div>

    <!-- search form -->
      <!-- <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form> -->
      <!-- /.search form -->

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Menu</li>

        <li><a href="<?php echo base_url('') ?>"><i class="fa fa-book"></i> <span>Dashboard</span></a></li>
        <?php if ($this->session->userdata('level') == 1): ?>
        <li><a href="<?php echo base_url('pegawai') ?>"><i class="fa fa-fw fa-user-plus"></i> <span>Pegawai</span></a></li>
        
          
        <li><a href="<?php echo base_url('anggota') ?>"><i class="fa fa-fw fa-child"></i> <span>Anggota Koperasi</span></a>
        </li>
        <?php endif; ?>
        <?php if ($this->session->userdata('level') == 1 || $this->session->userdata('level') == 2) : ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-fw fa-dollar"></i> <span>Simpanan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('simpanan_pokok') ?>"><i class="fa fa-circle-o"></i>Simpanan Pokok</a></li>
            <li><a href="<?php echo base_url('simpanan_wajib') ?>"><i class="fa fa-circle-o"></i>Simpanan Wajib</a></li>
            <li><a href="<?php echo base_url('simpanan_sukarela') ?>"><i class="fa fa-circle-o"></i>Simpanan Sukarela</a></li>
          </ul>
        </li>
        <li><a href="<?php echo base_url('pinjaman') ?>"><i class="fa fa-fw fa-money"></i> <span>Pinjaman</span></a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-fw fa-dollar"></i> <span>Angsuran</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('angsuran') ?>"><i class="fa fa-circle-o"></i>Kelola Angsuran</a></li>
            <li><a href="<?php echo base_url('angsuran/list_anggota') ?>"><i class="fa fa-circle-o"></i>Detail Angsuran</a></li>
          </ul>
        </li>
        </li>
        <?php endif; ?>
        <?php if ($this->session->userdata('level') == 1): ?>
        <li><a href="<?php echo base_url('pengguna') ?>"><i class="fa fa-fw fa-users"></i> <span>Manajemen Pengguna</span></a>
        </li>
        <?php endif; ?>
        <li><a href="<?php echo base_url('pinjaman/simulasi') ?>"><i class="fa fa-fw fa-calculator"></i> <span>Simulasi Pinjaman</span></a>
        </li>
        <li><a href="<?php echo base_url('calculator') ?>"><i class="fa fa-fw fa-calculator"></i> <span>Kalkulator</span></a>
        </li>
        <li><a href="<?php echo base_url('dashboard/petunjuk') ?>"><i class="fa fa-folder-open-o" aria-hidden="true"></i> <span>Petunjuk</span></a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
