<?php
include 'koneksi.php';

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    header("Location: databarang.php");
    exit;
}

$id = (int) $_GET['id'];

$stmt = mysqli_prepare(
    $conn,
    "SELECT * FROM produk WHERE id_produk = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$barang = mysqli_fetch_assoc($result);

if (!$barang) {
    header("Location: databarang.php");
    exit;
}

if (isset($_POST['update'])) {

    $nama  = trim($_POST['nama_produk']);
    $harga = (int) $_POST['harga'];
    $stok  = (int) $_POST['stok'];

    if ($nama !== "" && $harga >= 0 && $stok >= 0) {

        $update = mysqli_prepare(
            $conn,
            "UPDATE produk
             SET nama_produk = ?, harga = ?, stok = ?
             WHERE id_produk = ?"
        );

        mysqli_stmt_bind_param(
            $update,
            "siii",
            $nama,
            $harga,
            $stok,
            $id
        );

        if (mysqli_stmt_execute($update)) {
            header("Location: databarang.php");
            exit;
        } else {
            echo "Gagal mengubah data.";
        }
    } else {
        echo "Data tidak boleh kosong atau bernilai negatif.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f6fa;
            padding: 30px;
        }

        .container {
            max-width: 550px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 3px 15px #00000012;
        }

        h2 {
            color: #422512;
        }

        label {
            display: block;
            margin-top: 18px;
            margin-bottom: 7px;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        button, a {
            display: inline-block;
            padding: 12px 18px;
            margin-top: 20px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            cursor: pointer;
        }

        button {
            background: #3a2512;
            color: white;
        }

        a {
            background: #3d1f13;
            color: white;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>Edit Data Barang</h2>

    <form method="POST">

        <label>Nama Barang</label>
        <input
            type="text"
            name="nama_produk"
            value="<?= htmlspecialchars($barang['nama_produk']); ?>"
            required
        >

        <label>Harga Barang (Rp)</label>
        <input
            type="number"
            name="harga"
            min="0"
            value="<?= $barang['harga']; ?>"
            required
        >

        <label>Jumlah Stok</label>
        <input
            type="number"
            name="stok"
            min="0"
            value="<?= $barang['stok']; ?>"
            required
        >

        <button type="submit" name="update">
            Update Data
        </button>

        <a href="databarang.php">Batal</a>

    </form>

</div>

</body>
</html>