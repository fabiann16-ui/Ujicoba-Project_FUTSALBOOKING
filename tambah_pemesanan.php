<?php
include 'koneksi.php';

if (isset($_POST['simpan'])) {

    $id_pemesanan  = $_POST['id_pemesanan'];
    $id_pelanggan  = $_POST['id_pelanggan'];
    $id_lapangan   = $_POST['id_lapangan'];
    $tanggal       = $_POST['tanggal'];
    $jam_mulai     = $_POST['jam_mulai'];
    $jam_selesai   = $_POST['jam_selesai'];
    $status        = $_POST['status'];

    // Ambil harga lapangan
    $cek_lapangan = mysqli_query($koneksi, "SELECT harga_per_jam 
        FROM lapangan 
        WHERE id_lapangan = '$id_lapangan'");

    $lapangan = mysqli_fetch_assoc($cek_lapangan);

    if (!$lapangan) {
        echo "<script>
            alert('Lapangan tidak ditemukan!');
            window.location='tambah_pemesanan.php';
        </script>";
        exit;
    }

    $harga_per_jam = $lapangan['harga_per_jam'];

    // Hitung lama sewa
    $mulai = strtotime($jam_mulai);
    $selesai = strtotime($jam_selesai);

    if ($selesai <= $mulai) {
        echo "<script>
            alert('Jam selesai harus lebih besar dari jam mulai!');
            window.location='tambah_pemesanan.php';
        </script>";
        exit;
    }

    $durasi = ($selesai - $mulai) / 3600;

    // Hitung total pembayaran
    $total_bayar = $durasi * $harga_per_jam;

    // Cek ID pemesanan
    $cek = mysqli_query($koneksi, "SELECT * FROM pemesanan 
        WHERE id_pemesanan = '$id_pemesanan'");

    if (mysqli_num_rows($cek) > 0) {

        echo "<script>
            alert('ID Pemesanan sudah digunakan! Silakan gunakan ID lain.');
            window.location='tambah_pemesanan.php';
        </script>";

    } else {

        $query = mysqli_query($koneksi, "INSERT INTO pemesanan
            (id_pemesanan, id_pelanggan, id_lapangan, tanggal, jam_mulai, jam_selesai, total_bayar, status)
            VALUES
            ('$id_pemesanan', '$id_pelanggan', '$id_lapangan', '$tanggal', '$jam_mulai', '$jam_selesai', '$total_bayar', '$status')");

        if ($query) {

            echo "<script>
                alert('Pemesanan berhasil ditambahkan!');
                window.location='pemesanan.php';
            </script>";

        } else {

            echo "Gagal menyimpan data: " . mysqli_error($koneksi);

        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Pemesanan - Futsal Booking</title>

    <link rel="stylesheet" href="style.css">

    <style>

        .form-container {
            max-width: 800px;
            margin: 40px auto;
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }

        .form-container h1 {
            margin-bottom: 10px;
        }

        .form-container p {
            margin-bottom: 30px;
            color: #666;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 14px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .form-buttons {
            margin-top: 30px;
        }

        .btn-simpan {
            background: #4969e8;
            color: white;
            border: none;
            padding: 14px 25px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-kembali {
            margin-left: 15px;
            color: #555;
            text-decoration: none;
        }

        .info-box {
            background: #eef4ff;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 25px;
            color: #3154b8;
        }

    </style>

</head>

<body>

<div class="form-container">

    <h1>Tambah Pemesanan 📅</h1>

    <p>Buat pemesanan lapangan futsal baru.</p>

    <div class="info-box">
        💡 Total pembayaran dihitung otomatis berdasarkan
        durasi sewa dan harga lapangan.
    </div>

    <form method="POST">

        <div class="form-group">

            <label>ID Pemesanan</label>

            <input
                type="text"
                name="id_pemesanan"
                placeholder="Contoh: PM001"
                required
            >

        </div>


        <div class="form-group">

            <label>Pelanggan</label>

            <select name="id_pelanggan" required>

                <option value="">
                    -- Pilih Pelanggan --
                </option>

                <?php

                $pelanggan = mysqli_query($koneksi,
                    "SELECT * FROM pelanggan ORDER BY nama_pelanggan ASC"
                );

                while ($data = mysqli_fetch_assoc($pelanggan)) {

                ?>

                    <option value="<?= htmlspecialchars($data['id_pelanggan']); ?>">

                        <?= htmlspecialchars($data['id_pelanggan']); ?>
                        -
                        <?= htmlspecialchars($data['nama_pelanggan']); ?>

                    </option>

                <?php } ?>

            </select>

        </div>


        <div class="form-group">

            <label>Lapangan</label>

            <select name="id_lapangan" required>

                <option value="">
                    -- Pilih Lapangan --
                </option>

                <?php

                $lapangan = mysqli_query($koneksi,
                    "SELECT * FROM lapangan ORDER BY nama_lapangan ASC"
                );

                while ($data = mysqli_fetch_assoc($lapangan)) {

                ?>

                    <option value="<?= htmlspecialchars($data['id_lapangan']); ?>">

                        <?= htmlspecialchars($data['id_lapangan']); ?>
                        -
                        <?= htmlspecialchars($data['nama_lapangan']); ?>
                        (Rp <?= number_format($data['harga_per_jam'], 0, ',', '.'); ?>/jam)

                    </option>

                <?php } ?>

            </select>

        </div>


        <div class="form-group">

            <label>Tanggal Pemesanan</label>

            <input
                type="date"
                name="tanggal"
                required
            >

        </div>


        <div class="form-group">

            <label>Jam Mulai</label>

            <input
                type="time"
                name="jam_mulai"
                required
            >

        </div>


        <div class="form-group">

            <label>Jam Selesai</label>

            <input
                type="time"
                name="jam_selesai"
                required
            >

        </div>


        <div class="form-group">

            <label>Status</label>

            <select name="status" required>

                <option value="">
                    -- Pilih Status --
                </option>

                <option value="Menunggu">
                    Menunggu
                </option>

                <option value="Dibayar">
                    Dibayar
                </option>

                <option value="Selesai">
                    Selesai
                </option>

                <option value="Dibatalkan">
                    Dibatalkan
                </option>

            </select>

        </div>


        <div class="form-buttons">

            <button
                type="submit"
                name="simpan"
                class="btn-simpan"
            >
                💾 Simpan Pemesanan
            </button>

            <a
                href="pemesanan.php"
                class="btn-kembali"
            >
                Kembali
            </a>

        </div>

    </form>

</div>

</body>

</html>