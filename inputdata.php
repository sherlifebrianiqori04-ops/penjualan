<?php
// Memasukkan file koneksi database
include 'koneksi.php';

// Logika untuk menyimpan data barang baru
if (isset($_POST['simpan'])) {
    $nama_barang = $_POST['nama_barang'];
    $harga       = $_POST['harga'];
    $stok        = $_POST['stok'];

    $query_simpan = mysqli_query($conn, "INSERT INTO produk (nama_produk, harga, stok) VALUES ('$nama_barang', '$harga', '$stok')");

    if ($query_simpan) {
        echo "<script>alert('Data barang berhasil ditambahkan!'); window.location='inputdata.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan data!');</script>";
    }
}

// Logika pencarian data
if (isset($_POST['cari'])) {
    $keyword = $_POST['keyword'];
    $query = mysqli_query($conn, "SELECT * FROM produk WHERE nama_produk LIKE '%$keyword%' OR id_produk LIKE '%$keyword%' ORDER BY id_produk DESC");
} else {
    $query = mysqli_query($conn, "SELECT * FROM produk ORDER BY id_produk DESC");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data & Input Barang | SELLORA</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f6fa;
            padding: 30px;
            color: #2c200f;
        }
        .container {
            max-width: 1100px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.1);
        }
        h2 {
            margin-bottom: 20px;
            color: #42311d;
        }
        .card-form {
            background: #fdfdfd;
            border: 1px solid #e2e8f0;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        .form-row {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        .form-group {
            flex: 1;
            min-width: 200px;
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
            font-size: 14px;
            color: #42311d;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }
        .btn {
            background-color: #2c200f;
            color: white;
            padding: 10px 18px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
        }
        .btn:hover {
            background-color: #42311d;
        }
        .btn-simpan {
            margin-top: 5px;
        }
        .header-action {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }
        .search-box {
            display: flex;
            gap: 8px;
        }
        .search-input {
            padding: 9px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            width: 250px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        th {
            background-color: #f3f6fa;
            color: #42311d;
            font-weight: bold;
        }
        tr:hover {
            background-color: #fafbfc;
        }
        .action-links a {
            margin-right: 10px;
            text-decoration: none;
            font-weight: bold;
        }
        .edit-btn { color: #d97706; }
        .hapus-btn { color: #dc2626; }
    </style>
</head>
<body>

<div class="container">
    <h2>Kelola Data Barang</h2>

    <!-- FORM INPUT DI ATAS -->
    <div class="card-form">
        <h3 style="margin-top: 0; color: #42311d; font-size: 18px;">+ Tambah Barang Baru</h3>
        <form action="" method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label>Nama Produk</label>
                    <input type="text" name="nama_barang" class="form-control" placeholder="Masukkan nama barang" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label>Harga (Rp)</label>
                    <input type="number" name="harga" class="form-control" placeholder="Contoh: 50000" required>
                </div>
                <div class="form-group">
                    <label>Stok</label>
                    <input type="number" name="stok" class="form-control" placeholder="Jumlah stok" required>
                </div>
            </div>
            <button type="submit" name="simpan" class="btn btn-simpan">Simpan Barang</button>
        </form>
    </div>

    <!-- BAGIAN TABEL DAN PENCARIAN -->
    <div class="header-action">
        <h3 style="margin: 0; color: #42311d; font-size: 18px;">Daftar Produk Tersimpan</h3>

        <!-- Form Pencarian -->
        <form action="" method="POST" class="search-box">
            <input type="text" name="keyword" class="search-input" placeholder="Cari nama barang..." autocomplete="off">
            <button type="submit" name="cari" class="btn">Cari</button>
        </form>
    </div>

    <!-- Tabel Menampilkan Data -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Produk</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            if (mysqli_num_rows($query) > 0) {
                while ($row = mysqli_fetch_assoc($query)) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . $row['id_produk'] . "</td>";
                    echo "<td>" . $row['nama_produk'] . "</td>";
                    echo "<td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>";
                    echo "<td>" . $row['stok'] . "</td>";
                    echo "<td class='action-links'>
                            <a href='edit.php?id=" . $row['id_produk'] . "' class='edit-btn'>Edit</a>
                            <a href='hapus.php?id=" . $row['id_produk'] . "' class='hapus-btn' onclick=\"return confirm('Yakin ingin menghapus data ini?')\">Hapus</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' style='text-align: center; color: #777;'>Belum ada data barang atau data tidak ditemukan.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>