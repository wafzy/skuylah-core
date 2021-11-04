<?php

session_start();

if(!isset($_SESSION["login"])) {
	header("location: ../masuk.php");
}

if($_SESSION["peran"] == "admin") {
	header("location: ../admin");
} elseif($_SESSION["peran"] == "siswa") {
	header("location: ../siswa");
}

$id_guru = $_SESSION["id_guru"];

require "../koneksi-database.php";

$ambil_data_guru = mysqli_query($koneksi_database, "SELECT * FROM guru WHERE id_guru='$id_guru' ");
$data_guru = mysqli_fetch_assoc($ambil_data_guru);
// var_dump($data_guru);

$id_guru = $data_guru["id"];

$id_kelas = $_GET["id-kelas"];
$id_jenis_pelajaran = $_GET["id-jenis-pelajaran"];
$id_mata_pelajaran = $_GET["id-mata-pelajaran"];

// var_dump($id_guru, $id_kelas, $id_jenis_pelajaran);

$kueri_data_pelajaran = "
	SELECT
		id_pelajaran,
		tanggal,
		pelajaran
	FROM pelajaran
	WHERE
	id_kelas = '$id_kelas' AND
	id_jenis_pelajaran = '$id_jenis_pelajaran' AND
	id_guru = '$id_guru'
	ORDER BY tanggal DESC
";

$ambil_data_pelajaran = mysqli_query($koneksi_database, $kueri_data_pelajaran);
// var_dump($ambil_data_pelajaran);

$ambil_data_kelas = mysqli_query($koneksi_database, "SELECT nama_kelas FROM kelas WHERE id_kelas='$id_kelas' ");
$data_kelas = mysqli_fetch_assoc($ambil_data_kelas);

$ambil_data_jenis_pelajaran = mysqli_query($koneksi_database, "SELECT * FROM jenis_pelajaran WHERE id_jenis_pelajaran='$id_jenis_pelajaran' ");
$data_jenis_pelajaran = mysqli_fetch_assoc($ambil_data_jenis_pelajaran);

$ambil_data_mata_pelajaran = mysqli_query($koneksi_database, "SELECT * FROM mata_pelajaran WHERE id_mata_pelajaran='$id_mata_pelajaran' ");
$data_mata_pelajaran = mysqli_fetch_assoc($ambil_data_mata_pelajaran);



?>
<!DOCTYPE html>
<html lang="en">
<?php require "../template/head.html"; ?>
<body>
<nav>
<a class="kembali" href="../guru/jadwal-mengajar.php?id-mata-pelajaran=<?php echo $id_mata_pelajaran; ?>"><i class="fas fa-chevron-left"></i> kembali</a>
<a class="unggah" href="unggah.php?
		id-jenis-pelajaran=<?php echo $id_jenis_pelajaran; ?>&&id-kelas=<?php echo $id_kelas; ?>&&id-mata-pelajaran=<?php echo $id_mata_pelajaran; ?>">unggah <i class="fas fa-cloud-upload-alt"></i></a></nav><br><br><br>
<table align="center">
<tr>
			<td class="head-table" colspan="6" align="center"><?php echo $data_jenis_pelajaran["nama_jenis_pelajaran"] . " " . $data_mata_pelajaran["nama_mata_pelajaran"] . " kelas " . $data_kelas["nama_kelas"]; ?></td>
		</tr>
		<table align="center">
		<tr class="tatabel">
			<th>tanggal</th>
			<th>pelajaran</th>
			<th>aksi</th>
		</tr>
		<?php while($data_pelajaran = mysqli_fetch_assoc($ambil_data_pelajaran)) : ?>
		<tr class="table-mapel" align="center">
			<td><?php echo $data_pelajaran["tanggal"]; ?></td>
			<td><?php echo $data_pelajaran["pelajaran"]; ?></td>
			<td width="200px">
				<a class="buka" href="daftar-hadir-siswa.php?
					id-kelas=<?php echo $id_kelas; ?>&&
					id-pelajaran=<?php echo $data_pelajaran['id_pelajaran']; ?>&&
					id-jenis-pelajaran=<?php echo $id_jenis_pelajaran; ?>
				">daftar hadir siswa</a>
			</td>
		</tr>
		<?php endwhile; ?>
	</table>

</body>
</html>

	
