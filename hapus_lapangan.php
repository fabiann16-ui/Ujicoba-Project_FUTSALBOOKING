<?php
include 'koneksi.php';

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $query = mysqli_query($koneksi, "DELETE FROM lapangan 
        WHERE id_lapangan = '$id'");

    if ($query) {

        echo "<script>
            alert('Data lapangan berhasil dihapus!');
            window.location='lapangan.php';
        </script>";

    } else {

        echo "Gagal menghapus data: " . mysqli_error($koneksi);

    }

} else {

    header("Location: lapangan.php");
    exit;

}
?>