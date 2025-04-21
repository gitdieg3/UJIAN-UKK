<?php
include 'conn.php';
include 'function.php';

$nama_barang = "";
$katagori = "";
$jumlah = "";
$harga = "";
$tanggal = "";
$sukses = "";
$error = "";
$warning = "";

// Ambil semua kategori dari tabel_katagori
$katagori_list = mysqli_query($conn, "SELECT * FROM tabel_katagori ORDER BY katagori ASC");

if (isset($_POST['submit'])) {
    $nama_barang = ($_POST['nama_barang']);
    $katagori    = ($_POST['katagori']);
    $jumlah      = ($_POST['jumlah']);
    $harga       = ($_POST['harga']);
    $tanggal     = ($_POST['tanggal']);

    if ($nama_barang && $katagori && $jumlah && $harga && $tanggal) {
        $result = insertdata($nama_barang, $katagori, $jumlah, $harga, $tanggal, $conn);
        $sukses = $result;
    } else {
        $warning = "Semua kolom harus diisi.";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            overflow-x: hidden;
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="bg-primary text-white p-3 vh-100 position-fixed no-print" style="width: 220px;">
            <h4 class="mb-4">Aplikasi E-Data</h4>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link text-white d-flex align-items-center <?php echo basename($_SERVER['PHP_SELF']) == 'beranda.php' ? 'active fw-bold' : ''; ?>" href="beranda.php">
                        <i class="bi bi-house-door me-2"></i> Beranda
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white d-flex align-items-center <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active fw-bold' : ''; ?>" href="index.php">
                        <i class="bi bi-box-seam me-2"></i> Daftar Produk
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white d-flex align-items-center <?php echo basename($_SERVER['PHP_SELF']) == 'tambah.php' ? 'active fw-bold' : ''; ?>" href="tambah.php">
                        <i class="bi bi-plus-circle me-2"></i> Tambah Data
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white d-flex align-items-center <?php echo basename($_SERVER['PHP_SELF']) == 'katagori.php' ? 'active fw-bold' : ''; ?>" href="katagori.php">
                        <i class="bi bi-tags me-2"></i> Tambah Katagori
                    </a>
                </li>
            </ul>
        </div>

        <!-- Konten utama -->
        <div class="flex-grow-1" style="margin-left: 220px;">
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded p-4">

                    <!-- Notifikasi -->
                    <?php include 'layouts/notifikasi.php'; ?>

                    <!-- Form Input -->
                    <h3 class="text-primary">Tambah Barang</h3>
                    <div class="bg-light rounded p-4">
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="nama_barang" class="form-label">Nama Barang</label>
                                <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
                            </div>
                            <div class="mb-3">
                                <label for="katagori" class="form-label">Kategori Barang</label>
                                <select class="form-select" id="katagori" name="katagori" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php while ($row = mysqli_fetch_assoc($katagori_list)) : ?>
                                        <option value="<?php echo htmlspecialchars($row['katagori']); ?>">
                                            <?php echo htmlspecialchars($row['katagori']); ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="jumlah" class="form-label">Jumlah Stok</label>
                                <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                            </div>
                            <div class="mb-3">
                                <label for="harga" class="form-label">Harga Barang</label>
                                <input type="number" class="form-control" id="harga" name="harga" required>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>