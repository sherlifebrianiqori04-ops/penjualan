<?php
include 'koneksi.php';

$data = mysqli_query($conn, "SELECT * FROM produk ORDER BY id_produk DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang | SELLORA</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px;
            font-family: Arial, sans-serif;
            background: #f3f6fa;
            color: #2c200f;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 3px 15px #00000012;
            overflow-x: auto;
        }

        h1 {
            color: #422716;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        th, td {
            padding: 13px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #311e0f;
            color: white;
        }

        .btn {
            display: inline-block;
            padding: 9px 14px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 3px;
        }

        .tambah {
            background: #2c1e0e;
        }

        .edit {
            background: #5f3818;
        }

        .hapus {
            background: #7c4525;
        }

        .kembali {
            background: #351e0f;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Data Barang</h1>
    <p>Daftar seluruh produk yang tersimpan dalam database.</p>

    <a href="inputdata.php" class="btn tambah">+ Tambah Barang</a>
    <a href="index.php" class="btn kembali">Kembali</a>

    <table>
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;

        while ($d = mysqli_fetch_assoc($data)) {
        ?>

        <tr>
            <td><?= $no++; ?></td>

            <td>
                <?= htmlspecialchars($d['nama_produk']); ?>
            </td>

            <td>
                Rp <?= number_format($d['harga'], 0, ',', '.'); ?>
            </td>

            <td>
                <?= $d['stok']; ?>
            </td>

            <td>
                <a class="btn edit"
                   href="edit.php?id=<?= $d['id_produk']; ?>">
                   Edit
                </a>

                <a class="btn hapus"
                   href="hapus.php?id=<?= $d['id_produk']; ?>"
                   onclick="return confirm('Yakin ingin menghapus barang ini?')">
                   Hapus
                </a>
            </td>
        </tr>

        <?php } ?>

    </table>

</div>

</body>
</html>