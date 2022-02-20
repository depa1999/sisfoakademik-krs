<?php
//memanggil file pustaka fungsi
require "fungsi.php";

//memindahkan data kiriman dari form ke var biasa
$idKrs=$_POST["idKrs"];
$thAkdm=$_POST["thAkdm"];
$nim=$_POST["nim"];
$idkultawar=$_POST["idkultawar"];
$jmlMhs=$_POST["jmlMhs"];

// simpan data
$sql="insert krs values('','$idKrs','$thAkdm','$nim')";
$sql1="insert detail_krs values('','$idKrs,$idkultawar')";
$sql2="insert dummy values('','$idkultawar','$jmlMhs')";

mysqli_query($koneksi,$sql);
mysqli_query($koneksi,$sql1);
mysqli_query($koneksi,$sq2);

echo "Data telah tersimpan";
//header("location:addMatkul.php");
?>