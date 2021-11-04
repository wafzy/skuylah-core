<?php

session_start();

if(!isset($_SESSION["login"])) {
	header("location: ../masuk.php");
}

if($_SESSION["peran"] == "guru") {
	header("location: ../guru");
} elseif($_SESSION["peran"] == "siswa") {
	header("location: ../siswa");
}

require "../koneksi-database.php";

$ambil_data_kelas = mysqli_query($koneksi_database, "SELECT * FROM kelas");

?>

<!DOCTYPE html>
<html lang="en">
<?php require "../template/head.html"; ?>
<body>
<a class="kembali" href="../admin"><i class="fas fa-chevron-left"></i> Kembali</a>
<a class="unggah" href="tambah-kelas.php?
		id-jenis-pelajaran=">Tambah Kelas <i class="fas fa-plus"></i></a></nav><br><br><br>
<table align="center">
<tr>
			<td class="head-table" colspan="6" align="center">daftar kelas</td>
		</tr>	

	<table align="center">
		<tr class="tatabel">
			<th>nama kelas</th>
		</tr>
		<?php while($data_kelas = mysqli_fetch_assoc($ambil_data_kelas)) : ?>
			<tr class="table-mapel" align="center" >
				<td><?php echo $data_kelas["nama_kelas"]; ?></td>
			</tr>
		<?php endwhile; ?>
	</table>
	
</body>
</html>