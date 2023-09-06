<?php
include 'fungsi_php.php';
$fungsi=new fungsi_php();
if(isset($_POST['login']))
{
	?>
		<!DOCTYPE html>
		<html lang="en">
		<head>
		    <meta charset="utf-8">
		    <meta http-equiv="X-UA-Compatible" content="IE=edge">
		    <meta name="viewport" content="width=device-width, initial-scale=1">
		    <title>PinCamera</title>
		        <!-- Favicon -->
		        <link rel="shortcut icon" type="image/x-icon" href="gambar/favicon.ico" />
		        <!--======== All Stylesheet =========-->
		        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		        <!-- Fontes -->
		        <link href="css/buttons.css" rel="stylesheet">
		        <!-- adminbag main css -->
		        <link href="css/main.css" rel="stylesheet">
		        <!-- media css for responsive  -->
		        <link href="css/main.media.css" rel="stylesheet">
		        <link href="css/style.css" rel="stylesheet">
		  </head>
		<body class="login-layout-full login">
		<div class="page-brand-info">
		  <div class="brand"> <h1><i class="glyphicon glyphicon-camera"></i> PinCamera</h1> </div>
		  <p class="font-size-20">Bingung kasih tag line apa. Kasih lorem ipsum aja</p>
		</div>
		<div class="loginColumns " style="text-align: center;">
		  <div>
		    <a href="home.php">
		      <h2 style="color: #0cbaaee6;"><i class="glyphicon glyphicon-camera"></i> PinCamera</h2>
		    </a>
		    </div>
		    <h3>Selamat Datang di PinCamera</h3>
		    <p>Login untuk dapatkan inspirasimu</p>
		    <?php
			$fungsi->login();
		    ?>
		    <form action="cek.php"  class="top15" method="post">
		      <div class="form-group">
		        <input type="text" name="username" required="" placeholder="Username" class="form-control">
		      </div>
		      <div class="form-group">
		        <input type="password" name="password" required="" placeholder="Password" class="form-control">
		      </div>
		      <input type="submit" name="login" value="Login" class="btn btn-outline green block full-width bottom15">
		      <p class="text-muted text-center"><small>Belum punya akun?</small></p>
		      <a href="register.html" class="btn btn-sm btn-success btn-block">Daftar Sekarang</a>
		    </form>
		</div>
		</body>
		</html>
<?php
}
else
{
?>
	<!DOCTYPE html>
	<html lang="en">
	<head>
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <title>PinCamera</title>
	        <!-- Favicon -->
	        <link rel="shortcut icon" type="image/x-icon" href="gambar/favicon.ico" />
	        <!--======== All Stylesheet =========-->
	        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	        <!-- Fontes -->
	        <link href="css/buttons.css" rel="stylesheet">
	        <!-- adminbag main css -->
	        <link href="css/main.css" rel="stylesheet">
	        <!-- media css for responsive  -->
	        <link href="css/main.media.css" rel="stylesheet">
	        <link href="css/style.css" rel="stylesheet">
	  </head>
	<body class="login-layout-full login">
	<div class="page-brand-info">
	  <div class="brand"> <h1><i class="glyphicon glyphicon-camera"></i> PinCamera</h1> </div>
	  <p class="font-size-20">Bingung kasih tag line apa. Kasih lorem ipsum aja</p>
	</div>
	</div>
	<div class="loginColumns" style="text-align: center;">
	  <div>
	    <a href="home.php">
	      <h2 style="color: #0cbaaee6;"><i class="glyphicon glyphicon-camera"></i> PinCamera</h2>
	    </a>
	    </div>
	    <h3>Selamat Datang di PinCamera</h3>
	    <p>Segera daftar untuk dapatkan inspirasimu</p>
	    <?php
		$fungsi->daftar();
	    ?>
	    <form action="cek.php"  class="top15" method="post">
	    <div class="form-group">
	        <input type="text" name="nama_depan" required="" placeholder="Nama Depan" class="form-control">
	        <input type="text" name="nama_belakang" required="" placeholder="Nama Belakang" class="form-control">
	      </div>
	      <div class="form-group">
	        <input type="text" name="username" required="" placeholder="Username" class="form-control">
	      </div>
	      <div class="form-group">
	        <input type="password" name="password" required="" placeholder="Password" class="form-control">
	      </div>
	      <div class="form-group">
	        <input type="password" name="password2" required="" placeholder="Konfirmasi Password" class="form-control">
	      </div>
	      <div class="form-group">
	      <div class="i-checks">
	        <input type="checkbox" class="iCheck" indeterminate="true" required>
	        Setuju dengan syarat dan ketentuan </div>
	    </div>
	      <input type="submit" name="daftar" value="daftar" class="btn btn-outline green block full-width bottom15">
	      <p class="text-muted text-center"><small>Sudah punya akun?</small></p>
	      <a href="index.html" class="btn btn-sm btn-block btn-success">Login</a>
	    </form>
	</div>
	</body>
	</html>
<?php
}
?>