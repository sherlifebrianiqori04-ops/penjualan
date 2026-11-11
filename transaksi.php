<?php
// Memanggil koneksi database
include 'koneksi.php';

// Proses Simpan Data ke Database
if (isset($_POST['simpan'])) {
    $no_faktur      = $_POST['noFaktur'];
    $tanggal        = $_POST['tanggal'];
    $nama_pelanggan = $_POST['namaPelanggan'];
    
    // Memisahkan nilai produk dan harga dari dropdown
    $produk_data    = explode('|', $_POST['produk']);
    $nama_produk    = $produk_data[0];
    $harga_satuan   = $produk_data[1];
    
    $jumlah         = $_POST['jumlah'];
    $total_harga    = $harga_satuan * $jumlah;

    $query = "INSERT INTO transaksi (no_faktur, tanggal, nama_pelanggan, nama_produk, harga_satuan, jumlah, total_harga) 
              VALUES ('$no_faktur', '$tanggal', '$nama_pelanggan', '$nama_produk', '$harga_satuan', '$jumlah', '$total_harga')";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Transaksi berhasil disimpan!'); window.location='transaksi.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan transaksi!');</script>";
    }
}

// Generate No Faktur Otomatis Berdasarkan Data Terakhir di Database
$fakturBaru = "INV/2026/001";
if (isset($conn)) {
    $qFaktur = mysqli_query($conn, "SELECT no_faktur FROM transaksi ORDER BY id DESC LIMIT 1");
    if ($qFaktur && mysqli_num_rows($qFaktur) > 0) {
        $dFaktur = mysqli_fetch_assoc($qFaktur);
        $noUrut = (int) substr($dFaktur['no_faktur'], -3) + 1;
        $fakturBaru = "INV/2026/" . sprintf("%03s", $noUrut);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form & Tabel Penjualan - Brown Theme</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #fdf8f5 0%, #f4eae1 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card-custom {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(111, 78, 55, 0.15);
            overflow: hidden;
        }
        .card-header-brown {
            background: linear-gradient(135deg, #8d5b4c 0%, #6f4e37 100%);
            color: white;
            padding: 20px;
            border: none;
        }
        .btn-brown {
            background: linear-gradient(135deg, #8d5b4c 0%, #6f4e37 100%);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 10px;
            font-weight: 600;
        }
        .btn-brown:hover {
            background: linear-gradient(135deg, #6f4e37 0%, #563d2c 100%);
            color: white;
        }
        .form-control:focus, .form-select:focus {
            border-color: #8d5b4c;
            box-shadow: 0 0 0 0.25rem rgba(141, 91, 76, 0.25);
        }
        .total-box {
            background-color: #fcf8f6;
            border-radius: 12px;
            border: 1px solid #e6d5cc;
        }
        .table-brown th {
            background-color: #8d5b4c !important;
            color: white;
        }
        .text-brown {
            color: #6f4e37 !important;
        }
    </style>
</head>x
<body class="py-4">

    <div class="container">
        <!-- Judul Halaman -->
        <div class="text-center mb-4">
            <h2 class="fw-bold text-brown"><i class="bi bi-bag-fill me-2"></i>Aplikasi Transaksi Penjualan</h2>
            <p class="text-muted">Kelola input penjualan dan lihat riwayat transaksi langsung dari database</p>
        </div>

        <div class="row g-4">
            <!-- Bagian Kiri: Form Input Penjualan -->
            <div class="col-lg-5">
                <div class="card card-custom">
                    <div class="card-header card-header-brown">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i>Form Input Penjualan</h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="">
                            <!-- No Faktur -->
                            <div class="mb-3">
                                <label class="form-label text-secondary fw-semibold">No. Faktur</label>
                                <input type="text" class="form-control bg-light" name="noFaktur" value="<?= $fakturBaru; ?>" readonly>
                            </div>

                            <!-- Tanggal -->
                            <div class="mb-3">
                                <label class="form-label text-secondary fw-semibold">Tanggal Transaksi</label>
                                <input type="date" class="form-control" name="tanggal" id="tanggal" required>
                            </div>

                            <!-- Nama Pelanggan -->
                            <div class="mb-3">
                                <label class="form-label text-secondary fw-semibold">Nama Pelanggan</label>
                                <input type="text" class="form-control" name="namaPelanggan" placeholder="Masukkan nama pembeli" required>
                            </div>

                            <!-- Pilih Produk (Diambil dari tabel produk) -->
                            <div class="mb-3">
                                <label class="form-label text-secondary fw-semibold">Pilih Produk</label>
                                <select class="form-select" name="produk" id="produk" required>
                                    <option value="" disabled selected>-- Pilih Produk dari Database --</option>
                                    <?php
                                    if (isset($conn)) {
                                        $queryBarang = mysqli_query($conn, "SELECT * FROM produk");
                                        if ($queryBarang && mysqli_num_rows($queryBarang) > 0) {
                                            while ($rowB = mysqli_fetch_assoc($queryBarang)) {
                                    ?>
                                    <option value="<?= $rowB['nama_produk']; ?>|<?= $rowB['harga']; ?>">
                                        <?= ucfirst($rowB['nama_produk']); ?> - Rp <?= number_format($rowB['harga'], 0, ',', '.'); ?> (Stok: <?= $rowB['stok']; ?>)
                                    </option>
                                    <?php 
                                            }
                                        } else {
                                            echo '<option value="" disabled>Data produk kosong / tabel tidak ditemukan</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Harga Satuan -->
                            <div class="mb-3">
                                <label class="form-label text-secondary fw-semibold">Harga Satuan</label>
                                <input type="text" class="form-control bg-light" id="hargaSatuan" readonly placeholder="0">
                            </div>

                            <!-- Jumlah Beli -->
                            <div class="mb-3">
                                <label class="form-label text-secondary fw-semibold">Jumlah Beli</label>
                                <input type="number" class="form-control" name="jumlah" id="jumlah" min="1" value="1" required>
                            </div>

                            <!-- Total Harga (Kalkulasi Otomatis) -->
                            <div class="p-3 total-box text-center mb-3">
                                <label class="form-label text-secondary fw-semibold mb-1">Total Pembayaran</label>
                                <h4 class="mb-0 fw-bold text-brown" id="displayTotal">Rp 0</h4>
                            </div>

                            <!-- Tombol Simpan -->
                            <div class="d-grid">
                                <button type="submit" name="simpan" class="btn btn-brown shadow-sm">
                                    <i class="bi bi-save-fill me-2"></i>Simpan Transaksi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <!-- Bagian Kanan: Tabel Riwayat Penjualan -->
            <div class="col-lg-7">
                <div class="card card-custom">
                    <div class="card-header card-header-brown">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-table me-2"></i>Tabel Riwayat Penjualan</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle table-brown">
                                <thead class="text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Faktur & Tanggal</th>
                                        <th>Pelanggan</th>
                                        <th>Produk & Qty</th>
                                        <th>Total Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    if (isset($conn)) {
                                        $data = mysqli_query($conn, "SELECT * FROM transaksi ORDER BY id DESC");
                                        if ($data && mysqli_num_rows($data) > 0) {
                                            while ($row = mysqli_fetch_assoc($data)) {
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td>
                                            <span class="fw-bold text-brown"><?= $row['no_faktur']; ?></span><br>
                                            <small class="text-muted"><?= $row['tanggal']; ?></small>
                                        </td>
                                        <td><?= $row['nama_pelanggan']; ?></td>
                                        <td>
                                            <?= ucfirst($row['nama_produk']); ?><br>
                                            <small class="text-muted">Qty: <?= $row['jumlah']; ?></small>
                                        </td>
                                        <td class="fw-semibold text-success">Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?></td>
                                    </tr>
                                    <?php 
                                            }
                                        } else {
                                            echo "<tr><td colspan='5' class='text-center text-muted py-3'>Belum ada data transaksi.</td></tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Kalkulasi Otomatis -->
    <script>
        // Set tanggal otomatis ke hari ini
        document.getElementById('tanggal').valueAsDate = new Date();

        const selectProduk = document.getElementById('produk');
        const inputHarga = document.getElementById('hargaSatuan');
        const inputJumlah = document.getElementById('jumlah');
        const displayTotal = document.getElementById('displayTotal');

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID').format(angka);
        }

        // Ketika produk dipilih
        selectProduk.addEventListener('change', function() {
            let val = this.value.split('|');
            let harga = parseInt(val[1]) || 0;
            inputHarga.value = formatRupiah(harga);
            hitungTotal();
        });

        // Ketika jumlah diubah
        inputJumlah.addEventListener('input', function() {
            hitungTotal();
        });

        // Hitung total otomatis
        function hitungTotal() {
            let val = selectProduk.value ? selectProduk.value.split('|')[1] : 0;
            let harga = parseInt(val) || 0;
            let jumlah = parseInt(inputJumlah.value) || 0;
            let total = harga * jumlah;
            displayTotal.innerText = 'Rp ' + formatRupiah(total);
        }
    </script>
</body>
</html>