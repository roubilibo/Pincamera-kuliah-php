<?php
include '../fungsi_php.php';
$fungsi=new fungsi_php();

$koneksi=mysqli_connect($fungsi->dbHost, $fungsi->dbUser, $fungsi->dbPassword);
mysqli_select_db($koneksi,$fungsi->dbName) or die("Database anda tidak ada");

$query_id=mysqli_query($koneksi,"SELECT id_user FROM user WHERE username='".$_SESSION['username']."'");
$ambil=mysqli_fetch_assoc($query_id);
$id_user=$ambil['id_user'];

if (isset($_POST['kirim']))
{
	$query=mysqli_query($koneksi,"INSERT INTO komentar VALUES ('','".$id_user."','".$_POST['id_posting']."','".$_POST['komen']."') ");
	if ($query)
	{
		header("location:index.php?page=komentar&id_post=".$_POST['id_posting']."");
	}
	else
	{
		echo "GAGAL";
	}
}
elseif(isset($_POST['edit']))
{
	$query=mysqli_query($koneksi,"UPDATE komentar SET komentar='".$_POST['komen']."' WHERE id_post='".$_POST['id_posting']."' and id_komentar='".$_POST['id_komen']."'");
	if ($query)
	{
		header("location:index.php?page=komentar&id_post=".$_POST['id_posting']."");
	}
	else
	{
		echo "GAGAL";
	}
}

?>