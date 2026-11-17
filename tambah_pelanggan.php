<?php
require_once 'koneksi.php';

if (isset($_POST['simpan'])) {

    $id = $_POST['id_pelanggan'];
    $nama = $_POST['nama_pelanggan'];
    $telp = $_POST['no_telp'];
    $alamat = $_POST['alamat'];

    $query = mysqli_query($koneksi, "INSERT INTO pelanggan
        (id_pelanggan, nama_pelanggan, no_telp, alamat)
        VALUES
        ('$id', '$nama', '$telp', '$alamat')
    ");

    if ($query) {
        header("Location: pelanggan.php");
        exit;
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Pelanggan</title>

    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            background: #f4f6fa;
        }

        .container {
            max-width: 700px;
            margin: 50px auto;
            padding: 20px;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 18px;
            box-shadow: 0 5px 20px rgba(0,0,0,.08);
        }

        h1 {
            margin-top: 0;
        }

        label {
            display: block;
            margin-top: 18px;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input, textarea {
            width: 100%;
            padding: 13px;
            border: 1px solid #d1d5db;
            border-radius: 9px;
            font-size: 15px;
        }

        textarea {
            height: 100px;
            resize: vertical;
        }

        button {
            margin-top: 25px;
            padding: 13px 22px;
            border: none;
            border-radius: 9px;
            background: #4169e1;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        .kembali {
            display: inline-block;
            margin-left: 10px;
            color: #6b7280;
            text-decoration: none;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="card">

        <h1>Tambah Pelanggan 👤</h1>
        <p>Masukkan data pelanggan baru.</p>

        <form method="POST">

            <label>ID Pelanggan</label>
            <input type="text"
                   name="id_pelanggan"
                   maxlength="5"
                   placeholder="Contoh: PL001"
                   required>

            <label>Nama Pelanggan</label>
            <input type="text"
                   name="nama_pelanggan"
                   placeholder="Masukkan nama pelanggan"
                   required>

            <label>No. Telepon</label>
            <input type="text"
                   name="no_telp"
                   placeholder="08xxxxxxxxxx"
                   required>

            <label>Alamat</label>
            <textarea name="alamat"
                      placeholder="Masukkan alamat pelanggan"
                      required></textarea>

            <button type="submit" name="simpan">
                💾 Simpan Data
            </button>

            <a href="data_pelanggan.php" class="kembali">
                Kembali
            </a>

        </form>

    </div>

</div>

</body>
</html>