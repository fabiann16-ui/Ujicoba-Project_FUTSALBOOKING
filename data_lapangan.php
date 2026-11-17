<?php
include 'koneksi.php';

$query = mysqli_query($koneksi, "SELECT * FROM lapangan");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Lapangan - Futsal Booking</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="main">

    <h1>Data Lapangan ⚽</h1>
    <p>Kelola data lapangan futsal.</p>

    <div style="margin: 25px 0;">

        <a href="tambah_lapangan.php" class="btn">
            ➕ Tambah Lapangan
        </a>

        <a href="index.php" class="btn" style="margin-left: 10px;">
            🏠 Dashboard
        </a>

    </div>

    <div class="table-container">

        <table>

            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Lapangan</th>
                    <th>Nama Lapangan</th>
                    <th>Jenis Lapangan</th>
                    <th>Harga / Jam</th>
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

                    <td>
                        <?= htmlspecialchars($data['id_lapangan']); ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($data['nama_lapangan']); ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($data['jenis_lapangan']); ?>
                    </td>

                    <td>
                        Rp <?= number_format($data['harga_perjam'], 0, ',', '.'); ?>
                    </td>

                    <td>
                        <a href="edit_lapangan.php?id=<?= urlencode($data['id_lapangan']); ?>">
                            ✏️ Edit
                        </a>

                        |

                        <a
                            href="hapus_lapangan.php?id=<?= urlencode($data['id_lapangan']); ?>"
                            onclick="return confirm('Yakin ingin menghapus lapangan ini?');"
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
                    <td colspan="6" style="text-align:center;">
                        Belum ada data lapangan.
                    </td>
                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>