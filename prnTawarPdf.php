<?php
require_once __DIR__ . '/vendor/autoload.php';
require "fungsi.php";

$mpdf = new \Mpdf\Mpdf();

// Write some HTML code:

$mpdf->WriteHTML('
	<!DOCTYPE html>
	<html>
	<head>
	    <title>Sistem Informasi Akademik::Daftar Mahasiswa</title>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="css/stylepdf.css">
	</head>
	<body>
	<h1>Daftar Penawaran Mata Kuliah<br>
	<sub>Sistem Informasi - Fakultas Ilmu Komputer - Universitas Dian Nuswantoro<sub><br>
	<small>Tahun Akademik 2020-2021</small></h1>
	<table>	
	<tr>
       <th>No.</th>
       <th>Mata Kuliah</th>
       <th>Dosen</th>
       <th>Kelompok</th>
       <th>Hari</th>
       <th>Jam</th>
       <th>Ruang</th>
	</tr>
	');
$sql="select * from matkul as m, dosen as d, kultawar as k 
             where k.idmatkul=m.idmatkul and k.npp = d.npp
              order by m.namamatkul asc, d.namadosen asc";		
$qry = mysqli_query($koneksi,$sql) or die(mysqli_error($koneksi));
$no=0;
while($row=mysqli_fetch_assoc($qry)){
	$no++;
	$mpdf->WriteHTML('
	<tr>
		<td>'.$no.'</td>
		<td>'.$row["namamatkul"].'</td>
		<td>'.$row["namadosen"].'</td>
        <td>'.$row["klp"].'</td>
        <td>'.$row["hari"].'</td>
        <td>'.$row["jamkul"].'</td>	
        <td>'.$row["ruang"].'</td>					
	</tr>
	');
}
$mpdf->WriteHTML('</table>');
$mpdf->WriteHTML('</body></html>');
// Output a PDF file directly to the browser
$mpdf->Output("Data_KRS.pdf","I");