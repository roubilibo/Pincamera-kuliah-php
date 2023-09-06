<?php 
include '../fungsi_php.php';
if(isset($_SESSION['username']))
{
	if(isset($_GET['page']))
	{
		if($_GET['page']=='home')
		{
			require "home.php";
		}
		elseif ($_GET['page']=='profil') 
		{
			require "profil.php";
		}
		elseif ($_GET['page']=='koleksi') 
		{
			require "koleksi.php";
		}
		elseif ($_GET['page']=='setting') 
		{
			require "setting.php";
		}
		elseif ($_GET['page']=='tambah_kategori') 
		{
			require "tambah_kategori.php";
		}
		elseif ($_GET['page']=='komentar') 
		{
			require "komentar.php";
		}
		elseif ($_GET['page']=='lihatuser') 
		{
			require "lihatuser.php";
		}
		elseif ($_GET['page']=='hasil') 
		{
			require "hasil.php";
		}
		elseif ($_GET['page']=='tag') 
		{
			require "tag.php";
		}
		elseif ($_GET['page']=='edit') 
		{
			require "edit.php";
		}
		elseif ($_GET['page']=='hapus') 
		{
			require "hapus.php";
		}
		elseif ($_GET['page']=='editkomen') 
		{
			require "editkomen.php";
		}
		elseif ($_GET['page']=='hapuskomen') 
		{
			require "hapuskomen.php";
		}
	}
	else
	{
		header("location:index.php?page=home&status=ok");
	}
}
else
{
	?>
	<script type="text/javascript">
		alert("Harap Login dahulu");
		document.location="../index.html";
	</script>
	<?php
}
?>

