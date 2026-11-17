<?php
include 'koneksi.php';

$query = mysqli_query($koneksi, "
    SELECT * FROM pelanggan
    ORDER BY nama_pelanggan ASC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Pelanggan - Futsal Booking</title>

    <link rel="stylesheet" href="style.css">

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            overflow-x: hidden;
        }

        .main-content {
            margin-left: 250px;
            padding: 30px;
            width: calc(100% - 250px);
            min-height: 100vh;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            gap: 15px;
        }

        .page-header h1 {
            margin: 0 0 7px 0;
        }

        .page-header p {
            margin: 0;
            color: #64748b;
        }

        .btn-tambah {
            background: #2563eb;
            color: white;
            padding: 12px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            white-space: nowrap;
        }

        .btn-tambah:hover {
            background: #1d4ed8;
        }

        .table-container {
            width: 100%;
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 650px;
        }

        th {
            background: #f1f5f9;
            padding: 14px;
            text-align: left;
            color: #334155;
        }

        td {
            padding: 14px;
            border-bottom: 1px solid #e5e7eb;
        }

        tr:hover {
            background: #f8fafc;
        }

        .edit {
            background: #f59e0b;
            color: white;
            padding: 7px 10px;
            border-radius: 6px;
            text-decoration: none;
            margin-right: 5px;
        }

        .edit:hover {
            background: #d97706;
        }

        .hapus {
            background: #ef4444;
            color: white;
            padding: 7px 10px;
            border-radius: 6px;
            text-decoration: none;
        }

        .hapus:hover {
            background: #dc2626;
        }

        .kosong {
            text-align: center;
            padding: 30px;
            color: #64748b;
        }

        @media (max-width: 900px) {

            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 20px;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }

    </style>

</head>

<body>


<!-- SIDEBAR -->

<div class="sidebar">

    <h2>⚽ FUTSAL</h2>

    <a href="index.php">
        🏠 Dashboard
    </a>

    <a href="pelanggan.php" class="active">
        👤 Pelanggan
    </a>

    <a href="lapangan.php">
        ⚽ Lapangan
    </a>

    <a href="pemesanan.php">
        📅 Pemesanan
    </a>

</div>


<!-- KONTEN -->

<div class="main-content">

    <div class="page-header">

        <div>

            <h1>Data Pelanggan</h1>

            <p>
                Daftar pelanggan futsal
            </p>

        </div>

        <a
            href="tambah_pelanggan.php"
            class="btn-tambah"
        >
            + Tambah Pelanggan
        </a>

    </div>


    <div class="table-container">

        <table>

            <thead>

                <tr>
                    <th>No</th>
                    <th>ID Pelanggan</th>
                    <th>Nama Pelanggan</th>
                    <th>No. Telepon</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>

            </thead>


            <tbody>

            <?php

            $no = 1;

            if (mysqli_num_rows($query) > 0) {

                while ($data = mysqli_fetch_assoc($query)) {

            ?>

                <tr>

                    <td>
                        <?= $no++; ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($data['id_pelanggan']); ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($data['nama_pelanggan']); ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($data['no_telp']); ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($data['alamat']); ?>
                    </td>

                    <td>

                        <a
                            href="edit_pelanggan.php?id=<?= urlencode($data['id_pelanggan']); ?>"
                            class="edit"
                        >
                            ✏️ Edit
                        </a>

                        <a
                            href="hapus_pelanggan.php?id=<?= urlencode($data['id_pelanggan']); ?>"
                            class="hapus"
                            onclick="return confirm('Yakin ingin menghapus pelanggan ini?');"
                        >
                            🗑️ Hapus
                        </a>

                    </td>

                </tr>

            <?php

                }

            } else {

            ?>

                <tr>

                    <td colspan="6" class="kosong">

                        Belum ada data pelanggan.

                    </td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>