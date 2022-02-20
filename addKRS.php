<!DOCTYPE html>
<html>
<head>
    <title>A12.2018.05960-Depata Siwa Prasetya</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="bootstrap4/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/styleku.css">
	<script src="bootstrap4/jquery/3.3.1/jquery-3.3.1.js"></script>
	<script src="bootstrap4/js/bootstrap.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
</head>
<body>
<?php
	//memanggil file berisi fungsi2 yang sering dipakai
	require "fungsi.php";
	require "head.html";

	/*	---- cetak data per halaman ---------	*/

	//--------- konfigurasi

	//jumlah data per halaman
	$jmlDataPerHal = 3;

	//cari jumlah data
	if (isset($_POST['cari'])){
		$cari=$_POST['cari'];
    	$sql="select * from matkul as m, dosen as d, kultawar as k where 
                         k.idmatkul=m.idmatkul and k.npp = d.npp 
                         having 
                         namamatkul like'%$cari%' or 
                         namadosen like '%$cari%' 
                         order by m.namamatkul asc, d.namadosen asc";
	}else{
    	$sql="select * from matkul as m, dosen as d, kultawar as k where 
                         k.idmatkul=m.idmatkul and k.npp = d.npp
				         order by m.namamatkul asc, d.namadosen asc";				
	}
	$qry = mysqli_query($koneksi,$sql) or die(mysqli_error($koneksi));
	$jmlData = mysqli_num_rows($qry);

	$jmlHal = ceil($jmlData / $jmlDataPerHal);
	if (isset($_GET['hal'])){
		$halAktif=$_GET['hal'];
	}else{
		$halAktif=1;
	}

	$awalData=($jmlDataPerHal * $halAktif)-$jmlDataPerHal;

	//Jika tabel data kosong
	$kosong=false;
	if (!$jmlData){
		$kosong=true;
	}
	//data berdasar pencarian atau tidak
	if (isset($_POST['cari'])){
		$cari=$_POST['cari'];
		$sql=" select * from matkul as m, dosen as d, kultawar as k where 
                           k.idmatkul=m.idmatkul and k.npp = d.npp 
                           having 
                           namamatkul like'%$cari%' or 
                           namadosen like '%$cari%' 
                           order by m.namamatkul asc, d.namadosen asc
                           limit $awalData,$jmlDataPerHal";
	}else{
		$sql="select * from matkul as m, dosen as d, kultawar as k where 
                          k.idmatkul=m.idmatkul and k.npp = d.npp
                          order by m.namamatkul asc, d.namadosen asc 
                          limit $awalData,$jmlDataPerHal";		
	}
	//Ambil data untuk ditampilkan
	$hasil=mysqli_query($koneksi,$sql) or die(mysqli_error($koneksi));
?>
	<div class="utama">			
		<br><br>
		<h2 class="text-center">INPUT KRS </h2>
		<br>
		<div class="alert alert-success alert-dismissible" id="success" style="display:none;">
	  		<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
		</div>
		<form id="faddTawar">			
			<div class="form-group">
				<label for="thAkdm">Tahun Akademik: </label>
				<select class="form-control" name="thAkdm" id="thAkdm">
					<?php
					$thAkdm=array('Gasal 2020/2021','Genap 2020/2021');
					for($i=0;$i<count($thAkdm);$i++){
						echo "<option value=$thAkdm[$i]>$thAkdm[$i]";
					}
					?>					
				</select>
			</div>
			<div class="form-group">
				<label for="nim">NIM:</label>
				<select class="form-control" name="nim" id="nim">
				<?php
				$sql="select nim, nim from mhs order by nim";
				$qry=mysqli_query($koneksi,$sql);
				while($hsl=mysqli_fetch_row($qry)){
					echo "<option value='".$hsl[0]."'>".$hsl[1];
				}
				?> 
				</select>
			</div>	
				
			</div>
		</form>
	</div>

<div class="utama">
	<i><h5 class="text-left" style="margin-top: 2cm; color: grey">*Pilih mata kuliah yang ingin diambil </h5></i>
	<span class="float-right">
		
	</span>
	<br>
	<ul class="pagination">
		<?php
		//navigasi pagination
		//cetak navigasi back
		if ($halAktif>1){
			$back=$halAktif-1;
			echo "<li class='page-item'><a class='page-link' href=?hal=$back>&laquo;</a></li>";
		}
		//cetak angka halaman
		for($i=1;$i<=$jmlHal;$i++){
			if ($i==$halAktif){
				echo "<li class='page-item'><a class='page-link' href=?hal=$i style='font-weight:bold;color:red;'>$i</a></li>";
			}else{
				echo "<li class='page-item'><a class='page-link' href=?hal=$i>$i</a></li>";
			}	
		}
		//cetak navigasi forward
		if ($halAktif<$jmlHal){
			$forward=$halAktif+1;
			echo "<li class='page-item'><a class='page-link' href=?hal=$forward>&raquo;</a></li>";
		}
		?>
	</ul>	
	<!-- Cetak data dengan tampilan tabel -->
	<table class="table table-hover">
	<thead class="thead-light">
      <tr>
		<th>Pilih</th>
		<th>Mata Kuliah</th>
		<th>Kelompok</th>
		<th>Hari</th>
		<th>Jam</th>
		<th>Ruang</th>
		<th>Jumlah Mahasiswa</th>
	</thead>
	<tbody>
	<?php
		//jika data tidak ada
		if ($kosong){
	?>
	<tr><th colspan="6">
	<div class="alert alert-info alert-dismissible fade show text-center">
		<!--<button type="button" class="close" data-dismiss="alert">&times;</button>-->
		Data tidak ada
	</div>
	</th></tr>
	<?php
		}else{	
			if($awalData==0){
				$no=$awalData+1;
			}else{
				$no=$awalData;
			}
		while($row=mysqli_fetch_assoc($hasil)){
	?>	
	<tr>
		<td><input type="checkbox" name="coba"></td>
		<td><?php echo $row["namamatkul"]?></td>
		<td><?php echo $row["klp"]?></td>
		<td><?php echo $row["hari"]?></td>
		<td><?php echo $row["jamkul"]?></td>
		<td><?php echo $row["ruang"]?></td>
		<td><?php echo $no?></td>
	</tr>
	<?php 
		$no++;
		}
		}
	?>
	</tbody>
	</table>
</div>
</body>
</html>	