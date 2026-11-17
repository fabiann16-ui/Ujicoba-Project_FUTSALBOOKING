<?php
require_once "koneksi.php";

$query_pelanggan = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM pelanggan");
$data_pelanggan = mysqli_fetch_assoc($query_pelanggan);

$query_lapangan = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM lapangan");
$data_lapangan = mysqli_fetch_assoc($query_lapangan);

$query_pemesanan = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM pemesanan");
$data_pemesanan = mysqli_fetch_assoc($query_pemesanan);

// Total pendapatan dari pemesanan yang sudah dibayar atau selesai
$query_pendapatan = mysqli_query($koneksi, "
    SELECT SUM(total_bayar) AS total_pendapatan
    FROM pemesanan
    WHERE status IN ('Dibayar', 'Selesai')
");

$data_pendapatan = mysqli_fetch_assoc($query_pendapatan);
$total_pendapatan = $data_pendapatan['total_pendapatan'] ?? 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Futsal Booking</title>

    <link rel="stylesheet" href="style.css">

    <style>

        /* =========================
           FIX SIDEBAR
        ========================= */

        .sidebar {
            display: block !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 250px !important;
            height: 100vh !important;
            background: #111827 !important;
            padding: 25px 18px !important;
            color: white !important;
            z-index: 9999 !important;
        }

        .sidebar .logo {
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
            width: 100% !important;
            color: white !important;
            font-size: 25px !important;
            font-weight: bold !important;
            padding: 5px 12px 35px !important;
        }

        .sidebar .logo span {
            color: white !important;
        }

        .sidebar .menu-title {
            display: block !important;
            width: 100% !important;
            color: #9ca3af !important;
            font-size: 11px !important;
            font-weight: bold !important;
            padding: 0 14px 12px !important;
            letter-spacing: 1px !important;
        }

        .sidebar a.menu {
            display: flex !important;
            align-items: center !important;
            flex-direction: row !important;
            width: 100% !important;
            height: auto !important;
            padding: 14px !important;
            margin: 0 0 7px 0 !important;
            gap: 14px !important;
            border-radius: 10px !important;
            background: transparent !important;
            color: #cbd5e1 !important;
            text-decoration: none !important;
            font-size: 14px !important;
            float: none !important;
            clear: both !important;
        }

        .sidebar a.menu:hover {
            background: #1f2937 !important;
            color: white !important;
        }

        .sidebar a.menu.active {
            background: #2563eb !important;
            color: white !important;
        }

        .sidebar a.menu span {
            display: inline-block !important;
            color: inherit !important;
            text-decoration: none !important;
            white-space: nowrap !important;
        }

        .sidebar-bottom {
            display: block !important;
            position: absolute !important;
            bottom: 25px !important;
            left: 18px !important;
            right: 18px !important;
        }


        /* =========================
           MAIN
        ========================= */

        .main {
            margin-left: 250px !important;
            width: calc(100% - 250px) !important;
            min-height: 100vh !important;
            padding: 35px 40px !important;
        }


        /* =========================
           4 STATISTIK
        ========================= */

        .stats {
            display: grid !important;
            grid-template-columns: repeat(4, 1fr) !important;
            gap: 20px !important;
        }

        .stat-card {
            min-width: 0 !important;
        }


        /* =========================
           MOBILE
        ========================= */

        @media (max-width: 1100px) {

            .stats {
                grid-template-columns: repeat(2, 1fr) !important;
            }

        }

        @media (max-width: 900px) {

            .sidebar {
                width: 210px !important;
            }

            .main {
                margin-left: 210px !important;
                width: calc(100% - 210px) !important;
                padding: 25px !important;
            }

        }

        @media (max-width: 650px) {

            .sidebar {
                display: none !important;
            }

            .main {
                margin-left: 0 !important;
                width: 100% !important;
                padding: 20px !important;
            }

            .stats {
                grid-template-columns: 1fr !important;
            }

        }

    </style>

</head>

<body>


<!-- =========================
     SIDEBAR
========================= -->

<div class="sidebar">

    <div class="logo">
        ⚽
        <span>FUTSAL</span>
    </div>

    <div class="menu-title">
        MENU UTAMA
    </div>


    <a href="index.php" class="menu active">

        🏠

        <span>
            Dashboard
        </span>

    </a>


    <a href="pelanggan.php" class="menu">

        👤

        <span>
            Pelanggan
        </span>

    </a>


    <a href="lapangan.php" class="menu">

        🏟️

        <span>
            Lapangan
        </span>

    </a>


    <a href="pemesanan.php" class="menu">

        📅

        <span>
            Pemesanan
        </span>

    </a>


    <!-- MENU LAPORAN -->

    <a href="laporan.php" class="menu">

        📊

        <span>
            Laporan
        </span>

    </a>


    <div class="sidebar-bottom">

        <div class="admin-box">

            <div class="admin-icon">
                ⚡
            </div>

            <div>

                <strong>
                    Admin
                </strong>

                <small>
                    Futsal Manager
                </small>

            </div>

        </div>

    </div>

</div>



<!-- =========================
     MAIN CONTENT
========================= -->

<div class="main">


    <!-- TOPBAR -->

    <div class="topbar">

        <div>

            <h1>
                Dashboard
            </h1>

            <p>
                Selamat datang di sistem informasi futsal 👋
            </p>

        </div>


        <div class="date-box">

            📅

            <?php echo date("d M Y"); ?>

        </div>

    </div>



    <!-- WELCOME -->

    <div class="welcome">

        <div>

            <h2>
                Kelola Futsal Lebih Mudah ⚽
            </h2>

            <p>
                Kelola pelanggan, lapangan, dan pemesanan
                dalam satu sistem.
            </p>

        </div>


        <div class="ball">
            ⚽
        </div>

    </div>



    <!-- STATISTICS -->

    <div class="stats">


        <!-- PELANGGAN -->

        <div class="stat-card">

            <div class="stat-icon blue">
                👤
            </div>

            <div>

                <span>
                    Total Pelanggan
                </span>

                <h2>
                    <?php echo $data_pelanggan['total']; ?>
                </h2>

            </div>

        </div>



        <!-- LAPANGAN -->

        <div class="stat-card">

            <div class="stat-icon green">
                🏟️
            </div>

            <div>

                <span>
                    Total Lapangan
                </span>

                <h2>
                    <?php echo $data_lapangan['total']; ?>
                </h2>

            </div>

        </div>



        <!-- PEMESANAN -->

        <div class="stat-card">

            <div class="stat-icon orange">
                📅
            </div>

            <div>

                <span>
                    Total Pemesanan
                </span>

                <h2>
                    <?php echo $data_pemesanan['total']; ?>
                </h2>

            </div>

        </div>



        <!-- PENDAPATAN -->

        <div class="stat-card">

            <div class="stat-icon blue">
                💰
            </div>

            <div>

                <span>
                    Total Pendapatan
                </span>

                <h2>
                    Rp <?php echo number_format(
                        $total_pendapatan,
                        0,
                        ',',
                        '.'
                    ); ?>
                </h2>

            </div>

        </div>


    </div>



    <!-- CONTENT -->

    <div class="content-grid">


        <!-- MENU CEPAT -->

        <div class="content-card">

            <div class="card-header">

                <div>

                    <h3>
                        Menu Cepat
                    </h3>

                    <p>
                        Akses pengelolaan data
                    </p>

                </div>

            </div>


            <div class="quick-menu">


                <a
                    href="tambah_pelanggan.php"
                    class="quick blue-border"
                >

                    <div>
                        👤
                    </div>

                    <span>
                        Tambah Pelanggan
                    </span>

                </a>



                <a
                    href="tambah_lapangan.php"
                    class="quick green-border"
                >

                    <div>
                        🏟️
                    </div>

                    <span>
                        Tambah Lapangan
                    </span>

                </a>



                <a
                    href="tambah_pemesanan.php"
                    class="quick orange-border"
                >

                    <div>
                        📅
                    </div>

                    <span>
                        Buat Pemesanan
                    </span>

                </a>


            </div>

        </div>



        <!-- INFORMASI SISTEM -->

        <div class="content-card info-card">

            <h3>
                Informasi Sistem
            </h3>


            <div class="info-row">

                <span>
                    Status Sistem
                </span>

                <strong class="online">
                    ● Online
                </strong>

            </div>


            <div class="info-row">

                <span>
                    Database
                </span>

                <strong>
                    db_futsal
                </strong>

            </div>


            <div class="info-row">

                <span>
                    Versi
                </span>

                <strong>
                    1.0
                </strong>

            </div>


        </div>


    </div>


</div>


</body>
</html>