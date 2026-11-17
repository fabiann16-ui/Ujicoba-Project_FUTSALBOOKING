<?php
include 'koneksi.php';

// Ambil ID lapangan dari URL
$id = $_GET['id'];

// Ambil data lapangan berdasarkan ID
$query = mysqli_query($koneksi, "SELECT * FROM lapangan WHERE id_lapangan = '$id'");
$data = mysqli_fetch_assoc($query);

// Jika data tidak ditemukan
if (!$data) {
    echo "<script>
        alert('Data lapangan tidak ditemukan!');
        window.location='lapangan.php';
    </script>";
    exit;
}


// Proses update data
if (isset($_POST['update'])) {

    $id_lapangan    = $_POST['id_lapangan'];
    $nama_lapangan  = $_POST['nama_lapangan'];
    $jenis_lapangan = $_POST['jenis_lapangan'];
    $harga_per_jam  = $_POST['harga_per_jam'];

    $update = mysqli_query($koneksi, "UPDATE lapangan SET
        nama_lapangan = '$nama_lapangan',
        jenis_lapangan = '$jenis_lapangan',
        harga_per_jam = '$harga_per_jam'
        WHERE id_lapangan = '$id_lapangan'
    ");

    if ($update) {

        echo "<script>
            alert('Data lapangan berhasil diperbarui!');
            window.location='lapangan.php';
        </script>";

    } else {

        echo "Gagal mengubah data: " . mysqli_error($koneksi);

    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Lapangan - Futsal Booking</title>

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

        .btn-update {
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

    <h1>Edit Lapangan ✏️</h1>

    <p>Ubah data lapangan yang dipilih.</p>


    <form method="POST">


        <div class="form-group">

            <label>ID Lapangan</label>

            <input
                type="text"
                name="id_lapangan"
                value="<?= htmlspecialchars($data['id_lapangan']); ?>"
                readonly
            >

        </div>


        <div class="form-group">

            <label>Nama Lapangan</label>

            <input
                type="text"
                name="nama_lapangan"
                value="<?= htmlspecialchars($data['nama_lapangan']); ?>"
                required
            >

        </div>


        <div class="form-group">

            <label>Jenis Lapangan</label>

            <select name="jenis_lapangan" required>

                <option value="Vinyl"
                    <?= $data['jenis_lapangan'] == 'Vinyl' ? 'selected' : ''; ?>>
                    Vinyl
                </option>

                <option value="Parquet"
                    <?= $data['jenis_lapangan'] == 'Parquet' ? 'selected' : ''; ?>>
                    Parquet
                </option>

                <option value="Rumput Sintetis"
                    <?= $data['jenis_lapangan'] == 'Rumput Sintetis' ? 'selected' : ''; ?>>
                    Rumput Sintetis
                </option>

            </select>

        </div>


        <div class="form-group">

            <label>Harga Per Jam</label>

            <input
                type="number"
                name="harga_per_jam"
                value="<?= htmlspecialchars($data['harga_per_jam']); ?>"
                min="0"
                required
            >

        </div>


        <div class="form-buttons">

            <button
                type="submit"
                name="update"
                class="btn-update"
            >
                💾 Simpan Perubahan
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