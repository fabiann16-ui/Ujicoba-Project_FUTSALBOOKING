<?php
include 'koneksi.php';

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $query = mysqli_query($koneksi, "
        DELETE FROM pelanggan
        WHERE id_pelanggan = '$id'
    ");

    if ($query) {

        echo "<script>
            alert('Data pelanggan berhasil dihapus!');
            window.location='pelanggan.php';
        </script>";

    } else {

        echo "Gagal menghapus data: " . mysqli_error($koneksi);
    }

} else {

    header("Location: pelanggan.php");
    exit;
}
?>