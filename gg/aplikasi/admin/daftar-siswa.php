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

$ambil_data_siswa = mysqli_query($koneksi_database, "SELECT siswa.id_siswa, siswa.nama_siswa, kelas.nama_kelas FROM siswa INNER JOIN kelas ON kelas.id_kelas = siswa.id_kelas ");

?>

<!DOCTYPE html>
<html lang="en">
<?php require "../template/head.html"; ?>
<body>
<nav>
<a class="kembali" href="../admin"><i class="fas fa-chevron-left"></i> Kembali</a>
<a class="unggah" href="tambah-kelas.php?
		id-jenis-pelajaran=">Tambah Siswa <i class="fas fa-plus"></i></a></nav><br><br><br>
<table align="center">
<tr>
			<td class="head-table" colspan="6" align="center">daftar siswa</td>
		</tr>

	<table align="center">
		<tr class="tatabel">
			<th>id siswa</th>
			<th>nama siswa</th>
			<th>kelas</th>
		</tr>
		<?php while($data_siswa = mysqli_fetch_assoc($ambil_data_siswa)) : ?>
			<tr class="table-mapel" align="center" >
				<td><?php echo $data_siswa["id_siswa"]; ?></td>
				<td><?php echo $data_siswa["nama_siswa"]; ?></td>
				<td><?php echo $data_siswa["nama_kelas"]; ?></td>
			</tr>
		<?php endwhile; ?>
	</table>
	
</body>
</html>