<?php

session_start();
class fungsi_php
{
	public $dbHost = 'sql208.epizy.com';
	public $dbUser = 'epiz_20210098';
	public $dbPassword = 'pincamera';
	public $dbName = 'epiz_20210098_pincamera';

	function login()
	{
		$username = $_POST['username'];
		$password = strtolower($_POST['password']);
		$hash = md5($password);

		$koneksi = mysqli_connect($this->dbHost, $this->dbUser, $this->dbPassword);
		mysqli_select_db($koneksi, $this->dbName) or die("Database anda tidak ada");

		$query = mysqli_query($koneksi, "SELECT * FROM user where username='$username' and password='$hash'");
		$num = mysqli_num_rows($query);
		if ($num > 0) {
			$_SESSION['username'] = $username;
			header("location:user/index.php?page=home&status=ok&status=ok");
		} else {
?>
			<div class="alert alert-danger" role="alert">
				<b style="color: #a94442;">Maaf </b>username atau password anda salah
			</div>
		<?php
		}
	}
	function daftar()
	{
		$nama_depan = $_POST['nama_depan'];
		$nama_belakang = $_POST['nama_belakang'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$konfirmasi = $_POST['password2'];
		$hash = md5($password);

		$koneksi = mysqli_connect($this->dbHost, $this->dbUser, $this->dbPassword);
		mysqli_select_db($koneksi, $this->dbName) or die("Database anda tidak ada");

		$query = mysqli_query($koneksi, "SELECT username FROM user where username='$username'");
		$num = mysqli_num_rows($query);
		$cekmax = mysqli_query($koneksi, "SELECT max(id_user) as id FROM user");
		$ambil_id = mysqli_fetch_assoc($cekmax);
		$ins_id = $ambil_id['id'] + 1;
		if ($num > 0) {
			echo "<script type='text/javascript'>alert('Password tidak cocok');document.location='register.html'</script>";
		} else {
			if ($password == $konfirmasi) {
				$querybaru = mysqli_query($koneksi, "INSERT INTO user VALUES('" . $ins_id . "','" . $username . "','" . $hash . "')");
				$querybaru = mysqli_query($koneksi, "INSERT INTO `profil`(`id_user`, `nama_depan`, `nama_belakang`) VALUES ('" . $ins_id . "','" . $nama_depan . "','" . $nama_belakang . "')");
				if ($query && $querybaru) {
					$_SESSION['username'] = $username;
					header("location:user/index.php?page=home&status=ok&status=ok");
				}
			} else {
				echo "<script type='text/javascript'>alert('Password tidak cocok');document.location='register.html'</script>";
			}
		}
	}
	function cekfoto()
	{
		$koneksi = mysqli_connect($this->dbHost, $this->dbUser, $this->dbPassword);
		mysqli_select_db($koneksi, $this->dbName) or die("Database anda tidak ada");

		$query = mysqli_query($koneksi, "SELECT profil.location FROM profil, user where user.id_user=profil.id_user and username='" . $_SESSION['username'] . "'");
		$cek = mysqli_fetch_assoc($query);
		if (($cek['location']) != "") {
		?>
			<a data-close-others="true" data-hover="dropdown" data-toggle="dropdown" class="dropdown-toggle" href="javascript:;">
				<img src="<?php echo $cek['location']; ?>" class="img-circle" alt="">
				<span class="username username-hide-on-mobile"> <?php echo $_SESSION['username']; ?></span> <i class="glyphicon glyphicon-menu-down"></i>
			</a>
		<?php
		} else {
		?>
			<a data-close-others="true" data-hover="dropdown" data-toggle="dropdown" class="dropdown-toggle" href="javascript:;">
				<img src="../gambar/petugas.jpg" class="img-circle" alt="">
				<span class="username username-hide-on-mobile"> <?php echo $_SESSION['username']; ?></span> <i class="glyphicon glyphicon-menu-down"></i>
			</a>
<?php
		}
	}
	function tampil_kategori()
	{
		$koneksi = mysqli_connect($this->dbHost, $this->dbUser, $this->dbPassword);
		mysqli_select_db($koneksi, $this->dbName) or die("Database anda tidak ada");

		if (isset($_SESSION['username'])) {
			echo "<br>";
			$query = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY nama_kategori");
			while ($data = mysqli_fetch_assoc($query)) {
				$row = mysqli_num_rows($query);
				if ($row % 2 == 0) {
					echo "<a href='index.php?page=home&status=ok&kategori=" . $data['id_kategori'] . "' style=' margin-top:-2%; margin-bottom:5%; text-decoration:none; font-size:12px; background-color:#29ABA4; color:white;' class='btn btn-md btn-round'>" . $data['nama_kategori'] . "</a> ";
				} else {
					echo "<a href='index.php?page=home&status=ok&kategori=" . $data['id_kategori'] . "' style=' margin-top:-2%; margin-bottom:5%; text-decoration:none; font-size:12px; color:white; background-color:rgba(35,102,187,0.71);' class='btn btn-md btn-round'>" . $data['nama_kategori'] . "</a> ";
				}
			}
		} else {
			echo "<br>";
			$query = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY nama_kategori");
			while ($data = mysqli_fetch_assoc($query)) {
				$row = mysqli_num_rows($query);
				if ($row % 2 == 0) {
					echo "<a href='home.php?kategori=" . $data['id_kategori'] . "' style=' margin-top:-2%; margin-bottom:5%; text-decoration:none; font-size:12px;' class='btn btn-md btn-round red'>" . $data['nama_kategori'] . "</a> ";
				} else {
					echo "<a href='home.php?kategori=" . $data['id_kategori'] . "' style=' margin-top:-2%; margin-bottom:5%; text-decoration:none; font-size:12px; color:white; background-color:rgba(35,102,187,0.71);' class='btn btn-md btn-round'>" . $data['nama_kategori'] . "</a> ";
				}
			}
		}
	}
	function kategorimodal()
	{
		$koneksi = mysqli_connect($this->dbHost, $this->dbUser, $this->dbPassword);
		mysqli_select_db($koneksi, $this->dbName) or die("Database anda tidak ada");

		$query = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY nama_kategori");
		while ($data = mysqli_fetch_assoc($query)) {
			echo "<option value='" . $data['id_kategori'] . "'>" . $data['nama_kategori'] . "</option> ";
		}
	}
	function uploadgaleri()
	{
		$koneksi = mysqli_connect($this->dbHost, $this->dbUser, $this->dbPassword);
		mysqli_select_db($koneksi, $this->dbName) or die("Database anda tidak ada");

		$query_id = mysqli_query($koneksi, "SELECT id_user FROM user WHERE username='" . $_SESSION['username'] . "'");
		$ambil = mysqli_fetch_assoc($query_id);
		$id_user = $ambil['id_user'];

		if (isset($_POST['upload'])) {
			$allowed_ext  = array('jpg', 'jpeg', 'png', 'gif');
			$file_name    = $_FILES['file']['name'];
			$file_ext   = strtolower(end(explode('.', $file_name)));
			$file_size    = $_FILES['file']['size'];
			$file_tmp   = $_FILES['file']['tmp_name'];

			$judul = $_POST['judul'];
			$kategori = $_POST['kategori'];
			$caption = $_POST['caption'];
			$tag = $_POST['tag'];

			if (in_array($file_ext, $allowed_ext) === true) {
				$lokasi = 'data/' . $file_name;
				move_uploaded_file($file_tmp, $lokasi);

				$in = mysqli_query($koneksi, "INSERT INTO upload (judul_post, id_kategori, keterangan,tag,name, size, location, id_user,lihat) VALUES ('$judul','$kategori','$caption','$tag','$file_name', '$file_size', '$lokasi','$id_user','0')");
				if ($in) {
					echo "<script type='text/javascript'>document.location='index.php?page=koleksi'</script>";
				} else {
					echo "<script type='text/javascript'>alert('Gagal Upload File, Coba lagi nanti');document.location='index.php?page=koleksi'</script>";
				}
			} else {
				echo "<script type='text/javascript'>alert('Ekstensi File tidak didukung');document.location='index.php?page=koleksi'</script>";
			}
		}
	}
	function tag()
	{
		$koneksi = mysqli_connect($this->dbHost, $this->dbUser, $this->dbPassword);
		mysqli_select_db($koneksi, $this->dbName) or die("Database anda tidak ada");

		$lokasi1 = mysqli_query($koneksi, "SELECT profil.location,upload.judul_post, upload.keterangan,upload.location,upload.lihat, upload.id_post, upload.tag FROM profil,upload WHERE upload.id_user=profil.id_user AND upload.tag LIKE '%" . $_GET['tag'] . "%'");
		$cek1 = mysqli_num_rows($lokasi1);
		$counter = 0;
		if ($cek1) {
			echo "<div class='col-sm-4 col-lg-4 col-md-4 img-responsive'>
						   <div class='thumbnail btn-round'>
				                     		<div class='caption'>
							<h3 align='center'>- <i class='glyphicon glyphicon-tags'></i> Tag berkaitan -</h3>
							<h4 align='center'># " . $_GET['tag'] . "</h4>";

			while ($data1 = mysqli_fetch_array($lokasi1)) {

				$lokasi = mysqli_query($koneksi, "SELECT user.username, profil.location FROM user,profil WHERE user.id_user='" . @$data['id_user'] . "' and profil.id_user=user.id_user");
				$user = mysqli_query($koneksi, "SELECT username FROM user WHERE id_user='" . @$data['id_user'] . "'");
				$ambil = mysqli_fetch_array($lokasi);
				$ambil1 = mysqli_fetch_array($user);
				// $tambah=$data['lihat']+1;
				// $query_view=mysqli_query($koneksi,"UPDATE upload SET lihat='".$tambah."' WHERE id_post='".$data['id_post']."'");

				echo "
				                      <a href='index.php?page=lihatuser&user=" . $ambil[0] . "' style='text-decoration: none;' >
				                      ";
				if (($ambil[1]) != "") {
					echo "<img src='" . $ambil[1] . "' class='img-circle img-responsive' style='width: 10%; height: 10%; float: left;'>";
				} else {
					echo "<img src='../gambar/petugas.jpg' class='img-circle img-responsive' style='width: 10%; height: 10%; float: left;'>";
				}
				echo "
				                         <h4 style='color: #337ab7; padding: 2%;'>
				                           &nbsp " . $ambil1[0] . "
				                        </h4>
				                      </a>
				                      <br>
				                    </div>
				                    <img src='" . $data1['location'] . "' data-toggle='modal' data-target='.bs-example-modal-sm" . $counter . "' class='img-responsive'>
				                      <div class='caption' data-toggle='modal' data-target='.bs-example-modal-sm" . $counter . "'>
				                        <h4 style='color: #3598DC;'>
				                          " . $data1['judul_post'] . "
				                        </h4>
				                        <br>
				                        <p>" . $data1['keterangan'] . "<a href='#'>&nbsp Lihat Selengkapnya</a></p>
				                      </div>
				                  </div>
				                </div>
				                <div class='modal fade bs-example-modal-sm" . $counter . "' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
					                <div class='modal-dialog modal-sm' role='document'>
					                  <div class='modal-content'>
					                    <div class='modal-header'>
					                      <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					                      <h4 class='modal-title' id='myModalLabel' style='color: #3598DC;' >" . $data1['judul_post'] . "</h4>
					                    </div>
					                    <div class='modal-body'>
					                      <img src='" . $data1['location'] . "' class='img-responsive'>
					                      <p><br>" . $data1['keterangan'] . "</p>
					                      ";
				if ($data1['tag'] != '') {
					$ambil_tag = explode("#", $data1['tag']);
					echo "<p>";
					foreach ($ambil_tag as $value) {
						if ($value == $ambil_tag[0]) {
							continue;
						} else {
							echo "<a href='index.php?page=tag&tag=" . $value . "'> #" . $value . " </a>";
						}
					}
					echo "</p>
					            	      </div>
					            	      <div class='modal-footer'>
				                                        <a href='index.php?page=komentar&id_post=" . $data1['id_post'] . "'><button type='submit' class='btn btn-sm btn-round btn-outline btn-info' name='komen'>
				                                          <i class='glyphicon glyphicon-send'></i> Komentar
				                                        </button></a>
					                    </div>
					                  </div>
					                </div>
					              </div>";
				} else {
					echo "</div>
					          	 <div class='modal-footer'>
				                                        <a href='index.php?page=komentar&id_post=" . $data1['id_post'] . "'><button type='submit' class='btn btn-sm btn-round btn-outline btn-info' name='komen'>
				                                          <i class='glyphicon glyphicon-send'></i> Komentar
				                                        </button></a>
					                    </div>
					                  </div>
					                </div>
					              </div>";
				}
				$counter++;
				echo "</div>";
			}
		}
	}
	function cari()
	{
		$koneksi = mysqli_connect($this->dbHost, $this->dbUser, $this->dbPassword);
		mysqli_select_db($koneksi, $this->dbName) or die("Database anda tidak ada");

		$query = mysqli_query($koneksi, "SELECT * FROM user INNER JOIN profil WHERE user.id_user=profil.id_user AND user.username LIKE '%" . $_POST['kunci'] . "%'");
		$lokasi1 = mysqli_query($koneksi, "SELECT profil.location,upload.judul_post, upload.keterangan,upload.location, upload.id_post, upload.tag FROM profil,upload WHERE upload.id_user=profil.id_user AND upload.tag LIKE '%" . $_POST['kunci'] . "%'");
		$cek = mysqli_num_rows($query);
		$cek1 = mysqli_num_rows($lokasi1);
		$counter = 0;

		if ($cek && $cek1) {
			while ($data = mysqli_fetch_array($query)) {
				$lokasi = mysqli_query($koneksi, "SELECT user.username, profil.location FROM user,profil WHERE user.id_user='" . $data['id_user'] . "' and profil.id_user=user.id_user");

				// $tambah=$data['lihat']+1;
				// $query_view=mysqli_query($koneksi,"UPDATE upload SET lihat='".$tambah."' WHERE id_post='".$data['id_post']."'");

				echo "<div class='col-sm-4 col-lg-4 col-md-4 img-responsive'>
		                  <div class='thumbnail btn-round'>
		                     <div class='caption'>
		                     		<h2 align='center'>Hasil Pencarian</h2>
									<h4 align='center'>- <i class='glyphicon glyphicon-user'></i> User -</h4>";
				while ($ambil1 = mysqli_fetch_array($lokasi)) {
					echo "<a href='index.php?page=lihatuser&user=" . $ambil1[0] . "' style='text-decoration: none;' >
		                      ";
					if (($ambil1[1]) != "") {
						echo "<img src='" . $ambil1[1] . "' class='img-circle img-responsive' style='width: 10%; height: 10%; float: left;'>";
					} else {
						echo "<img src='../gambar/petugas.jpg' class='img-circle img-responsive' style='width: 10%; height: 10%; float: left;'>";
					}
					echo "
				                         <h4 style='color: #337ab7; padding: 2%;'>
				                           &nbsp " . $ambil1[0] . "
				                        </h4>
				                      </a>
				                      <br>";
				}
				echo "</div>            
				   </div>";
				echo "<div class='thumbnail btn-round'>
		                     		<div class='caption'>
					<h4 align='center'>- <i class='glyphicon glyphicon-tags'></i> Tag berkaitan -</h4>";

				while ($data1 = mysqli_fetch_array($lokasi1)) {

					$lokasi = mysqli_query($koneksi, "SELECT user.username, profil.location FROM user,profil WHERE user.id_user='" . @$data['id_user'] . "' and profil.id_user=user.id_user");
					$user = mysqli_query($koneksi, "SELECT username FROM user WHERE id_user='" . @$data['id_user'] . "'");
					$ambil = mysqli_fetch_array($lokasi);
					$ambil1 = mysqli_fetch_array($user);
					// $tambah=$data['lihat']+1;
					// $query_view=mysqli_query($koneksi,"UPDATE upload SET lihat='".$tambah."' WHERE id_post='".$data['id_post']."'");

					echo "
					                      <a href='index.php?page=lihatuser&user=" . $ambil[0] . "' style='text-decoration: none;' >
					                      ";
					if (($ambil[1]) != "") {
						echo "<img src='" . $ambil[1] . "' class='img-circle img-responsive' style='width: 10%; height: 10%; float: left;'>";
					} else {
						echo "<img src='../gambar/petugas.jpg' class='img-circle img-responsive' style='width: 10%; height: 10%; float: left;'>";
					}
					echo "
					                         <h4 style='color: #337ab7; padding: 2%;'>
					                           &nbsp " . $ambil1[0] . "
					                        </h4>
					                      </a>
					                      <br>
					                    </div>
					                    <img src='" . $data1['location'] . "' data-toggle='modal' data-target='.bs-example-modal-sm" . $counter . "' class='img-responsive'>
					                      <div class='caption' data-toggle='modal' data-target='.bs-example-modal-sm" . $counter . "'>
					                        <h4 style='color: #3598DC;'>
					                          " . $data1['judul_post'] . "
					                        </h4>
					                        <br>
					                        <p>" . $data1['keterangan'] . "<a href='#'>&nbsp Lihat Selengkapnya</a></p>
					                      </div>
					                  </div>
					                </div>
					                <div class='modal fade bs-example-modal-sm" . $counter . "' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
						                <div class='modal-dialog modal-sm' role='document'>
						                  <div class='modal-content'>
						                    <div class='modal-header'>
						                      <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						                      <h4 class='modal-title' id='myModalLabel' style='color: #3598DC;' >" . $data1['judul_post'] . "</h4>
						                    </div>
						                    <div class='modal-body'>
						                      <img src='" . $data1['location'] . "' class='img-responsive'>
						                      <p><br>" . $data1['keterangan'] . "</p>
						                      ";
					if ($data1['tag'] != '') {
						$ambil_tag = explode("#", $data1['tag']);
						echo "<p>";
						foreach ($ambil_tag as $value) {
							if ($value == $ambil_tag[0]) {
								continue;
							} else {
								echo "<a href='index.php?page=tag&tag=" . $value . "'> #" . $value . " </a>";
							}
						}
						echo "</p>
						            	      </div>
						            	      <div class='modal-footer'>
					                                        <a href='index.php?page=komentar&id_post=" . $data1['id_post'] . "'><button type='submit' class='btn btn-sm btn-round btn-outline btn-info' name='komen'>
					                                          <i class='glyphicon glyphicon-send'></i> Komentar
					                                        </button></a>
						                    </div>
						                  </div>
						                </div>
						              </div>";
					} else {
						echo "</div>
						          	 <div class='modal-footer'>
					                                        <a href='index.php?page=komentar&id_post=" . $data1['id_post'] . "'><button type='submit' class='btn btn-sm btn-round btn-outline btn-info' name='komen'>
					                                          <i class='glyphicon glyphicon-send'></i> Komentar
					                                        </button></a>
						                    </div>
						                  </div>
						                </div>
						              </div>";
					}
					$counter++;
				}
				echo "</div>";
			}
		} elseif ($cek1) {
			echo "<div class='col-sm-4 col-lg-4 col-md-4 img-responsive'>
				                  <div class='thumbnail btn-round'>
				                     <div class='caption'>
				                     		<h2 align='center'>Hasil Pencarian</h2>
							<h4 align='center'>- <i class='glyphicon glyphicon-user'></i> User -</h4>
							<p align='center'>User tidak ditemukan</p>
						   </div>            
						   </div>";
			echo "<div class='thumbnail btn-round'>
				                     		<div class='caption'>
							<h4 align='center'>- <i class='glyphicon glyphicon-tags'></i> Tag berkaitan -</h4>";

			while ($data1 = mysqli_fetch_array($lokasi1)) {

				$lokasi = mysqli_query($koneksi, "SELECT user.username, profil.location FROM user,profil WHERE user.id_user='" . @$data['id_user'] . "' and profil.id_user=user.id_user");
				$user = mysqli_query($koneksi, "SELECT username FROM user WHERE id_user='" . @$data['id_user'] . "'");
				$ambil = mysqli_fetch_array($lokasi);
				$ambil1 = mysqli_fetch_array($user);
				// $tambah=$data['lihat']+1;
				// $query_view=mysqli_query($koneksi,"UPDATE upload SET lihat='".$tambah."' WHERE id_post='".$data['id_post']."'");

				echo "
					                      <a href='index.php?page=lihatuser&user=" . $ambil[0] . "' style='text-decoration: none;' >
					                      ";
				if (($ambil[1]) != "") {
					echo "<img src='" . $ambil[1] . "' class='img-circle img-responsive' style='width: 10%; height: 10%; float: left;'>";
				} else {
					echo "<img src='../gambar/petugas.jpg' class='img-circle img-responsive' style='width: 10%; height: 10%; float: left;'>";
				}
				echo "
					                         <h4 style='color: #337ab7; padding: 2%;'>
					                           &nbsp " . $ambil1[0] . "
					                        </h4>
					                      </a>
					                      <br>
					                    </div>
					                    <img src='" . $data1['location'] . "' data-toggle='modal' data-target='.bs-example-modal-sm" . $counter . "' class='img-responsive'>
					                      <div class='caption' data-toggle='modal' data-target='.bs-example-modal-sm" . $counter . "'>
					                        <h4 style='color: #3598DC;'>
					                          " . $data1['judul_post'] . "
					                        </h4>
					                        <br>
					                        <p>" . $data1['keterangan'] . "<a href='#'>&nbsp Lihat Selengkapnya</a></p>
					                      </div>
					                  </div>
					                </div>
					                <div class='modal fade bs-example-modal-sm" . $counter . "' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
						                <div class='modal-dialog modal-sm' role='document'>
						                  <div class='modal-content'>
						                    <div class='modal-header'>
						                      <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						                      <h4 class='modal-title' id='myModalLabel' style='color: #3598DC;' >" . $data1['judul_post'] . "</h4>
						                    </div>
						                    <div class='modal-body'>
						                      <img src='" . $data1['location'] . "' class='img-responsive'>
						                      <p><br>" . $data1['keterangan'] . "</p>
						                      ";
				if ($data1['tag'] != '') {
					$ambil_tag = explode("#", $data1['tag']);
					echo "<p>";
					foreach ($ambil_tag as $value) {
						if ($value == $ambil_tag[0]) {
							continue;
						} else {
							echo "<a href='index.php?page=tag&tag=" . $value . "'> #" . $value . " </a>";
						}
					}
					echo "</p>
						            	      </div>
						            	      <div class='modal-footer'>
					                                        <a href='index.php?page=komentar&id_post=" . $data1['id_post'] . "'><button type='submit' class='btn btn-sm btn-round btn-outline btn-info' name='komen'>
					                                          <i class='glyphicon glyphicon-send'></i> Komentar
					                                        </button></a>
						                    </div>
						                  </div>
						                </div>
						              </div>";
				} else {
					echo "</div>
						          	 <div class='modal-footer'>
					                                        <a href='index.php?page=komentar&id_post=" . $data1['id_post'] . "'><button type='submit' class='btn btn-sm btn-round btn-outline btn-info' name='komen'>
					                                          <i class='glyphicon glyphicon-send'></i> Komentar
					                                        </button></a>
						                    </div>
						                  </div>
						                </div>
						              </div>";
				}
				$counter++;
				echo "</div>";
			}
		} elseif ($cek) {
			while ($data = mysqli_fetch_array($query)) {
				$lokasi = mysqli_query($koneksi, "SELECT user.username, profil.location FROM user,profil WHERE user.id_user='" . $data['id_user'] . "' and profil.id_user=user.id_user");

				// $tambah=$data['lihat']+1;
				// $query_view=mysqli_query($koneksi,"UPDATE upload SET lihat='".$tambah."' WHERE id_post='".$data['id_post']."'");

				echo "<div class='col-sm-4 col-lg-4 col-md-4 img-responsive'>
		                  <div class='thumbnail btn-round'>
		                     <div class='caption'>
		                     		<h2 align='center'>Hasil Pencarian</h2>
									<h4 align='center'>- <i class='glyphicon glyphicon-user'></i> User -</h4>";
				while ($ambil1 = mysqli_fetch_array($lokasi)) {
					echo "<a href='index.php?page=lihatuser&user=" . $ambil1[0] . "' style='text-decoration: none;' >
		                      ";
					if (($ambil1[1]) != "") {
						echo "<img src='" . $ambil1[1] . "' class='img-circle img-responsive' style='width: 10%; height: 10%; float: left;'>";
					} else {
						echo "<img src='../gambar/petugas.jpg' class='img-circle img-responsive' style='width: 10%; height: 10%; float: left;'>";
					}
					echo "
				                         <h4 style='color: #337ab7; padding: 2%;'>
				                           &nbsp " . $ambil1[0] . "
				                        </h4>
				                      </a>
				                      <br>";
				}
				echo "</div>            
				   </div>";

				echo "<div class='thumbnail btn-round'>
				                     		<div class='caption'>
							<h4 align='center'>- <i class='glyphicon glyphicon-tags'></i> Tag berkaitan -</h4>
							<p align='center'>Tidak ditemukan posting berkaitan</p>
						   </div>            
						   </div>";
			}
		} else {
			echo "<div class='col-sm-4 col-lg-4 col-md-4 img-responsive'>
		                  <div class='thumbnail btn-round'>
		                     <div class='caption'>
	                     		<h2 align='center'>Hasil Pencarian</h2>
					<h4 align='center'>- <i class='glyphicon glyphicon-user'></i> User -</h4>
					<p align='center'>User tidak ditemukan</p>
				</div>
			</div>
			<div class='thumbnail btn-round'>
	                     		<div class='caption'>
				<h4 align='center'>- <i class='glyphicon glyphicon-tags'></i> Tag berkaitan -</h4>
				<p align='center'>Tidak ditemukan posting berkaitan</p>
			   </div>            
			   </div>
			   </div>";
		}
	}
	function koleksi()
	{
		$koneksi = mysqli_connect($this->dbHost, $this->dbUser, $this->dbPassword);
		mysqli_select_db($koneksi, $this->dbName) or die("Database anda tidak ada");

		$query_id = mysqli_query($koneksi, "SELECT id_user FROM user WHERE username='" . $_SESSION['username'] . "'");
		$id_ambil = mysqli_fetch_assoc($query_id);
		$id_user = $id_ambil['id_user'];
		$counter = 0;

		$query = mysqli_query($koneksi, "SELECT profil.location,upload.judul_post, upload.keterangan,upload.location, upload.id_post, upload.tag FROM profil,upload WHERE upload.id_user='$id_user' and upload.id_user=profil.id_user");
		$cek = mysqli_num_rows($query);

		if ($cek) {
			while ($data = mysqli_fetch_array($query)) {
				// $tambah=$data['lihat']+1;
				// $query_view=mysqli_query($koneksi,"UPDATE upload SET lihat='".$tambah."' WHERE id_post='".$data['id_post']."'");
				echo "<div class='col-sm-4 col-lg-4 col-md-4 img-responsive'>
				                  <div class='thumbnail btn-round'>
				                     <div class='caption'>
				                     <div class='pull-right social-action dropdown'>
					                <button class='dropdown-toggle btn white' data-toggle='dropdown'> <i class='glyphicon glyphicon-cog'></i> </button>
					                <ul class='dropdown-menu m-t-xs'>
					                  <li><a href='index.php?page=edit&id=" . $data['id_post'] . "' style='color:#333;'>Edit</a></li>
					                  <li><a href='index.php?page=hapus&id=" . $data['id_post'] . "' style='color:#333;'>Hapus</a></li>
					                </ul>
					              </div>
				                      <a href='#' style='text-decoration: none;' >";
				if ($data[0] == "") {

					echo "<img src='../gambar/petugas.jpg' class='img-circle img-responsive' style='width: 10%; height: 10%; float: left;'>";
				} else {
					echo "<img src='" . $data[0] . "' class='img-circle img-responsive' style='width: 10%; height: 10%; float: left;'>";
				}
				echo "<h4 style='color: #337ab7; padding: 2%;'>
				                           &nbsp " . $_SESSION['username'] . "
				                        </h4>
				                      </a>
				                      <br>
				                    </div>
				                    <img src='" . $data[3] . "' data-toggle='modal' data-target='.bs-example-modal-sm" . $counter . "' class='img-responsive'>
				                      <div class='caption' data-toggle='modal' data-target='.bs-example-modal-sm" . $counter . "'>
				                        <h4 style='color: #3598DC;'>
				                          " . $data[1] . "
				                        </h4>
				                        <br>
				                        <p>" . $data[2] . "<a href='#'>&nbsp Lihat Selengkapnya</a></p>
				                      </div>
				                  </div>
				                </div>
				                <div class='modal fade bs-example-modal-sm" . $counter . "' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
					                <div class='modal-dialog modal-sm' role='document'>
					                  <div class='modal-content'>
					                    <div class='modal-header'>
					                      <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					                      <h4 class='modal-title' id='myModalLabel' style='color: #3598DC;' >" . $data['judul_post'] . "</h4>
					                    </div>
					                    <div class='modal-body'>
					                      <img src='" . $data['location'] . "' class='img-responsive'>
					                      <p><br>" . $data['keterangan'] . "</p>
					                      ";
				if ($data['tag'] != '') {
					$ambil_tag = explode("#", $data['tag']);
					echo "<p>";
					foreach ($ambil_tag as $value) {
						if ($value == $ambil_tag[0]) {
							continue;
						} else {
							echo "<a href='index.php?page=tag&tag=" . $value . "'> #" . $value . " </a>";
						}
					}
					echo "</p>
					            	      </div>
					            	      <div class='modal-footer'>
				                                        <a href='index.php?page=komentar&id_post=" . $data['id_post'] . "'><button type='submit' class='btn btn-sm btn-round btn-outline btn-info' name='komen'>
				                                          <i class='glyphicon glyphicon-send'></i> Komentar
				                                        </button></a>
					                    </div>
					                  </div>
					                </div>
					              </div>";
				} else {
					echo "</div>
					          	 <div class='modal-footer'>
				                                        <a href='index.php?page=komentar&id_post=" . $data['id_post'] . "'><button type='submit' class='btn btn-sm btn-round btn-outline btn-info' name='komen'>
				                                          <i class='glyphicon glyphicon-send'></i> Komentar
				                                        </button></a>
					                    </div>
					                  </div>
					                </div>
					              </div>";
				}
				$counter++;
			}
		} else {
			echo "<div class='col-sm-7 col-lg-7 col-md-7 img-responsive'>
				<div class='thumbnail btn-round'>
					<div class='caption'>
						<h2 align='center'> Belum menemukan inspirasimu sendiri </h2>
						<h3 align='center'> Segera upload inspirasimu </h3>
					</div>
				</div>
				</div>";
		}
	}
	function lihatuserfoto()
	{
		$koneksi = mysqli_connect($this->dbHost, $this->dbUser, $this->dbPassword);
		mysqli_select_db($koneksi, $this->dbName) or die("Database anda tidak ada");

		$query = mysqli_query($koneksi, "SELECT profil.location FROM profil,user WHERE user.username='" . $_GET['user'] . "' and user.id_user=profil.id_user and profil.location!=''");
		$cek = mysqli_num_rows($query);
		$ambil = mysqli_fetch_assoc($query);

		if ($cek > 0) {
			echo "<img src='" . $ambil['location'] . "' class=''img-circle img-responsive'' style='width:100%; height:100%;'>";
		} else {
			echo "<img src='../gambar/petugas.png' class='img-circle img-responsive' style='width:100%; height:100%;'>";
		}
	}
	function lihatuserprofil()
	{
		$koneksi = mysqli_connect($this->dbHost, $this->dbUser, $this->dbPassword);
		mysqli_select_db($koneksi, $this->dbName) or die("Database anda tidak ada");

		$query = mysqli_query($koneksi, "SELECT profil.nama_depan, profil.nama_belakang, profil.status FROM profil,user WHERE user.username='" . $_GET['user'] . "' and user.id_user=profil.id_user");

		while ($ambil = mysqli_fetch_array($query)) {
			echo "
			                     <div class='caption'>
			                      <div class='caption'>
			                        <h4 style='color: #3598DC;'>
			                          " . $ambil[0] . " " . $ambil[1] . " - @" . $_GET['user'] . "
			                        </h4>
			                        <br>
			                      </div>
			                      <p>
			                      <blockquote>
			                          " . $ambil[2] . " <cite>Somebody famous</cite>
				          </blockquote>
				          </p>
			                      </div>";
		}
	}
	function lihatuserkoleksi()
	{
		$koneksi = mysqli_connect($this->dbHost, $this->dbUser, $this->dbPassword);
		mysqli_select_db($koneksi, $this->dbName) or die("Database anda tidak ada");

		$query_id = mysqli_query($koneksi, "SELECT id_user FROM user WHERE username='" . $_GET['user'] . "'");
		$id_ambil = mysqli_fetch_assoc($query_id);
		$id_user = $id_ambil['id_user'];
		$counter = 0;

		$query = mysqli_query($koneksi, "SELECT profil.location,upload.judul_post, upload.keterangan,upload.location, upload.id_post, upload.tag FROM profil,upload WHERE upload.id_user='$id_user' and upload.id_user=profil.id_user");
		$cek = mysqli_num_rows($query);

		if ($cek) {
			while ($data = mysqli_fetch_array($query)) {
				// $tambah=$data['lihat']+1;
				// $query_view=mysqli_query($koneksi,"UPDATE upload SET lihat='".$tambah."' WHERE id_post='".$data['id_post']."'");
				echo "<div class='col-sm-4 col-lg-4 col-md-4 img-responsive'>
				                  <div class='thumbnail btn-round'>
				                     <div class='caption'>
				                      <a href='#' style='text-decoration: none;' >";
				if ($data[0] == "") {

					echo "<img src='../gambar/petugas.jpg' class='img-circle img-responsive' style='width: 10%; height: 10%; float: left;'>";
				} else {
					echo "<img src='" . $data[0] . "' class='img-circle img-responsive' style='width: 10%; height: 10%; float: left;'>";
				}
				echo "<h4 style='color: #337ab7; padding: 2%;'>
				                           &nbsp " . $_GET['user'] . "
				                        </h4>
				                      </a>
				                      <br>
				                    </div>
				                    <img src='" . $data[3] . "' data-toggle='modal' data-target='.bs-example-modal-sm" . $counter . "' class='img-responsive'>
				                      <div class='caption' data-toggle='modal' data-target='.bs-example-modal-sm" . $counter . "'>
				                        <h4 style='color: #3598DC;'>
				                          " . $data[1] . "
				                        </h4>
				                        <br>
				                        <p>" . $data[2] . "<a href='#'>&nbsp Lihat Selengkapnya</a></p>
				                      </div>
				                  </div>
				                </div>
				                <div class='modal fade bs-example-modal-sm" . $counter . "' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
					                <div class='modal-dialog modal-sm' role='document'>
					                  <div class='modal-content'>
					                    <div class='modal-header'>
					                      <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					                      <h4 class='modal-title' id='myModalLabel' style='color: #3598DC;' >" . $data['judul_post'] . "</h4>
					                    </div>
					                    <div class='modal-body'>
					                      <img src='" . $data['location'] . "' class='img-responsive'>
					                      <p><br>" . $data['keterangan'] . "</p>
					                      ";
				if ($data['tag'] != '') {
					$ambil_tag = explode("#", $data['tag']);
					echo "<p>";
					foreach ($ambil_tag as $value) {
						if ($value == $ambil_tag[0]) {
							continue;
						} else {
							echo "<a href='index.php?page=tag&tag=" . $value . "'> #" . $value . " </a>";
						}
					}
					echo "</p>
					            	      </div>
					            	      <div class='modal-footer'>
				                                        <a href='index.php?page=komentar&id_post=" . $data['id_post'] . "'><button type='submit' class='btn btn-sm btn-round btn-outline btn-info' name='komen'>
				                                          <i class='glyphicon glyphicon-send'></i> Komentar
				                                        </button></a>
					                    </div>
					                  </div>
					                </div>
					              </div>";
				} else {
					echo "</div>
					          	 <div class='modal-footer'>
				                                        <a href='index.php?page=komentar&id_post=" . $data['id_post'] . "'><button type='submit' class='btn btn-sm btn-round btn-outline btn-info' name='komen'>
				                                          <i class='glyphicon glyphicon-send'></i> Komentar
				                                        </button></a>
					                    </div>
					                  </div>
					                </div>
					              </div>";
				}
				$counter++;
			}
		} else {
			echo "<div class='col-sm-7 col-lg-7 col-md-7 img-responsive'>
				<div class='thumbnail btn-round'>
					<div class='caption'>
						<h2 align='center'> Belum menemukan inspirasimu sendiri </h2>
						<h3 align='center'> Segera upload inspirasimu </h3>
					</div>
				</div>
				</div>";
		}
	}
	function galeri()
	{
		$koneksi = mysqli_connect($this->dbHost, $this->dbUser, $this->dbPassword);
		mysqli_select_db($koneksi, $this->dbName) or die("Database anda tidak ada");

		$counter = 0;
		$tag_counter = 1;
		if (@$_GET['status'] == 'ok') {
			$query = mysqli_query($koneksi, "SELECT * FROM upload ORDER BY id_post desc");
			while ($data = mysqli_fetch_assoc($query)) {
				$lokasi = mysqli_query($koneksi, "SELECT user.username, profil.location FROM user,profil WHERE user.id_user='" . $data['id_user'] . "' and profil.id_user=user.id_user");
				$user = mysqli_query($koneksi, "SELECT username FROM user WHERE id_user='" . $data['id_user'] . "'");
				$ambil = mysqli_fetch_array($lokasi);
				$ambil1 = mysqli_fetch_array($user);
				// $tambah=$data['lihat']+1;
				// $query_view=mysqli_query($koneksi,"UPDATE upload SET lihat='".$tambah."' WHERE id_post='".$data['id_post']."'");

				echo "<div class='col-sm-4 col-lg-4 col-md-4 img-responsive'>
				                  <div class='thumbnail btn-round'>
				                     <div class='caption'>
				                      <a href='index.php?page=lihatuser&user=" . $ambil[0] . "' style='text-decoration: none;' >
				                      ";
				if (($ambil[1]) != "") {
					echo "<img src='" . $ambil[1] . "' class='img-circle img-responsive' style='width: 10%; height: 10%; float: left;'>";
				} else {
					echo "<img src='../gambar/petugas.jpg' class='img-circle img-responsive' style='width: 10%; height: 10%; float: left;'>";
				}
				echo "
				                         <h4 style='color: #337ab7; padding: 2%;'>
				                           &nbsp " . $ambil1[0] . "
				                        </h4>
				                      </a>
				                      <br>
				                    </div>
				                    <img src='" . $data['location'] . "' data-toggle='modal' data-target='.bs-example-modal-sm" . $counter . "' class='img-responsive'>
				                      <div class='caption' data-toggle='modal' data-target='.bs-example-modal-sm" . $counter . "'>
				                        <h4 style='color: #3598DC;'>
				                          " . $data['judul_post'] . "
				                        </h4>
				                        <br>
				                        <p>" . $data['keterangan'] . "<a href='#'>&nbsp Lihat Selengkapnya</a></p>
				                      </div>
				                  </div>
				                </div>
				                <div class='modal fade bs-example-modal-sm" . $counter . "' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
					                <div class='modal-dialog modal-sm' role='document'>
					                  <div class='modal-content'>
					                    <div class='modal-header'>
					                      <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					                      <h4 class='modal-title' id='myModalLabel' style='color: #3598DC;' >" . $data['judul_post'] . "</h4>
					                    </div>
					                    <div class='modal-body'>
					                      <img src='" . $data['location'] . "' class='img-responsive'>
					                      <p><br>" . $data['keterangan'] . "</p>
					                      ";
				if ($data['tag'] != '') {
					$ambil_tag = explode("#", $data['tag']);
					echo "<p>";
					foreach ($ambil_tag as $value) {
						if ($value == $ambil_tag[0]) {
							continue;
						} else {
							echo "<a href='index.php?page=tag&tag=" . $value . "'> #" . $value . " </a>";
						}
					}
					echo "</p>
					            	      </div>
					            	      <div class='modal-footer'>
				                                        <a href='index.php?page=komentar&id_post=" . $data['id_post'] . "'><button type='submit' class='btn btn-sm btn-round btn-outline btn-info' name='komen'>
				                                          <i class='glyphicon glyphicon-send'></i> Komentar
				                                        </button></a>
					                    </div>
					                  </div>
					                </div>
					              </div>";
				} else {
					echo "</div>
					          	 <div class='modal-footer'>
				                                        <a href='index.php?page=komentar&id_post=" . $data['id_post'] . "'><button type='submit' class='btn btn-sm btn-round btn-outline btn-info' name='komen'>
				                                          <i class='glyphicon glyphicon-send'></i> Komentar
				                                        </button></a>
					                    </div>
					                  </div>
					                </div>
					              </div>";
				}
				$counter++;
			}
		} else {
			$query = mysqli_query($koneksi, "SELECT * FROM upload ORDER BY id_post desc");
			while ($data = mysqli_fetch_assoc($query)) {

				$lokasi = mysqli_query($koneksi, "SELECT profil.location FROM user,profil WHERE user.id_user='" . $data['id_user'] . "' and profil.id_user=user.id_user");
				$user = mysqli_query($koneksi, "SELECT username FROM user WHERE id_user='" . $data['id_user'] . "'");
				$ambil = mysqli_fetch_array($lokasi);
				$ambil1 = mysqli_fetch_array($user);


				// $tambah=$data['lihat']+1;
				// $query_view=mysqli_query($koneksi,"UPDATE upload SET lihat='".$tambah."' WHERE id_post='".$data['id_post']."'");
				echo "<div class='col-sm-4 col-lg-4 col-md-4 img-responsive'>
				                  <div class='thumbnail btn-round'>
				                     <div class='caption'>
				                      <a href='index.php?page=lihatuser&user=" . $ambil[0] . "' style='text-decoration: none;'>";
				if (($ambil[0]) != "") {
					echo "<img src='user/" . $ambil[0] . "' class='img-circle img-responsive' style='width: 10%; height: 10%; float: left;'>";
				} else {
					echo "<img src='gambar/petugas.jpg' class='img-circle img-responsive' style='width: 10%; height: 10%; float: left;'>";
				}
				echo "<h4 style='color: #337ab7; padding: 2%;'>
				                           &nbsp " . $ambil1[0] . "
				                        </h4>
				                      </a>
				                      <br>
				                    </div>
				                    <img src='user/" . $data['location'] . "' data-toggle='modal' data-target='.bs-example-modal-sm" . $counter . "' class='img-responsive'>
				                      <div class='caption' data-toggle='modal' data-target='.bs-example-modal-sm" . $counter . "'>
				                        <h4 style='color: #3598DC;'>
				                          " . $data['judul_post'] . "
				                        </h4>
				                        <br>
				                        <p>" . $data['keterangan'] . "<a href='#'>&nbsp Lihat Selengkapnya</a></p>
				                      </div>";
				echo "                </div>
				                </div>
				                <div class='modal fade bs-example-modal-sm" . $counter . "' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
					                <div class='modal-dialog modal-sm' role='document'>
					                  <div class='modal-content'>
					                    <div class='modal-header'>
					                      <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					                      <h4 class='modal-title' id='myModalLabel' style='color: #3598DC;' >" . $data['judul_post'] . "</h4>
					                    </div>
					                    <div class='modal-body'>
					                      <img src='user/" . $data['location'] . "' class='img-responsive'>
					                      <p><br>" . $data['keterangan'] . "</p>
					                      ";
				if ($data['tag'] != '') {
					$ambil_tag = explode("#", $data['tag']);
					echo "<p>";
					foreach ($ambil_tag as $value) {
						if ($value == $ambil_tag[0]) {
							continue;
						} else {
							echo "<a href='index.php?page=tag&tag=" . $value . "'> #" . $value . " </a>";
						}
					}
					echo "</p>
					            	      </div>
					                  </div>
					                </div>
					              </div>";
				} else {
					echo "</div>
					                  </div>
					                </div>
					              </div>";
				}
				$counter++;
			}
		}
	}
	function galerikategori()
	{
		$koneksi = mysqli_connect($this->dbHost, $this->dbUser, $this->dbPassword);
		mysqli_select_db($koneksi, $this->dbName) or die("Database anda tidak ada");

		$counter = 0;
		if (@$_GET['status'] == 'ok') {
			$query = mysqli_query($koneksi, "SELECT * FROM upload WHERE id_kategori='" . $_GET['kategori'] . "'");
			$cek = mysqli_num_rows($query);
			if ($cek) {
				while ($data = mysqli_fetch_assoc($query)) {
					$lokasi = mysqli_query($koneksi, "SELECT user.username, profil.location FROM user,profil WHERE user.id_user='" . $data['id_user'] . "' and profil.id_user=user.id_user");
					$user = mysqli_query($koneksi, "SELECT username FROM user WHERE id_user='" . $data['id_user'] . "'");
					$ambil = mysqli_fetch_array($lokasi);
					$ambil1 = mysqli_fetch_array($user);
					// $tambah=$data['lihat']+1;
					// $query_view=mysqli_query($koneksi,"UPDATE upload SET lihat='".$tambah."' WHERE id_post='".$data['id_post']."'");

					echo "<div class='col-sm-4 col-lg-4 col-md-4 img-responsive'>
					                  <div class='thumbnail btn-round'>
					                     <div class='caption'>
					                      <a href='index.php?page=lihatuser&user=" . $ambil[0] . "' style='text-decoration: none;' >
					                      ";
					if (($ambil[1]) != "") {
						echo "<img src='" . $ambil[1] . "' class='img-circle img-responsive' style='width: 10%; height: 10%; float: left;'>";
					} else {
						echo "<img src='../gambar/petugas.jpg' class='img-circle img-responsive' style='width: 10%; height: 10%; float: left;'>";
					}
					echo "
					                         <h4 style='color: #337ab7; padding: 2%;'>
					                           &nbsp " . $ambil1[0] . "
					                        </h4>
					                      </a>
					                      <br>
					                    </div>
					                    <img src='" . $data['location'] . "' data-toggle='modal' data-target='.bs-example-modal-sm" . $counter . "' class='img-responsive'>
					                      <div class='caption' data-toggle='modal' data-target='.bs-example-modal-sm" . $counter . "'>
					                        <h4 style='color: #3598DC;'>
					                          " . $data['judul_post'] . "
					                        </h4>
					                        <br>
					                        <p>" . $data['keterangan'] . "<a href='#'>&nbsp Lihat Selengkapnya</a></p>
					                      </div>
					                  </div>
					                </div>
					                <div class='modal fade bs-example-modal-sm" . $counter . "' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
						                <div class='modal-dialog modal-sm' role='document'>
						                  <div class='modal-content'>
						                    <div class='modal-header'>
						                      <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						                      <h4 class='modal-title' id='myModalLabel' style='color: #3598DC;' >" . $data['judul_post'] . "</h4>
						                    </div>
						                    <div class='modal-body'>
						                      <img src='" . $data['location'] . "' class='img-responsive'>
						                      <p><br>" . $data['keterangan'] . "</p>
						                      ";
					if ($data['tag'] != '') {
						$ambil_tag = explode("#", $data['tag']);
						echo "<p>";
						foreach ($ambil_tag as $value) {
							if ($value == $ambil_tag[0]) {
								continue;
							} else {
								echo "<a href='index.php?page=tag&tag=" . $value . "'> #" . $value . " </a>";
							}
						}
						echo "</p>
						            	      </div>
						            	      <div class='modal-footer'>
					                                        <a href='index.php?page=komentar&id_post=" . $data['id_post'] . "'><button type='submit' class='btn btn-sm btn-round btn-outline btn-info' name='komen'>
					                                          <i class='glyphicon glyphicon-send'></i> Komentar
					                                        </button></a>
						                    </div>
						                  </div>
						                </div>
						              </div>";
					} else {
						echo "</div>
						          	 <div class='modal-footer'>
					                                        <a href='index.php?page=komentar&id_post=" . $data['id_post'] . "'><button type='submit' class='btn btn-sm btn-round btn-outline btn-info' name='komen'>
					                                          <i class='glyphicon glyphicon-send'></i> Komentar
					                                        </button></a>
						                    </div>
						                  </div>
						                </div>
						              </div>";
					}
					$counter++;
				}
			} else {
				echo "<div class='col-sm-4 col-lg-4 col-md-4 img-responsive'>
					<div class='thumbnail btn-round'>
						<div class='caption'>
							<h2 align='center'> Tidak ada post yang berkaitan </h2>
						</div>
					</div>
					</div>";
			}
		} else {
			$query = mysqli_query($koneksi, "SELECT * FROM upload WHERE id_kategori='" . $_GET['kategori'] . "'");
			$cek = mysqli_num_rows($query);
			if ($cek) {
				while ($data = mysqli_fetch_assoc($query)) {
					$lokasi = mysqli_query($koneksi, "SELECT user.username, profil.location FROM user,profil WHERE user.id_user='" . $data['id_user'] . "' and profil.id_user=user.id_user");
					$user = mysqli_query($koneksi, "SELECT username FROM user WHERE id_user='" . $data['id_user'] . "'");
					$ambil = mysqli_fetch_array($lokasi);
					$ambil1 = mysqli_fetch_array($user);
					// $tambah=$data['lihat']+1;
					// $query_view=mysqli_query($koneksi,"UPDATE upload SET lihat='".$tambah."' WHERE id_post='".$data['id_post']."'");

					echo "<div class='col-sm-4 col-lg-4 col-md-4 img-responsive'>
					                  <div class='thumbnail btn-round'>
					                     <div class='caption'>
					                      <a href='index.php?page=lihatuser&user=" . $ambil[0] . "' style='text-decoration: none;' >
					                      ";
					if (($ambil[1]) != "") {
						echo "<img src='user/" . $ambil[1] . "' class='img-circle img-responsive' style='width: 10%; height: 10%; float: left;'>";
					} else {
						echo "<img src='gambar/petugas.jpg' class='img-circle img-responsive' style='width: 10%; height: 10%; float: left;'>";
					}
					echo "
					                         <h4 style='color: #337ab7; padding: 2%;'>
					                           &nbsp " . $ambil1[0] . "
					                        </h4>
					                      </a>
					                      <br>
					                    </div>
					                    <img src='user/" . $data['location'] . "' data-toggle='modal' data-target='.bs-example-modal-sm" . $counter . "' class='img-responsive'>
					                      <div class='caption' data-toggle='modal' data-target='.bs-example-modal-sm" . $counter . "'>
					                        <h4 style='color: #3598DC;'>
					                          " . $data['judul_post'] . "
					                        </h4>
					                        <br>
					                        <p>" . $data['keterangan'] . "<a href='#'>&nbsp Lihat Selengkapnya</a></p>
					                      </div>
					                  </div>
					                </div>
					                <div class='modal fade bs-example-modal-sm" . $counter . "' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
						                <div class='modal-dialog modal-sm' role='document'>
						                  <div class='modal-content'>
						                    <div class='modal-header'>
						                      <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						                      <h4 class='modal-title' id='myModalLabel' style='color: #3598DC;' >" . $data['judul_post'] . "</h4>
						                    </div>
						                    <div class='modal-body'>
						                      <img src='user/" . $data['location'] . "' class='img-responsive'>
						                      <p><br>" . $data['keterangan'] . "</p>
						                      ";
					if ($data['tag'] != '') {
						$ambil_tag = explode("#", $data['tag']);
						echo "<p>";
						foreach ($ambil_tag as $value) {
							if ($value == $ambil_tag[0]) {
								continue;
							} else {
								echo "<a href='index.php?page=tag&tag=" . $value . "'> #" . $value . " </a>";
							}
						}
						echo "</p>
						            	      </div>
						            	      <div class='modal-footer'>
					                                        <a href='index.php?page=komentar&id_post=" . $data['id_post'] . "'><button type='submit' class='btn btn-sm btn-round btn-outline btn-info' name='komen'>
					                                          <i class='glyphicon glyphicon-send'></i> Komentar
					                                        </button></a>
						                    </div>
						                  </div>
						                </div>
						              </div>";
					} else {
						echo "</div>
						          	 <div class='modal-footer'>
					                                        <a href='index.php?page=komentar&id_post=" . $data['id_post'] . "'><button type='submit' class='btn btn-sm btn-round btn-outline btn-info' name='komen'>
					                                          <i class='glyphicon glyphicon-send'></i> Komentar
					                                        </button></a>
						                    </div>
						                  </div>
						                </div>
						              </div>";
					}
					$counter++;
				}
			} else {
				echo "<div class='col-sm-4 col-lg-4 col-md-4 img-responsive'>
					<div class='thumbnail btn-round'>
						<div class='caption'>
							<h2 align='center'> Tidak ada post yang berkaitan </h2>
						</div>
					</div>
					</div>";
			}
		}
	}
	function fotoprofil()
	{
		$koneksi = mysqli_connect($this->dbHost, $this->dbUser, $this->dbPassword);
		mysqli_select_db($koneksi, $this->dbName) or die("Database anda tidak ada");

		$query = mysqli_query($koneksi, "SELECT profil.location FROM profil,user WHERE user.username='" . $_SESSION['username'] . "' and user.id_user=profil.id_user and profil.location!=''");
		$cek = mysqli_num_rows($query);
		$ambil = mysqli_fetch_assoc($query);

		if ($cek > 0) {
			echo "<img src='" . $ambil['location'] . "' class=''img-circle img-responsive'' style='width:100%; height:100%;'>";
		} else {
			echo "<img src='../gambar/petugas.png' class='img-circle img-responsive' style='width:100%; height:100%;'>";
		}
	}
	function profil()
	{
		$koneksi = mysqli_connect($this->dbHost, $this->dbUser, $this->dbPassword);
		mysqli_select_db($koneksi, $this->dbName) or die("Database anda tidak ada");

		$query = mysqli_query($koneksi, "SELECT profil.nama_depan, profil.nama_belakang, profil.status FROM profil,user WHERE user.username='" . $_SESSION['username'] . "' and user.id_user=profil.id_user");

		while ($ambil = mysqli_fetch_array($query)) {
			echo "
			                     <div class='caption'>
			                      <div class='caption'>
			                        <h4 style='color: #3598DC;'>
			                          " . $ambil[0] . " " . $ambil[1] . " - @" . $_SESSION['username'] . "
			                        </h4>
			                        <br>
			                      </div>
			                      <p>
			                      <blockquote>
			                          " . $ambil[2] . " <cite>Somebody famous</cite>
				          </blockquote>
				          </p>
			                      </div>";
		}
	}
	function tampilsetting()
	{
		$koneksi = mysqli_connect($this->dbHost, $this->dbUser, $this->dbPassword);
		mysqli_select_db($koneksi, $this->dbName) or die("Database anda tidak ada");

		$query = mysqli_query($koneksi, "SELECT profil.nama_depan, profil.nama_belakang, profil.status FROM profil,user WHERE user.username='" . $_SESSION['username'] . "' and user.id_user=profil.id_user");

		while ($ambil = mysqli_fetch_array($query)) {
			echo "
			                    <div class='caption'>
			                      <div class='caption'>
			                      <form action='$_SERVER[PHP_SELF]?page=setting' method='POST' enctype ='multipart/form-data'>
			                      <div class='form-group'>
			                            <label for='judul'>Username</label>
			                            <div class='input-group'>
			                            <span class='input-group-addon' id='basic-addon1'>@</span>
			                            <input type='text' class='form-control' name='username' value='" . $_SESSION['username'] . "'>
			                            </div>
			                          </div>
			                          <div class='form-group'>
			                            <label for='kategori'>Nama Depan</label>
			                            <input type='text' class='form-control' name='nama_depan' value='" . $ambil[0] . "'>
			                          </div>
			                          <div class='form-group'>
			                            <label for='kategori'>Nama Belakang</label>
			                            <input type='text' class='form-control' name='nama_belakang' value='" . $ambil[1] . "'>
			                          </div>
			                          <div class='form-group'>
			                            <label>Caption</label>
			                            <textarea class='form-control' name='status' value='" . $ambil[2] . "'>" . $ambil[2] . "</textarea>
			                          </div>
			                          <div class='form-group'>
			                            <button type='submit' name='ubah' class='btn btn-round btn-outline blue btn-sm'><i class='glyphicon glyphicon-pencil'></i> Ubah Profil</button>
			                          </div>
			                      </form>
			                      </div>
			             </div>";
		}
	}
	function ubahfoto()
	{
		$koneksi = mysqli_connect($this->dbHost, $this->dbUser, $this->dbPassword);
		mysqli_select_db($koneksi, $this->dbName) or die("Database anda tidak ada");

		$query = mysqli_query($koneksi, "SELECT profil.location FROM profil,user WHERE user.username='" . $_SESSION['username'] . "' and user.id_user=profil.id_user and profil.location!=''");
		$cek = mysqli_num_rows($query);
		$ambil = mysqli_fetch_assoc($query);

		if ($cek > 0) {
			echo "<img src='" . $ambil['location'] . "' class='img-responsive' style='width:100%; height:100%;' >
			<p data-toggle='modal' data-target='.bs-example-modal-sm'>
				<a href='#' style='color:#333;'>
				 	<i class='glyphicon glyphicon-pencil' data-toggle='modal' data-target='.bs-example-modal-sm'></i> Ubah Foto Profil
				 </a>
			</p>

			<div class='modal fade bs-example-modal-sm' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
			  <div class='modal-dialog' role='document'>
			    <div class='modal-content'>
			      <div class='modal-header'>
			        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
			        <h3 class='modal-title' id='myModalLabel'>Ubah Foto Profil</h3>
			      </div>
			      <div class='modal-body' align='center'>
			      	<img src='" . $ambil['location'] . "' class='img-circle img-responsive' style='height:30%; width:30%;'>
			      </div>
			      <div class='form-group'>
			        	<form enctype ='multipart/form-data' action='$_SERVER[PHP_SELF]?page=setting' method='POST'>
		                            <label>Pilih Gambar</label>
		                            <input type='file' name='file' style='margin-left:5%;'/>
		                            <p class='help-block'>Max 2MB</p>
		                            <button type='submit' name='upload' class='btn btn-round btn-outline btn-success btn-sm'><i class='glyphicon glyphicon-send'></i> Upload</button>
		                            </form>
		                          </div>
			    </div>
			  </div>
			</div>";

			$query_id = mysqli_query($koneksi, "SELECT id_user FROM user WHERE username='" . $_SESSION['username'] . "'");
			$ambil1 = mysqli_fetch_assoc($query_id);
			$id_user = $ambil1['id_user'];

			if (isset($_POST['upload'])) {
				$allowed_ext  = array('jpg', 'jpeg', 'png', 'gif');
				$file_name    = $_FILES['file']['name'];
				$file_ext   = strtolower(end(explode('.', $file_name)));
				$file_size    = $_FILES['file']['size'];
				$file_tmp   = $_FILES['file']['tmp_name'];

				if (in_array($file_ext, $allowed_ext) === true) {
					$lokasi = 'profil/' . $file_name;
					move_uploaded_file($file_tmp, $lokasi);

					$in = mysqli_query($koneksi, "UPDATE profil SET location='" . $lokasi . "' WHERE id_user='" . $id_user . "'");
					if ($in) {
						echo "<script type='text/javascript'>document.location='index.php?page=setting'</script>";
						unlink($ambil['location']);
					} else {
						echo "<script type='text/javascript'>alert('Gagal Ubah Foto Profil, Coba lagi nanti');document.location='index.php?page=setting'</script>";
					}
				} else {
					echo "<script type='text/javascript'>alert('Ekstensi File tidak didukung');document.location='index.php?page=setting'</script>";
				}
			}
		} else {
			echo "<img src='../gambar/petugas.png' class='img-circle img-responsive' style='width:100%; height:100%;'>
			<p data-toggle='modal' data-target='.bs-example-modal-sm'>
				<a href='#' style='color:#333;'>
				 	<i class='glyphicon glyphicon-pencil' data-toggle='modal' data-target='.bs-example-modal-sm'></i> Ubah Foto Profil
				 </a>
			</p>

			<div class='modal fade bs-example-modal-sm' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
			  <div class='modal-dialog' role='document'>
			    <div class='modal-content'>
			      <div class='modal-header'>
			        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
			        <h3 class='modal-title' id='myModalLabel'>Ubah Foto Profil</h3>
			      </div>
			      <div class='modal-body' align='center'>
			      	<img src='../gambar/petugas.png' class='img-circle img-responsive' style='width:50%; height:50%;'>
			      </div>
			      <div class='form-group'>
			        	<form enctype ='multipart/form-data' action='$_SERVER[PHP_SELF]?page=setting' method='POST'>
		                            <label>Pilih Gambar</label>
		                            <input type='file' name='file' style='margin-left:5%;'/>
		                            <p class='help-block'>Max 2MB</p>
		                            <button type='submit' name='upload' class='btn btn-round btn-outline btn-success btn-sm'><i class='glyphicon glyphicon-send'></i> Upload</button>
		                            </form>
		                          </div>
			    </div>
			  </div>
			</div>";

			$query_id = mysqli_query($koneksi, "SELECT id_user FROM user WHERE username='" . $_SESSION['username'] . "'");
			$ambil = mysqli_fetch_assoc($query_id);
			$id_user = $ambil['id_user'];

			if (isset($_POST['upload'])) {
				$allowed_ext  = array('jpg', 'jpeg', 'png', 'gif');
				$file_name    = $_FILES['file']['name'];
				$file_ext   = strtolower(end(explode('.', $file_name)));
				$file_size    = $_FILES['file']['size'];
				$file_tmp   = $_FILES['file']['tmp_name'];

				$judul = $_POST['judul'];
				$kategori = $_POST['kategori'];
				$caption = $_POST['caption'];

				if (in_array($file_ext, $allowed_ext) === true) {
					$lokasi = 'profil/' . $file_name;
					move_uploaded_file($file_tmp, $lokasi);

					$in = mysqli_query($koneksi, "UPDATE profil SET location='" . $lokasi . "' WHERE id_user='" . $id_user . "'");
					if ($in) {
						echo "<script type='text/javascript'>document.location='index.php?page=setting'</script>";
					} else {
						echo "<script type='text/javascript'>alert('Gagal Ubah Foto Profil, Coba lagi nanti');document.location='index.php?page=setting'</script>";
					}
				} else {
					echo "<script type='text/javascript'>alert('Ekstensi File tidak didukung');document.location='index.php?page=setting'</script>";
				}
			}
		}
	}
	function ubahsetting()
	{
		$koneksi = mysqli_connect($this->dbHost, $this->dbUser, $this->dbPassword);
		mysqli_select_db($koneksi, $this->dbName) or die("Database anda tidak ada");

		$query_id = mysqli_query($koneksi, "SELECT username FROM user");
		$ambil1 = mysqli_fetch_assoc($query_id);
		$username_cek = $ambil1['username'];

		if ($_POST['username'] == $username_cek) {
			echo "<div class='alert alert-danger' role='alert' align='center'><b style='color:#a94442;'><i class='glyphicon glyphicon-remove'></i> Gagal</b> ubah data profil</div>";
		} else {
			$query = mysqli_query($koneksi, "SELECT id_user FROM user WHERE username='" . $_SESSION['username'] . "'");
			$ambil = mysqli_fetch_assoc($query);
			$id_user = $ambil['id_user'];

			$in = mysqli_query($koneksi, "UPDATE profil SET nama_depan='" . $_POST['nama_depan'] . "', nama_belakang='" . $_POST['nama_belakang'] . "', status='" . $_POST['status'] . "'  WHERE id_user='" . $id_user . "'");
			$in1 = mysqli_query($koneksi, "UPDATE user SET username='" . $_POST['username'] . "' WHERE id_user='" . $id_user . "'");

			$_SESSION['username'] = $_POST['username'];
			echo "<div class='alert alert-success' role='alert' align='center'><b style='color:#3c763d;'><i class='glyphicon glyphicon-check'></i> Sukses</b> Berhasil ubah data profil</div>
			<a href='index.php?page=profil' class='btn-block alert alert-warning' style='text-align:center; margin-top:-4%;'><i class='glyphicon glyphicon-user'></i> Cek Profilmu</a>";
		}
	}
	function tambahkategori()
	{
		$koneksi = mysqli_connect($this->dbHost, $this->dbUser, $this->dbPassword);
		mysqli_select_db($koneksi, $this->dbName) or die("Database anda tidak ada");

		echo "<div class='caption'>
		                      <div class='caption'>
		                      <form action='$_SERVER[PHP_SELF]?page=tambah_kategori' method='POST' enctype ='multipart/form-data'>
		                      <div class='form-group'>
		                            <label for='kategori'>Kategori</label>
		                            <input type='text' class='form-control' name='kategori'>
		                          </div>
		                          <div class='form-group' align='center'>
		                            <button type='submit' name='tambah' class='btn btn-round btn-outline blue btn-sm'><i class='glyphicon glyphicon-plus'></i> Tambah Kategori</button>
		                          </div>
		                      </form>
		                      </div>
		             </div>";

		if (isset($_POST['tambah'])) {
			$in = mysqli_query($koneksi, "INSERT INTO kategori (nama_kategori) VALUES ('" . $_POST['kategori'] . "')");
			if ($in) {
				echo "<div class='alert alert-success' role='alert' align='center'><b style='color:#3c763d;'>Sukses</b> Berhasil menambahkan kategori</div>";
			}
		}
	}
	function komentar($id)
	{
		$koneksi = mysqli_connect($this->dbHost, $this->dbUser, $this->dbPassword);
		mysqli_select_db($koneksi, $this->dbName) or die("Database anda tidak ada");

		$query = mysqli_query($koneksi, "SELECT profil.location,upload.judul_post, upload.keterangan,upload.location, upload.id_post, upload.tag FROM profil,upload WHERE upload.id_user=profil.id_user and id_post=" . $id . "");
		$cek = mysqli_num_rows($query);

		if ($cek) {
			while ($data = mysqli_fetch_array($query)) {
				// $tambah=$data['lihat']+1;
				// $query_view=mysqli_query($koneksi,"UPDATE upload SET lihat='".$tambah."' WHERE id_post='".$data['id_post']."'");
				echo "<div class='col-sm-4 col-lg-4 col-md-4 img-responsive'>
				                  <div class='thumbnail btn-round'>
				                     <div class='caption'>
				                     <div class='pull-right social-action dropdown'>
					                <button class='dropdown-toggle btn white' data-toggle='dropdown'> <i class='glyphicon glyphicon-cog'></i> </button>
					                <ul class='dropdown-menu m-t-xs'>
					                  <li><a href='index.php?page=edit&id=" . $data['id_post'] . "' style='color:#333;'>Edit</a></li>
					                  <li><a href='index.php?page=hapus&id=" . $data['id_post'] . "' style='color:#333;'>Hapus</a></li>
					                </ul>
					              </div>
				                      <a href='#' style='text-decoration: none;' >";
				if ($data[0] == "") {

					echo "<img src='../gambar/petugas.jpg' class='img-circle img-responsive' style='width: 10%; height: 10%; float: left;'>";
				} else {
					echo "<img src='" . $data[0] . "' class='img-circle img-responsive' style='width: 10%; height: 10%; float: left;'>";
				}
				echo "<h4 style='color: #337ab7; padding: 2%;'>
				                           &nbsp " . $_SESSION['username'] . "
				                        </h4>
				                      </a>
				                      <br>
				                    </div>
				                    <img src='" . $data['location'] . "' class='img-responsive'>
				                      <div class='caption'>
				                        <h4 style='color: #3598DC;'>
				                          " . $data[1] . "
				                        </h4>
				                        <br>
				                        <p>" . $data[2] . "</p>";
				if ($data['tag'] != '') {
					$ambil_tag = explode("#", $data['tag']);
					echo "<p>";
					foreach ($ambil_tag as $value) {
						if ($value == $ambil_tag[0]) {
							continue;
						} else {
							echo "<a href='index.php?page=tag&tag=" . $value . "'> #" . $value . " </a>";
						}
					}
				}
				$komentar_lihat = mysqli_query($koneksi, "SELECT komentar.komentar, user.username,komentar.id_komentar FROM komentar,user,upload WHERE komentar.id_user=user.id_user and  upload.id_post=" . $id . "");
				echo "<div class='caption'>";
				while ($ambil_komentar = mysqli_fetch_array($komentar_lihat)) {

					echo "<h4 style='color: #3598DC;'>
					                          " . $ambil_komentar[1] . "
					                        </h4>";
					if ($ambil_komentar[1] == $_SESSION['username']) {
						echo "
					                        	<div class='pull-right social-action dropdown' style='margin-top:-5%;'>
						                <button class='dropdown-toggle btn white' data-toggle='dropdown'> <i class='glyphicon glyphicon-pencil'></i> </button>
						                <ul class='dropdown-menu m-t-xs'>
						                  <li><a href='index.php?page=editkomen&id_komentar=" . $ambil_komentar[2] . "&id_post=" . $id . "' style='color:#333;'>Edit</a></li>
						                  <li><a href='index.php?page=hapuskomen&id_komentar=" . $ambil_komentar[2] . "&id_post=" . $id . "' style='color:#333;'>Hapus</a></li>
						                </ul>
						              </div>
					                        	<p>
					                        	" . $ambil_komentar[0] . "
					                        	</p>";
					} else {
						echo "<p>
					                        	" . $ambil_komentar[0] . "
					                        	</p>";
					}
				}
				echo "
				                      </div>
				                      <div class='feed-activity-list'>
			                                    <div class='feed-element'>
			                                      <div class='media-body '>
			                                      <form action='komen.php' method='POST'>
			                                          <input type='hidden' name='id_posting' value='" . $id . "'>
			                                          <textarea class='form-control' placeholder='Berikan komentar...' name='komen'></textarea>

			                                          <div class='actions'>
			                                          <div class='actions pull-right' style='margin-top: -0.1%;'>
			                                          <button class='btn btn-sm btn-round btn-outline btn-success' type='submit' name='kirim'><i class='glyphicon glyphicon-send'></i> Komentar</button>
			                                          </form>
			                                          </div>
			                                          </div>
			                                      </div>
			                                    </div>
			                                  </div>
				                      </div>
				                  </div>
				                </div>";
			}
		}
	}
	function editkomentar($id, $id_komentar)
	{
		$koneksi = mysqli_connect($this->dbHost, $this->dbUser, $this->dbPassword);
		mysqli_select_db($koneksi, $this->dbName) or die("Database anda tidak ada");

		$query = mysqli_query($koneksi, "SELECT profil.location,upload.judul_post, upload.keterangan,upload.location, upload.id_post, upload.tag FROM profil,upload WHERE upload.id_user=profil.id_user and upload.id_post=" . $id . "");
		$cek = mysqli_num_rows($query);

		if ($cek) {
			while ($data = mysqli_fetch_array($query)) {
				// $tambah=$data['lihat']+1;
				// $query_view=mysqli_query($koneksi,"UPDATE upload SET lihat='".$tambah."' WHERE id_post='".$data['id_post']."'");
				echo "<div class='col-sm-4 col-lg-4 col-md-4 img-responsive'>
				                  <div class='thumbnail btn-round'>
				                     <div class='caption'>
				                     <div class='pull-right social-action dropdown'>
					                <button class='dropdown-toggle btn white' data-toggle='dropdown'> <i class='glyphicon glyphicon-cog'></i> </button>
					                <ul class='dropdown-menu m-t-xs'>
					                  <li><a href='index.php?page=edit&id=" . $data['id_post'] . "' style='color:#333;'>Edit</a></li>
					                  <li><a href='index.php?page=hapus&id=" . $data['id_post'] . "' style='color:#333;'>Hapus</a></li>
					                </ul>
					              </div>
				                      <a href='#' style='text-decoration: none;' >";
				if ($data[0] == "") {

					echo "<img src='../gambar/petugas.jpg' class='img-circle img-responsive' style='width: 10%; height: 10%; float: left;'>";
				} else {
					echo "<img src='" . $data[0] . "' class='img-circle img-responsive' style='width: 10%; height: 10%; float: left;'>";
				}
				echo "<h4 style='color: #337ab7; padding: 2%;'>
				                           &nbsp " . $_SESSION['username'] . "
				                        </h4>
				                      </a>
				                      <br>
				                    </div>
				                    <img src='" . $data['location'] . "' class='img-responsive'>
				                      <div class='caption'>
				                        <h4 style='color: #3598DC;'>
				                          " . $data[1] . "
				                        </h4>
				                        <br>
				                        <p>" . $data[2] . "</p>";
				if ($data['tag'] != '') {
					$ambil_tag = explode("#", $data['tag']);
					echo "<p>";
					foreach ($ambil_tag as $value) {
						if ($value == $ambil_tag[0]) {
							continue;
						} else {
							echo "<a href='index.php?page=tag&tag=" . $value . "'> #" . $value . " </a>";
						}
					}
				}
				$komentar_lihat = mysqli_query($koneksi, "SELECT komentar.komentar FROM komentar,user,upload WHERE komentar.id_user=user.id_user and user.id_user=upload.id_user and komentar.id_user=upload.id_user and upload.id_post=" . $id . " and komentar.id_komentar=" . $_GET['id_komentar'] . " ");
				$ambil_komentar = mysqli_fetch_array($komentar_lihat);

				echo " <div class='feed-activity-list'>
					                                    <div class='feed-element'>
					                                      <div class='media-body '>
					                                      <form action='komen.php' method='POST'>
					                                          <input type='hidden' name='id_posting' value='" . $id . "'>
					                                          <input type='hidden' name='id_komen' value='" . $id_komentar . "'>
					                                          <textarea class='form-control' name='komen' value='" . $ambil_komentar[0] . "'>" . $ambil_komentar[0] . "</textarea>
					                                          <div class='actions'>
					                                          <div class='actions pull-right' style='margin-top: -0.1%;'>
					                                          <button class='btn btn-sm btn-round btn-outline btn-success' type='submit' name='edit'><i class='glyphicon glyphicon-send'></i> Komentar</button>
					                                          </form>
					                                          </div>
					                                          </div>
					                                      </div>";

				echo "
			                                    </div>
			                                  </div>
				                      </div>
				                  </div>
				                </div>";
			}
		}
	}
	function tampiledit()
	{
		$koneksi = mysqli_connect($this->dbHost, $this->dbUser, $this->dbPassword);
		mysqli_select_db($koneksi, $this->dbName) or die("Database anda tidak ada");

		$query = mysqli_query($koneksi, "SELECT * FROM upload WHERE id_post='" . $_GET['id'] . "'");
		$query1 = mysqli_query($koneksi, "SELECT kategori.nama_kategori FROM upload,kategori WHERE upload.id_post='" . $_GET['id'] . "'
			and upload.id_kategori=kategori.id_kategori");
		$kategori = mysqli_fetch_array($query1);
		while ($ambil = mysqli_fetch_array($query)) {
			echo "
			                    <div class='caption'>
			                      <div class='caption'>
			                      <form action='$_SERVER[PHP_SELF]?page=edit&id=" . $ambil[0] . "' method='POST' enctype ='multipart/form-data'>
				             <div class='form-group'>
			                            <label for='judul'>Judul Post</label>
			                            <input type='text' class='form-control' name='judul' value='" . $ambil[1] . "'>
			                          </div>
			                          <div class='form-group'>
			                            <label for='kategori'>Kategori</label>
			                            <select name='kategori' class='form-control'>
			                            <option value='" . $ambil[2] . "'>- " . $kategori[0] . " -</option>
			                            	";
			echo $this->kategorimodal();
			echo "</select>
			                          </div>
			                          <div class='form-group'>
			                            <label for='caption'>Caption</label>
			                            <textarea class='form-control' name='caption' value='" . $ambil[3] . "'>" . $ambil[3] . "</textarea>
			                          </div>
			                          <div class='form-group'>
			                            <label>Tag</label>
			                            <textarea class='form-control' name='tag' value='" . $ambil[4] . "'>" . $ambil[4] . "</textarea>
			                          </div>
			                          <div class='form-group'>
			                            <button type='submit' name='ubah' class='btn btn-round btn-outline blue btn-sm'><i class='glyphicon glyphicon-pencil'></i> Edit Posting</button>
			                          </div>
			                      </form>
			                      </div>
			             </div>";
		}
	}
	function editpost()
	{
		$koneksi = mysqli_connect($this->dbHost, $this->dbUser, $this->dbPassword);
		mysqli_select_db($koneksi, $this->dbName) or die("Database anda tidak ada");

		$in = mysqli_query($koneksi, "UPDATE upload SET judul_post='" . $_POST['judul'] . "', id_kategori='" . $_POST['kategori'] . "', keterangan='" . $_POST['caption'] . "', tag='" . $_POST['tag'] . "'  WHERE id_post='" . $_GET['id'] . "'");
		if ($in) {
			echo "SUKSES";
		}
	}
	function fotopost()
	{
		$koneksi = mysqli_connect($this->dbHost, $this->dbUser, $this->dbPassword);
		mysqli_select_db($koneksi, $this->dbName) or die("Database anda tidak ada");

		$query = mysqli_query($koneksi, "SELECT location FROM upload WHERE id_post=" . $_GET['id'] . "");
		$ambil = mysqli_fetch_assoc($query);

		echo "<img src='" . $ambil['location'] . "' class='img-responsive' style='width:100%; height:100%;' >
			<p data-toggle='modal' data-target='.bs-example-modal-sm'>
				<a href='#' style='color:#333;'>
				 	<i class='glyphicon glyphicon-pencil' data-toggle='modal' data-target='.bs-example-modal-sm'></i> Ubah Foto Posting
				 </a>
			</p>

			<div class='modal fade bs-example-modal-sm' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
			  <div class='modal-dialog' role='document'>
			    <div class='modal-content'>
			      <div class='modal-header'>
			        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
			        <h3 class='modal-title' id='myModalLabel'>Ubah Foto Posting</h3>
			      </div>
			      <div class='modal-body' align='center'>
			      	<img src='" . $ambil['location'] . "' class='img-circle img-responsive' style='height:30%; width:30%;'>
			      </div>
			      <div class='form-group'>
			        	<form enctype ='multipart/form-data' action='$_SERVER[PHP_SELF]?page=edit&id=" . $_GET['id'] . "' method='POST'>
		                            <label>Pilih Gambar</label>
		                            <input type='file' name='file' style='margin-left:5%;'/>
		                            <p class='help-block'>Max 2MB</p>
		                            <button type='submit' name='upload' class='btn btn-round btn-outline btn-success btn-sm'><i class='glyphicon glyphicon-send'></i> Upload</button>
		                            </form>
		                          </div>
			    </div>
			  </div>
			</div>";

		if (isset($_POST['upload'])) {
			$allowed_ext  = array('jpg', 'jpeg', 'png', 'gif');
			$file_name    = $_FILES['file']['name'];
			$file_ext   = strtolower(end(explode('.', $file_name)));
			$file_size    = $_FILES['file']['size'];
			$file_tmp   = $_FILES['file']['tmp_name'];

			if (in_array($file_ext, $allowed_ext) === true) {
				$lokasi = 'profil/' . $file_name;
				move_uploaded_file($file_tmp, $lokasi);

				$in = mysqli_query($koneksi, "UPDATE upload SET location='" . $lokasi . "' WHERE id_post='" . $_GET['id'] . "'");
				if ($in) {
					echo "<script type='text/javascript'>document.location='index.php?page=edit&id=" . $_GET['id'] . "'</script>";
					unlink($ambil['location']);
				} else {
					echo "<script type='text/javascript'>alert('Gagal Ubah Foto Profil, Coba lagi nanti');document.location='index.php?page=edit&id=" . $_GET['id'] . "'</script>";
				}
			} else {
				echo "<script type='text/javascript'>alert('Ekstensi File tidak didukung');document.location='index.php?page=edit&id=" . $_GET['id'] . "'</script>";
			}
		}
	}
	function hapuspost()
	{
		$koneksi = mysqli_connect($this->dbHost, $this->dbUser, $this->dbPassword);
		mysqli_select_db($koneksi, $this->dbName) or die("Database anda tidak ada");

		$query = "SELECT * FROM upload WHERE id_post = " . $_GET['id'];
		$hsl = mysqli_query($koneksi, $query) or die(mysql_error());
		$isi = mysqli_fetch_assoc($hsl);
		$num = mysqli_num_rows($hsl);
		$in = mysqli_query($koneksi, "DELETE FROM upload  WHERE id_post='" . $_GET['id'] . "'");

		if ($hsl) {
			unlink("$isi[location]");
			echo "<script type='text/javascript'>history.go(-1)</script>";
		}
	}
	function hapuskomen()
	{
		$koneksi = mysqli_connect($this->dbHost, $this->dbUser, $this->dbPassword);
		mysqli_select_db($koneksi, $this->dbName) or die("Database anda tidak ada");

		$in = mysqli_query($koneksi, "DELETE FROM komentar  WHERE id_komentar='" . $_GET['id_komentar'] . "' and id_post='" . $_GET['id_post'] . "'");
		echo "<script type='text/javascript'>history.go(-1)</script>";
	}
}

?>