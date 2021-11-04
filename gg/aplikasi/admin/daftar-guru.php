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

$ambil_data_guru = mysqli_query($koneksi_database, "SELECT guru.id_guru, guru.nama_guru, kelas.nama_kelas FROM guru INNER JOIN kelas ON kelas.id_kelas = guru.id_kelas ");

?>

<!DOCTYPE html>
<html lang="en">
<?php require "../template/head.html"; ?>
<body>
<nav>
<a class="kembali" href="../admin"><i class="fas fa-chevron-left"></i> Kembali</a>
<a class="unggah" href="tambah-guru.php?
		id-jenis-pelajaran=">Tambah Guru <i class="fas fa-plus"></i></a></nav><br><br><br>
<table align="center">
<tr>
			<td class="head-table" colspan="6" align="center">daftar guru</td>
		</tr>

	<table align="center">
		<tr class="tatabel">
			<th>id guru</th>
			<th>nama guru</th>
			<th>wali kelas</th>
			<th colspan="2">aksi</th>
		</tr>
		<?php while($data_guru = mysqli_fetch_assoc($ambil_data_guru)) : ?>
			<tr class="table-mapel" align="center" >
				<td width="200"><?php echo $data_guru["id_guru"]; ?></td>
				<td><?php echo $data_guru["nama_guru"]; ?></td>
				<td><?php echo $data_guru["nama_kelas"]; ?></td>
				<td class="btn-lewat" ><a href="hapus.php?id=<?php echo $data_guru['id_guru']; ?>">HAPUS</a></td>
			</tr>
		<?php endwhile; ?>
	</table>
	
</body>
</html>