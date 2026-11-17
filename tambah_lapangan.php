<?php
include 'koneksi.php';

if (isset($_POST['simpan'])) {

    $id_lapangan    = $_POST['id_lapangan'];
    $nama_lapangan  = $_POST['nama_lapangan'];
    $jenis_lapangan = $_POST['jenis_lapangan'];
    $harga_per_jam  = $_POST['harga_per_jam'];

    // Cek apakah ID sudah digunakan
    $cek = mysqli_query($koneksi, "SELECT * FROM lapangan 
        WHERE id_lapangan = '$id_lapangan'");

    if (mysqli_num_rows($cek) > 0) {

        echo "<script>
            alert('ID Lapangan sudah digunakan! Silakan gunakan ID lain.');
            window.location='tambah_lapangan.php';
        </script>";

    } else {

        $query = mysqli_query($koneksi, "INSERT INTO lapangan 
            (id_lapangan, nama_lapangan, jenis_lapangan, harga_per_jam)
            VALUES 
            ('$id_lapangan', '$nama_lapangan', '$jenis_lapangan', '$harga_per_jam')");

        if ($query) {
            echo "<script>
                alert('Data lapangan berhasil ditambahkan!');
                window.location='lapangan.php';
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

    <title>Tambah Lapangan - Futsal Booking</title>

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
    </style>
</head>

<body>

<div class="form-container">

    <h1>Tambah Lapangan ⚽</h1>

    <p>Masukkan data lapangan baru.</p>

    <form method="POST">

        <div class="form-group">
            <label>ID Lapangan</label>

            <input
                type="text"
                name="id_lapangan"
                placeholder="Contoh: LP001"
                required
            >
        </div>


        <div class="form-group">
            <label>Nama Lapangan</label>

            <input
                type="text"
                name="nama_lapangan"
                placeholder="Contoh: Lapangan A"
                required
            >
        </div>


        <div class="form-group">
            <label>Jenis Lapangan</label>

            <select name="jenis_lapangan" required>

                <option value="">
                    -- Pilih Jenis Lapangan --
                </option>

                <option value="Vinyl">
                    Vinyl
                </option>

                <option value="Parquet">
                    Parquet
                </option>

                <option value="Rumput Sintetis">
                    Rumput Sintetis
                </option>

            </select>

        </div>


        <div class="form-group">

            <label>Harga Per Jam</label>

            <input
                type="number"
                name="harga_per_jam"
                placeholder="Contoh: 100000"
                min="0"
                required
            >

        </div>


        <div class="form-buttons">

            <button
                type="submit"
                name="simpan"
                class="btn-simpan"
            >
                💾 Simpan Data
            </button>


            <a
                href="lapangan.php"
                class="btn-kembali"
            >
                Kembali
            </a>

        </div>

    </form>

</div>

</body>

</html>