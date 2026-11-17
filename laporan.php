<?php
require_once "koneksi.php";

/* Ambil data pemesanan */
$query = mysqli_query($koneksi, "
    SELECT 
        pemesanan.id_pemesanan,
        pelanggan.nama_pelanggan,
        lapangan.nama_lapangan,
        pemesanan.tanggal,
        pemesanan.jam_mulai,
        pemesanan.jam_selesai,
        pemesanan.total_bayar,
        pemesanan.status
    FROM pemesanan
    INNER JOIN pelanggan 
        ON pemesanan.id_pelanggan = pelanggan.id_pelanggan
    INNER JOIN lapangan 
        ON pemesanan.id_lapangan = lapangan.id_lapangan
    ORDER BY pemesanan.tanggal DESC, pemesanan.jam_mulai DESC
");

/* Hitung total transaksi */
$query_total = mysqli_query($koneksi, "
    SELECT 
        COUNT(*) AS jumlah_transaksi,
        COALESCE(SUM(total_bayar), 0) AS total_semua
    FROM pemesanan
    WHERE status IN ('Dibayar', 'Selesai')
");

$data_total = mysqli_fetch_assoc($query_total);

$jumlah_transaksi = $data_total['jumlah_transaksi'];
$total_semua = $data_total['total_semua'];
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Laporan Pemesanan - Futsal Booking</title>

    <link rel="stylesheet" href="style.css">

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f4f6f8;
            color: #1f2937;
            font-family: Arial, Helvetica, sans-serif;
            overflow-x: hidden;
        }

        /* SIDEBAR */

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            height: 100vh;
            background: #111827;
            padding: 25px 18px;
            color: white;
            z-index: 1000;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 25px;
            font-weight: bold;
            padding: 5px 12px 35px;
        }

        .menu-title {
            color: #9ca3af;
            font-size: 11px;
            font-weight: bold;
            padding: 0 14px 12px;
            letter-spacing: 1px;
        }

        .sidebar a.menu {
            display: flex;
            align-items: center;
            gap: 14px;
            width: 100%;
            padding: 14px;
            margin-bottom: 7px;
            border-radius: 10px;
            color: #cbd5e1;
            text-decoration: none;
            font-size: 14px;
            transition: 0.2s;
        }

        .sidebar a.menu:hover {
            background: #1f2937;
            color: white;
        }

        .sidebar a.menu.active {
            background: #2563eb;
            color: white;
        }

        .sidebar-bottom {
            position: absolute;
            bottom: 25px;
            left: 18px;
            right: 18px;
        }

        .admin-box {
            background: #1f2937;
            padding: 13px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-icon {
            width: 38px;
            height: 38px;
            background: #2563eb;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .admin-box strong {
            display: block;
            font-size: 13px;
        }

        .admin-box small {
            display: block;
            color: #9ca3af;
            margin-top: 3px;
        }

        /* MAIN */

        .main-content {
            margin-left: 250px;
            width: calc(100% - 250px);
            padding: 35px 40px;
            min-height: 100vh;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .topbar h1 {
            margin: 0 0 6px;
            font-size: 28px;
        }

        .topbar p {
            margin: 0;
            color: #6b7280;
            font-size: 14px;
        }

        .date-box {
            background: white;
            padding: 12px 18px;
            border-radius: 10px;
            color: #4b5563;
            font-size: 13px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        /* RINGKASAN */

        .summary {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 25px;
        }

        .summary-card {
            background: white;
            padding: 22px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.04);
        }

        .summary-icon {
            width: 55px;
            height: 55px;
            border-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
            background: #dbeafe;
        }

        .summary-card span {
            display: block;
            color: #6b7280;
            font-size: 13px;
            margin-bottom: 6px;
        }

        .summary-card h2 {
            margin: 0;
            font-size: 23px;
        }

        /* LAPORAN */

        .report-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.04);
        }

        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .report-header h3 {
            margin: 0 0 5px;
            font-size: 18px;
        }

        .report-header p {
            margin: 0;
            color: #9ca3af;
            font-size: 13px;
        }

        .btn-cetak {
            background: #2563eb;
            color: white;
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
            border: none;
            cursor: pointer;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 950px;
            border-collapse: collapse;
        }

        th {
            background: #f8fafc;
            color: #475569;
            padding: 13px 12px;
            text-align: left;
            font-size: 12px;
            border-bottom: 1px solid #e5e7eb;
        }

        td {
            padding: 14px 12px;
            border-bottom: 1px solid #f1f1f1;
            font-size: 13px;
        }

        tr:hover td {
            background: #f8fafc;
        }

        .harga {
            font-weight: bold;
        }

        .status {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
        }

        .status-menunggu {
            background: #fef3c7;
            color: #92400e;
        }

        .status-dibayar {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .status-selesai {
            background: #dcfce7;
            color: #166534;
        }

        .status-dibatalkan {
            background: #fee2e2;
            color: #991b1b;
        }

        .empty {
            text-align: center;
            padding: 40px;
            color: #9ca3af;
        }

        /* RESPONSIVE */

        @media (max-width: 900px) {

            .sidebar {
                width: 210px;
            }

            .main-content {
                margin-left: 210px;
                width: calc(100% - 210px);
                padding: 25px;
            }

        }

        @media (max-width: 650px) {

            .sidebar {
                display: none;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 20px;
            }

            .summary {
                grid-template-columns: 1fr;
            }

            .topbar {
                display: block;
            }

            .date-box {
                display: inline-block;
                margin-top: 15px;
            }

            .report-header {
                display: block;
            }

            .btn-cetak {
                display: inline-block;
                margin-top: 15px;
            }

        }

    </style>

</head>

<body>


<!-- SIDEBAR -->

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

    <a href="lapangan.php" class="menu">
        🏟️ <span>Lapangan</span>
    </a>

    <a href="pemesanan.php" class="menu">
        📅 <span>Pemesanan</span>
    </a>

    <a href="laporan.php" class="menu active">
        📊 <span>Laporan</span>
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


<!-- MAIN -->

<div class="main-content">


    <!-- TOPBAR -->

    <div class="topbar">

        <div>

            <h1>
                Laporan Pemesanan
            </h1>

            <p>
                Rekapitulasi data pemesanan lapangan futsal
            </p>

        </div>

        <div class="date-box">
            📅 <?php echo date("d M Y"); ?>
        </div>

    </div>


    <!-- SUMMARY -->

    <div class="summary">

        <div class="summary-card">

            <div class="summary-icon">
                📅
            </div>

            <div>

                <span>
                    Total Transaksi
                </span>

                <h2>
                    <?php echo $jumlah_transaksi; ?>
                </h2>

            </div>

        </div>


        <div class="summary-card">

            <div class="summary-icon">
                💰
            </div>

            <div>

                <span>
                    Total Pendapatan
                </span>

                <h2>
                    Rp <?php echo number_format(
                        $total_semua,
                        0,
                        ',',
                        '.'
                    ); ?>
                </h2>

            </div>

        </div>

    </div>


    <!-- REPORT TABLE -->

    <div class="report-card">

        <div class="report-header">

            <div>

                <h3>
                    Data Pemesanan
                </h3>

                <p>
                    Daftar seluruh transaksi pemesanan
                </p>

            </div>

            <button
                onclick="window.print()"
                class="btn-cetak"
            >
                🖨️ Cetak Laporan
            </button>

        </div>


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

                    </tr>

                </thead>

                <tbody>

                <?php

                $no = 1;

                if (mysqli_num_rows($query) > 0) {

                    while ($data = mysqli_fetch_assoc($query)) {

                        $status = strtolower($data['status']);

                        $status_class = '';

                        if ($status == 'menunggu') {
                            $status_class = 'status-menunggu';
                        } elseif ($status == 'dibayar') {
                            $status_class = 'status-dibayar';
                        } elseif ($status == 'selesai') {
                            $status_class = 'status-selesai';
                        } elseif ($status == 'dibatalkan') {
                            $status_class = 'status-dibatalkan';
                        }

                ?>

                    <tr>

                        <td>
                            <?php echo $no++; ?>
                        </td>

                        <td>
                            <strong>
                                <?php echo htmlspecialchars($data['id_pemesanan']); ?>
                            </strong>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($data['nama_pelanggan']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($data['nama_lapangan']); ?>
                        </td>

                        <td>
                            <?php echo date(
                                'd-m-Y',
                                strtotime($data['tanggal'])
                            ); ?>
                        </td>

                        <td>
                            <?php echo date(
                                'H:i',
                                strtotime($data['jam_mulai'])
                            ); ?>

                            -

                            <?php echo date(
                                'H:i',
                                strtotime($data['jam_selesai'])
                            ); ?>
                        </td>

                        <td class="harga">
                            Rp <?php echo number_format(
                                $data['total_bayar'],
                                0,
                                ',',
                                '.'
                            ); ?>
                        </td>

                        <td>

                            <span class="status <?php echo $status_class; ?>">

                                <?php echo htmlspecialchars($data['status']); ?>

                            </span>

                        </td>

                    </tr>

                <?php

                    }

                } else {

                ?>

                    <tr>

                        <td colspan="8" class="empty">
                            Belum ada data pemesanan.
                        </td>

                    </tr>

                <?php

                }

                ?>

                </tbody>

            </table>

        </div>

    </div>


</div>


</body>

</html>