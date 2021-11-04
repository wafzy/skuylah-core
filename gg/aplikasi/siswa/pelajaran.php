<?php

session_start();

if(!isset($_SESSION["login"])) {
	header("location: ../masuk.php");
}

if($_SESSION["peran"] == "admin") {
	header("location: ../admin");
} elseif($_SESSION["peran"] == "guru") {
	header("location: ../guru");
}

$id_siswa = $_SESSION["id_siswa"];

require "../koneksi-database.php";

$kueri_data_siswa = "	SELECT id_kelas FROM siswa WHERE id_siswa='$id_siswa' ";

$tanggal_hari_ini = date('Y-m-d');

$ambil_data_siswa = mysqli_query($koneksi_database, $kueri_data_siswa);
	$data_siswa = mysqli_fetch_assoc($ambil_data_siswa);
	$id_kelas = $data_siswa["id_kelas"];

$id_mata_pelajaran = $_GET["id-mata-pelajaran"];

$ambil_data_mata_pelajaran = mysqli_query($koneksi_database, "SELECT * FROM mata_pelajaran WHERE id_mata_pelajaran='$id_mata_pelajaran' ");
$data_mata_pelajaran = mysqli_fetch_assoc($ambil_data_mata_pelajaran);

$kueri_data_pelajaran = "
	SELECT
		pelajaran.id_pelajaran,
		pelajaran.id_jenis_pelajaran,
		pelajaran.pelajaran,

		jenis_pelajaran.nama_jenis_pelajaran,
		guru.nama_guru
	FROM pelajaran
		INNER JOIN jenis_pelajaran ON jenis_pelajaran.id_jenis_pelajaran = pelajaran.id_jenis_pelajaran
		INNER JOIN guru ON guru.id = pelajaran.id_guru
	WHERE
		pelajaran.tanggal = '$tanggal_hari_ini' AND
		pelajaran.id_kelas=$id_kelas AND
		pelajaran.id_mata_pelajaran=$id_mata_pelajaran
";

$ambil_data_pelajaran = mysqli_query($koneksi_database, $kueri_data_pelajaran);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
<link rel="stylesheet" href="../../assets/css/style.css">
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>

<?php require "../template/head.html"; ?>
<body>
<nav>
<a class="kembali" href="../siswa/jadwal-pelajaran.php"><i class="fas fa-chevron-left"></i> Kembali</a>
</nav><br><br><br>
<table align="center">
<tr>
			<td class="head-table" colspan="2" align="center">daftar pelajaran <?php echo $data_mata_pelajaran["nama_mata_pelajaran"]; ?></td>
		</tr>


<table  align="center" >
	<tr class="tatabel">
		<!-- <th>jenis pelajaran</th> -->
		<!-- <th>nama guru</th> -->
		<th>pelajaran</th>
		<th>aksi</th>
	</tr>
	<?php while($data_pelajaran = mysqli_fetch_assoc($ambil_data_pelajaran)) : ?>
	<tr class="table-mapel" align="center">
		<!-- <td><?php echo $data_pelajaran["nama_jenis_pelajaran"]; ?></td> -->
		<!-- <td><?php echo $data_pelajaran["nama_guru"]; ?></td> -->
		<td><?php echo $data_pelajaran["pelajaran"]; ?></td>
		<td>
			<a class="buka" href="buka-pelajaran.php?id-pelajaran=<?php echo $data_pelajaran['id_pelajaran']; ?>&&id-jenis-pelajaran=<?php echo $data_pelajaran['id_jenis_pelajaran']; ?>">Buka</a>
		</td>
	</tr>
	<?php endwhile; ?>
</table>
</body>
</html>