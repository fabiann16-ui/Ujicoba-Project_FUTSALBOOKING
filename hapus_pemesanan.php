<?php
include 'koneksi.php';

// Cek apakah ID dikirim
if (isset($_GET['id'])) {

    $id = $_GET['id'];

    // Hapus data pemesanan
    $query = mysqli_query($koneksi, "
        DELETE FROM pemesanan
        WHERE id_pemesanan = '$id'
    ");

    if ($query) {

        echo "<script>
            alert('Data pemesanan berhasil dihapus!');
            window.location='pemesanan.php';
        </script>";

    } else {

        echo "Gagal menghapus data: " . mysqli_error($koneksi);

    }

} else {

    header("Location: pemesanan.php");
    exit;

}
?>