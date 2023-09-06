<?php
include '../fungsi_php.php';
$fungsi=new fungsi_php();
if(isset($_POST['upload']))
{
	$fungsi->uploadgaleri();
}
?>