<?php
include 'koneksi.php';

if (!isset($_GET['id'])) {
    header("Location: pelanggan.php");
    exit;
}

$id = $_GET['id'];

// Ambil data pelanggan
$query = mysqli_query($koneksi, "
    SELECT * FROM pelanggan
    WHERE id_pelanggan = '$id'
");

$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "<script>
        alert('Data pelanggan tidak ditemukan!');
        window.location='pelanggan.php';
    </script>";
    exit;
}

// Proses update
if (isset($_POST['update'])) {

    $nama   = $_POST['nama_pelanggan'];
    $telp   = $_POST['no_telp'];
    $alamat = $_POST['alamat'];

    $update = mysqli_query($koneksi, "
        UPDATE pelanggan SET
            nama_pelanggan = '$nama',
            no_telp = '$telp',
            alamat = '$alamat'
        WHERE id_pelanggan = '$id'
    ");

    if ($update) {
        echo "<script>
            alert('Data pelanggan berhasil diubah!');
            window.location='pelanggan.php';
        </script>";
        exit;
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
    <title>Edit Pelanggan</title>

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
            width: calc(100% - 250px);
            padding: 30px;
            min-height: 100vh;
        }

        .form-container {
            width: 100%;
            max-width: 700px;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }

        .form-container h2 {
            margin-top: 0;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
        }

        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }

        .form-group input[readonly] {
            background: #eee;
            cursor: not-allowed;
        }

        .button-area {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 25px;
        }

        .btn-update,
        .btn-kembali {
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            font-size: 15px;
        }

        .btn-update {
            background: #2563eb;
            color: white;
        }

        .btn-kembali {
            background: #ddd;
            color: #333;
        }

        @media (max-width: 900px) {
            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 20px;
            }
        }
    </style>
</head>

<body>

<div class="main-content">

    <div class="form-container">

        <h2>✏️ Edit Data Pelanggan</h2>

        <form method="POST">

            <div class="form-group">
                <label>ID Pelanggan</label>
                <input
                    type="text"
                    value="<?= htmlspecialchars($data['id_pelanggan']); ?>"
                    readonly
                >
            </div>

            <div class="form-group">
                <label>Nama Pelanggan</label>
                <input
                    type="text"
                    name="nama_pelanggan"
                    value="<?= htmlspecialchars($data['nama_pelanggan']); ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label>No. Telepon</label>
                <input
                    type="text"
                    name="no_telp"
                    value="<?= htmlspecialchars($data['no_telp']); ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label>Alamat</label>
                <textarea
                    name="alamat"
                    required
                ><?= htmlspecialchars($data['alamat']); ?></textarea>
            </div>

            <div class="button-area">

                <button
                    type="submit"
                    name="update"
                    class="btn-update"
                >
                    💾 Update
                </button>

                <a
                    href="pelanggan.php"
                    class="btn-kembali"
                >
                    ← Kembali
                </a>

            </div>

        </form>

    </div>

</div>

</body>
</html>