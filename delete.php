<?php
include 'conn.php';
include 'function.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = delete_barang($conn, $id);

    // Cek hasil dan redirect dengan pesan sukses atau error
    if (strpos($result, 'berhasil') !== false) {
        header("Location: index.php?sukses=" . urlencode($result));
    } else {
        header("Location: index.php?error=" . urlencode($result));
    }
} else {
    header("Location: index.php?error=" . urlencode("ID produk tidak ditemukan."));
}
exit;
?>
