<?php
include 'koneksi.php';

if (isset($_POST['simpan'])) {

    $nama  = trim($_POST['nama_produk']);
    $harga = (int) $_POST['harga'];
    $stok  = (int) $_POST['stok'];

    if ($nama !== "" && $harga >= 0 && $stok >= 0) {

        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO produk (nama_produk, harga, stok)
             VALUES (?, ?, ?)"
        );

        mysqli_stmt_bind_param($stmt, "sii", $nama, $harga, $stok);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: databarang.php");
            exit;
        } else {
            echo "Gagal menyimpan data: " . mysqli_error($conn);
        }

    } else {
        echo "Data tidak boleh kosong atau bernilai negatif.";
    }

} else {
    header("Location: inputdata.php");
    exit;
}
?>