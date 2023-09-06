<?php
class database
{
	protected $dbHost='localhost';
	protected $dbUser='root';
	protected $dbPassword='';
	protected $dbName='pincamera';
	protected $koneksi;
	
	public function __construct()
	{
		$koneksi=mysqli_connect($this->dbHost, $this->dbUser, $this->dbPassword);
		mysqli_select_db($koneksi,$this->dbName) or die("Database anda tidak ada");
	}
}
?>