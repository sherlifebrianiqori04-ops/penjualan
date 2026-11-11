<?php
include 'koneksi.php';

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    header("Location: databarang.php");
    exit;
}

$id = (int) $_GET['id'];

$stmt = mysqli_prepare(
    $conn,
    "DELETE FROM produk WHERE id_produk = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    header("Location: databarang.php");
    exit;
} else {
    echo "Gagal menghapus data.";
    echo "<br>Barang mungkin masih digunakan dalam data penjualan.";
}
?>