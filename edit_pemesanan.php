<?php
include 'koneksi.php';

// Cek ID
if (!isset($_GET['id'])) {
    header("Location: pemesanan.php");
    exit;
}

$id = $_GET['id'];

// Ambil data pemesanan
$query = mysqli_query($koneksi, "
    SELECT * FROM pemesanan
    WHERE id_pemesanan = '$id'
");

$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "<script>
        alert('Data pemesanan tidak ditemukan!');
        window.location='pemesanan.php';
    </script>";
    exit;
}


// =========================
// PROSES UPDATE
// =========================
if (isset($_POST['update'])) {

    $id_pelanggan = $_POST['id_pelanggan'];
    $id_lapangan  = $_POST['id_lapangan'];
    $tanggal      = $_POST['tanggal'];
    $jam_mulai    = $_POST['jam_mulai'];
    $jam_selesai  = $_POST['jam_selesai'];
    $status       = $_POST['status'];


    // Ambil harga lapangan
    $cek_lapangan = mysqli_query($koneksi, "
        SELECT harga_per_jam
        FROM lapangan
        WHERE id_lapangan = '$id_lapangan'
    ");

    $lapangan_data = mysqli_fetch_assoc($cek_lapangan);


    if (!$lapangan_data) {

        echo "<script>
            alert('Lapangan tidak ditemukan!');
            window.location='edit_pemesanan.php?id=$id';
        </script>";

        exit;
    }


    $harga_per_jam = $lapangan_data['harga_per_jam'];


    // Hitung waktu
    $mulai   = strtotime($jam_mulai);
    $selesai = strtotime($jam_selesai);


    if ($selesai <= $mulai) {

        echo "<script>
            alert('Jam selesai harus lebih besar dari jam mulai!');
            window.location='edit_pemesanan.php?id=$id';
        </script>";

        exit;
    }


    // Hitung durasi
    $durasi = ($selesai - $mulai) / 3600;


    // Hitung total
    $total_bayar = $durasi * $harga_per_jam;


    // Update database
    $update = mysqli_query($koneksi, "
        UPDATE pemesanan SET
            id_pelanggan = '$id_pelanggan',
            id_lapangan = '$id_lapangan',
            tanggal = '$tanggal',
            jam_mulai = '$jam_mulai',
            jam_selesai = '$jam_selesai',
            total_bayar = '$total_bayar',
            status = '$status'
        WHERE id_pemesanan = '$id'
    ");


    if ($update) {

        echo "<script>
            alert('Data pemesanan berhasil diubah!');
            window.location='pemesanan.php';
        </script>";

        exit;

    } else {

        echo "Gagal mengubah data: " . mysqli_error($koneksi);

    }
}


// =========================
// DATA PELANGGAN
// =========================
$pelanggan = mysqli_query($koneksi, "
    SELECT *
    FROM pelanggan
    ORDER BY nama_pelanggan ASC
");


// =========================
// DATA LAPANGAN
// =========================
$lapangan = mysqli_query($koneksi, "
    SELECT *
    FROM lapangan
    ORDER BY nama_lapangan ASC
");

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Edit Pemesanan - Futsal Booking</title>

    <link rel="stylesheet" href="style.css">


    <style>

        /* =========================
           RESET
        ========================= */

        * {
            box-sizing: border-box;
        }


        body {
            margin: 0;
            overflow-x: hidden;
        }


        /* =========================
           AREA UTAMA
        ========================= */

        .main-content {
            margin-left: 250px;
            padding: 30px;
            width: calc(100% - 250px);
            min-height: 100vh;
        }


        /* =========================
           JUDUL
        ========================= */

        .page-title {
            margin-bottom: 25px;
        }


        .page-title h1 {
            margin: 0 0 8px 0;
        }


        .page-title p {
            margin: 0;
            color: #64748b;
        }


        /* =========================
           FORM
        ========================= */

        .form-container {
            width: 100%;
            max-width: 750px;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }


        .form-group {
            width: 100%;
            margin-bottom: 20px;
        }


        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #334155;
        }


        .form-group input,
        .form-group select {

            display: block;

            width: 100%;

            max-width: 100%;

            padding: 12px 14px;

            border: 1px solid #d1d5db;

            border-radius: 8px;

            font-size: 14px;

            background: white;
        }


        .form-group input:focus,
        .form-group select:focus {

            outline: none;

            border-color: #2563eb;

            box-shadow: 0 0 0 2px rgba(37,99,235,0.10);
        }


        /* =========================
           ID PEMESANAN
        ========================= */

        .info-id {

            width: 100%;

            background: #f1f5f9;

            padding: 14px;

            border-radius: 8px;

            margin-bottom: 25px;

            color: #334155;
        }


        /* =========================
           TOMBOL
        ========================= */

        .button-area {

            display: flex;

            gap: 10px;

            flex-wrap: wrap;

            margin-top: 10px;
        }


        .btn-simpan {

            background: #2563eb;

            color: white;

            border: none;

            padding: 12px 20px;

            border-radius: 8px;

            cursor: pointer;

            font-weight: bold;

            font-size: 14px;
        }


        .btn-simpan:hover {
            background: #1d4ed8;
        }


        .btn-kembali {

            display: inline-block;

            background: #64748b;

            color: white;

            padding: 12px 20px;

            border-radius: 8px;

            text-decoration: none;

            font-weight: bold;

            font-size: 14px;
        }


        .btn-kembali:hover {
            background: #475569;
        }


        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 900px) {

            .main-content {

                margin-left: 0;

                width: 100%;

                padding: 20px;
            }

            .form-container {

                max-width: 100%;

                padding: 25px;
            }
        }


        @media (max-width: 600px) {

            .main-content {

                padding: 15px;
            }


            .form-container {

                padding: 20px;

                border-radius: 10px;
            }


            .button-area {

                flex-direction: column;
            }


            .btn-simpan,
            .btn-kembali {

                width: 100%;

                text-align: center;
            }

        }

    </style>

</head>


<body>


<!-- =========================
     SIDEBAR
========================= -->

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



<!-- =========================
     KONTEN
========================= -->

<div class="main-content">


    <div class="page-title">

        <h1>Edit Pemesanan</h1>

        <p>
            Ubah data pemesanan lapangan futsal
        </p>

    </div>



    <!-- FORM -->

    <div class="form-container">


        <!-- ID -->

        <div class="info-id">

            <strong>ID Pemesanan:</strong>

            <?= htmlspecialchars($data['id_pemesanan']); ?>

        </div>



        <form method="POST">


            <!-- PELANGGAN -->

            <div class="form-group">

                <label>
                    Pelanggan
                </label>


                <select name="id_pelanggan" required>

                    <option value="">
                        -- Pilih Pelanggan --
                    </option>


                    <?php while ($p = mysqli_fetch_assoc($pelanggan)) { ?>

                        <option
                            value="<?= htmlspecialchars($p['id_pelanggan']); ?>"
                            <?= ($p['id_pelanggan'] == $data['id_pelanggan']) ? 'selected' : ''; ?>
                        >

                            <?= htmlspecialchars($p['id_pelanggan']); ?>

                            -

                            <?= htmlspecialchars($p['nama_pelanggan']); ?>

                        </option>

                    <?php } ?>

                </select>

            </div>



            <!-- LAPANGAN -->

            <div class="form-group">

                <label>
                    Lapangan
                </label>


                <select name="id_lapangan" required>

                    <option value="">
                        -- Pilih Lapangan --
                    </option>


                    <?php while ($l = mysqli_fetch_assoc($lapangan)) { ?>

                        <option
                            value="<?= htmlspecialchars($l['id_lapangan']); ?>"
                            <?= ($l['id_lapangan'] == $data['id_lapangan']) ? 'selected' : ''; ?>
                        >

                            <?= htmlspecialchars($l['id_lapangan']); ?>

                            -

                            <?= htmlspecialchars($l['nama_lapangan']); ?>

                            (Rp

                            <?= number_format(
                                $l['harga_per_jam'],
                                0,
                                ',',
                                '.'
                            ); ?>

                            /jam)

                        </option>

                    <?php } ?>

                </select>

            </div>



            <!-- TANGGAL -->

            <div class="form-group">

                <label>
                    Tanggal
                </label>


                <input
                    type="date"
                    name="tanggal"
                    value="<?= htmlspecialchars($data['tanggal']); ?>"
                    required
                >

            </div>



            <!-- JAM MULAI -->

            <div class="form-group">

                <label>
                    Jam Mulai
                </label>


                <input
                    type="time"
                    name="jam_mulai"
                    value="<?= htmlspecialchars($data['jam_mulai']); ?>"
                    required
                >

            </div>



            <!-- JAM SELESAI -->

            <div class="form-group">

                <label>
                    Jam Selesai
                </label>


                <input
                    type="time"
                    name="jam_selesai"
                    value="<?= htmlspecialchars($data['jam_selesai']); ?>"
                    required
                >

            </div>



            <!-- STATUS -->

            <div class="form-group">

                <label>
                    Status
                </label>


                <select name="status" required>

                    <option
                        value="Menunggu"
                        <?= ($data['status'] == 'Menunggu') ? 'selected' : ''; ?>
                    >
                        Menunggu
                    </option>


                    <option
                        value="Dibayar"
                        <?= ($data['status'] == 'Dibayar') ? 'selected' : ''; ?>
                    >
                        Dibayar
                    </option>


                    <option
                        value="Selesai"
                        <?= ($data['status'] == 'Selesai') ? 'selected' : ''; ?>
                    >
                        Selesai
                    </option>


                    <option
                        value="Dibatalkan"
                        <?= ($data['status'] == 'Dibatalkan') ? 'selected' : ''; ?>
                    >
                        Dibatalkan
                    </option>

                </select>

            </div>



            <!-- TOMBOL -->

            <div class="button-area">

                <button
                    type="submit"
                    name="update"
                    class="btn-simpan"
                >
                    💾 Simpan Perubahan
                </button>


                <a
                    href="pemesanan.php"
                    class="btn-kembali"
                >
                    ↩ Kembali
                </a>

            </div>


        </form>


    </div>


</div>


</body>
</html>