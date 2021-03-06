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

$id_guru = $data_guru["id"];

$hari_saat_ini = date("l");

if($hari_saat_ini == "Sunday") {
	$hari_saat_ini = "ahad";
} elseif($hari_saat_ini == "Monday") {
	$hari_saat_ini = "senin";
} elseif($hari_saat_ini == "Tuesday") {
	$hari_saat_ini = "selasa";
} elseif($hari_saat_ini == "Wednesday") {
	$hari_saat_ini = "rabu";
} elseif($hari_saat_ini == "Thursday") {
	$hari_saat_ini = "kamis";
} elseif($hari_saat_ini == "Friday") {
	$hari_saat_ini = "jum'at";
} elseif($hari_saat_ini == "Saturday") {
	$hari_saat_ini = "sabtu";
}

$kueri_data_jadwal = "
	SELECT
		hari.nama_hari,
		kelas.nama_kelas,
		mata_pelajaran.nama_mata_pelajaran,
		jadwal.id_kelas,
		jadwal.id_mata_pelajaran,
		jadwal.waktu_mulai,
		jadwal.waktu_selesai
	FROM jadwal
	INNER JOIN hari ON hari.id_hari = jadwal.id_hari
	INNER JOIN kelas ON kelas.id_kelas = jadwal.id_kelas
	INNER JOIN mata_pelajaran ON mata_pelajaran.id_mata_pelajaran = jadwal.id_mata_pelajaran
	WHERE id_guru = '$id_guru'
	ORDER BY jadwal.id_hari, jadwal.waktu_mulai
";

$ambil_data_jadwal = mysqli_query($koneksi_database, $kueri_data_jadwal);

$waktu_saat_ini = date("H:i:s");

?>
<!DOCTYPE html>
<html lang="en">
<?php require "../template/head.html"; ?>
<body>
<nav>
<a class="kembali" href="../guru"><i class="fas fa-chevron-left"></i> Kembali</a>
</nav><br><br><br>
<table align="center">
<tr>
			<td class="head-table" colspan="6" align="center">Jadwal Mengajar</td>
		</tr>
		<table  align="center">
		<tr class="tatabel">
			<th>hari</th>
			<th>kelas</th>
			<th>mata pelajaran</th>
			<th>waktu mulai</th>
			<th>waktu selesai</th>
			<th colspan="2">pelajaran</th>
		</tr>
		<?php while($data_jadwal = mysqli_fetch_assoc($ambil_data_jadwal)) : ?>
		<tr class="table-mapel" align="center" >
			<td><?php echo $data_jadwal["nama_hari"]; ?></td>
			<td><?php echo $data_jadwal["nama_kelas"]; ?></td>
			<td><?php echo $data_jadwal["nama_mata_pelajaran"]; ?></td>
			<td><?php echo $data_jadwal["waktu_mulai"]; ?></td>
			<td><?php echo $data_jadwal["waktu_selesai"]; ?></td>
			<td>
				<?php if ($hari_saat_ini != $data_jadwal["nama_hari"] && $waktu_saat_ini < $data_jadwal["waktu_mulai"]): ?>
					<p class="btn-wait">belum waktunya mengajar</p>
				<?php elseif($hari_saat_ini != $data_jadwal["nama_hari"] && $waktu_saat_ini > $data_jadwal["waktu_selesai"]) : ?>
					<p class="btn-wait">belum waktunya mengajar</p>
				<?php elseif($hari_saat_ini != $data_jadwal["nama_hari"] && $waktu_saat_ini >= $data_jadwal["waktu_mulai"] AND $waktu_saat_ini <= $data_jadwal["waktu_selesai"]) : ?>
					<p class="btn-wait">belum waktunya mengajar</p>
				<?php elseif($hari_saat_ini == $data_jadwal["nama_hari"] && $waktu_saat_ini < $data_jadwal["waktu_mulai"]) : ?>
					<p class="btn-wait">belum waktunya mengajar</p>
				<?php elseif($hari_saat_ini == $data_jadwal["nama_hari"] && $waktu_saat_ini > $data_jadwal["waktu_selesai"]) : ?>
					<p class="btn-lewat">waktu sudah lewat</p>
				<?php else: ?>
					<a id="btn-absen" href="
						pelajaran.php?
							id-jenis-pelajaran=1&&
							id-kelas=<?php echo $data_jadwal["id_kelas"]; ?>&&
							id-mata-pelajaran=<?php echo $data_jadwal['id_mata_pelajaran']; ?>
					">masuk kelas</a>
				<?php endif ?>
			</td>
			<!-- <td>
				<?php if ($waktu_saat_ini < $data_jadwal["waktu_mulai"]): ?>
					<p>belum waktunya memberi tugas</p>
				<?php elseif($waktu_saat_ini > $data_jadwal["waktu_selesai"]) : ?>
					<p>waktu sudah lewat</p>
				<?php else: ?>
					<a href="
						pelajaran.php?
							id-jenis-pelajaran=2&&
							id-kelas=<?php echo $data_jadwal["id_kelas"]; ?>&&
							id-mata-pelajaran=<?php echo $data_jadwal['id_mata_pelajaran']; ?>
					">tugas</a>
				<?php endif ?>
			</td> -->
		</tr>
		<?php endwhile; ?>
	</table>
</body>
</html>
