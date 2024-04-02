<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Login | Koperasi Desa Beji</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo base_url('template/')?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url('template/')?>bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo base_url('template/')?>bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo base_url('template/')?>dist/css/AdminLTE.min.css">
  

  <meta name="viewport" content="width=device-width, user-scalable=1, initial-scale=1, maximum-scale=1">
        <link rel="stylesheet" href="<?php echo base_url('template/')?>bower_components/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url('template/')?>bower_components/bootstrap/dist/css/main.min.css">
<script src="<?php echo base_url('template/')?>bower_components/bootstrap/dist/css//modernizr.js"></script>
<style>
    .error-message {
        background-color: #f2dede; /* Warna latar merah muda */
        color: #a94442; /* Warna teks merah */
        padding: 10px; /* Ruang jeda di dalam kotak pesan */
        border: 1px solid #ebccd1; /* Garis tepi merah */
        border-radius: 5px; /* Sudut melengkung kotak */
        margin-bottom: 15px; /* Ruang bawah dari pesan */
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const togglePassword = document.querySelector('.toggle-password');
        const passwordField = document.querySelector('input[name="password"]');

        togglePassword.addEventListener('click', function () {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    });
</script>

</head>
<body class="hold-transition login-page" li style="background-image: url(<?php echo base_url().'template/img/ss.jpg'?>);">
<div id="bg">
<div class="login-box">
  <div>
   <p><?php echo $this->session->flashdata('msg');?></p>
  </div>
  <div class="login-box-body">
  <div style="color: red;margin-bottom: 15px;">
  <?php if($this->session->flashdata('message')): ?>
  <div class="error-message">
		<?php
		// Cek apakah terdapat session nama message
		if($this->session->flashdata('message')){ // Jika ada
			echo $this->session->flashdata('message'); // Tampilkan pesannya
      $this->session->unset_userdata('message');
		}
		?>
    </div>
    <?php endif; ?>
	</div>
    <p class="login-box-msg"> <img src="<?php echo base_url().'template/img/login.png'?>"></p><hr/>
    <p><i class="fa fa-info-circle mg-r-md text-danger"></i><i>Silahkan login untuk menggunakan sistem</i></p>

    <form action="<?php echo base_url().'Auth/login'?>" method="post">
      <div class="input-group input-group-md mg-b-md">
       <span class="input-group-addon"><i class="fa fa-user"></i></span>
        <input type="text" name="username" class="form-control" placeholder="Username" required oninvalid="this.setCustomValidity('Username Harus di Isi')" oninput="setCustomValidity('')">

      </div>
      <p>
      </p>
      <div class="input-group input-group-md mg-b-md">
    <span class="input-group-addon"><i class="fa fa-key"></i></span>
    <input type="password" name="password" class="form-control" placeholder="Password" required oninvalid="this.setCustomValidity('Password Harus di Isi')" oninput="setCustomValidity('')">
    <span class="input-group-addon toggle-password"><i class="fa fa-eye" aria-hidden="true"></i></span>
</div>
      <p>
      </p>
      <button class="btn btn-md btn-info btn-block mg-t-md hidden-xs" type="submit"><i class="fa fa-sign-in mg-r-sm"></i> Login</button>
      <button class="btn btn-lg btn-info btn-block mg-t-lg visible-xs" type="submit"><i class="fa fa-sign-in mg-r-sm"></i> Login</button>
    </form>
    <br>
 <?php echo form_close(); ?>

  <!-- Belum Punya Akun?  <a href="<?php echo base_url('Auth/add') ?>" class="text-center"><strong> <font color="black">Daftar Disini </font></strong></a>
   <br><br> -->
    
    <p><center>Copyright &copy; 2024 <br> Koperasi Desa Beji</center></p>
  </div>
</div>



<script src="<?php echo base_url('template/')?>bower_components/jquery/dist/jquery-2.2.3.min.js"></script>
<script src="<?php echo base_url('template/')?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo base_url('template/')?>plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>