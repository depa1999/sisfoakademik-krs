<?php
require "fungsi.php";
$idkultawar=$_POST['idkultawar'];
$idmatkul=$_POST['idmatkul'];
$npp=$_POST['npp'];
$klp=$_POST['klp'];
$hari=$_POST['hari'];
$jamkul=$_POST['jamkul'];
$ruang=$_POST['ruang'];
$kapasitas=$_POST['kapasitas'];

$sql="update kultawar set idmatkul = '$idmatkul',
						  npp      = '$npp',
						  klp      = '$klp',
						  hari     = '$hari',
						  jamkul   = '$jamkul',
						  ruang    = '$ruang',
						  kapasitas = '$kapasitas'
						  where  idkultawar='$idkultawar'";
mysqli_query($koneksi,$sql) or die(mysqli_error($koneksi));
header("location:updateTawar.php");
?>