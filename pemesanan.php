<?php
include 'koneksi.php';

$query = mysqli_query($koneksi, "
    SELECT
        pemesanan.*,
        pelanggan.nama_pelanggan,
        lapangan.nama_lapangan
    FROM pemesanan
    JOIN pelanggan
        ON pemesanan.id_pelanggan = pelanggan.id_pelanggan
    JOIN lapangan
        ON pemesanan.id_lapangan = lapangan.id_lapangan
    ORDER BY pemesanan.tanggal DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Pemesanan - Futsal Booking</title>

    <link rel="stylesheet" href="style.css">

    <style>

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            overflow-x: hidden;
        }

        /* SIDEBAR */

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            height: 100vh;
            overflow-y: auto;
        }

        /* KONTEN */

        .main-content {
            margin-left: 250px !important;
            width: calc(100% - 250px) !important;
            min-height: 100vh;
            padding: 30px !important;
            overflow-x: auto;
        }

        /* HEADER */

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 25px;
        }

        .page-header h1 {
            margin: 0 0 7px 0;
        }

        .page-header p {
            margin: 0;
            color: #64748b;
        }

        /* TOMBOL TAMBAH */

        .btn-tambah {
            display: inline-block;
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

        /* TABEL */

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
            min-width: 950px;
            border-collapse: collapse;
        }

        th {
            background: #f1f5f9;
            padding: 14px;
            text-align: left;
            color: #334155;
            white-space: nowrap;
        }

        td {
            padding: 14px;
            border-bottom: 1px solid #e5e7eb;
            white-space: nowrap;
        }

        tr:hover {
            background: #f8fafc;
        }

        /* TOMBOL AKSI */

        .edit {
            display: inline-block;
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
            display: inline-block;
            background: #ef4444;
            color: white;
            padding: 7px 10px;
            border-radius: 6px;
            text-decoration: none;
        }

        .hapus:hover {
            background: #dc2626;
        }

        /* STATUS */

        .status {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
        }

        .Menunggu {
            background: #fef3c7;
            color: #92400e;
        }

        .Dibayar {
            background: #dcfce7;
            color: #166534;
        }

        .Selesai {
            background: #dbeafe;
            color: #1e40af;
        }

        .Dibatalkan {
            background: #fee2e2;
            color: #991b1b;
        }

        .kosong {
            text-align: center;
            padding: 30px;
            color: #64748b;
        }

        /* RESPONSIVE */

        @media (max-width: 900px) {

            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }

            .main-content {
                margin-left: 0 !important;
                width: 100% !important;
                padding: 20px !important;
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

    <a href="pelanggan.php">
        👤 Pelanggan
    </a>

    <a href="lapangan.php">
        ⚽ Lapangan
    </a>

    <a href="pemesanan.php" class="active">
        📅 Pemesanan
    </a>

</div>


<!-- KONTEN -->

<div class="main-content">


    <div class="page-header">

        <div>

            <h1>Data Pemesanan</h1>

            <p>
                Daftar pemesanan lapangan futsal
            </p>

        </div>


        <a
            href="tambah_pemesanan.php"
            class="btn-tambah"
        >
            + Tambah Pemesanan
        </a>

    </div>


    <!-- TABEL -->

    <div class="table-container">

        <table>

            <thead>

                <tr>

                    <th>No</th>

                    <th>ID Pemesanan</th>

                    <th>Pelanggan</th>

                    <th>Lapangan</th>

                    <th>Tanggal</th>

                    <th>Jam</th>

                    <th>Total Bayar</th>

                    <th>Status</th>

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
                        <?= htmlspecialchars($data['id_pemesanan']); ?>
                    </td>


                    <td>
                        <?= htmlspecialchars($data['nama_pelanggan']); ?>
                    </td>


                    <td>
                        <?= htmlspecialchars($data['nama_lapangan']); ?>
                    </td>


                    <td>
                        <?= date(
                            'd-m-Y',
                            strtotime($data['tanggal'])
                        ); ?>
                    </td>


                    <td>

                        <?= substr(
                            $data['jam_mulai'],
                            0,
                            5
                        ); ?>

                        -

                        <?= substr(
                            $data['jam_selesai'],
                            0,
                            5
                        ); ?>

                    </td>


                    <td>

                        Rp
                        <?= number_format(
                            $data['total_bayar'],
                            0,
                            ',',
                            '.'
                        ); ?>

                    </td>


                    <td>

                        <span
                            class="status <?= htmlspecialchars($data['status']); ?>"
                        >

                            <?= htmlspecialchars(
                                $data['status']
                            ); ?>

                        </span>

                    </td>


                    <td>

                        <a
                            href="edit_pemesanan.php?id=<?= urlencode($data['id_pemesanan']); ?>"
                            class="edit"
                        >
                            ✏️ Edit
                        </a>


                        <a
                            href="hapus_pemesanan.php?id=<?= urlencode($data['id_pemesanan']); ?>"
                            class="hapus"
                            onclick="return confirm('Yakin ingin menghapus pemesanan ini?');"
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

                    <td
                        colspan="9"
                        class="kosong"
                    >
                        Belum ada data pemesanan.
                    </td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>