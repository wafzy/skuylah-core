<?php 
// koneksi database
include '../koneksi-database.php';

// menangkap data id yang di kirim dari url
$id = $_GET['id_guru'];


// menghapus data dari database
mysqli_query($koneksi_database,"delete from guru where id_guru='$id'");

// mengalihkan halaman kembali ke index.php
header("location:daftar-guru.php");

?>