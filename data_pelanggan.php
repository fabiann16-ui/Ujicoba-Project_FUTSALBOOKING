<?php
require_once 'koneksi.php';

$query = mysqli_query($koneksi, "SELECT * FROM pelanggan");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pelanggan - Futsal Booking</title>

    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            background: #f4f6fa;
            color: #1f2937;
        }

        .container {
            padding: 35px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .header h1 {
            margin: 0;
            font-size: 30px;
        }

        .header p {
            color: #6b7280;
            margin-top: 8px;
        }

        .btn {
            display: inline-block;
            padding: 12px 20px;
            background: #4169e1;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: bold;
        }

        .btn:hover {
            background: #3154c7;
        }

        .card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.06);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #4169e1;
            color: white;
            padding: 14px;
            text-align: left;
        }

        td {
            padding: 14px;
            border-bottom: 1px solid #e5e7eb;
        }

        tr:hover {
            background: #f8fafc;
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

        .kosong {
            text-align: center;
            padding: 30px;
            color: #6b7280;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <div>
            <h1>Data Pelanggan 👤</h1>
            <p>Kelola data pelanggan futsal</p>
        </div>

        <a href="tambah_pelanggan.php" class="btn">
            + Tambah Pelanggan
        </a>
    </div>

    <div class="card">

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Pelanggan</th>
                    <th>Nama Pelanggan</th>
                    <th>No. Telepon</th>
                    <th>Alamat</th>
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
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($data['id_pelanggan']); ?></td>
                    <td><?= htmlspecialchars($data['nama_pelanggan']); ?></td>
                    <td><?= htmlspecialchars($data['no_telp']); ?></td>
                    <td><?= htmlspecialchars($data['alamat']); ?></td>

                    <td>
                        <a class="edit"
                           href="edit_pelanggan.php?id=<?= $data['id_pelanggan']; ?>">
                           Edit
                        </a>

                        <a class="hapus"
                           href="hapus_pelanggan.php?id=<?= $data['id_pelanggan']; ?>"
                           onclick="return confirm('Yakin ingin menghapus pelanggan ini?');">
                           Hapus
                        </a>
                    </td>
                </tr>

            <?php
                }
            } else {
            ?>

                <tr>
                    <td colspan="6" class="kosong">
                        Belum ada data pelanggan.
                    </td>
                </tr>

            <?php } ?>

            </tbody>
        </table>

    </div>

</div>

</body>
</html>