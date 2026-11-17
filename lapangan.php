<?php
include 'koneksi.php';

$query = mysqli_query($koneksi, "SELECT * FROM lapangan");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Lapangan - Futsal Booking</title>

    <link rel="stylesheet" href="style.css">

    <style>
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .page-header h1 {
            margin: 0;
        }

        .page-header p {
            color: #6b7280;
            margin-top: 7px;
        }

        .btn-add {
            background: #2563eb;
            color: white;
            text-decoration: none;
            padding: 12px 18px;
            border-radius: 10px;
            font-weight: bold;
        }

        .table-card {
            background: white;
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.04);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f1f5f9;
            padding: 15px;
            text-align: left;
            font-size: 13px;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 14px;
        }

        tr:hover {
            background: #f8fafc;
        }

        .harga {
            font-weight: bold;
        }

        .edit {
            color: #2563eb;
            text-decoration: none;
            font-weight: bold;
            margin-right: 10px;
        }

        .hapus {
            color: #dc2626;
            text-decoration: none;
            font-weight: bold;
        }

        .empty {
            text-align: center;
            color: #6b7280;
            padding: 30px;
        }
    </style>
</head>

<body>

<div class="sidebar">

    <div class="logo">
        ⚽ <span>FUTSAL</span>
    </div>

    <div class="menu-title">
        MENU UTAMA
    </div>

    <a href="index.php" class="menu">
        🏠 <span>Dashboard</span>
    </a>

    <a href="pelanggan.php" class="menu">
        👤 <span>Pelanggan</span>
    </a>

    <a href="lapangan.php" class="menu active">
        🏟️ <span>Lapangan</span>
    </a>

    <a href="pemesanan.php" class="menu">
        📅 <span>Pemesanan</span>
    </a>

    <div class="sidebar-bottom">

        <div class="admin-box">

            <div class="admin-icon">
                ⚡
            </div>

            <div>
                <strong>Admin</strong>
                <small>Futsal Manager</small>
            </div>

        </div>

    </div>

</div>


<div class="main">

    <div class="page-header">

        <div>

            <h1>
                Data Lapangan 🏟️
            </h1>

            <p>
                Kelola daftar lapangan futsal.
            </p>

        </div>


        <a href="tambah_lapangan.php" class="btn-add">
            + Tambah Lapangan
        </a>

    </div>


    <div class="table-card">

        <table>

            <thead>

                <tr>
                    <th>No</th>
                    <th>ID Lapangan</th>
                    <th>Nama Lapangan</th>
                    <th>Jenis Lapangan</th>
                    <th>Harga / Jam</th>
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
                        <?= htmlspecialchars($data['id_lapangan']); ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($data['nama_lapangan']); ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($data['jenis_lapangan']); ?>
                    </td>

                    <td class="harga">

                        Rp <?= number_format(
                            $data['harga_per_jam'],
                            0,
                            ',',
                            '.'
                        ); ?>

                    </td>

                    <td>

                        <a
                            href="edit_lapangan.php?id=<?= urlencode($data['id_lapangan']); ?>"
                            class="edit"
                        >
                            ✏️ Edit
                        </a>

                        <a
                            href="hapus_lapangan.php?id=<?= urlencode($data['id_lapangan']); ?>"
                            class="hapus"
                            onclick="return confirm('Yakin ingin menghapus lapangan ini?');"
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

                    <td colspan="6" class="empty">
                        Belum ada data lapangan.
                    </td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>