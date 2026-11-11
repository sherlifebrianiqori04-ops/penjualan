<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sers school - Penjualan</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f6fa;
            color: #3f2518;
        }

        header {
            background: #422317;
            color: white;
            padding: 25px 40px;
        }

        .container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
        }

        .panel {
            background: white;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 3px 15px #00000012;
        }

        a {
            display: inline-block;
            background: #492917;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 15px;
        }

        a:hover {
            background: #522f1a;
        }
    </style>
</head>

<body>

<header>
    <h1>sers school</h1>
    <p>Sistem Informasi Penjualan</p>
</header>

<div class="container">
    <div class="panel">
        <h2>Selamat Datang di sers school</h2>
        <p>
            Website ini digunakan untuk mengelola data barang
            dan informasi produk penjualan.
        </p>

        <a href="databarang.php">Lihat Data Barang</a>
        <a href="inputdata.php">Input Data Barang</a>
        <a href="transaksi.php">Transaksi</a>
    </div>
</div>

</body>
</html>