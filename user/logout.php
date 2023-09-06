<?php
session_start();
if($_REQUEST['maukeluar']="iya")
{
	if(isset($_SESSION['username']))
	{
		unset($_SESSION['username']);
		header("location:../");
	}
}
else {
	# code...
}

?>