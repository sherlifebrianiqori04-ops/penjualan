<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_penjualan"; // sesuaikan dengan nama database Anda

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>